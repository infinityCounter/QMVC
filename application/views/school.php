<html>

    <head>

        <script src="<?php echo('application/js/school.js');?>"></script>
    </head>

    <body>
        TEST CREATE, READ, UPDATE, AND DELETE OPERATIONS ON THIS PAGE</br>
        FILL OUT THIS FORM AND CLICK THE SUBMIT BUTTON TO CREATE, OR CLICK THE EDIT BUTTON NEXT TO A SCHOOL TO UPDATE
        <form action="<?php echo(URL.'/home')?>" method="POST">
            School Name:<br>
            <input type="text" name="Name">
            <br><br>
            School Address:<br>
            <input type="text" name="Address">
            <br>
            Telephone Number:<br>
            <input type="text" name="Telephone">
            <br><br>
            Principal Name:<br>
            <input type="text" name="Principal">
            <br>
            <input type="submit" value="Submit">
        </form> 
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
            <?php $schools = $this->schools; foreach ($schools as $school) {?>
                <tr>
                    <td><?php if (isset($school["Id"])) echo htmlspecialchars($school["Id"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($school["Name"])) echo htmlspecialchars($school["Name"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($school["Address"])) echo htmlspecialchars($school["Address"], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <?php if (isset($school["Telephone"])) echo htmlspecialchars($school["Telephone"], ENT_QUOTES, 'UTF-8'); ?>
                    </td>
                    <td><button onclick="deleteSchool(<?php echo $school['Id']?>)">delete</button></td>
                    <td><button onclick="updateSchool(<?php echo $school['Id']?>)">Edit</button></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>