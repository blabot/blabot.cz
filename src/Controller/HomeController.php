<?php

namespace App\Controller;

use App\Gateway\DictionaryGateway;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Blabot\Generator\GenerateBlabolsRequest;
use Blabot\Generator\GenerateBlabolsUseCase;
use Blabot\Context as BlabotContext;

/**
 * Class HomeController
 *
 * @package App\Controller
 */
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
     * @Route("/{_locale}/{dictionary}", name="home")
     */
    public function index($_locale = 'cs', $dictionary = null)
    {
        $request = new GenerateBlabolsRequest();
        if (empty($dictionary))
            $request->dictionaryName = $_locale.'.json';
        else
            $request->dictionaryName = $_locale.'-'.$dictionary.'.json';
        $request->sentencesCount = 33;

        $useCase = new GenerateBlabolsUseCase();
        $generatorOutput = $useCase->execute($request);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'blabols' => $generatorOutput->blabols,
            'locale' => $_locale
        ]);
    }
}
