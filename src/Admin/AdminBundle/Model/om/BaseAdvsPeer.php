<?php

namespace Admin\AdminBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\AdCategoriesPeer;
use Admin\AdminBundle\Model\AdvCommentsPeer;
use Admin\AdminBundle\Model\AdvComplainePeer;
use Admin\AdminBundle\Model\AdvImagesPeer;
use Admin\AdminBundle\Model\AdvPacketsPeer;
use Admin\AdminBundle\Model\AdvParamsPeer;
use Admin\AdminBundle\Model\AdvPricePeer;
use Admin\AdminBundle\Model\AdvVideosPeer;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsModerStatPeer;
use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\AdvsStatPeer;
use Admin\AdminBundle\Model\AreasPeer;
use Admin\AdminBundle\Model\RegionsPeer;
use Admin\AdminBundle\Model\ShopsPeer;
use Admin\AdminBundle\Model\UserFavoritePeer;
use Admin\AdminBundle\Model\map\AdvsTableMap;
use FOS\UserBundle\Propel\UserPeer;

abstract class BaseAdvsPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'advs';

    /** the related Propel class for this table */
    const OM_CLASS = 'Admin\\AdminBundle\\Model\\Advs';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Admin\\AdminBundle\\Model\\map\\AdvsTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 49;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 49;

    /** the column name for the id field */
    const ID = 'advs.id';

    /** the column name for the category_id field */
    const CATEGORY_ID = 'advs.category_id';

    /** the column name for the user_id field */
    const USER_ID = 'advs.user_id';

    /** the column name for the user_type field */
    const USER_TYPE = 'advs.user_type';

    /** the column name for the company_name field */
    const COMPANY_NAME = 'advs.company_name';

    /** the column name for the phone field */
    const PHONE = 'advs.phone';

    /** the column name for the name field */
    const NAME = 'advs.name';

    /** the column name for the alias field */
    const ALIAS = 'advs.alias';

    /** the column name for the description field */
    const DESCRIPTION = 'advs.description';

    /** the column name for the price field */
    const PRICE = 'advs.price';

    /** the column name for the dogovor field */
    const DOGOVOR = 'advs.dogovor';

    /** the column name for the torg field */
    const TORG = 'advs.torg';

    /** the column name for the region_id field */
    const REGION_ID = 'advs.region_id';

    /** the column name for the area_id field */
    const AREA_ID = 'advs.area_id';

    /** the column name for the shop_id field */
    const SHOP_ID = 'advs.shop_id';

    /** the column name for the cnt field */
    const CNT = 'advs.cnt';

    /** the column name for the cnt_today field */
    const CNT_TODAY = 'advs.cnt_today';

    /** the column name for the cnt_tel field */
    const CNT_TEL = 'advs.cnt_tel';

    /** the column name for the cnt_tel_today field */
    const CNT_TEL_TODAY = 'advs.cnt_tel_today';

    /** the column name for the cnt_skype field */
    const CNT_SKYPE = 'advs.cnt_skype';

    /** the column name for the cnt_site field */
    const CNT_SITE = 'advs.cnt_site';

    /** the column name for the coord field */
    const COORD = 'advs.coord';

    /** the column name for the site field */
    const SITE = 'advs.site';

    /** the column name for the skype field */
    const SKYPE = 'advs.skype';

    /** the column name for the youtube field */
    const YOUTUBE = 'advs.youtube';

    /** the column name for the digest field */
    const DIGEST = 'advs.digest';

    /** the column name for the moder_approved field */
    const MODER_APPROVED = 'advs.moder_approved';

    /** the column name for the enabled field */
    const ENABLED = 'advs.enabled';

    /** the column name for the deleted field */
    const DELETED = 'advs.deleted';

    /** the column name for the twitter field */
    const TWITTER = 'advs.twitter';

    /** the column name for the facebook field */
    const FACEBOOK = 'advs.facebook';

    /** the column name for the vk field */
    const VK = 'advs.vk';

    /** the column name for the vk_share field */
    const VK_SHARE = 'advs.vk_share';

    /** the column name for the google field */
    const GOOGLE = 'advs.google';

    /** the column name for the mailru field */
    const MAILRU = 'advs.mailru';

    /** the column name for the odnoklassniki field */
    const ODNOKLASSNIKI = 'advs.odnoklassniki';

    /** the column name for the yandex_partner field */
    const YANDEX_PARTNER = 'advs.yandex_partner';

    /** the column name for the up_date field */
    const UP_DATE = 'advs.up_date';

    /** the column name for the hl_date field */
    const HL_DATE = 'advs.hl_date';

    /** the column name for the social_date field */
    const SOCIAL_DATE = 'advs.social_date';

    /** the column name for the yandex_date field */
    const YANDEX_DATE = 'advs.yandex_date';

    /** the column name for the yandex_index_date field */
    const YANDEX_INDEX_DATE = 'advs.yandex_index_date';

    /** the column name for the yandex_ping field */
    const YANDEX_PING = 'advs.yandex_ping';

    /** the column name for the google_date field */
    const GOOGLE_DATE = 'advs.google_date';

    /** the column name for the google_index_date field */
    const GOOGLE_INDEX_DATE = 'advs.google_index_date';

    /** the column name for the create_date field */
    const CREATE_DATE = 'advs.create_date';

    /** the column name for the publish_date field */
    const PUBLISH_DATE = 'advs.publish_date';

    /** the column name for the publish_before_date field */
    const PUBLISH_BEFORE_DATE = 'advs.publish_before_date';

    /** the column name for the last_view_date field */
    const LAST_VIEW_DATE = 'advs.last_view_date';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Advs objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Advs[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AdvsPeer::$fieldNames[AdvsPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'CategoryId', 'UserId', 'UserType', 'CompanyName', 'Phone', 'Name', 'Alias', 'Description', 'Price', 'Dogovor', 'Torg', 'RegionId', 'AreaId', 'ShopId', 'Cnt', 'CntToday', 'CntTel', 'CntTelToday', 'CntSkype', 'CntSite', 'Coord', 'Site', 'Skype', 'Youtube', 'Digest', 'ModerApproved', 'Enabled', 'Deleted', 'Twitter', 'Facebook', 'Vk', 'VkShare', 'Google', 'Mailru', 'Odnoklassniki', 'YandexPartner', 'UpDate', 'HlDate', 'SocialDate', 'YandexDate', 'YandexIndexDate', 'YandexPing', 'GoogleDate', 'GoogleIndexDate', 'CreateDate', 'PublishDate', 'PublishBeforeDate', 'LastViewDate', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'categoryId', 'userId', 'userType', 'companyName', 'phone', 'name', 'alias', 'description', 'price', 'dogovor', 'torg', 'regionId', 'areaId', 'shopId', 'cnt', 'cntToday', 'cntTel', 'cntTelToday', 'cntSkype', 'cntSite', 'coord', 'site', 'skype', 'youtube', 'digest', 'moderApproved', 'enabled', 'deleted', 'twitter', 'facebook', 'vk', 'vkShare', 'google', 'mailru', 'odnoklassniki', 'yandexPartner', 'upDate', 'hlDate', 'socialDate', 'yandexDate', 'yandexIndexDate', 'yandexPing', 'googleDate', 'googleIndexDate', 'createDate', 'publishDate', 'publishBeforeDate', 'lastViewDate', ),
        BasePeer::TYPE_COLNAME => array (AdvsPeer::ID, AdvsPeer::CATEGORY_ID, AdvsPeer::USER_ID, AdvsPeer::USER_TYPE, AdvsPeer::COMPANY_NAME, AdvsPeer::PHONE, AdvsPeer::NAME, AdvsPeer::ALIAS, AdvsPeer::DESCRIPTION, AdvsPeer::PRICE, AdvsPeer::DOGOVOR, AdvsPeer::TORG, AdvsPeer::REGION_ID, AdvsPeer::AREA_ID, AdvsPeer::SHOP_ID, AdvsPeer::CNT, AdvsPeer::CNT_TODAY, AdvsPeer::CNT_TEL, AdvsPeer::CNT_TEL_TODAY, AdvsPeer::CNT_SKYPE, AdvsPeer::CNT_SITE, AdvsPeer::COORD, AdvsPeer::SITE, AdvsPeer::SKYPE, AdvsPeer::YOUTUBE, AdvsPeer::DIGEST, AdvsPeer::MODER_APPROVED, AdvsPeer::ENABLED, AdvsPeer::DELETED, AdvsPeer::TWITTER, AdvsPeer::FACEBOOK, AdvsPeer::VK, AdvsPeer::VK_SHARE, AdvsPeer::GOOGLE, AdvsPeer::MAILRU, AdvsPeer::ODNOKLASSNIKI, AdvsPeer::YANDEX_PARTNER, AdvsPeer::UP_DATE, AdvsPeer::HL_DATE, AdvsPeer::SOCIAL_DATE, AdvsPeer::YANDEX_DATE, AdvsPeer::YANDEX_INDEX_DATE, AdvsPeer::YANDEX_PING, AdvsPeer::GOOGLE_DATE, AdvsPeer::GOOGLE_INDEX_DATE, AdvsPeer::CREATE_DATE, AdvsPeer::PUBLISH_DATE, AdvsPeer::PUBLISH_BEFORE_DATE, AdvsPeer::LAST_VIEW_DATE, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'CATEGORY_ID', 'USER_ID', 'USER_TYPE', 'COMPANY_NAME', 'PHONE', 'NAME', 'ALIAS', 'DESCRIPTION', 'PRICE', 'DOGOVOR', 'TORG', 'REGION_ID', 'AREA_ID', 'SHOP_ID', 'CNT', 'CNT_TODAY', 'CNT_TEL', 'CNT_TEL_TODAY', 'CNT_SKYPE', 'CNT_SITE', 'COORD', 'SITE', 'SKYPE', 'YOUTUBE', 'DIGEST', 'MODER_APPROVED', 'ENABLED', 'DELETED', 'TWITTER', 'FACEBOOK', 'VK', 'VK_SHARE', 'GOOGLE', 'MAILRU', 'ODNOKLASSNIKI', 'YANDEX_PARTNER', 'UP_DATE', 'HL_DATE', 'SOCIAL_DATE', 'YANDEX_DATE', 'YANDEX_INDEX_DATE', 'YANDEX_PING', 'GOOGLE_DATE', 'GOOGLE_INDEX_DATE', 'CREATE_DATE', 'PUBLISH_DATE', 'PUBLISH_BEFORE_DATE', 'LAST_VIEW_DATE', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'category_id', 'user_id', 'user_type', 'company_name', 'phone', 'name', 'alias', 'description', 'price', 'dogovor', 'torg', 'region_id', 'area_id', 'shop_id', 'cnt', 'cnt_today', 'cnt_tel', 'cnt_tel_today', 'cnt_skype', 'cnt_site', 'coord', 'site', 'skype', 'youtube', 'digest', 'moder_approved', 'enabled', 'deleted', 'twitter', 'facebook', 'vk', 'vk_share', 'google', 'mailru', 'odnoklassniki', 'yandex_partner', 'up_date', 'hl_date', 'social_date', 'yandex_date', 'yandex_index_date', 'yandex_ping', 'google_date', 'google_index_date', 'create_date', 'publish_date', 'publish_before_date', 'last_view_date', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AdvsPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CategoryId' => 1, 'UserId' => 2, 'UserType' => 3, 'CompanyName' => 4, 'Phone' => 5, 'Name' => 6, 'Alias' => 7, 'Description' => 8, 'Price' => 9, 'Dogovor' => 10, 'Torg' => 11, 'RegionId' => 12, 'AreaId' => 13, 'ShopId' => 14, 'Cnt' => 15, 'CntToday' => 16, 'CntTel' => 17, 'CntTelToday' => 18, 'CntSkype' => 19, 'CntSite' => 20, 'Coord' => 21, 'Site' => 22, 'Skype' => 23, 'Youtube' => 24, 'Digest' => 25, 'ModerApproved' => 26, 'Enabled' => 27, 'Deleted' => 28, 'Twitter' => 29, 'Facebook' => 30, 'Vk' => 31, 'VkShare' => 32, 'Google' => 33, 'Mailru' => 34, 'Odnoklassniki' => 35, 'YandexPartner' => 36, 'UpDate' => 37, 'HlDate' => 38, 'SocialDate' => 39, 'YandexDate' => 40, 'YandexIndexDate' => 41, 'YandexPing' => 42, 'GoogleDate' => 43, 'GoogleIndexDate' => 44, 'CreateDate' => 45, 'PublishDate' => 46, 'PublishBeforeDate' => 47, 'LastViewDate' => 48, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'categoryId' => 1, 'userId' => 2, 'userType' => 3, 'companyName' => 4, 'phone' => 5, 'name' => 6, 'alias' => 7, 'description' => 8, 'price' => 9, 'dogovor' => 10, 'torg' => 11, 'regionId' => 12, 'areaId' => 13, 'shopId' => 14, 'cnt' => 15, 'cntToday' => 16, 'cntTel' => 17, 'cntTelToday' => 18, 'cntSkype' => 19, 'cntSite' => 20, 'coord' => 21, 'site' => 22, 'skype' => 23, 'youtube' => 24, 'digest' => 25, 'moderApproved' => 26, 'enabled' => 27, 'deleted' => 28, 'twitter' => 29, 'facebook' => 30, 'vk' => 31, 'vkShare' => 32, 'google' => 33, 'mailru' => 34, 'odnoklassniki' => 35, 'yandexPartner' => 36, 'upDate' => 37, 'hlDate' => 38, 'socialDate' => 39, 'yandexDate' => 40, 'yandexIndexDate' => 41, 'yandexPing' => 42, 'googleDate' => 43, 'googleIndexDate' => 44, 'createDate' => 45, 'publishDate' => 46, 'publishBeforeDate' => 47, 'lastViewDate' => 48, ),
        BasePeer::TYPE_COLNAME => array (AdvsPeer::ID => 0, AdvsPeer::CATEGORY_ID => 1, AdvsPeer::USER_ID => 2, AdvsPeer::USER_TYPE => 3, AdvsPeer::COMPANY_NAME => 4, AdvsPeer::PHONE => 5, AdvsPeer::NAME => 6, AdvsPeer::ALIAS => 7, AdvsPeer::DESCRIPTION => 8, AdvsPeer::PRICE => 9, AdvsPeer::DOGOVOR => 10, AdvsPeer::TORG => 11, AdvsPeer::REGION_ID => 12, AdvsPeer::AREA_ID => 13, AdvsPeer::SHOP_ID => 14, AdvsPeer::CNT => 15, AdvsPeer::CNT_TODAY => 16, AdvsPeer::CNT_TEL => 17, AdvsPeer::CNT_TEL_TODAY => 18, AdvsPeer::CNT_SKYPE => 19, AdvsPeer::CNT_SITE => 20, AdvsPeer::COORD => 21, AdvsPeer::SITE => 22, AdvsPeer::SKYPE => 23, AdvsPeer::YOUTUBE => 24, AdvsPeer::DIGEST => 25, AdvsPeer::MODER_APPROVED => 26, AdvsPeer::ENABLED => 27, AdvsPeer::DELETED => 28, AdvsPeer::TWITTER => 29, AdvsPeer::FACEBOOK => 30, AdvsPeer::VK => 31, AdvsPeer::VK_SHARE => 32, AdvsPeer::GOOGLE => 33, AdvsPeer::MAILRU => 34, AdvsPeer::ODNOKLASSNIKI => 35, AdvsPeer::YANDEX_PARTNER => 36, AdvsPeer::UP_DATE => 37, AdvsPeer::HL_DATE => 38, AdvsPeer::SOCIAL_DATE => 39, AdvsPeer::YANDEX_DATE => 40, AdvsPeer::YANDEX_INDEX_DATE => 41, AdvsPeer::YANDEX_PING => 42, AdvsPeer::GOOGLE_DATE => 43, AdvsPeer::GOOGLE_INDEX_DATE => 44, AdvsPeer::CREATE_DATE => 45, AdvsPeer::PUBLISH_DATE => 46, AdvsPeer::PUBLISH_BEFORE_DATE => 47, AdvsPeer::LAST_VIEW_DATE => 48, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'CATEGORY_ID' => 1, 'USER_ID' => 2, 'USER_TYPE' => 3, 'COMPANY_NAME' => 4, 'PHONE' => 5, 'NAME' => 6, 'ALIAS' => 7, 'DESCRIPTION' => 8, 'PRICE' => 9, 'DOGOVOR' => 10, 'TORG' => 11, 'REGION_ID' => 12, 'AREA_ID' => 13, 'SHOP_ID' => 14, 'CNT' => 15, 'CNT_TODAY' => 16, 'CNT_TEL' => 17, 'CNT_TEL_TODAY' => 18, 'CNT_SKYPE' => 19, 'CNT_SITE' => 20, 'COORD' => 21, 'SITE' => 22, 'SKYPE' => 23, 'YOUTUBE' => 24, 'DIGEST' => 25, 'MODER_APPROVED' => 26, 'ENABLED' => 27, 'DELETED' => 28, 'TWITTER' => 29, 'FACEBOOK' => 30, 'VK' => 31, 'VK_SHARE' => 32, 'GOOGLE' => 33, 'MAILRU' => 34, 'ODNOKLASSNIKI' => 35, 'YANDEX_PARTNER' => 36, 'UP_DATE' => 37, 'HL_DATE' => 38, 'SOCIAL_DATE' => 39, 'YANDEX_DATE' => 40, 'YANDEX_INDEX_DATE' => 41, 'YANDEX_PING' => 42, 'GOOGLE_DATE' => 43, 'GOOGLE_INDEX_DATE' => 44, 'CREATE_DATE' => 45, 'PUBLISH_DATE' => 46, 'PUBLISH_BEFORE_DATE' => 47, 'LAST_VIEW_DATE' => 48, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'category_id' => 1, 'user_id' => 2, 'user_type' => 3, 'company_name' => 4, 'phone' => 5, 'name' => 6, 'alias' => 7, 'description' => 8, 'price' => 9, 'dogovor' => 10, 'torg' => 11, 'region_id' => 12, 'area_id' => 13, 'shop_id' => 14, 'cnt' => 15, 'cnt_today' => 16, 'cnt_tel' => 17, 'cnt_tel_today' => 18, 'cnt_skype' => 19, 'cnt_site' => 20, 'coord' => 21, 'site' => 22, 'skype' => 23, 'youtube' => 24, 'digest' => 25, 'moder_approved' => 26, 'enabled' => 27, 'deleted' => 28, 'twitter' => 29, 'facebook' => 30, 'vk' => 31, 'vk_share' => 32, 'google' => 33, 'mailru' => 34, 'odnoklassniki' => 35, 'yandex_partner' => 36, 'up_date' => 37, 'hl_date' => 38, 'social_date' => 39, 'yandex_date' => 40, 'yandex_index_date' => 41, 'yandex_ping' => 42, 'google_date' => 43, 'google_index_date' => 44, 'create_date' => 45, 'publish_date' => 46, 'publish_before_date' => 47, 'last_view_date' => 48, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = AdvsPeer::getFieldNames($toType);
        $key = isset(AdvsPeer::$fieldKeys[$fromType][$name]) ? AdvsPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AdvsPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, AdvsPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AdvsPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. AdvsPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AdvsPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AdvsPeer::ID);
            $criteria->addSelectColumn(AdvsPeer::CATEGORY_ID);
            $criteria->addSelectColumn(AdvsPeer::USER_ID);
            $criteria->addSelectColumn(AdvsPeer::USER_TYPE);
            $criteria->addSelectColumn(AdvsPeer::COMPANY_NAME);
            $criteria->addSelectColumn(AdvsPeer::PHONE);
            $criteria->addSelectColumn(AdvsPeer::NAME);
            $criteria->addSelectColumn(AdvsPeer::ALIAS);
            $criteria->addSelectColumn(AdvsPeer::DESCRIPTION);
            $criteria->addSelectColumn(AdvsPeer::PRICE);
            $criteria->addSelectColumn(AdvsPeer::DOGOVOR);
            $criteria->addSelectColumn(AdvsPeer::TORG);
            $criteria->addSelectColumn(AdvsPeer::REGION_ID);
            $criteria->addSelectColumn(AdvsPeer::AREA_ID);
            $criteria->addSelectColumn(AdvsPeer::SHOP_ID);
            $criteria->addSelectColumn(AdvsPeer::CNT);
            $criteria->addSelectColumn(AdvsPeer::CNT_TODAY);
            $criteria->addSelectColumn(AdvsPeer::CNT_TEL);
            $criteria->addSelectColumn(AdvsPeer::CNT_TEL_TODAY);
            $criteria->addSelectColumn(AdvsPeer::CNT_SKYPE);
            $criteria->addSelectColumn(AdvsPeer::CNT_SITE);
            $criteria->addSelectColumn(AdvsPeer::COORD);
            $criteria->addSelectColumn(AdvsPeer::SITE);
            $criteria->addSelectColumn(AdvsPeer::SKYPE);
            $criteria->addSelectColumn(AdvsPeer::YOUTUBE);
            $criteria->addSelectColumn(AdvsPeer::DIGEST);
            $criteria->addSelectColumn(AdvsPeer::MODER_APPROVED);
            $criteria->addSelectColumn(AdvsPeer::ENABLED);
            $criteria->addSelectColumn(AdvsPeer::DELETED);
            $criteria->addSelectColumn(AdvsPeer::TWITTER);
            $criteria->addSelectColumn(AdvsPeer::FACEBOOK);
            $criteria->addSelectColumn(AdvsPeer::VK);
            $criteria->addSelectColumn(AdvsPeer::VK_SHARE);
            $criteria->addSelectColumn(AdvsPeer::GOOGLE);
            $criteria->addSelectColumn(AdvsPeer::MAILRU);
            $criteria->addSelectColumn(AdvsPeer::ODNOKLASSNIKI);
            $criteria->addSelectColumn(AdvsPeer::YANDEX_PARTNER);
            $criteria->addSelectColumn(AdvsPeer::UP_DATE);
            $criteria->addSelectColumn(AdvsPeer::HL_DATE);
            $criteria->addSelectColumn(AdvsPeer::SOCIAL_DATE);
            $criteria->addSelectColumn(AdvsPeer::YANDEX_DATE);
            $criteria->addSelectColumn(AdvsPeer::YANDEX_INDEX_DATE);
            $criteria->addSelectColumn(AdvsPeer::YANDEX_PING);
            $criteria->addSelectColumn(AdvsPeer::GOOGLE_DATE);
            $criteria->addSelectColumn(AdvsPeer::GOOGLE_INDEX_DATE);
            $criteria->addSelectColumn(AdvsPeer::CREATE_DATE);
            $criteria->addSelectColumn(AdvsPeer::PUBLISH_DATE);
            $criteria->addSelectColumn(AdvsPeer::PUBLISH_BEFORE_DATE);
            $criteria->addSelectColumn(AdvsPeer::LAST_VIEW_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.user_type');
            $criteria->addSelectColumn($alias . '.company_name');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.alias');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.dogovor');
            $criteria->addSelectColumn($alias . '.torg');
            $criteria->addSelectColumn($alias . '.region_id');
            $criteria->addSelectColumn($alias . '.area_id');
            $criteria->addSelectColumn($alias . '.shop_id');
            $criteria->addSelectColumn($alias . '.cnt');
            $criteria->addSelectColumn($alias . '.cnt_today');
            $criteria->addSelectColumn($alias . '.cnt_tel');
            $criteria->addSelectColumn($alias . '.cnt_tel_today');
            $criteria->addSelectColumn($alias . '.cnt_skype');
            $criteria->addSelectColumn($alias . '.cnt_site');
            $criteria->addSelectColumn($alias . '.coord');
            $criteria->addSelectColumn($alias . '.site');
            $criteria->addSelectColumn($alias . '.skype');
            $criteria->addSelectColumn($alias . '.youtube');
            $criteria->addSelectColumn($alias . '.digest');
            $criteria->addSelectColumn($alias . '.moder_approved');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.deleted');
            $criteria->addSelectColumn($alias . '.twitter');
            $criteria->addSelectColumn($alias . '.facebook');
            $criteria->addSelectColumn($alias . '.vk');
            $criteria->addSelectColumn($alias . '.vk_share');
            $criteria->addSelectColumn($alias . '.google');
            $criteria->addSelectColumn($alias . '.mailru');
            $criteria->addSelectColumn($alias . '.odnoklassniki');
            $criteria->addSelectColumn($alias . '.yandex_partner');
            $criteria->addSelectColumn($alias . '.up_date');
            $criteria->addSelectColumn($alias . '.hl_date');
            $criteria->addSelectColumn($alias . '.social_date');
            $criteria->addSelectColumn($alias . '.yandex_date');
            $criteria->addSelectColumn($alias . '.yandex_index_date');
            $criteria->addSelectColumn($alias . '.yandex_ping');
            $criteria->addSelectColumn($alias . '.google_date');
            $criteria->addSelectColumn($alias . '.google_index_date');
            $criteria->addSelectColumn($alias . '.create_date');
            $criteria->addSelectColumn($alias . '.publish_date');
            $criteria->addSelectColumn($alias . '.publish_before_date');
            $criteria->addSelectColumn($alias . '.last_view_date');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AdvsPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return Advs
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AdvsPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return AdvsPeer::populateObjects(AdvsPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AdvsPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param Advs $obj A Advs object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            AdvsPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Advs object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Advs) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Advs object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AdvsPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Advs Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AdvsPeer::$instances[$key])) {
                return AdvsPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (AdvsPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        AdvsPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to advs
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in AdvPricePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvPricePeer::clearInstancePool();
        // Invalidate objects in AdvsStatPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvsStatPeer::clearInstancePool();
        // Invalidate objects in AdvsModerStatPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvsModerStatPeer::clearInstancePool();
        // Invalidate objects in AdvParamsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvParamsPeer::clearInstancePool();
        // Invalidate objects in AdvImagesPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvImagesPeer::clearInstancePool();
        // Invalidate objects in AdvVideosPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvVideosPeer::clearInstancePool();
        // Invalidate objects in AdvPacketsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvPacketsPeer::clearInstancePool();
        // Invalidate objects in AdvCommentsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvCommentsPeer::clearInstancePool();
        // Invalidate objects in AdvComplainePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvComplainePeer::clearInstancePool();
        // Invalidate objects in UserFavoritePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        UserFavoritePeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = AdvsPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AdvsPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdvsPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Advs object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AdvsPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AdvsPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AdvsPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdvsPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AdvsPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Regions table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinRegions(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Areas table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAreas(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related User table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Shops table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinShops(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AdCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAdCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Advs objects pre-filled with their Regions objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRegions(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol = AdvsPeer::NUM_HYDRATE_COLUMNS;
        RegionsPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = RegionsPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Advs) to $obj2 (Regions)
                $obj2->addAdvs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with their Areas objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAreas(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol = AdvsPeer::NUM_HYDRATE_COLUMNS;
        AreasPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AreasPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AreasPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AreasPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Advs) to $obj2 (Areas)
                $obj2->addAdvs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol = AdvsPeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Advs) to $obj2 (User)
                $obj2->addAdvs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with their Shops objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinShops(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol = AdvsPeer::NUM_HYDRATE_COLUMNS;
        ShopsPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ShopsPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ShopsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ShopsPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Advs) to $obj2 (Shops)
                $obj2->addAdvs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with their AdCategories objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAdCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol = AdvsPeer::NUM_HYDRATE_COLUMNS;
        AdCategoriesPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AdCategoriesPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AdCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AdCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Advs) to $obj2 (AdCategories)
                $obj2->addAdvs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Advs objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol2 = AdvsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AreasPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Regions rows

            $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = RegionsPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Advs) to the collection in $obj2 (Regions)
                $obj2->addAdvs($obj1);
            } // if joined row not null

            // Add objects for joined Areas rows

            $key3 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AreasPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AreasPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AreasPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Advs) to the collection in $obj3 (Areas)
                $obj3->addAdvs($obj1);
            } // if joined row not null

            // Add objects for joined User rows

            $key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = UserPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = UserPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    UserPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Advs) to the collection in $obj4 (User)
                $obj4->addAdvs($obj1);
            } // if joined row not null

            // Add objects for joined Shops rows

            $key5 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = ShopsPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = ShopsPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    ShopsPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (Advs) to the collection in $obj5 (Shops)
                $obj5->addAdvs($obj1);
            } // if joined row not null

            // Add objects for joined AdCategories rows

            $key6 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol6);
            if ($key6 !== null) {
                $obj6 = AdCategoriesPeer::getInstanceFromPool($key6);
                if (!$obj6) {

                    $cls = AdCategoriesPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    AdCategoriesPeer::addInstanceToPool($obj6, $key6);
                } // if obj6 loaded

                // Add the $obj1 (Advs) to the collection in $obj6 (AdCategories)
                $obj6->addAdvs($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Regions table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptRegions(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Areas table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAreas(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related User table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Shops table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptShops(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AdCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAdCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdvsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Advs objects pre-filled with all related objects except Regions.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptRegions(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol2 = AdvsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AreasPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Areas rows

                $key2 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AreasPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AreasPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AreasPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Advs) to the collection in $obj2 (Areas)
                $obj2->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = UserPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Advs) to the collection in $obj3 (User)
                $obj3->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key4 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ShopsPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ShopsPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ShopsPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Advs) to the collection in $obj4 (Shops)
                $obj4->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined AdCategories rows

                $key5 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AdCategoriesPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AdCategoriesPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AdCategoriesPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Advs) to the collection in $obj5 (AdCategories)
                $obj5->addAdvs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with all related objects except Areas.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAreas(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol2 = AdvsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Regions rows

                $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = RegionsPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Advs) to the collection in $obj2 (Regions)
                $obj2->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = UserPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Advs) to the collection in $obj3 (User)
                $obj3->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key4 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ShopsPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ShopsPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ShopsPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Advs) to the collection in $obj4 (Shops)
                $obj4->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined AdCategories rows

                $key5 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AdCategoriesPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AdCategoriesPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AdCategoriesPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Advs) to the collection in $obj5 (AdCategories)
                $obj5->addAdvs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with all related objects except User.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol2 = AdvsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AreasPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Regions rows

                $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = RegionsPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Advs) to the collection in $obj2 (Regions)
                $obj2->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Areas rows

                $key3 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AreasPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AreasPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AreasPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Advs) to the collection in $obj3 (Areas)
                $obj3->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key4 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ShopsPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ShopsPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ShopsPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Advs) to the collection in $obj4 (Shops)
                $obj4->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined AdCategories rows

                $key5 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AdCategoriesPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AdCategoriesPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AdCategoriesPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Advs) to the collection in $obj5 (AdCategories)
                $obj5->addAdvs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with all related objects except Shops.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptShops(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol2 = AdvsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AreasPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Regions rows

                $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = RegionsPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Advs) to the collection in $obj2 (Regions)
                $obj2->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Areas rows

                $key3 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AreasPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AreasPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AreasPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Advs) to the collection in $obj3 (Areas)
                $obj3->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = UserPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = UserPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    UserPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Advs) to the collection in $obj4 (User)
                $obj4->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined AdCategories rows

                $key5 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = AdCategoriesPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = AdCategoriesPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    AdCategoriesPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Advs) to the collection in $obj5 (AdCategories)
                $obj5->addAdvs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Advs objects pre-filled with all related objects except AdCategories.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Advs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAdCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdvsPeer::DATABASE_NAME);
        }

        AdvsPeer::addSelectColumns($criteria);
        $startcol2 = AdvsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AreasPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + UserPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdvsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(AdvsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdvsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdvsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdvsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdvsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Regions rows

                $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = RegionsPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Advs) to the collection in $obj2 (Regions)
                $obj2->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Areas rows

                $key3 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AreasPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AreasPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AreasPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Advs) to the collection in $obj3 (Areas)
                $obj3->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key4 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = UserPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = UserPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    UserPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Advs) to the collection in $obj4 (User)
                $obj4->addAdvs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key5 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = ShopsPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = ShopsPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    ShopsPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Advs) to the collection in $obj5 (Shops)
                $obj5->addAdvs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(AdvsPeer::DATABASE_NAME)->getTable(AdvsPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAdvsPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAdvsPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Admin\AdminBundle\Model\map\AdvsTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return AdvsPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Advs or Criteria object.
     *
     * @param      mixed $values Criteria or Advs object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Advs object
        }

        if ($criteria->containsKey(AdvsPeer::ID) && $criteria->keyContainsValue(AdvsPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AdvsPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Advs or Criteria object.
     *
     * @param      mixed $values Criteria or Advs object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AdvsPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AdvsPeer::ID);
            $value = $criteria->remove(AdvsPeer::ID);
            if ($value) {
                $selectCriteria->add(AdvsPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AdvsPeer::TABLE_NAME);
            }

        } else { // $values is Advs object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the advs table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += AdvsPeer::doOnDeleteCascade(new Criteria(AdvsPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(AdvsPeer::TABLE_NAME, $con, AdvsPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdvsPeer::clearInstancePool();
            AdvsPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Advs or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Advs object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Advs) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdvsPeer::DATABASE_NAME);
            $criteria->add(AdvsPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(AdvsPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += AdvsPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                AdvsPeer::clearInstancePool();
            } elseif ($values instanceof Advs) { // it's a model object
                AdvsPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    AdvsPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AdvsPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Peer classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
    {
        // initialize var to track total num of affected rows
        $affectedRows = 0;

        // first find the objects that are implicated by the $criteria
        $objects = AdvsPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related AdvPrice objects
            $criteria = new Criteria(AdvPricePeer::DATABASE_NAME);

            $criteria->add(AdvPricePeer::ADV_ID, $obj->getId());
            $affectedRows += AdvPricePeer::doDelete($criteria, $con);

            // delete related AdvsStat objects
            $criteria = new Criteria(AdvsStatPeer::DATABASE_NAME);

            $criteria->add(AdvsStatPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvsStatPeer::doDelete($criteria, $con);

            // delete related AdvsModerStat objects
            $criteria = new Criteria(AdvsModerStatPeer::DATABASE_NAME);

            $criteria->add(AdvsModerStatPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvsModerStatPeer::doDelete($criteria, $con);

            // delete related AdvParams objects
            $criteria = new Criteria(AdvParamsPeer::DATABASE_NAME);

            $criteria->add(AdvParamsPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvParamsPeer::doDelete($criteria, $con);

            // delete related AdvImages objects
            $criteria = new Criteria(AdvImagesPeer::DATABASE_NAME);

            $criteria->add(AdvImagesPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvImagesPeer::doDelete($criteria, $con);

            // delete related AdvVideos objects
            $criteria = new Criteria(AdvVideosPeer::DATABASE_NAME);

            $criteria->add(AdvVideosPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvVideosPeer::doDelete($criteria, $con);

            // delete related AdvPackets objects
            $criteria = new Criteria(AdvPacketsPeer::DATABASE_NAME);

            $criteria->add(AdvPacketsPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvPacketsPeer::doDelete($criteria, $con);

            // delete related AdvComments objects
            $criteria = new Criteria(AdvCommentsPeer::DATABASE_NAME);

            $criteria->add(AdvCommentsPeer::ADV_ID, $obj->getId());
            $affectedRows += AdvCommentsPeer::doDelete($criteria, $con);

            // delete related AdvComplaine objects
            $criteria = new Criteria(AdvComplainePeer::DATABASE_NAME);

            $criteria->add(AdvComplainePeer::ADV_ID, $obj->getId());
            $affectedRows += AdvComplainePeer::doDelete($criteria, $con);

            // delete related UserFavorite objects
            $criteria = new Criteria(UserFavoritePeer::DATABASE_NAME);

            $criteria->add(UserFavoritePeer::ADV_ID, $obj->getId());
            $affectedRows += UserFavoritePeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given Advs object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Advs $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AdvsPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AdvsPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(AdvsPeer::DATABASE_NAME, AdvsPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Advs
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AdvsPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AdvsPeer::DATABASE_NAME);
        $criteria->add(AdvsPeer::ID, $pk);

        $v = AdvsPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Advs[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AdvsPeer::DATABASE_NAME);
            $criteria->add(AdvsPeer::ID, $pks, Criteria::IN);
            $objs = AdvsPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAdvsPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAdvsPeer::buildTableMap();

