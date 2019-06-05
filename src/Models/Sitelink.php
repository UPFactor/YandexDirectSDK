<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Sitelinks;
use YandexDirectSDK\Components\Model;

/** 
 * Class Sitelink 
 * 
 * @property          string    $title
 * @property          string    $href
 * @property          string    $description
 * @property          integer   $turboPageId
 * 
 * @method            $this     setTitle(string $title)
 * @method            $this     setHref(string $href)
 * @method            $this     setDescription(string $description)
 * @method            $this     setTurboPageId(integer $turboPageId)
 * 
 * @method            string    getTitle()
 * @method            string    getHref()
 * @method            string    getDescription()
 * @method            integer   getTurboPageId()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Sitelink extends Model 
{
    protected $compatibleCollection = Sitelinks::class;

    protected $properties = [
        'title' => 'string',
        'href' => 'string',
        'description' => 'string',
        'turboPageId' => 'integer'
    ];
}