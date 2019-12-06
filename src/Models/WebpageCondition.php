<?php 
namespace YandexDirectSDK\Models; 

use YandexDirectSDK\Collections\WebpageConditions;
use YandexDirectSDK\Components\Model;

/** 
 * Class WebpageCondition 
 * 
 * @property     string       $operand
 * @property     string       $operator
 * @property     string[]     $arguments
 *                            
 * @method       $this        setOperand(string $operand)
 * @method       string       getOperand()
 * @method       $this        setOperator(string $operator)
 * @method       string       getOperator()
 * @method       $this        setArguments(string[] $arguments)
 * @method       string[]     getArguments()
 * 
 * @package YandexDirectSDK\Models 
 */ 
class WebpageCondition extends Model 
{ 
    const DOMAIN = 'DOMAIN';
    const OFFERS_LIST_URL = 'OFFERS_LIST_URL';
    const PAGE_CONTENT = 'PAGE_CONTENT';
    const PAGE_TITLE = 'PAGE_TITLE';
    const URL = 'URL';

    const EQUALS_ANY = 'EQUALS_ANY';
    const NOT_EQUALS_ALL = 'NOT_EQUALS_ALL';
    const CONTAINS_ANY = 'CONTAINS_ANY';
    const NOT_CONTAINS_ALL = 'NOT_CONTAINS_ALL';

    protected static $compatibleCollection = WebpageConditions::class;

    protected static $properties = [
        'operand' => 'enum:' . self::DOMAIN . ',' . self::OFFERS_LIST_URL . ',' . self::PAGE_CONTENT . ',' . self::PAGE_TITLE . ',' . self::URL,
        'operator' => 'enum:' . self::EQUALS_ANY . ',' . self::NOT_EQUALS_ALL . ',' . self::CONTAINS_ANY . ',' . self::NOT_CONTAINS_ALL,
        'arguments' => 'stack:string'
    ];

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:DOMAIN, operator:CONTAINS_ANY]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function domainContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::DOMAIN)
            ->setOperator(self::CONTAINS_ANY)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:DOMAIN, operator:NOT_CONTAINS_ALL]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function domainNotContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::DOMAIN)
            ->setOperator(self::NOT_CONTAINS_ALL)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:URL, operator:CONTAINS_ANY]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function urlContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::URL)
            ->setOperator(self::CONTAINS_ANY)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:URL, operator:NOT_CONTAINS_ALL]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function urlNotContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::URL)
            ->setOperator(self::NOT_CONTAINS_ALL)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:PAGE_TITLE, operator:CONTAINS_ANY]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function pageTitleContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::PAGE_TITLE)
            ->setOperator(self::CONTAINS_ANY)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:PAGE_TITLE, operator:NOT_CONTAINS_ALL]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function pageTitleNotContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::PAGE_TITLE)
            ->setOperator(self::NOT_CONTAINS_ALL)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:PAGE_CONTENT, operator:CONTAINS_ANY]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function pageContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::PAGE_CONTENT)
            ->setOperator(self::CONTAINS_ANY)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:PAGE_CONTENT, operator:NOT_CONTAINS_ALL]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function pageNotContain(array $arguments)
    {
        return (new static())
            ->setOperand(self::PAGE_CONTENT)
            ->setOperator(self::NOT_CONTAINS_ALL)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:OFFERS_LIST_URL, operator:EQUALS_ANY]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function offersUrlEquals(array $arguments)
    {
        return (new static())
            ->setOperand(self::OFFERS_LIST_URL)
            ->setOperator(self::EQUALS_ANY)
            ->setArguments($arguments);
    }

    /**
     * Returns the [WebpageCondition] instance
     * with the parameters set [operand:OFFERS_LIST_URL, operator:NOT_EQUALS_ALL]
     *
     * @param array $arguments
     * @return WebpageCondition
     */
    public static function offersUrlNotEquals(array $arguments)
    {
        return (new static())
            ->setOperand(self::OFFERS_LIST_URL)
            ->setOperator(self::NOT_EQUALS_ALL)
            ->setArguments($arguments);
    }

}