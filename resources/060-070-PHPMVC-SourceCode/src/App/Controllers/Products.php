<?php

namespace App\Controllers;

class Products
{
    public function index()
    {
        $model = new \App\Models\Product;

        $products = $model->getData();

        require "views/products_index.php";
    }

    public function show()
    {
        require "views/products_show.php";
    }
}