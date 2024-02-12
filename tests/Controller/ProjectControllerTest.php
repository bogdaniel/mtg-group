<?php

namespace App\Test\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/project/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Project::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Project index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'project[name]' => 'Testing',
            'project[yearStarted]' => 'Testing',
            'project[yearEnded]' => 'Testing',
            'project[description]' => 'Testing',
            'project[country]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Project();
        $fixture->setName('My Title');
        $fixture->setYearStarted('My Title');
        $fixture->setYearEnded('My Title');
        $fixture->setDescription('My Title');
        $fixture->setCountry('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Project');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Project();
        $fixture->setName('Value');
        $fixture->setYearStarted('Value');
        $fixture->setYearEnded('Value');
        $fixture->setDescription('Value');
        $fixture->setCountry('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'project[name]' => 'Something New',
            'project[yearStarted]' => 'Something New',
            'project[yearEnded]' => 'Something New',
            'project[description]' => 'Something New',
            'project[country]' => 'Something New',
        ]);

        self::assertResponseRedirects('/project/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getYearStarted());
        self::assertSame('Something New', $fixture[0]->getYearEnded());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getCountry());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Project();
        $fixture->setName('Value');
        $fixture->setYearStarted('Value');
        $fixture->setYearEnded('Value');
        $fixture->setDescription('Value');
        $fixture->setCountry('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/project/');
        self::assertSame(0, $this->repository->count([]));
    }
}
