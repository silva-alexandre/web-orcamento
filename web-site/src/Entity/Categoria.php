<?php

namespace App\Entity;

use App\Repository\CategoriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriaRepository::class)]
class Categoria
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $nome_categoria = null;

    #[ORM\OneToMany(mappedBy: 'categoria', targetEntity: Servico::class)]
    private Collection $servico;

    public function __construct()
    {
        $this->servico = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeCategoria(): ?string
    {
        return $this->nome_categoria;
    }

    public function setNomeCategoria(string $nome_categoria): static
    {
        $this->nome_categoria = $nome_categoria;

        return $this;
    }

    public function __toString()
    {
        return $this->nome_categoria;
    }

    /**
     * @return Collection<int, Servico>
     */
    public function getServico(): Collection
    {
        return $this->servico;
    }

    public function addServico(Servico $servico): static
    {
        if (!$this->servico->contains($servico)) {
            $this->servico->add($servico);
            $servico->setCategoria($this);
        }

        return $this;
    }

    public function removeServico(Servico $servico): static
    {
        if ($this->servico->removeElement($servico)) {
            // set the owning side to null (unless already changed)
            if ($servico->getCategoria() === $this) {
                $servico->setCategoria(null);
            }
        }

        return $this;
    }
}
