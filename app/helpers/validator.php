<?php
/**
 * Validator Helper Functions
 * Functions for input validation
 */

/**
 * Validate required field
 */
function validateRequired($value, $fieldName = 'Field') {
    if (empty($value) && $value !== '0') {
        return "{$fieldName} harus diisi";
    }
    return true;
}

/**
 * Validate email
 */
function validateEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Format email tidak valid";
    }
    return true;
}

/**
 * Validate phone number (Indonesian format)
 */
function validatePhone($phone) {
    $pattern = '/^(\+62|62|0)[0-9]{9,12}$/';
    if (!preg_match($pattern, $phone)) {
        return "Format nomor telepon tidak valid";
    }
    return true;
}

/**
 * Validate minimum length
 */
function validateMinLength($value, $min, $fieldName = 'Field') {
    if (strlen($value) < $min) {
        return "{$fieldName} minimal {$min} karakter";
    }
    return true;
}

/**
 * Validate maximum length
 */
function validateMaxLength($value, $max, $fieldName = 'Field') {
    if (strlen($value) > $max) {
        return "{$fieldName} maksimal {$max} karakter";
    }
    return true;
}

/**
 * Validate numeric
 */
function validateNumeric($value, $fieldName = 'Field') {
    if (!is_numeric($value)) {
        return "{$fieldName} harus berupa angka";
    }
    return true;
}

/**
 * Validate integer
 */
function validateInteger($value, $fieldName = 'Field') {
    if (!filter_var($value, FILTER_VALIDATE_INT)) {
        return "{$fieldName} harus berupa bilangan bulat";
    }
    return true;
}

/**
 * Validate decimal
 */
function validateDecimal($value, $fieldName = 'Field') {
    if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
        return "{$fieldName} harus berupa angka desimal";
    }
    return true;
}

/**
 * Validate minimum value
 */
function validateMin($value, $min, $fieldName = 'Field') {
    if ($value < $min) {
        return "{$fieldName} minimal {$min}";
    }
    return true;
}

/**
 * Validate maximum value
 */
function validateMax($value, $max, $fieldName = 'Field') {
    if ($value > $max) {
        return "{$fieldName} maksimal {$max}";
    }
    return true;
}

/**
 * Validate date format
 */
function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    if (!$d || $d->format($format) !== $date) {
        return "Format tanggal tidak valid";
    }
    return true;
}

/**
 * Validate URL
 */
function validateUrl($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return "Format URL tidak valid";
    }
    return true;
}

/**
 * Validate alphabetic
 */
function validateAlpha($value, $fieldName = 'Field') {
    if (!preg_match('/^[a-zA-Z\s]+$/', $value)) {
        return "{$fieldName} hanya boleh berisi huruf";
    }
    return true;
}

/**
 * Validate alphanumeric
 */
function validateAlphaNumeric($value, $fieldName = 'Field') {
    if (!preg_match('/^[a-zA-Z0-9\s]+$/', $value)) {
        return "{$fieldName} hanya boleh berisi huruf dan angka";
    }
    return true;
}

/**
 * Validate in array
 */
function validateIn($value, $array, $fieldName = 'Field') {
    if (!in_array($value, $array)) {
        return "{$fieldName} tidak valid";
    }
    return true;
}

/**
 * Validate unique in database
 */
function validateUnique($table, $column, $value, $excludeId = null) {
    $db = db();
    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?";
    $params = [$value];
    
    if ($excludeId) {
        $sql .= " AND id != ?";
        $params[] = $excludeId;
    }
    
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch();
    
    if ($result['count'] > 0) {
        return "{$column} sudah digunakan";
    }
    
    return true;
}

/**
 * Validate exists in database
 */
function validateExists($table, $column, $value) {
    $db = db();
    $stmt = $db->prepare("SELECT COUNT(*) as count FROM {$table} WHERE {$column} = ?");
    $stmt->execute([$value]);
    $result = $stmt->fetch();
    
    if ($result['count'] === 0) {
        return "{$column} tidak ditemukan";
    }
    
    return true;
}

/**
 * Validate file upload
 */
