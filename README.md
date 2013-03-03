# SimpleFM_FMServer_Sample

## About

This application demonstrates use of the [SimpleFM][10]\ZF2 package as the Model layer of a Zend Framework 2 MVC application, using the FileMaker Server 12 FMServer_Sample database as a data provider.

## System Requirements

[SimpleFM][10], the examples and this documentation are tailored for PHP 5.3 and FileMaker Sever 12

* PHP 5.3+
* FileMaker Server 12+

With minimum effort, you could get them to work with PHP 5.0 (requires SimpleXML) and any version of FileMaker server that uses fmresultset.xml grammar, however, backward compatibility is not maintained.

## License

SimpleFM is free for commercial and non-commercial use, licensed under the business-friendly standard MIT license.

## Basic Setup Instructions

1. Setup a project directory in your development environment with /public defined as a vhost.
2. Git clone https://github.com/soliantconsulting/SimpleFM_FMServer_Sample.git in your project directory.
3. Upload FMServer_Sample_Web.fmp12 to a FileMaker Server 12. See /documentation/README.md for details.
4. Copy /public/.htaccess.dist as /public/.htaccess.
5. Copy /config/autoload/local.php.dist as /config/autoload/local.php and edit hostname as needed.
6. In your project directory, run `sudo ./composer.phar install` on the command line. See [getcomposer.org][9] for details

After completing these steps successfully, when you visit your vhost in a browser, you should see a success message if everying installed correctly.

## SimpleFM Best practices

### Dedicated FileMaker Web API File

When designing a FileMaker Web API, it is recommended that you use a dedicated FileMaker Web interface file that contains *references* to your main solution, but contains no data of its own. This allows you to clearly separate the Web Layouts and Table Occurrences (TOs) from the FileMaker Pro Layouts and TOs. If you have FileMaker scripts in the main solution that need to be called from your Web application, make wrapper scripts in the Web interface file to maintain a crisp separation of concerns. Maintaining a strict decoupling of your Web API may take a little bit of extra effort in some cases, but is an important best practice.

### MVC (Model View Controller)

ZendFramework 2 provides a robust MVC implementation, as do many PHP frameworks. Use of MVC on PHP web apps is well documented many places on the Web, although much of the attention seems to go to the View and the Controller layers. In part this may be because these two layers are more similar from one appliction to the next, and therefore are more suited to encapsulation in frameworks. MVC frameworks have to leave more of the Model layer up to the developer, as so much of it depends on both the business domain of the application (which will vary widely), and on the persistance technology employed. There are a number of good object oriented PHP model frameworks, such as [Doctrine ORM][3], which incorporate well with MVC frameworks, but ORMs generally rely on a SQL-based DBAL (Database Abstraction Layer), so the FileMaker Server XML API cannot be adapted to work with them.

Even with FileMaker as a given, there is still wide variation in the business domain between projects. FileMaker puts some bounds on this variation by virtue of the fact that a FileMaker solution has a Relationship Graph. The Relationship Graph requires the developer/architect to think in terms of object associations, and provides some strong clues as to what the domain model should be on the Web side of the application.

So ZendFramework 2 has the View and Controller well handled; team it up with SimpleFM to define the domain Model, and you've got three solid legs for a FileMaker-backed MVC Web application.

### Di (Dependency Injection)

MVC is important, but it is ZF2's powerful new DependencyInjection (Di) container that makes it an important evolution of PHP frameworks. Di makes the framework inherently modular and extensible. Using Di, it is simple to extend the core MVC framework and to leverage third-party libraries. Whereas Soliant\SimpleFM\Adapter is a stand-alone component with no inherent external dependencies, the Soliant\SimpleFM\ZF2 package combines ZF2 with SimpleFM\Adapter and mixes in some Doctrine where common OOP object modeling problems have already been solved.

### Domain Driven Design

