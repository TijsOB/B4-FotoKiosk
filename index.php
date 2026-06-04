<?php
session_start();
$pageTitle = 'Welkom';
$activeNav = 'home';
include 'partials/header.php';

$days = [
    ['name' => 'Zondag',    'icon' => 'fa-sun'],
    ['name' => 'Maandag',   'icon' => 'fa-mug-hot'],
    ['name' => 'Dinsdag',   'icon' => 'fa-ticket'],
    ['name' => 'Woensdag',  'icon' => 'fa-children'],
    ['name' => 'Donderdag', 'icon' => 'fa-ice-cream'],
    ['name' => 'Vrijdag',   'icon' => 'fa-rocket'],
    ['name' => 'Zaterdag',  'icon' => 'fa-star'],
];
?>
<main class="page">
    <section class="hero wrapper">
        <p class="eyebrow">DeveloperLand · Fotoservice</p>
        <h1>Herbeleef jouw dag in het park.</h1>
        <p class="hero__lede">
            Selecteer de dag van je bezoek en kies de mooiste herinneringen.
            Elke foto wordt in hoge resolutie geleverd voor &euro;12,50.
        </p>
    </section>

    <section class="wrapper">
        <header class="section-head">
            <h2>Kies een dag</h2>
            <p>We hebben elke dag van de week vastgelegd.</p>
        </header>

        <div class="day-grid">
            <?php foreach ($days as $d): ?>
                <a class="day-card" href="days.php?day=<?php echo urlencode($d['name']); ?>">
                    <span class="day-card__icon"><i class="fa-solid <?php echo $d['icon']; ?>"></i></span>
                    <span class="day-card__name"><?php echo htmlspecialchars($d['name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="day-card__cta">Bekijk foto's <i class="fa-solid fa-arrow-right"></i></span>
                </a>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?php include 'partials/footer.php'; ?>
