<?php

namespace Image\Controller\Factory;

use Image\Controller\ImageController;
use Image\Service\ImageManager;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class ImageControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new ImageController(
            $container->get('doctrine.entitymanager.orm_default'),
            $container->get(ImageManager::class
            ));
    }
}