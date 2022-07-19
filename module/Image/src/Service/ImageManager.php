<?php

namespace Image\Service;

use Doctrine\ORM\EntityManager;
use Image\Entity\Image;

class ImageManager
{
    /**
     * Doctrine entity manager.
     * @var EntityManager
     */
    private $entityManager;

    // Constructor is used to inject dependencies into the service.
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addNewImage($data)
    {
        $image = new Image();
        $image->setName($data['name']);
        $image->setCreatedAt(date('Y-m-d H:i:s'));

        $this->entityManager->persist($image);

        $this->entityManager->flush();
    }
}