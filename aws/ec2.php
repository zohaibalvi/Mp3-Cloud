<?php
// https://aws.amazon.com/blogs/developer/provision-an-amazon-ec2-instance-with-php/

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
        // 'credentials' => $credentials


));

echo "Create the key pair";
echo "<br>";
// Create the key pair
$keyPairName = 'my-keypair';
$result = $ec2Client->createKeyPair(array(
    'KeyName' => $keyPairName
));

// exit;
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
    'ImageId'        => 'ami-0dba2cb6798deb6d8',//'ami-570f603e',  //Ubuntu Server 20.04 LTS (HVM), SSD Volume Type
    'MinCount'       => 1,
    'MaxCount'       => 1,
    'InstanceType'   => 't2.micro',//'m1.small',
    'KeyName'        => $keyPairName,
    'SecurityGroups' => array($securityGroupName),
    'UserData'      => $userDataEncoded
));

$instanceIds = $result->getPath('Instances/*/InstanceId');

// echo "<pre>";
// print_r($instanceIds);

echo "Wait until the instance is launched";
echo "<br>";
// Wait until the instance is launched
// $ec2Client->waitUntilInstanceRunning(array(
//     'InstanceIds' => $instanceIds,
// ));

// echo "Describe the now-running instance to get the public URL";
// echo "<br>";
// // Describe the now-running instance to get the public URL
// $result = $ec2Client->describeInstances(array(
//     'InstanceIds' => $instanceIds,
// ));
// echo current($result->getPath('Reservations/*/Instances/*/PublicDnsName'));