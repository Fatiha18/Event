<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MyEventsController extends AbstractController
{


    /**
     * page mes evenements
     * @Route("/my_events", name="my_events")
     */
     public function events()
    {

       // afficher le template twig home.html.twig
       return $this->render('account/my_events.html.twig');
    }



    /**
     * page mes participation
     * @Route("/participate", name="participate")
     */
    public function  participation()
    {

       // afficher le template twig 
       return $this->render('account/participate.html.twig');
    }



}