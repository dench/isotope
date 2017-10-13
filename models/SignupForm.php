<?php

namespace app\models;

use DateTime;
use DateTimeZone;
use himiklab\yii2\recaptcha\ReCaptchaValidator;
use Yii;
use yii\base\Model;

/**
 *
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $reCaptcha;
    public $country_id;
    public $offset;
    public $email_news;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'trim'],
            [['username', 'email', 'password', 'password_repeat', 'country_id'], 'required'],
            ['email', 'email'],
            ['username', 'string', 'min' => 2, 'max' => 20],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['email', 'string', 'max' => 255],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'Username already exists')],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'E-mail already exists')],
            ['reCaptcha', ReCaptchaValidator::className(), 'uncheckedMessage' => Yii::t('app', 'Please confirm that you are not a bot.')],
            ['offset', 'integer'],
            ['country_id', 'string', 'min' => 2, 'max' => 2],
            ['country_id', 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            ['email_news', 'boolean'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => Yii::t('app', 'Passwords do not match, please retype.')],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-mail'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Confirm password'),
            'country_id' => Yii::t('app', 'Location'),
            'email_news' => Yii::t('app', 'Receive our news by e-mail'),
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->country_id = $this->country_id;
        $user->email_news = $this->email_news;
        $user->ip = Yii::$app->request->userIP;
        $user->setPassword($this->password);
        $user->generateAuthKey();

        $timezone = null;

        $list = DateTimeZone::listIdentifiers(DateTimeZone::PER_COUNTRY, $user->country_id);
        foreach ($list as $l) {
            $date = new DateTimeZone($l);
            $offset = $date->getOffset(new DateTime())/60;
            if ($offset == -$this->offset) {
                $timezone = $l;
                break;
            }
        }

        if (!$timezone) {
            $list = DateTimeZone::listIdentifiers();
            foreach ($list as $l) {
                $date = new DateTimeZone($l);
                $offset = $date->getOffset(new DateTime())/60;
                if ($offset == -$this->offset) {
                    $timezone = $l;
                    break;
                }
            }
        }

        $user->timezone = $timezone;

        return $user->save() ? $user : null;
    }
}