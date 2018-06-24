<?php

namespace frontend\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "media".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $hash
 * @property string $is_default
 */
class AdvertiserMedia extends \yii\db\ActiveRecord
{
    const WEBCAM_WIDTH = 1280;
    const WEBCAM_HEIGHT = 720;

    const RATIO = 0.85;

    const MIN_HEIGHT = 298;//596 * 0.5;
    const MIN_WIDTH = 351;//702 * 0.5;

    const MAX_ORIGIN_WIDTH = 1024;
    const MAX_ORIGIN_HEIGHT = 1024;

    const MAX_BIG_THUMB_WIDTH = 596;
    const MAX_BIG_THUMB_HEIGHT = 708;

    const MAX_SMALL_THUMB_WIDTH = 148;
    const MAX_SMALL_THUMB_HEIGHT = 174;

    const JPEG_RATIO = 0.85;

    const PREFIX_BIG_THUMB = 'thumb_big_';
    const PREFIX_SMALL_THUMB = 'thumb_big_';

    private $delete_data;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['hash'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Id Advertiser'),
            'hash' => Yii::t('app', 'Hash'),
            'is_default' => Yii::t('app', 'Is default'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'user_id']);
    }

    public function beforeDelete()
    {
        $this->delete_data = array('hash' => $this->hash, 'is_default' => $this->is_default, 'user_id' => $this->user_id);
        return parent::beforeDelete();
    }

    public function afterDelete()
    {
        parent::afterDelete();
        if (is_array($this->delete_data)) {
            $dir = $this->getSavePath($this->delete_data['hash']);
            $remove_files = array(
                $dir.$this->delete_data['hash'].'.jpg',
                $dir.AdvertiserMedia::PREFIX_BIG_THUMB.$this->delete_data['hash'].'.jpg',
                $dir.AdvertiserMedia::PREFIX_SMALL_THUMB.$this->delete_data['hash'].'.jpg'
            );
            foreach ($remove_files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
            if ($this->delete_data['is_default']) {
                $row = AdvertiserMedia::find()->where(['user_id' => $this->delete_data['user_id']])->one();
                if ($row) {
                    $row->is_default = 1;
                    $row->save();
                }
            }
            $this->delete_data = false;
        }
    }

    public static function getPhotosFor($user_id)
    {
        return self::find()->where(['user_id' => $user_id])->all();
    }

    public static function getDefaultPhoto($user_id)
    {
      return self::find()->where(['user_id' => $user_id])->andWhere(['is_default' => 1])->one();
    }

    public static function getDefaultPhotoHash($user_id)
    {
        $model = self::getDefaultPhoto($user_id);
        if ($model) {
            return $model->hash;
        }
        return '';
    }

    public static function getDefaultPhotoUrl($user_id, $prefix = '')
    {
        $hash = self::getDefaultPhotoHash($user_id);
        if (!empty($hash)) {
            return self::getUrl($hash, $prefix);
        }
        return false;
    }

    public function getHash()
    {
        return $this->hash;
    }

    private static function getImageDir($hash)
    {
        return implode('/', str_split(substr($hash, 0, 5)));
    }

    public static function getUrl($hash, $prefix = '')
    {
        return Yii::getAlias('@frontendImages/advertiser/'.self::getImageDir($hash). '/'.$prefix.$hash.'.jpg');
    }


    private static function getSavePath($hash)
    {
        return Yii::getAlias('@images/advertiser/'.self::getImageDir($hash). '/');
    }

    public static function addImage($user_id, $imgData)
    {
        $findOther = self::find()->where(['user_id' => $user_id])->one();
        $model = new AdvertiserMedia();
        $model->user_id = $user_id;
        $model->hash = md5(0);
        if (count($findOther) == 0) {
            $model->is_default = 1;
        }
        if ($model->save()) {
            $hash = md5($model->id);
            $model->hash = $hash;
            $model->save();

            $saveDir = self::getSavePath($hash);
            if (!is_dir($saveDir)) {
                mkdir($saveDir, 0777, true);
            }

            $orgFileName = $saveDir.$hash.'.jpg';
            if (file_put_contents($orgFileName, $imgData) !== false) {
                list($width, $height) = getimagesize($orgFileName);

                // fix orientation
                $exif = exif_read_data($orgFileName);
                $ort = 0;
                if ($exif && isset($exif['IFD0'])) {
                    $ort = $exif['IFD0']['Orientation'];
                }

                if (in_array($ort, array(3, 6, 8))) {
                    $image   = imagecreatefromjpeg($orgFileName);
                    switch($orientation) {
                        case 3:
                            $image = imagerotate($image, 180, 0);
                            break;
                        case 6:
                            $image = imagerotate($image, -90, 0);
                            break;
                        case 8:
                            $image = imagerotate($image, 90, 0);
                            break;
                    }
                    imagejpeg($image, $orgFileName, AdvertiserMedia::JPEG_RATIO * 100);
                    list($width, $height) = getimagesize($orgFileName); // refresh info
                }

                if ($width > AdvertiserMedia::MAX_ORIGIN_WIDTH || $height > AdvertiserMedia::MAX_ORIGIN_HEIGHT) {
                    self::resizeImage($saveDir.$hash.'.jpg', AdvertiserMedia::MAX_ORIGIN_WIDTH, AdvertiserMedia::MAX_ORIGIN_HEIGHT);
                }
                copy($orgFileName, $saveDir.self::PREFIX_BIG_THUMB.$hash.'.jpg');
                copy($orgFileName, $saveDir.self::PREFIX_SMALL_THUMB.$hash.'.jpg');
                return self::getUrl($hash); // end if all ok
            }

            $model->delete(); // if image not saved
        }
        throw new NotFoundHttpException('The image not saved');
    }

    private static function resizeImage($imageFile, $maxWidth, $maxHeight)
    {
        list($width, $height) = getimagesize($imageFile);
        $source = imagecreatefromjpeg($imageFile);
        $widthPer = $maxWidth / $width;
        $heightPer = $maxHeight / $height;
        $percent = ($widthPer < $heightPer ? $widthPer : $heightPer);
        $newWidth = $width * $percent;
        $newHeight = $height * $percent;

        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagejpeg($thumb, $imageFile, AdvertiserMedia::JPEG_RATIO * 100);
    }

    public static function cropImage($hash, $cropData)
    {
        $filename = self::getSavePath($hash).$hash.'.jpg';
        $croppedfilename = self::getSavePath($hash).AdvertiserMedia::PREFIX_BIG_THUMB.$hash.'.jpg';
        if (file_exists($filename)) {
            $source = imagecreatefromjpeg($filename);
            $thumb = imagecreatetruecolor($cropData['width'], $cropData['height']);
            imagecopyresampled($thumb, $source, 0, 0, $cropData['left'], $cropData['top'], $cropData['width'], $cropData['height'], $cropData['width'], $cropData['height']);
            imagejpeg($thumb, $croppedfilename, AdvertiserMedia::JPEG_RATIO * 100);

            self::resizeImage($croppedfilename, AdvertiserMedia::MAX_BIG_THUMB_WIDTH, AdvertiserMedia::MAX_BIG_THUMB_HEIGHT);

            $smallFileName = $saveDir.self::PREFIX_SMALL_THUMB.$hash.'.jpg';
            copy($croppedfilename, $smallFileName);
            self::resizeImage($smallFileName, AdvertiserMedia::MAX_SMALL_THUMB_WIDTH, AdvertiserMedia::MAX_SMALL_THUMB_HEIGHT);

            return self::getUrl($hash, self::PREFIX_BIG_THUMB);
        }
    }

    public static function saveCropImage($hash, $cropData)
    {
        $prefix = self::PREFIX_BIG_THUMB;
        $croppedfilename = self::getSavePath($hash).$prefix.$hash.'.jpg';
        file_put_contents($croppedfilename, $cropData);
        return self::getUrl($hash, $prefix);
    }
}
