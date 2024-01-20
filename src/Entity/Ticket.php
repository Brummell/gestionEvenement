<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $prix = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $nbrPlaceDispo = null;

    #[ORM\ManyToOne(inversedBy: 'ticket')]
    private ?Event $event = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tickets')]
    private Collection $user_ticker;

    public function __construct()
    {
        $this->user_ticker = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNbrPlaceDispo(): ?int
    {
        return $this->nbrPlaceDispo;
    }

    public function setNbrPlaceDispo(int $nbrPlaceDispo): static
    {
        $this->nbrPlaceDispo = $nbrPlaceDispo;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserTicker(): Collection
    {
        return $this->user_ticker;
    }

    public function addUserTicker(User $userTicker): static
    {
        if (!$this->user_ticker->contains($userTicker)) {
            $this->user_ticker->add($userTicker);
        }

        return $this;
    }

    public function removeUserTicker(User $userTicker): static
    {
        $this->user_ticker->removeElement($userTicker);

        return $this;
    }
}
