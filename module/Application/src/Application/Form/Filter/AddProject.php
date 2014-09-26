<?php
namespace Application\Form\Filter;

use Zend\InputFilter\InputFilter;

class AddProject extends InputFilter
{
    use \Application\Form\Element\Filter\ProjectName;
    use \Application\Form\Element\Filter\Description;
    use \Application\Form\Element\Filter\Tag;
    
    public function __construct() {
        
        $this->add($this->projectName);
        $this->add($this->description);
        $this->add($this->tag);
        
    }
}