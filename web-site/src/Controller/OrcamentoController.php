<?php

namespace App\Controller;

use App\Entity\Cliente;
use App\Entity\Orcamento;
use App\Entity\Produto;
use App\Entity\Servico;
use App\Form\ClienteType;
use App\Form\OrcamentoType;
use App\Form\ProdutoType;
use App\Repository\ClienteRepository;
use App\Repository\OrcamentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/orcamento')]
class OrcamentoController extends AbstractController
{
    #[Route('/', name: 'app_orcamento_index', methods: ['GET'])]
    public function index(OrcamentoRepository $orcamentoRepository): Response
    {
        return $this->render('orcamento/index.html.twig', [
            'orcamentos' => $orcamentoRepository->findAll(),
        ]);
    }

    #[Route('/simulacao', name: 'app_simulacao_index', methods: ['GET'])]
    public function simulacao(Request $request, EntityManagerInterface $entityManager, ClienteRepository $clienteRepository): Response
    {
        $orcamento = new Orcamento();

        $form = $this->createForm(OrcamentoType::class, $orcamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $orcamento->calcularValorTotal();
            $orcamento->getValorTotal();
            $entityManager->persist($orcamento);
            $entityManager->flush();

            return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cliente/cadastro.html.twig', [
            'orcamento' => $orcamento,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_orcamento_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $orcamento = new Orcamento();
        $form = $this->createForm(OrcamentoType::class, $orcamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orcamento->calcularValorTotal();
            $orcamento->getValorTotal();
            $entityManager->persist($orcamento);
            $entityManager->flush();

            return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orcamento/new.html.twig', [
            'orcamento' => $orcamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orcamento_show', methods: ['GET'])]
    public function show(Orcamento $orcamento): Response
    {
        return $this->render('orcamento/show.html.twig', [
            'orcamento' => $orcamento,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orcamento_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orcamento $orcamento, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrcamentoType::class, $orcamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orcamento->calcularValorTotal();
            $orcamento->getValorTotal();
            $entityManager->flush();

            return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orcamento/edit.html.twig', [
            'orcamento' => $orcamento,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_orcamento_delete', methods: ['POST'])]
    public function delete(Request $request, Orcamento $orcamento, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$orcamento->getId(), $request->request->get('_token'))) {
            $entityManager->remove($orcamento);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_orcamento_index', [], Response::HTTP_SEE_OTHER);
    }
}
