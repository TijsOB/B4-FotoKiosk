<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/5246fd09f8.js" crossorigin="anonymous"></script>
    <title>Devland</title>
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
                <div class="nav-item">            
                    <a href="buy.php">&larr; Terug</a>
                </div>
            </div>

        <div class="formcontainer">
            <h1>Shipping Details</h1>
            <div class="form-group">
                <label for="name">Naam:</label>
                <input type="text" name="name" id="name" class="form-input">
            </div>
            <div class="form-group">
                <label for="senderEmail">E-mailadres:</label>
              <input type="email" name="email" id="email" class="form-input">
            </div>
            <div class="form-group">
                <label for="name">Telefoon-Nummer:</label>
                <input type="tel" name="number" id="number" class="form-input">
            </div>
            <div class="form-group">
                <label for="name">Adres:</label>
                <input type="text" name="adres" id="adres" class="form-input">
            </div>
            <div class="form-group">
            <input type="button" onclick="alert('Dit valt buiten de Scope')" value="Door naar afrekenen" class=form-button>
            </div>
        </div>
    </main>
</body>
</html>