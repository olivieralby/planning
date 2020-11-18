<?php

namespace App\Controller;

use App\Repository\ActiviteRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('home/home.html.twig');
    }
    /**
     * @Route("/home", name="home")
     */
    public function index(ActiviteRepository $activ, UserRepository $repo): Response
    {
        $user = $this->getUser();
        $activite = $activ->findAll();
        $role = $repo->findAll();


        return $this->render('home/index.html.twig', [
            'user' => $user,
            'activite'=>$activite,
            'role'=>$role
        ]);
    }

    /**
     * @Route("/home/{id}", name="homeid", methods={"GET"})
     */
    public function show($id, UserRepository $re): Response
    {
        return $this->json($re->find($id),200);
    }
}
