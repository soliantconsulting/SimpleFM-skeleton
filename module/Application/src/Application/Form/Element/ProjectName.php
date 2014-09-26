<?php
namespace Application\Form\Element;

trait ProjectName
{
    protected $projectName = array(
		'name' => 'project_name',
		'type' => 'text',
		'options' => array(
			'label' => 'Project Name: ',
		),
        'attributes' => array(
			'class' => 'form-control',
		),
    );
}