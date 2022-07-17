<?php

namespace Image\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;

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

        $inputFilter->add([
            'name'     => 'image',
            'required' => true,
            'filters'  => [
            ],
//            'validators' => [
//                [
//                    'name'    => 'Size',
//                    'options' => [
//                        'max' => '2MB',
//                    ],
//                ],
//            ],
        ]);
    }
}