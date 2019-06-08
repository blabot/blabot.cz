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
     * HomeController constructor.
     */
    public function __construct()
    {
        BlabotContext::$dictionaryGateway =  new DictionaryGateway();
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $request = new GenerateBlabolsRequest();
        $request->dictionaryName = 'cs.json';
        $request->sentencesCount = 10;

        $useCase = new GenerateBlabolsUseCase();
        $generatorOutput = $useCase->execute($request);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'blabols' => $generatorOutput->blabols,
        ]);
    }
}
