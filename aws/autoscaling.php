<?php
// https://docs.aws.amazon.com/autoscaling/ec2/userguide/create-lc-with-instanceID.html
// https://docs.aws.amazon.com/aws-sdk-php/v2/api/class-Aws.AutoScaling.AutoScalingClient.html#_createLaunchConfiguration
require '../vendor/autoload.php';
use Aws\AutoScaling\AutoScalingClient;

$client = AutoScalingClient::factory(array(
   	'profile' => 'default',
		'version'     => 'latest',	
    'region'      => 'us-east-1',
));

$result = $client->describeAutoScalingNotificationTypes([
]);

$result = $client->describeNotificationConfigurations([
    'AutoScalingGroupNames' => ['AutoScalingGroup-03'],
    'MaxRecords' => 4,
    // 'NextToken' => '<string>',
]);
print_r($result);
exit();
$result = $client->createLaunchConfiguration(array(
    // LaunchConfigurationName is required
    'LaunchConfigurationName' => 'MyLaunhConfig-03',
    'ImageId' => 'ami-0513c3e1f5ea987a6',
    'KeyName' => 'my-keypair-ec2',
    'SecurityGroups' => array('sg-0ac7987fcc3ee9468'),
    // 'ClassicLinkVPCId' => 'string',
    // 'ClassicLinkVPCSecurityGroups' => array('string', ... ),
    // 'UserData' => 'string',
    // 'InstanceId' => 'string',
    'InstanceType' => 't2.micro',
    // 'KernelId' => NULL,
    // 'RamdiskId' => NULL,
     "BlockDeviceMappings"=> []
    // 'BlockDeviceMappings' => array(
    //     array(
    //         'VirtualName' => 'string',
    //         // DeviceName is required
    //         'DeviceName' => 'string',
    //         'Ebs' => array(
    //             'SnapshotId' => 'string',
    //             'VolumeSize' => integer,
    //             'VolumeType' => 'string',
    //             'DeleteOnTermination' => true || false,
    //             'Iops' => integer,
    //             'Encrypted' => true || false,
    //         ),
    //         'NoDevice' => true || false,
    //     ),
    //     // ... repeated
    // ),
    // 'InstanceMonitoring' => array(
    //     'Enabled' => true || false,
    // ),
    // 'SpotPrice' => 'string',
    // 'IamInstanceProfile' => 'string',
    // 'EbsOptimized' => true || false,
    // 'AssociatePublicIpAddress' => true || false,
    // 'PlacementTenancy' => 'string',
));


$result = $client->createAutoScalingGroup(array(
    // AutoScalingGroupName is required
    'AutoScalingGroupName' => 'AutoScalingGroup-03',
    'LaunchConfigurationName' => 'MyLaunhConfig-03',
    // 'InstanceId' => 'i-050ac72a26a0ef43e',
    // MinSize is required
    'MinSize' => 1,
    // MaxSize is required
    'MaxSize' => 1,
    'DesiredCapacity' => 1,
    // 'DefaultCooldown' => 300,
    // 'AvailabilityZones' => array('us-east-1'),
    // 'LoadBalancerNames' => array('string', ... ),
    'HealthCheckType' => 'EC2',
    // 'HealthCheckGracePeriod' => integer,
    // 'PlacementGroup' => 'string',
    'VPCZoneIdentifier' => 'subnet-63e59a2e',
    // 'TerminationPolicies' => array('string', ... ),
    // 'NewInstancesProtectedFromScaleIn' => true || false,
    'NotificationConfigurations' => array(
        "NotificationTypes" => 
        array(
            'autoscaling:EC2_INSTANCE_LAUNCH','autoscaling:EC2_INSTANCE_LAUNCH_ERROR','autoscaling:EC2_INSTANCE_TERMINATE','autoscaling:EC2_INSTANCE_TERMINATE_ERROR','autoscaling:TEST_NOTIFICATION'
        ),
        "TopicARN" => 'arn:aws:sns:us-east-1:372100151213:MyTopic'
    ),

    'Tags' => array(
        array(
            // 'ResourceId' => 'auto-scaling-group',
            // 'ResourceType' => 'string',
            // Key is required
            'Key' => 'Name',
            'Value' => 'auto-scaling-webserver',
            'PropagateAtLaunch' => true ,
        ),
    //     // ... repeated
    ),
));




// https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-autoscaling-2011-01-01.html#createautoscalinggroup


echo "<pre>";
print_r($result);