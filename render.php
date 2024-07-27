<?php
require __DIR__ . '/config.php';
require __DIR__ . '/cache.php';

function renderToString($name, $data = [], $base = __DIR__, $bun = BUN)
{
    $file = implode('/', [$base, $name]);
    if (!file_exists($file)) {
        throw new Exception("$file not found");
        return null;
    }

    $json = json_encode($data);

    $render = implode('/', [$base, 'render.jsx']);

    $key = sha1($render . stat($render)['mtime'] . $file . stat($file)['mtime'] . $json);

    $value = cache()->get($key, fn () => `$bun $render $file '$json'`);

    return toIsland($name, $json, $value);
}

function toIsland($name, $json, $html)
{
    $id = uniqid('r-');
    return <<<html
<div data-id="$id">$html</div>
<script type="module">
import React from 'react'
import ReactDOM from 'react-dom/client'
import App from './bun.php?file=$name'
ReactDOM.hydrateRoot(document.querySelector('[data-id="$id"]'), React.createElement(App, $json))
</script>
html;
}

function render($file, $data = [])
{
    echo renderToString($file, $data);
}
