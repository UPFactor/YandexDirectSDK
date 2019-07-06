<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\Grands;
use YandexDirectSDK\Components\Model;

/** 
 * Class Grand 
 * 
 * @property            string   $privilege
 * @property            string   $value
 * 
 * @property-readable   string   $agency
 * 
 * @method              $this    setPrivilege(string $privilege)
 * @method              $this    setValue(string $value)
 * 
 * @method              string   getPrivilege()
 * @method              string   getValue()
 * @method              string   getAgency()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class Grand extends Model 
{ 
    const EDIT_CAMPAIGNS = 'EDIT_CAMPAIGNS';
    const IMPORT_XLS = 'IMPORT_XLS';
    const TRANSFER_MONEY = 'TRANSFER_MONEY';
    const YES = 'YES';
    const NO = 'NO';

    protected static $compatibleCollection = Grands::class;

    protected static $properties = [
        'privilege' => 'enum:' . self::EDIT_CAMPAIGNS . ',' . self::IMPORT_XLS . ',' . self::TRANSFER_MONEY,
        'value' => 'enum:' . self::YES . ',' . self::NO,
        'agency' => 'string'
    ];

    protected static $nonWritableProperties = [
        'agency'
    ];

    /**
     * Returns the [Grand] instance
     * with the [EDIT_CAMPAIGNS] privilege set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function editCampaigns($switchOn = true){
        return (new static())
            ->setPrivilege(self::EDIT_CAMPAIGNS)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [Grand] instance
     * with the [IMPORT_XLS] privilege set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function importXls($switchOn = true){
        return (new static())
            ->setPrivilege(self::IMPORT_XLS)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }

    /**
     * Returns the [Grand] instance
     * with the [TRANSFER_MONEY] privilege set.
     *
     * @param bool $switchOn
     * @return static
     */
    public static function transferMoney($switchOn = true){
        return (new static())
            ->setPrivilege(self::TRANSFER_MONEY)
            ->setValue($switchOn === true ? self::YES : self::NO);
    }
}