<?php

namespace app\helpers;

use \yii\imagine\Image;
use Yii;
use yii\web\BadRequestHttpException;

class AmazonS3
{
    const BUCKET = 'venenciame';

    const BUCKET_USERS = 'venenciame-users';

    const USER = '@user/';

    public static function upload($upload, $key, $bucket, $old)
    {
        try {
            $fileName = Yii::getAlias('@uploads/' . $upload->baseName . '.' . $upload->extension);
            $upload->saveAs($fileName);

            Image::resize($fileName, 400, 400, false)->save($fileName);

            if ($old !== null) {
                Yii::$app->s3->delete($bucket, $old);
            }

            $key .= '.' . $upload->extension;

            $uploadFile = Yii::$app->s3->upload($bucket, $key, file_get_contents($fileName));
            unlink($fileName);

            return $uploadFile;
        } catch (\Exception $exception) {
            throw new BadRequestHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    public static function getLink($image, $default, $alias, $bucket)
    {
        if ($image !== null) {
            try {
                $path = Yii::getAlias($alias . $image);
                if (!file_exists($path)) {
                    $img = Yii::$app->s3->download($bucket, $image);
                    file_put_contents($path, $img['Body']);
                } else {
                    Yii::$app->s3->delete($bucket, $path);
                    $img = Yii::$app->s3->download($bucket, $image);
                    file_put_contents($path, $img['Body']);
                }
                return $path;
            } catch (\Exception $exception) {
            }
        }

        return Yii::getAlias($default);
    }
}
