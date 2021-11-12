
/*
 echo get_stylesheet_uri()
*/
<html>
<head>
    <title>New Funcy</title>
    <link rel="stylesheet" href="http://10.0.9.24:8000/wp-content/themes/newFuncy/style.css">
</head>

<body>
<?php get_header()?>
<div id="cuerpo">

    <?php
    echo get_stylesheet_uri();
    echo  "<h1 class='morado'>Hola funcy</h1>";
    ?>

</div>

<? get_footer()?>
</body>
</html>
