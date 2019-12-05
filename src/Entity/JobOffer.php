<?php

namespace App\Entity;

use App\Repository\JobOfferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Gedmo\Mapping\Annotation as Gedmo;
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
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
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
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    

    /**
     * @ORM\Column(type="integer")
     */
    private $applicationsCount = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Application", mappedBy="jobOffer", fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    private $applications;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="jobOffers")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="jobOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Field", inversedBy="jobOffers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $field;

    

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->isFilled = false;
        $this->isPublished = false;
        $this->applications = new ArrayCollection();
        $this->tags = new ArrayCollection();
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


    public function getApplicationsCount(): ?int
    {
        return $this->applicationsCount;
    }

    public function setApplicationsCount(int $applicationsCount): self
    {
        $this->applicationsCount = $applicationsCount;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }


    public function getImagePath()
    {
        return 'images/'. $this->getImageFilename();
    }

    /**
     * @return Collection|Application[]
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    /**
     * @return Collection|Application[]
     */
    public function getNonDeletedApplications(): Collection
    {
        $criteria = JobOfferRepository::createNonDeletedCriteria();
        return $this->applications->matching($criteria);
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications[] = $application;
            $application->setJobOffer($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->contains($application)) {
            $this->applications->removeElement($application);
            // set the owning side to null (unless already changed)
            if ($application->getJobOffer() === $this) {
                $application->setJobOffer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }
}
