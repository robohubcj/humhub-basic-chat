<?php
namespace humhub\modules\humhubchat;

use Yii;
use yii\helpers\Url;
use humhub\modules\humhubchat\widgets\ChatFrame;
use humhub\modules\humhubchat\Assets;
use humhub\modules\humhubchat\models\UserChatMessage;
use humhub\models\Setting;

class Events extends \yii\base\Object
{

    public static function addChatFrame($event)
    {
        if (Yii::$app->user->isGuest) {
            return;
        }
        $event->sender->view->registerAssetBundle(Assets::className());
        $event->sender->addWidget(ChatFrame::className(), [], [
            'sortOrder' => 0
        ]);
        $event->sender->view->registerjsVar('chat_ListUsers', Url::to([
            '/humhub_chat/chat/users'
        ]));
        $event->sender->view->registerjsVar('chat_Submit', Url::to([
            '/humhub_chat/chat/submit'
        ]));
        $event->sender->view->registerjsVar('chat_GetChats', Url::to([
            '/humhub_chat/chat/chats'
        ]));
    }

    public static function onDailyCron($event)
    {
        $controller = $event->sender;
        $controller->stdout("Deleting old chat_messages... ");
        
        $timeout = Setting::Get('timeout', 'humhub_chat');
        if (! $timeout || $timeout == null || $timeout <= 0) {
            $controller->stdout('skipped! no timeout set.' . PHP_EOL, \yii\helpers\Console::FG_YELLOW);
            return;
        }
        
        // delete old chats
        UserChatMessage::deleteAll([
            '<',
            'created_at',
            Yii::$app->formatter->asDatetime(strtotime("- $timeout day"), 'php:Y-m-d H:i:s')
        ]);
        
        $controller->stdout('done.' . PHP_EOL, \yii\helpers\Console::FG_GREEN);
    }

    public static function onAdminMenuInit(\yii\base\Event $event)
    {
        $event->sender->addItem([
            'label' => Yii::t('HumhubChatModule.base', 'Basic Chat'),
            'url' => Url::to(['/humhub_chat/admin']),
            'group' => 'settings',
            'icon' => '<i class="fa fa-weixin"></i>',
            'isActive' => Yii::$app->controller->module && Yii::$app->controller->module->id == 'humhub_chat' && Yii::$app->controller->id == 'admin',
            'sortOrder' => 650
        ]);
    }
}
