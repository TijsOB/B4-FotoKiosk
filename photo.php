<?php
session_start();

// Handle adding photo to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = [
        'day'   => $_POST['day']   ?? 'Onbekend',
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

$dayMap = [
    'Zondag' => '0_Zondag', 'Maandag' => '1_Maandag', 'Dinsdag' => '2_Dinsdag',
    'Woensdag' => '3_Woensdag', 'Donderdag' => '4_Donderdag',
    'Vrijdag' => '5_Vrijdag', 'Zaterdag' => '6_Zaterdag'
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

$selectedPhoto = $photos[$id - 1] ?? null;

$pageTitle = $selectedPhoto ? "Foto · $day" : "Foto";
$activeNav = 'home';
include 'partials/header.php';
?>
<main class="page">
    <section class="wrapper">
        <nav class="breadcrumbs" aria-label="Kruimelpad">
            <a href="index.php">Dagen</a>
            <span aria-hidden="true">/</span>
            <a href="days.php?day=<?php echo urlencode($day); ?>"><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></a>
            <span aria-hidden="true">/</span>
            <span class="is-current">Foto #<?php echo str_pad($id, 2, '0', STR_PAD_LEFT); ?></span>
        </nav>

        <?php if ($selectedPhoto): ?>
            <article class="photo-detail">
                <div class="photo-detail__media">
                    <img src="pictures/<?php echo htmlspecialchars($folderName, ENT_QUOTES, 'UTF-8'); ?>/<?php echo htmlspecialchars($selectedPhoto, ENT_QUOTES, 'UTF-8'); ?>"
                         alt="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?> foto <?php echo $id; ?>">
                </div>
                <aside class="photo-detail__panel">
                    <p class="eyebrow">DeveloperLand · Foto</p>
                    <h1>Herinnering <?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></h1>
                    <dl class="spec-list">
                        <div><dt>Dag</dt><dd><?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></dd></div>
                        <div><dt>Foto naam</dt><dd><?php echo htmlspecialchars(pathinfo($selectedPhoto, PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8'); ?></dd></div>
                        <div><dt>Formaat</dt><dd>Hoge resolutie · digitaal</dd></div>
                    </dl>
                    <div class="price-row">
                        <span class="price-row__label">Prijs</span>
                        <span class="price-row__value">&euro;12,50</span>
                    </div>
                    <form method="POST" class="photo-detail__actions">
                        <input type="hidden" name="day"   value="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="hidden" name="photo" value="<?php echo htmlspecialchars($selectedPhoto, ENT_QUOTES, 'UTF-8'); ?>">
                        <button type="submit" name="add_to_cart" value="1" class="btn btn--primary btn--lg btn--block">
                            <i class="fa-solid fa-cart-shopping"></i> In winkelwagen
                        </button>
                        <a href="days.php?day=<?php echo urlencode($day); ?>" class="btn btn--ghost btn--block">
                            <i class="fa-solid fa-arrow-left"></i> Terug naar overzicht
                        </a>
                    </form>
                </aside>
            </article>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-regular fa-image"></i>
                <h2>Foto niet gevonden</h2>
                <p>Deze foto bestaat niet (meer).</p>
                <a href="days.php?day=<?php echo urlencode($day); ?>" class="btn btn--secondary">Terug naar <?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?></a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
