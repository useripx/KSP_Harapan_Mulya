<?php
/**
 * ChatbotController Class
 * Manages chatbot interactions
 */

require_once APP_PATH . '/services/GroqService.php';

class ChatbotController extends Controller {
    private $groqService;

    public function __construct() {
        parent::__construct();
        $this->groqService = new GroqService();
    }

    /**
     * Handle chatbot request
     */
    public function ask() {
        // --- CORS FIX START ---
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '*';
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, X-CSRF-TOKEN, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");

        // Handle preflight OPTIONS request
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }
        // --- CORS FIX END ---

        $logFile = $this->config['paths']['storage'] . '/logs/ai_debug.log';
        
        // Ambil remote address dengan aman
        $remoteAddr = $_SERVER['REMOTE_ADDR'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? 'unknown';
        
        // Logging request masuk (Debugging)
        error_log("[Chatbot] Request masuk dari: " . $remoteAddr . "\n", 3, $logFile);
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            error_log("[Chatbot] Gagal: Method bukan POST\n", 3, $logFile);
            return $this->jsonResponse(['error' => 'Method not allowed'], 405);
        }

        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize or increment message counter
        if (!isset($_SESSION['chatbot_message_count'])) {
            $_SESSION['chatbot_message_count'] = 0;
        }
        
        // Limit to 30 messages per session
        if ($_SESSION['chatbot_message_count'] >= 30) {
            error_log("[Chatbot] Gagal: Limit sesi tercapai (30)\n", 3, $logFile);
            return $this->jsonResponse(['error' => 'Batas chat sesi ini (30 pesan) telah tercapai. Silakan segarkan halaman untuk memulai sesi baru.'], 429);
        }

        $json = file_get_contents('php://input');
        error_log("[Chatbot] Data mentah: " . $json . "\n", 3, $logFile);
        
        $input = json_decode($json, true);
        $message = $input['message'] ?? '';
        $history = $input['history'] ?? [];

        if (empty($message)) {
            error_log("[Chatbot] Gagal: Pesan kosong\n", 3, $logFile);
            return $this->jsonResponse(['error' => 'Pesan tidak boleh kosong'], 400);
        }

        // Increment count BEFORE calling AI
        $_SESSION['chatbot_message_count']++;

        try {
            error_log("[Chatbot] Memanggil GroqService untuk pesan: " . $message . "\n", 3, $logFile);
            $response = $this->groqService->ask($message, $history);
            error_log("[Chatbot] Respon diterima dari AI\n", 3, $logFile);
            
            // Jika ada prefix Error:, kirim sebagai error JSON
            if (strpos($response, 'Error:') === 0) {
                $cleanError = str_replace('Error: ', '', $response);
                return $this->jsonResponse(['error' => $cleanError], 400);
            }

            return $this->jsonResponse(['response' => $response]);
        } catch (Exception $e) {
            error_log("[Chatbot] EXCEPTION: " . $e->getMessage() . "\n", 3, $logFile);
            return $this->jsonResponse(['error' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Return JSON response
     */
    private function jsonResponse($data, $code = 200) {
        // Bersihkan output buffer jika ada (menjamin respon JSON murni)
        if (ob_get_length()) ob_clean();
        
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
