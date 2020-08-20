<?php

namespace app\components;

use Aws\S3\S3Client;
use yii\base\Component;

/**
 * Componente de aplicación para gestionar la subida de archivos a AWS S3
 */
class S3Component extends Component
{
    /**
     * Versión de AWS S3
     *
     * @var [type]
     */

    public $version;
    /**
     * Región de AWS S3
     *
     * @var [type]
     */
    public $region;

    /**
     * Clave de la conexión
     *
     * @var [type]
     */
    public $key;

    /**
     * Clave secreta de la conexión
     *
     * @var [type]
     */
    public $secret;

    /**
     * Atributo S3Client
     *
     * @var [type]
     */
    public $s3Client;

    /**
     * Constructor del componente AWS S3
     *
     * @param array $config configuración del componente
     */
    public function __construct($config = [])
    {
        $this->s3Client($config, $this->s3Client);
        parent::__construct($config);
    }

    /**
     * Objeto S3Client
     *
     * @param [type] $config    configuración del componente S3Client
     * @param [type] $s3Client  attributo S3Client
     * @return \S3Client        objeto S3Client
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
     * Sube un fichero a AWS S3
     *
     * @param [type] $body   imagen a subir
     * @param [type] $key    nombre de la imagen
     * @param [type] $bucket nombre del bucket
     * @return String        nombre del bucket
     */
    public function upload($body, $key, $bucket)
    {
        $this->s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'Body' => $body
        ]);

        return $key;
    }

    /**
     * Descarga un fichero de AWS S3
     *
     * @param [type] $key    nombre de la imagen
     * @param [type] $bucket nombre del bucket
     * @return \Aws\Result   resultado de la operación
     */
    public function download($key, $bucket)
    {
        return $this->s3Client->getObject([
            'Bucket' => $bucket,
            'Key' => $key
        ]);
    }

    /**
     * Elimina un fichero de AWS S3
     *
     * @param [type] $key    nombre de la imagen
     * @param [type] $bucket nombre del bucket
     * @return \Aws\Result   resultado de la operación
     */
    public function delete($key, $bucket)
    {
        $this->s3Client->deleteObject([
            'Bucket' => $bucket,
            'Key' => $key
        ]);
    }

    /**
     * Obtiene la url de un fichero de AWS S3
     *
     * @param [type] $key    nombre de la imagen
     * @param [type] $bucket nombre del bucket
     * @return \Aws\Result   link del fichero
     */
    public function getUrl($key, $bucket)
    {
        return $this->s3Client->getObjectUrl($bucket, $key);
    }
}
