<?php

namespace App\Entity;

use App\Repository\DiscussRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussRepository::class)]
class Discuss
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Message>
     */
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'discuss')]
    private Collection $Message;

    public function __construct()
    {
        $this->Message = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessage(): Collection
    {
        return $this->Message;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->Message->contains($message)) {
            $this->Message->add($message);
            $message->setDiscuss($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->Message->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDiscuss() === $this) {
                $message->setDiscuss(null);
            }
        }

        return $this;
    }
}
