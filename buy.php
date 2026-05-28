<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Shopping Cart</title>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="wrapper">   
            <img src="/pictures/img/logo-big-v3.png" alt="Het logo van DeveloperLand met een draaimolen, kasteel, achtbaan en tot slot een gezin op de voorgrond." class="logo hidden-on-sm">
            </div>
        </div>       
    </header>  

    <main>
        <div class="nav">
                <a href="index.php">&larr; Terug</a>
        </div>

        <?php $placeholder = 0 ?>
        <?php $photos[] = 1 ?>
        
        <?php if(!empty($photos)) ?>
            <?php foreach ($photos as $photo): ?>
                <?php $placeholder += 500 ?>
                <h2>Totaal prijs = €<?php echo $placeholder ?></h2>
            <?php endforeach; ?>
    </main>
</body>
</html>