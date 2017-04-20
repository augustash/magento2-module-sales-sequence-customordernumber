<?php

namespace Augustash\CustomOrderNumber\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;


class NumberLength implements ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 0, 'label' => __('0 - Disable leading zeros')],
            ['value' => 5, 'label' => __('5')],
            ['value' => 6, 'label' => __('6')],
            ['value' => 7, 'label' => __('7')],
            ['value' => 8, 'label' => __('8')],
            ['value' => 9, 'label' => __('9')],
        ];
    }
}
