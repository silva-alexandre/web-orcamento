<?php

namespace App\Test\Controller;

use App\Entity\Orcamento;
use App\Repository\OrcamentoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrcamentoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private OrcamentoRepository $repository;
    private string $path = '/orcamento/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Orcamento::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Orcamento index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'orcamento[titulo_orcamento]' => 'Testing',
            'orcamento[data_solicitacao]' => 'Testing',
            'orcamento[valor_total]' => 'Testing',
            'orcamento[cliente]' => 'Testing',
            'orcamento[servico]' => 'Testing',
            'orcamento[produto]' => 'Testing',
        ]);

        self::assertResponseRedirects('/orcamento/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Orcamento();
        $fixture->setTitulo_orcamento('My Title');
        $fixture->setData_solicitacao('My Title');
        $fixture->setValor_total('My Title');
        $fixture->setCliente('My Title');
        $fixture->setServico('My Title');
        $fixture->setProduto('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Orcamento');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Orcamento();
        $fixture->setTitulo_orcamento('My Title');
        $fixture->setData_solicitacao('My Title');
        $fixture->setValor_total('My Title');
        $fixture->setCliente('My Title');
        $fixture->setServico('My Title');
        $fixture->setProduto('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'orcamento[titulo_orcamento]' => 'Something New',
            'orcamento[data_solicitacao]' => 'Something New',
            'orcamento[valor_total]' => 'Something New',
            'orcamento[cliente]' => 'Something New',
            'orcamento[servico]' => 'Something New',
            'orcamento[produto]' => 'Something New',
        ]);

        self::assertResponseRedirects('/orcamento/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitulo_orcamento());
        self::assertSame('Something New', $fixture[0]->getData_solicitacao());
        self::assertSame('Something New', $fixture[0]->getValor_total());
        self::assertSame('Something New', $fixture[0]->getCliente());
        self::assertSame('Something New', $fixture[0]->getServico());
        self::assertSame('Something New', $fixture[0]->getProduto());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Orcamento();
        $fixture->setTitulo_orcamento('My Title');
        $fixture->setData_solicitacao('My Title');
        $fixture->setValor_total('My Title');
        $fixture->setCliente('My Title');
        $fixture->setServico('My Title');
        $fixture->setProduto('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/orcamento/');
    }
}
