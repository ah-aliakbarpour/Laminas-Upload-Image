<?php

namespace Image\Service\Factory;

use Image\Service\ImageManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ImageManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ImageManager($container->get('doctrine.entitymanager.orm_default'));
    }
}