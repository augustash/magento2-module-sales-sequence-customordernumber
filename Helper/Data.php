<?php

namespace Augustash\CustomOrderNumber\Helper;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Admin config settings
     */
    const XML_IS_ENABLED = 'augustash_customordernumber/general/enabled';
    const XML_ORDER_PREFIX = 'augustash_customordernumber/order/prefix';
    const XML_ORDER_SUFFIX = 'augustash_customordernumber/order/suffix';
    const XML_ORDER_START = 'augustash_customordernumber/order/start_counter_from';
    const XML_ORDER_STEP = 'augustash_customordernumber/order/counter_increment_step';
    const XML_ORDER_NUMBER_LENGTH = 'augustash_customordernumber/order/number_length';

    const XML_INVOICE_PREFIX = 'augustash_customordernumber/invoice/prefix';
    const XML_INVOICE_SUFFIX = 'augustash_customordernumber/invoice/suffix';
    const XML_INVOICE_START = 'augustash_customordernumber/invoice/start_counter_from';
    const XML_INVOICE_STEP = 'augustash_customordernumber/invoice/counter_increment_step';
    const XML_INVOICE_NUMBER_LENGTH = 'augustash_customordernumber/invoice/number_length';

    const XML_SHIPMENT_PREFIX = 'augustash_customordernumber/shipment/prefix';
    const XML_SHIPMENT_SUFFIX = 'augustash_customordernumber/shipment/suffix';
    const XML_SHIPMENT_START = 'augustash_customordernumber/shipment/start_counter_from';
    const XML_SHIPMENT_STEP = 'augustash_customordernumber/shipment/counter_increment_step';
    const XML_SHIPMENT_NUMBER_LENGTH = 'augustash_customordernumber/shipment/number_length';

    const XML_CREDITMEMO_PREFIX = 'augustash_customordernumber/creditmemo/prefix';
    const XML_CREDITMEMO_SUFFIX = 'augustash_customordernumber/creditmemo/suffix';
    const XML_CREDITMEMO_START = 'augustash_customordernumber/creditmemo/start_counter_from';
    const XML_CREDITMEMO_STEP = 'augustash_customordernumber/creditmemo/counter_increment_step';
    const XML_CREDITMEMO_NUMBER_LENGTH = 'augustash_customordernumber/creditmemo/number_length';

    public function isEnabled()
    {
        if ($this->getConfig(self::XML_IS_ENABLED)) {
            return true;
        }

        return false;
    }

    public function getOrderPrefix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_ORDER_PREFIX);
    }

    public function getOrderSuffix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_ORDER_SUFFIX);
    }

    public function getOrderStartFrom()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento start from value
        }

        return $this->getConfig(self::XML_ORDER_START);
    }

    public function getOrderStep()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento step by value
        }

        return $this->getConfig(self::XML_ORDER_STEP);
    }

    public function getOrderNumberLength()
    {
        if (!$this->isEnabled()) {
            return 9; // default Magento sequence length
        }

        return $this->getConfig(self::XML_ORDER_NUMBER_LENGTH);
    }

    public function getInvoicePrefix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_INVOICE_PREFIX);
    }

    public function getInvoiceSuffix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_INVOICE_SUFFIX);
    }

    public function getInvoiceStartFrom()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento start from value
        }

        return $this->getConfig(self::XML_INVOICE_START);
    }

    public function getInvoiceStep()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento step by value
        }

        return $this->getConfig(self::XML_INVOICE_STEP);
    }

    public function getInvoiceNumberLength()
    {
        if (!$this->isEnabled()) {
            return 9; // default Magento sequence length
        }

        return $this->getConfig(self::XML_INVOICE_NUMBER_LENGTH);
    }

    public function getShipmentPrefix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_SHIPMENT_PREFIX);
    }

    public function getShipmentSuffix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_SHIPMENT_SUFFIX);
    }

    public function getShipmentStartFrom()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento start from value
        }

        return $this->getConfig(self::XML_SHIPMENT_START);
    }

    public function getShipmentStep()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento step by value
        }

        return $this->getConfig(self::XML_SHIPMENT_STEP);
    }

    public function getShipmentNumberLength()
    {
        if (!$this->isEnabled()) {
            return 9; // default Magento sequence length
        }

        return $this->getConfig(self::XML_SHIPMENT_NUMBER_LENGTH);
    }

    public function getCreditmemoPrefix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_CREDITMEMO_PREFIX);
    }

    public function getCreditmemoSuffix()
    {
        if (!$this->isEnabled()) {
            return null;
        }

        return $this->getConfig(self::XML_CREDITMEMO_SUFFIX);
    }

    public function getCreditmemoStartFrom()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento start from value
        }

        return $this->getConfig(self::XML_CREDITMEMO_START);
    }

    public function getCreditmemoStep()
    {
        if (!$this->isEnabled()) {
            return 1; // default Magento step by value
        }

        return $this->getConfig(self::XML_CREDITMEMO_STEP);
    }

    public function getCreditmemoNumberLength()
    {
        if (!$this->isEnabled()) {
            return 9; // default Magento sequence length
        }

        return $this->getConfig(self::XML_CREDITMEMO_NUMBER_LENGTH);
    }


    public function getConfig($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
