<?php

class Home
{
    public function index()
    {
        require 'src/models/article.php';

        $model = new Article;

        $articles = $model->getData();

        require 'views/home_index.php';
    }

    // TODO NEW
    public function show()
    {
        require 'views/home_show.php';
    }
}
