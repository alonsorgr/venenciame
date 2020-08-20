<?php

namespace app\components;

use Aws\S3\S3Client;
use yii\base\Component;


class S3Component extends Component
{
    public $version;

    public $region;

    public $key;

    public $secret;

    public $s3Client;

    public function __construct($config = [])
    {
        $this->s3Client($config, $this->s3Client);
        parent::__construct($config);
    }

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

    public function upload($bucket, $key, $body)
    {
        $this->s3Client->putObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'Body' => $body,
        ]);

        return $key;
    }

    public function download($bucket, $key)
    {
        return $this->s3Client->getObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);
    }

    public function delete($bucket, $key)
    {
        $this->s3Client->deleteObject([
            'Bucket' => $bucket,
            'Key' => $key,
        ]);
    }

    public function getUrl($key, $bucket)
    {
        return $this->s3Client->getObjectUrl($bucket, $key);
    }
}
