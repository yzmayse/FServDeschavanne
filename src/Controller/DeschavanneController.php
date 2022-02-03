<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateurs;

class DeschavanneController extends AbstractController
{
    /**
     * @Route("/deschavanne", name="deschavanne")
     */
    public function index(): Response
    {
        return $this->render('deschavanne/index.html.twig', [
            'controller_name' => 'DeschavanneController',
        ]);
    }
    /**
     * @Route("/deschavanne/pages/loginconfirm", name="loginconfirm")
     */
    public function loginconfirm(Request $request,EntityManagerInterface $manager): Response
    {   
        $Login = $request -> request -> get("Login");
        $password = $request -> request -> get("Password");
        if (($Login=="root") && ($password=="toor")){
            $reponse = "acces autorise";
             } 
             else{
                 $reponse = "erreur";
             }
        return $this->render('deschavanne/pages/loginconfirm.html.twig', [
            'Message' => $reponse,
        ]);
    }
}
