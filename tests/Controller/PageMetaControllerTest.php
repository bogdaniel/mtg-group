<?php

namespace App\Test\Controller;

use App\Entity\PageMeta;
use App\Repository\PageMetaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageMetaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PageMetaRepository $repository;
    private string $path = '/page/meta/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(PageMeta::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PageMetum index');

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
            'page_metum[title]' => 'Testing',
            'page_metum[slug]' => 'Testing',
            'page_metum[metaTitle]' => 'Testing',
            'page_metum[metaDescription]' => 'Testing',
            'page_metum[page]' => 'Testing',
        ]);

        self::assertResponseRedirects('/page/meta/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new PageMeta();
        $fixture->setTitle('My Title');
        $fixture->setSlug('My Title');
        $fixture->setMetaTitle('My Title');
        $fixture->setMetaDescription('My Title');
        $fixture->setPage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('PageMetum');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new PageMeta();
        $fixture->setTitle('My Title');
        $fixture->setSlug('My Title');
        $fixture->setMetaTitle('My Title');
        $fixture->setMetaDescription('My Title');
        $fixture->setPage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'page_metum[title]' => 'Something New',
            'page_metum[slug]' => 'Something New',
            'page_metum[metaTitle]' => 'Something New',
            'page_metum[metaDescription]' => 'Something New',
            'page_metum[page]' => 'Something New',
        ]);

        self::assertResponseRedirects('/page/meta/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getSlug());
        self::assertSame('Something New', $fixture[0]->getMetaTitle());
        self::assertSame('Something New', $fixture[0]->getMetaDescription());
        self::assertSame('Something New', $fixture[0]->getPage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new PageMeta();
        $fixture->setTitle('My Title');
        $fixture->setSlug('My Title');
        $fixture->setMetaTitle('My Title');
        $fixture->setMetaDescription('My Title');
        $fixture->setPage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/page/meta/');
    }
}
