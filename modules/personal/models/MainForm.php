<?php

namespace app\modules\personal\models;

use app\models\Country;
use app\models\User;
use DateTimeZone;
use Yii;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.10.17
 * Time: 14:09
 */
class MainForm extends Model
{
    public $password_new;
    public $password_repeat;
    public $password_current;
    public $email;
    public $email_news;
    public $email_notice;
    public $country_id;
    public $timezone;

    /**
     * @var $user User
     */
    public $user;

    public function init()
    {
        parent::init();

        $this->user = User::findOne(Yii::$app->user->identity);

        $this->email = $this->user->email;
        $this->email_news = $this->user->email_news;
        $this->email_notice = $this->user->email_notice;
        $this->country_id = $this->user->country_id;
        $this->timezone = $this->user->timezone;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password_new', 'password_repeat', 'password_current', 'email'], 'trim'],
            [['email', 'country_id', 'timezone'], 'required'],
            [['password_repeat', 'password_current'], 'required', 'when' => function ($model) {
                return !empty($model->password_new);
            }, 'whenClient' => "function (attribute, value) {
                return ($('#mainform-password_new').val() != '');
            }"],
            [['password_new', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password_new', 'message' => Yii::t('app', 'Passwords do not match, please retype.')],
            ['password_current', function ($attribute, $params) {
                if (empty($this->password_current)) {
                    $this->addError($attribute, Yii::t('app', 'Password cannot be blank.'));
                } elseif (!$this->user->validatePassword($this->password_current)) {
                    $this->addError($attribute, Yii::t('app', 'Invalid password!'));
                }
            }, 'when' => function ($model) {
                return !empty($model->password_new) || $this->email != $this->user->email;
            }, 'skipOnEmpty' => false],
            ['country_id', 'string', 'min' => 2, 'max' => 2],
            ['country_id', 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['email_news', 'email_notice'], 'boolean'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'E-mail already exists'), 'filter' => ['!=', 'id', $this->user->id]],
            ['timezone', 'in', 'range' => DateTimeZone::listIdentifiers()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'E-mail'),
            'email_news' => Yii::t('app', 'Receive our news by e-mail'),
            'email_notice' => Yii::t('app', 'Receive important notifications by email'),
            'password_new' => Yii::t('app', 'New password'),
            'password_repeat' => Yii::t('app', 'Confirm password'),
            'password_current' => Yii::t('app', 'Current password'),
            'country_id' => Yii::t('app', 'Country'),
            'timezone' => Yii::t('app', 'Timezone'),
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user->email = $this->email;
        $this->user->email_news = $this->email_news;
        $this->user->email_notice = $this->email_notice;
        $this->user->country_id = $this->country_id;
        $this->user->timezone = $this->timezone;

        $this->user->save();

        Yii::error($this->user->errors);

        return $this->user->save() ? true : false;
    }
}