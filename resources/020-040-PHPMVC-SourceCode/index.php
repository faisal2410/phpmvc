<?php

require "model.php";

$model = new Model;

$products = $model->getData();

require "view.php";