<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="build/css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="build/css/app.css">
</head>

<body>
    <?php echo $contenido ?>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <?php
    echo $script ?? '';
    ?>
</body>

</html>