# QMVC
A quick PHP MVC microframework. It's a simple bare bone deconstruct.

Note: This is not a completed framework to be used for large scale projects, but feel free to fork and develop!
______

##Setting up

1. Clone this repository.
2. If not already installed, install [Vagrant](http://vagrantup.com).
3. Navigate to the project root and run Vagrant up. (VAGRANT FILE NOT YET SETUP!)
4. If you choose not to use vagrant, please place this project in the public directory of your server.

That's it and you're done!
______

##Understanding project layout

The QMVC project is structured as follows:
```
*application --- Folder where all source code should be placed

   *controllers --- Location of controllers for views
   
   *models --- Location of models used by controllers
   
   *views --- Template files for your web views
   
*config --- Location of project configuration data

   *database.php 
   
   *environment.php
   
   *states.php
   
*library --- Helper methods and core methods used by the project

*public --- All incoming requests are routed here

   *.htaccess --- Controls request rerouting
   
   *index.php --- instantiates an instance of the project upon request
   
```

The project layout *can be modified* by the user but it will require the modification of core files router.php, index.php. *This is NOT recommended.*

______

##States

A state is any of the mutable forms or view the application may take at any time.
A state is composed of:
   * View
   * Controller

###View

Views ,synonymous with template for this project, are the display elements of your application. 


###Controllers</br></br>

Controllers provide a layer of abstraction between templates, the user interface, and the model, the back end of your application.
Templates must *NEVER* directly interact with models by principle.</br>

All controllers in the project are extensions of the abstract Controller core class of the project located in /library

```php
<?php

class Home extends Controller{

    function render(){};
}
?>
```

####methods:

defined by abstract Controller class:    

######__construct($template, $subView)(); 
    abstract methods of abstract Controller class:


#######function render();
    Must be defined in extending controller. Renders the view.
    Left undefined as there are custom procedures that can be performed on the view before rendering.

####attributes:

defined by abstract Controller class:

######*protected* $template
    Contains the view of the state, loaded in through the constructor.

######*protected* $subView
    Boolean from the state array. If true activate any substates.
   
--

###Models

Models represents the data of the application and is independent of View and Controller.
Primarly the layer where your application and database interact.

QMVC supports: *SQL*, *Postgres*, and *MongoDB* currently.
--

###The States Array

The states the are routes accessible by the project. *All* states are defined within the *states.php* config file.
The states array takes the format

````php
$states = array(
    
    'stateName' => array(
        'uri' => 'stateOne',
        'controllerPath' => 'controllers/stateCtrl.php',
        'controllerName' => 'StateOneController',
        'template' => 'views/stateOne.php',
        'subView' => false
    ),

    'Otherwise' => array(
        'uri' => 'error',
        'controllerPath' => 'controllers/error404.php',
        'controllerName' => 'Error404',
        'template' => 'views/error404.php',
        'subView' => false
    );
);
````

_*stateName*_: Key for the state of the array. This stateName is also the url to access the state from the web browser.

_*uri*_: Publicly displayed uri in header bar.

_*controllerPath*_: Path to the controller for state.

_*controllerName*_: Name of the controller class to be initialized for state.

_*template*_: Path of the view location for state.

_*subView*_: A boolean. If set to true, allow the loading of any subviews, if false do not load subviews in view file.

######Otherwise

Otherwise is a reserved state. A fallback if there is no state matching the initial request.
______

##The Router

The QMVC router is what fits the project together. 
The router redirect any request to the domain.

####Making a request

request are of the format http://domain.com/home/method/17

*All* of the string after the top level domain is considered an argument.
In this case 
```
home/method/17
```
This string is seperated into an array delimeted by '/'

*The router assumes the first index of teh array to be the state.
*The second index is the name of the method to be executed.
*All remaining indexes to be arguments to the method. 

If the state requested does not exist the fallback 'Otherwise' state will be requested.
If there is no matching method for the state controller, no method is executed.

______

*DOCUMENTATION TO BE UPDATED IN THE FUTURE*
author: Emile Keith (@infinityCounter)
