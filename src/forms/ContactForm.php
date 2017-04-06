<?php
/**
 * Date: 06.04.17
 * Time: 15:22
 */

namespace demmonico\contact\forms;

use Yii;
use yii\base\Model;
use demmonico\contact\models\Contact;

/**
 * This is the form class for table "contact".
 *
 * @property integer $name
 * @property integer $email
 * @property integer $subject
 * @property string $body
 */

class ContactForm extends Model
{
    /** @var string honeypot */
    public $username;
    /** @var string */
    public $name;
    /** @var string */
    public $email;
    /** @var string */
    public $subject;
    /** @var string */
    public $body;

    /** @var string */
    public $verifyCode;

    /** @var string */
    public $mailerComponent;
    /** @var string */
    public $captchaUrl;



    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject', 'body', 'verifyCode'], 'filter', 'filter' => 'trim'],

            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            [['name', 'subject', 'email'], 'string', 'min' => 3, 'max' => 255],
            [['body'], 'string', 'max' => 65525],
            [['name', 'email', 'subject', 'body'], 'filter', 'filter' => function ($value) {
                return strip_tags($value);
            }],

            //letters or numbers
            [['name', 'subject'], 'match', 'pattern' => '/^[\w\s\']*$/i'],

            // email has to be a valid email address
            ['email', 'email'],

            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'captchaAction' => $this->captchaUrl],

            // field for honeypot
            ['username', 'safe'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'subject' => Yii::t('app', 'Subject'),
            'body' => Yii::t('app', 'Message'),
            'verifyCode' => Yii::t('app', 'Verification Code'),
        ];
    }

    /**
     * Checks for honeypot
     * @return bool
     */
    public function isBot()
    {
        return $this->username ? true : false;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $model = Yii::createObject(['class' => Contact::className()]);
        // apply properties
        foreach ($this->attributes as $attribute => $value) {
            if ($model->hasAttribute($attribute)) {
                $model->$attribute = $value;
            }
        }
        return $model->save();
    }

    /**
     * Sends an email to the specified email address
     * @param string $email the target email address
     * @return bool whether the email was send
     */
    public function send($email)
    {
        return Yii::$app->{$this->mailerComponent}->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();
    }
}