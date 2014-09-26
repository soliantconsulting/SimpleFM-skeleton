<?php
namespace Application\Form\Element\Filter;

trait ProjectName
{
    protected $projectName = array(
		'name' => 'project_name',
		'required' => true,
        'filters' => array(
            array('name' => 'StripTags'),
            array('name' => 'StringTrim'),
        ),
    );
}