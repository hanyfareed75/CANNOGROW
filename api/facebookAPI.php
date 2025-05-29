<?php
require_once __DIR__.'/../config/database.php';

// Force UTF-8 for entire script
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_regex_encoding('UTF-8');

// Set proper headers
header('Content-Type: application/json; charset=utf-8');

// Create database connection using Database class
try {
    $database = new Database();
    $pdo = $database->connect();
    $pdo->exec("SET NAMES utf8mb4");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    $pdo->exec("SET character_set_connection = utf8mb4");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    die(json_encode(['error' => 'Connection failed: ' . $e->getMessage()]));
}

// Add at the top after UTF-8 settings
function debug_log($message, $data = null) {
    $log = date('Y-m-d H:i:s') . " - " . $message;
    if ($data) {
        $log .= "\n" . print_r($data, true);
    }
    echo json_encode(['debug' => $log]) . "\n";
}

// Modified insert function to use PDO
function insertMessage($pdo, $conversation_id, $sender_id, $sender_name, $message_text, $timestamp, $additional_data = []) {
    try {
        debug_log("Attempting to insert message", [
            'conversation_id' => $conversation_id,
            'sender_id' => $sender_id,
            'message_text' => $message_text
        ]);

        // First verify if message already exists
        $check = $pdo->prepare("SELECT id FROM messages WHERE conversation_id = ? AND sender_id = ? AND timestamp = ?");
        $check->execute([$conversation_id, $sender_id, $timestamp]);
        
        if ($check->rowCount() > 0) {
            debug_log("Message already exists, skipping");
            return true;
        }

        $stmt = $pdo->prepare("
            INSERT INTO messages (
                conversation_id, 
                sender_id, 
                sender_name, 
                message_text, 
                timestamp,
                attachments, 
                reactions, 
                shares, 
                sticker_id, 
                tags, 
                recipients, 
                message_tags
            ) VALUES (
                :conv_id, 
                :sender_id, 
                :sender_name, 
                :msg_text, 
                :timestamp,
                :attachments, 
                :reactions, 
                :shares, 
                :sticker_id, 
                :tags, 
                :recipients, 
                :message_tags
            )
        ");
        
        $params = [
            ':conv_id' => $conversation_id,
            ':sender_id' => $sender_id,
            ':sender_name' => $sender_name,
            ':msg_text' => $message_text,
            ':timestamp' => $timestamp,
            ':attachments' => isset($additional_data['attachments']) ? json_encode($additional_data['attachments']) : null,
            ':reactions' => isset($additional_data['reactions']) ? json_encode($additional_data['reactions']) : null,
            ':shares' => isset($additional_data['shares']) ? json_encode($additional_data['shares']) : null,
            ':sticker_id' => isset($additional_data['sticker']) ? $additional_data['sticker']['id'] : null,
            ':tags' => isset($additional_data['tags']) ? json_encode($additional_data['tags']) : null,
            ':recipients' => isset($additional_data['to']) ? json_encode($additional_data['to']) : null,
            ':message_tags' => isset($additional_data['message_tags']) ? json_encode($additional_data['message_tags']) : null
        ];

        debug_log("Executing insert with params", $params);
        
        $success = $stmt->execute($params);

        if (!$success) {
            debug_log("Insert failed", $stmt->errorInfo());
            throw new PDOException("Execute failed: " . print_r($stmt->errorInfo(), true));
        }

        debug_log("Insert successful, rows affected: " . $stmt->rowCount());
        return true;
    } catch (PDOException $e) {
        debug_log("PDO Exception", $e->getMessage());
        echo json_encode(['error' => 'Insert failed: ' . $e->getMessage()]);
        return false;
    }
}

// Modified fetchFromFacebook function
function fetchFromFacebook($url) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_ENCODING => '',
        CURLOPT_HTTPHEADER => [
            'Accept-Charset: utf-8',
            'Content-Type: application/json; charset=utf-8'
        ]
    ]);
    
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        debug_log("cURL Error", curl_error($ch));
        curl_close($ch);
        return null;
    }
    
    curl_close($ch);
    
    $data = json_decode($response, true, 512, JSON_UNESCAPED_UNICODE);
    
    if (isset($data['error'])) {
        debug_log("Facebook API Error", $data['error']);
        return null;
    }
    
    return $data;
}

