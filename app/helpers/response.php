<?php
/**
 * Response Helper Functions
 * Functions for API/AJAX responses
 */

/**
 * Send JSON response
 */
function jsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

/**
 * Success response
 */
function successResponse($message = 'Success', $data = null, $statusCode = 200) {
    $response = [
        'success' => true,
        'message' => $message
    ];
    
    if ($data !== null) {
        $response['data'] = $data;
    }
    
    jsonResponse($response, $statusCode);
}

/**
 * Error response
 */
function errorResponse($message = 'Error', $errors = null, $statusCode = 400) {
    $response = [
        'success' => false,
        'message' => $message
    ];
    
    if ($errors !== null) {
        $response['errors'] = $errors;
    }
    
    jsonResponse($response, $statusCode);
}

/**
 * Validation error response
 */
function validationErrorResponse($errors, $message = 'Validation failed') {
    errorResponse($message, $errors, 422);
}

/**
 * Not found response
 */
function notFoundResponse($message = 'Resource not found') {
    errorResponse($message, null, 404);
}

/**
 * Unauthorized response
 */
function unauthorizedResponse($message = 'Unauthorized') {
    errorResponse($message, null, 401);
}

/**
 * Forbidden response
 */
function forbiddenResponse($message = 'Forbidden') {
    errorResponse($message, null, 403);
}

/**
 * Server error response
 */
function serverErrorResponse($message = 'Internal server error') {
    errorResponse($message, null, 500);
}

/**
 * Paginated response
 */
function paginatedResponse($data, $total, $page, $perPage, $message = 'Success') {
    $lastPage = ceil($total / $perPage);
    
    $response = [
        'success' => true,
        'message' => $message,
        'data' => $data,
        'pagination' => [
            'total' => (int)$total,
            'per_page' => (int)$perPage,
            'current_page' => (int)$page,
            'last_page' => (int)$lastPage,
            'from' => (($page - 1) * $perPage) + 1,
            'to' => min($page * $perPage, $total)
        ]
    ];
    
    jsonResponse($response);
}

/**
 * Download response (for file downloads)
 */
function downloadResponse($filePath, $fileName = null, $mimeType = null) {
    if (!file_exists($filePath)) {
        http_response_code(404);
        die('File not found');
    }
    
    $fileName = $fileName ?? basename($filePath);
    $mimeType = $mimeType ?? mime_content_type($filePath);
    
    header('Content-Type: ' . $mimeType);
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    header('Content-Length: ' . filesize($filePath));
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    readfile($filePath);
    exit;
}

/**
 * CSV download response
 */
function csvResponse($data, $fileName = 'export.csv', $headers = []) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
    $output = fopen('php://output', 'w');
    
    // Add BOM for UTF-8
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
    
    // Add headers if provided
    if (!empty($headers)) {
        fputcsv($output, $headers);
    }
    
    // Add data
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    
    fclose($output);
    exit;
}

/**
 * Excel download response (simple CSV with .xlsx extension)
 */
function excelResponse($data, $fileName = 'export.xlsx', $headers = []) {
    // For simple Excel export, we use CSV format
    // For complex Excel, you need PHPSpreadsheet library
    $fileName = str_replace('.xlsx', '.csv', $fileName);
    csvResponse($data, $fileName, $headers);
}

/**
 * PDF response (requires PDF library like TCPDF or FPDF)
 */
function pdfResponse($html, $fileName = 'document.pdf', $orientation = 'P') {
    // This is a placeholder - you need to implement with PDF library
    // Example with TCPDF or FPDF
    
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
    // Your PDF generation code here
    echo "PDF generation requires PDF library (TCPDF/FPDF)";
    exit;
}

/**
 * Check if request is AJAX
 */
function isAjaxRequest() {
    return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
}

/**
 * Check if request method is POST
 */
function isPostRequest() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Check if request method is GET
 */
function isGetRequest() {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Check if request method is PUT
 */
function isPutRequest() {
    return $_SERVER['REQUEST_METHOD'] === 'PUT';
}

/**
 * Check if request method is DELETE
 */
function isDeleteRequest() {
    return $_SERVER['REQUEST_METHOD'] === 'DELETE';
}

/**
 * Get request input (works for all methods)
 */
function getInput($key = null, $default = null) {
    $input = [];
    
    // Get POST data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = $_POST;
    }
    
    // Get PUT/DELETE data from php://input
    if (in_array($_SERVER['REQUEST_METHOD'], ['PUT', 'DELETE', 'PATCH'])) {
        parse_str(file_get_contents('php://input'), $input);
    }
    
    // Get GET data
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $input = $_GET;
    }
    
    // Get JSON data
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (strpos($contentType, 'application/json') !== false) {
        $json = file_get_contents('php://input');
        $input = json_decode($json, true) ?? [];
    }
    
    if ($key === null) {
        return $input;
    }
    
    return $input[$key] ?? $default;
}

/**
 * Get all request headers
 */
function getHeaders() {
    if (function_exists('getallheaders')) {
        return getallheaders();
    }
    
    $headers = [];
    foreach ($_SERVER as $name => $value) {
        if (substr($name, 0, 5) == 'HTTP_') {
            $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
    }
    return $headers;
}

/**
 * Get specific header
 */
function getHeader($name) {
    $headers = getHeaders();
    return $headers[$name] ?? null;
}

/**
 * Set response header
 */
function setHeader($name, $value) {
    header("{$name}: {$value}");
}

/**
 * Set multiple headers
 */
function setHeaders($headers) {
    foreach ($headers as $name => $value) {
        setHeader($name, $value);
    }
}

/**
 * CORS headers for API
 */
function setCorsHeaders($allowedOrigins = ['*']) {
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    if (in_array('*', $allowedOrigins) || in_array($origin, $allowedOrigins)) {
        header('Access-Control-Allow-Origin: ' . ($origin ?: '*'));
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }
    
    // Handle preflight request
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit;
    }
}

/**
 * Rate limit response
 */
function rateLimitResponse($retryAfter = 60) {
    header('Retry-After: ' . $retryAfter);
    errorResponse('Too many requests. Please try again later.', null, 429);
}

/**
 * Redirect response
 */
function redirectResponse($url, $statusCode = 302) {
    header('Location: ' . $url, true, $statusCode);
    exit;
}

/**
 * Back response (redirect to previous page)
 */
function backResponse() {
    $referer = $_SERVER['HTTP_REFERER'] ?? url('/');
    redirectResponse($referer);
}