<?php

namespace App\Repository;

use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    public function delete(Theme $theme): void
    {
        $this->_em->remove($theme);
        $this->_em->flush();
    }

    public function findThemeByName(string $name): ?Theme
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function setActive(Theme $theme): void
    {
        $this->save($theme);
    }

    public function save(Theme $theme): void
    {
        $this->_em->persist($theme);
        $this->_em->flush();
    }
}
