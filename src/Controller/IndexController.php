<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/index', name: 'app_index')]
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    #[Route('/login', name: 'login' , methods:["GET", "POST"])]
    public function login(Request $request): Response
    {
        $login = $request->request->get('login');
        $pass = $request->request->get('pass');
        $isAuthenticated =$this->authenticate($login, $pass);

        if($isAuthenticated){
            return $this->render('index/index.html.twig', []);
        }
        else {
            return $this->render('index/index.html.twig', []);
        }
    }

    private function authenticate(string $login, string $pass): bool
    {
        if (($login === "admin") && ($pass === "admin")){
            return true;
        }
        else {
            return false;
        }
    }

}
