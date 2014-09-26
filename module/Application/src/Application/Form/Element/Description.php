<?php
namespace Application\Form\Element;

trait Description
{
    protected $description = array(
		'name' => 'description',
		'type' => 'text',
		'options' => array(
			'label' => 'Description: ',
		),
        'attributes' => array(
			'class' => 'form-control',
		),
    );
}