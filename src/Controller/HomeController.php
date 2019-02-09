<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
	    $token = $this->calcToken();
	    return $this->json(["token" =>$token]);
    }
    /**
     * @Route("/login", name="Home.login", methods={"POST"})
     */
    public function login(Request $request,UserRepository $userRepository){
	    if ($request->request->get('token')["token"] == $this->calcToken()){
			$user = $userRepository->findBy(['username'=>$request->request->get('username'),
				'password'=>$request->request->get('password')]);
			if (!$user){
				return $this->json(["Response"=>"Nexiste pas dans la bdd"], 419);
			}else{
				return $this->json(["Response"=>"Utilisateur peut se connecter"], 200);
			}
	    }
	    else{
		    return $this->json(["Response"=>"Error Token"], 419);
	    }
    }
    /**
     * @Route("/register", name="Home.register", methods={"POST"})
     */
    public function register(Request $request, ObjectManager $manager){

		if ($request->request->get('token')["token"] == $this->calcToken()){
			$user = new User();
			$user->setUsername($request->request->get('username'))
				->setPassword($request->request->get('password'));

			$manager->persist($user);
			$manager->flush();
			return $this->json(["Response"=>"Bien recu"], 200);
		}
		else{
			return $this->json(["Response"=>"Error Token"], 419);
		}
    }

	/**
	 * @return string
	 */
	public function calcToken(): string {
		$date = date('d/m/Y');
		$token = sha1($date);
		return $token;
	}
}
