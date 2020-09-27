<?php

require './vendor/autoload.php';
// include ('./global_constant.php');
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
 

function uploadFileIntoS3($file_path,$file_name){

define('BUCKET_NAME', 'zohaib');
define('REGION', 'us-east-1');


$argv = array(BUCKET_NAME,$file_path);

if (count($argv) < 2) {
    echo $USAGE;
    exit();
}

$bucket = $argv[0];
$file_path = $argv[1];
$key = $file_name;   

try {

$credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);


$s3 = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => REGION,
    'credentials' => $credentials
]);

    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key' => $key,
        'SourceFile' => $file_path,
        'ACL'    => 'public-read',


    ]);
    print_r($result);
    exit;
} catch (S3Exception $e) {
    echo $e->getMessage() . "\n";
}
}

?>