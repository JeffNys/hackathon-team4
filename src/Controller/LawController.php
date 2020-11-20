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

    public function voter(string $url = "")
    {
        $accessApi = new AssembleeApiManager();
        if ($url != "") {
            $law = $accessApi->getOne($url);
        } else {
            $law = $accessApi->getHazard();
        }
        return $this->twig->render('Law/voter.html.twig', ['law' => $law]);
    }

    public function status(int $law)
    {
        $accessDataBase = new LawManager();
        $votes = $accessDataBase->statusOf($law);
        return $this->twig->render('Law/status.html.twig', ['votes' => $votes]);
    }

    public function createVote()
    {
        // two cases: you are the first to vote, or you vote
        // if you are the first, that import the law from API to Database
        $tuple = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $url = $_POST['url'];
            $accessDataBase = new LawManager();
            $tuple = $accessDataBase->findByUrl($url);
            // hey, bad new, case 1, you have to import the law in database
            if ($tuple == []) {
                $accessApi = new AssembleeApiManager();
                $dataApi = $accessApi->getOne($url);
                $dataForTable['url_loi'] = $dataApi['url'];
                $dataForTable['date_depot'] = $dataApi['dateDepot'];
                $dataForTable['date_vote'] = $dataApi['dateVote'];
                $dataForTable['titre_principal'] = $dataApi['titrePrincipal'];
                $accessDataBase->create($dataForTable);
            }
            $row = $accessDataBase->findByUrl($url);
            // now we have to create the pseudo and ballot
            
        }
        return $this->status($row['id']);
    }
}
