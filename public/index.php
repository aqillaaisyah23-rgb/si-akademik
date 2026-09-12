<?php
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $path = __DIR__ . '/../app/' . str_replace('\\', '/', $relative) . '.php';

    if (file_exists($path)) {
        require $path;
    }
});

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../routes/web.php';

// ------------------------------------------------------------------
// Base path project (dipakai untuk redirect & strip URI)
// ------------------------------------------------------------------
define('BASE_PATH', '/si-akademik/public');

function redirect(string $path): void
{
    header('Location: ' . BASE_PATH . $path);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (str_starts_with($uri, BASE_PATH)) {
    $uri = substr($uri, strlen(BASE_PATH)) ?: '/';
}

$method = $_SERVER['REQUEST_METHOD'];


if (isset($routes[$method][$uri])) {
    $route = $routes[$method][$uri];
    $controllerName = $route[0];
    $action = $route[1];

    // Jalankan middleware kalau ada
    $middlewareList = $route['middleware'] ?? [];
    foreach ($middlewareList as $mw) {
        $mwInstance = new $mw();
        $mwInstance->handle();
    }

    $controllerClass = "App\\Controllers\\{$controllerName}";
    $controller = new $controllerClass();
    $controller->$action();

} else {
    $segments = explode('/', trim($uri, '/')); // "/mahasiswa/5" -> ["mahasiswa", "5"]

    if (($segments[0] ?? '') === 'mahasiswa' && isset($segments[1]) && ctype_digit($segments[1])) {
        $id = (int) $segments[1];
        $controller = new App\Controllers\MahasiswaController();
        $aksi = $segments[2] ?? null;

        if ($method === 'GET' && count($segments) === 2) {
            $controller->show($id);
        } elseif ($method === 'GET' && $aksi === 'edit') {
            $controller->edit((string) $id);
        } elseif ($method === 'POST' && $aksi === 'update') {
            $controller->update((string) $id);
        } elseif ($method === 'POST' && $aksi === 'delete') {
            $controller->destroy((string) $id);
        } else {
            http_response_code(404);
            echo "404 - Halaman tidak ditemukan";
        }
    } else {
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
    }
}