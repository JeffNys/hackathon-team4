<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AssembleeApiManager;

class LawController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        $accessApi = new AssembleeApiManager();
        $laws = $accessApi->getAll();
        return $this->twig->render('Law/index.html.twig', ['laws' => $laws]);
    }

    public function voter(string $url = "")
    {
        $accessApi = new AssembleeApiManager();
        if ($url != "") {
            $law = $accessApi->getOne($url);
        }
        else
        {
            $law = $accessApi->getHazard($url);
        }
        return $this->twig->render('Law/voter.html.twig', ['law' => $law]);       
    }
}
