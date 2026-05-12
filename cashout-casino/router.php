<?php
/**
 * PHP built-in server router
 * Passes ALL requests (including .json, .txt etc.) through Laravel's index.php
 * while still serving real static assets directly.
 */
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve genuine static files (css, js, images, fonts) directly
if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
    return false;
}

// Everything else → Laravel
require __DIR__ . '/index.php';
