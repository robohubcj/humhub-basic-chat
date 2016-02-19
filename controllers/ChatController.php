<?php
namespace humhub\modules\humhubchat\controllers;

use Yii;
use humhub\modules\User\models\User;
use humhub\modules\humhubchat\models\UserChatMessage;

class ChatController extends \humhub\components\Controller
{

    public function behaviors()
    {
        return [
            'acl' => [
                'class' => \humhub\components\behaviors\AccessControl::className()
            ]
        ];
    }

    /**
     * Overview of all messages
     */
    public function actionChats()
    {
        $data = Yii::$app->request->get();
        $lastId = $data['lastID'];
        $query = UserChatMessage::find();
        $query->where([
            '>',
            'id',
            $lastId
        ]);
        $query->asArray(true);
        $results = $query->all();
        $chats = array();
        foreach ($results as $chat) {
            
            // Returning the GMT (UTC) time of the chat creation:
            
            $chat['time'] = array(
                'hours' => gmdate('H', strtotime($chat['ts'])),
                'minutes' => gmdate('i', strtotime($chat['ts']))
            );
            
            $chats[] = $chat;
        }
        
        Yii::$app->response->format = 'json';
        return [
            'chats' => $chats
        ];
    }

    public function actionSubmit()
    {
        $data = Yii::$app->request->get();
        $messageText = $data["chatText"];
        
        $query = User::find();
        $query->where([
            'id' => Yii::$app->user->id
        ]);
        $user = $query->one();
        
        $chat = new UserChatMessage();
        $chat->text = $messageText;
        $chat->author = $user->username;
        $chat->gravatar = '/uploads/profile_image/' . $user->guid . '.jpg';
        $chat->save();
    }

    public function actionUsers()
    {
        $onlineUsers = \humhub\modules\user\components\Session::getOnlineUsers()->asArray(true)->all();
        $users = array();
        foreach ($onlineUsers as $onlineUser) {
            $user = array();
            $user['name'] = $onlineUser['username'];
            $user['gravatar'] = '/uploads/profile_image/' . $onlineUser['guid'] . '.jpg';
            $users[] = $user;
        }
        
        Yii::$app->response->format = 'json';
        return [
            'users' => $users
        ];
    }
}
