<?php

namespace Image\Form;

use Image\Entity\Image;
use Laminas\Filter\File\RenameUpload;
use Laminas\Form\Form;
use Laminas\InputFilter\FileInput;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\File\Extension;
use Laminas\Validator\File\IsImage;
use Laminas\Validator\File\MimeType;
use Laminas\Validator\File\Size;
use Laminas\Validator\File\UploadFile;

class ImageForm extends Form
{
    public function __construct()
    {
        // Define form name
        parent::__construct('image-form');

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "image" field
        $this->add([
            'type'  => 'file',
            'name' => 'image',
            'attributes' => [
                'id' => 'image'
            ],
            'options' => [
                'label' => 'Image',
            ],
        ]);

        // Add the submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Add',
                'id' => 'submit',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add validation rules for the "image" field.
        $inputFilter->add([
            'type'     => FileInput::class,
            'name'     => 'image',
            'required' => true,
            'validators' => [
                [
                    'name'    => UploadFile::class,
                ],
                [
                    'name'    => IsImage::class,
                    'options' => [
                        'message' => 'File should be image',
                    ],
                ],
                [
                    'name'    => MimeType::class,
                    'options' => [
                        'mimeType'  => ['image/jpeg', 'image/png'],
                        'message' => 'File type not match',
                    ]
                ],
                [
                    'name' => Extension::class,
                    'options' => [
                        'extension' => ['jpg', 'png'],
                        'message' => 'File extension not match',
                    ],
                ],
                [
                    'name'    => Size::class,
                    'options' => [
                        'max' => '2MB',
                        'message' => 'File size is too large',
                    ],
                ],
            ],
            'filters'  => [
                // Rename and move uploaded file
                [
                    'name' => RenameUpload::class,
                    'options' => [
                        'target' => 'public/' . Image::IMAGE_DIR,
                        'useUploadName' => false,
                        'useUploadExtension' => true,
                        'overwrite' => true,
                        'randomize' => true,
                    ]
                ]
            ],
        ]);
    }
}