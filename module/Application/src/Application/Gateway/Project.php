<?php
/**
 * SimpleFM-skeleton
 * @author jsmall@soliantconsulting.com
 */

namespace Application\Gateway;

use Soliant\SimpleFM\ZF2\Gateway\AbstractGateway;

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

