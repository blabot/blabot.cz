<?php

namespace App\Controller;

use App\Gateway\DictionaryGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Blabot\Generator\GenerateBlabolsRequest;
use Blabot\Generator\GenerateBlabolsUseCase;
use Blabot\Context as BlabotContext;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        mb_internal_encoding("UTF-8");
        BlabotContext::$dictionaryGateway =  new DictionaryGateway();
        $request = new GenerateBlabolsRequest();
        $request->dictionaryName = 'cs-capek.json';
        $useCase = new GenerateBlabolsUseCase();
        $generatorOutput = $useCase->execute($request);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'blabols' => $generatorOutput->blabols,
        ]);
    }
}
