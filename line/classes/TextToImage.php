<?php
/**
 * TextToImage class
 * This class converts text to image
 * 
 * @author    CodexWorld Dev Team
 * @link    http://www.codexworld.com
 * @license    http://www.codexworld.com/license/
 */
class TextToImage {
	
    private $img;
    private $fontName;
    private $lineBgColor;
    private $lineTextColor;
    
    function __construct() {
	    $this->fontName = 'supermarket.ttf';
	    $this->lineBgColor = new RGBColor(229, 255, 242);
	    $this->lineTextColor = new RGBColor(0, 0, 0);
    }
    
    /**
     * Create image from text
     * @param string text to convert into image
     * @param int font size of text
     * @param int width of the image
     * @param int height of the image
     */
    function createImage($text, $fontSize = 20, $imgWidth = 400, $imgHeight = 80) {

        //text font path
        $font = 'fonts/'.$this->fontName;
        
        //create the image
        $this->img = imagecreatetruecolor($imgWidth, $imgHeight);
        
        //create some colors
        $white = imagecolorallocate($this->img, 255, 255, 255);
        $grey = imagecolorallocate($this->img, 128, 128, 128);
        $black = imagecolorallocate($this->img, 0, 0, 0);
        imagefilledrectangle($this->img, 0, 0, $imgWidth - 1, $imgHeight - 1, $white);
        
        //break lines
        $splitText = explode ("\n" , $text);
        $lines = count($splitText);
        
        foreach ($splitText as $txt) {
            $textBox = imagettfbbox($fontSize,$angle,$font,$txt);
            $textWidth = abs(max($textBox[2], $textBox[4]));
            $textHeight = abs(max($textBox[5], $textBox[7]));
            $x = (imagesx($this->img) - $textWidth)/2;
            $y = ((imagesy($this->img) + $textHeight)/2)-($lines-2)*$textHeight;
            $lines = $lines-1;
        
            //add some shadow to the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $grey, $font, $txt);
            
            //add the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $black, $font, $txt);
        }
		return true;
    }
    
    function createLineImage($text, $fontSize = 20) {

        //text font path
        $font = 'fonts/'.$this->fontName;
        
        //image size
        $imgWidth = 0;
        $imgHeight = 0;
        
        //break lines
        $splitText = explode ("\n" , $text);
        $lines = count($splitText);
        
        foreach ($splitText as $txt) {
            $textBox = imagettfbbox($fontSize, $angle, $font, $txt);
            $textWidth = abs(max($textBox[2], $textBox[4]));
            $textHeight = abs(max($textBox[5], $textBox[7]));
            $imgWidth = max($imgWidth, $textWidth);
            $imgHeight += $textHeight;
        }
        
        $padding = 10;
        $lineSpace = 8;
        
        $imgWidth = $imgWidth + $padding*2;
        $imgHeight = $imgHeight + $lineSpace*($lines-1) + $padding*2;
        
        //calculate image size to display in line app properly
        if ($imgHeight < $imgWidth / 2.5) {
	        $imgHeight = $imgWidth / 2.5;
        }
        
        //create the image
        $this->img = imagecreatetruecolor($imgWidth, $imgHeight);
        
        //create some colors
        $white = imagecolorallocate($this->img, 255, 255, 255);
        $grey = imagecolorallocate($this->img, 128, 128, 128);
        $bgColor = imagecolorallocate($this->img, $this->lineBgColor->r, $this->lineBgColor->g, $this->lineBgColor->b);
        $textColor = imagecolorallocate($this->img, $this->lineTextColor->r, $this->lineTextColor->g, $this->lineTextColor->b);
        imagefilledrectangle($this->img, 0, 0, $imgWidth - 1, $imgHeight - 1, $bgColor);
        
        $textTop = $padding;
        
        foreach ($splitText as $txt) {
            $textBox = imagettfbbox($fontSize, $angle, $font, $txt);
            $textHeight = abs(max($textBox[5], $textBox[7]));
            $x = $padding;
			$y = $textTop + $textHeight;
			$textTop += $textHeight + $lineSpace;
			
            //add some shadow to the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $grey, $font, $txt);
            
            //add the text
            imagettftext($this->img, $fontSize, $angle, $x, $y, $textColor, $font, $txt);
        }
		return true;
    }
    
    /**
     * Display image
     */
    function showImage() {
        header('Content-Type: image/png');
        return imagepng($this->img);
    }
    
    /**
     * Save image as png format
     * @param string file name to save
     * @param string location to save image file
     */
    function saveAsPng($fileName = 'text-image', $location = '') {
        $fileName = $fileName.".png";
        $fileName = !empty($location) ? $location.$fileName : $fileName;
        return imagepng($this->img, $fileName);
    }
    
    /**
     * Save image as jpg format
     * @param string file name to save
     * @param string location to save image file
     */
    function saveAsJpg($fileName = 'text-image', $location = '') {
        $fileName = $fileName.".jpg";
        $fileName = !empty($location) ? $location.$fileName : $fileName;
        return imagejpeg($this->img, $fileName);
    }
    
    function getImage() {
	    return $this->img;
    }
}

class RGBColor {
	public $r;
	public $g;
	public $b;
	
	function __construct($red, $green, $blue) {
		$this->r = $red;
		$this->g = $green;
		$this->b = $blue;
	}
}