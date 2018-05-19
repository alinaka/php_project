<!DOCTYPE html>    
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/style.css"></link>
</head>
<body>
   <div class="container">
    <?php include 'logo.php'; ?>
    <?php include $view;?>
    <?php include 'footer.php'; ?>
   </div>
</body>
</html>