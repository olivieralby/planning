<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Entity\Day;
use App\Repository\ActiviteRepository;
use App\Repository\DayRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CalendarController extends AbstractController
{

    /**
     * @Route("/calendar",name="getcalendar")
     */
    public function index(DayRepository $em)
    {
        $user = $this->getUser();
        $id = $user->getId();
        $day = $em->getDay($id);
        $data=['user_id'=>$id];
        foreach($day as $d){
            $data[] = ['id'=>$d['id'],'start'=>$d['start'], "end"=>$d['end'], "title"=>$d['label'], "color"=>$d['color']];
        }
        return $this->json($data,200,[],['groups'=>"day:read"]);
    }

    /**
     * @Route("/calendar/show/{id}", name="showcalendar")
     */
    public function show($id, DayRepository $em)
    {

        $user = $this->getUser();
        $day = $em->getDay($id);
        if($day==null){
            return $this->json('table day vide',200);
        }
        foreach($day as $d){
            $data[] = ['id'=>$d['id'],'day_id'=>$d['day_id'],'start'=>$d['start'], "end"=>$d['end'], "title"=>$d['label'], "color"=>$d['color']];
        }
        return $this->json($data,200,[],['groups'=>'day:read']);
    }
    /**
     * @Route("/calendar/new", name="calendar", methods={"POST"})
     */
    public function store(EntityManagerInterface $em, Request $request, ActiviteRepository $repo, UserRepository $userRepository): Response
    {
        $result = json_decode($request->getContent());
        $activite = $repo->find($result->event->activites);
        $user = $userRepository->find($result->user->id);
        $day = new Day();
        $day->setStart($result->event->start);
        $day->setEnd($result->event->end) ;
        $day->addActivite($activite);
        $day->addUser($user);
        $em->persist($day);
        $em->flush();
        return $this->json($day, 200,[],["groups"=>"day:read"]);
    }

    /**
     * @Route("/calendar/update", name="update")
     */
    public function update(Request $request, EntityManagerInterface $em, DayRepository $repo)
    {
        $result = json_decode($request->getContent());
        $day = $repo->findOneBySomeField($result->oldstart, $result->id);
        $day->setStart($result->start);
        $day->setEnd($result->end);
        $em->persist($day);
        $em->flush();
        return $this->json($day,200);
    }

    /**
     * @Route("/calendar/destroy/{id}", name="calendardestroy")
     */
    public function destroy($id, DayRepository $dr, EntityManagerInterface $em)
    {
        $day = $dr->find($id);
        $em->remove($day);
        $em->flush();
        return $this->json('élément supprimé',200);

    }

    /**
     * @Route("/calendar/activite", name="activite")
     */
    public function activite(ActiviteRepository $ar)
    {
        return $this->json($ar->findAll(),200,[],['groups'=>["user:read"]]);
    }
}
