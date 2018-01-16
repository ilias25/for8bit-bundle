<?php

namespace Ilias25\For8BitBundle\Entity;

/**
 * Location
  */
class Location
{
    /**
     * @var string
     *
     */
    protected $name;

    /**
     * @var float
     *
     */
    protected $latitude;

    /**
     * @var float
     *
     */
    protected $longitude;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Location
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Location
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Location
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Returns location as array
     *
     * @return array
     */
    public function getAsArray()
    {
        return [
            'name'          => $this->getName(),
            'coordinates'   => [
                'lat'   => $this->getLatitude(),
                'long'  => $this->getLongitude(),

            ],
        ];
    }
}

