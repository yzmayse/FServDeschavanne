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
             if (password_verify($password,$code)){
                 $repons = "acces autorisé";
             }else {
                $repons = "MDP = PAS VALIDE";
             }
             
             }
        return $this->render('deschavanne/pages/loginconfirm.html.twig', [
            'Message' => $repons,
            'login' => $Login,
        ]);
    }

     /**
     * @Route("/deschavanne/pages/formuser", name="formuser")
     */
    public function formuser(Request $request,EntityManagerInterface $manager): Response
    {
     

        return $this->render('deschavanne/pages/formuser.html.twig', [
            'controller_name' => 'DeschavanneController',
        ]);
    }

     /**
     * @Route("/deschavanne/pages/adduser", name="adduser")
     */
    public function adduser(Request $request,EntityManagerInterface $manager): Response
    {
        $Login = $request -> request -> get("Login");
        $password = $request -> request -> get("Password");
        $password = (password_hash($password, PASSWORD_DEFAULT));
        $monUtilisateur = new Utilisateurs();
        $monUtilisateur -> setLogin($Login);
        $monUtilisateur -> setPassword($password);
        $manager -> persist($monUtilisateur);
        $manager -> flush ();

        return $this->redirectToRoute ('formuser');
    }

     /**
     * @Route("/deschavanne/pages/afficheuser", name="afficheuser")
     */
    public function afficheuser(Request $request,EntityManagerInterface $manager): Response
    {
        $mesUtilisateurs=$manager->getRepository(Utilisateurs::class)->findAll();
        return $this->render('/deschavanne/pages/afficheuser.html.twig',['lst_utilisateurs' => $mesUtilisateurs]);
        
    }

    /**
     * @Route("/serveur/session", name="serveur/session")
     */
    public function session(SessionInterface $session): Response
    {
        $vs = $session -> get('nomVar');
        $val=44;
        $session -> set('nomVar',$val);
        return $this->render ('serveur/session.html.twig');
    }
}


