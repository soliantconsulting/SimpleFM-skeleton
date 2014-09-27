<?php
namespace Application\Form\Element\Filter;

trait Tag
{
    protected $tag = array(
		'name' => 'tag',
		'required' => true,
        'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
        ),
    );
}