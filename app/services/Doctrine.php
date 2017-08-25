<?php

namespace app\services;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Class Doctrine
 */
class Doctrine
{
    /**
     * @var EntityManager
     */
    public $entityManager;

    public function __construct($config, $annotation, $isDevMode)
    {
        $annotationConfig = Setup::createAnnotationMetadataConfiguration($annotation, $isDevMode);

        $this->entityManager = EntityManager::create($config, $annotationConfig);
    }
}
