<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Sitelinks;
use YandexDirectSDK\Components\Model;

/** 
 * Class Sitelink 
 * 
 * @property     string      $title
 * @property     string      $href
 * @property     string      $description
 * @property     integer     $turboPageId
 *                           
 * @method       $this       setTitle(string $title)
 * @method       string      getTitle()
 * @method       $this       setHref(string $href)
 * @method       string      getHref()
 * @method       $this       setDescription(string $description)
 * @method       string      getDescription()
 * @method       $this       setTurboPageId(integer $turboPageId)
 * @method       integer     getTurboPageId()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Sitelink extends Model 
{
    protected static $compatibleCollection = Sitelinks::class;

    protected static $properties = [
        'title' => 'string',
        'href' => 'string',
        'description' => 'string',
        'turboPageId' => 'integer'
    ];
}