<?php

namespace Augustash\CustomOrderNumber\Model;

use Magento\Framework\App\ResourceConnection as AppResource;
use Magento\SalesSequence\Model\Meta;
use Magento\Framework\Logger\Monolog as MonologLogger;

use Augustash\CustomOrderNumber\Helper\Data;

class CustomSequence extends \Magento\SalesSequence\Model\Sequence
{
    /**
     * @var string
     */
    protected $lastIncrementId;

    /**
     * @var \Magento\SalesSequence\Model\Meta
     */
    protected $meta;

    /**
     * @var false|\Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    /**
     * @var string
     */
    protected $pattern;

    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $logger;

    /**
     * @var \Augustash\CustomOrderNumber\Helper\Data
     */
    protected $helper;

    /**
     * @var array
     */
    protected $patterns = [];

    /**
     * @var array
     */
    protected $replacements = [];


    /**
     * @param \Magento\SalesSequence\Model\Meta             $meta
     * @param \Magento\Framework\App\ResourceConnection     $resource
     * @param \Magento\Framework\Logger\Monolog             $logger
     * @param \Augustash\CustomOrderNumber\Helper\Data      $helper
     * @param string                                        $pattern
     */
    public function __construct(
        Meta $meta,
        AppResource $resource,
        MonologLogger $logger,
        Data $helper,
        $pattern = \Magento\SalesSequence\Model\Sequence::DEFAULT_PATTERN
    )
    {
        parent::__construct($meta, $resource, $pattern);

        $this->meta = $meta;
        $this->connection = $resource->getConnection('sales');
        $this->pattern = $pattern;
        $this->logger = $logger;
        $this->helper = $helper;

        $this->patterns = [
            '/({yyyy})/',
            '/({yy})/',
            '/({mm})/',
            '/({m})/',
            '/({dd})/',
            '/({d})/',
        ];

        $this->replacements = [
            date('Y'),
            date('y'),
            date('m'),
            date('n'),
            date('d'),
            date('j'),
        ];
    }

    /**
     * Retrieve current value
     *
     * @param callable $result
     * @return string
     */
    public function getCurrentValue()
    {
        if (!$this->helper->isEnabled()) {
            return parent::getCurrentValue();
        }

        /**
         * Customer sequence functionality enabled so do the following:
         *
         *   + determine the pattern
         *   + format the prefix and suffix values
         *   + calculate the current value
         */
        if (!isset($this->lastIncrementId)) {
            $this->lastIncrementId = $this->connection->lastInsertId($this->meta->getSequenceTable());
        }
        $profile = $this->meta->getActiveProfile();
        if ($profile) {
            $prefix         = $this->formatPrefix($profile->getPrefix());
            $suffix         = $this->formatSuffix($profile->getSuffix());
        } else {
            $prefix = '';
            $suffix = '';
        }

        $pattern        = $this->getPattern($this->meta->getEntityType());
        $currentValue   = $this->_calculateCurrentValue();

        $this->logger->addDebug('FROM ' . __CLASS__ . '::' . __FUNCTION__);
        $this->logger->addDebug('$pattern: ' . var_export($pattern, true));
        $this->logger->addDebug('$prefix: ' . var_export($prefix, true));
        $this->logger->addDebug('$currentValue: ' . var_export($currentValue, true));
        $this->logger->addDebug('$suffix: ' . var_export($suffix, true));

        $customOrderNumber = sprintf($pattern, $prefix, $currentValue, $suffix);

        $this->logger->addDebug('$customOrderNumber: ' . var_export($customOrderNumber, true));


        return $customOrderNumber;
    }



    public function formatPrefix($prefix = '')
    {
        return preg_replace($this->patterns, $this->replacements, $prefix);
    }

    public function formatSuffix($suffix = '')
    {
        return preg_replace($this->patterns, $this->replacements, $suffix);
    }

    public function getPattern($entityType = 'order')
    {
        if (!$this->helper->isEnabled()) {
            return $this->pattern;
        }

        $padding = $this->_getPatternNumberLength($entityType);
        if ($padding == '0') {
            // No leading zeros!
            $this->pattern = "%s%'.d%s";
        } else {
            // make sure we don't exceed sensible defaults
            if ($padding > 9) {
                $padding = 9;
            }
            $this->pattern = "%s%'.0{$padding}d%s";
        }

        return $this->pattern;
    }

    protected function _getPatternNumberLength($entityType = 'order')
    {
        switch ($entityType) {
            case 'order':
                $length = $this->helper->getOrderNumberLength();
                break;

            default:
                $length = 9; // default Magento value
                break;
        }

        return $length;
    }

    /**
     * Calculate current value depends on start value
     *
     * Copied from Magento\SalesSequence\Model\Sequence::calculateCurrentValue()
     *
     * @return string
     */
    protected function _calculateCurrentValue()
    {
        $profile = $this->meta->getActiveProfile();


        $startValue = ($profile) ? $profile->getStartValue() : 1;
        $step = ($profile) ? $profile->getStep() : 1;

        return ($this->lastIncrementId - $startValue) * $step + $startValue;
    }
}
