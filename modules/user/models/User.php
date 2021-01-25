<?php

namespace app\modules\user\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string  $about
 * @property integer $type
 * @property string $nickname
 * @property string $picture
 * @property string $password write-only password
 */
class User extends ActiveRecord
{
    public static function tableName()
    {
        return '{{user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    public static function createBySignup($username, $email, $password)
    {
        $user = new self();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->generateAuthKey();

        return $user;
    }

    public function getNickName()
    {
        return $this->nickname ?? $this->id;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
