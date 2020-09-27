<?php

require './vendor/autoload.php';
// include ('./global_constant.php');
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
  // if ($argc < 4) {
  //   exit("Usage: php s3.php <the time zone> <the bucket name> <the AWS Region to use>\n" .
  //     "Example: php s3.php America/Los_Angeles my-test-bucket us-east-2");
  // }


  // date_default_timezone_set($timeZone);


// $credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);

// $s3 = new Aws\S3\S3Client([
//     'version'     => 'latest',
//     'region'      => REGION,
//     'credentials' => $credentials
// ]);

// //   # Lists all of your available buckets in this AWS Region.
// //   function listMyBuckets($s3) {
// //     print("\nMy buckets now are:\n");

// //     $promise = $s3->listBucketsAsync();

// //     $result = $promise->wait();

// //     foreach ($result['Buckets'] as $bucket) {
// //       print("\n");
// //       echo "<pre>";
// //       print($bucket['Name']);
// //     }
// //   }

// //   listMyBuckets($s3);
// // // exit;
// //   # Create a new bucket.
// //       echo "<pre>";

//   print("\n\nCreating a new bucket named ".BUCKET_NAME."...\n");

//   try {
//     $promise = $s3->createBucketAsync([
//       'Bucket' => BUCKET_NAME,
//       'CreateBucketConfiguration' => [
//         'LocationConstraint' => REGION
//       ]
//     ]);

//     $promise->wait();

//   } catch (Exception $e) {
//     if ($e->getCode() == 'BucketAlreadyExists') {
//       exit("\nCannot create the bucket. " .
//         "A bucket with the name ".BUCKET_NAME." already exists. Exiting.");
//     }
//   }








  // listMyBuckets($s3);
      // echo "<pre>";

  # Delete the bucket you just created.
  // print("\n\nDeleting the bucket named '$bucketName'...\n");

  // $promise = $s3->deleteBucketAsync([
  //   'Bucket' => $bucketName
  // ]);

  // $promise->wait();

  // listMyBuckets($s3);
// snippet-end:[s3.php.bucket_operations.list_create_delete]








function uploadFileIntoS3($file_path,$file_name){

//    $USAGE = "\n" .
// "To run this example, supply the name of an S3 bucket and a file to\n" .
// "upload to it.\n" .
// "\n" .
// "Ex: php PutObject.php <bucketname> <filename>\n";
define('BUCKET_NAME', 'zohaib');
define('REGION', 'us-east-1');

// $file_Path = 'C:\Users\user\Desktop\zohaib.png';
$argv = array(BUCKET_NAME,$file_path);


// print_r($argv);
// exit();
if (count($argv) < 2) {
    echo $USAGE;
    exit();
}

$bucket = $argv[0];
$file_path = $argv[1];
$key = $file_name;    //basename($argv[1]);

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
// $file_path = 'C:\Users\user\Desktop\right.png';

 // uploadFileIntoS3($file_path,'test.png');
function listOfAllObjects(){
// $credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);

$s3 = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => REGION,
    // 'credentials' => $credentials
]);
// list of all object
 // Use the plain API (returns ONLY up to 1000 of your objects).
try {
    $objects = $s3->listObjects([
        'Bucket' => BUCKET_NAME
    ]);
    return $objects['Contents'];
    // foreach ($objects['Contents']  as $object) {
    //     echo S3_URL.$object['Key'] . PHP_EOL;
    // }
} catch (S3Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
}
// print_r(listOfAllObjects());



// delete object 
// $client->deleteObject(['Bucket' => 'my-bucket-name', 'Key' => 'goodbye.txt']);

// https://docs.ceph.com/en/latest/radosgw/s3/php/
?>