In a Web application that will use the FileMaker XML API, the architect needs to define Web domain objects that represent the FileMaker domain model as defined in the FileMaker Relationship Graph. In Doctrine ORM, [domain objects are referred to as Entities][4], and we will borrow that term here. Defining an Entity for each table allows you to cast your FileMaker data as objects with specific associations to each other that follow the domain associations defined in the FileMaker Relationship Graph. If you don't develop a domain model on the PHP side, you will be forced to juggle untyped arrays of strings that have no inherent associations with each other. This may be fine for very simple Web applications, but the initial investment in setting up your model is fairly low, so even for small projects it is probably worth while. Managing the domain model on the PHP side also allows you to cast your Entity properties. For example, you can cast object properties as dates, numbers, collections, etc.

#### Domain Objects (Entity)

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

#### Table Data Gateways (Gateway)

Designate a FileMaker Layout for each Entity in your PHP domain model. A Table Data Gateway class (hereafter just Gateway) links an Entity to the Layout that each owns. Additional layous may be defined for an entity (see next section), but a minimum of one is required.

Example: given a *Person* table in FileMaker, define a Layout for the PersonGateway: *Person*

> Table Data Gateway: An object that acts as a [Gateway][8] to a database table. One instance handles all the rows in the table. ([Fowler, PoEAA, TableDataGateway][6]).

In the Project example shown below, additional library dependencies are assumed to be defined in `Soliant\SimpleFM\ZF2\Gateway\AbstractGateway`. The constructor requires an instance of `Zend\ServiceManager`, `Soliant\SimpleFM\ZF2\Entity\AbstractEntity`, `Soliant\SimpleFM\Adapter`, injected via a factory closure in the service_manager section of module.config.php. `AbstractGateway` also requires `Doctrine\Common\Collections\ArrayCollection`. These dependencies and several helper methods are not shown in the example for clarity.

In addition to the dependencies, `AbstractGateway` provides all the basic database interaction methods shown here. They are included as methods of `Application\Gateway\Project` to illustrate the main point of a Gateway. When you implement the domain model for a Gateway, use the methods provided by `AbstractGateway` as-is or override any of them with custom domain logic. And of course you can create any new methods needed to support your domain model. The point is to encapsulate the inner workings of the FileMaker API in your Gateway classes, and let your ZF2 application focus only on the OO methods it needs to work with Entities.

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

#### Optimizing Gatway Requests With Custom FileMaker Layouts

Data from all the fields included on a Filemaker Layout are always returned when the Layout is called by the API. As there is no programatic way to modify which columns are returned, short of changing Layouts. You don't want to be forced to eagerly load the whole object in all circumstances. It can be useful to maintain one or more alternate layouts that are sub or super sets of the default fields that comprise an Entity class. For example you might define an EntityPointer layout which contains the minimum properties required to identify an Entity, e.g. name, and primary key, and can be used when lazy loading is preferable. As the EntityPointer is an incomplete representation of the Entity, it must be treated as read-only, and the Table Data Gateway interface (see next section) provides a method for resolving the Entity from a non-standard layout resonse. For instance, if you specify the EntityPointer layout to generate a list view, you can pass an Entity instance from that collection to the resolveEntity() method on the EntityGateway, and it will make a request for that entity and return it with a more complete field set:

        // retrieve the gateway and specify a stripped down Pointer layout
        $gatewayProject = $this->getServiceLocator()->get('gateway_project');
        $gatewayProject->setEntityLayout('ProjectPointer');
        
        // execute the request
        $projects = $gatewayProject->findAll();
        
        // pick one of the result records and "inflate" just that record with a second request
        $fullProject = $gatewayProject->resolveEntity($projects[500][recid], 'Project');

[1]: http://www.soliantconsulting.com
[2]: http://www.filemaker.com/products/filemaker-server/
[3]: http://www.doctrine-project.org/
[4]: http://docs.doctrine-project.org/projects/doctrine-orm/en/2.0.x/reference/architecture.html
[6]: http://martinfowler.com/eaaCatalog/tableDataGateway.html
[8]: http://martinfowler.com/eaaCatalog/gateway.html
[9]: http://getcomposer.org
[10]: https://github.com/soliantconsulting/SimpleFM
