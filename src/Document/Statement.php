<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 * @MongoDB\HasLifecycleCallbacks()
 */
class Statement
{
    /**
     * @MongoDB\Id()
     */
    private $id;

    /**
     * @var int
     * @MongoDB\Field(type="integer")
     */
    private $year;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $type;

    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $unit;

    /**
     * @var array
     * @MongoDB\Field(type="collection")
     */
    private $values;

    /**
     * @var Station
     * @MongoDB\ReferenceOne(targetDocument="Station")
     */
    private $station;

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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @param string $unit
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return Station
     */
    public function getStation(): Station
    {
        return $this->station;
    }

    /**
     * @param Station $station
     */
    public function setStation(Station $station)
    {
        $this->station = $station;
    }
}