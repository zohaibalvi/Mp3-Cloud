<?php

require '../vendor/autoload.php';
include ('../global_constant.php');


use Aws\Ec2\Ec2Client;
use Aws\Rds\RdsClient; 
use Aws\S3\S3Client;
use Aws\Exception\AwsException;





$ec2Client = Ec2Client::factory(array(
		'version'     => 'latest',	
    	'region'      => REGION,
));

// Create the key pair
echo "Create the key pair";
echo "<br>";
$keyPairName = 'my-keypair';
$result = $ec2Client->createKeyPair(array(
    'KeyName' => $keyPairName
));


// Save the private key
echo "Save the private key";
echo "<br>";
$saveKeyLocation = DESKTOP_PATH. "/.ssh/{$keyPairName}.pem";

$data = $result->toArray()['KeyMaterial'];
file_put_contents($saveKeyLocation, $data);

// Update the key's permissions so it can be used with SSH
chmod($saveKeyLocation, 0600);



// Create the security group
echo "Create the security group";
echo "<br>";
$securityGroupName = 'my-security-group';
$result = $ec2Client->createSecurityGroup(array(
    'GroupName'   => $securityGroupName,
    'Description' => 'Basic web server security'
));

// Set ingress rules for the security group
echo "Set ingress rules for the security group";
echo "<br>";
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

$userData= '#!/bin/bash
#https://gist.github.com/aamnah/f03c266d715ed479eb46

# Update packages and Upgrade system
echo -e "Updating System.. "
sudo apt-get update -y && sudo apt-get upgrade -y

## Install AMP
echo -e "Installing Apache2 "
sudo apt-get install -y apache2 apache2-doc apache2-mpm-prefork apache2-utils libexpat1 ssl-cert

echo -e "Installing PHP & Requirements "
sudo apt-get install -y libapache2-mod-php5 php5 php5-common php5-curl php5-dev php5-gd php5-idn php-pear php5-imagick php5-mcrypt php5-mysql php5-ps php5-pspell php5-recode php5-xsl

echo -e "Installing MySQL "
sudo apt-get install -y mysql-server mysql-client libmysqlclient15.dev

echo -e "Installing phpMyAdmin "
sudo DEBIAN_FRONTEND=noninteractive apt-get -yq install phpmyadmin

echo -e "Verifying installs"
sudo apt-get install -y apache2 libapache2-mod-php5 php5 mysql-server php-pear php5-mysql mysql-client mysql-server php5-mysql php5-gd

# Permissions
echo -e "Permissions for /var/www "
sudo chown -R www-data:www-data /var/www
echo -e " Permissions have been set "

# give permission of html folder
sudo chmod a+rwx /var/www/html

#clone project
echo -e "git clone"
git clone  https://github.com/zohaibalvi/mp3.git /var/www/html/mp3
echo -e "git end"


# Enabling Mod Rewrite, required for WordPress permalinks and .htaccess files
echo -e "Enabling Modules "
sudo a2enmod rewrite
sudo php5enmod mcrypt

# Restart Apache
echo -e "Restarting Apache "
sudo service apache2 restart';

$userDataEncoded = base64_encode($userData);


// Launch an instance with the key pair and security group
$result = $ec2Client->runInstances(array(
    'ImageId'        => 'ami-0dba2cb6798deb6d8',
    'MinCount'       => 1,
    'MaxCount'       => 1,
    'InstanceType'   => 't2.micro',//'m1.small',
    'KeyName'        => $keyPairName,
    'SecurityGroups' => array($securityGroupName),
    'UserData'      => $userDataEncoded
));


echo "Wait until the instance is launched";
echo "<br>";


echo '<h1> Now Creating RDS </h1>';
echo "<br>";


//Create a RDSClient
$rdsClient = new Aws\Rds\RdsClient([
    'version'     => 'latest',
    'region'      => REGION,
]);

$dbIdentifier = RDS_NAME;
$dbClass = RDS_CLASS;
$storage = RDS_STORAGE;
$engine = RDS_ENGINE;
$username = RDS_USER;
$password =  RDS_PASSWORD;

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
    echo "RDS has been created";
    echo "<br>";
    // print_r($result->ToArray());
} catch (AwsException $e) {
    echo $e->getMessage();
    echo "\n";
} 



echo '<h1> Now Creating s3 bucket </h1>';
echo "<br>";

$s3 = new Aws\S3\S3Client([
    'version'     => 'latest',
    'region'      => REGION,
]);
  try {
    $promise = $s3->createBucketAsync([
      'Bucket' => BUCKET_NAME,
      'CreateBucketConfiguration' => [
        'LocationConstraint' => REGION
      ]
    ]);

    $promise->wait();

  } catch (Exception $e) {
    if ($e->getCode() == 'BucketAlreadyExists') {
      exit("\nCannot create the bucket. " .
        "A bucket with the name ".BUCKET_NAME." already exists. Exiting.");
    }
  }
