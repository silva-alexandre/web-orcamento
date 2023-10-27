<?php

namespace App\Entity;


use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $nome_cliente = null;

    #[ORM\Column(length: 100)]
    private ?string $contato = null;

    #[ORM\OneToMany(mappedBy: 'cliente', targetEntity: Orcamento::class)]
    private Collection $orcamento;

    public function __construct()
    {
        $this->orcamento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeCliente(): ?string
    {
        return $this->nome_cliente;
    }

    public function setNomeCliente(string $nome_cliente): static
    {
        $this->nome_cliente = $nome_cliente;

        return $this;
    }

    public function __toString()
    {
        return $this->nome_cliente;
    }


    public function getContato(): ?string
    {
        return $this->contato;
    }

    public function setContato(string $contato): static
    {
        $this->contato = $contato;

        return $this;
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
            $orcamento->setCliente($this);
        }

        return $this;
    }

    public function removeOrcamento(Orcamento $orcamento): static
    {
        if ($this->orcamento->removeElement($orcamento)) {
            // set the owning side to null (unless already changed)
            if ($orcamento->getCliente() === $this) {
                $orcamento->setCliente(null);
            }
        }

        return $this;
    }
}
