<?php
// partials/header.php — shared header + nav
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
$pageTitle = $pageTitle ?? 'DeveloperLand';
$activeNav = $activeNav ?? '';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DeveloperLand — bekijk en bestel jouw pretparkfoto's per dag.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://kit.fontawesome.com/5246fd09f8.js" crossorigin="anonymous"></script>
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> · DeveloperLand</title>
</head>
<body>
<header class="site-header">
    <div class="site-header__inner wrapper">
        <a href="index.php" class="brand" aria-label="DeveloperLand home">
            <img src="/pictures/img/logo-big-v3.png"
                 alt="DeveloperLand logo"
                 class="brand__logo">
        </a>
        <nav class="primary-nav" aria-label="Hoofdnavigatie">
            <a href="index.php" class="primary-nav__link <?php echo $activeNav==='home'?'is-active':''; ?>">
                <i class="fa-solid fa-house"></i><span>Dagen</span>
            </a>
            <a href="buy.php" class="primary-nav__link primary-nav__link--cart <?php echo $activeNav==='cart'?'is-active':''; ?>">
                <i class="fa-solid fa-basket-shopping"></i>
                <span>Winkelwagen</span>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </a>
        </nav>
    </div>
</header>
