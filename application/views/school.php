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
                                NATIONAL SCHOOL REGISTRAR DATABASE<br>
                                <span id="poweredBy">powered by QMVC</span>
                        </div>
                        <hr>
                    </div>
                    <div class="row contentRow">
                        <div class="col-md-12 col-sm-12">
                        Edit any of the fields and click update to update the entry, or delete to delete the entry.
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>School Name</td>
                <td>Address</td>
                <td>Telephone</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td><input id="newName" type="text"></td>
                    <td><input id="newAddress" type="text"></td>
                    <td><input id="newTelephone" type="text"></td>
                    <td><button onclick="createSchool()">CREATE</button></td>
                </tr>
            <?php $schools = $this->schools; foreach ($schools as $school) {?>
                <tr>
                    <td><?php if (isset($school["Id"])) echo htmlspecialchars($school["Id"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><input id="<?php echo($school['Id'] . 'Name')?>" type="text" value="<?php echo($school['Name'])?>"></td>
                    <td><input id="<?php echo($school['Id'] . 'Address')?>" type="text" value="<?php echo($school['Address'])?>"></td>
                    <td><input id="<?php echo($school['Id'] . 'Telephone')?>" type="text" value="<?php echo($school['Telephone'])?>"></td>
                    <td><button onclick="deleteSchool(<?php echo $school['Id']?>)">delete</button></td>
                    <td><button onclick="updateSchool(<?php echo $school['Id']?>)">Update</button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="<?php echo('lib/jquery/jquery-3.1.1.min.js')?>"></script>
        <script src="<?php echo('lib/bootstrap/js/bootstrap.min.js')?>"></script>
        <script src="<?php echo('application/js/school.js')?>"></script>
    </body>
</html>