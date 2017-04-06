<?php
/**
 * Date: 06.04.17
 * Time: 15:09
 */

namespace demmonico\contact;

use yii\base\Module as BaseModule;
use yii\base\View;
use demmonico\contact\assets\ContactAsset;

class Module extends BaseModule
{
    /**
     * @var string
     */
    public $adminEmail;
    /**
     * @var string
     */
    public $mailerComponent;
    /**
     * @var string
     */
    public $pageTitle;



    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // register assets
        \Yii::$app->view->on(View::EVENT_BEFORE_RENDER, function ($event) {
            ContactAsset::register($event->sender);
        });

        if (isset($this->pageTitle)) {
            $this->pageTitle = \Yii::t('app', strtr($this->pageTitle, ['APP_NAME' => \Yii::$app->name]));
        }
    }
}