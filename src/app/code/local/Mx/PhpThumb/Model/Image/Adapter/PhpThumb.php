<?php

class Mx_PhpThumb_Model_Image_Adapter_PhpThumb
    implements Mx_PhpThumb_Model_Image_Interface
{
    public $fileName = null;
    public $imageBackgroundColor = 0;
    /** @var array */
    protected $_actions = array();

    const ACTION_ROTATE    = 'rotate';
    const ACTION_RESIZE    = 'resize';
    const ACTION_CROP      = 'crop';
    const ACTION_WATERMARK = 'watermark';

    const RESIZE_METHOD_DEFAULT = 'default';
    const RESIZE_METHOD_CROP    = 'crop';

    const POSITION_TOP_LEFT = 'top-left';
    const POSITION_TOP_RIGHT = 'top-right';
    const POSITION_BOTTOM_LEFT = 'bottom-left';
    const POSITION_BOTTOM_RIGHT = 'bottom-right';
    const POSITION_STRETCH = 'stretch';
    const POSITION_TILE = 'tile';
    const POSITION_CENTER = 'center';

    protected $_fileType = null;
    protected $_fileName = null;
    protected $_fileMimeType = null;
    protected $_fileSrcName = null;
    protected $_fileSrcPath = null;
    protected $_imageHandler = null;
    protected $_imageSrcWidth = null;
    protected $_imageSrcHeight = null;
    protected $_requiredExtensions = null;
    protected $_watermarkPosition = null;
    protected $_watermarkWidth = null;
    protected $_watermarkHeigth = null;
    protected $_watermarkImageOpacity = null;
    protected $_quality = null;

    protected $_keepAspectRatio;
    protected $_keepFrame;
    protected $_keepTransparency;
    protected $_backgroundColor;
    protected $_constrainOnly;
    
    /** @var PhpThumb_GdThumb */
    protected $_imageProcessor;
    
    protected $_resizeMethod = self::RESIZE_METHOD_DEFAULT;

    /**
     * @param string $fileName
     */
    public function __construct($fileName)
    {
        $this->_fileName = $fileName;
    }
    
    public function setResizeMethod($method)
    {
        $this->_resizeMethod = $method;
    }

    /**
     * @return PhpThumb_GdThumb
     */
    protected function _render()
    {
        if (is_null($this->_imageProcessor)) {
            $processor = $this->open($this->_fileName);
            if (isset($this->_actions[self::ACTION_CROP])) {
                $processor->crop(
                    $this->_actions[self::ACTION_CROP]['left'],
                    $this->_actions[self::ACTION_CROP]['top'],
                    $this->_actions[self::ACTION_CROP]['right'],
                    $this->_actions[self::ACTION_CROP]['bottom']
                );
            }
            if (isset($this->_actions[self::ACTION_RESIZE])) {
                switch ($this->_resizeMethod) {
                    case self::ACTION_CROP:
                        $processor->adaptiveResize(
                            $this->_actions[self::ACTION_RESIZE]['width'],
                            $this->_actions[self::ACTION_RESIZE]['height']
                        );
                        break;
                    default:
                        $processor->resize(
                            $this->_actions[self::ACTION_RESIZE]['width'],
                            $this->_actions[self::ACTION_RESIZE]['height'],
                            $this->_keepAspectRatio
                        );
                        break;
                }
            }
            if (isset($this->_actions[self::ACTION_ROTATE])) {
                $processor->rotateImageNDegrees(
                    $this->_actions[self::ACTION_ROTATE]['angle']
                );
            }
            $this->_imageProcessor = $processor;
        }
        return $this->_imageProcessor;
    }

    /**
     * Open image file
     * 
     * @return PhpThumb_GdThumb|void
     */
    public function open()
    {
        return new PhpThumb_GdThumb($this->_fileName, array(
            'backgroundColor' => $this->_backgroundColor,
        )); 
    }

    /**
     * Save handled image into file
     * 
     * @param string $fileName
     */
    public function save($fileName)
    {
        $this->_render()->save($fileName);
    }

    /**
     * Display handled image in your browser
     *
     * @access public
     * @return void
     */
    public function display()
    {
        $this->_render()->show();
    }

    /**
     * Set rotate params.
     *
     * @param int $angle
     * @access public
     * @return void
     */
    public function rotate($angle)
    {
        $this->_actions[self::ACTION_ROTATE] = array(
            'angle' => intval($angle),
        );
    }

    /**
     * Set resize params.
     *
     * @param int $width
     * @param int $height
     * @access public
     * @return void
     */
    public function resize($width = null, $height = null)
    {
        $this->_actions[self::ACTION_RESIZE] = array(
            'width'  => intval($width), 
            'height' => intval($height ? $height : $width),
        );
    }

    /**
     * Set crop params.
     *
     * @param int $top. Default value is 0
     * @param int $left. Default value is 0
     * @param int $right. Default value is 0
     * @param int $bottom. Default value is 0
     * @access public
     * @return void
     */
    public function crop($top = 0, $left = 0, $right = 0, $bottom = 0)
    {
        $this->_actions[self::ACTION_CROP] = array(
            'top'    => $top,
            'left'   => $left,
            'right'  => $right,
            'bottom' => $bottom,
        );
    }

    /**
     * Set watermark params
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
        $watermarkImage, 
        $positionX = 0, 
        $positionY = 0, 
        $watermarkImageOpacity = 30, 
        $repeat = false)
    {
        
    }

    /**
     * Get mime type of handled image
     *
     * @access public
     * @return string
     */
    public function getMimeType()
    {
        if( $this->_fileType ) {
            return $this->_fileType;
        } else {
            list($this->_imageSrcWidth, $this->_imageSrcHeight, $this->_fileType, ) = getimagesize($this->_fileName);
            $this->_fileMimeType = image_type_to_mime_type($this->_fileType);
            return $this->_fileMimeType;
        }
    }

    /**
     * Retrieve Original Image Width
     *
     * @return int|null
     */
    public function getOriginalWidth()
    {
        $this->getMimeType();
        return $this->_imageSrcWidth;
    }

    /**
     * Retrieve Original Image Height
     *
     * @return int|null
     */
    public function getOriginalHeight()
    {
        $this->getMimeType();
        return $this->_imageSrcHeight;
    }

    public function setWatermarkPosition($position)
    {
        $this->_watermarkPosition = $position;
        return $this;
    }

    public function getWatermarkPosition()
    {
        return $this->_watermarkPosition;
    }

    public function setWatermarkImageOpacity($imageOpacity)
    {
        $this->_watermarkImageOpacity = $imageOpacity;
        return $this;
    }

    public function getWatermarkImageOpacity()
    {
        return $this->_watermarkImageOpacity;
    }

    public function setWatermarkWidth($width)
    {
        $this->_watermarkWidth = $width;
        return $this;
    }

    public function getWatermarkWidth()
    {
        return $this->_watermarkWidth;
    }

    public function setWatermarkHeigth($heigth)
    {
        $this->_watermarkHeigth = $heigth;
        return $this;
    }

    public function getWatermarkHeigth()
    {
        return $this->_watermarkHeigth;
    }


    /**
     * Get/set keepAspectRatio
     *
     * @param bool $value
     * @return bool|Varien_Image_Adapter_Abstract
     */
    public function keepAspectRatio($value = null)
    {
        if (null !== $value) {
            $this->_keepAspectRatio = (bool)$value;
        }
        return $this->_keepAspectRatio;
    }

    /**
     * Get/set keepFrame
     *
     * @param bool $value
     * @return bool
     */
    public function keepFrame($value = null)
    {
        if (null !== $value) {
            $this->_keepFrame = (bool)$value;
        }
        return $this->_keepFrame;
    }

    /**
     * Get/set keepTransparency
     *
     * @param bool $value
     * @return bool
     */
    public function keepTransparency($value = null)
    {
        if (null !== $value) {
            $this->_keepTransparency = (bool)$value;
        }
        return $this->_keepTransparency;
    }

    /**
     * Get/set constrainOnly
     *
     * @param bool $value
     * @return bool
     */
    public function constrainOnly($value = null)
    {
        if (null !== $value) {
            $this->_constrainOnly = (bool)$value;
        }
        return $this->_constrainOnly;
    }

    /**
     * Get/set quality, values in percentage from 0 to 100
     *
     * @param int $value
     * @return int
     */
    public function quality($value = null)
    {
        if (null !== $value) {
            $this->_quality = (int)$value;
        }
        return $this->_quality;
    }

    /**
     * Get/set keepBackgroundColor
     *
     * @param array $value
     * @return array
     */
    public function backgroundColor($value = null)
    {
        if (null !== $value) {
            if ((!is_array($value)) || (3 !== count($value))) {
                return;
            }
            foreach ($value as $color) {
                if ((!is_integer($color)) || ($color < 0) || ($color > 255)) {
                    return;
                }
            }
        }
        $this->_backgroundColor = $value;
        return $this->_backgroundColor;
    }

    protected function _getFileAttributes()
    {
        $pathInfo = pathinfo($this->_fileName);
        $this->_fileSrcPath = $pathInfo['dirname'];
        $this->_fileSrcName = $pathInfo['basename'];
    }
}
