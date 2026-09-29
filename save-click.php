<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("POST only.\n");
}

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    exit("Invalid JSON.\n");
}

$timestamp = $data['timestamp'] ?? '';
$pageX     = (int)($data['pageX'] ?? 0);
$pageY     = (int)($data['pageY'] ?? 0);
$clientX   = (int)($data['clientX'] ?? 0);
$clientY   = (int)($data['clientY'] ?? 0);
$screenX   = (int)($data['screenX'] ?? 0);
$screenY   = (int)($data['screenY'] ?? 0);
$element   = $data['element'] ?? '';
$id        = $data['id'] ?? '';
$className = $data['className'] ?? '';

$line =
    $timestamp .
    " | page=(" . $pageX . "," . $pageY . ")" .
    " | client=(" . $clientX . "," . $clientY . ")" .
    " | screen=(" . $screenX . "," . $screenY . ")" .
    " | element=" . $element .
    " | id=" . $id .
    " | class=" . $className .
    PHP_EOL;

$file = __DIR__ . '/data/clicks.txt';

$result = file_put_contents(
    $file,
    $line,
    FILE_APPEND | LOCK_EX
);

if ($result === false) {
    http_response_code(500);
    exit("Could not write clicks.txt\n");
}

echo "saved\n";
