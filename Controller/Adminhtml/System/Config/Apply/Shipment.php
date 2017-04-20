<?php

namespace Augustash\CustomOrderNumber\Controller\Adminhtml\System\Config\Apply;


use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\SalesSequence\Model\ResourceModel\Meta as ResourceMeta;
use Augustash\CustomOrderNumber\Helper\Data;
use Magento\Framework\Logger\Monolog;

class Shipment extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $logger;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var \Augustash\CustomOrderNumber\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\SalesSequence\Model\ResourceModel\Meta
     */
    protected $meta;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
     * @param \Magento\SalesSequence\Model\ResourceModel\Meta $meta
     * @param \Augustash\CustomOrderNumber\Helper\Data $helper
     * @param \Magento\Framework\Logger\Monolog $logger
     */
    public function __construct(
        Context $context,
        JsonFactory $resultJsonFactory,
        ResourceMeta $resourceMeta,
        Data $helper,
        Monolog $logger
    )
    {
        parent::__construct($context);

        $this->resultJsonFactory = $resultJsonFactory;
        $this->meta = $resourceMeta;
        $this->helper = $helper;
        $this->logger = $logger;
    }

    /**
     * Apply Order Sequence
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->resultJsonFactory->create();

        if ($this->helper->isEnabled()) {
            $prefix     = $this->helper->getShipmentPrefix();
            $suffix     = $this->helper->getShipmentSuffix();
            $startFrom  = $this->helper->getShipmentStartFrom();
            $step       = $this->helper->getShipmentStep();
            $numLength  = $this->helper->getShipmentNumberLength();

            $params = $this->getRequest()->getParams();

            if ($params['website_id'] != 0 && $params['store_view_id'] == 0) {
                $scopeLevel = 'website';
                $scope = $params['website_id']; // website level configuration
            } elseif($params['website_id'] == 0 && $params['store_view_id'] != 0) {
                $scopeLevel = 'store_view';
                $scope = $params['store_view_id']; // store_view level configuration
            } else {
                $scopeLevel = 'default';
                $scope = 0; // default level configuration
            }

            $meta = $this->meta->loadByEntityTypeAndStore('shipment', $scope);
            $profile = $meta->getActiveProfile();

            $profile->setData('prefix', $prefix);
            $profile->setData('suffix', $suffix);
            $profile->setData('start_value', $startFrom);
            $profile->setData('step', $step);
            $profile->save();

            $result->setData([
                'success'       => true,
                'error'         => false,
                'reason'        => 'OK',
                'scope_level'   => $scopeLevel,
                'scope'         => $scope,
                'sequence_configuration' => [
                    'prefix'        => $prefix,
                    'suffix'        => $suffix,
                    'start_value'   => $startFrom,
                    'step'          => $step,
                    'number_length' => $numLength,
                ],
                'sales_sequence_profile' => $profile->getData()
            ]);
        } else {
            $result->setData([
                'success'   => false,
                'error'     => true,
                'reason'    => 'Augustash_CustomOrderNumber functionality is disabled via the System > Configuration'
            ]);
        }

        return $result;
    }



    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Augustash_CustomOrderNumber::config');
    }
}
