<?php
/**
 * Created by PhpStorm.
 * User: unuliar
 * Date: 14.09.2019
 * Time: 21:20
 */

namespace App\Controller;


use App\Entity\Block;
use App\Entity\BlockVersion;
use App\Entity\Event;
use App\Entity\Message;
use App\Entity\User;
use App\Entity\Vote;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\FOSRestBundle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractFOSRestController
{
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /** parent param
     * @Rest\Post("/api/block")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postBlock(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);

        if($request->get('parent') !== null) {
            $rep2 = $this->getDoctrine()->getRepository(Block::class);
            $request->query->set('parent', $rep2->find($request->get('parent')));
        }

        $rep3 = $this->getDoctrine()->getRepository(Event::class);

        $request->query->set('user', $rep->find($request->get('user')));
        $request->query->set('event', $rep3->find($request->get('event')));



        $rep = $this->getDoctrine()->getRepository(Block::class);
        $result = $rep->createByRequest($request);

        return $this->handleView($this->view(['status' => 'ok', 'id' => $result->getId()], Response::HTTP_CREATED));
    }

    /**
     * @Rest\Get("/api/block")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getBlock(Request $request)
    {
        $id = $request->query->get('id');
        $rep = $this->getDoctrine()->getRepository(Block::class);
        isset($id) ? $res = [$rep->findOneBy(['id' => $id])] : $res = $rep->findAll();
        return $this->handleView($this->view($res));
    }

    /**
     * @Rest\Post("/api/event")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEvent(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);

        $arb = $request->get('arbiter');

        $request->query->set('starttime',  new \DateTime($request->get('starttime')) ?? new \DateTime());
        $request->query->set('arbiter', $rep->find($arb));
        $request->query->set('endtime',  new \DateTime($request->get('endtime')) ?? new \DateTime("12.12.2099"));
        $request->query->set('status', $request->get('start') === null ? 1 : 0);

        $rep = $this->getDoctrine()->getRepository(Event::class);
        $result = $rep->createByRequest($request);

        return $this->handleView($this->view(['status' => 'ok', 'id' => $result->getId()], Response::HTTP_CREATED));
    }

    /**
     * @Rest\Patch("/api/event")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function patchEvent(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(Event::class);
        $event = $rep->find($request->query->get('id'));
        $result = $rep->createByRequest($request, $event);

        return $this->handleView($this->view(['status' => 'ok', 'id' => $event->getId()], Response::HTTP_CREATED));
    }

    /**
     * @Rest\Post("/api/message")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postMessage(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $rep2 = $this->getDoctrine()->getRepository(Event::class);


        $request->query->set('time', $request->get('starttime') ?? new \DateTime());
        $request->query->set('user', $rep->find($request->get('user')));
        $request->query->set('event', $rep2->find($request->get('event')));


        $rep = $this->getDoctrine()->getRepository(Message::class);
        $result = $rep->createByRequest($request);

        return $this->handleView($this->view(['status' => 'ok', 'id' => $result->getId()], Response::HTTP_CREATED));
    }

    /**
     * @Rest\Post("/api/user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postUser(Request $request)
    {
        $request->query->set('token', md5(rand(0, PHP_INT_MAX)));

        $rep = $this->getDoctrine()->getRepository(User::class);
        $result = $rep->createByRequest($request);

        return $this->handleView($this->view(['status' => 'ok', 'id' => $result->getId()], Response::HTTP_CREATED));
    }

    /**
     * @Rest\Post("/api/vote")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postVote(Request $request)
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $rep2 = $this->getDoctrine()->getRepository(Block::class);

        $request->query->set('user', $rep->find($request->get('user')));
        $request->query->set('block', $rep2->find($request->get('block')));
       // print_r(json_encode($request->get('user')))

        $rep = $this->getDoctrine()->getRepository(Vote::class);

        if($vote = $rep->findBy([
            'user' => $request->get('user'),
            'block' => $request->get('block')
        ])) {
            foreach ($vote as $item)
                {
                $this->em->remove($item);
            }
            $this->em->flush();

        }
        $result = $rep->createByRequest($request);

        return $this->handleView($this->view(['status' => 'ok', 'id' => $result->getId()], Response::HTTP_CREATED));
    }


    /**
     * @Rest\Get("/api/event")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getEvent(Request $request)
    {
        $id = $request->query->get('id');
        $rep = $this->getDoctrine()->getRepository(Event::class);
        isset($id) ? $res = [$rep->findOneBy(['id' => $id])] : $res = $rep->findAll();
        return $this->handleView($this->view($res));
    }

}