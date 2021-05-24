<?php

namespace App\Entity;

use App\Repository\WeatherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WeatherRepository::class)
 */
class Weather
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $month;

    /**
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @ORM\Column(type="integer")
     */
    private $averageMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $averageMax;

    /**
     * @ORM\Column(type="integer")
     */
    private $tempLevelMin;

    /**
     * @ORM\Column(type="integer")
     */
    private $tempLevelMax;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UpdatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="Weather")
     */
    private $city;

    public function __toString()
    {
        if(is_null($this->month)) {
            return 'NULL';
        }
        return get_class($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function setMonth(int $month): self
    {
        $this->month = $month;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getAverageMin(): ?int
    {
        return $this->averageMin;
    }

    public function setAverageMin(int $averageMin): self
    {
        $this->averageMin = $averageMin;

        return $this;
    }

    public function getAverageMax(): ?int
    {
        return $this->averageMax;
    }

    public function setAverageMax(int $averageMax): self
    {
        $this->averageMax = $averageMax;

        return $this;
    }

    public function getTempLevelMin(): ?int
    {
        return $this->tempLevelMin;
    }

    public function setTempLevelMin(int $tempLevelMin): self
    {
        $this->tempLevelMin = $tempLevelMin;

        return $this;
    }

    public function getTempLevelMax(): ?int
    {
        return $this->tempLevelMax;
    }

    public function setTempLevelMax(int $tempLevelMax): self
    {
        $this->tempLevelMax = $tempLevelMax;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }
}
