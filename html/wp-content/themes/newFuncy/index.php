<html>
<head>
    <title>New Funcy</title>
    <link rel="stylesheet" href="http://10.0.9.24:8000/wp-content/themes/newFuncy/style.css">
</head>

<body>
<?php get_header() ?>
<div id="cuerpo">

    <?php
    echo "<h1 class='morado'>Hola funcy</h1>";

    global $post;
    if(have_posts()):
        while ((have_posts())):
            the_post();
            the_title();
            the_post_thumbnail();
          endwhile;
      endif;
    ?>



    </div>

    <? get_footer() ?>
</body>
</html>
