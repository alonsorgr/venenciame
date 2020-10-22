<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use Yii;
use yii\imagine\Image;
use yii\web\BadRequestHttpException;

/**
 * Clase auxiliar para la administración de imágenes en AWS S3.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class AmazonS3
{
    /**
     * Constantes de buckets en AWS S3.
     */
    const BUCKET = 'venenciame';
    const BUCKET_USERS = 'venenciame-users';
    const BUCKET_PARTNERS = 'venenciame-partners';
    const BUCKET_ARTICLES = 'venenciame-articles';

    /**
     * Constantes de alias para AWS S3.
     */
    const USER = '@user/';
    const PARTNERS = '@partners/';
    const ARTICLES = '@articles/';

    /**
     * Sube un fichero el servicio de Amazon S3.
     *
     * @param   yii\web\UploadedFile    $upload   imagen a subir.
     * @param   string                  $key      nombre de la imagen a subir.
     * @param   string                  $bucket   nombre del bucket.
     * @param   string                  $old      imagen a reemplazar.
     * @return  string                            nombre de la imagen.
     */
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

    /**
     * Baja un fichero el servicio de Amazon S3.
     *
     * @param   string    $image     nombre de la imagen.
     * @param   string    $default   imagen por defecto.
     * @param   string    $alias     ruta al directorio de imágenes.
     * @param   string    $bucket    nombre del bucket.
     * @return  string               enlace a la imagen.
     */
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
