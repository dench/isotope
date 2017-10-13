<?php
namespace app\models;

use DateTimeZone;
use dench\image\models\File;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $country_id
 * @property string $city
 * @property integer $birthday
 * @property integer $sex
 * @property string $website
 * @property integer $file_id
 * @property string $timezone
 * @property boolean email_news
 * @property boolean email_notice
 * @property string $ip
 *
 * @property string $password
 *
 * @property Country $country
 * @property File $file
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    const SEX_UNKNOWN = 0;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'ip', 'timezone', 'country_id'], 'required'],
            [['status', 'file_id'], 'integer'],

            ['username', 'string', 'min' => 2, 'max' => 20],
            ['password', 'string', 'min' => 6],

            [['email', 'website'], 'string', 'max' => 255],
            [['city', 'timezone'], 'string', 'max' => 30],
            ['ip', 'string', 'max' => 40],

            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'Username already exists')],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::className(), 'message' => Yii::t('app', 'E-mail already exists')],

            ['status', 'default', 'value' => self::STATUS_ENABLED],
            ['status', 'in', 'range' => [self::STATUS_ENABLED, self::STATUS_DISABLED]],

            ['sex', 'default', 'value' => self::SEX_UNKNOWN],
            ['sex', 'in', 'range' => [self::SEX_UNKNOWN, self::SEX_MALE, self::SEX_FEMALE]],

            ['country_id', 'string', 'min' => 2, 'max' => 2],
            ['country_id', 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],

            ['file_id', 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],

            [['email_news', 'email_notice'], 'boolean'],

            ['timezone', 'default', 'value' => 'UTC'],

            ['timezone', 'in', 'range' => DateTimeZone::listIdentifiers()],

            ['birthday', 'date'],
        ];
    }

    public static function statusList()
    {
        return [
            self::STATUS_DISABLED => Yii::t('app', 'Disabled'),
            self::STATUS_ENABLED => Yii::t('app', 'Enabled')
        ];
    }

    public static function sexList()
    {
        return [
            self::SEX_UNKNOWN => Yii::t('app', 'Unknown'),
            self::SEX_MALE => Yii::t('app', 'Male'),
            self::SEX_FEMALE => Yii::t('app', 'Female'),
        ];
    }

    public function getStatusName()
    {
        $a = self::statusList();
        return $a[$this->status];
    }

    public function getSexName()
    {
        $a = self::sexList();
        return $a[$this->sex];
    }

    public static function userList()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'E-mail'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created'),
            'updated_at' => Yii::t('app', 'Updated'),
            'password' => Yii::t('app', 'Password'),
            'ip' => Yii::t('app', 'IP address'),
            'country_id' => Yii::t('app', 'Country'),
            'city' => Yii::t('app', 'City'),
            'birthday' => Yii::t('app', 'Birthday'),
            'sex' => Yii::t('app', 'Sex'),
            'website' => Yii::t('app', 'Website'),
            'file_id' => Yii::t('app', 'Image'),
            'timezone' => Yii::t('app', 'Timezone'),
            'email_news' => Yii::t('app', 'Email News'),
            'email_notice' => Yii::t('app', 'Email Notice'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::find()->where('id = :id and status != :status', ['id' => $id, 'status' => self::STATUS_DISABLED])->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return array|ActiveRecord
     */
    public static function findByUsername($username)
    {
        return static::find()->where('username = :username and status != :status', ['username' => $username, 'status' => self::STATUS_DISABLED])->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return array|ActiveRecord
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()->where('password_reset_token = :token and status != :status', ['token' => $token, 'status' => self::STATUS_DISABLED])->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }
}