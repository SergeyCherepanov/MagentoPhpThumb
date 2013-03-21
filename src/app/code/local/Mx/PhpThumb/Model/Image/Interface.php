<?php

interface Mx_PhpThumb_Model_Image_Interface
{
    /**
     * Opens an image and creates image handle
     *
     * @access public
     * @return void
     */
    public function open();
    
    /**
     * Display handled image in your browser
     *
     * @access public
     * @return void
     */
    public function display();
    
    /**
     * Save handled image into file
     *
     * @param string $fileName
     * @access public
     * @return void
     */
    public function save($fileName);
    
    /**
     * Rotate an image.
     *
     * @param int $angle
     * @access public
     * @return void
     */
    public function rotate($angle);
    
    /**
     * Crop an image.
     *
     * @param int $top. Default value is 0
     * @param int $left. Default value is 0
     * @param int $right. Default value is 0
     * @param int $bottom. Default value is 0
     * @access public
     * @return void
     */
    public function crop($top = 0, $left = 0, $right = 0, $bottom = 0);
    
    /**
     * Resize an image
     *
     * @param int $width
     * @param int $height
     * @access public
     * @return void
     */
    public function resize($width, $height = null);
    
    /**
     * Get/set keepAspectRatio
     *
     * @param bool $value
     * @return bool|Varien_Image_Adapter_Abstract
     */
    public function keepAspectRatio($value);
    
    /**
     * Get/set keepFrame
     *
     * @param bool $value
     * @return bool
     */
    public function keepFrame($value);
    
    /**
     * Get/set keepTransparency
     *
     * @param bool $value
     * @return bool
     */
    public function keepTransparency($value);
    
    /**
     * Get/set constrainOnly
     *
     * @param bool $value
     * @return bool
     */
    public function constrainOnly($value);
    
    /**
     * Get/set keepBackgroundColor
     *
     * @param array $value
     * @return array
     */
    public function backgroundColor($value);
    
    /**
     * Get/set quality, values in percentage from 0 to 100
     *
     * @param int $value
     * @return int
     */
    public function quality($value);
    
    /**
     * Adds watermark to our image.
     *
     * @param string $watermarkImage. Absolute path to watermark image.
     * @param int $positionX. Watermark X position.
     * @param int $positionY. Watermark Y position.
     * @param int $watermarkImageOpacity. Watermark image opacity.
     * @param bool $repeat. Enable or disable watermark brick.
     * @access public
     * @return void
     */
    public function watermark(
        $watermarkImage, $positionX = 0, $positionY = 0, $watermarkImageOpacity = 30, $repeat = false);
    
    /**
     * Get mime type of handled image
     *
     * @access public
     * @return string
     */
    public function getMimeType();
}
