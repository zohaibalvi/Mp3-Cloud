var AWS = require('aws-sdk');
// Load credentials and set region from JSON file
AWS.config.loadFromPath('./config-wasif.json');

var userData64 = new Buffer(`
#!/bin/bash
set -e -x
curl --silent --location https://rpm.nodesource.com/setup_9.x | bash -
sudo yum install -y git nodejs
git clone https://github.com/Vaaceph/BackEndCloud.git && cd BackEndCloud
sudo npm install
DEBUG=express:* node server.js
`).toString('base64');

var autoscaling = new AWS.AutoScaling();
var cloudwatch = new AWS.CloudWatch();

var launchConfiguration = {
	IamInstanceProfile: "arn:aws:iam::491934600746:instance-profile/S3Access", 
	ImageId: "ami-a0cfeed8",
	InstanceType: "t2.micro",
	LaunchConfigurationName: "sdk-launch-config",
	SecurityGroups: ['launch-wizard-1'],
	UserData: userData64,
	KeyName: 'wasif'
};

var AutoScalingGroup = {
	AutoScalingGroupName: "autoScalingSDK",
	AvailabilityZones: [
		"us-west-2c",
		"us-west-2b"
	],
	HealthCheckGracePeriod: 120,
	HealthCheckType: "ELB",
	LaunchConfigurationName: "sdk-launch-config",
	LoadBalancerNames: [
		"sdk-load-balancer"
	],
	MaxSize: 3,
	MinSize: 1
};

var scaleOut = {
	AdjustmentType: "ChangeInCapacity",
	AutoScalingGroupName: "autoScalingSDK",
	PolicyName: "ScaleOut",
	ScalingAdjustment: 1,
	Cooldown: 30
};

var scaleIn = {
	AdjustmentType: "ChangeInCapacity",
	AutoScalingGroupName: "autoScalingSDK",
	PolicyName: "ScaleIn",
	ScalingAdjustment: -1,
	Cooldown: 30
};

var data1;
var data2;

function launchConfigurationCallBack(err, data) {
	if (err) console.log(err, err.stack); // an error occurred
	else {
		console.log(data);           // successful response
		autoscaling.createAutoScalingGroup(AutoScalingGroup, AutoScalingGroupCreation);
	}
}

function scaleOutPolicyCallBack(err, data) {
	if (err) console.log(err, err.stack); // an error occurred
	else {
		console.log(data);           // successful response
		data1 = data.PolicyARN;

		var scaleOut = {
			AlarmName: 'ScaleOut', /* required */
			ComparisonOperator: 'GreaterThanOrEqualToThreshold', /* required */
			EvaluationPeriods: 1, /* required */
			MetricName: 'RequestCount', /* required */
			Namespace: 'AWS/ELB', /* required */
			Period: 60, /* required */
			Threshold: 7.0, /* required */
			AlarmDescription: 'This will be used to scale out',
			DatapointsToAlarm: 1,
			Dimensions: [
				{
					Name: 'LoadBalancerName', /* required */
					Value: 'sdk-load-balancer' /* required */
				},
				/* more items */
			],
			AlarmActions: [data1],
			Statistic: 'Sum'
		};

		cloudwatch.putMetricAlarm(scaleOut, function (err, data) {
			if (err) console.log(err, err.stack); // an error occurred
			else console.log(data);           // successful response
		});
	}
}


function scaleInPolicyCallBack(err, data) {
	if (err) console.log(err, err.stack); // an error occurred
	else {
		console.log(data);           // successful response
		data2 = data.PolicyARN;
		var scaleIn = {
			AlarmName: 'ScaleIn', /* required */
			ComparisonOperator: 'LessThanOrEqualToThreshold', /* required */
			EvaluationPeriods: 1, /* required */
			MetricName: 'RequestCount', /* required */
			Namespace: 'AWS/ELB', /* required */
			Period: 60, /* required */
			Threshold: 2.0, /* required */
			AlarmDescription: 'This will be used to scale in',
			DatapointsToAlarm: 1,
			Dimensions: [
				{
					Name: 'LoadBalancerName', /* required */
					Value: 'sdk-load-balancer' /* required */
				},
				/* more items */
			],
			AlarmActions: [data2],
			Statistic: 'Minimum'
		};
		cloudwatch.putMetricAlarm(scaleIn, function (err, data) {
			if (err) console.log(err, err.stack); // an error occurred
			else console.log(data);           // successful response
		});
	}
}

function AutoScalingGroupCreation(err, data) {
	if (err) console.log(err, err.stack); // an error occurred
	else {
		console.log(data);           // successful response
		autoscaling.putScalingPolicy(scaleOut, scaleOutPolicyCallBack);
		autoscaling.putScalingPolicy(scaleIn, scaleInPolicyCallBack);
	}
}

autoscaling.createLaunchConfiguration(launchConfiguration, launchConfigurationCallBack);
