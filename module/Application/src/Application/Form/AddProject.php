<?php
namespace Application\Form;

use Zend\Form\Form;

class AddProject extends Form
{
    use \Application\Form\Element\ProjectName;
    use \Application\Form\Element\Description;
    use \Application\Form\Element\Tag;
    
    public function __construct() {
        parent::__construct();
        
        $this->setName('AddProject');
        $this->setAttribute('method', 'post');
        
        $this->add($this->projectName);
        $this->add($this->description);
        $this->add($this->tag);

        $this->add(array(
    		'name' => 'submit',
    		'type' => 'submit',
            'attributes' => array(
    			'class' => 'btn btn-primary',
                'value' => 'Add New Project'
    		),
        ));
    }
}