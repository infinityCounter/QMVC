# QMVC
A quick PHP MVC microframework. It's a simple bare bone application deconstruct.

Note: This is not a completed framework to be used for large scale or enterpise projects, but feel free to use it for small and simple application. Fork and develop further if you like!
______

## Setting up

I recommed using method 1, as the environment will be the same as when this project was being created.

Method 1:

1. Clone this repository.

2. If not already installed, install [Vagrant](http://vagrantup.com).

3. Navigate to the \_vagrant under the project root and run Vagrant up. 

4. That's it. Server and test application should be running and accessible on localhost:9820/QMVC/


Method 2:

1. Download the bootstrap.sh file located under \_vagrant in this repository.

2. Run the script.

3. Done. Project should be live on localhost:80/QMVC/ 
______

## Understanding project layout

The QMVC project is structured as follows:

```
*application --- Folder where all source code and project resources should be placed

   *controllers --- Location of controllers for views
   
   *models --- Location of models used by controllers
   
   *views --- Template files for your web views
   
*config --- Location of project configuration data

   *database.ini.php --- File containing all database access credentials
   
   *definitions.php
   
   *environment.php
   
   *states.php
 
*base -- The core of the application containing vital code including router.

*public --- All incoming requests are routed here

   *.htaccess --- Controls request rerouting
   
   *index.php --- instantiates an instance of the project upon request
   
```

______

## States

A state is any form the application may take at any given time, states are navigated by sending requests to the router.

A state is composed of:
   * View
   * Controller
   * Model
   
NOTE: A state may be created without a model or controller, only a View is required.

### View

Views ,synonymous with template for this project, are the display elements of your application. 


### Controllers

Controllers provide a layer of abstraction between templates, the user interface, and the model, the back end of your application.
Templates must *NOT* directly interact with models by principle, and should go through controllers.

All controllers in the project are extensions of the abstract Controller core class of the project located in /library

```php
<?php

abstract class Controller 
{
    protected $template = null;
    protected $model = null;

    function __construct($model = null, $template)
    {
        $this->template = $template;
        $this->model= $model;
    }

    function render()
    {
        require_once(ROOT_PATH . $this->template);
    }
}
?>
```

#### methods:

defined by abstract Controller class:  

###### *protected*  $template:
 An inheritable private variable of type String that will contain the relative path from project root to your template file.
    
###### *protected*  $model:
 An inheritable private variable of type Model that will keep an instance of the model.


###### function render();
 May be ovewridden in extending controller. Default Renders the view template provided to the constructor.

--

### Models

Models represents the data of the application and is independent of View and Controller.
Primarly the layer where your application and database interact.

QMVC currently only supports: *MySQL databases*, but later hopes to add *Postsgres*, *MongoD*,and *Firebase*.
___

### The States Array

STATES is an array indexed by the accessible URIs of the application. These URIs may contain RESTful parameters indicated by "{}".  the are routes accessible by the project. *All* states should be defined within the *states.php* config file.
The states array takes the format:

````php
define('STATES', (
    
    '/routeURI' => array(
        'model' => 'StateModel',
        'controller' => 'StateController',
        'template' => 'application/views/stateOneView.php',
        'actions' = array('GET' => 'getAction', 'POST' => 'postAction')
    ),
    
    '/otherwise' => array(
        'template' => 'application/views/fallback.php'
    )
));
````

_*routeURI*_: Key for the state of the array. The route URI is used to access the state from the web browser.

_*model*_: The class name model to be used by the controller of this state.

_*controller*_: The class name of the controller to be used by the state.

_*template*_: The relative path of the state template from the root of the project.

_*actions*_: Array of permissible request types where keys are the type of request and the values, methods that are executed on the controller when a request of that type is made to the route. A request of a type not listed in actions will be redirected to the fallback route.

###### Otherwise

'/otherwise' is a reserved state, the default fallback if there is no state matching the initial request.
______

## The Router

The QMVC router is what fits the project together. #
The router redirect any request to the domain. The router accepts the string url of the default fallback as parameters in its constructor. If ommited the default fallback state will be set to '/otherwise'

```php
//Creates a new Router object with the states defined in states.php
$Router = new Router();
//Load the State that the request Uri mapped to
$Router->loadRequestedState();
```
The router is instantiated as so in the index.php file located in the public folder.

#### Making a request

QMVC is based on the concept of REST architecture, and thus is meant to be used to build small RESTful applications. However it can also be used to create regular websites.

Requests are then of the form: http://domain.com/state/ or http://domain.com/state/{dataUri}

The first case is simply a request for a state, the second is a request for a specific data object at a state.
In the second case the argument located at teh position of {dataUri} in an actual request will be used as the first argument in the function call of the specified action type.

Please keep that in mind when creating states.

### Features still to be implimented: 

* Subviews
* Support for Postgres, MongoDB, and Firebase databases
* Getting environment database information

_________

*DOCUMENTATION TO BE UPDATED IN THE FUTURE*
author: Emile Keith (@infinityCounter)
