<?php

function parsePhotoTimestamp(string $filename): ?array
{
    $base = pathinfo($filename, PATHINFO_FILENAME);
    if (preg_match('/^(\d{2})_(\d{2})_(\d{2})_/', $base, $matches)) {
        return [
            'hour' => (int)$matches[1],
            'minute' => (int)$matches[2],
            'second' => (int)$matches[3],
            'time' => sprintf('%02d:%02d:%02d', $matches[1], $matches[2], $matches[3]),
        ];
    }

    return null;
}

function comparePhotosByTimestamp(string $a, string $b): int
{
    $timeA = parsePhotoTimestamp($a);
    $timeB = parsePhotoTimestamp($b);

    if ($timeA && $timeB) {
        if ($timeA['hour'] !== $timeB['hour']) {
            return $timeA['hour'] <=> $timeB['hour'];
        }
        if ($timeA['minute'] !== $timeB['minute']) {
            return $timeA['minute'] <=> $timeB['minute'];
        }
        if ($timeA['second'] !== $timeB['second']) {
            return $timeA['second'] <=> $timeB['second'];
        }
        return strcmp($a, $b);
    }

    if ($timeA) {
        return -1;
    }

    if ($timeB) {
        return 1;
    }

    return strcmp($a, $b);
}

function loadPhotosFromFolder(string $folderPath): array
{
    $photos = [];
    if (!is_dir($folderPath)) {
        return $photos;
    }

    $files = scandir($folderPath);
    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    foreach ($files as $file) {
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, $imageExtensions, true)) {
            $photos[] = $file;
        }
    }

    usort($photos, 'comparePhotosByTimestamp');
    return $photos;
}

function groupPhotosByHour(array $photos): array
{
    $groups = [];
    foreach ($photos as $photo) {
        $time = parsePhotoTimestamp($photo);
        $groupKey = $time ? sprintf('%02d:00', $time['hour']) : 'Onbekende tijd';
        $groups[$groupKey][] = $photo;
    }

    uksort($groups, static function ($a, $b) {
        if ($a === 'Onbekende tijd') {
            return 1;
        }
        if ($b === 'Onbekende tijd') {
            return -1;
        }
        return intval(substr($a, 0, 2)) <=> intval(substr($b, 0, 2));
    });

    return $groups;
}

function filterPhotosByTime(array $photos, ?int $hour = null, ?int $minute = null): array
{
    if ($hour === null && $minute === null) {
        return $photos;
    }

    return array_values(array_filter($photos, static function (string $photo) use ($hour, $minute) {
        $time = parsePhotoTimestamp($photo);
        if (!$time) {
            return false;
        }

        if ($hour !== null && $time['hour'] !== $hour) {
            return false;
        }

        if ($minute !== null && $time['minute'] !== $minute) {
            return false;
        }

        return true;
    }));
}

function getPhotoHours(array $photos): array
{
    $hours = [];
    foreach ($photos as $photo) {
        $time = parsePhotoTimestamp($photo);
        if ($time) {
            $hours[$time['hour']] = true;
        }
    }

    $hours = array_keys($hours);
    sort($hours);
    return $hours;
}
