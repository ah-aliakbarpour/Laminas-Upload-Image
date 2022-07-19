<?php

namespace Image\Controller;

use Doctrine\ORM\EntityManager;
use Image\Entity\Image;
use Image\Form\ImageForm;
use Image\Service\ImageManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ImageController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Post manager.
     * @var ImageManager
     */
    private $imageManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */
    public function __construct(EntityManager $entityManager, ImageManager $imageManager)
    {
        $this->entityManager = $entityManager;
        $this->imageManager = $imageManager;
    }

    public function indexAction()
    {
        $images = $this->entityManager->getRepository(Image::class)
            ->findAll();

        return new ViewModel([
            'images' => $images,
        ]);
    }

    public function addAction()
    {
        $form = new ImageForm();

        $request = $this->getRequest();

        if ($request->isPost()) {

            // Make certain to merge the $_FILES info!
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            // Fill form with data.
            $form->setData($data);
            if ($form->isValid()) {

                // Get validated form data.
                $data = $form->getData();

                // Extract image name
                $imagePath = explode('/', $data['image']['tmp_name']);
                $imageName = end($imagePath);

                $this->imageManager->addNewImage(['name' => $imageName]);

                // Redirect the user to posts list page.
                return $this->redirect()->toRoute('image');
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }
}