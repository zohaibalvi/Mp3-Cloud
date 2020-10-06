<?php

require '../vendor/autoload.php';
include ('../global_constant.php');


use Aws\CloudWatch\CloudWatchClient; 
use Aws\Exception\AwsException;
// snippet-end:[cloudwatch.php.describe_alarms.import]

/* ////////////////////////////////////////////////////////////////////////////
 * Purpose: Provides information for existing alarms in Amazon CloudWatch.
 * 
 * Inputs:
 * - $cloudWatchClient: An initialized CloudWatch client.
 * 
 * Returns: Information about any alarms found; otherwise, the error message.
 * ///////////////////////////////////////////////////////////////////////// */
 
// snippet-start:[cloudwatch.php.describe_alarms.main]

function describeTheAlarms()
{
$credentials = new Aws\Credentials\Credentials(AWS_ACCESS_KEY_ID, AWS_SECRET_ACCESS_KEY,TOKEN);


    $cloudWatchClient = new CloudWatchClient([
        'profile' => 'default',
        'version'     => 'latest',
        'region'      => REGION,
        // 'credentials' => $credentials
    ]);

echo describeAlarms($cloudWatchClient);
  
}


describeTheAlarms();
  



function describeAlarms($cloudWatchClient)
{
    try {
        $result = $cloudWatchClient->describeAlarms();

        $message = '';

        if (isset($result['@metadata']['effectiveUri']))
        {
            $message .= 'Alarms at the effective URI of ' . 
                $result['@metadata']['effectiveUri'] . "\n\n";

            if (isset($result['CompositeAlarms']))
            {
                $message .= "Composite alarms:\n";

                foreach ($result['CompositeAlarms'] as $alarm) {
                    $message .= $alarm['AlarmName'] . "\n";
                }
            } else {
                $message .= "No composite alarms found.\n";
            }
            
            if (isset($result['MetricAlarms']))
            {
                $message .= "Metric alarms:\n";

                foreach ($result['MetricAlarms'] as $alarm) {
                    $message .= $alarm['AlarmName'] . "\n";
                }
            } else {
                $message .= 'No metric alarms found.';
            }
        } else {
            $message .= 'No alarms found.';
        }
        
        return $message;
    } catch (AwsException $e) {
        return 'Error: ' . $e->getAwsErrorMessage();
    }
}

// function describeTheAlarms()
// {

  
// }


// describeTheAlarms();