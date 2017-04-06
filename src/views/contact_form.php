<?php
/* @var $this yii\web\View */
/* @var $model demmonico\contact\forms\ContactForm */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


$moduleName = isset($this->context->id) ? $this->context->id : 'contact';
$formOptions = [
    'action' => \yii\helpers\Url::to('/'.$moduleName),
    'id' => 'contact-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true
];

$this->title =
    isset($this->context, $this->context->module, $this->context->module->pageTitle) ?
        $this->context->module->pageTitle :
        (Yii::$app->name.' - Contact Us');
$this->params['breadcrumbs'][] = $this->title;
?>

<div><?= Yii::$app->session->getFlash('error') ?><?= Yii::$app->session->getFlash('success') ?></div>
<div class="col-lg-5">
    <?php $form = ActiveForm::begin($formOptions); ?>
        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'username')->textInput(['class' => 'hp-field'])->label(false) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'subject') ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
            'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            'captchaAction' => \yii\helpers\Url::to('/'.$moduleName.'/captcha'),
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
