<?php

$action = $_GET["action"];
$controller = $_GET["controller"];

if ($controller === "products") {

    require "src/controllers/products.php";

    $controller_object = new Products;

} elseif ($controller === "home") {

    require "src/controllers/home.php";

    $controller_object = new Home;
    
}

if ($action === "index") {

    $controller_object->index();

} elseif ($action === "show") {

    $controller_object->show();

}