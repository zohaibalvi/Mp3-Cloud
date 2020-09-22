<?php


require '../vendor/autoload.php';
include ('../global_constant.php');

use Aws\Rds\RdsClient; 
use Aws\Exception\AwsException;


$credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);

//Create a RDSClient
$rdsClient = new Aws\Rds\RdsClient([
    // 'profile' => 'default',
    'version'     => 'latest',
    'region'      => REGION,
    'credentials' => $credentials
]);

// $dbIdentifier = 'mp3';
// $dbClass = 'db.t2.micro';
// $storage = 5;
// $engine = 'MySQL';
// $username = 'zohaib';
// $password =  'syedzohaibali';
// // ]);
// try {
//     $result = $rdsClient->createDBInstance([
//         'DBInstanceIdentifier' => $dbIdentifier,
//         'DBInstanceClass' => $dbClass ,
//         'AllocatedStorage' => $storage,
//         'Engine' => $engine,
//         'MasterUsername' => $username,
//         'MasterUserPassword' => $password,
//     ]);

//     echo "<pre>";
//     var_dump($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     echo $e->getMessage();
//     echo "\n";
// } 





// start instance 

//Create a RDSClient

// $dbIdentifier = 'mp3';

// try {
//     $result = $rdsClient->startDBInstance([
//         'DBInstanceIdentifier' => $dbIdentifier,
//     ]);
//     var_dump($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     echo $e->getMessage();
//     echo "\n";
// } 




//delete RDS

$dbIdentifier = 'mp3';

try {
    $result = $rdsClient->deleteDBInstance([
        'DBInstanceIdentifier' => $dbIdentifier,
        'SkipFinalSnapshot' => true
    ]);
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo "\n";
} 


