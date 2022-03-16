<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateurs;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
    public function loginconfirm(Request $request,EntityManagerInterface $manager,SessionInterface $session): Response
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
                 $session->set('nomVar', $reponse->getId());
                 return $this->redirectToRoute ('deschavanne/pages/session');
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
    public function formuser(): Response
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
        $Password = $request -> request -> get("Password");
        $Password = (password_hash($Password, PASSWORD_DEFAULT));
        $monUtilisateur = new Utilisateurs();
        $monUtilisateur -> setLogin($Login);
        $monUtilisateur -> setPassword($Password);
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
     * @Route("/deschavanne/pages/session", name="deschavanne/pages/session")
     */
    public function session(SessionInterface $session,EntityManagerInterface $manager): Response
    {
        $vs = $session -> get('login');
        $user=$manager->getRepository(utilisateurs::class)->findOneById($vs);
        return $this->redirectToRoute ('deschavanne');
    }

     /**
     * @Route("/deschavanne/pages/deconnection", name="deschavanne/pages/deconnection")
     */
    public function deconnection(SessionInterface $session): Response
    {
        $session->clear();
        return $this->render('/deschavanne', [
            'controller_name' => 'DeschavanneController',
        ]);
        
    }



}




