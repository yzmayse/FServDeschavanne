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
        $reponse = $manager -> getRepository(utilisateurs :: class) -> findOneBy([ 'Login' => $Login]);
        if ($reponse == NULL){
            $repons ="utilisateurs inconnu";
             } 
        else{
             $code = $reponse -> getPassword();
             if ($code == $password){
                 $repons = "acces autorisé";
             }else {
                $repons = "MDP = PAS VALIDE";
             }
             
             }
        return $this->render('deschavanne/pages/loginconfirm.html.twig', [
            'Message' => $repons,
        ]);
    }
}
