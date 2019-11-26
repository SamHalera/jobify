<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ApplicationRepository")
 */
class Application
{

    use TimestampableEntity;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $applicantName;

    /**
     * @ORM\Column(type="text")
     */
    private $motivationalMessage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobOffer", inversedBy="applications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jobOffer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApplicantName(): ?string
    {
        return $this->applicantName;
    }

    public function setApplicantName(string $applicantName): self
    {
        $this->applicantName = $applicantName;

        return $this;
    }

    public function getMotivationalMessage(): ?string
    {
        return $this->motivationalMessage;
    }

    public function setMotivationalMessage(string $motivationalMessage): self
    {
        $this->motivationalMessage = $motivationalMessage;

        return $this;
    }

    public function getJobOffer(): ?JobOffer
    {
        return $this->jobOffer;
    }

    public function setJobOffer(?JobOffer $jobOffer): self
    {
        $this->jobOffer = $jobOffer;

        return $this;
    }
}
