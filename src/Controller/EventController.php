<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    /**
     * @Route("/event", name="event")
     */
    public function index()
    {
        return $this->render('event/index.html.twig');
    }

    /**
     * @Route("/event/create",name="create-event")
     * @return Response
     */
    public function create()
    {
        return $this->render('event/create.html.twig');
    }

    /**
     * @Route("/event/room/{id}",name="event-room")
     * @param $id
     * @return Response
     */
    public function room($id)
    {
        return $this->render('event/room.html.twig', [
            'event_id' => $id
        ]);
    }
}
