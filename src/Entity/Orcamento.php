<?php

namespace App\Entity;

use App\Repository\OrcamentoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: OrcamentoRepository::class)]
class Orcamento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $titulo_orcamento = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $data_solicitacao = null;

    #[ORM\ManyToOne(inversedBy: 'orcamento')]
    private ?Cliente $cliente = null;

    #[ORM\ManyToOne(inversedBy: 'orcamento')]
    private ?Servico $servico = null;

    #[ORM\ManyToOne(inversedBy: 'orcamento')]
    private ?Produto $produto = null;

    #[ORM\Column(nullable: true)]
    private ?int $valor_total = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTituloOrcamento(): ?string
    {
        return $this->titulo_orcamento;
    }

    public function setTituloOrcamento(string $titulo_orcamento): static
    {
        $this->titulo_orcamento = $titulo_orcamento;

        return $this;
    }

    public function getDataSolicitacao(): ?\DateTimeInterface
    {
        return $this->data_solicitacao;
    }

    public function setDataSolicitacao(?\DateTimeInterface $data_solicitacao): static
    {
        $this->data_solicitacao = $data_solicitacao;

        return $this;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): static
    {
        $this->cliente = $cliente;

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

    public function getProduto(): ?Produto
    {
        return $this->produto;
    }

    public function setProduto(?Produto $produto): static
    {
        $this->produto = $produto;

        return $this;
    }

    public function preencherTituloAutomaticamente(): void
    {
        if ($this->getCliente() && empty($this->titulo_orcamento)) {
            $nomeCliente = $this->getCliente();
            $dataAtual = new \DateTime();
            $dia = $dataAtual->format('d-m-Y');

            $this->titulo_orcamento = $nomeCliente . ' ' . $dia;
        }
    }


    public function calcularValorTotal() {

        if ($this->produto instanceof Produto) {
            $this->valor_total = $this->produto->getQuantidade() * $this->servico->getValor();
        }
    }

    public function getValorTotal(): ?int
    {
        return $this->valor_total;
    }

    public function setValorTotal(?int $valor_total): static
    {
        $this->calcularValorTotal($valor_total) ;

        return $this;
    }
}
