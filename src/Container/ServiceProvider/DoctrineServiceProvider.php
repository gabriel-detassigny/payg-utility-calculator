<?php

namespace GabrielDeTassigny\Puc\Container\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\UtilityRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DoctrineServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityManager::class,
        EntityManagerInterface::class,
        UtilityRepository::class
    ];

    /**
     * @throws ORMException
     */
    public function register()
    {
        $config = Setup::createAnnotationMetadataConfiguration([PROJECT_DIR . '/src'], true, null, null, false);
        $dbConnection = ['driver' => 'pdo_sqlite', 'path' => PROJECT_DIR . '/db/db.sqlite'];

        $entityManager = EntityManager::create($dbConnection, $config);

        $container = $this->getLeagueContainer();

        $container->add(EntityManager::class, $entityManager, true);
        $container->add(EntityManagerInterface::class, EntityManager::class);

        $container->add(UtilityRepository::class, $entityManager->getRepository(Utility::class), true);
    }
}