<?php
/**
 * Date: 06.04.17
 * Time: 15:22
 */

namespace demmonico\contact\models;

use Yii;
use yii\db\ActiveRecord;
use demmonico\contact\behaviors\TimestampBehavior;

/**
 * This is the model class for table "contact".
 *
 * @property integer $id
 * @property integer $name
 * @property integer $email
 * @property integer $subject
 * @property string $body
 * @property integer $status
 * @property string $created
 * @property string $updated
 */

class Contact extends ActiveRecord
{
    const DATETIME_FORMAT = 'Y-m-d H:i:s';



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cm_contact}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body'], 'required'],
            [['body'], 'string'],
            [['status', 'created', 'updated'], 'integer'],
            [['name', 'email', 'subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Message'),
            'status' => Yii::t('app', 'Status'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}