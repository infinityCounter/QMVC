<html>

    <head>
        <link rel="stylesheet" href="<?php echo('lib/bootstrap/css/bootstrap.min.css')?>">
        <link rel="stylesheet" href="<?php echo('application/styles/style.css')?>">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One|Roboto|Roboto+Slab" rel="stylesheet">
    </head>

    <body>
        <div class="container">

            <!--SIDE BAR FOR PAGE-->
            <div  id="pageWrapper" class="row">
                <div id="webHeader" class="col-sm-4 col-md-4">
                    <img src="<?php echo('application/img/banner.jpg')?>">
                    <div class="row menuRow">
                        <div class="col-md-12 col-sm-12 menuHeader">
                            NATIONAL SCHOOL REGISTRAR
                        </div>
                    </div>
                    <div id="homeLink" class="row menuRow menuContainer">
                        <a href="<?php echo(URL)?>"><div class="row menuRow menuItem">
                            <div class="col-md-12 col-sm-12">
                                HOME
                            </div></a>
                        </div>
                         <a href="<?php echo(URL . '/school')?>"><div id="schoolLink" class="row menuRow menuItem">
                            <div class="col-md-12 col-sm-12">
                                SCHOOL REGISTRAR
                            </div>
                        </div></a>
                    </div>
                </div>





                <!--MAIN PAGE CONTENT AREA-->
                <div id="contentArea" class="col-sm-8 col-md-8">
                    <div id="welcomeHeader" class="row contentRow">
                        <div class="col-md-12 col-sm-12">
                                WELCOME TO THE NATIONAL SCHOOL REGISTRAR<br>
                                <span id="poweredBy">powered by QMVC</span>
                        </div>
                        <hr>
                    </div>
                    <div class="row contentRow">
                        <div class="col-md-12 col-sm-12">
                                <p class="tab"></p><p>The National School Registrar(NSR) is a web based system for the catalouging of 
                                all scholastic institutions in Jamaica. Designed using the new PHP microframework 
                                Quick MVC (QMVC). The framework is aimed at building simple RESTful web applications.
                                There are no heavy components, modules, or features like in other frameworks.
                                However QMVC does support several features: </p>
                                <ul>
                                    <li>
                                        Clean, simple URL routing
                                    </li>
                                    <li>
                                        RESTful artictechure
                                    </li>
                                    <li>
                                        Pure intuitive OOP PHP
                                    </li>
                                    <li>
                                        Simple PHP structure
                                    </li>
                                    <li>
                                        JSON friendly
                                    </li>
                                    <li>
                                        Easily to setup, and go!
                                    </li>
                                    <li>
                                        Various MVC combinations.
                                    </li>
                                </ul>

                                <p>The School Registrar page allows you to view all the schools in the National
                                School Registrar database, as well as perform supported CRUD operations on them.
                                The contact form will write a new information request to the database. </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="<?php echo('lib/jquery/jquery-3.1.1.min.js')?>"></script>
        <script src="<?php echo('lib/bootstrap/js/bootstrap.min.js')?>"></script>
        
    </body>
</html>