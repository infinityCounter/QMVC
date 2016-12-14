<html>
    <head>
        <link rel="stylesheet" href="<?php echo(URL . '/application/lib/bootstrap/css/bootstrap.min.css')?>">
        <link rel="stylesheet" href="<?php echo(URL . '/application/styles/style.css')?>">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One|Roboto|Roboto+Slab" rel="stylesheet">
    </head>

    <body id="errorPage">
        <div class="container">

            <!--SIDE BAR FOR PAGE-->
            <div  id="pageWrapper" class="row errorRap">
                <img src="<?php echo(URL . '/application/img/404.gif')?>">
                <div>These are some dangerous parts! Maybe you should head 
                <a id="homeAnchor" href="<?php echo(URL)?>">home.</a></div>
            </div>

        </div>

        <script src="<?php echo(URL . '/application/lib/jquery/jquery-3.1.1.min.js')?>"></script>
        <script src="<?php echo(URL . '/application/lib/bootstrap/js/bootstrap.min.js')?>"></script>
        
    </body>
</html>