<?php

namespace Image\Controller;

use Image\Form\ImageForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ImageController extends AbstractActionController
{
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


                // Redirect the user to posts list page.
                return $this->redirect()->toRoute('image');
            }
        }

        return new ViewModel([
            'form' => $form,
        ]);
    }
}