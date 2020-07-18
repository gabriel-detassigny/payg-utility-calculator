<?php

namespace GabrielDeTassigny\Puc\Container\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DoctrineServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityManager::class,
        EntityManagerInterface::class
    ];

    /**
     * @throws ORMException
     */
    public function register()
    {
        $config = Setup::createAnnotationMetadataConfiguration([PROJECT_DIR . '/src'], true, null, null, false);
        $dbConnection = ['driver' => 'pdo_sqlite', 'path' => PROJECT_DIR . '/db/db.sqlite'];

        $entityManager = EntityManager::create($dbConnection, $config);

        $this->getLeagueContainer()->add($entityManager, true, true);
        $this->getLeagueContainer()->add(EntityManagerInterface::class, EntityManager::class);
    }
}