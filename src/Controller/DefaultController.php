<?php

namespace App\Controller;


use App\Document\Region;
use App\Document\Station;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/test")
     * @return Response
     */
    public function index(){
        $region = $this->get('doctrine_mongodb')
            ->getRepository(Region::class)
            ->findOneBy(['regionCode'=>'REGIN09']);
        $stations = $this->get('doctrine_mongodb')
            ->getRepository(Station::class)->findBy(['region'=>$region]);

        dump($stations);die();
    }

}