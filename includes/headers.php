<?php
// Allow requests from any origin
header('Access-Control-Allow-Origin: *');
// Allow all HTTP methods
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
// Allow specific headers
header('Access-Control-Allow-Headers: Content-Type');
// Content type
header('Content-Type: application/json');
?>