<?php

namespace App\Controller;

use App\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
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

    /**
     * @Route("/event/{block}/variant",name="block-variant")
     * @param $block
     * @return Response
     */
    public function addVariant($block)
    {
        return $this->render('/event/variant.html.twig', [
            'block_id' => $block
        ]);
    }

    /**
     * @Route("/event/versions/{block}",name="block-versions")
     * @param $block
     * @return Response
     */
    public function versions($block)
    {
        return $this->render('/event/versions.html.twig', [
            'block_id' => $block
        ]);
    }

    /**
     * @Route("/event/close/{id}",name="close_event")
     * @param $id
     * @return RedirectResponse
     */
    public function close($id)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var Event $event */
        $event = $em->getRepository(Event::class)->find($id);


        $event->setStatus(3);

        $em->flush();
        return new RedirectResponse('/event');
    }

    /**
     * @Route("/event/protocol/{id}",name="event_protocol")
     * @param $id
     * @return Response
     */
    public function protocol($id)
    {
        return $this->render('/event/protocol.html.twig', [
           'event_id' => $id
        ]);
    }
}
