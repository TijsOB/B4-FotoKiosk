<?php
session_start();

include 'helpers.php';

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
$filterHourRaw = filter_input(INPUT_GET, 'hour');
$filterMinuteRaw = filter_input(INPUT_GET, 'minute');
$filterHour = ($filterHourRaw !== null && $filterHourRaw !== '') ? filter_var($filterHourRaw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 23]]) : null;
$filterMinute = ($filterMinuteRaw !== null && $filterMinuteRaw !== '') ? filter_var($filterMinuteRaw, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => 59]]) : null;
if ($filterHour === false) {
    $filterHour = null;
}
if ($filterMinute === false) {
    $filterMinute = null;
}

$availableHours = [];
if ($folderName) {
    $folderPath = 'pictures/' . $folderName;
    $photos = loadPhotosFromFolder($folderPath);
    $availableHours = getPhotoHours($photos);
    $photos = filterPhotosByTime($photos, $filterHour, $filterMinute);
}

function makeQuery(array $extra = []): string
{
    global $day, $filterHour, $filterMinute;
    $params = ['day' => $day];
    if ($filterHour !== null) {
        $params['hour'] = $filterHour;
    }
    if ($filterMinute !== null) {
        $params['minute'] = $filterMinute;
    }

    return http_build_query(array_merge($params, $extra));
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

        <div class="sort-toolbar">
            <form method="get" class="sort-toolbar__form">
                <input type="hidden" name="day" value="<?php echo htmlspecialchars($day, ENT_QUOTES, 'UTF-8'); ?>">

                <label for="hour">Uur</label>
                <select name="hour" id="hour">
                    <option value="">Alle uren</option>
                    <?php foreach ($availableHours as $hourOption): ?>
                        <option value="<?php echo $hourOption; ?>"<?php echo $filterHour === $hourOption ? ' selected' : ''; ?>><?php echo str_pad($hourOption, 2, '0', STR_PAD_LEFT); ?>:00</option>
                    <?php endforeach; ?>
                </select>

                <label for="minute">Minuut</label>
                <input type="number" name="minute" id="minute" min="0" max="59" step="1" value="<?php echo $filterMinute !== null ? htmlspecialchars($filterMinute, ENT_QUOTES, 'UTF-8') : ''; ?>" placeholder="0">

                <button type="submit" class="btn btn--secondary">Filteren</button>
                <a href="days.php?day=<?php echo urlencode($day); ?>" class="btn btn--tertiary"><button class="btn btn--secondary">Reset</button></a>
            </form>
        </div>

        <?php if (!empty($photos)): ?>
            <div class="photo-grid">
                <?php $id = 0; foreach ($photos as $photo): $id++; ?>
                    <article class="photo-card">
                        <a class="photo-card__media" href="photo.php?<?php echo makeQuery(['id' => $id]); ?>">
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
                               href="photo.php?<?php echo makeQuery(['id' => $id]); ?>">
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
