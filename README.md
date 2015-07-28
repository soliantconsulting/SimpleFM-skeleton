# SimpleFM Skeleton

## About

This application demonstrates use of the [SimpleFM][10]\ZF2 package in the Model layer of a Zend Framework 2 MVC application, using the FileMaker Server 14 FMServer_Sample database as a data provider.

## System Requirements

[SimpleFM][10], the examples and this documentation are tailored for PHP 5.5+ and FileMaker Sever 14

* PHP 5.5+
* FileMaker Server 12+

With minimum effort, it should work with any version of FileMaker server that uses fmresultset.xml grammar, however, this is not recommended.

## License

SimpleFM is free for commercial and non-commercial use, licensed under the business-friendly [standard MIT license][12].

## Basic Setup Instructions

### Installation Options

#### Use Composer

The easiest way to create a new ZF2 project is to use [Composer](https://getcomposer.org/). If you don't have it already installed, then please install as per the [documentation](https://getcomposer.org/doc/00-intro.md).

Create your new ZF2 project:

    composer create-project -n -sdev soliantconsulting/SimpleFM-skeleton path/to/install


#### Download a tarball with a local Composer

If you don't have composer installed globally then another way to create a new ZF2 project is to download the tarball and install it:

1. Download the [tarball](https://github.com/soliantconsulting/SimpleFM-skeleton/tarball/master), extract it and then install the dependencies with a locally installed Composer:

        cd my/project/dir
        curl -#L https://github.com/soliantconsulting/SimpleFM-skeleton/tarball/master | tar xz --strip-components=1
    

2. Download composer into your proejct directory and install the dependencies:

        curl -s https://getcomposer.org/installer | php
        php composer.phar install

If you don't have access to curl, then install Composer into your project as per the [documentation](https://getcomposer.org/doc/00-intro.md).


### Local Development Web Server Setup Options

#### PHP CLI server

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root
directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note:** The built-in CLI server is *for development only*.

#### Vagrant server

This project supports a basic [Vagrant](http://docs.vagrantup.com/v2/getting-started/index.html) configuration with an inline shell provisioner to run the Skeleton Application in a [VirtualBox](https://www.virtualbox.org/wiki/Downloads).

1. Run vagrant up command

        vagrant up

2. Visit [http://localhost:8085](http://localhost:8085) in your browser

Look in [Vagrantfile](Vagrantfile) for configuration details.

#### Host On Existing Web Server

There are many web server options compatible with PHP 5.5+, including Apache, Nginx, and IIS. Setup of other options is beyond the scope of this documentation.

1. Setup a project directory in your development environment with /public defined as a vhost.

### Configuration Tasks

1. Upload `FMServer_Sample_Web.fmp12` to a FileMaker Server 12 host. See [/documentation/README.md][11] for details.
1. Copy `/config/autoload/local.php.dist` as `/config/autoload/local.php` and edit hostname as needed if not using localhost.

After completing these steps successfully, when you visit your vhost in a browser, you should see a success message if everything installed correctly.

## SimpleFM Best practices

### Dedicated FileMaker Web API File

When designing a FileMaker Web API, it is recommended that you use a dedicated FileMaker Web interface file that contains *references* to your main solution, but contains no data of its own. This allows you to clearly separate the Web Layouts and Table Occurrences (TOs) from the FileMaker Pro Layouts and TOs. If you have FileMaker scripts in the main solution that need to be called from your Web application, make wrapper scripts in the Web interface file to maintain a crisp separation of concerns. Maintaining a strict decoupling of your Web API may take a little bit of extra effort in some cases, but is an important best practice.

### Authentication Module

This example includes a demonstration of using the dispatch event to check the session for a valid user identity *before* a controller can render anything for the user, without having to to make the controllers aware of the Authentication module. It also contains an example of Zend\Form and the SimpleFM Identity class to make authentication very easy to bolt on to any ZF2 project.

### MVC (Model View Controller)

ZendFramework 2 provides a robust MVC implementation, as do many PHP frameworks. Use of MVC on PHP web apps is well documented many places on the Web, although much of the attention seems to go to the View and the Controller layers. In part this may be because these two layers are more similar from one appliction to the next, and therefore are more suited to encapsulation in frameworks. MVC frameworks have to leave more of the Model layer up to the developer, as so much of it depends on both the business domain of the application (which will vary widely), and on the persistance technology employed. There are a number of good object oriented PHP model frameworks, such as [Doctrine ORM][3], which incorporate well with MVC frameworks, but ORMs generally rely on a SQL-based DBAL (Database Abstraction Layer), so the FileMaker Server XML API cannot be adapted to work with them.

Even with FileMaker as a given, there is still wide variation in the business domain between projects. FileMaker puts some bounds on this variation by virtue of the fact that a FileMaker solution has a Relationship Graph. The Relationship Graph requires the developer/architect to think in terms of object associations, and provides some strong clues as to what the domain model should be on the Web side of the application.

So ZendFramework 2 has the View and Controller well handled; team it up with SimpleFM to define the domain Model, and you've got three solid legs for a FileMaker-backed MVC Web application.

### Di (Dependency Injection)

MVC is important, but it is ZF2's powerful new DependencyInjection (Di) container that makes it an important evolution of PHP frameworks. Di makes the framework inherently modular and extensible. Using Di, it is simple to extend the core MVC framework and to leverage third-party libraries. Whereas Soliant\SimpleFM\Adapter is a stand-alone component with no inherent external dependencies, the Soliant\SimpleFM\ZF2 package combines ZF2 with SimpleFM\Adapter and mixes in some Doctrine where common OOP object modeling problems have already been solved.

### Domain Driven Design

In a Web application that will use the FileMaker XML API, the architect needs to define Web domain objects that represent the FileMaker domain model as defined in the FileMaker Relationship Graph. In Doctrine ORM, [domain objects are referred to as Entities][4], and we will borrow that term here. Defining an Entity for each table allows you to cast your FileMaker data as objects with specific associations to each other that follow the domain associations defined in the FileMaker Relationship Graph. If you don't develop a domain model on the PHP side, you will be forced to juggle untyped arrays of strings that have no inherent associations with each other. This may be fine for very simple Web applications, but the initial investment in setting up your model is fairly low, so even for small projects it is probably worth while. Managing the domain model on the PHP side also allows you to cast your Entity properties. For example, you can cast object properties as dates, numbers, collections, etc.

#### Domain Objects (Entities)

Generally you will define one Entity per FileMaker table, but the FileMaker XML API does not give us direct access to tables. Instead we use Layouts in a manner roughly analogous to SQL views and, properly used, they can be used as Gateways to the domain model in FileMaker. For example, consider Project and Task from FMServer_Sample:

    class Project
    {
        // Fields
        protected $name;
        protected $description;
        
        // Associations
        protected $tasks;
        
        /**
         *  getters and setters
         */
    }
    
    class Task
    {
        // Fields
        protected $name;
        protected $description;
        protected $status;
        
        // Associations
        protected $project;
        
        /**
         *  getters and setters
         */
    }

#### Table Data Gateways (Gateways)

> Table Data Gateway: An object that acts as a [Gateway][8] to a database table. One instance handles all the rows in the table. ([Fowler, PoEAA, TableDataGateway][6]).

Designate a FileMaker Layout for each Entity in your PHP domain model. A Table Data Gateway class (hereafter just Gateway) links an Entity to the Layout(s) that provide access to the Table. Additional Layouts may be defined for an entity (see next section), but a minimum of one is required by the `AbstractEntity::getDefaultWriteLayoutName()` abstract static method.

Example: given a *Person* Table in FileMaker, define the default layout for the PersonGateway:

    public static function getDefaultWriteLayoutName()
    {
    	return 'Person';
    }

In the Project example shown here, additional library dependencies are assumed to be defined in `AbstractGateway`<sup>[1](#footnote1)</sup>. These dependencies and several helper methods are omitted from the example for clarity.

`AbstractGateway` provides all the basic database interaction methods shown here. They are shown as methods of `Application\Gateway\Project` to illustrate the main point of a Gateway. When you implement the domain model for a Gateway, use the methods provided by `AbstractGateway` as-is or override any of them with your own custom logic, and create any additional custom methods needed to support your domain model. The point is to encapsulate the inner workings of the FileMaker API in your Gateway classes, and let your ZF2 application focus only on the OO methods it needs to work with Entities. There should be no direct use of FileMaker API commands outside of the Gateway classes.

    <?php
    
    namespace Application\Gateway;
    
    use Soliant\SimpleFM\ZF2\AbstractGateway;
    use Application\Entity\Project;

    class Project extends AbstractGateway
    {
    
	    public function resolveEntity(AbstractEntity $entity, $entityLayout=NULL)
	    {
	        if (!empty($entityLayout)){
	            $this->setEntityLayout($entityLayout);
	        }
	        return $this->find($entity->getRecid());
	    }
        
        public function find($recid)
        {
            // Call FileMaker API via SimpleFMAdapter and unserialize as Project entity
        }
        
        public function findAll(array $sort = array(), $max = NULL, $skip = NULL)
        {
            // Call FileMaker API via SimpleFMAdapter and unserialize as Project ArrayCollection
        }
        
        public function findBy(array $search, array $sort = array(), $max = NULL, $skip = NULL)
        {
            // Call FileMaker API via SimpleFMAdapter and unserialize as Project ArrayCollection
        }
        
        public function create(Project $entity)
        {   
            // Call FileMaker API via SimpleFMAdapter and unserialize as Project entity
        }
        
        public function edit(Project $entity)
        {   
            // Call FileMaker API via SimpleFMAdapter and unserialize as Project entity
        }
        
        public function delete(Project $entity)
        {
            // Call FileMaker API via SimpleFMAdapter and return TRUE on success
        }
    }

#### Optimizing Gateway Requests With Custom FileMaker Layouts

Data from all the fields included on a Filemaker Layout are always returned when the Layout is called by the API. There is no programatic way to modify which columns are returned, short of using a different Layout. You don't want to be forced to eagerly load the whole object in all circumstances. It can be useful to maintain one or more alternate layouts that are sub or super sets of the default fields that comprise an Entity class. For example you might define an EntityList Layout which contains the minimum properties required to identify an Entity, e.g. name, and primary key, and can be used when lazy loading is preferable. As the EntityList is an incomplete representation of the Entity, any instance retrieved with it must be treated as read-only, and the AbstractGateway provides a method for resolving the Entity from an incomplete Layout. For instance, if you specify the EntityList Layout to generate a list view, you can pass a sparse Entity instance from that collection to the resolveEntity() method on the EntityGateway, and it will make a request for that entity and return it with a serializable field set:

        // retrieve the gateway and specify a sparse layout
        $gatewayProject = $this->getServiceLocator()->get('gateway_project');
        $gatewayProject->setEntityLayout('ProjectList');
        
        // execute the request
        $projects = $gatewayProject->findAll();
        
        // pick one of the result records and resolve just that record with a second request on a full layout
        $sparseProject = $projects[0];
        $fullProject = $gatewayProject->resolveEntity($sparseProject, 'Project');

[1]: http://www.soliantconsulting.com
[2]: http://www.filemaker.com/products/filemaker-server/
[3]: http://www.doctrine-project.org/
[4]: http://docs.doctrine-project.org/projects/doctrine-orm/en/2.0.x/reference/architecture.html
[6]: http://martinfowler.com/eaaCatalog/tableDataGateway.html
[8]: http://martinfowler.com/eaaCatalog/gateway.html
[9]: http://getcomposer.org
[10]: https://github.com/soliantconsulting/SimpleFM
[11]: https://github.com/soliantconsulting/SimpleFM-skeleton/blob/master/documentation/README.md
[12]: https://github.com/soliantconsulting/SimpleFM-skeleton/blob/master/LICENSE.txt

# Footnotes

<a name="footnote1">1</a>: See [Soliant\SimpleFM\ZF2\Gateway\AbstractGateway](https://github.com/soliantconsulting/SimpleFM/blob/master/library/Soliant/SimpleFM/ZF2/Gateway/AbstractGateway.php) for complete details.
