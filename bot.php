<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ваш токен Telegram Bot
    $botToken = '7400122239:AAGMXs7H0hAHAIfnwoU5FAd2DAMHgGUwLUs';
    $webAppUrl = 'https://your-web-app-url.com'; // URL вашего Web App

    // Логирование входящих данных
    file_put_contents('php://stderr', print_r(file_get_contents('php://input'), true));

    // Получение обновлений от Telegram
    $input = file_get_contents('php://input');
    $update = json_decode($input, true);

    if (isset($update["message"])) {
        $chatId = $update["message"]["chat"]["id"];
        $text = $update["message"]["text"];

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

            file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?" . http_build_query($response));
        }
    }
} else {
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
