<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userManager = new UserManager();
            $user =
                [
                    'email' => $_POST['email'],
                    'nom' => $_POST['nom'],
                    'prenom' => $_POST ['prenom'],
                    'password' => $_POST['password'],
                    'adress' => $_POST['adress']
                ];
            $id = $userManager->addUser($user);
            header('Location:/User/showUser/' . $id);
        } else {
            return $this->twig->render('User/addUser.html.twig');
        }
    }

    public function showUser(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/indexUser.html.twig', ['user' => $user]);
    }

    public function showEditUser(int $id)
    {
        $userManager = new userManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/editUser.html.twig', ['user' => $user]);
    }

    public function editUser(int $id)
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user['email'] = $_POST['email'];
            $user['firstname'] = $_POST['firstname'];
            $user['lastname'] = $_POST['lastname'];
            $user['adress'] = $_POST['adress'];

            $userManager->updateUser($user);
            header('Location:/User/showUser/' . $id);
        } else {
            return $this->twig->render('User/editUser.html.twig', ['user' => $user]);
        }
    }

    public function deleteUser(int $id)
    {
        $userManager = new userManager();
        $userManager->delete($id);
        header('Location:/');
    }
}
