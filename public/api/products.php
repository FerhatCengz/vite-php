<?php
require_once "verify-token.php";

$products = array(
    array("id" => 1, "name" => "Product 1", "price" => 100),
    array("id" => 2, "name" => "Product 2", "price" => 200),
    array("id" => 3, "name" => "Product 3", "price" => 300),
    array("id" => 4, "name" => "Product 4", "price" => 400),
    array("id" => 5, "name" => "Product 5", "price" => 500),
);

echo json_encode($products);