// إعدادات الاتصال
$access_token = "EAAJniHVOOxEBOZBcYlSVrMn1hmfI3fuqCdj5e2ZCMfT4GcwM94o1W35O1qwKpKEaqGc0f5bWLfnRZCRZALy3QgfZCnrvoz85bFBZAGYMmBFhDRhCEN1o8Fsribu9bZAR6rFzUAZBtaiOuwUBG06ZCbPpMbqhPe1BhBGIxVbgek52ImmMjLzoZAgYjj9a1dbadhbvSEJvIXdGZBkgWDR9EyF2sYiNnEZD";
$page_id = "605107702675224";
$api_version = "v18.0";

// الاتصال بقاعدة البيانات

// دالة لاستدعاء API باستخدام cURL
 
// Add at the top of the file after mysqli connection
function sleep_between_requests() {
    usleep(200000); // 200ms delay
}

// جلب المحادثات
$conversations_url = "https://graph.facebook.com/{$api_version}/{$page_id}/conversations?access_token={$access_token}";
$conversations = fetchFromFacebook($conversations_url);

if (!isset($conversations['data'])) {
    die("❌ فشل في جلب المحادثات.");
}

// معالجة كل محادثة
foreach ($conversations['data'] as $conversation) {
    debug_log("Processing conversation", $conversation['id']);
    $conversation_id = $conversation['id'];
    
    // Update the messages URL to use the proper endpoint
    $messages_url = "https://graph.facebook.com/{$api_version}/{$conversation_id}/messages?fields=".
                "message,". // Message content
                "from,". // Sender info
                "created_time,". // Timestamp
                "id". // Message ID
                "&access_token={$access_token}";

    $messages = fetchFromFacebook($messages_url);

    // Add after fetching messages
    debug_log("Facebook API Response for messages", [
        'url' => $messages_url,
        'response' => $messages
    ]);

    // Add this check after fetching messages
    if (empty($messages)) {
        debug_log("Empty response for conversation", [
            'conversation_id' => $conversation_id,
            'url' => $messages_url
        ]);
        continue;
    }

    if (isset($messages['error'])) {
        debug_log("Error fetching messages", [
            'conversation_id' => $conversation_id,
            'error' => $messages['error']
        ]);
        continue;
    }

    if (!isset($messages['data'])) {
        debug_log("No messages found for conversation", $conversation_id);
        continue;
    } else {
        debug_log("Found messages", [
            'conversation_id' => $conversation_id,
            'message_count' => count($messages['data'])
        ]);
    }

    foreach ($messages['data'] as $message) {
        debug_log("Processing message", [
            'message_id' => $message['id'] ?? 'unknown',
            'from' => $message['from'] ?? 'unknown',
            'message_text' => $message['message'] ?? 'no text'
        ]);

        // Remove the extra user info fetch since we already have the name from the message
        if (isset($message['from']['id'])) {
            $sender_id = $message['from']['id'];
            $sender_name = $message['from']['name'] ?? 'Unknown';
        } else {
            $sender_id = 'unknown';
            $sender_name = 'Unknown';
        }

        $message_text = isset($message['message']) ? $message['message'] : '';
        $timestamp = date("Y-m-d H:i:s", strtotime($message['created_time']));

        $additional_data = [
            'attachments' => $message['attachments']['data'] ?? null,
            'reactions' => $message['reactions']['data'] ?? null,
            'shares' => $message['shares'] ?? null,
            'sticker' => $message['sticker'] ?? null,
            'tags' => $message['tags'] ?? null,
            'to' => $message['to'] ?? null,
            'message_tags' => $message['message_tags'] ?? null
        ];

        debug_log("Attempting to insert message with data", [
            'conversation_id' => $conversation_id,
            'sender_id' => $sender_id,
            'sender_name' => $sender_name,
            'message_text' => $message_text,
            'timestamp' => $timestamp,
            'has_attachments' => isset($additional_data['attachments']),
            'has_reactions' => isset($additional_data['reactions'])
        ]);

        if (!insertMessage($pdo, $conversation_id, $sender_id, $sender_name, $message_text, $timestamp, $additional_data)) {
            debug_log("❌ Failed to insert message", [
                'conversation_id' => $conversation_id,
                'message_text' => $message_text
            ]);
            continue;
        } else {
            debug_log("✅ Successfully inserted message", [
                'conversation_id' => $conversation_id,
                'message_id' => $message['id'] ?? 'unknown'
            ]);
        }
    }
}

echo json_encode(['success' => true, 'message' => '✅ تم سحب وتخزين الرسائل بنجاح.']);
$database->close();
?>
