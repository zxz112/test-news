<?php

namespace App;

require_once 'Application.php';
require_once 'Template.php';
require_once 'DB.php';

use function App\render;

$app = new Application();

$app->get('/', function () {
    $itemOnPage = 5;
    if (empty($_GET['page'])) {
        $page = 1;
    } elseif (array_key_exists('page', $_GET)) {
        $page = $_GET['page'];
    }
        $con = DB::connect();
        $args['news'] = $con->query("SELECT * from news LIMIT $page, $itemOnPage")->fetchAll();
        $pages = $con->query("SELECT COUNT(*) from news ")->fetchColumn();
        $args['pages'] = ceil($pages / $itemOnPage);
        return render('views/news.phtml', $args);
});

$app->get('/view', function () {
    $con = new \PDO("mysql:host=localhost;dbname=tests", 'root', 'root', array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $id = $_GET['id'];
    $args['news'] = $con->query("SELECT * from news WHERE id=$id")->fetchAll();
    return render('views/view.phtml', $args);
});


$app->run();