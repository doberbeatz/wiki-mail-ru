<?php

return [
    '/'   => 'site/main',
    [
        'pattern'      => '<path:[a-zA-Z0-9_\/]+>/add/',
        'route'        => 'pages/create',
        'encodeParams' => false,
    ],
    'add' => 'pages/create',
    [
        'pattern'      => '<path:[a-zA-Z0-9_\/]+>/edit/',
        'route'        => 'pages/edit',
        'encodeParams' => false,
    ],
    [
        'pattern'      => '<path:[a-zA-Z0-9_\/]+>/delete/',
        'route'        => 'pages/delete',
        'encodeParams' => false,
    ],
    [
        'pattern'      => '<path:[a-zA-Z0-9_\/]+>/',
        'route'        => 'pages/show',
        'encodeParams' => false,
    ],
];