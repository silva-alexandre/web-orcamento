<?php

namespace App\Entity;

use App\Repository\ServicoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicoRepository::class)]
class Servico
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 80)]
    private ?string $nome_servico = null;

    #[ORM\Column(length: 120)]
    private ?string $descricao_servico = null;

    #[ORM\Column]
    private ?int $valor = null;

    #[ORM\ManyToOne(inversedBy: 'servico')]
    private ?Categoria $categoria = null;

    #[ORM\OneToMany(mappedBy: 'servico', targetEntity: Produto::class)]
    private Collection $produto;

    #[ORM\OneToMany(mappedBy: 'servico', targetEntity: Orcamento::class)]
    private Collection $orcamento;

    public function __construct()
    {
        $this->produto = new ArrayCollection();
        $this->orcamento = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeServico(): ?string
    {
        return $this->nome_servico;
    }

    public function setNomeServico(string $nome_servico): static
    {
        $this->nome_servico = $nome_servico;

        return $this;
    }

    public function getDescricaoServico(): ?string
    {
        return $this->descricao_servico;
    }

    public function setDescricaoServico(string $descricao_servico): static
    {
        $this->descricao_servico = $descricao_servico;

        return $this;
    }

    public function getValor(): ?int
    {
        return $this->valor;
    }

    public function setValor(int $valor): static
    {
        $this->valor = $valor;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function __toString()
    {
        return $this->nome_servico;
    }

    /**
     * @return Collection<int, Produto>
     */
    public function getProduto(): Collection
    {
        return $this->produto;
    }

    public function addProduto(Produto $produto): static
    {
        if (!$this->produto->contains($produto)) {
            $this->produto->add($produto);
            $produto->setServico($this);
        }

        return $this;
    }

    public function removeProduto(Produto $produto): static
    {
        if ($this->produto->removeElement($produto)) {
            // set the owning side to null (unless already changed)
            if ($produto->getServico() === $this) {
                $produto->setServico(null);
            }
        }

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
            $orcamento->setServico($this);
        }

        return $this;
    }

    public function removeOrcamento(Orcamento $orcamento): static
    {
        if ($this->orcamento->removeElement($orcamento)) {
            // set the owning side to null (unless already changed)
            if ($orcamento->getServico() === $this) {
                $orcamento->setServico(null);
            }
        }

        return $this;
    }
}
