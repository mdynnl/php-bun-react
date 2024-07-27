<?php
require __DIR__ . '/config.php';
require __DIR__ . '/cache.php';

header('content-type: application/javascript');

$file = $_GET['file'];
$bun = BUN;
if (file_exists($file)) {
    $value = cache()->get($file . stat($file)['mtime'], fn () => `NODE_ENV=production $bun build -e react -e react-dom --minify $file 2>&1`);

    $etag = md5($value);

    if (($_SERVER['HTTP_IF_NONE_MATCH'] ?? null) == $etag) {
        header('HTTP/1.1 304 Not Modified');
        header_remove("Cache-Control");
        header_remove("Pragma");
        header_remove("Expires");
    } else {
        header('Etag: ' . $etag . '');
        header_remove("Cache-Control");
        header_remove("Pragma");
        header_remove("Expires");

        echo $value;
    }
}
