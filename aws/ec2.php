<?php


require '../vendor/autoload.php';
include ('../global_constant.php');


use Aws\Ec2\Ec2Client;
// snippet-end:[ec2.php.describe_instances.import]
/**
 * Describe Instances
 *
 * This code expects that you have AWS credentials set up per:
 * https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html
 */
 
// snippet-start:[ec2.php.describe_instances.main]
$credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);


    // 'profile' => 'default',
$ec2Client = new Aws\Ec2\Ec2Client([
    'profile' => 'default',
    'version'     => 'latest',
    'region'      => REGION,
    'credentials' => $credentials
]);

$result = $ec2Client->describeInstances();

var_dump($result);