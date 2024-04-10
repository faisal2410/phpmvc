<?php

//class Controller   // TODO changed
class Home
{
    public function index()
    {
        //require 'model.php';   // TODO changed
        require 'src/models/article.php';

        //$model = new Model;  // TODO changed
        $model = new Article;

        $articles = $model->getData();

        require 'view.php';
    }

}
