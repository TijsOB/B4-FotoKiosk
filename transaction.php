<?php
session_start();
$pageTitle = 'Afrekenen';
$activeNav = 'cart';
include 'partials/header.php';

$cart = $_SESSION['cart'] ?? [];
$total = count($cart) * 12.50;
?>
<main class="page">
    <section class="wrapper">
        <nav class="breadcrumbs" aria-label="Kruimelpad">
            <a href="buy.php"><i class="fa-solid fa-arrow-left"></i> Winkelwagen</a>
            <span aria-hidden="true">/</span>
            <span class="is-current">Afrekenen</span>
        </nav>

        <div class="checkout-layout">
            <form class="checkout-form" onsubmit="event.preventDefault(); alert('Dit valt buiten de Scope');">
                <header class="section-head">
                    <p class="eyebrow">Stap 2 van 2</p>
                    <h1>Verzendgegevens</h1>
                    <p>Vul je gegevens in zodat we je foto's kunnen leveren.</p>
                </header>

                <div class="form-grid">
                    <div class="form-field">
                        <label for="name">Naam</label>
                        <input type="text" name="name" id="name" required placeholder="Voornaam Achternaam">
                    </div>
                    <div class="form-field">
                        <label for="email">E-mailadres</label>
                        <input type="email" name="email" id="email" required placeholder="jij@voorbeeld.nl">
                    </div>
                    <div class="form-field">
                        <label for="number">Telefoonnummer</label>
                        <input type="tel" name="number" id="number" placeholder="06 12 34 56 78">
                    </div>
                    <div class="form-field form-field--full">
                        <label for="adres">Adres</label>
                        <input type="text" name="adres" id="adres" placeholder="Straat, huisnr, postcode, plaats">
                    </div>
                </div>

                <button type="submit" class="btn btn--primary btn--lg btn--block">
                    <i class="fa-solid fa-coins"></i> Door naar betalings methode
                </button>
            </form>

            <aside class="cart-summary">
                <h2>Jouw bestelling</h2>
                <dl class="summary-list">
                    <div><dt>Foto's</dt><dd><?php echo count($cart); ?></dd></div>
                    <div><dt>Per stuk</dt><dd>&euro;12,50</dd></div>
                </dl>
                <div class="summary-total">
                    <span>Totaal</span>
                    <span>&euro;<?php echo number_format($total, 2, ',', '.'); ?></span>
                </div>
                <p class="summary-note"><i class="fa-solid fa-shield-halved"></i> Versleutelde verbinding</p>
            </aside>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
