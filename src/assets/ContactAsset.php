<?php

/**
 * Created by PhpStorm.
 * User: carnat
 * Date: 06.04.17
 * Time: 16:43
 */

namespace demmonico\contact\assets;

use yii\web\AssetBundle;

class ContactAsset extends AssetBundle
{
    public $css = [
        'css/contact.css',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = __DIR__;
        parent::init();
    }
}