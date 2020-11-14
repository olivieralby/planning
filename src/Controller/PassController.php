<?php

namespace App\Controller;

use App\Entity\Day;
use App\Entity\User;
use App\Repository\DayRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PassController{

    private $encoder;
    private $repo;

    public function __construct(UserPasswordEncoderInterface $encoder, DayRepository $repo)
    {
        $this->encoder = $encoder;
        $this->repo = $repo;
    }

    public function __invoke(User $data)
    {
        
        //$days = $this->repo->findByUser($data->getId());
        //$data->addDay($days);
        $data->setPassword($this->encoder->encodePassword($data, $data->getPassword()));
        return $data;
    }
}