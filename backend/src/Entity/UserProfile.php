<?php

namespace App\Entity;

use App\Repository\UserProfileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $bio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $websiteURL = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitterUserName = null;

    #[ORM\Column(type: 'date_immutable', length: 255, nullable: true)]
    private ?Date $dateOfBirth = null;

    #[ORM\OneToOne(inversedBy: 'userProfile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getWebsiteURL(): ?string
    {
        return $this->websiteURL;
    }

    public function setWebsiteURL(?string $websiteURL): static
    {
        $this->websiteURL = $websiteURL;

        return $this;
    }

    public function getTwitterUserName(): ?string
    {
        return $this->twitterUserName;
    }

    public function setTwitterUserName(?string $twitterUserName): static
    {
        $this->twitterUserName = $twitterUserName;

        return $this;
    }

    public function getDateOfBirth(): ?Date
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(Date $dateOfBirth = null): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
