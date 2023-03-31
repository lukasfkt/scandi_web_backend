<?php

use ScandiwebApp\classes\Product;

require_once('./vendor/autoload.php');
include_once('./db/credentials.php');

// Connection string
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Set the database for the classes
Product::set_database($database);
