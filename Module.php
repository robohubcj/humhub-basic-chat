<?php
namespace humhub\modules\humhubchat;
use Yii;
use yii\helpers\Url;
class Module extends \humhub\modules\content\components\ContentContainerModule
{
        /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/humhub_chat/admin']);
    }
}
