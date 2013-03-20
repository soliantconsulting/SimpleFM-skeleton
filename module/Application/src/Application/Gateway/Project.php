<?php
/**
 * SimpleFM_FMServer_Sample
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Gateway;

use Soliant\SimpleFM\ZF2\Gateway\AbstractGateway;
use Application\Entity\ProjectPointer;
use Application\Entity\Project as ProjectEntity;

class Project extends AbstractGateway
{

    public function helloWorld() {

        $project = $this->find(7676);

        $project->setProjectName('Launch web site ' . $project->getModid())
            ->setDescription('myDescription')
            ->setTag('myTag');

        return $this->edit($project);

    }

}

