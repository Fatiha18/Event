<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{


    /**
     * page d'accueil
     * @Route("/", name="home")
     */
     public function home()
    {

       // afficher le template twig home.html.twig
       return $this->render('home/index.html.twig');
    }



}