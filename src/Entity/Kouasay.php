<?php

namespace App\Entity;

use App\Repository\KouasayRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KouasayRepository::class)]
class Kouasay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
