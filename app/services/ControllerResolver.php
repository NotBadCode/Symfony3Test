<?php

namespace app\services;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ControllerResolver extends \Symfony\Component\HttpKernel\Controller\ControllerResolver
{
    protected $container;

    public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
    {
        $this->container = $container;

        parent::__construct($logger);
    }

    protected function createController($controller)
    {
        if (false === strpos($controller, '::')) {
            throw new \InvalidArgumentException(sprintf('Unable to find controller "%s".', $controller));
        }

        list($class, $method) = explode('::', $controller, 2);

        if (!class_exists($class)) {
            if (!$this->container->has($class)) {
                throw new \InvalidArgumentException(sprintf('Class "%s" does not exist.', $class));
            }
            $controller = $this->container->get($class);

            return [$controller, $method];
        }

        $controller = new $class();
        if ($controller instanceof ContainerAwareInterface) {
            $controller->setContainer($this->container);
        }

        return [$controller, $method];
    }
}