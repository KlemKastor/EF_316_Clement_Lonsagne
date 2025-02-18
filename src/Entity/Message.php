<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Likes>
     */
    #[ORM\OneToMany(targetEntity: Likes::class, mappedBy: 'message')]
    private Collection $Likes;

    #[ORM\ManyToOne(inversedBy: 'Message')]
    private ?Discuss $discuss = null;

    public function __construct()
    {
        $this->Likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Likes>
     */
    public function getLikes(): Collection
    {
        return $this->Likes;
    }

    public function addLike(Likes $like): static
    {
        if (!$this->Likes->contains($like)) {
            $this->Likes->add($like);
            $like->setMessage($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): static
    {
        if ($this->Likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getMessage() === $this) {
                $like->setMessage(null);
            }
        }

        return $this;
    }

    public function getDiscuss(): ?Discuss
    {
        return $this->discuss;
    }

    public function setDiscuss(?Discuss $discuss): static
    {
        $this->discuss = $discuss;

        return $this;
    }
}
