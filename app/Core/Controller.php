<?php

namespace App\Core;

/**
 * Base Controller: menyediakan method view() untuk merender file di
 * app/Views dengan layout utama, dan helper flash message sederhana.
 */
class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View {$view} tidak ditemukan.";
            return;
        }

        // Ambil isi view dulu ke buffer, baru suntikkan ke layout utama.
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        require __DIR__ . '/../Views/layouts/main.php';
    }

    protected function redirect(string $to): void
    {
        $prefix = defined('BASE_PATH') ? BASE_PATH : '';
        header("Location: {$prefix}{$to}");
        exit;
    }

    protected function flash(string $key, ?string $message = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($message !== null) {
            $_SESSION['flash'][$key] = $message;
            return null;
        }

        $value = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $value;
    }
}
