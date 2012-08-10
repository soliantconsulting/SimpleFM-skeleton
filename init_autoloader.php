<?php

/**
 * This autoloading setup is a simplified version of the one the ships with the ZendSkeletonApplication
 * @author jsmall@soliantconsulting.com
 */

include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Adapter.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Version.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Exception/ExceptionInterface.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Exception/ErrorException.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Exception/FileMakerException.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Exception/HttpException.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/Exception/XmlException.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/ZF2/Entity/EntityInterface.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/ZF2/Entity/SerializableEntityInterface.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/ZF2/Entity/AbstractEntity.php';
include 'vendor/soliantconsulting/SimpleFM/library/Soliant/SimpleFM/ZF2/Gateway/AbstractGateway.php';
include 'vendor/doctrine/common/lib/Doctrine/Common/Collections/Collection.php';
include 'vendor/doctrine/common/lib/Doctrine/Common/Collections/Selectable.php';
include 'vendor/doctrine/common/lib/Doctrine/Common/Collections/ArrayCollection.php';
include 'vendor/zendframework/library/Zend/Loader/AutoloaderFactory.php';
Zend\Loader\AutoloaderFactory::factory(array(
    'Zend\Loader\StandardAutoloader' => array(
        'autoregister_zf' => true
    )
));