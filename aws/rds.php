<?php
require '../vendor/autoload.php';
include ('../global_constant.php');

use Aws\Rds\RdsClient; 
use Aws\Exception\AwsException;


// $credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);

//Create a RDSClient
$rdsClient = new Aws\Rds\RdsClient([
    // 'profile' => 'default',
    'version'     => 'latest',
    'region'      => REGION,
    // 'credentials' => $credentials
]);

$dbIdentifier = 'mp31';
$dbClass = 'db.t2.micro';
$storage = 5;
$engine = 'MySQL';
$username = 'zohaib';
$password =  'syedzohaibali';
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

    echo "<pre>";
   $data = $result->ToArray();


    echo "meta";
    echo "<pre>";
    print_r($data['@metadata']);



    echo "DBInstanceIdentifier";
    echo "<pre>";
    print_r($data['DBInstance']['DBInstanceIdentifier']);



$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";


} catch (AwsException $e) {
    // output error message if fails
    echo $e->getMessage();
    echo "\n";
} 




// // Create RDS securtiy Group
// echo "Create the security group";
// echo "<br>";
// // Create the security group
// $securityGroupName = 'RDS-security-group111';
// // $result = $rdsClient->createDBSecurityGroup(array(
// //     'DBSecurityGroupName'   => $securityGroupName,
// //     'DBSecurityGroupDescription' => 'Basic RDS security'
// // ));


// $result = $rdsClient->createDBSecurityGroup(array(
//     // DBSecurityGroupName is required
//     'DBSecurityGroupName' => $securityGroupName,
//     // DBSecurityGroupDescription is required
//     'DBSecurityGroupDescription' => 'Basic RDS security',
//     // 'Tags' => array(
//     //     array(
//     //         'Key' => 'string',
//     //         'Value' => 'string',
//     //     ),
//     //     // ... repeated
//     // ),
// ));


// $result = $rdsClient->authorizeDBSecurityGroupIngress(array(
//     // DBSecurityGroupName is required
//     'DBSecurityGroupName' => $securityGroupName,
//     'CIDRIP' => '0.0.0.0/0',
//     'EC2SecurityGroupName' => 'my-security-group',
//     'EC2SecurityGroupId' => 'sg-0817b4a1f8db314c3',
//     'EC2SecurityGroupOwnerId' => '372100151213',
// ));


// Get the security group ID (optional)
// $securityGroupId = $result->get('GroupId');


// echo "Set ingress rules for the security group";
// echo "<br>";
// // Set ingress rules for the security group
// $rdsClient->authorizeDBSecurityGroupIngress(array(
//     'DBSecurityGroupName'     => $securityGroupName,
//     'CidrIp' => '0.0.0.0/0'
            
//         )
    
// );




// start instance 

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

// $dbIdentifier = 'mp3';

// try {
//     $result = $rdsClient->deleteDBInstance([
//         'DBInstanceIdentifier' => $dbIdentifier,
//         'SkipFinalSnapshot' => true
//     ]);
//     var_dump($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     echo $e->getMessage();
//     echo "\n";
// } 


