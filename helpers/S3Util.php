<?php

namespace app\helpers;

use \yii\imagine\Image;
use Yii;
use yii\web\BadRequestHttpException;

/**
 * Clase auxiliar para el uso del componente AWS S3
 */
class S3Util
{
    /**
     * Nombre del bucket general en AWS S3
     */
    const BUCKET = 'venenciame';

    /**
     * Nombre del bucket de imágenes de usuario en AWS S3
     */
    const BUCKET_USERS = 'venenciame-users';

    /**
     * Nombre del alias para imágenes de usuario
     */
    const USER = '@user/';

    /**
     * Nombre del alias para imágenes de vinos
     */
    const WINES = '@wine/';

    /**
     * Función para subir un archivo a la nube AWS S3
     *
     * @param [type] $upload    Archivo a subir
     * @param [type] $key       Nombre del archivo a subir
     * @param [type] $bucket    Nombre del bucket en AWS S3
     * @param [type] $old       Nombre del archivo antiguo para eliminarlo de AWS S3
     */
    public static function upload($upload, $key, $bucket, $old)
    {
        try {
            $fileName = Yii::getAlias('@uploads/' . $upload->baseName . '.' . $upload->extension);
            $upload->saveAs($fileName);

            Image::resize($fileName, 400, 400, false)->save($fileName);

            if ($old !== null) {
                Yii::$app->s3->delete($old, $bucket);
            }

            $key .= '.' . $upload->extension;

            $uploadFile = Yii::$app->s3->upload(file_get_contents($fileName), $key, $bucket);
            unlink($fileName);

            return $uploadFile;

        } catch (\Exception $exception) {
            throw new BadRequestHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

    }

    /**
     * Función que obtiene un link de imagen de un recurso en AWS S3
     *
     * @param [type] $image     Nombre de la imagen
     * @param [type] $default   Imagen por defecto
     * @param [type] $alias     Ruta de imagenes
     */
    public static function getLink($image, $default, $alias, $bucket)
    {
        if ($image !== null) {
            try {
                $path = Yii::getAlias($alias . $image);
                if (!file_exists($path)) {
                    $img = Yii::$app->s3->download($image, $bucket);
                    file_put_contents($path, $img['Body']);
                } else {
                    Yii::$app->s3->delete($path, $bucket);
                    $img = Yii::$app->s3->download($image, $bucket);
                    file_put_contents($path, $img['Body']);
                }
                return $path;
            } catch (\Exception $exception) {
            }
        }

        return Yii::getAlias($default);
    }
}