function validateFile($file, $maxSize = 5242880, $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png']) {
    if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
        return "File tidak valid";
    }
    
    // Check file size
    if ($file['size'] > $maxSize) {
        $maxSizeMB = $maxSize / 1048576;
        return "Ukuran file maksimal {$maxSizeMB}MB";
    }
    
    // Check file type
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedTypes)) {
        return "Tipe file hanya boleh: " . implode(', ', $allowedTypes);
    }
    
    return true;
}

/**
 * Validate image file
 */
function validateImage($file, $maxSize = 2097152) {
    $validation = validateFile($file, $maxSize, ['jpg', 'jpeg', 'png', 'gif']);
    
    if ($validation !== true) {
        return $validation;
    }
    
    // Check if it's really an image
    $imageInfo = getimagesize($file['tmp_name']);
    if (!$imageInfo) {
        return "File bukan gambar yang valid";
    }
    
    return true;
}

/**
 * Validate password strength
 */
function validatePasswordStrength($password, $minLength = 6) {
    if (strlen($password) < $minLength) {
        return "Password minimal {$minLength} karakter";
    }
    
    // Check for at least one letter and one number
    if (!preg_match('/[a-zA-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        return "Password harus mengandung huruf dan angka";
    }
    
    return true;
}

/**
 * Validate password confirmation
 */
function validatePasswordConfirmation($password, $confirmation) {
    if ($password !== $confirmation) {
        return "Konfirmasi password tidak cocok";
    }
    return true;
}

/**
 * Comprehensive validator function
 */
function validate($data, $rules) {
    $errors = [];
    
    foreach ($rules as $field => $ruleString) {
        $ruleArray = explode('|', $ruleString);
        $value = $data[$field] ?? '';
        
        foreach ($ruleArray as $rule) {
            $params = [];
            
            // Parse rule with parameters (e.g., "min:5")
            if (strpos($rule, ':') !== false) {
                list($rule, $paramString) = explode(':', $rule, 2);
                $params = explode(',', $paramString);
            }
            
            $result = true;
            $fieldLabel = ucfirst(str_replace('_', ' ', $field));
            
            switch ($rule) {
                case 'required':
                    $result = validateRequired($value, $fieldLabel);
                    break;
                    
                case 'email':
                    if (!empty($value)) {
                        $result = validateEmail($value);
                    }
                    break;
                    
                case 'phone':
                    if (!empty($value)) {
                        $result = validatePhone($value);
                    }
                    break;
                    
                case 'min':
                    if (!empty($value)) {
                        $result = validateMinLength($value, $params[0], $fieldLabel);
                    }
                    break;
                    
                case 'max':
                    if (!empty($value)) {
                        $result = validateMaxLength($value, $params[0], $fieldLabel);
                    }
                    break;
                    
                case 'numeric':
                    if (!empty($value)) {
                        $result = validateNumeric($value, $fieldLabel);
                    }
                    break;
                    
                case 'integer':
                    if (!empty($value)) {
                        $result = validateInteger($value, $fieldLabel);
                    }
                    break;
                    
                case 'min_value':
                    if (!empty($value)) {
                        $result = validateMin($value, $params[0], $fieldLabel);
                    }
                    break;
                    
                case 'max_value':
                    if (!empty($value)) {
                        $result = validateMax($value, $params[0], $fieldLabel);
                    }
                    break;
                    
                case 'date':
                    if (!empty($value)) {
                        $format = $params[0] ?? 'Y-m-d';
                        $result = validateDate($value, $format);
                    }
                    break;
                    
                case 'unique':
                    if (!empty($value)) {
                        $table = $params[0];
                        $column = $params[1] ?? $field;
                        $excludeId = $data['id'] ?? null;
                        $result = validateUnique($table, $column, $value, $excludeId);
                    }
                    break;
                    
                case 'exists':
                    if (!empty($value)) {
                        $table = $params[0];
                        $column = $params[1] ?? $field;
                        $result = validateExists($table, $column, $value);
                    }
                    break;
            }
            
            if ($result !== true) {
                $errors[$field] = $result;
                break; // Stop validating this field
            }
        }
    }
    
    return $errors;
}