<?php
namespace Aws\S3\RegionalEndpoint\Exception;

use Aws\HasMonitoringEventsTrait;
use Aws\MonitoringEventsInterface;
require 'aws-sdk-php-master/src/MonitoringEventsInterface.php';
require 'aws-sdk-php-master/src/HasMonitoringEventsTrait.php';

/**
 * Represents an error interacting with configuration for sts regional endpoints
 */
class ConfigurationException extends \RuntimeException implements
    MonitoringEventsInterface
{
    use HasMonitoringEventsTrait;
}
