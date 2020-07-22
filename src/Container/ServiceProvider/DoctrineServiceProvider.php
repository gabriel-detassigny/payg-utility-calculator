<?php

namespace GabrielDeTassigny\Puc\Container\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use GabrielDeTassigny\Puc\Entity\Reading;
use GabrielDeTassigny\Puc\Entity\Utility;
use GabrielDeTassigny\Puc\Repository\ReadingRepository;
use GabrielDeTassigny\Puc\Repository\UtilityRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class DoctrineServiceProvider extends AbstractServiceProvider
{
    private const REPOSITORIES = [
        UtilityRepository::class => Utility::class,
        ReadingRepository::class => Reading::class
    ];

    protected $provides = [
        EntityManager::class,
        EntityManagerInterface::class
    ];

    public function __construct()
    {
        $this->provides = array_merge($this->provides, array_keys(self::REPOSITORIES));
    }

    /**
     * @throws ORMException
     */
    public function register()
    {
        $config = Setup::createAnnotationMetadataConfiguration([PROJECT_DIR . '/src'], true, null, null, false);
        $dbConnection = ['driver' => 'pdo_sqlite', 'path' => PROJECT_DIR . '/db/db.sqlite3'];

        $entityManager = EntityManager::create($dbConnection, $config);

        $container = $this->getLeagueContainer();

        $container->add(EntityManager::class, $entityManager, true);
        $container->add(EntityManagerInterface::class, $container->get(EntityManager::class));

        foreach (self::REPOSITORIES as $repository => $entity) {
            $container->add($repository, $entityManager->getRepository($entity), true);
        }
    }
}