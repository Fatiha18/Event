<?php

namespace App\Controller;

use App\Entity\Events;
use App\Form\CreateEventFormType;
use App\Repository\EventsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyEventsController extends AbstractController
{
   private $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }
    


      /**
     * Liste des evenements
     * @Route("/", name="home")
     */
    public function index(EventsRepository $repository)
    {
        return $this->render('home/index.html.twig', [
            'events_list' => $repository->findAll(),
        ]);
    }

    /**
     * page mes evenements
     * @Route("/my_events", name="my_events")
     */
     public function my_events( EventsRepository $eventRepository)
    {   
        
        $user = $this->getUser
        
        $event = $eventRepository->findBy(['user' => $this->getUser()]);
          
       return $this->render('account/my_events.html.twig',[
        'events_list' => $event,
            'user'=> $user
        
       ]);
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




    /**
     * page d'un évenement
     * @Route("/event/{id}", name="event_page")
     */
    public function EventPage(Events $events)
    {

        return $this->render('home/event_page.html.twig', [
            'events' => $events

        ]);
    }


    
     /**
     * @Route("/new_event", name="new_event")
     */
    public function newEvent (Request $request, UserRepository $repository): Response
    {
       
        
        $form = $this->createForm(CreateEventFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données de formulaire (entité Events)
            $event = $form->getData();
            $event->setAuteur($this->getUser());

            $this->manager->persist($event);
            $this->manager->flush();

            $this->addFlash('success', 'Vous avez bien créé votre evenement.');
            return $this->redirectToRoute('my_events');
        }

    

        return $this->render('account/new_event.html.twig', [
            'CreateEventForm' => $form->createView(),
        ]);
    }
}
    

















