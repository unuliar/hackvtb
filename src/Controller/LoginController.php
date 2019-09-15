<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        if($request->cookies->get('token') == null) {
            return $this->render('login.html.twig', [
                'error' => $request->query->get('error')
            ]);
        } else {
            return $this->redirectToRoute('main');
        }
    }

    /**
     * @Route("/login/check", name="checkCredentials")
     */
    public function checkCredentials(Request $request)
    {
        $login = $request->request->get('login');
        $password = $request->request->get('password');

        if($login == 'admin@xvote.com' && $password == 'admin') {
            $entityManager = $this->getDoctrine()->getManager();

            /** @var User[] $user */
            $user = $entityManager->getRepository(User::class)->findBy([
                'name' => 'admin'
            ]);
            $authToken = md5(rand(0,100000));

            $user[0]->setToken($authToken);
            $entityManager->flush();

            $response = new RedirectResponse($this->generateUrl('main'));
            $response->headers->setCookie(Cookie::create('token', $authToken));
            $response->headers->setCookie(Cookie::create('user_id', $user[0]->getId()));

            return $response;
        } else {
            return $this->redirectToRoute('login', [
                'error' => 'Неверные данные'
            ]);
        }
    }
}
