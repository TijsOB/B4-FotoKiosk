<?php
session_start();

// Handle removing photo from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $removeIndex = (int)$_POST['remove'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
    }
    header('Location: buy.php');
    exit();
}

?>

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
            <div class="nav-item">
                <a href="index.php">&larr; Terug</a>
            </div class="nav-item">
        </div>

        <?php
        $cart = $_SESSION['cart'] ?? [];
        $totalPhotos = count($cart);
        $price = $totalPhotos * 67;
        ?>
        
        <div class="cartcontainer">
            <div class="cartitem">
        <h2>Winkelwagen</h2>
        <div class="buycontainer">
        <?php if (!empty($cart)): ?>
            
                <?php foreach ($cart as $index => $item): ?>
                    <div class="buy-items">
                        <div class="buy-item">
                            <p><strong>Dag:</strong> <?php echo htmlspecialchars($item['day'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Foto:</strong> <?php echo htmlspecialchars($item['photo'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><strong>Prijs:</strong> €67</p>
                        </div>
                    <div class="buy-item">
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="remove" value="<?php echo $index; ?>">
                            <button type="submit">Verwijderen</button>
                        </form>
                    </div>
                    </div>
                <?php endforeach; ?>
            
        </div>
        </div class="cartitem">
        <div class="cartitem">
            <div class="cart">
                <h2>Totaal foto's: <?php echo $totalPhotos ?></h2>
                <h2>Totaal prijs = €<?php echo $price ?></h2>
            </div>
            <div class="cart">
                <button><a href="/">Doorgaan winkelen</a></button>

                <button><a href="/">Betalen</a></button>

            </div>
        <?php else: ?>
            <p>Je winkelwagen is leeg. <a href="index.php">Ga terug en selecteer foto's</a></p>
        <?php endif; ?>
        </div class="cartitem">
        </div>
    </main>
</body>
</html>