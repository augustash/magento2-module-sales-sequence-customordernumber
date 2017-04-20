<?php

namespace Augustash\CustomOrderNumber\Block\Adminhtml\System\Config\Sequence;

class Invoice extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var string
     */
    protected $_template = 'Augustash_CustomOrderNumber::system/config/invoice_sequence.phtml';

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Remove scope label
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param  \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return ajax url for apply order sequence button
     *
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('augustash_customordernumber/system_config_apply/invoice');
    }

    /**
     * Generate synchronize button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()
            ->createBlock('Magento\Backend\Block\Widget\Button')
            ->setData(
                [
                    'id' => 'apply_invoice_sequence_button',
                    'label' => __('Apply Invoice Sequence'),
                ]
            );

        return $button->toHtml();
    }

}
