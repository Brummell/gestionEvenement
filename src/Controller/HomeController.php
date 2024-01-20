<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $event = $entityManager->getRepository(Event::class)->findAll();
        if(!$event){
            throw $this->createNotFoundException(
                'Pas d\'évenement disponible'
            );
        }
        return $this->render('home/index.html.twig',[
            'event'=>$event
        ]);
    }
    #[Route('/participer', name: 'app_participer')]
    public function participation(EntityManagerInterface $entityManager,Request $request): Response
    {
        $tickets = $entityManager->getRepository(Ticket::class)->findAll($request->get('event_id'));
        if(!$tickets){
            throw $this->createNotFoundException(
                'Pas de ticket disponible'
            );
        }
        return $this->render('home/participer.html.twig',[
            'tickets'=>$tickets
        ]);
    }
    #[Route('/jeParticipe', name: 'app_jeParticipe')]
    public function jeParticipe(EntityManagerInterface $entityManager,Request $request,#[CurrentUser()] ?User $user): Response
    {
        if(!empty($user)){
            $tickets = $entityManager->getRepository(Ticket::class)->find($request->get('ticket_id'));
            $event = $entityManager->getRepository(Event::class)->find($tickets->getEvent());
            $event->addUser($user);
            $tickets->addUserTicker($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }else{
            return $this->redirectToRoute('app_home'); 
        }
        
    }
    #[Route('/mes_evenements', name: 'app_mesEvenements')]
    public function mesEvenements(EntityManagerInterface $entityManager,Request $request,#[CurrentUser()] ?User $user): Response
    {
        if(!empty($user)){
            $events = $entityManager->getRepository(Event::class)->find($user->getId());
            $events->getUsers()->initialize();
            return $this->render('home/myEvent.html.twig',[
                'myCurrentEvents'=>$events
            ]);
        }else{
            return $this->render('home/myEvent.html.twig');
        }
    }

}
