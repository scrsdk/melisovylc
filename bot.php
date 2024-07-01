<?php
// Ваш токен Telegram Bot
$botToken = '7400122239:AAGMXs7H0hAHAIfnwoU5FAd2DAMHgGUwLUs';
$webAppUrl = 'https://your-web-app-url.com'; // URL вашего Web App

// Получение обновлений от Telegram
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    // Получение обновлений не удалось
    exit;
}

$message = $update['message'] ?? null;
if ($message) {
    $chatId = $message['chat']['id'];
    $text = $message['text'];

    if ($text === '/start') {
        $keyboard = [
            'inline_keyboard' => [
                [
                    [
                        'text' => 'Open Web App',
                        'web_app' => ['url' => $webAppUrl]
                    ]
                ]
            ]
        ];

        $response = [
            'chat_id' => $chatId,
            'text' => 'Click the button below to open the Web App:',
            'reply_markup' => json_encode($keyboard)
        ];

        sendTelegramMessage($botToken, $response);
    }
}

function sendTelegramMessage($botToken, $response) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.telegram.org/bot$botToken/sendMessage");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>
