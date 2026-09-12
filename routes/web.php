<?php
$routes = [
    'GET' => [
        '/'                 => ['HomeController', 'index'],
        '/login'            => ['AuthController', 'loginForm'],
        '/logout'           => ['AuthController', 'logout'],   // ⬅️ tambahkan ini kalau belum ada
        '/dashboard'        => ['AuthController', 'dashboard', 'middleware' => ['App\Core\Middleware\AuthMiddleware']],
        '/mahasiswa'        => ['MahasiswaController', 'index', 'middleware' => ['App\Core\Middleware\AuthMiddleware']],
        '/mahasiswa/create' => ['MahasiswaController', 'create', 'middleware' => ['App\Core\Middleware\AuthMiddleware']],
    ],
    'POST' => [
        '/login'     => ['AuthController', 'login'],
        '/mahasiswa' => ['MahasiswaController', 'store', 'middleware' => ['App\Core\Middleware\AuthMiddleware']],
    ],
];