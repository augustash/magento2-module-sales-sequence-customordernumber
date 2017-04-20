# Augustash_CustomerOrderNumber

## Overview:

Allow admins to set custom prefix, suffix, and leading zero length values for the order numbers, invoices, shipments, and credit memos by overriding the Magento_SalesSequence module's default pattern

## Installation

In your project's `composer.json` file, add the following lines to the `require` and `repositories` sections:

```js
{
    "require": {
        "augustash/module-sales-sequence-customordernumber": "dev-master"
    },
    "repositories": {
        "augustash-customordernumber": {
            "type": "vcs",
            "url": "https://github.com/augustash/magento2-module-sales-sequence-customordernumber.git"
        }
    }
}
```
