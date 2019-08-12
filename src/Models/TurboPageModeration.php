<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Components\Model;

/** 
 * Class TurboPageModeration 
 * 
 * @property-read     string     $status
 * @property-read     string     $statusClarification
 *                               
 * @method            string     getStatus()
 * @method            string     getStatusClarification()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class TurboPageModeration extends Model 
{
    const ACCEPTED = 'ACCEPTED';
    const DRAFT = 'DRAFT';
    const MODERATION = 'MODERATION';
    const REJECTED = 'REJECTED';
    const UNKNOWN = 'UNKNOWN';

    protected static $properties = [
        'status' => 'enum:' . self::ACCEPTED . ',' . self::DRAFT . ',' . self::MODERATION . ',' . self::REJECTED . ',' . self::UNKNOWN,
        'statusClarification' => 'string:'
    ];

    protected static $nonWritableProperties = [
        'status',
        'statusClarification'
    ];
}