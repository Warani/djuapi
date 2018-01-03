<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks()
 * @MongoDBUnique(fields={"regionCode", "name"})
 */
class Region
{
    /**
     * @MongoDB\Id()
     */
    private $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $regionCode;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    /**
     * @param string $regionCode
     */
    public function setRegionCode(string $regionCode)
    {
        $this->regionCode = $regionCode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

}