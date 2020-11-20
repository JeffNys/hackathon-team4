<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\LawManager;
use App\Controller\LawController;

class VotedLawController extends AbstractController
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
        $accessDataBase = new LawManager();
        $laws = $accessDataBase->selectAll();
        return $this->twig->render('VotedLaw/index.html.twig', ['laws' => $laws]);
    }

    public function status(string $id)
    {
        if ($id == "") {
            return $this->index();
        }
        $lawAccess = new LawController;
        return $lawAccess->status($id);
    }
}
