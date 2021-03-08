<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"api_city"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"api_city"})
     */
    private $cityName;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"api_city"})
     */
    private $countryName;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"api_city"})
     */
    private $geonameId;


    /**
     * @ORM\Column(type="datetime")
     * @Groups({"api_city"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Weather::class, mappedBy="city")
     */
    private $weather;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="cities")
     */
    private $tag;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="city")
     */
    private $reviews;

    public function __construct()
    {
        $this->weather = new ArrayCollection();
        $this->tag = new ArrayCollection();
        $this->reviews = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCityName(): ?string
    {
        return $this->cityName;
    }

    public function setCityName(string $cityName): self
    {
        $this->cityName = $cityName;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function setCountryName(string $countryName): self
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * @Groups({"api_city"})
     */
    public function getUrlCity()
    {
        return '/city/fiche/' . $this->getGeonameId();
        //return 'http://' . $_SERVER['SERVER_NAME'] . '/city/' . $this->getGeonameId();
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
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of geonameId
     */ 
    public function getGeonameId()
    {
        return $this->geonameId;
    }

    /**
     * Set the value of geonameId
     *
     * @return  self
     */ 
    public function setGeonameId($geonameId)
    {
        $this->geonameId = $geonameId;

        return $this;
    }

    /**
     * @return Collection|Weather[]
     */
    public function getWeather(): Collection
    {
        return $this->weather;
    }

    public function addWeather(Weather $weather): self
    {
        if (!$this->weather->contains($weather)) {
            $this->weather[] = $weather;
            $weather->setCity($this);
        }

        return $this;
    }

    public function removeWeather(Weather $weather): self
    {
        if ($this->Weather->removeElement($weather)) {
            // set the owning side to null (unless already changed)
            if ($weather->getCity() === $this) {
                $weather->setCity(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Review[]
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setCity($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCity() === $this) {
                $review->setCity(null);
            }
        }

        return $this;
    }
}
