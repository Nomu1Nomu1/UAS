<?php
// UAS/index.php
require_once __DIR__ . '/config/db.php';

$request_uri = $_SERVER['REQUEST_URI'];
$base_folder = '/pw/UAS';

// Hilangkan base folder dari URL
$uri = str_replace($base_folder, '', $request_uri);
$uri = trim($uri, '/');

// Default ke login jika kosong
if (empty($uri) || $uri === 'index.php') {
    $uri = 'auth/login';
}

$segments = explode('/', $uri);
$controllerName = ucfirst(strtolower($segments[0] ?? 'auth')) . 'Controller';
$method         = $segments[1] ?? 'login';

// Untuk debug (sementara)
echo "<!-- DEBUG URL: $request_uri → $uri | Controller: $controllerName | Method: $method -->";

$controllerFile = __DIR__ . "/controller/{$controllerName}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    $controller = new $controllerName();
    
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        die("Method <b>$method</b> tidak ditemukan di controller <b>$controllerName</b>");
    }
} else {
    die("Controller <b>$controllerName</b> tidak ditemukan.<br>
         Path yang dicari: <b>$controllerFile</b><br><br>
         <a href='{$base_folder}/auth/login'>→ Ke Halaman Login</a>");
}