<?php
namespace Core;
require_once app_root . '/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;
class AmazonS3
{
    private $instance = 'global';
    private $bucket = AWS_S3_BUCKET_NAME;

    public function __construct($instance) {
        $this->instance = $instance;
    }

    public function copyFile($copySource,$keyname) {

        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'credentials' => array(
                'key'    => AWS_ACCESS_KEY_ID,
                'secret' => AWS_SECRET_ACCESS_KEY,
            )
        ]);

        try {

            $result = $s3->copyObject([
                'Bucket' => $this->bucket,
                'Key' => $keyname,
                'CopySource' => $copySource,
            ]);

            return $result['ObjectURL'];
        } catch (S3Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function uploadFile($filePath,$keyName,$base64 = false)
    {
        $keyname = 'instances/'.$this->instance.'/'.$keyName;

        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1',
            'credentials' => array(
                'key'    => AWS_ACCESS_KEY_ID,
                'secret' => AWS_SECRET_ACCESS_KEY,
            )
        ]);

        try {
            // Upload data.
            $result = $s3->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $keyname,
                'Body'   => ($base64 == true)? base64_decode($filePath):fopen($filePath, 'r'),
                'ACL'    => 'public-read'
            ]);

            return $result['ObjectURL'];

        } catch (S3Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function isFileExists($bucket,$file)
    {
        $s3 = new S3Client([
            'version' => 'latest',
            'region'  => 'us-east-1'
        ]);

        return $s3->doesObjectExist($bucket, $file);
    }
}
?>