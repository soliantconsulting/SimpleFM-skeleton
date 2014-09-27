<?php
namespace Application\Form\Element\Filter;

trait Description
{
    protected $description = array(
		'name' => 'description',
		'required' => true,
        'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
        ),
    );
}