<?php
/**
 * Date: 06.04.17
 * Time: 15:18
 */

namespace demmonico\contact\controllers;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\Controller;
use yii\filters\AccessControl;
use demmonico\contact\forms\ContactForm;

class ContactController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return array_merge(parent::actions(), [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    /**
     * Send contact form action
     * @return string|\yii\web\Response
     * @throws InvalidConfigException
     */
    public function actionIndex()
    {
        $formProperties = ['class' => ContactForm::className()];

        // get module config
        $module = \Yii::$app->controller->module;
        if (!isset($module) || !isset($module->adminEmail)) {
            throw new InvalidConfigException('Invalid contact module config');
        }
        $formProperties['captchaUrl'] = '/'.$module->id.'/contact/captcha';
        if (isset($module->mailerComponent)) {
            $formProperties['mailerComponent'] = $module->mailerComponent;
        }

        $model = Yii::createObject($formProperties);
        // load and validate contact data
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            // check for honeypot or save & send
            if ($model->isBot() || $model->save() && $model->send($module->adminEmail)) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your message was send successfully'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('app', 'Error while send message'));
            }
            return $this->refresh();
        }

        return $this->render('/contact_form', ['model' => $model]);
    }
}