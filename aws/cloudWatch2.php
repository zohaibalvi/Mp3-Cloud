<?php

require '../vendor/autoload.php';
include ('../global_constant.php');


use Aws\CloudWatch\CloudWatchClient; 
use Aws\Exception\AwsException;

// List Metrics

// $client = new CloudWatchClient([
//     'profile' => 'default',
//     'version'     => 'latest',
//     'region'      => REGION,
// ]);

// try {
//     $result = $client->listMetrics();
//     echo "<pre>";
//     print_r($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     error_log($e->getMessage());
// }




// Retrieve Alarms for a Metric
// try {
//     $result = $client->describeAlarmsForMetric(array(
//         // MetricName is required
//         'MetricName' => 'ApproximateNumberOfMessagesVisible',
//         // Namespace is required
//         'Namespace' => 'AWS/SQS',
//     ));
// echo "<pre>";
//     print_r($result);
// } catch (AwsException $e) {
//     // output error message if fails
//     error_log($e->getMessage());
// }


// create Alaram 
 
 function putMetricAlarm($cloudWatchClient, $cloudWatchRegion, 
    $alarmName, $namespace, $metricName, 
    $dimensions, $statistic, $period, $comparison, $threshold, 
    $evaluationPeriods,$AlarmActions)
{
    try {
        $result = $cloudWatchClient->putMetricAlarm([
            'AlarmName' => $alarmName,
            'Namespace' => $namespace,
            'MetricName' => $metricName,
            'Dimensions' => $dimensions,
            'Statistic' => $statistic,
            'Period' => $period,
            'ComparisonOperator' => $comparison,
            'Threshold' => $threshold,
            'EvaluationPeriods' => $evaluationPeriods,
            'AlarmActions' => $AlarmActions
        ]);
        
        if (isset($result['@metadata']['effectiveUri']))
        {
            if ($result['@metadata']['effectiveUri'] == 
                'https://monitoring.' . $cloudWatchRegion . '.amazonaws.com')
            {
                return 'Successfully created or updated specified alarm.';
            } else {
                return 'Could not create or update specified alarm.';
            }
        } else {
            return 'Could not create or update specified alarm.';
        }
    } catch (AwsException $e) {
        return 'Error: ' . $e->getAwsErrorMessage();
    }
}

	// var scaleOut = {
	// 		AlarmName: 'ScaleOut', /* required */
	// 		ComparisonOperator: 'GreaterThanOrEqualToThreshold', /* required */
	// 		EvaluationPeriods: 1, /* required */
	// 		MetricName: 'RequestCount', /* required */
	// 		Namespace: 'AWS/ELB', /* required */
	// 		Period: 60, /* required */
	// 		Threshold: 7.0, /* required */
	// 		AlarmDescription: 'This will be used to scale out',
	// 		DatapointsToAlarm: 1,
	// 		Dimensions: [
	// 			{
	// 				Name: 'LoadBalancerName', /* required */
	// 				Value: 'sdk-load-balancer' /* required */
	// 			},
	// 			/* more items */
	// 		],
	// 		AlarmActions: [data1],
	// 		Statistic: 'Sum'
	// 	};

	// 	cloudwatch.putMetricAlarm(scaleOut, function (err, data) {
	// 		if (err) console.log(err, err.stack); // an error occurred
	// 		else console.log(data);           // successful response
	// 	});
function putTheMetricAlarm()
{
    $alarmName = 'my-ec2';
    $namespace = 'AWS/EC2';
    $metricName = 'NetworkOut';
    $dimensions = [
        [
            'Name' => 'InstanceId',
            'Value' => 'i-051381b2dd6264619'
        ]
    ];
    $statistic = 'Average';
    $period = 60;
    $comparison = 'GreaterThanThreshold';
    $threshold = 1;
    $evaluationPeriods = 1;

    $cloudWatchRegion = REGION;


  $AlarmActions = [
    // 'STRING_VALUE',
    // its working
    // 'arn:aws:automate:us-east-1:ec2:stop'

    'arn:aws:sns:us-east-1:372100151213:MyTopic'
    // 'arn:aws:ec2:*:372100151213:instance/i-051381b2dd6264619'
   // ' arn:aws:automate:region:ec2:stop '
    // | arn:aws:automate:region:ec2:terminate | arn:aws:automate:region:ec2:recover | arn:aws:automate:region:ec2:reboot | arn:aws:sns:region:account-id:sns-topic-name | arn:aws:autoscaling:region:account-id:scalingPolicy:policy-id:autoScalingGroupName/group-friendly-name:policyName/policy-friendly-name
    /* more items */
  ];
    $cloudWatchClient = new CloudWatchClient([
        'profile' => 'default',
        'region' => $cloudWatchRegion,
        'version' => 'latest'
    ]);


    echo putMetricAlarm($cloudWatchClient, $cloudWatchRegion, 
        $alarmName, $namespace, $metricName, 
        $dimensions, $statistic, $period, $comparison, $threshold, 
        $evaluationPeriods,$AlarmActions);
}

