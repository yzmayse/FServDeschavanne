<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function loginconfirm(): Response
    {
        return $this->render('deschavanne/pages/loginconfirm.html.twig', [
            'controller_name' => 'DeschavanneController',
        ]);
    }
}
