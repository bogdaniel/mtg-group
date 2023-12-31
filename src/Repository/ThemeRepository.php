<?php
declare(strict_types=1);

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
        $this->getEntityManager()->remove($theme);
        $this->getEntityManager()->flush();
    }

    public function findThemeByName(string $name): ?Theme
    {
        return $this->findOneBy(['name' => $name]);
    }


    public function save(Theme $theme): void
    {
        $this->getEntityManager()->persist($theme);
        $this->getEntityManager()->flush();
        $this->getEntityManager()->refresh($theme);

    }
}
