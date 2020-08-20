<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\components;

use Aws\S3\S3Client;
use yii\base\Component;

/**
 * Componente de aplicación para la administración de imágenes en AWS S3.
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class S3Component extends Component
{
    /**
     * Variable para la versión de AWS S3.
     *
     * @var string
     */
    public $version;

    /**
     * Variable para la región de AWS S3.
     *
     * @var string
     */
    public $region;

    /**
     * Variable para la clave de AWS S3.
     *
     * @var string
     */
    public $key;

    /**
     * Variable para la clave secreta de AWS S3.
     *
     * @var string
     */
    public $secret;

    /**
     * Variable para el cliente de AWS S3.
     *
     * @var \Aws\S3\S3Client
     */
    public $s3Client;

    /**
     * Constructor del componente AWS S3.
     *
     * @param array $config configuración del componente.
     */
    public function __construct($config = [])
    {
        $this->s3Client($config, $this->s3Client);
        parent::__construct($config);
    }

    /**
     * Establece las propiedades del componente [[Aws\S3\S3Client]].
     *
     * @param   array               $config     configuración del componente.
     * @param   \Aws\S3\S3Client    $s3Client   cliente AWS S3.
     * @return  void
     */
    private function s3Client($config, &$s3Client)
    {
        $s3Client = new S3Client([
            'version' => $config['version'],
            'region' => $config['region'],
            'credentials' => [
                'key'    => $config['key'],
                'secret' => $config['secret'],
            ],
        ]);
    }

    /**
     * Subida de imágenes a AWS S3.
     *
     * @param   string    $bucket    nombre del bucket.
     * @param   string    $key       nombre de la imagen.
     * @param   string    $body      imagen subir.
     * @return  string               nombre de la imagen subida.
     */
    public function upload($bucket, $key, $body)
    {
        $this->s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'Body' => $body,
        ]);

        return $key;
    }

    /**
     * Bajada de imágenes a AWS S3.
     *
     * @param   string          $bucket    nombre del bucket.
     * @param   string          $key       nombre de la imagen.
     * @return  \Aws\Result                imagen de AWS S3.
     */
    public function download($bucket, $key)
    {
        return $this->s3Client->getObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);
    }

    /**
     * Elimina una imagen de AWS S3.
     *
     * @param   string          $bucket    nombre del bucket.
     * @param   string          $key       nombre de la imagen.
     * @return  \Aws\Result                resultado de la eliminación de la imagen.
     */
    public function delete($bucket, $key)
    {
        $this->s3Client->deleteObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);
    }

    /**
     * Obtiene la url de un fichero de AWS S3.
     *
     * @param   string $bucket    nombre del bucket.
     * @param   string $key       nombre de la imagen.
     * @return  string            url de la imagen.
     */
    public function getUrl($bucket, $key)
    {
        return $this->s3Client->getObjectUrl($bucket, $key);
    }
}