// Uncomment the following line to run this code in an AWS account.
echo "<pre>";
print_r(putTheMetricAlarm());



// var params = {
//   AlarmName: 'STRING_VALUE', /* required */
//   ComparisonOperator: GreaterThanOrEqualToThreshold | GreaterThanThreshold | LessThanThreshold | LessThanOrEqualToThreshold | LessThanLowerOrGreaterThanUpperThreshold | LessThanLowerThreshold | GreaterThanUpperThreshold, /* required */
//   EvaluationPeriods: 'NUMBER_VALUE', /* required */
//   ActionsEnabled: true || false,
//   AlarmActions: [
//     'STRING_VALUE',
//     /* more items */
//   ],
//   AlarmDescription: 'STRING_VALUE',
//   DatapointsToAlarm: 'NUMBER_VALUE',
//   Dimensions: [
//     {
//       Name: 'STRING_VALUE', /* required */
//       Value: 'STRING_VALUE' /* required */
//     },
//     /* more items */
//   ],
//   EvaluateLowSampleCountPercentile: 'STRING_VALUE',
//   ExtendedStatistic: 'STRING_VALUE',
//   InsufficientDataActions: [
//     'STRING_VALUE',
//     /* more items */
//   ],
//   MetricName: 'STRING_VALUE',
//   Metrics: [
//     {
//       Id: 'STRING_VALUE', /* required */
//       Expression: 'STRING_VALUE',
//       Label: 'STRING_VALUE',
//       MetricStat: {
//         Metric: { /* required */
//           Dimensions: [
//             {
//               Name: 'STRING_VALUE', /* required */
//               Value: 'STRING_VALUE' /* required */
//             },
//             /* more items */
//           ],
//           MetricName: 'STRING_VALUE',
//           Namespace: 'STRING_VALUE'
//         },
//         Period: 'NUMBER_VALUE', /* required */
//         Stat: 'STRING_VALUE', /* required */
//         Unit: Seconds | Microseconds | Milliseconds | Bytes | Kilobytes | Megabytes | Gigabytes | Terabytes | Bits | Kilobits | Megabits | Gigabits | Terabits | Percent | Count | Bytes/Second | Kilobytes/Second | Megabytes/Second | Gigabytes/Second | Terabytes/Second | Bits/Second | Kilobits/Second | Megabits/Second | Gigabits/Second | Terabits/Second | Count/Second | None
//       },
//       Period: 'NUMBER_VALUE',
//       ReturnData: true || false
//     },
//     /* more items */
//   ],
//   Namespace: 'STRING_VALUE',
//   OKActions: [
//     'STRING_VALUE',
//     /* more items */
//   ],
//   Period: 'NUMBER_VALUE',
//   Statistic: SampleCount | Average | Sum | Minimum | Maximum,
//   Tags: [
//     {
//       Key: 'STRING_VALUE', /* required */
//       Value: 'STRING_VALUE' /* required */
//     },
//     /* more items */
//   ],
//   Threshold: 'NUMBER_VALUE',
//   ThresholdMetricId: 'STRING_VALUE',
//   TreatMissingData: 'STRING_VALUE',
//   Unit: Seconds | Microseconds | Milliseconds | Bytes | Kilobytes | Megabytes | Gigabytes | Terabytes | Bits | Kilobits | Megabits | Gigabits | Terabits | Percent | Count | Bytes/Second | Kilobytes/Second | Megabytes/Second | Gigabytes/Second | Terabytes/Second | Bits/Second | Kilobits/Second | Megabits/Second | Gigabits/Second | Terabits/Second | Count/Second | None
// };
// cloudwatch.putMetricAlarm(params, function(err, data) {
//   if (err) console.log(err, err.stack); // an error occurred
//   else     console.log(data);           // successful response
// });