<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Entity;

use Soliant\SimpleFM\ZF2\Entity\AbstractEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Task;


class TaskPointer extends AbstractEntity
{
    
    /**
     * Fields
     */
    protected $taskName;
    
    /**
     * Read-only Fields
     */
    protected $id;

    /**
     * @see \Soliant\SimpleFM\ZF2\Entity\AbstractEntity::getName()
     */
    public function getName(){
        return $this->getTaskName();
    }

	/**
     * @return the $taskName
     */
    public function getTaskName ()
    {
        return $this->taskName;
    }

	/**
     * @see \Soliant\SimpleFM\Entity\AbstractEntity::unserialize()
     */
    public function unserialize ($simpleFMAdapterRow = array())
    {
        
        $this->recid                        = $simpleFMAdapterRow["recid"];
        $this->modid                        = $simpleFMAdapterRow["modid"];
        $this->id                           = $simpleFMAdapterRow["TASK ID MATCH FIELD"];
        $this->taskName                     = $simpleFMAdapterRow["Task Name"];

        return $this;
    }
    
    /**
     * @see \Soliant\SimpleFM\ZF2\Entity\AbstractEntity::getControllerAlias()
     */
    function getControllerAlias()
    {
        return 'task';
    }

    /**
     * @see \Soliant\SimpleFM\ZF2\Entity\AbstractEntity::getEntityPointerName()
     */
    function getEntityPointerName()
    {
        return '\Application\Entity\TaskPointer';
    }
     
    /**
     * @see \Soliant\SimpleFM\ZF2\Entity\AbstractEntity::getEntityName()
     */
    function getEntityName()
    {
        return '\Application\Entity\Task';
    }

}