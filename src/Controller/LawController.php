<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\AssembleeApiManager;
use App\Model\LawManager;

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

    public function voter()
    {
        $tuple = [];
        $accessApi = new AssembleeApiManager();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = $_POST['url'];
            $accessDataBase = new LawManager();
            $tuple = $accessDataBase->findByUrl($url);
        }
        if ($tuple != []) {
            $law = $tuple;
        } elseif ($url != "") {
            $law = $accessApi->getOne($url);
        } else {
            $law = $accessApi->getHazard();
        }
        return $this->twig->render('Law/voter.html.twig', ['law' => $law]);
    }
}
