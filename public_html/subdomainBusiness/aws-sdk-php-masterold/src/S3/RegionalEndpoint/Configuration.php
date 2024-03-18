<?php
namespace Aws\S3\RegionalEndpoint;
require 'aws-sdk-php-master/src/S3/RegionalEndpoint/ConfigurationInterface.php';

class Configuration implements ConfigurationInterface
{
    private $endpointsType;
    private $isFallback;

    public function __construct($endpointsType, $isFallback = false)
    {
        $this->endpointsType = strtolower($endpointsType);
        $this->isFallback = $isFallback;
        if (!in_array($this->endpointsType, ['legacy', 'regional'])) {
            throw new \InvalidArgumentException(
                "Configuration parameter must either be 'legacy' or 'regional'."
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getEndpointsType()
    {
        return $this->endpointsType;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'endpoints_type' => $this->getEndpointsType()
        ];
    }

    public function isFallback()
    {
        return $this->isFallback;
    }
}
