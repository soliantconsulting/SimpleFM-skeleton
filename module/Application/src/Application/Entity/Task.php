<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Entity;

use Soliant\SimpleFM\ZF2\Entity\SerializableEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Task;

class Task extends TaskPointer implements SerializableEntityInterface
{
    /**
     * Fields
     */
    protected $description;
    protected $tag;
    
    /**
     * Read-only Fields
     */
    protected $startDate;
    protected $dueDate;
    protected $daysRemaining;
    protected $daysElapsed;
    protected $status;
    protected $statusOnScreen;
    protected $priority;
    protected $priorityOnScreen;
    protected $taskCompletionPercentage;
    protected $personnelName;
    protected $personnelEmail;
    protected $personnelPhone;
    protected $createdBy;

    /**
     * Parent Pointers
     */
    protected $project;

    /**
     * @param array $simpleFMAdapterRow
     */
    public function __construct($simpleFMAdapterRow = array())
    {
        parent::__construct($simpleFMAdapterRow);
    }
    
    /**
     * @param array $simpleFMAdapterRow
     * @see \Soliant\SimpleFM\ZF2\Entity\Serializable::unserialize()
     */
    public function unserialize ($simpleFMAdapterRow = array())
    {
        parent::unserialize($simpleFMAdapterRow);
        
        $this->description                  = $simpleFMAdapterRow["Description"];
        $this->tag                          = $simpleFMAdapterRow["Tag"];
        $this->startDate                    = $simpleFMAdapterRow["Start Date"];
        $this->dueDate                      = $simpleFMAdapterRow["Due Date"];
        $this->daysRemaining                = $simpleFMAdapterRow["Days Remaining"];
        $this->daysElapsed                  = $simpleFMAdapterRow["Days Elapsed"];
        $this->status                       = $simpleFMAdapterRow["Status"];
        $this->statusOnScreen               = $simpleFMAdapterRow["Status on Screen"];
        $this->priority                     = $simpleFMAdapterRow["Priority Number List"];
        $this->priorityOnScreen             = $simpleFMAdapterRow["Priority on Screen"];
        $this->taskCompletionPercentage     = $simpleFMAdapterRow["Task Completion Percentage"];
        $this->createdBy                    = $simpleFMAdapterRow["Created By"];

        $this->personnelName                = $simpleFMAdapterRow["PERSONNEL NAME MATCH FIELD"];
        $this->personnelEmail               = $simpleFMAdapterRow["Personnel::Email"];
        $this->personnelPhone               = $simpleFMAdapterRow["Personnel::Phone"];
    
        if (!empty($simpleFMAdapterRow["Projects"]["rows"])){
            $this->project = new ProjectPointer($simpleFMAdapterRow["Projects"]["rows"][0]);
        }
        
        return $this;
    }
    
    /**
     * @see \Soliant\SimpleFM\ZF2\Entity\Serializable::serialize()
     */
    public function serialize()
    {
        $simpleFMAdapterRow["-recid"]       = $this->getRecid();
        $simpleFMAdapterRow["-modid"]       = $this->getModid();
        $simpleFMAdapterRow["Task Name"]    = $this->getTaskName();
        $simpleFMAdapterRow["Description"]  = $this->getDescription();
        $simpleFMAdapterRow["Tag"]          = $this->getTag();
    
        return $simpleFMAdapterRow;
    }
    
	/**
     * @param field_type $taskName
     * @return \Application\Entity\Task
     */
    public function setTaskName ($taskName)
    {
        $this->taskName = $taskName;
        return $this;
    }

	/**
     * @return the $description
     */
    public function getDescription ()
    {
        return $this->description;
    }

	/**
     * @param field_type $description
     * @return \Application\Entity\Task
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }

	/**
     * @return the $tag
     */
    public function getTag ()
    {
        return $this->tag;
    }

	/**
     * @param field_type $tag
     * @return \Application\Entity\Task
     */
    public function setTag ($tag)
    {
        $this->tag = $tag;
        return $this;
    }
    
	/**
     * @return the $startDate
     */
    public function getStartDate ()
    {
        return $this->startDate;
    }

	/**
     * @return the $dueDate
     */
    public function getDueDate ()
    {
        return $this->dueDate;
    }

	/**
     * @return the $daysRemaining
     */
    public function getDaysRemaining ()
    {
        return $this->daysRemaining;
    }

	/**
     * @return the $daysElapsed
     */
    public function getDaysElapsed ()
    {
        return $this->daysElapsed;
    }

	/**
     * @return the $statusOnScreen
     */
    public function getStatusOnScreen ()
    {
        return $this->statusOnScreen;
    }

	/**
     * @return the $status
     */
    public function getStatus ()
    {
        return $this->status;
    }

	/**
     * @return the $priorityOnScreen
     */
    public function getPriorityOnScreen ()
    {
        return $this->priorityOnScreen;
    }

	/**
     * @return the $priority
     */
    public function getPriority ()
    {
        return $this->priority;
    }

	/**
     * @return the $taskCompletionPercentage
     */
    public function getTaskCompletionPercentage ()
    {
        return $this->taskCompletionPercentage;
    }

	/**
     * @return the $personnelName
     */
    public function getPersonnelName ()
    {
        return $this->personnelName;
    }

	/**
     * @return the $personnelEmail
     */
    public function getPersonnelEmail ()
    {
        return $this->personnelEmail;
    }

	/**
     * @return the $personnelPhone
     */
    public function getPersonnelPhone ()
    {
        return $this->personnelPhone;
    }

	/**
     * @return the $createdBy
     */
    public function getCreatedBy ()
    {
        return $this->createdBy;
    }

	/**
     * @return the $project
     */
    public function getProject ()
    {
        return $this->project;
    }

}

/*
array(7) {
    ["url"] => string(99) "http://Admin:[...]@shn.serveftp.net/fmi/xml/fmresultset.xml?-db=FMServer_Sample&-lay=Tasks&-findany"
            ["error"] => int(0)
            ["errortext"] => string(8) "No error"
            ["errortype"] => string(9) "FileMaker"
            ["count"] => string(1) "1"
            ["fetchsize"] => string(1) "1"
            ["rows"] => array(1) {
                [0] => array(21) {
                    ["index"] => int(0)
                    ["recid"] => int(15005)
                    ["modid"] => int(0)
                    ["Task Completion Bar"] => string(0) ""
                    ["Task Name"] => string(15) "Build prototype"
                    ["Description"] => string(0) ""
                    ["Start Date"] => string(10) "02/16/2012"
                    ["Due Date"] => string(10) "02/17/2012"
                    ["Days Remaining"] => string(1) "0"
                    ["Days Elapsed"] => string(1) "1"
                    ["Time Progression Bar"] => string(99) "/fmi/xml/cnt/Red.png?-db=FMServer_Sample&-lay=Tasks&-recid=15005&-field=Time%20Progression%20Bar(1)"
                    ["PERSONNEL NAME MATCH FIELD"] => string(13) "Robert Martin"
                    ["Task Completion Percentage"] => string(1) "0"
                    ["Created By"] => string(11) "Tim Thomson"
                    ["Tag"] => string(13) "manufacturing"
                    ["Priority Number List"] => string(0) ""
                    ["Priority on Screen"] => string(0) ""
                    ["Status on Screen"] => string(7) "Overdue"
                    ["Personnel::Email"] => string(18) "robert@kristis.com"
                    ["Personnel::Phone"] => string(14) "(415) 555-2525"
                }
            }
        }
    }
}
*/

