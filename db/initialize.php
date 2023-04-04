<?php

include_once('./db/credentials.php');

// Connection string
$database = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
