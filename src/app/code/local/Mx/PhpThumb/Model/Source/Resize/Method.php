<?php

class Mx_PhpThumb_Model_Source_Resize_Method
{
    public function toOptionArray()
    {
        /** @var $helper Mx_PhpThumb_Helper_Data */
        $helper  = Mage::helper('phpthumb');
        $options = array(
            Mx_PhpThumb_Model_Image_Adapter_PhpThumb::RESIZE_METHOD_DEFAULT => $helper->__('Fit'),
            Mx_PhpThumb_Model_Image_Adapter_PhpThumb::RESIZE_METHOD_CROP    => $helper->__('Crop'),
        );
        return $options;
    }
}
