<?php
namespace Application\Form\Element;

trait Tag
{
    protected $tag = array(
		'name' => 'tag',
		'type' => 'text',
		'options' => array(
			'label' => 'Tag: ',
		),
        'attributes' => array(
			'class' => 'form-control',
		),
    );
}