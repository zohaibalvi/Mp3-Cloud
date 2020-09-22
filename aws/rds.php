<?php


require './vendor/autoload.php';
include ('./global_constant.php');

use Aws\Rds\RdsClient; 
use Aws\Exception\AwsException;

//Create a RDSClient
$rdsClient = new Aws\Rds\RdsClient([
    'profile' => 'default',
    'version' => '2014-10-31',
    'region' => 'us-east-2'
]);

$dbIdentifier = '<<{{db-identifier}}>>';
$dbClass = 'db.t2.micro';
$storage = 5;
$engine = 'MySQL';
$username = 'zohaib';
$password =  'zohaib';
// ]);
try {
    $result = $rdsClient->createDBInstance([
        'DBInstanceIdentifier' => $dbIdentifier,
        'DBInstanceClass' => $dbClass ,
        'AllocatedStorage' => $storage,
        'Engine' => $engine,
        'MasterUsername' => $username,
        'MasterUserPassword' => $password,
    ]);
    var_dump($result);
} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo "\n";
} 
