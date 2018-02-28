<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks()
 * @MongoDBUnique(fields={"stationCode", "name"})
 */
class Station
{
    /**
     * @MongoDB\Id()
     */
    private $id;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $stationCode;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $name;

    /**
     * @var Region
     * @MongoDB\ReferenceOne(targetDocument="Region")
     */
    private $region;

    /**
     * @var string
     * @MongoDB\Field(type="string", nullable=true)
     */
    private $postalCode;

    /**
     * @var string
     * @MongoDB\Field(type="string", nullable=true)
     */
    private $lat;

    /**
     * @var string
     * @MongoDB\Field(type="string", nullable=true)
     */
    private $long;

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
    public function getStationCode(): string
    {
        return $this->stationCode;
    }

    /**
     * @param string $stationCode
     */
    public function setStationCode(string $stationCode)
    {
        $this->stationCode = $stationCode;
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

    /**
     * @return Region
     */
    public function getRegion(): Region
    {
        return $this->region;
    }

    /**
     * @param Region $region
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return string
     */
    public function getLat(): string
    {
        return $this->lat;
    }

    /**
     * @param string $lat
     */
    public function setLat(string $lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return string
     */
    public function getLong(): string
    {
        return $this->long;
    }

    /**
     * @param string $long
     */
    public function setLong(string $long)
    {
        $this->long = $long;
    }
}