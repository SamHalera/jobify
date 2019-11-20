<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobOfferRepository")
 */
class JobOffer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $contentSociety;

    /**
     * @ORM\Column(type="text")
     */
    private $contentMission;

    /**
     * @ORM\Column(type="text")
     */
    private $contentRequirements;

    

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFilled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $slug;

    

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getContentSociety(): ?string
    {
        return $this->contentSociety;
    }

    public function setContentSociety(?string $contentSociety): self
    {
        $this->contentSociety = $contentSociety;

        return $this;
    }

    public function getContentMission(): ?string
    {
        return $this->contentMission;
    }

    public function setContentMission(string $contentMission): self
    {
        $this->contentMission = $contentMission;

        return $this;
    }

    public function getContentRequirements(): ?string
    {
        return $this->contentRequirements;
    }

    public function setContentRequirements(string $contentRequirements): self
    {
        $this->contentRequirements = $contentRequirements;

        return $this;
    }

   

    public function getIsFilled(): ?bool
    {
        return $this->isFilled;
    }

    public function setIsFilled(bool $isFilled): self
    {
        $this->isFilled = $isFilled;

        return $this;
    }

    public function getPublishedAt(): ?\DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?\DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(?bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
