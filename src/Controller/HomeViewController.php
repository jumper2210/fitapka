<?php


namespace App\Controller;
use Symfony\Component\Asset\Package;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomeViewController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Method({"GET"})
     */
    public function index(){

        return $this->render('Home/index.html.twig', []);
}



}