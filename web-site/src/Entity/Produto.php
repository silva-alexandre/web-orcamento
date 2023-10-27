<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantidade = null;

    #[ORM\ManyToOne(inversedBy: 'produto')]
    private ?Servico $servico = null;

    #[ORM\OneToMany(mappedBy: 'produto', targetEntity: Orcamento::class)]
    private Collection $orcamento;

    public function __construct()
    {
        $this->orcamento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantidade(): ?int
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): static
    {
        $this->quantidade = $quantidade;

        return $this;
    }
    public function getServico(): ?Servico
    {
        return $this->servico;
    }

    public function setServico(?Servico $servico): static
    {
        $this->servico = $servico;

        return $this;
    }

    public function __toString()
    {
        return $this->quantidade;
    }

    /**
     * @return Collection<int, Orcamento>
     */
    public function getOrcamento(): Collection
    {
        return $this->orcamento;
    }

    public function addOrcamento(Orcamento $orcamento): static
    {
        if (!$this->orcamento->contains($orcamento)) {
            $this->orcamento->add($orcamento);
            $orcamento->setProduto($this);
        }

        return $this;
    }

    public function removeOrcamento(Orcamento $orcamento): static
    {
        if ($this->orcamento->removeElement($orcamento)) {
            // set the owning side to null (unless already changed)
            if ($orcamento->getProduto() === $this) {
                $orcamento->setProduto(null);
            }
        }

        return $this;
    }
}
