<?php

namespace App\Service;


use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;

class DoctrineDocumentManager
{
 private $dm;

 function __construct(ManagerRegistry $documentManager)
 {
     $this->dm = $documentManager;
 }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|objectaæ
     */
 public function getManager(){
     return $this->dm->getManager();
 }
}