<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $removeIndex = (int)$_POST['remove'];
    if (isset($_SESSION['cart'][$removeIndex])) {
        unset($_SESSION['cart'][$removeIndex]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    header('Location: buy.php');
    exit();
}

$dayMap = [
    'Zondag' => '0_Zondag', 'Maandag' => '1_Maandag', 'Dinsdag' => '2_Dinsdag',
    'Woensdag' => '3_Woensdag', 'Donderdag' => '4_Donderdag',
    'Vrijdag' => '5_Vrijdag', 'Zaterdag' => '6_Zaterdag'
];

$cart = $_SESSION['cart'] ?? [];
$totalPhotos = count($cart);
$price = $totalPhotos * 12.50;

$pageTitle = 'Winkelwagen';
$activeNav = 'cart';
include 'partials/header.php';
?>
<main class="page">
    <section class="wrapper">
        <header class="section-head section-head--row">
            <div>
                <p class="eyebrow">Bestelling</p>
                <h1>Winkelwagen</h1>
            </div>
            <a href="index.php" class="btn btn--ghost"><i class="fa-solid fa-arrow-left"></i> Verder winkelen</a>
        </header>

        <?php if (!empty($cart)): ?>
            <div class="cart-layout">
                <div class="cart-list">
                    <?php foreach ($cart as $index => $item):
                        $itemFolder = $dayMap[$item['day']] ?? null;
                        $thumb = $itemFolder ? 'pictures/' . $itemFolder . '/' . $item['photo'] : null;
                    ?>
                        <article class="cart-row">
                            <?php if ($thumb): ?>
                                <div class="cart-row__thumb">
                                    <img loading="lazy" src="<?php echo htmlspecialchars($thumb, ENT_QUOTES, 'UTF-8'); ?>"
                                         alt="<?php echo htmlspecialchars($item['day'], ENT_QUOTES, 'UTF-8'); ?>">
                                </div>
                            <?php endif; ?>
                            <div class="cart-row__body">
                                <h3><?php echo htmlspecialchars(pathinfo($item['photo'], PATHINFO_FILENAME), ENT_QUOTES, 'UTF-8'); ?></h3>
                                <p class="cart-row__meta">
                                    <span><i class="fa-regular fa-calendar"></i> <?php echo htmlspecialchars($item['day'], ENT_QUOTES, 'UTF-8'); ?></span>
                                    <span><i class="fa-solid fa-image"></i> Digitale download</span>
                                </p>
                            </div>
                            <div class="cart-row__price">&euro;12,50</div>
                            <form method="POST" class="cart-row__remove">
                                <input type="hidden" name="remove" value="<?php echo $index; ?>">
                                <button type="submit" class="btn btn--icon" aria-label="Verwijderen">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </form>
                        </article>
                    <?php endforeach; ?>
                </div>

                <aside class="cart-summary">
                    <h2>Overzicht</h2>
                    <dl class="summary-list">
                        <div><dt>Aantal foto's</dt><dd><?php echo $totalPhotos; ?></dd></div>
                        <div><dt>Prijs per foto</dt><dd>&euro;12,50</dd></div>
                        <div><dt>Subtotaal</dt><dd>&euro;<?php echo number_format($price, 2, ',', '.'); ?></dd></div>
                    </dl>
                    <div class="summary-total">
                        <span>Totaal</span>
                        <span>&euro;<?php echo number_format($price, 2, ',', '.'); ?></span>
                    </div>
                    <a href="transaction.php" class="btn btn--primary btn--lg btn--block">
                        Afrekenen <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a href="index.php" class="btn btn--ghost btn--block">Verder winkelen</a>
                    <p class="summary-note"><i class="fa-solid fa-lock"></i> Veilig betalen via DeveloperLand</p>
                </aside>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fa-solid fa-basket-shopping"></i>
                <h2>Je winkelwagen is leeg</h2>
                <p>Selecteer eerst een paar mooie herinneringen.</p>
                <a href="index.php" class="btn btn--primary">Kies een dag</a>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
