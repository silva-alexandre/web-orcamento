<?php

namespace App\Test\Controller;

use App\Entity\Servico;
use App\Repository\ServicoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ServicoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ServicoRepository $repository;
    private string $path = '/servico/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Servico::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Servico index');

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
            'servico[nome_servico]' => 'Testing',
            'servico[descricao_servico]' => 'Testing',
            'servico[valor]' => 'Testing',
            'servico[categoria]' => 'Testing',
        ]);

        self::assertResponseRedirects('/servico/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Servico();
        $fixture->setNome_servico('My Title');
        $fixture->setDescricao_servico('My Title');
        $fixture->setValor('My Title');
        $fixture->setCategoria('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Servico');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Servico();
        $fixture->setNome_servico('My Title');
        $fixture->setDescricao_servico('My Title');
        $fixture->setValor('My Title');
        $fixture->setCategoria('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'servico[nome_servico]' => 'Something New',
            'servico[descricao_servico]' => 'Something New',
            'servico[valor]' => 'Something New',
            'servico[categoria]' => 'Something New',
        ]);

        self::assertResponseRedirects('/servico/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNome_servico());
        self::assertSame('Something New', $fixture[0]->getDescricao_servico());
        self::assertSame('Something New', $fixture[0]->getValor());
        self::assertSame('Something New', $fixture[0]->getCategoria());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Servico();
        $fixture->setNome_servico('My Title');
        $fixture->setDescricao_servico('My Title');
        $fixture->setValor('My Title');
        $fixture->setCategoria('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/servico/');
    }
}
