<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Entity;

use Soliant\SimpleFM\ZF2\Entity\SerializableEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Application\Entity\Task;

class Project extends ProjectPointer implements SerializableEntityInterface
{
    
    /**
     * Fields
     */
    protected $projectName;
    protected $description;
    protected $tag;
    
    /**
     * Read-only Fields
     */
    protected $id;
    protected $startDate;
    protected $dueDate;
    protected $daysRemaining;
    protected $daysElapsed;
    protected $statusOnScreen;
    protected $createdBy;

    // Child Pointers
    protected $tasks;

    public function __construct($simpleFMAdapterRow = array())
    {
        $this->tasks = new ArrayCollection();
        parent::__construct($simpleFMAdapterRow);
    }
    
    /**
     * @param array $simpleFMAdapterRow
     * @see \Soliant\SimpleFM\ZF2\Entity\Serializable::unserialize()
     */
    public function unserialize ($simpleFMAdapterRow = array())
    {
        $this->recid                        = $simpleFMAdapterRow["recid"];
        $this->modid                        = $simpleFMAdapterRow["modid"];
        $this->id                           = $simpleFMAdapterRow["PROJECT ID MATCH FIELD"];
        $this->projectName                  = $simpleFMAdapterRow["Project Name"];
        $this->description                  = $simpleFMAdapterRow["Description"];
        $this->tag                          = $simpleFMAdapterRow["Tag"];
        $this->startDate                    = $simpleFMAdapterRow["Start Date"];
        $this->dueDate                      = $simpleFMAdapterRow["Due Date"];
        $this->daysRemaining                = $simpleFMAdapterRow["Days Remaining"];
        $this->daysElapsed                  = $simpleFMAdapterRow["Days Elapsed"];
        $this->statusOnScreen               = $simpleFMAdapterRow["Status on Screen"];
        $this->createdBy                    = $simpleFMAdapterRow["Created By"];
        
        if (!empty($simpleFMAdapterRow["Tasks"]["rows"])){
            foreach ($simpleFMAdapterRow["Tasks"]["rows"] as $row){
                $this->tasks[] = new TaskPointer($row);
            }
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
        $simpleFMAdapterRow["Project Name"] = $this->getProjectName();
        $simpleFMAdapterRow["Description"]  = $this->getDescription();
        $simpleFMAdapterRow["Tag"]          = $this->getTag();
    
        return $simpleFMAdapterRow;
    }

    /**
     * @see \Soliant\SimpleFM\ZF2\Entity\AbstractEntity::getName()
     */
    public function getName()
    {
        return $this->getProjectName();
    }
    
	/**
     * @return the $projectName
     */
    public function getProjectName ()
    {
        return $this->projectName;
    }

	/**
     * @param array $projectName
     * @return \Application\Entity\Task
     */
    public function setProjectName ($projectName)
    {
        $this->projectName = $projectName;
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
     * @param array $description
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
     * @param array $tag
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
     * @return the $createdBy
     */
    public function getCreatedBy ()
    {
        return $this->createdBy;
    }

	/**
     * @return the $projectCompletionProgressBar
     */
    public function getProjectCompletionProgressBar ()
    {
        return $this->projectCompletionProgressBar;
    }

	/**
     * @return the $tasks
     */
    public function getTasks ()
    {
        return $this->tasks;
    }

    
    

}

/*
array(7) {
    ["url"] => string(102) "http://Admin:[...]@shn.serveftp.net/fmi/xml/fmresultset.xml?-db=FMServer_Sample&-lay=Projects&-findany"
    ["error"] => int(0)
    ["errortext"] => string(8) "No error"
    ["errortype"] => string(9) "FileMaker"
    ["count"] => string(1) "1"
    ["fetchsize"] => string(1) "1"
    ["rows"] => array(1) {
        [0] => array(15) {
            ["index"] => int(0)
            ["recid"] => int(7676)
            ["modid"] => int(5)
            ["Project Completion Progress Bar"] => string(114) "/fmi/xml/cnt/Red.png?-db=FMServer_Sample&-lay=Projects&-recid=7676&-field=Project%20Completion%20Progress%20Bar(1)"
            ["Tag"] => string(9) "marketing"
            ["Start Date"] => string(10) "04/13/2011"
            ["Due Date"] => string(10) "05/02/2012"
            ["Days Remaining"] => string(1) "0"
            ["Days Elapsed"] => string(3) "275"
            ["Description"] => string(59) "Launch the web site with our new branding and product line."
            ["Project Name"] => string(15) "Launch web site"
            ["Status on Screen"] => string(7) "Overdue"
            ["Created By"] => string(11) "Tim Thomson"
            ["Tasks"] => array(5) {
                ["parentindex"] => int(0)
                ["parentrecid"] => int(7676)
                ["portalindex"] => int(0)
                ["portalrecordcount"] => int(5)
                ["rows"] => array(5) {
                    [0] => array(10) {
                        ["index"] => int(0)
                        ["modid"] => int(0)
                        ["recid"] => int(14999)
                        ["Start Date"] => string(10) "03/19/2012"
                                ["Due Date"] => string(10) "05/02/2012"
                                        ["Task Completion Bar"] => string(113) "/fmi/xml/cnt/Red.png?-db=FMServer_Sample&-lay=Projects&-recid=7676&-field=Tasks::Task%20Completion%20Bar(1).14999"
                                                ["Task Name"] => string(15) "Site map sketch"
                                                        ["PERSONNEL NAME MATCH FIELD"] => string(11) "Ann Johnson"
                                                                ["Task Completion Percentage"] => string(2) "80"
                                                                        ["Tag"] => string(6) "design"
                    }
                    [1] => array(10) {
                        ["index"] => int(1)
                        ["modid"] => int(0)
                        ["recid"] => int(15000)
                        ["Start Date"] => string(10) "04/04/2012"
                                ["Due Date"] => string(10) "04/05/2012"
                                        ["Task Completion Bar"] => string(0) ""
                                                ["Task Name"] => string(18) "Send art to vendor"
                                                        ["PERSONNEL NAME MATCH FIELD"] => string(12) "Frank Rankin"
                                                                ["Task Completion Percentage"] => string(1) "0"
                                                                        ["Tag"] => string(3) "art"
                    }
                    [2] => array(10) {
                        ["index"] => int(2)
                        ["modid"] => int(0)
                        ["recid"] => int(15001)
                        ["Start Date"] => string(10) "04/13/2011"
                                ["Due Date"] => string(10) "04/30/2011"
                                        ["Task Completion Bar"] => string(113) "/fmi/xml/cnt/Red.png?-db=FMServer_Sample&-lay=Projects&-recid=7676&-field=Tasks::Task%20Completion%20Bar(1).15001"
                                                ["Task Name"] => string(15) "Review mock ups"
                                                        ["PERSONNEL NAME MATCH FIELD"] => string(11) "Tim Thomson"
                                                                ["Task Completion Percentage"] => string(2) "50"
                                                                        ["Tag"] => string(3) "art"
                    }
                    [3] => array(10) {
                        ["index"] => int(3)
                        ["modid"] => int(0)
                        ["recid"] => int(15002)
                        ["Start Date"] => string(10) "03/20/2012"
                                ["Due Date"] => string(10) "03/30/2012"
                                        ["Task Completion Bar"] => string(113) "/fmi/xml/cnt/Red.png?-db=FMServer_Sample&-lay=Projects&-recid=7676&-field=Tasks::Task%20Completion%20Bar(1).15002"
                                                ["Task Name"] => string(15) "Write page text"
                                                        ["PERSONNEL NAME MATCH FIELD"] => string(11) "Ann Johnson"
                                                                ["Task Completion Percentage"] => string(2) "80"
                                                                        ["Tag"] => string(0) ""
                    }
                    [4] => array(10) {
                        ["index"] => int(4)
                        ["modid"] => int(0)
                        ["recid"] => int(15003)
                        ["Start Date"] => string(10) "03/20/2012"
                                ["Due Date"] => string(10) "03/29/2012"
                                        ["Task Completion Bar"] => string(113) "/fmi/xml/cnt/Red.png?-db=FMServer_Sample&-lay=Projects&-recid=7676&-field=Tasks::Task%20Completion%20Bar(1).15003"
                                                ["Task Name"] => string(12) "New logo art"
                                                        ["PERSONNEL NAME MATCH FIELD"] => string(12) "Frank Rankin"
                                                                ["Task Completion Percentage"] => string(2) "30"
                                                                        ["Tag"] => string(3) "art"
                    }
                }
            }

        }
    }
}
*/

