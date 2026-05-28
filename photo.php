<?php
session_start();

// Handle adding photo to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = [
        'id' => $id ?? 0,
        'day' => $_POST['day'] ?? 'Onbekend',
        'photo' => $_POST['photo'] ?? ''
    ];
    header('Location: buy.php');
    exit();
}

$dayRaw = filter_input(INPUT_GET, 'day');
$day = $dayRaw ? trim($dayRaw) : '';

$idRaw = filter_input(INPUT_GET, 'id');
$id = $idRaw ? (int)$idRaw : 0;

if ($day === '' || !preg_match('/^[\p{L} ]+$/u', $day) || mb_strlen($day) > 50) {
    $day = 'Onbekend';
}

// Map Dutch day names to folder numbers
$dayMap = [
    'Zondag' => '0_Zondag',
    'Maandag' => '1_Maandag',
    'Dinsdag' => '2_Dinsdag',
    'Woensdag' => '3_Woensdag',
    'Donderdag' => '4_Donderdag',
    'Vrijdag' => '5_Vrijdag',
    'Zaterdag' => '6_Zaterdag'
];

// Get the folder name for this day
$folderName = $dayMap[$day] ?? null;
$photos = [];

if ($folderName) {
    $folderPath = 'pictures/' . $folderName;
    if (is_dir($folderPath)) {
        $files = scandir($folderPath);
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, $imageExtensions)) {
                $photos[] = $file;
            }
        }
        sort($photos);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/5246fd09f8.js" crossorigin="anonymous"></script>
    <title>Devland, Foto</title>
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
                </div>
                <div class="nav-item">
                    <a href="buy.php"><i class="fa-solid fa-basket-shopping">Naar Winkelwagen</i></a>
                </div>
            </div>

        <div class="container">
            <?php $checkid = 0 ?>
            <?php if (!empty($photos)): ?>
                <?php foreach ($photos as $photo): ?>
                    <?php $checkid += 1; ?>
                    
                    <?php if ($checkid == $id): ?>
                        <div class="PhotoContainer">
                            <div class="PhotoContainer">
                                <img src="pictures/<?php echo htmlspecialchars($folderName, ENT_QUOTES, 'UTF-8'); ?>/<?php echo htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>" 
                                alt="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?> foto">
                            </div>
                            
                            <div class="PhotoContainerItem">
                                <h2>Dag: <?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?> </h2>
                                <p>Foto Naam: <?php echo htmlspecialchars(pathinfo($photo, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8'); ?></p>
                            </div>
                            
                        </div>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="day" value="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="photo" value="<?php echo htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>">
                            <button type="submit" name="add_to_cart" value="1">Koop <i class="fa-solid fa-cart-shopping"></i></button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Geen foto's beschikbaar voor deze dag.</p>
            <?php endif; ?>
        </div>

    </main>
</body>
</html>