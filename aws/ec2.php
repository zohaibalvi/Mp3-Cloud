<?php
// https://aws.amazon.com/blogs/developer/provision-an-amazon-ec2-instance-with-php/
// var_dump( getenv('s3'));
// echo "string";
// exit;

// require '../vendor/autoload.php';
// include ('../global_constant.php');


// use Aws\Ec2\Ec2Client;
// // snippet-end:[ec2.php.describe_instances.import]
// /**
//  * Describe Instances
//  *
//  * This code expects that you have AWS credentials set up per:
//  * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html
//  */
 
// // snippet-start:[ec2.php.describe_instances.main]
// $credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);


//     // 'profile' => 'default',
// $ec2Client = new Aws\Ec2\Ec2Client([
//     'profile' => 'default',
//     'version'     => 'latest',
//     'region'      => REGION,
//     'credentials' => $credentials
// ]);

// $result = $ec2Client->describeInstances();

// var_dump($result);


require '../vendor/autoload.php';
include ('../global_constant.php');


use Aws\Ec2\Ec2Client;
$credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);

$ec2Client = Ec2Client::factory(array(
    // 'key'    => '[aws access key]',
    // 'secret' => '[aws secret key]',
    // 'region' => '[aws region]' // (e.g., us-east-1).
		'version'     => 'latest',	
    	'region'      => REGION,
        'credentials' => $credentials


));

echo "Create the key pair";
echo "<br>";
// Create the key pair
$keyPairName = 'mya-keaaaykpair-msapa1sssaaassas';
$result = $ec2Client->createKeyPair(array(
    'KeyName' => $keyPairName
));
$data = $result;
print_r($data['KeyFingerprint'] );
// foreach ($data as $key => $value) {

// 	foreach ($value['Aws\Resultdata'] as $key1 => $value1) {
// 		echo "<pre>";

// 		print_r($key1);
// 		echo "string";
// 		print_r($value1);
// 		# code...
// 	}
// }
echo "<pre>";
print_r($data);


echo "</pre>";
echo "Save the private key";
echo "<br>";
// Save the private key
$saveKeyLocation = 'C:/Users/user/Desktop'. "/.ssh/{$keyPairName}.pem";//getenv('HOME') . "/.ssh/{$keyPairName}.pem";
file_put_contents($saveKeyLocation, $result['keyMaterial']);

// Update the key's permissions so it can be used with SSH
chmod($saveKeyLocation, 0600);
exit();
echo "Create the security group";
echo "<br>";
// Create the security group
$securityGroupName = 'my-security-group';
$result = $ec2Client->createSecurityGroup(array(
    'GroupName'   => $securityGroupName,
    'Description' => 'Basic web server security'
));

// Get the security group ID (optional)
$securityGroupId = $result->get('GroupId');


echo "Set ingress rules for the security group";
echo "<br>";
// Set ingress rules for the security group
$ec2Client->authorizeSecurityGroupIngress(array(
    'GroupName'     => $securityGroupName,
    'IpPermissions' => array(
        array(
            'IpProtocol' => 'tcp',
            'FromPort'   => 80,
            'ToPort'     => 80,
            'IpRanges'   => array(
                array('CidrIp' => '0.0.0.0/0')
            ),
        ),
        array(
            'IpProtocol' => 'tcp',
            'FromPort'   => 22,
            'ToPort'     => 22,
            'IpRanges'   => array(
                array('CidrIp' => '0.0.0.0/0')
            ),
        )
    )
));


echo "Launch an instance with the key pair and security group";
echo "<br>";
// Launch an instance with the key pair and security group
$result = $ec2Client->runInstances(array(
    'ImageId'        => 'ami-00514a528eadbc95b',//'ami-570f603e',
    'MinCount'       => 1,
    'MaxCount'       => 1,
    'InstanceType'   => 't2.micro',//'m1.small',
    'KeyName'        => $keyPairName,
    'SecurityGroups' => array($securityGroupName),
));

$instanceIds = $result->getPath('Instances/*/InstanceId');


echo "Wait until the instance is launched";
echo "<br>";
// Wait until the instance is launched
$ec2Client->waitUntilInstanceRunning(array(
    'InstanceIds' => $instanceIds,
));

echo "Describe the now-running instance to get the public URL";
echo "<br>";
// Describe the now-running instance to get the public URL
$result = $ec2Client->describeInstances(array(
    'InstanceIds' => $instanceIds,
));
echo current($result->getPath('Reservations/*/Instances/*/PublicDnsName'));