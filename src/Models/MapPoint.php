<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class MapPoint 
 * 
 * @property   integer   $x 
 * @property   integer   $y 
 * @property   integer   $x1 
 * @property   integer   $y1 
 * @property   integer   $x2 
 * @property   integer   $y2 
 * 
 * @method     $this     setX(integer $x) 
 * @method     $this     setY(integer $y) 
 * @method     $this     setX1(integer $x1) 
 * @method     $this     setY1(integer $y1) 
 * @method     $this     setX2(integer $x2) 
 * @method     $this     setY2(integer $y2) 
 * 
 * @method     integer   getX() 
 * @method     integer   getY() 
 * @method     integer   getX1() 
 * @method     integer   getY1() 
 * @method     integer   getX2() 
 * @method     integer   getY2() 
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MapPoint extends Model 
{ 
    protected $properties = [
        'x' => 'integer',
        'y' => 'integer',
        'x1' => 'integer',
        'y1' => 'integer',
        'x2' => 'integer',
        'y2' => 'integer'
    ];

    /**
     * @param integer $x
     * @param integer $y
     * @return $this
     */
    public function setPoint($x,$y){
        return $this->setX($x)->setY($y);
    }

    /**
     * @param integer $x
     * @param integer $y
     * @return $this
     */
    public function setLLCornerMap($x,$y){
        return $this->setX1($x)->setY1($y);
    }

    /**
     * @param integer $x
     * @param integer $y
     * @return $this
     */
    public function setURCornerMap($x,$y){
        return $this->setX2($x)->setY2($y);
    }
}