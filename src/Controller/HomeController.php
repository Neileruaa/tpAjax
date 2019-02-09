<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * @Route("/", name="Home.index", methods={"GET"})
     */
    public function index(){
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/getToken", name="Home.getToken", methods={"GET"})
     */
    public function getToken(){
        $date = date('d/m/Y');
        $token = sha1($date);
        return $this->json(["token" =>$token]);
    }
    /**
     * @Route("/login", name="Home.login", methods={"POST"})
     */
    public function login(){

    }
    /**
     * @Route("/register", name="Home.register", methods={"POST"})
     */
    public function register(){

    }
}
