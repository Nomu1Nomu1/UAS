<?php
// UAS/index.php
require_once __DIR__ . '/config/db.php';

// ====================== ROUTER ======================
$request_uri = $_SERVER['REQUEST_URI'];
$base_folder = BASE_URL;   // dari config/db.php

// Bersihkan URI
$uri = str_replace($base_folder, '', $request_uri);
$uri = strtok(trim($uri, '/'), '?');

if (empty($uri) || $uri === 'index.php') {
    $uri = 'dashboard/index';        // ← Langsung ke Dashboard
}

$segments       = explode('/', $uri);
$controllerName = ucfirst(strtolower($segments[0] ?? 'dashboard')) . 'Controller';
$method         = $segments[1] ?? 'index';

$controllerFile = __DIR__ . "/controller/{$controllerName}.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    
    $controller = new $controllerName();
    
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        http_response_code(404);
        die("Method <b>{$method}</b> tidak ditemukan di controller <b>{$controllerName}</b>.");
    }
} else {
    http_response_code(404);
    die("Controller <b>{$controllerName}</b> tidak ditemukan.<br>
         Path: <b>{$controllerFile}</b><br><br>
         <a href='" . BASE_URL . "/dashboard/index'>→ Ke Dashboard</a>");
}