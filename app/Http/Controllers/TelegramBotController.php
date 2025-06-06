<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;

class TelegramBotController extends Controller
{
    public function handle(Request $request)
    {
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $update = $telegram->getWebhookUpdate();

        $chatId = $update->getMessage()->getChat()->getId();
        $text = $update->getMessage()->getText();

        if ($text == "/start") {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Hello World',
            ]);
        }

        return 'ok';
    }
}
