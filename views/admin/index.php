<?php
use yii\helpers\URL;
use yii\helpers\Html;
use humhub\compat\CActiveForm;
use humhub\models\Setting;
use humhub\modules\humhubchat\controllers\AdminController;
?>
<div class="panel panel-default">
	<div class="panel-heading"><?=Yii::t('HumhubChatModule.base', '<strong>Basic Chat</strong>'); ?></div>
	<div class="panel-body">
		<?php $form = CActiveForm::begin(['id' => 'hhc-settings-form']); ?>
			<?=$form->errorSummary($model); ?>
			<div class="form-group">
				<?=$form->labelEx($model, 'theme'); ?>
				<?=$form->dropDownList($model, 'theme', AdminController::getThemes(), ['class' => 'form-control', 'readonly' => Setting::IsFixed('theme', 'humhub_chat')]); ?>
				</div>
			<div class="form-group">
				<?=$form->labelEx($model, 'timeout'); ?>
				<?=$form->textField($model, 'timeout', ['class' => 'form-control', 'readonly' => Setting::IsFixed('timeout', 'humhub_chat')]); ?>
			</div>
			<p class="help-block"><?=Yii::t('HumhubChatModule.base', 'Amount of days, after messages will be deleted; min value is 0 (no deletion); max: 365'); ?></p>
			<?php echo Html::submitButton(Yii::t('HumhubChatModule.base', 'Save'), ['class' => 'btn btn-primary']); ?>
			<?=\humhub\widgets\DataSaved::widget(); ?>
		<?php CActiveForm::end(); ?>
	</div>
</div>
