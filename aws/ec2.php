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
 // $KeyMaterial = "-----BEGIN RSA PRIVATE KEY-----
 // MIIEogIBAAKCAQEAgoPw1xZii9/lZJ1VoBr2G5EUck11DFLpiSd7JQhL2crFZ+oK
 // ymEQkwmC813kO8bAaaPvNCeb7ZmriZY4bCn5OR+2V8Zb1i2d0HalEzd+oI0TIUm9
 // 2c+C4fSqfYZSMaDDjWzzsbJyqx+XZrdCI4wtbcEZsU2HSpr9acSJlMBHOSP4JL6V
 // zNwntJkoadmQa2fJz9Kn53cAOuDY8n5HTGe21dbBLH+61Z+FZc20UN7KY3f50Yd3
 // 1YKbUcPcr7JNKc4dyaEzPiCX0DqlJatTzS1td9WEfZvYpTJNcdGXenVay+/Kv8lY
 // 4wNcMxXRZi2kqvPh/0ofkbzaIsVuiDwD8qOmNwIDAQABAoIBACFrw+pwEwAab1Va
 // bKi4/riEaCX067oiKScz8vbCrxmwMOixJ943CNV+JAhJzL354R+sGP7T/bvUE/cB
 // fqVEAku8cSb85ltsBvNwzkijd0uJlJJ7nZ/+4VcXHelS0g1fS3QVqDmipnZneo+U
 // 8dzEcoWeYwPiBHj4Q1goOcrbieF5lN1xdx0m+wPQyZ2aDmXBN3w+qE9yYYRStm6j
 // xdqMQO9mwZa3C5tRZCQ0WTU1j15D78sAQNGyPV+xLiKqbUnsAVpRRQBtJYRzJ72r
 // Wh0CU8q/eQxSxHuTuT5CfQL8GXvivtCTyrNCr/90BmJWsg7/ChDEn95A03HHn5Jz
 // A2wD1CECgYEAuAimA8B1MYS0jeIIbTw8NDJcRx56jhMa8xNuNENH4wlyW2yIKLme
 // XF5LPJlBS3TF3Lkv3bfo8jtQkoT8uxQsdpwRIwSbpFvEBdgBKoeX56VzZVDnjskF
 // WFPNUwzJ4NZzb5d8OQp37xPdZQ7M+1ZQVH2HDX0yDYNzpKYrmnHkm0kCgYEAtY2l
 // HczZy2bIDlYXrInByo5ji63SmoIDyfcxMxCoi6Zxn4qwW60PHG9yJ4QikRZ9bIah
 // juttb9LVj7q7rFEaob4S5VV2lQk+slQODPQ9nUwYK96S5kYZa1bjqheOi/1qIbBk
 // YhhZGRFeeGMD+CuWcsDnpBzkGnjFPnykx1zwtX8CgYAKK8AxGOPhNrpb1RAuKVQS
 // dm4PKCoRzBCDOqGulcFVVOJTFy53Qbr00+lIkhe/udZtmnaAxHdFW+3aCyuEk1rZ
 // u0pfKxQHA2NUB1oZJaFJliVIhi4mAAohlZAVdPF7UZ7TngWpiWCTf/+OZEED6wNJ
 // iB58qlynzooHoX9ra7v8sQKBgBDUR3kCszGqnmLN0jX5MxCOsGWTQFF4Odev5Uyh
 // f64qSKAMYBqvaRYusns9QWMHnarAtBsmcaeK+KbxHVJ01i4mC2Rczrgz+i7XodHL
 // liaNljQC1sUnvFV54XKz6k/JttvWmQeK0D+Fn6czLnwDtld+0DojP3XAui/3p+Kf
 // F+ULAoGAUrVGqnRWnNZepr/ve+ksVCEMvCH2HYHOURNW4OJxaMqI46HaLV7uwCHo
 // ncTnz+Do5I1TXTc/cOTfcgFJK0LsAIZPZnZ9qMw8coNCO2txEtc317LA3hK8cIcf
 // DRWBPqBVXit/vLcIGQFDVoO9bNn5hnthA9RSlPKByEuQKz0wEYY=
 // -----END RSA PRIVATE KEY-----";

//   $data = file_get_contents('C:/Users/user/Desktop/.ssh/mya-keaaaykpair-m1.pem');

// $data1 =  strstr($data, '-----BEGIN');
// // echo $data1;
// $variable = substr($data1, 0, strpos($data1, '"KeyName"')); 
// echo ;
// echo   substr($variable, 0, -3);
// exit;
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
$keyPairName = 'my-keypair-mp3';
$result = $ec2Client->createKeyPair(array(
    'KeyName' => $keyPairName
));

exit;
echo "Save the private key";

// Save the private key
$saveKeyLocation = 'C:/Users/user/Desktop'. "/.ssh/{$keyPairName}.pem";//getenv('HOME') . "/.ssh/{$keyPairName}.pem";

$data = $result->toArray()['KeyMaterial'];
file_put_contents($saveKeyLocation, $data);

// Update the key's permissions so it can be used with SSH
chmod($saveKeyLocation, 0600);

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
    'ImageId'        => 'ami-00514a528eadbc95b',//'ami-570f603e',  //Ubuntu Server 20.04 LTS (HVM), SSD Volume Type
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