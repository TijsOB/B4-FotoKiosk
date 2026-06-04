<?php
session_start();

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

$pageTitle = $day;
$activeNav = 'home';
include 'partials/header.php';
?>
<main class="page">
    <section class="wrapper">
        <nav class="breadcrumbs" aria-label="Kruimelpad">
            <a href="index.php"><i class="fa-solid fa-arrow-left"></i> Alle dagen</a>
            <span aria-hidden="true">/</span>
            <span class="is-current"><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></span>
        </nav>

        <header class="section-head section-head--row">
            <div>
                <p class="eyebrow">Foto's van</p>
                <h1><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></h1>
            </div>
            <div class="section-head__meta">
                <span class="pill"><i class="fa-solid fa-images"></i> <?php echo count($photos); ?> foto's</span>
                <span class="pill pill--accent"><i class="fa-solid fa-tag"></i> &euro;12,50 per foto</span>
            </div>
        </header>

        <?php if (!empty($photos)): ?>
            <div class="photo-grid">
                <?php $id = 0; foreach ($photos as $photo): $id++; ?>
                    <article class="photo-card">
                        <a class="photo-card__media" href="photo.php?day=<?php echo urlencode($day); ?>&id=<?php echo $id; ?>">
                            <img loading="lazy"
                                 src="pictures/<?php echo htmlspecialchars($folderName, ENT_QUOTES, 'UTF-8'); ?>/<?php echo htmlspecialchars($photo, ENT_QUOTES, 'UTF-8'); ?>"
                                 alt="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?> foto <?php echo $id; ?>">
                            <span class="photo-card__overlay"><i class="fa-solid fa-magnifying-glass-plus"></i> Bekijken</span>
                        </a>
                        <div class="photo-card__body">
                            <div class="photo-card__meta">
                                <span class="photo-card__index">#<?php echo str_pad($id, 2, '0', STR_PAD_LEFT); ?></span>
                                <span class="photo-card__price">&euro;12,50</span>
                            </div>
                            <a class="btn btn--primary btn--block"
                               href="photo.php?day=<?php echo urlencode($day); ?>&id=<?php echo $id; ?>">
                                <i class="fa-solid fa-cart-shopping"></i> Bekijk &amp; koop
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-regular fa-image"></i>
                <h2>Geen foto's beschikbaar</h2>
                <p>Voor <?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?> zijn nog geen foto's geüpload.</p>
                <a href="index.php" class="btn btn--secondary"><i class="fa-solid fa-arrow-left"></i> Kies een andere dag</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
