<?php

require 'Routing.php';
require_once './src/models/User.php';

session_start();

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);


Router::get('', 'SecurityController');
Router::get('guest', 'SecurityController');
Router::get('error404', 'DefaultController');

Router::post('login', 'SecurityController');
Router::post('password', 'SecurityController');
Router::post('password2', 'SecurityController');
Router::post('register', 'SecurityController');
Router::post('logout', 'SecurityController');
Router::post('search', 'MapsController');
Router::post('download', 'MapsController');




if (isset($_SESSION['email'])) {
    if ($_SESSION['role'] !== User::Guest) {
        Router::post('add_map', 'MapsController');
        Router::get('remove_map', 'MapsController');
        Router::get('like_map', 'MapsController');
        Router::get('remove_like', 'MapsController');
        Router::get('liked_maps', 'MapsController');
    }

    Router::post('map_info', 'MapsController');
    Router::get('maps', 'MapsController');
}


Router::run($path);