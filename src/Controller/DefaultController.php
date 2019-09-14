<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController
{
    public function index()
    {
        return new Response("Hello!");
    }
}