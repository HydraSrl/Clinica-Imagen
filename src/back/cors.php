<?php
/**
 * CORS Configuration
 * Include this file at the beginning of API endpoints to enable CORS
 */

// Allow requests from any origin (adjust as needed for production)
header('Access-Control-Allow-Origin: *');

// Allow specific HTTP methods
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

// Allow specific headers
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

// Allow credentials (cookies, authorization headers, etc.)
header('Access-Control-Allow-Credentials: true');

// Cache preflight requests for 1 hour
header('Access-Control-Max-Age: 3600');

// Set content type to JSON by default for API responses
header('Content-Type: application/json; charset=UTF-8');

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}
?>
