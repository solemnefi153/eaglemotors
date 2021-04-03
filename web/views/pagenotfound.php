<!DOCTYPE html>
<html lang="en">
    <head>

        <title>Not found | Eagle Motors, LLC.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel='stylesheet' href='<?php echo ROOT_URI; ?>public/css/general_styles.css' media='screen'>
        <link href="<?php echo ROOT_URI; ?>public/images/site/favicon.ico" rel="icon" type="image/x-icon" />
    </head>
    <body>
        <div class='content'>
            <?php require ABS_ROOT_FILE_PATH . '/views/snipets/header.php'; ?>
            <nav>
                <a class='nav_link' href='#' title='Go to the home page'>Home</a>
            </nav>
            <main>
                <h1>Page not found </h1>
                <p>
                    Sorry we could not find the page you were looking. 
                </p>
            </main>
            <?php  require ABS_ROOT_FILE_PATH . '/views/snipets/footer.php' ?>
        </div>

    </body>
</html>