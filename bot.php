<?php
require 'vendor/autoload.php';

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

// Ваш токен Telegram Bot
$botToken = '7400122239:AAGMXs7H0hAHAIfnwoU5FAd2DAMHgGUwLUs';
$webAppUrl = 'https://your-web-app-url.com'; // URL вашего Web App

$telegram = new Api($botToken);

// Получение обновлений от Telegram
$updates = $telegram->getWebhookUpdates();

foreach ($updates as $update) {
    $message = $update->getMessage();
    $chatId = $message->getChat()->getId();
    $text = $message->getText();

    if ($text === '/start') {
        $keyboard = Keyboard::make()
            ->inline()
            ->row(
                Keyboard::inlineButton([
                    'text' => 'Open Web App',
                    'web_app' => ['url' => $webAppUrl]
                ])
            );

        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Click the button below to open the Web App:',
            'reply_markup' => $keyboard
        ]);
    }
}
?>