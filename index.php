<?php

namespace App;

require_once 'src/Application.php';
require_once 'src/Template.php';
require_once 'src/DB.php';

use function App\render;

$app = new Application();

$app->get('/', function () {
    $itemOnPage = 5;
    if (empty($_GET['page'])) {
        $page = 1;
    } elseif (array_key_exists('page', $_GET)) {
        $page = $_GET['page'];
    }
    $offset = ($page - 1) * $itemOnPage;
    $db = DB::connect();
    $args['news'] = $db->query("SELECT * from news ORDER BY idate DESC LIMIT $offset, $itemOnPage")->fetchAll();
    $pages = $db->query("SELECT COUNT(*) from news ")->fetchColumn();
    $args['pages'] = ceil($pages / $itemOnPage);
    return render('views/news.phtml', $args);
});

$app->get('/view', function () {
    $id = $_GET['id'];
    $db = DB::connect();
    $args['news'] = $db->query("SELECT * from news WHERE id=$id")->fetchAll();
    return render('views/view.phtml', $args);
});


$app->run();