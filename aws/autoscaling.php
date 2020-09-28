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


// $result = $client->createLaunchConfiguration(array(
//     // LaunchConfigurationName is required
//     'LaunchConfigurationName' => 'MyLaunhConfig-01',
//     'ImageId' => 'ami-04078d90f5bfd8c5b',
//     'KeyName' => 'my-keypair',
//     'SecurityGroups' => array('sg-09a04ac34bedcc1b8'),
//     // 'ClassicLinkVPCId' => 'string',
//     // 'ClassicLinkVPCSecurityGroups' => array('string', ... ),
//     // 'UserData' => 'string',
//     // 'InstanceId' => 'string',
//     'InstanceType' => 't2.micro',
//     // 'KernelId' => NULL,
//     // 'RamdiskId' => NULL,
//      "BlockDeviceMappings"=> []
//     // 'BlockDeviceMappings' => array(
//     //     array(
//     //         'VirtualName' => 'string',
//     //         // DeviceName is required
//     //         'DeviceName' => 'string',
//     //         'Ebs' => array(
//     //             'SnapshotId' => 'string',
//     //             'VolumeSize' => integer,
//     //             'VolumeType' => 'string',
//     //             'DeleteOnTermination' => true || false,
//     //             'Iops' => integer,
//     //             'Encrypted' => true || false,
//     //         ),
//     //         'NoDevice' => true || false,
//     //     ),
//     //     // ... repeated
//     // ),
//     // 'InstanceMonitoring' => array(
//     //     'Enabled' => true || false,
//     // ),
//     // 'SpotPrice' => 'string',
//     // 'IamInstanceProfile' => 'string',
//     // 'EbsOptimized' => true || false,
//     // 'AssociatePublicIpAddress' => true || false,
//     // 'PlacementTenancy' => 'string',
// ));

// https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-autoscaling-2011-01-01.html#createautoscalinggroup
$result = $client->createAutoScalingGroup(array(
    // AutoScalingGroupName is required
    'AutoScalingGroupName' => 'sg-09a04ac34bedcc1b8',
    'LaunchConfigurationName' => 'MyLaunhConfig-01',
    // 'InstanceId' => 'string',
    // MinSize is required
    'MinSize' => 1,
    // MaxSize is required
    'MaxSize' => 4,
    // 'DesiredCapacity' => integer,
    'DefaultCooldown' => 300,
    'AvailabilityZones' => array('us-east-1'),
    // 'LoadBalancerNames' => array('string', ... ),
    'HealthCheckType' => 'EC2',
    // 'HealthCheckGracePeriod' => integer,
    // 'PlacementGroup' => 'string',
    // 'VPCZoneIdentifier' => 'string',
    // 'TerminationPolicies' => array('string', ... ),
    // 'NewInstancesProtectedFromScaleIn' => true || false,
    // 'Tags' => array(
    //     array(
    //         'ResourceId' => 'auto-scaling-group',
    //         'ResourceType' => 'string',
    //         // Key is required
    //         'Key' => 'my-asg',
    //         'Value' => 'string',
    //         'PropagateAtLaunch' => true || false,
    //     ),
    //     // ... repeated
    // ),
));

echo "<pre>";
print_r($result);