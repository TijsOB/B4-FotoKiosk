<?php

$dayRaw = filter_input(INPUT_GET, 'day');
$day = $dayRaw ? trim($dayRaw) : '';

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
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></title>
   
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
            
            <div class="title">
                <h1><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></h1>
            </div>
        
        <div class="PHOTO">
            <?php if (!empty($photos)): ?>
                <?php foreach ($photos as $photo): ?>
                    <img src="pictures/<?php echo htmlspecialchars($folderName, ENT_QUOTES, 'UTF-8'); ?>/<?php echo htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>" 
                         alt="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?> foto">
                <?php endforeach; ?>
            <?php else: ?>
                <p>Geen foto's beschikbaar voor deze dag.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>

