<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class MapPoint 
 * 
 * @property     double     $x
 * @property     double     $y
 * @property     double     $x1
 * @property     double     $y1
 * @property     double     $x2
 * @property     double     $y2
 *                          
 * @method       $this      setX(double $x)
 * @method       double     getX()
 * @method       $this      setY(double $y)
 * @method       double     getY()
 * @method       $this      setX1(double $x1)
 * @method       double     getX1()
 * @method       $this      setY1(double $y1)
 * @method       double     getY1()
 * @method       $this      setX2(double $x2)
 * @method       double     getX2()
 * @method       $this      setY2(double $y2)
 * @method       double     getY2()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class MapPoint extends Model 
{ 
    protected static $properties = [
        'x' => 'double',
        'y' => 'double',
        'x1' => 'double',
        'y1' => 'double',
        'x2' => 'double',
        'y2' => 'double'
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