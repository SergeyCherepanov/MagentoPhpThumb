<?php

class Mx_PhpThumb_Model_Product_Image
    extends Mage_Catalog_Model_Product_Image
{
    /** @var Mx_PhpThumb_Helper_Data */
    protected $_helper;

    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_helper = Mage::helper('phpthumb');
        parent::_construct();
    }
    /**
     * @return Mx_PhpThumb_Model_Image|Varien_Image
     */
    public function getImageProcessor()
    {
        if (!$this->_processor) {
            $this->_processor = new Mx_PhpThumb_Model_Image_Adapter_PhpThumb($this->getBaseFile());
        }
        $this->_processor->setResizeMethod($this->_helper->getProductResizeMethod());
        $this->_processor->keepAspectRatio($this->_keepAspectRatio);
        $this->_processor->keepFrame($this->_keepFrame);
        $this->_processor->keepTransparency($this->_keepTransparency);
        $this->_processor->constrainOnly($this->_constrainOnly);
        $this->_processor->backgroundColor($this->_backgroundColor);
        $this->_processor->quality($this->_quality);
        return $this->_processor;
    }
}
