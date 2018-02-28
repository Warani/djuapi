<?php

namespace App\Controller;


use App\Document\Region;
use App\Document\Statement;
use App\Document\Station;
use App\Service\DoctrineDocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class DefaultController extends Controller
{
    private $dm;

    public function __construct(DoctrineDocumentManager $dm)
    {
        $this->dm = $dm->getManager();
    }

    /**
     * @Route("/test")
     * @Rest\View()
     */
    public function index(){
        $region = $this->dm
            ->getRepository(Region::class)
            ->findOneBy(['regionCode'=>'REGIN09']);
        $stations = $this->dm
            ->getRepository(Station::class)->findBy(['region'=>$region]);

        #$statements = $dm->getManager()->getRepository(Statement::class)->findAll();
        return $stations;
    }

}