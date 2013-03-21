<?php

class Mx_PhpThumb_Helper_Data
    extends Mage_Core_Helper_Abstract
{
    const CONFIG_PRODUCT_RESIZE_METHOD = 'design/image/product_resize_method';

    /**
     * @return string|null
     */
    public function getProductResizeMethod()
    {
        return Mage::getStoreConfig(self::CONFIG_PRODUCT_RESIZE_METHOD);
    }
}
