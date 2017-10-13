<?php

namespace app\modules\personal\models;

use app\models\Country;
use app\models\User;
use dench\image\models\File;
use Yii;
use yii\base\Model;

/**
 * Created by PhpStorm.
 * User: dench
 * Date: 02.10.17
 * Time: 14:09
 */
class ProfileForm extends Model
{
    public $username;
    public $country_id;
    public $city;
    public $birthday;
    public $sex;
    public $website;
    public $file_id;

    /**
     * @var $user User;
     */
    private $user;

    public function init()
    {
        parent::init();

        $this->user = User::findOne(Yii::$app->user->identity);

        $this->username = $this->user->username;
        $this->country_id = $this->user->country_id;
        $this->city = $this->user->city;
        $this->birthday = $this->user->birthday;
        $this->sex = $this->user->sex;
        $this->website = $this->user->website;
        $this->file_id = $this->user->file_id;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'city', 'website'], 'trim'],
            [['username', 'country_id'], 'required'],
            ['website', 'string', 'max' => 255],
            ['city', 'string', 'max' => 30],
            ['file_id', 'integer'],
            ['file_id', 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
            ['sex', 'default', 'value' => User::SEX_UNKNOWN],
            ['sex', 'in', 'range' => [User::SEX_UNKNOWN, User::SEX_MALE, User::SEX_FEMALE]],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => Yii::t('app', 'Username already exists'), 'filter' => ['!=', 'id', $this->user->id]],
            ['birthday', 'date'],
            ['country_id', 'string', 'min' => 2, 'max' => 2],
            ['country_id', 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'Username'),
            'country_id' => Yii::t('app', 'Country'),
            'city' => Yii::t('app', 'City'),
            'birthday' => Yii::t('app', 'Birthday'),
            'sex' => Yii::t('app', 'Sex'),
            'website' => Yii::t('app', 'Social page'),
            'file_id' => Yii::t('app', 'Image'),
        ];
    }

    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->user->username = $this->username;
        $this->user->country_id = $this->country_id;
        $this->user->city = $this->city;
        $this->user->sex = $this->sex;
        $this->user->website = $this->website;
        $this->user->file_id = $this->file_id;
        $this->user->birthday = $this->birthday;

        return $this->user->save() ? true : false;
    }
}