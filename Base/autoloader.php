<?php

spl_autoload_register(function ($class) {
    $escaped = str_replace('\\', '/', $class);
    $removedPrefix = str_replace('QMVC/Base/', '', $escaped);
    $file = __DIR__ . $removedPrefix .'.php';
    if (file_exists($file)) {
        require_once($file);
    }
});
?>