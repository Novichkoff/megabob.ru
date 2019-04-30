<?php

namespace Admin\AdminBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvComments;
use Admin\AdminBundle\Model\AdvCommentsQuery;
use Admin\AdminBundle\Model\AdvComplaine;
use Admin\AdminBundle\Model\AdvComplaineQuery;
use Admin\AdminBundle\Model\AdvImages;
use Admin\AdminBundle\Model\AdvImagesQuery;
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\AdvPrice;
use Admin\AdminBundle\Model\AdvPriceQuery;
use Admin\AdminBundle\Model\AdvVideos;
use Admin\AdminBundle\Model\AdvVideosQuery;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsModerStat;
use Admin\AdminBundle\Model\AdvsModerStatQuery;
use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvsStat;
use Admin\AdminBundle\Model\AdvsStatQuery;
use Admin\AdminBundle\Model\Areas;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\Shops;
use Admin\AdminBundle\Model\ShopsQuery;
use Admin\AdminBundle\Model\UserFavorite;
use Admin\AdminBundle\Model\UserFavoriteQuery;
use FOS\UserBundle\Propel\User;
use FOS\UserBundle\Propel\UserQuery;

abstract class BaseAdvs extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AdvsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AdvsPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the category_id field.
     * @var        int
     */
    protected $category_id;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

    /**
     * The value for the user_type field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $user_type;

    /**
     * The value for the company_name field.
     * @var        string
     */
    protected $company_name;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the alias field.
     * @var        string
     */
    protected $alias;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the price field.
     * @var        int
     */
    protected $price;

    /**
     * The value for the dogovor field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $dogovor;

    /**
     * The value for the torg field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $torg;

    /**
     * The value for the region_id field.
     * @var        int
     */
    protected $region_id;

    /**
     * The value for the area_id field.
     * @var        int
     */
    protected $area_id;

    /**
     * The value for the shop_id field.
     * @var        int
     */
    protected $shop_id;

    /**
     * The value for the cnt field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt;

    /**
     * The value for the cnt_today field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt_today;

    /**
     * The value for the cnt_tel field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt_tel;

    /**
     * The value for the cnt_tel_today field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt_tel_today;

    /**
     * The value for the cnt_skype field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt_skype;

    /**
     * The value for the cnt_site field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt_site;

    /**
     * The value for the coord field.
     * @var        string
     */
    protected $coord;

    /**
     * The value for the site field.
     * @var        string
     */
    protected $site;

    /**
     * The value for the skype field.
     * @var        string
     */
    protected $skype;

    /**
     * The value for the youtube field.
     * @var        string
     */
    protected $youtube;

    /**
     * The value for the digest field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $digest;

    /**
     * The value for the moder_approved field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $moder_approved;

    /**
     * The value for the enabled field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $enabled;

    /**
     * The value for the deleted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $deleted;

    /**
     * The value for the twitter field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $twitter;

    /**
     * The value for the facebook field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $facebook;

    /**
     * The value for the vk field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $vk;

    /**
     * The value for the vk_share field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $vk_share;

    /**
     * The value for the google field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $google;

    /**
     * The value for the mailru field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $mailru;

    /**
     * The value for the odnoklassniki field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $odnoklassniki;

    /**
     * The value for the yandex_partner field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $yandex_partner;

    /**
     * The value for the up_date field.
     * @var        string
     */
    protected $up_date;

    /**
     * The value for the hl_date field.
     * @var        string
     */
    protected $hl_date;

    /**
     * The value for the social_date field.
     * @var        string
     */
    protected $social_date;

    /**
     * The value for the yandex_date field.
     * @var        string
     */
    protected $yandex_date;

    /**
     * The value for the yandex_index_date field.
     * @var        string
     */
    protected $yandex_index_date;

    /**
     * The value for the yandex_ping field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $yandex_ping;

    /**
     * The value for the google_date field.
     * @var        string
     */
    protected $google_date;

    /**
     * The value for the google_index_date field.
     * @var        string
     */
    protected $google_index_date;

    /**
     * The value for the create_date field.
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        string
     */
    protected $create_date;

    /**
     * The value for the publish_date field.
     * @var        string
     */
    protected $publish_date;

    /**
     * The value for the publish_before_date field.
     * @var        string
     */
    protected $publish_before_date;

    /**
     * The value for the last_view_date field.
     * @var        string
     */
    protected $last_view_date;

    /**
     * @var        Regions
     */
    protected $aRegions;

    /**
     * @var        Areas
     */
    protected $aAreas;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        Shops
     */
    protected $aShops;

    /**
     * @var        AdCategories
     */
    protected $aAdCategories;

    /**
     * @var        PropelObjectCollection|AdvPrice[] Collection to store aggregation of AdvPrice objects.
     */
    protected $collAdvPrices;
    protected $collAdvPricesPartial;

    /**
     * @var        PropelObjectCollection|AdvsStat[] Collection to store aggregation of AdvsStat objects.
     */
    protected $collAdvsStats;
    protected $collAdvsStatsPartial;

    /**
     * @var        PropelObjectCollection|AdvsModerStat[] Collection to store aggregation of AdvsModerStat objects.
     */
    protected $collAdvsModerStats;
    protected $collAdvsModerStatsPartial;

    /**
     * @var        PropelObjectCollection|AdvParams[] Collection to store aggregation of AdvParams objects.
     */
    protected $collAdvParamss;
    protected $collAdvParamssPartial;

    /**
     * @var        PropelObjectCollection|AdvImages[] Collection to store aggregation of AdvImages objects.
     */
    protected $collAdvImagess;
    protected $collAdvImagessPartial;

    /**
     * @var        PropelObjectCollection|AdvVideos[] Collection to store aggregation of AdvVideos objects.
     */
    protected $collAdvVideoss;
    protected $collAdvVideossPartial;

    /**
     * @var        PropelObjectCollection|AdvPackets[] Collection to store aggregation of AdvPackets objects.
     */
    protected $collAdvPacketss;
    protected $collAdvPacketssPartial;

    /**
     * @var        PropelObjectCollection|AdvComments[] Collection to store aggregation of AdvComments objects.
     */
    protected $collAdvCommentss;
    protected $collAdvCommentssPartial;

    /**
     * @var        PropelObjectCollection|AdvComplaine[] Collection to store aggregation of AdvComplaine objects.
     */
    protected $collAdvComplaines;
    protected $collAdvComplainesPartial;

    /**
     * @var        PropelObjectCollection|UserFavorite[] Collection to store aggregation of UserFavorite objects.
     */
    protected $collUserFavorites;
    protected $collUserFavoritesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advPricesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advsStatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advsModerStatsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advParamssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advImagessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advVideossScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advPacketssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advCommentssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advComplainesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $userFavoritesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->user_type = 1;
        $this->dogovor = false;
        $this->torg = false;
        $this->cnt = 0;
        $this->cnt_today = 0;
        $this->cnt_tel = 0;
        $this->cnt_tel_today = 0;
        $this->cnt_skype = 0;
        $this->cnt_site = 0;
        $this->digest = false;
        $this->moder_approved = false;
        $this->enabled = false;
        $this->deleted = false;
        $this->twitter = 0;
        $this->facebook = 0;
        $this->vk = 0;
        $this->vk_share = 0;
        $this->google = 0;
        $this->mailru = 0;
        $this->odnoklassniki = 0;
        $this->yandex_partner = true;
        $this->yandex_ping = 0;
    }

    /**
     * Initializes internal state of BaseAdvs object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [category_id] column value.
     *
     * @return int
     */
    public function getCategoryId()
    {

        return $this->category_id;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {

        return $this->user_id;
    }

    /**
     * Get the [user_type] column value.
     *
     * @return int
     */
    public function getUserType()
    {

        return $this->user_type;
    }

    /**
     * Get the [company_name] column value.
     *
     * @return string
     */
    public function getCompanyName()
    {

        return $this->company_name;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {

        return $this->phone;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [alias] column value.
     *
     * @return string
     */
    public function getAlias()
    {

        return $this->alias;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {

        return $this->description;
    }

    /**
     * Get the [price] column value.
     *
     * @return int
     */
    public function getPrice()
    {

        return $this->price;
    }

    /**
     * Get the [dogovor] column value.
     *
     * @return boolean
     */
    public function getDogovor()
    {

        return $this->dogovor;
    }

    /**
     * Get the [torg] column value.
     *
     * @return boolean
     */
    public function getTorg()
    {

        return $this->torg;
    }

    /**
     * Get the [region_id] column value.
     *
     * @return int
     */
    public function getRegionId()
    {

        return $this->region_id;
    }

    /**
     * Get the [area_id] column value.
     *
     * @return int
     */
    public function getAreaId()
    {

        return $this->area_id;
    }

    /**
     * Get the [shop_id] column value.
     *
     * @return int
     */
    public function getShopId()
    {

        return $this->shop_id;
    }

    /**
     * Get the [cnt] column value.
     *
     * @return int
     */
    public function getCnt()
    {

        return $this->cnt;
    }

    /**
     * Get the [cnt_today] column value.
     *
     * @return int
     */
    public function getCntToday()
    {

        return $this->cnt_today;
    }

    /**
     * Get the [cnt_tel] column value.
     *
     * @return int
     */
    public function getCntTel()
    {

        return $this->cnt_tel;
    }

    /**
     * Get the [cnt_tel_today] column value.
     *
     * @return int
     */
    public function getCntTelToday()
    {

        return $this->cnt_tel_today;
    }

    /**
     * Get the [cnt_skype] column value.
     *
     * @return int
     */
    public function getCntSkype()
    {

        return $this->cnt_skype;
    }

    /**
     * Get the [cnt_site] column value.
     *
     * @return int
     */
    public function getCntSite()
    {

        return $this->cnt_site;
    }

    /**
     * Get the [coord] column value.
     *
     * @return string
     */
    public function getCoord()
    {

        return $this->coord;
    }

    /**
     * Get the [site] column value.
     *
     * @return string
     */
    public function getSite()
    {

        return $this->site;
    }

    /**
     * Get the [skype] column value.
     *
     * @return string
     */
    public function getSkype()
    {

        return $this->skype;
    }

    /**
     * Get the [youtube] column value.
     *
     * @return string
     */
    public function getYoutube()
    {

        return $this->youtube;
    }

    /**
     * Get the [digest] column value.
     *
     * @return boolean
     */
    public function getDigest()
    {

        return $this->digest;
    }

    /**
     * Get the [moder_approved] column value.
     *
     * @return boolean
     */
    public function getModerApproved()
    {

        return $this->moder_approved;
    }

    /**
     * Get the [enabled] column value.
     *
     * @return boolean
     */
    public function getEnabled()
    {

        return $this->enabled;
    }

    /**
     * Get the [deleted] column value.
     *
     * @return boolean
     */
    public function getDeleted()
    {

        return $this->deleted;
    }

    /**
     * Get the [twitter] column value.
     *
     * @return int
     */
    public function getTwitter()
    {

        return $this->twitter;
    }

    /**
     * Get the [facebook] column value.
     *
     * @return int
     */
    public function getFacebook()
    {

        return $this->facebook;
    }

    /**
     * Get the [vk] column value.
     *
     * @return int
     */
    public function getVk()
    {

        return $this->vk;
    }

    /**
     * Get the [vk_share] column value.
     *
     * @return int
     */
    public function getVkShare()
    {

        return $this->vk_share;
    }

    /**
     * Get the [google] column value.
     *
     * @return int
     */
    public function getGoogle()
    {

        return $this->google;
    }

    /**
     * Get the [mailru] column value.
     *
     * @return int
     */
    public function getMailru()
    {

        return $this->mailru;
    }

    /**
     * Get the [odnoklassniki] column value.
     *
     * @return int
     */
    public function getOdnoklassniki()
    {

        return $this->odnoklassniki;
    }

    /**
     * Get the [yandex_partner] column value.
     *
     * @return boolean
     */
    public function getYandexPartner()
    {

        return $this->yandex_partner;
    }

    /**
     * Get the [optionally formatted] temporal [up_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpDate($format = null)
    {
        if ($this->up_date === null) {
            return null;
        }

        if ($this->up_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->up_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->up_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [hl_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getHlDate($format = null)
    {
        if ($this->hl_date === null) {
            return null;
        }

        if ($this->hl_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->hl_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->hl_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [social_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getSocialDate($format = null)
    {
        if ($this->social_date === null) {
            return null;
        }

        if ($this->social_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->social_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->social_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [yandex_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getYandexDate($format = null)
    {
        if ($this->yandex_date === null) {
            return null;
        }

        if ($this->yandex_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->yandex_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->yandex_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [yandex_index_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getYandexIndexDate($format = null)
    {
        if ($this->yandex_index_date === null) {
            return null;
        }

        if ($this->yandex_index_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->yandex_index_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->yandex_index_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [yandex_ping] column value.
     *
     * @return int
     */
    public function getYandexPing()
    {

        return $this->yandex_ping;
    }

    /**
     * Get the [optionally formatted] temporal [google_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getGoogleDate($format = null)
    {
        if ($this->google_date === null) {
            return null;
        }

        if ($this->google_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->google_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->google_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [google_index_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getGoogleIndexDate($format = null)
    {
        if ($this->google_index_date === null) {
            return null;
        }

        if ($this->google_index_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->google_index_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->google_index_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [create_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreateDate($format = null)
    {
        if ($this->create_date === null) {
            return null;
        }

        if ($this->create_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->create_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->create_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [publish_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPublishDate($format = null)
    {
        if ($this->publish_date === null) {
            return null;
        }

        if ($this->publish_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->publish_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->publish_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [publish_before_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPublishBeforeDate($format = null)
    {
        if ($this->publish_before_date === null) {
            return null;
        }

        if ($this->publish_before_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->publish_before_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->publish_before_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [last_view_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastViewDate($format = null)
    {
        if ($this->last_view_date === null) {
            return null;
        }

        if ($this->last_view_date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->last_view_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_view_date, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AdvsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = AdvsPeer::CATEGORY_ID;
        }

        if ($this->aAdCategories !== null && $this->aAdCategories->getId() !== $v) {
            $this->aAdCategories = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [user_id] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[] = AdvsPeer::USER_ID;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }


        return $this;
    } // setUserId()

    /**
     * Set the value of [user_type] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setUserType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_type !== $v) {
            $this->user_type = $v;
            $this->modifiedColumns[] = AdvsPeer::USER_TYPE;
        }


        return $this;
    } // setUserType()

    /**
     * Set the value of [company_name] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCompanyName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->company_name !== $v) {
            $this->company_name = $v;
            $this->modifiedColumns[] = AdvsPeer::COMPANY_NAME;
        }


        return $this;
    } // setCompanyName()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[] = AdvsPeer::PHONE;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AdvsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = AdvsPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = AdvsPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [price] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[] = AdvsPeer::PRICE;
        }


        return $this;
    } // setPrice()

    /**
     * Sets the value of the [dogovor] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setDogovor($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->dogovor !== $v) {
            $this->dogovor = $v;
            $this->modifiedColumns[] = AdvsPeer::DOGOVOR;
        }


        return $this;
    } // setDogovor()

    /**
     * Sets the value of the [torg] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setTorg($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->torg !== $v) {
            $this->torg = $v;
            $this->modifiedColumns[] = AdvsPeer::TORG;
        }


        return $this;
    } // setTorg()

    /**
     * Set the value of [region_id] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setRegionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->region_id !== $v) {
            $this->region_id = $v;
            $this->modifiedColumns[] = AdvsPeer::REGION_ID;
        }

        if ($this->aRegions !== null && $this->aRegions->getId() !== $v) {
            $this->aRegions = null;
        }


        return $this;
    } // setRegionId()

    /**
     * Set the value of [area_id] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setAreaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->area_id !== $v) {
            $this->area_id = $v;
            $this->modifiedColumns[] = AdvsPeer::AREA_ID;
        }

        if ($this->aAreas !== null && $this->aAreas->getId() !== $v) {
            $this->aAreas = null;
        }


        return $this;
    } // setAreaId()

    /**
     * Set the value of [shop_id] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setShopId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->shop_id !== $v) {
            $this->shop_id = $v;
            $this->modifiedColumns[] = AdvsPeer::SHOP_ID;
        }

        if ($this->aShops !== null && $this->aShops->getId() !== $v) {
            $this->aShops = null;
        }


        return $this;
    } // setShopId()

    /**
     * Set the value of [cnt] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCnt($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt !== $v) {
            $this->cnt = $v;
            $this->modifiedColumns[] = AdvsPeer::CNT;
        }


        return $this;
    } // setCnt()

    /**
     * Set the value of [cnt_today] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCntToday($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_today !== $v) {
            $this->cnt_today = $v;
            $this->modifiedColumns[] = AdvsPeer::CNT_TODAY;
        }


        return $this;
    } // setCntToday()

    /**
     * Set the value of [cnt_tel] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCntTel($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_tel !== $v) {
            $this->cnt_tel = $v;
            $this->modifiedColumns[] = AdvsPeer::CNT_TEL;
        }


        return $this;
    } // setCntTel()

    /**
     * Set the value of [cnt_tel_today] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCntTelToday($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_tel_today !== $v) {
            $this->cnt_tel_today = $v;
            $this->modifiedColumns[] = AdvsPeer::CNT_TEL_TODAY;
        }


        return $this;
    } // setCntTelToday()

    /**
     * Set the value of [cnt_skype] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCntSkype($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_skype !== $v) {
            $this->cnt_skype = $v;
            $this->modifiedColumns[] = AdvsPeer::CNT_SKYPE;
        }


        return $this;
    } // setCntSkype()

    /**
     * Set the value of [cnt_site] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCntSite($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_site !== $v) {
            $this->cnt_site = $v;
            $this->modifiedColumns[] = AdvsPeer::CNT_SITE;
        }


        return $this;
    } // setCntSite()

    /**
     * Set the value of [coord] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setCoord($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->coord !== $v) {
            $this->coord = $v;
            $this->modifiedColumns[] = AdvsPeer::COORD;
        }


        return $this;
    } // setCoord()

    /**
     * Set the value of [site] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setSite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->site !== $v) {
            $this->site = $v;
            $this->modifiedColumns[] = AdvsPeer::SITE;
        }


        return $this;
    } // setSite()

    /**
     * Set the value of [skype] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setSkype($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->skype !== $v) {
            $this->skype = $v;
            $this->modifiedColumns[] = AdvsPeer::SKYPE;
        }


        return $this;
    } // setSkype()

    /**
     * Set the value of [youtube] column.
     *
     * @param  string $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setYoutube($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->youtube !== $v) {
            $this->youtube = $v;
            $this->modifiedColumns[] = AdvsPeer::YOUTUBE;
        }


        return $this;
    } // setYoutube()

    /**
     * Sets the value of the [digest] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setDigest($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->digest !== $v) {
            $this->digest = $v;
            $this->modifiedColumns[] = AdvsPeer::DIGEST;
        }


        return $this;
    } // setDigest()

    /**
     * Sets the value of the [moder_approved] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setModerApproved($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->moder_approved !== $v) {
            $this->moder_approved = $v;
            $this->modifiedColumns[] = AdvsPeer::MODER_APPROVED;
        }


        return $this;
    } // setModerApproved()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setEnabled($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->enabled !== $v) {
            $this->enabled = $v;
            $this->modifiedColumns[] = AdvsPeer::ENABLED;
        }


        return $this;
    } // setEnabled()

    /**
     * Sets the value of the [deleted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setDeleted($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->deleted !== $v) {
            $this->deleted = $v;
            $this->modifiedColumns[] = AdvsPeer::DELETED;
        }


        return $this;
    } // setDeleted()

    /**
     * Set the value of [twitter] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setTwitter($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->twitter !== $v) {
            $this->twitter = $v;
            $this->modifiedColumns[] = AdvsPeer::TWITTER;
        }


        return $this;
    } // setTwitter()

    /**
     * Set the value of [facebook] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setFacebook($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->facebook !== $v) {
            $this->facebook = $v;
            $this->modifiedColumns[] = AdvsPeer::FACEBOOK;
        }


        return $this;
    } // setFacebook()

    /**
     * Set the value of [vk] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setVk($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->vk !== $v) {
            $this->vk = $v;
            $this->modifiedColumns[] = AdvsPeer::VK;
        }


        return $this;
    } // setVk()

    /**
     * Set the value of [vk_share] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setVkShare($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->vk_share !== $v) {
            $this->vk_share = $v;
            $this->modifiedColumns[] = AdvsPeer::VK_SHARE;
        }


        return $this;
    } // setVkShare()

    /**
     * Set the value of [google] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setGoogle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->google !== $v) {
            $this->google = $v;
            $this->modifiedColumns[] = AdvsPeer::GOOGLE;
        }


        return $this;
    } // setGoogle()

    /**
     * Set the value of [mailru] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setMailru($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->mailru !== $v) {
            $this->mailru = $v;
            $this->modifiedColumns[] = AdvsPeer::MAILRU;
        }


        return $this;
    } // setMailru()

    /**
     * Set the value of [odnoklassniki] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setOdnoklassniki($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->odnoklassniki !== $v) {
            $this->odnoklassniki = $v;
            $this->modifiedColumns[] = AdvsPeer::ODNOKLASSNIKI;
        }


        return $this;
    } // setOdnoklassniki()

    /**
     * Sets the value of the [yandex_partner] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Advs The current object (for fluent API support)
     */
    public function setYandexPartner($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->yandex_partner !== $v) {
            $this->yandex_partner = $v;
            $this->modifiedColumns[] = AdvsPeer::YANDEX_PARTNER;
        }


        return $this;
    } // setYandexPartner()

    /**
     * Sets the value of [up_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setUpDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->up_date !== null || $dt !== null) {
            $currentDateAsString = ($this->up_date !== null && $tmpDt = new DateTime($this->up_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->up_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::UP_DATE;
            }
        } // if either are not null


        return $this;
    } // setUpDate()

    /**
     * Sets the value of [hl_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setHlDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->hl_date !== null || $dt !== null) {
            $currentDateAsString = ($this->hl_date !== null && $tmpDt = new DateTime($this->hl_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->hl_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::HL_DATE;
            }
        } // if either are not null


        return $this;
    } // setHlDate()

    /**
     * Sets the value of [social_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setSocialDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->social_date !== null || $dt !== null) {
            $currentDateAsString = ($this->social_date !== null && $tmpDt = new DateTime($this->social_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->social_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::SOCIAL_DATE;
            }
        } // if either are not null


        return $this;
    } // setSocialDate()

    /**
     * Sets the value of [yandex_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setYandexDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->yandex_date !== null || $dt !== null) {
            $currentDateAsString = ($this->yandex_date !== null && $tmpDt = new DateTime($this->yandex_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->yandex_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::YANDEX_DATE;
            }
        } // if either are not null


        return $this;
    } // setYandexDate()

    /**
     * Sets the value of [yandex_index_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setYandexIndexDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->yandex_index_date !== null || $dt !== null) {
            $currentDateAsString = ($this->yandex_index_date !== null && $tmpDt = new DateTime($this->yandex_index_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->yandex_index_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::YANDEX_INDEX_DATE;
            }
        } // if either are not null


        return $this;
    } // setYandexIndexDate()

    /**
     * Set the value of [yandex_ping] column.
     *
     * @param  int $v new value
     * @return Advs The current object (for fluent API support)
     */
    public function setYandexPing($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->yandex_ping !== $v) {
            $this->yandex_ping = $v;
            $this->modifiedColumns[] = AdvsPeer::YANDEX_PING;
        }


        return $this;
    } // setYandexPing()

    /**
     * Sets the value of [google_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setGoogleDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->google_date !== null || $dt !== null) {
            $currentDateAsString = ($this->google_date !== null && $tmpDt = new DateTime($this->google_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->google_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::GOOGLE_DATE;
            }
        } // if either are not null


        return $this;
    } // setGoogleDate()

    /**
     * Sets the value of [google_index_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setGoogleIndexDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->google_index_date !== null || $dt !== null) {
            $currentDateAsString = ($this->google_index_date !== null && $tmpDt = new DateTime($this->google_index_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->google_index_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::GOOGLE_INDEX_DATE;
            }
        } // if either are not null


        return $this;
    } // setGoogleIndexDate()

    /**
     * Sets the value of [create_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setCreateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->create_date !== null || $dt !== null) {
            $currentDateAsString = ($this->create_date !== null && $tmpDt = new DateTime($this->create_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->create_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::CREATE_DATE;
            }
        } // if either are not null


        return $this;
    } // setCreateDate()

    /**
     * Sets the value of [publish_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setPublishDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->publish_date !== null || $dt !== null) {
            $currentDateAsString = ($this->publish_date !== null && $tmpDt = new DateTime($this->publish_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->publish_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::PUBLISH_DATE;
            }
        } // if either are not null


        return $this;
    } // setPublishDate()

    /**
     * Sets the value of [publish_before_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setPublishBeforeDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->publish_before_date !== null || $dt !== null) {
            $currentDateAsString = ($this->publish_before_date !== null && $tmpDt = new DateTime($this->publish_before_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->publish_before_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::PUBLISH_BEFORE_DATE;
            }
        } // if either are not null


        return $this;
    } // setPublishBeforeDate()

    /**
     * Sets the value of [last_view_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Advs The current object (for fluent API support)
     */
    public function setLastViewDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_view_date !== null || $dt !== null) {
            $currentDateAsString = ($this->last_view_date !== null && $tmpDt = new DateTime($this->last_view_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->last_view_date = $newDateAsString;
                $this->modifiedColumns[] = AdvsPeer::LAST_VIEW_DATE;
            }
        } // if either are not null


        return $this;
    } // setLastViewDate()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->user_type !== 1) {
                return false;
            }

            if ($this->dogovor !== false) {
                return false;
            }

            if ($this->torg !== false) {
                return false;
            }

            if ($this->cnt !== 0) {
                return false;
            }

            if ($this->cnt_today !== 0) {
                return false;
            }

            if ($this->cnt_tel !== 0) {
                return false;
            }

            if ($this->cnt_tel_today !== 0) {
                return false;
            }

            if ($this->cnt_skype !== 0) {
                return false;
            }

            if ($this->cnt_site !== 0) {
                return false;
            }

            if ($this->digest !== false) {
                return false;
            }

            if ($this->moder_approved !== false) {
                return false;
            }

            if ($this->enabled !== false) {
                return false;
            }

            if ($this->deleted !== false) {
                return false;
            }

            if ($this->twitter !== 0) {
                return false;
            }

            if ($this->facebook !== 0) {
                return false;
            }

            if ($this->vk !== 0) {
                return false;
            }

            if ($this->vk_share !== 0) {
                return false;
            }

            if ($this->google !== 0) {
                return false;
            }

            if ($this->mailru !== 0) {
                return false;
            }

            if ($this->odnoklassniki !== 0) {
                return false;
            }

            if ($this->yandex_partner !== true) {
                return false;
            }

            if ($this->yandex_ping !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->category_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->user_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->user_type = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->company_name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->phone = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->name = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->alias = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->description = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->price = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->dogovor = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
            $this->torg = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
            $this->region_id = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->area_id = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->shop_id = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->cnt = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
            $this->cnt_today = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
            $this->cnt_tel = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->cnt_tel_today = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
            $this->cnt_skype = ($row[$startcol + 19] !== null) ? (int) $row[$startcol + 19] : null;
            $this->cnt_site = ($row[$startcol + 20] !== null) ? (int) $row[$startcol + 20] : null;
            $this->coord = ($row[$startcol + 21] !== null) ? (string) $row[$startcol + 21] : null;
            $this->site = ($row[$startcol + 22] !== null) ? (string) $row[$startcol + 22] : null;
            $this->skype = ($row[$startcol + 23] !== null) ? (string) $row[$startcol + 23] : null;
            $this->youtube = ($row[$startcol + 24] !== null) ? (string) $row[$startcol + 24] : null;
            $this->digest = ($row[$startcol + 25] !== null) ? (boolean) $row[$startcol + 25] : null;
            $this->moder_approved = ($row[$startcol + 26] !== null) ? (boolean) $row[$startcol + 26] : null;
            $this->enabled = ($row[$startcol + 27] !== null) ? (boolean) $row[$startcol + 27] : null;
            $this->deleted = ($row[$startcol + 28] !== null) ? (boolean) $row[$startcol + 28] : null;
            $this->twitter = ($row[$startcol + 29] !== null) ? (int) $row[$startcol + 29] : null;
            $this->facebook = ($row[$startcol + 30] !== null) ? (int) $row[$startcol + 30] : null;
            $this->vk = ($row[$startcol + 31] !== null) ? (int) $row[$startcol + 31] : null;
            $this->vk_share = ($row[$startcol + 32] !== null) ? (int) $row[$startcol + 32] : null;
            $this->google = ($row[$startcol + 33] !== null) ? (int) $row[$startcol + 33] : null;
            $this->mailru = ($row[$startcol + 34] !== null) ? (int) $row[$startcol + 34] : null;
            $this->odnoklassniki = ($row[$startcol + 35] !== null) ? (int) $row[$startcol + 35] : null;
            $this->yandex_partner = ($row[$startcol + 36] !== null) ? (boolean) $row[$startcol + 36] : null;
            $this->up_date = ($row[$startcol + 37] !== null) ? (string) $row[$startcol + 37] : null;
            $this->hl_date = ($row[$startcol + 38] !== null) ? (string) $row[$startcol + 38] : null;
            $this->social_date = ($row[$startcol + 39] !== null) ? (string) $row[$startcol + 39] : null;
            $this->yandex_date = ($row[$startcol + 40] !== null) ? (string) $row[$startcol + 40] : null;
            $this->yandex_index_date = ($row[$startcol + 41] !== null) ? (string) $row[$startcol + 41] : null;
            $this->yandex_ping = ($row[$startcol + 42] !== null) ? (int) $row[$startcol + 42] : null;
            $this->google_date = ($row[$startcol + 43] !== null) ? (string) $row[$startcol + 43] : null;
            $this->google_index_date = ($row[$startcol + 44] !== null) ? (string) $row[$startcol + 44] : null;
            $this->create_date = ($row[$startcol + 45] !== null) ? (string) $row[$startcol + 45] : null;
            $this->publish_date = ($row[$startcol + 46] !== null) ? (string) $row[$startcol + 46] : null;
            $this->publish_before_date = ($row[$startcol + 47] !== null) ? (string) $row[$startcol + 47] : null;
            $this->last_view_date = ($row[$startcol + 48] !== null) ? (string) $row[$startcol + 48] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 49; // 49 = AdvsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Advs object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aAdCategories !== null && $this->category_id !== $this->aAdCategories->getId()) {
            $this->aAdCategories = null;
        }
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
        if ($this->aRegions !== null && $this->region_id !== $this->aRegions->getId()) {
            $this->aRegions = null;
        }
        if ($this->aAreas !== null && $this->area_id !== $this->aAreas->getId()) {
            $this->aAreas = null;
        }
        if ($this->aShops !== null && $this->shop_id !== $this->aShops->getId()) {
            $this->aShops = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AdvsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRegions = null;
            $this->aAreas = null;
            $this->aUser = null;
            $this->aShops = null;
            $this->aAdCategories = null;
            $this->collAdvPrices = null;

            $this->collAdvsStats = null;

            $this->collAdvsModerStats = null;

            $this->collAdvParamss = null;

            $this->collAdvImagess = null;

            $this->collAdvVideoss = null;

            $this->collAdvPacketss = null;

            $this->collAdvCommentss = null;

            $this->collAdvComplaines = null;

            $this->collUserFavorites = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AdvsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                AdvsPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aRegions !== null) {
                if ($this->aRegions->isModified() || $this->aRegions->isNew()) {
                    $affectedRows += $this->aRegions->save($con);
                }
                $this->setRegions($this->aRegions);
            }

            if ($this->aAreas !== null) {
                if ($this->aAreas->isModified() || $this->aAreas->isNew()) {
                    $affectedRows += $this->aAreas->save($con);
                }
                $this->setAreas($this->aAreas);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aShops !== null) {
                if ($this->aShops->isModified() || $this->aShops->isNew()) {
                    $affectedRows += $this->aShops->save($con);
                }
                $this->setShops($this->aShops);
            }

            if ($this->aAdCategories !== null) {
                if ($this->aAdCategories->isModified() || $this->aAdCategories->isNew()) {
                    $affectedRows += $this->aAdCategories->save($con);
                }
                $this->setAdCategories($this->aAdCategories);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->advPricesScheduledForDeletion !== null) {
                if (!$this->advPricesScheduledForDeletion->isEmpty()) {
                    AdvPriceQuery::create()
                        ->filterByPrimaryKeys($this->advPricesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advPricesScheduledForDeletion = null;
                }
            }

            if ($this->collAdvPrices !== null) {
                foreach ($this->collAdvPrices as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advsStatsScheduledForDeletion !== null) {
                if (!$this->advsStatsScheduledForDeletion->isEmpty()) {
                    AdvsStatQuery::create()
                        ->filterByPrimaryKeys($this->advsStatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advsStatsScheduledForDeletion = null;
                }
            }

            if ($this->collAdvsStats !== null) {
                foreach ($this->collAdvsStats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advsModerStatsScheduledForDeletion !== null) {
                if (!$this->advsModerStatsScheduledForDeletion->isEmpty()) {
                    AdvsModerStatQuery::create()
                        ->filterByPrimaryKeys($this->advsModerStatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advsModerStatsScheduledForDeletion = null;
                }
            }

            if ($this->collAdvsModerStats !== null) {
                foreach ($this->collAdvsModerStats as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advParamssScheduledForDeletion !== null) {
                if (!$this->advParamssScheduledForDeletion->isEmpty()) {
                    AdvParamsQuery::create()
                        ->filterByPrimaryKeys($this->advParamssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advParamssScheduledForDeletion = null;
                }
            }

            if ($this->collAdvParamss !== null) {
                foreach ($this->collAdvParamss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advImagessScheduledForDeletion !== null) {
                if (!$this->advImagessScheduledForDeletion->isEmpty()) {
                    AdvImagesQuery::create()
                        ->filterByPrimaryKeys($this->advImagessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advImagessScheduledForDeletion = null;
                }
            }

            if ($this->collAdvImagess !== null) {
                foreach ($this->collAdvImagess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advVideossScheduledForDeletion !== null) {
                if (!$this->advVideossScheduledForDeletion->isEmpty()) {
                    AdvVideosQuery::create()
                        ->filterByPrimaryKeys($this->advVideossScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advVideossScheduledForDeletion = null;
                }
            }

            if ($this->collAdvVideoss !== null) {
                foreach ($this->collAdvVideoss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advPacketssScheduledForDeletion !== null) {
                if (!$this->advPacketssScheduledForDeletion->isEmpty()) {
                    AdvPacketsQuery::create()
                        ->filterByPrimaryKeys($this->advPacketssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advPacketssScheduledForDeletion = null;
                }
            }

            if ($this->collAdvPacketss !== null) {
                foreach ($this->collAdvPacketss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advCommentssScheduledForDeletion !== null) {
                if (!$this->advCommentssScheduledForDeletion->isEmpty()) {
                    AdvCommentsQuery::create()
                        ->filterByPrimaryKeys($this->advCommentssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advCommentssScheduledForDeletion = null;
                }
            }

            if ($this->collAdvCommentss !== null) {
                foreach ($this->collAdvCommentss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advComplainesScheduledForDeletion !== null) {
                if (!$this->advComplainesScheduledForDeletion->isEmpty()) {
                    AdvComplaineQuery::create()
                        ->filterByPrimaryKeys($this->advComplainesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->advComplainesScheduledForDeletion = null;
                }
            }

            if ($this->collAdvComplaines !== null) {
                foreach ($this->collAdvComplaines as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->userFavoritesScheduledForDeletion !== null) {
                if (!$this->userFavoritesScheduledForDeletion->isEmpty()) {
                    UserFavoriteQuery::create()
                        ->filterByPrimaryKeys($this->userFavoritesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userFavoritesScheduledForDeletion = null;
                }
            }

            if ($this->collUserFavorites !== null) {
                foreach ($this->collUserFavorites as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = AdvsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdvsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdvsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdvsPeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(AdvsPeer::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`user_id`';
        }
        if ($this->isColumnModified(AdvsPeer::USER_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`user_type`';
        }
        if ($this->isColumnModified(AdvsPeer::COMPANY_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`company_name`';
        }
        if ($this->isColumnModified(AdvsPeer::PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(AdvsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(AdvsPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(AdvsPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(AdvsPeer::PRICE)) {
            $modifiedColumns[':p' . $index++]  = '`price`';
        }
        if ($this->isColumnModified(AdvsPeer::DOGOVOR)) {
            $modifiedColumns[':p' . $index++]  = '`dogovor`';
        }
        if ($this->isColumnModified(AdvsPeer::TORG)) {
            $modifiedColumns[':p' . $index++]  = '`torg`';
        }
        if ($this->isColumnModified(AdvsPeer::REGION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`region_id`';
        }
        if ($this->isColumnModified(AdvsPeer::AREA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`area_id`';
        }
        if ($this->isColumnModified(AdvsPeer::SHOP_ID)) {
            $modifiedColumns[':p' . $index++]  = '`shop_id`';
        }
        if ($this->isColumnModified(AdvsPeer::CNT)) {
            $modifiedColumns[':p' . $index++]  = '`cnt`';
        }
        if ($this->isColumnModified(AdvsPeer::CNT_TODAY)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_today`';
        }
        if ($this->isColumnModified(AdvsPeer::CNT_TEL)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_tel`';
        }
        if ($this->isColumnModified(AdvsPeer::CNT_TEL_TODAY)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_tel_today`';
        }
        if ($this->isColumnModified(AdvsPeer::CNT_SKYPE)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_skype`';
        }
        if ($this->isColumnModified(AdvsPeer::CNT_SITE)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_site`';
        }
        if ($this->isColumnModified(AdvsPeer::COORD)) {
            $modifiedColumns[':p' . $index++]  = '`coord`';
        }
        if ($this->isColumnModified(AdvsPeer::SITE)) {
            $modifiedColumns[':p' . $index++]  = '`site`';
        }
        if ($this->isColumnModified(AdvsPeer::SKYPE)) {
            $modifiedColumns[':p' . $index++]  = '`skype`';
        }
        if ($this->isColumnModified(AdvsPeer::YOUTUBE)) {
            $modifiedColumns[':p' . $index++]  = '`youtube`';
        }
        if ($this->isColumnModified(AdvsPeer::DIGEST)) {
            $modifiedColumns[':p' . $index++]  = '`digest`';
        }
        if ($this->isColumnModified(AdvsPeer::MODER_APPROVED)) {
            $modifiedColumns[':p' . $index++]  = '`moder_approved`';
        }
        if ($this->isColumnModified(AdvsPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(AdvsPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(AdvsPeer::TWITTER)) {
            $modifiedColumns[':p' . $index++]  = '`twitter`';
        }
        if ($this->isColumnModified(AdvsPeer::FACEBOOK)) {
            $modifiedColumns[':p' . $index++]  = '`facebook`';
        }
        if ($this->isColumnModified(AdvsPeer::VK)) {
            $modifiedColumns[':p' . $index++]  = '`vk`';
        }
        if ($this->isColumnModified(AdvsPeer::VK_SHARE)) {
            $modifiedColumns[':p' . $index++]  = '`vk_share`';
        }
        if ($this->isColumnModified(AdvsPeer::GOOGLE)) {
            $modifiedColumns[':p' . $index++]  = '`google`';
        }
        if ($this->isColumnModified(AdvsPeer::MAILRU)) {
            $modifiedColumns[':p' . $index++]  = '`mailru`';
        }
        if ($this->isColumnModified(AdvsPeer::ODNOKLASSNIKI)) {
            $modifiedColumns[':p' . $index++]  = '`odnoklassniki`';
        }
        if ($this->isColumnModified(AdvsPeer::YANDEX_PARTNER)) {
            $modifiedColumns[':p' . $index++]  = '`yandex_partner`';
        }
        if ($this->isColumnModified(AdvsPeer::UP_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`up_date`';
        }
        if ($this->isColumnModified(AdvsPeer::HL_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`hl_date`';
        }
        if ($this->isColumnModified(AdvsPeer::SOCIAL_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`social_date`';
        }
        if ($this->isColumnModified(AdvsPeer::YANDEX_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`yandex_date`';
        }
        if ($this->isColumnModified(AdvsPeer::YANDEX_INDEX_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`yandex_index_date`';
        }
        if ($this->isColumnModified(AdvsPeer::YANDEX_PING)) {
            $modifiedColumns[':p' . $index++]  = '`yandex_ping`';
        }
        if ($this->isColumnModified(AdvsPeer::GOOGLE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`google_date`';
        }
        if ($this->isColumnModified(AdvsPeer::GOOGLE_INDEX_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`google_index_date`';
        }
        if ($this->isColumnModified(AdvsPeer::CREATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`create_date`';
        }
        if ($this->isColumnModified(AdvsPeer::PUBLISH_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`publish_date`';
        }
        if ($this->isColumnModified(AdvsPeer::PUBLISH_BEFORE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`publish_before_date`';
        }
        if ($this->isColumnModified(AdvsPeer::LAST_VIEW_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`last_view_date`';
        }

        $sql = sprintf(
            'INSERT INTO `advs` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`category_id`':
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_INT);
                        break;
                    case '`user_id`':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
                        break;
                    case '`user_type`':
                        $stmt->bindValue($identifier, $this->user_type, PDO::PARAM_INT);
                        break;
                    case '`company_name`':
                        $stmt->bindValue($identifier, $this->company_name, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`alias`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`price`':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_INT);
                        break;
                    case '`dogovor`':
                        $stmt->bindValue($identifier, (int) $this->dogovor, PDO::PARAM_INT);
                        break;
                    case '`torg`':
                        $stmt->bindValue($identifier, (int) $this->torg, PDO::PARAM_INT);
                        break;
                    case '`region_id`':
                        $stmt->bindValue($identifier, $this->region_id, PDO::PARAM_INT);
                        break;
                    case '`area_id`':
                        $stmt->bindValue($identifier, $this->area_id, PDO::PARAM_INT);
                        break;
                    case '`shop_id`':
                        $stmt->bindValue($identifier, $this->shop_id, PDO::PARAM_INT);
                        break;
                    case '`cnt`':
                        $stmt->bindValue($identifier, $this->cnt, PDO::PARAM_INT);
                        break;
                    case '`cnt_today`':
                        $stmt->bindValue($identifier, $this->cnt_today, PDO::PARAM_INT);
                        break;
                    case '`cnt_tel`':
                        $stmt->bindValue($identifier, $this->cnt_tel, PDO::PARAM_INT);
                        break;
                    case '`cnt_tel_today`':
                        $stmt->bindValue($identifier, $this->cnt_tel_today, PDO::PARAM_INT);
                        break;
                    case '`cnt_skype`':
                        $stmt->bindValue($identifier, $this->cnt_skype, PDO::PARAM_INT);
                        break;
                    case '`cnt_site`':
                        $stmt->bindValue($identifier, $this->cnt_site, PDO::PARAM_INT);
                        break;
                    case '`coord`':
                        $stmt->bindValue($identifier, $this->coord, PDO::PARAM_STR);
                        break;
                    case '`site`':
                        $stmt->bindValue($identifier, $this->site, PDO::PARAM_STR);
                        break;
                    case '`skype`':
                        $stmt->bindValue($identifier, $this->skype, PDO::PARAM_STR);
                        break;
                    case '`youtube`':
                        $stmt->bindValue($identifier, $this->youtube, PDO::PARAM_STR);
                        break;
                    case '`digest`':
                        $stmt->bindValue($identifier, (int) $this->digest, PDO::PARAM_INT);
                        break;
                    case '`moder_approved`':
                        $stmt->bindValue($identifier, (int) $this->moder_approved, PDO::PARAM_INT);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`deleted`':
                        $stmt->bindValue($identifier, (int) $this->deleted, PDO::PARAM_INT);
                        break;
                    case '`twitter`':
                        $stmt->bindValue($identifier, $this->twitter, PDO::PARAM_INT);
                        break;
                    case '`facebook`':
                        $stmt->bindValue($identifier, $this->facebook, PDO::PARAM_INT);
                        break;
                    case '`vk`':
                        $stmt->bindValue($identifier, $this->vk, PDO::PARAM_INT);
                        break;
                    case '`vk_share`':
                        $stmt->bindValue($identifier, $this->vk_share, PDO::PARAM_INT);
                        break;
                    case '`google`':
                        $stmt->bindValue($identifier, $this->google, PDO::PARAM_INT);
                        break;
                    case '`mailru`':
                        $stmt->bindValue($identifier, $this->mailru, PDO::PARAM_INT);
                        break;
                    case '`odnoklassniki`':
                        $stmt->bindValue($identifier, $this->odnoklassniki, PDO::PARAM_INT);
                        break;
                    case '`yandex_partner`':
                        $stmt->bindValue($identifier, (int) $this->yandex_partner, PDO::PARAM_INT);
                        break;
                    case '`up_date`':
                        $stmt->bindValue($identifier, $this->up_date, PDO::PARAM_STR);
                        break;
                    case '`hl_date`':
                        $stmt->bindValue($identifier, $this->hl_date, PDO::PARAM_STR);
                        break;
                    case '`social_date`':
                        $stmt->bindValue($identifier, $this->social_date, PDO::PARAM_STR);
                        break;
                    case '`yandex_date`':
                        $stmt->bindValue($identifier, $this->yandex_date, PDO::PARAM_STR);
                        break;
                    case '`yandex_index_date`':
                        $stmt->bindValue($identifier, $this->yandex_index_date, PDO::PARAM_STR);
                        break;
                    case '`yandex_ping`':
                        $stmt->bindValue($identifier, $this->yandex_ping, PDO::PARAM_INT);
                        break;
                    case '`google_date`':
                        $stmt->bindValue($identifier, $this->google_date, PDO::PARAM_STR);
                        break;
                    case '`google_index_date`':
                        $stmt->bindValue($identifier, $this->google_index_date, PDO::PARAM_STR);
                        break;
                    case '`create_date`':
                        $stmt->bindValue($identifier, $this->create_date, PDO::PARAM_STR);
                        break;
                    case '`publish_date`':
                        $stmt->bindValue($identifier, $this->publish_date, PDO::PARAM_STR);
                        break;
                    case '`publish_before_date`':
                        $stmt->bindValue($identifier, $this->publish_before_date, PDO::PARAM_STR);
                        break;
                    case '`last_view_date`':
                        $stmt->bindValue($identifier, $this->last_view_date, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aRegions !== null) {
                if (!$this->aRegions->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aRegions->getValidationFailures());
                }
            }

            if ($this->aAreas !== null) {
                if (!$this->aAreas->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAreas->getValidationFailures());
                }
            }

            if ($this->aUser !== null) {
                if (!$this->aUser->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
                }
            }

            if ($this->aShops !== null) {
                if (!$this->aShops->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aShops->getValidationFailures());
                }
            }

            if ($this->aAdCategories !== null) {
                if (!$this->aAdCategories->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategories->getValidationFailures());
                }
            }


            if (($retval = AdvsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAdvPrices !== null) {
                    foreach ($this->collAdvPrices as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvsStats !== null) {
                    foreach ($this->collAdvsStats as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvsModerStats !== null) {
                    foreach ($this->collAdvsModerStats as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvParamss !== null) {
                    foreach ($this->collAdvParamss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvImagess !== null) {
                    foreach ($this->collAdvImagess as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvVideoss !== null) {
                    foreach ($this->collAdvVideoss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvPacketss !== null) {
                    foreach ($this->collAdvPacketss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvCommentss !== null) {
                    foreach ($this->collAdvCommentss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvComplaines !== null) {
                    foreach ($this->collAdvComplaines as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collUserFavorites !== null) {
                    foreach ($this->collUserFavorites as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AdvsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getCategoryId();
                break;
            case 2:
                return $this->getUserId();
                break;
            case 3:
                return $this->getUserType();
                break;
            case 4:
                return $this->getCompanyName();
                break;
            case 5:
                return $this->getPhone();
                break;
            case 6:
                return $this->getName();
                break;
            case 7:
                return $this->getAlias();
                break;
            case 8:
                return $this->getDescription();
                break;
            case 9:
                return $this->getPrice();
                break;
            case 10:
                return $this->getDogovor();
                break;
            case 11:
                return $this->getTorg();
                break;
            case 12:
                return $this->getRegionId();
                break;
            case 13:
                return $this->getAreaId();
                break;
            case 14:
                return $this->getShopId();
                break;
            case 15:
                return $this->getCnt();
                break;
            case 16:
                return $this->getCntToday();
                break;
            case 17:
                return $this->getCntTel();
                break;
            case 18:
                return $this->getCntTelToday();
                break;
            case 19:
                return $this->getCntSkype();
                break;
            case 20:
                return $this->getCntSite();
                break;
            case 21:
                return $this->getCoord();
                break;
            case 22:
                return $this->getSite();
                break;
            case 23:
                return $this->getSkype();
                break;
            case 24:
                return $this->getYoutube();
                break;
            case 25:
                return $this->getDigest();
                break;
            case 26:
                return $this->getModerApproved();
                break;
            case 27:
                return $this->getEnabled();
                break;
            case 28:
                return $this->getDeleted();
                break;
            case 29:
                return $this->getTwitter();
                break;
            case 30:
                return $this->getFacebook();
                break;
            case 31:
                return $this->getVk();
                break;
            case 32:
                return $this->getVkShare();
                break;
            case 33:
                return $this->getGoogle();
                break;
            case 34:
                return $this->getMailru();
                break;
            case 35:
                return $this->getOdnoklassniki();
                break;
            case 36:
                return $this->getYandexPartner();
                break;
            case 37:
                return $this->getUpDate();
                break;
            case 38:
                return $this->getHlDate();
                break;
            case 39:
                return $this->getSocialDate();
                break;
            case 40:
                return $this->getYandexDate();
                break;
            case 41:
                return $this->getYandexIndexDate();
                break;
            case 42:
                return $this->getYandexPing();
                break;
            case 43:
                return $this->getGoogleDate();
                break;
            case 44:
                return $this->getGoogleIndexDate();
                break;
            case 45:
                return $this->getCreateDate();
                break;
            case 46:
                return $this->getPublishDate();
                break;
            case 47:
                return $this->getPublishBeforeDate();
                break;
            case 48:
                return $this->getLastViewDate();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Advs'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Advs'][$this->getPrimaryKey()] = true;
        $keys = AdvsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getUserType(),
            $keys[4] => $this->getCompanyName(),
            $keys[5] => $this->getPhone(),
            $keys[6] => $this->getName(),
            $keys[7] => $this->getAlias(),
            $keys[8] => $this->getDescription(),
            $keys[9] => $this->getPrice(),
            $keys[10] => $this->getDogovor(),
            $keys[11] => $this->getTorg(),
            $keys[12] => $this->getRegionId(),
            $keys[13] => $this->getAreaId(),
            $keys[14] => $this->getShopId(),
            $keys[15] => $this->getCnt(),
            $keys[16] => $this->getCntToday(),
            $keys[17] => $this->getCntTel(),
            $keys[18] => $this->getCntTelToday(),
            $keys[19] => $this->getCntSkype(),
            $keys[20] => $this->getCntSite(),
            $keys[21] => $this->getCoord(),
            $keys[22] => $this->getSite(),
            $keys[23] => $this->getSkype(),
            $keys[24] => $this->getYoutube(),
            $keys[25] => $this->getDigest(),
            $keys[26] => $this->getModerApproved(),
            $keys[27] => $this->getEnabled(),
            $keys[28] => $this->getDeleted(),
            $keys[29] => $this->getTwitter(),
            $keys[30] => $this->getFacebook(),
            $keys[31] => $this->getVk(),
            $keys[32] => $this->getVkShare(),
            $keys[33] => $this->getGoogle(),
            $keys[34] => $this->getMailru(),
            $keys[35] => $this->getOdnoklassniki(),
            $keys[36] => $this->getYandexPartner(),
            $keys[37] => $this->getUpDate(),
            $keys[38] => $this->getHlDate(),
            $keys[39] => $this->getSocialDate(),
            $keys[40] => $this->getYandexDate(),
            $keys[41] => $this->getYandexIndexDate(),
            $keys[42] => $this->getYandexPing(),
            $keys[43] => $this->getGoogleDate(),
            $keys[44] => $this->getGoogleIndexDate(),
            $keys[45] => $this->getCreateDate(),
            $keys[46] => $this->getPublishDate(),
            $keys[47] => $this->getPublishBeforeDate(),
            $keys[48] => $this->getLastViewDate(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aRegions) {
                $result['Regions'] = $this->aRegions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAreas) {
                $result['Areas'] = $this->aAreas->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aShops) {
                $result['Shops'] = $this->aShops->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAdCategories) {
                $result['AdCategories'] = $this->aAdCategories->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAdvPrices) {
                $result['AdvPrices'] = $this->collAdvPrices->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvsStats) {
                $result['AdvsStats'] = $this->collAdvsStats->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvsModerStats) {
                $result['AdvsModerStats'] = $this->collAdvsModerStats->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvParamss) {
                $result['AdvParamss'] = $this->collAdvParamss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvImagess) {
                $result['AdvImagess'] = $this->collAdvImagess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvVideoss) {
                $result['AdvVideoss'] = $this->collAdvVideoss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvPacketss) {
                $result['AdvPacketss'] = $this->collAdvPacketss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvCommentss) {
                $result['AdvCommentss'] = $this->collAdvCommentss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvComplaines) {
                $result['AdvComplaines'] = $this->collAdvComplaines->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUserFavorites) {
                $result['UserFavorites'] = $this->collUserFavorites->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = AdvsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCategoryId($value);
                break;
            case 2:
                $this->setUserId($value);
                break;
            case 3:
                $this->setUserType($value);
                break;
            case 4:
                $this->setCompanyName($value);
                break;
            case 5:
                $this->setPhone($value);
                break;
            case 6:
                $this->setName($value);
                break;
            case 7:
                $this->setAlias($value);
                break;
            case 8:
                $this->setDescription($value);
                break;
            case 9:
                $this->setPrice($value);
                break;
            case 10:
                $this->setDogovor($value);
                break;
            case 11:
                $this->setTorg($value);
                break;
            case 12:
                $this->setRegionId($value);
                break;
            case 13:
                $this->setAreaId($value);
                break;
            case 14:
                $this->setShopId($value);
                break;
            case 15:
                $this->setCnt($value);
                break;
            case 16:
                $this->setCntToday($value);
                break;
            case 17:
                $this->setCntTel($value);
                break;
            case 18:
                $this->setCntTelToday($value);
                break;
            case 19:
                $this->setCntSkype($value);
                break;
            case 20:
                $this->setCntSite($value);
                break;
            case 21:
                $this->setCoord($value);
                break;
            case 22:
                $this->setSite($value);
                break;
            case 23:
                $this->setSkype($value);
                break;
            case 24:
                $this->setYoutube($value);
                break;
            case 25:
                $this->setDigest($value);
                break;
            case 26:
                $this->setModerApproved($value);
                break;
            case 27:
                $this->setEnabled($value);
                break;
            case 28:
                $this->setDeleted($value);
                break;
            case 29:
                $this->setTwitter($value);
                break;
            case 30:
                $this->setFacebook($value);
                break;
            case 31:
                $this->setVk($value);
                break;
            case 32:
                $this->setVkShare($value);
                break;
            case 33:
                $this->setGoogle($value);
                break;
            case 34:
                $this->setMailru($value);
                break;
            case 35:
                $this->setOdnoklassniki($value);
                break;
            case 36:
                $this->setYandexPartner($value);
                break;
            case 37:
                $this->setUpDate($value);
                break;
            case 38:
                $this->setHlDate($value);
                break;
            case 39:
                $this->setSocialDate($value);
                break;
            case 40:
                $this->setYandexDate($value);
                break;
            case 41:
                $this->setYandexIndexDate($value);
                break;
            case 42:
                $this->setYandexPing($value);
                break;
            case 43:
                $this->setGoogleDate($value);
                break;
            case 44:
                $this->setGoogleIndexDate($value);
                break;
            case 45:
                $this->setCreateDate($value);
                break;
            case 46:
                $this->setPublishDate($value);
                break;
            case 47:
                $this->setPublishBeforeDate($value);
                break;
            case 48:
                $this->setLastViewDate($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = AdvsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUserType($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCompanyName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPhone($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setAlias($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDescription($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPrice($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDogovor($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setTorg($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setRegionId($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setAreaId($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setShopId($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setCnt($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setCntToday($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setCntTel($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setCntTelToday($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setCntSkype($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setCntSite($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setCoord($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setSite($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setSkype($arr[$keys[23]]);
        if (array_key_exists($keys[24], $arr)) $this->setYoutube($arr[$keys[24]]);
        if (array_key_exists($keys[25], $arr)) $this->setDigest($arr[$keys[25]]);
        if (array_key_exists($keys[26], $arr)) $this->setModerApproved($arr[$keys[26]]);
        if (array_key_exists($keys[27], $arr)) $this->setEnabled($arr[$keys[27]]);
        if (array_key_exists($keys[28], $arr)) $this->setDeleted($arr[$keys[28]]);
        if (array_key_exists($keys[29], $arr)) $this->setTwitter($arr[$keys[29]]);
        if (array_key_exists($keys[30], $arr)) $this->setFacebook($arr[$keys[30]]);
        if (array_key_exists($keys[31], $arr)) $this->setVk($arr[$keys[31]]);
        if (array_key_exists($keys[32], $arr)) $this->setVkShare($arr[$keys[32]]);
        if (array_key_exists($keys[33], $arr)) $this->setGoogle($arr[$keys[33]]);
        if (array_key_exists($keys[34], $arr)) $this->setMailru($arr[$keys[34]]);
        if (array_key_exists($keys[35], $arr)) $this->setOdnoklassniki($arr[$keys[35]]);
        if (array_key_exists($keys[36], $arr)) $this->setYandexPartner($arr[$keys[36]]);
        if (array_key_exists($keys[37], $arr)) $this->setUpDate($arr[$keys[37]]);
        if (array_key_exists($keys[38], $arr)) $this->setHlDate($arr[$keys[38]]);
        if (array_key_exists($keys[39], $arr)) $this->setSocialDate($arr[$keys[39]]);
        if (array_key_exists($keys[40], $arr)) $this->setYandexDate($arr[$keys[40]]);
        if (array_key_exists($keys[41], $arr)) $this->setYandexIndexDate($arr[$keys[41]]);
        if (array_key_exists($keys[42], $arr)) $this->setYandexPing($arr[$keys[42]]);
        if (array_key_exists($keys[43], $arr)) $this->setGoogleDate($arr[$keys[43]]);
        if (array_key_exists($keys[44], $arr)) $this->setGoogleIndexDate($arr[$keys[44]]);
        if (array_key_exists($keys[45], $arr)) $this->setCreateDate($arr[$keys[45]]);
        if (array_key_exists($keys[46], $arr)) $this->setPublishDate($arr[$keys[46]]);
        if (array_key_exists($keys[47], $arr)) $this->setPublishBeforeDate($arr[$keys[47]]);
        if (array_key_exists($keys[48], $arr)) $this->setLastViewDate($arr[$keys[48]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AdvsPeer::DATABASE_NAME);

        if ($this->isColumnModified(AdvsPeer::ID)) $criteria->add(AdvsPeer::ID, $this->id);
        if ($this->isColumnModified(AdvsPeer::CATEGORY_ID)) $criteria->add(AdvsPeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(AdvsPeer::USER_ID)) $criteria->add(AdvsPeer::USER_ID, $this->user_id);
        if ($this->isColumnModified(AdvsPeer::USER_TYPE)) $criteria->add(AdvsPeer::USER_TYPE, $this->user_type);
        if ($this->isColumnModified(AdvsPeer::COMPANY_NAME)) $criteria->add(AdvsPeer::COMPANY_NAME, $this->company_name);
        if ($this->isColumnModified(AdvsPeer::PHONE)) $criteria->add(AdvsPeer::PHONE, $this->phone);
        if ($this->isColumnModified(AdvsPeer::NAME)) $criteria->add(AdvsPeer::NAME, $this->name);
        if ($this->isColumnModified(AdvsPeer::ALIAS)) $criteria->add(AdvsPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(AdvsPeer::DESCRIPTION)) $criteria->add(AdvsPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(AdvsPeer::PRICE)) $criteria->add(AdvsPeer::PRICE, $this->price);
        if ($this->isColumnModified(AdvsPeer::DOGOVOR)) $criteria->add(AdvsPeer::DOGOVOR, $this->dogovor);
        if ($this->isColumnModified(AdvsPeer::TORG)) $criteria->add(AdvsPeer::TORG, $this->torg);
        if ($this->isColumnModified(AdvsPeer::REGION_ID)) $criteria->add(AdvsPeer::REGION_ID, $this->region_id);
        if ($this->isColumnModified(AdvsPeer::AREA_ID)) $criteria->add(AdvsPeer::AREA_ID, $this->area_id);
        if ($this->isColumnModified(AdvsPeer::SHOP_ID)) $criteria->add(AdvsPeer::SHOP_ID, $this->shop_id);
        if ($this->isColumnModified(AdvsPeer::CNT)) $criteria->add(AdvsPeer::CNT, $this->cnt);
        if ($this->isColumnModified(AdvsPeer::CNT_TODAY)) $criteria->add(AdvsPeer::CNT_TODAY, $this->cnt_today);
        if ($this->isColumnModified(AdvsPeer::CNT_TEL)) $criteria->add(AdvsPeer::CNT_TEL, $this->cnt_tel);
        if ($this->isColumnModified(AdvsPeer::CNT_TEL_TODAY)) $criteria->add(AdvsPeer::CNT_TEL_TODAY, $this->cnt_tel_today);
        if ($this->isColumnModified(AdvsPeer::CNT_SKYPE)) $criteria->add(AdvsPeer::CNT_SKYPE, $this->cnt_skype);
        if ($this->isColumnModified(AdvsPeer::CNT_SITE)) $criteria->add(AdvsPeer::CNT_SITE, $this->cnt_site);
        if ($this->isColumnModified(AdvsPeer::COORD)) $criteria->add(AdvsPeer::COORD, $this->coord);
        if ($this->isColumnModified(AdvsPeer::SITE)) $criteria->add(AdvsPeer::SITE, $this->site);
        if ($this->isColumnModified(AdvsPeer::SKYPE)) $criteria->add(AdvsPeer::SKYPE, $this->skype);
        if ($this->isColumnModified(AdvsPeer::YOUTUBE)) $criteria->add(AdvsPeer::YOUTUBE, $this->youtube);
        if ($this->isColumnModified(AdvsPeer::DIGEST)) $criteria->add(AdvsPeer::DIGEST, $this->digest);
        if ($this->isColumnModified(AdvsPeer::MODER_APPROVED)) $criteria->add(AdvsPeer::MODER_APPROVED, $this->moder_approved);
        if ($this->isColumnModified(AdvsPeer::ENABLED)) $criteria->add(AdvsPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(AdvsPeer::DELETED)) $criteria->add(AdvsPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(AdvsPeer::TWITTER)) $criteria->add(AdvsPeer::TWITTER, $this->twitter);
        if ($this->isColumnModified(AdvsPeer::FACEBOOK)) $criteria->add(AdvsPeer::FACEBOOK, $this->facebook);
        if ($this->isColumnModified(AdvsPeer::VK)) $criteria->add(AdvsPeer::VK, $this->vk);
        if ($this->isColumnModified(AdvsPeer::VK_SHARE)) $criteria->add(AdvsPeer::VK_SHARE, $this->vk_share);
        if ($this->isColumnModified(AdvsPeer::GOOGLE)) $criteria->add(AdvsPeer::GOOGLE, $this->google);
        if ($this->isColumnModified(AdvsPeer::MAILRU)) $criteria->add(AdvsPeer::MAILRU, $this->mailru);
        if ($this->isColumnModified(AdvsPeer::ODNOKLASSNIKI)) $criteria->add(AdvsPeer::ODNOKLASSNIKI, $this->odnoklassniki);
        if ($this->isColumnModified(AdvsPeer::YANDEX_PARTNER)) $criteria->add(AdvsPeer::YANDEX_PARTNER, $this->yandex_partner);
        if ($this->isColumnModified(AdvsPeer::UP_DATE)) $criteria->add(AdvsPeer::UP_DATE, $this->up_date);
        if ($this->isColumnModified(AdvsPeer::HL_DATE)) $criteria->add(AdvsPeer::HL_DATE, $this->hl_date);
        if ($this->isColumnModified(AdvsPeer::SOCIAL_DATE)) $criteria->add(AdvsPeer::SOCIAL_DATE, $this->social_date);
        if ($this->isColumnModified(AdvsPeer::YANDEX_DATE)) $criteria->add(AdvsPeer::YANDEX_DATE, $this->yandex_date);
        if ($this->isColumnModified(AdvsPeer::YANDEX_INDEX_DATE)) $criteria->add(AdvsPeer::YANDEX_INDEX_DATE, $this->yandex_index_date);
        if ($this->isColumnModified(AdvsPeer::YANDEX_PING)) $criteria->add(AdvsPeer::YANDEX_PING, $this->yandex_ping);
        if ($this->isColumnModified(AdvsPeer::GOOGLE_DATE)) $criteria->add(AdvsPeer::GOOGLE_DATE, $this->google_date);
        if ($this->isColumnModified(AdvsPeer::GOOGLE_INDEX_DATE)) $criteria->add(AdvsPeer::GOOGLE_INDEX_DATE, $this->google_index_date);
        if ($this->isColumnModified(AdvsPeer::CREATE_DATE)) $criteria->add(AdvsPeer::CREATE_DATE, $this->create_date);
        if ($this->isColumnModified(AdvsPeer::PUBLISH_DATE)) $criteria->add(AdvsPeer::PUBLISH_DATE, $this->publish_date);
        if ($this->isColumnModified(AdvsPeer::PUBLISH_BEFORE_DATE)) $criteria->add(AdvsPeer::PUBLISH_BEFORE_DATE, $this->publish_before_date);
        if ($this->isColumnModified(AdvsPeer::LAST_VIEW_DATE)) $criteria->add(AdvsPeer::LAST_VIEW_DATE, $this->last_view_date);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(AdvsPeer::DATABASE_NAME);
        $criteria->add(AdvsPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Advs (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setUserType($this->getUserType());
        $copyObj->setCompanyName($this->getCompanyName());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setName($this->getName());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setDogovor($this->getDogovor());
        $copyObj->setTorg($this->getTorg());
        $copyObj->setRegionId($this->getRegionId());
        $copyObj->setAreaId($this->getAreaId());
        $copyObj->setShopId($this->getShopId());
        $copyObj->setCnt($this->getCnt());
        $copyObj->setCntToday($this->getCntToday());
        $copyObj->setCntTel($this->getCntTel());
        $copyObj->setCntTelToday($this->getCntTelToday());
        $copyObj->setCntSkype($this->getCntSkype());
        $copyObj->setCntSite($this->getCntSite());
        $copyObj->setCoord($this->getCoord());
        $copyObj->setSite($this->getSite());
        $copyObj->setSkype($this->getSkype());
        $copyObj->setYoutube($this->getYoutube());
        $copyObj->setDigest($this->getDigest());
        $copyObj->setModerApproved($this->getModerApproved());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setDeleted($this->getDeleted());
        $copyObj->setTwitter($this->getTwitter());
        $copyObj->setFacebook($this->getFacebook());
        $copyObj->setVk($this->getVk());
        $copyObj->setVkShare($this->getVkShare());
        $copyObj->setGoogle($this->getGoogle());
        $copyObj->setMailru($this->getMailru());
        $copyObj->setOdnoklassniki($this->getOdnoklassniki());
        $copyObj->setYandexPartner($this->getYandexPartner());
        $copyObj->setUpDate($this->getUpDate());
        $copyObj->setHlDate($this->getHlDate());
        $copyObj->setSocialDate($this->getSocialDate());
        $copyObj->setYandexDate($this->getYandexDate());
        $copyObj->setYandexIndexDate($this->getYandexIndexDate());
        $copyObj->setYandexPing($this->getYandexPing());
        $copyObj->setGoogleDate($this->getGoogleDate());
        $copyObj->setGoogleIndexDate($this->getGoogleIndexDate());
        $copyObj->setCreateDate($this->getCreateDate());
        $copyObj->setPublishDate($this->getPublishDate());
        $copyObj->setPublishBeforeDate($this->getPublishBeforeDate());
        $copyObj->setLastViewDate($this->getLastViewDate());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAdvPrices() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvPrice($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvsStats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvsStat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvsModerStats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvsModerStat($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvParamss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvParams($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvImagess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvImages($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvVideoss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvVideos($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvPacketss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvPackets($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvCommentss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvComments($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvComplaines() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvComplaine($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUserFavorites() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserFavorite($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Advs Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return AdvsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AdvsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Regions object.
     *
     * @param                  Regions $v
     * @return Advs The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRegions(Regions $v = null)
    {
        if ($v === null) {
            $this->setRegionId(NULL);
        } else {
            $this->setRegionId($v->getId());
        }

        $this->aRegions = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Regions object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvs($this);
        }


        return $this;
    }


    /**
     * Get the associated Regions object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Regions The associated Regions object.
     * @throws PropelException
     */
    public function getRegions(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aRegions === null && ($this->region_id !== null) && $doQuery) {
            $this->aRegions = RegionsQuery::create()->findPk($this->region_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRegions->addAdvss($this);
             */
        }

        return $this->aRegions;
    }

    /**
     * Declares an association between this object and a Areas object.
     *
     * @param                  Areas $v
     * @return Advs The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAreas(Areas $v = null)
    {
        if ($v === null) {
            $this->setAreaId(NULL);
        } else {
            $this->setAreaId($v->getId());
        }

        $this->aAreas = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Areas object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvs($this);
        }


        return $this;
    }


    /**
     * Get the associated Areas object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Areas The associated Areas object.
     * @throws PropelException
     */
    public function getAreas(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAreas === null && ($this->area_id !== null) && $doQuery) {
            $this->aAreas = AreasQuery::create()->findPk($this->area_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAreas->addAdvss($this);
             */
        }

        return $this->aAreas;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param                  User $v
     * @return Advs The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvs($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUser === null && ($this->user_id !== null) && $doQuery) {
            $this->aUser = UserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addAdvss($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a Shops object.
     *
     * @param                  Shops $v
     * @return Advs The current object (for fluent API support)
     * @throws PropelException
     */
    public function setShops(Shops $v = null)
    {
        if ($v === null) {
            $this->setShopId(NULL);
        } else {
            $this->setShopId($v->getId());
        }

        $this->aShops = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Shops object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvs($this);
        }


        return $this;
    }


    /**
     * Get the associated Shops object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Shops The associated Shops object.
     * @throws PropelException
     */
    public function getShops(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aShops === null && ($this->shop_id !== null) && $doQuery) {
            $this->aShops = ShopsQuery::create()->findPk($this->shop_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aShops->addAdvss($this);
             */
        }

        return $this->aShops;
    }

    /**
     * Declares an association between this object and a AdCategories object.
     *
     * @param                  AdCategories $v
     * @return Advs The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdCategories(AdCategories $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aAdCategories = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AdCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvs($this);
        }


        return $this;
    }


    /**
     * Get the associated AdCategories object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return AdCategories The associated AdCategories object.
     * @throws PropelException
     */
    public function getAdCategories(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdCategories === null && ($this->category_id !== null) && $doQuery) {
            $this->aAdCategories = AdCategoriesQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdCategories->addAdvss($this);
             */
        }

        return $this->aAdCategories;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AdvPrice' == $relationName) {
            $this->initAdvPrices();
        }
        if ('AdvsStat' == $relationName) {
            $this->initAdvsStats();
        }
        if ('AdvsModerStat' == $relationName) {
            $this->initAdvsModerStats();
        }
        if ('AdvParams' == $relationName) {
            $this->initAdvParamss();
        }
        if ('AdvImages' == $relationName) {
            $this->initAdvImagess();
        }
        if ('AdvVideos' == $relationName) {
            $this->initAdvVideoss();
        }
        if ('AdvPackets' == $relationName) {
            $this->initAdvPacketss();
        }
        if ('AdvComments' == $relationName) {
            $this->initAdvCommentss();
        }
        if ('AdvComplaine' == $relationName) {
            $this->initAdvComplaines();
        }
        if ('UserFavorite' == $relationName) {
            $this->initUserFavorites();
        }
    }

    /**
     * Clears out the collAdvPrices collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvPrices()
     */
    public function clearAdvPrices()
    {
        $this->collAdvPrices = null; // important to set this to null since that means it is uninitialized
        $this->collAdvPricesPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvPrices collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvPrices($v = true)
    {
        $this->collAdvPricesPartial = $v;
    }

    /**
     * Initializes the collAdvPrices collection.
     *
     * By default this just sets the collAdvPrices collection to an empty array (like clearcollAdvPrices());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvPrices($overrideExisting = true)
    {
        if (null !== $this->collAdvPrices && !$overrideExisting) {
            return;
        }
        $this->collAdvPrices = new PropelObjectCollection();
        $this->collAdvPrices->setModel('AdvPrice');
    }

    /**
     * Gets an array of AdvPrice objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvPrice[] List of AdvPrice objects
     * @throws PropelException
     */
    public function getAdvPrices($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvPricesPartial && !$this->isNew();
        if (null === $this->collAdvPrices || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvPrices) {
                // return empty collection
                $this->initAdvPrices();
            } else {
                $collAdvPrices = AdvPriceQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvPricesPartial && count($collAdvPrices)) {
                      $this->initAdvPrices(false);

                      foreach ($collAdvPrices as $obj) {
                        if (false == $this->collAdvPrices->contains($obj)) {
                          $this->collAdvPrices->append($obj);
                        }
                      }

                      $this->collAdvPricesPartial = true;
                    }

                    $collAdvPrices->getInternalIterator()->rewind();

                    return $collAdvPrices;
                }

                if ($partial && $this->collAdvPrices) {
                    foreach ($this->collAdvPrices as $obj) {
                        if ($obj->isNew()) {
                            $collAdvPrices[] = $obj;
                        }
                    }
                }

                $this->collAdvPrices = $collAdvPrices;
                $this->collAdvPricesPartial = false;
            }
        }

        return $this->collAdvPrices;
    }

    /**
     * Sets a collection of AdvPrice objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advPrices A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvPrices(PropelCollection $advPrices, PropelPDO $con = null)
    {
        $advPricesToDelete = $this->getAdvPrices(new Criteria(), $con)->diff($advPrices);


        $this->advPricesScheduledForDeletion = $advPricesToDelete;

        foreach ($advPricesToDelete as $advPriceRemoved) {
            $advPriceRemoved->setAdvs(null);
        }

        $this->collAdvPrices = null;
        foreach ($advPrices as $advPrice) {
            $this->addAdvPrice($advPrice);
        }

        $this->collAdvPrices = $advPrices;
        $this->collAdvPricesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvPrice objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvPrice objects.
     * @throws PropelException
     */
    public function countAdvPrices(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvPricesPartial && !$this->isNew();
        if (null === $this->collAdvPrices || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvPrices) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvPrices());
            }
            $query = AdvPriceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvPrices);
    }

    /**
     * Method called to associate a AdvPrice object to this object
     * through the AdvPrice foreign key attribute.
     *
     * @param    AdvPrice $l AdvPrice
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvPrice(AdvPrice $l)
    {
        if ($this->collAdvPrices === null) {
            $this->initAdvPrices();
            $this->collAdvPricesPartial = true;
        }

        if (!in_array($l, $this->collAdvPrices->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvPrice($l);

            if ($this->advPricesScheduledForDeletion and $this->advPricesScheduledForDeletion->contains($l)) {
                $this->advPricesScheduledForDeletion->remove($this->advPricesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvPrice $advPrice The advPrice object to add.
     */
    protected function doAddAdvPrice($advPrice)
    {
        $this->collAdvPrices[]= $advPrice;
        $advPrice->setAdvs($this);
    }

    /**
     * @param	AdvPrice $advPrice The advPrice object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvPrice($advPrice)
    {
        if ($this->getAdvPrices()->contains($advPrice)) {
            $this->collAdvPrices->remove($this->collAdvPrices->search($advPrice));
            if (null === $this->advPricesScheduledForDeletion) {
                $this->advPricesScheduledForDeletion = clone $this->collAdvPrices;
                $this->advPricesScheduledForDeletion->clear();
            }
            $this->advPricesScheduledForDeletion[]= clone $advPrice;
            $advPrice->setAdvs(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdvsStats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvsStats()
     */
    public function clearAdvsStats()
    {
        $this->collAdvsStats = null; // important to set this to null since that means it is uninitialized
        $this->collAdvsStatsPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvsStats collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvsStats($v = true)
    {
        $this->collAdvsStatsPartial = $v;
    }

    /**
     * Initializes the collAdvsStats collection.
     *
     * By default this just sets the collAdvsStats collection to an empty array (like clearcollAdvsStats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvsStats($overrideExisting = true)
    {
        if (null !== $this->collAdvsStats && !$overrideExisting) {
            return;
        }
        $this->collAdvsStats = new PropelObjectCollection();
        $this->collAdvsStats->setModel('AdvsStat');
    }

    /**
     * Gets an array of AdvsStat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvsStat[] List of AdvsStat objects
     * @throws PropelException
     */
    public function getAdvsStats($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvsStatsPartial && !$this->isNew();
        if (null === $this->collAdvsStats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvsStats) {
                // return empty collection
                $this->initAdvsStats();
            } else {
                $collAdvsStats = AdvsStatQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvsStatsPartial && count($collAdvsStats)) {
                      $this->initAdvsStats(false);

                      foreach ($collAdvsStats as $obj) {
                        if (false == $this->collAdvsStats->contains($obj)) {
                          $this->collAdvsStats->append($obj);
                        }
                      }

                      $this->collAdvsStatsPartial = true;
                    }

                    $collAdvsStats->getInternalIterator()->rewind();

                    return $collAdvsStats;
                }

                if ($partial && $this->collAdvsStats) {
                    foreach ($this->collAdvsStats as $obj) {
                        if ($obj->isNew()) {
                            $collAdvsStats[] = $obj;
                        }
                    }
                }

                $this->collAdvsStats = $collAdvsStats;
                $this->collAdvsStatsPartial = false;
            }
        }

        return $this->collAdvsStats;
    }

    /**
     * Sets a collection of AdvsStat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advsStats A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvsStats(PropelCollection $advsStats, PropelPDO $con = null)
    {
        $advsStatsToDelete = $this->getAdvsStats(new Criteria(), $con)->diff($advsStats);


        $this->advsStatsScheduledForDeletion = $advsStatsToDelete;

        foreach ($advsStatsToDelete as $advsStatRemoved) {
            $advsStatRemoved->setAdvs(null);
        }

        $this->collAdvsStats = null;
        foreach ($advsStats as $advsStat) {
            $this->addAdvsStat($advsStat);
        }

        $this->collAdvsStats = $advsStats;
        $this->collAdvsStatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvsStat objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvsStat objects.
     * @throws PropelException
     */
    public function countAdvsStats(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvsStatsPartial && !$this->isNew();
        if (null === $this->collAdvsStats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvsStats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvsStats());
            }
            $query = AdvsStatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvsStats);
    }

    /**
     * Method called to associate a AdvsStat object to this object
     * through the AdvsStat foreign key attribute.
     *
     * @param    AdvsStat $l AdvsStat
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvsStat(AdvsStat $l)
    {
        if ($this->collAdvsStats === null) {
            $this->initAdvsStats();
            $this->collAdvsStatsPartial = true;
        }

        if (!in_array($l, $this->collAdvsStats->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvsStat($l);

            if ($this->advsStatsScheduledForDeletion and $this->advsStatsScheduledForDeletion->contains($l)) {
                $this->advsStatsScheduledForDeletion->remove($this->advsStatsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvsStat $advsStat The advsStat object to add.
     */
    protected function doAddAdvsStat($advsStat)
    {
        $this->collAdvsStats[]= $advsStat;
        $advsStat->setAdvs($this);
    }

    /**
     * @param	AdvsStat $advsStat The advsStat object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvsStat($advsStat)
    {
        if ($this->getAdvsStats()->contains($advsStat)) {
            $this->collAdvsStats->remove($this->collAdvsStats->search($advsStat));
            if (null === $this->advsStatsScheduledForDeletion) {
                $this->advsStatsScheduledForDeletion = clone $this->collAdvsStats;
                $this->advsStatsScheduledForDeletion->clear();
            }
            $this->advsStatsScheduledForDeletion[]= clone $advsStat;
            $advsStat->setAdvs(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdvsModerStats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvsModerStats()
     */
    public function clearAdvsModerStats()
    {
        $this->collAdvsModerStats = null; // important to set this to null since that means it is uninitialized
        $this->collAdvsModerStatsPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvsModerStats collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvsModerStats($v = true)
    {
        $this->collAdvsModerStatsPartial = $v;
    }

    /**
     * Initializes the collAdvsModerStats collection.
     *
     * By default this just sets the collAdvsModerStats collection to an empty array (like clearcollAdvsModerStats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvsModerStats($overrideExisting = true)
    {
        if (null !== $this->collAdvsModerStats && !$overrideExisting) {
            return;
        }
        $this->collAdvsModerStats = new PropelObjectCollection();
        $this->collAdvsModerStats->setModel('AdvsModerStat');
    }

    /**
     * Gets an array of AdvsModerStat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvsModerStat[] List of AdvsModerStat objects
     * @throws PropelException
     */
    public function getAdvsModerStats($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvsModerStatsPartial && !$this->isNew();
        if (null === $this->collAdvsModerStats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvsModerStats) {
                // return empty collection
                $this->initAdvsModerStats();
            } else {
                $collAdvsModerStats = AdvsModerStatQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvsModerStatsPartial && count($collAdvsModerStats)) {
                      $this->initAdvsModerStats(false);

                      foreach ($collAdvsModerStats as $obj) {
                        if (false == $this->collAdvsModerStats->contains($obj)) {
                          $this->collAdvsModerStats->append($obj);
                        }
                      }

                      $this->collAdvsModerStatsPartial = true;
                    }

                    $collAdvsModerStats->getInternalIterator()->rewind();

                    return $collAdvsModerStats;
                }

                if ($partial && $this->collAdvsModerStats) {
                    foreach ($this->collAdvsModerStats as $obj) {
                        if ($obj->isNew()) {
                            $collAdvsModerStats[] = $obj;
                        }
                    }
                }

                $this->collAdvsModerStats = $collAdvsModerStats;
                $this->collAdvsModerStatsPartial = false;
            }
        }

        return $this->collAdvsModerStats;
    }

    /**
     * Sets a collection of AdvsModerStat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advsModerStats A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvsModerStats(PropelCollection $advsModerStats, PropelPDO $con = null)
    {
        $advsModerStatsToDelete = $this->getAdvsModerStats(new Criteria(), $con)->diff($advsModerStats);


        $this->advsModerStatsScheduledForDeletion = $advsModerStatsToDelete;

        foreach ($advsModerStatsToDelete as $advsModerStatRemoved) {
            $advsModerStatRemoved->setAdvs(null);
        }

        $this->collAdvsModerStats = null;
        foreach ($advsModerStats as $advsModerStat) {
            $this->addAdvsModerStat($advsModerStat);
        }

        $this->collAdvsModerStats = $advsModerStats;
        $this->collAdvsModerStatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvsModerStat objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvsModerStat objects.
     * @throws PropelException
     */
    public function countAdvsModerStats(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvsModerStatsPartial && !$this->isNew();
        if (null === $this->collAdvsModerStats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvsModerStats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvsModerStats());
            }
            $query = AdvsModerStatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvsModerStats);
    }

    /**
     * Method called to associate a AdvsModerStat object to this object
     * through the AdvsModerStat foreign key attribute.
     *
     * @param    AdvsModerStat $l AdvsModerStat
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvsModerStat(AdvsModerStat $l)
    {
        if ($this->collAdvsModerStats === null) {
            $this->initAdvsModerStats();
            $this->collAdvsModerStatsPartial = true;
        }

        if (!in_array($l, $this->collAdvsModerStats->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvsModerStat($l);

            if ($this->advsModerStatsScheduledForDeletion and $this->advsModerStatsScheduledForDeletion->contains($l)) {
                $this->advsModerStatsScheduledForDeletion->remove($this->advsModerStatsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvsModerStat $advsModerStat The advsModerStat object to add.
     */
    protected function doAddAdvsModerStat($advsModerStat)
    {
        $this->collAdvsModerStats[]= $advsModerStat;
        $advsModerStat->setAdvs($this);
    }

    /**
     * @param	AdvsModerStat $advsModerStat The advsModerStat object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvsModerStat($advsModerStat)
    {
        if ($this->getAdvsModerStats()->contains($advsModerStat)) {
            $this->collAdvsModerStats->remove($this->collAdvsModerStats->search($advsModerStat));
            if (null === $this->advsModerStatsScheduledForDeletion) {
                $this->advsModerStatsScheduledForDeletion = clone $this->collAdvsModerStats;
                $this->advsModerStatsScheduledForDeletion->clear();
            }
            $this->advsModerStatsScheduledForDeletion[]= clone $advsModerStat;
            $advsModerStat->setAdvs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related AdvsModerStats from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvsModerStat[] List of AdvsModerStat objects
     */
    public function getAdvsModerStatsJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvsModerStatQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getAdvsModerStats($query, $con);
    }

    /**
     * Clears out the collAdvParamss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvParamss()
     */
    public function clearAdvParamss()
    {
        $this->collAdvParamss = null; // important to set this to null since that means it is uninitialized
        $this->collAdvParamssPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvParamss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvParamss($v = true)
    {
        $this->collAdvParamssPartial = $v;
    }

    /**
     * Initializes the collAdvParamss collection.
     *
     * By default this just sets the collAdvParamss collection to an empty array (like clearcollAdvParamss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvParamss($overrideExisting = true)
    {
        if (null !== $this->collAdvParamss && !$overrideExisting) {
            return;
        }
        $this->collAdvParamss = new PropelObjectCollection();
        $this->collAdvParamss->setModel('AdvParams');
    }

    /**
     * Gets an array of AdvParams objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvParams[] List of AdvParams objects
     * @throws PropelException
     */
    public function getAdvParamss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvParamssPartial && !$this->isNew();
        if (null === $this->collAdvParamss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvParamss) {
                // return empty collection
                $this->initAdvParamss();
            } else {
                $collAdvParamss = AdvParamsQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvParamssPartial && count($collAdvParamss)) {
                      $this->initAdvParamss(false);

                      foreach ($collAdvParamss as $obj) {
                        if (false == $this->collAdvParamss->contains($obj)) {
                          $this->collAdvParamss->append($obj);
                        }
                      }

                      $this->collAdvParamssPartial = true;
                    }

                    $collAdvParamss->getInternalIterator()->rewind();

                    return $collAdvParamss;
                }

                if ($partial && $this->collAdvParamss) {
                    foreach ($this->collAdvParamss as $obj) {
                        if ($obj->isNew()) {
                            $collAdvParamss[] = $obj;
                        }
                    }
                }

                $this->collAdvParamss = $collAdvParamss;
                $this->collAdvParamssPartial = false;
            }
        }

        return $this->collAdvParamss;
    }

    /**
     * Sets a collection of AdvParams objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advParamss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvParamss(PropelCollection $advParamss, PropelPDO $con = null)
    {
        $advParamssToDelete = $this->getAdvParamss(new Criteria(), $con)->diff($advParamss);


        $this->advParamssScheduledForDeletion = $advParamssToDelete;

        foreach ($advParamssToDelete as $advParamsRemoved) {
            $advParamsRemoved->setAdvs(null);
        }

        $this->collAdvParamss = null;
        foreach ($advParamss as $advParams) {
            $this->addAdvParams($advParams);
        }

        $this->collAdvParamss = $advParamss;
        $this->collAdvParamssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvParams objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvParams objects.
     * @throws PropelException
     */
    public function countAdvParamss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvParamssPartial && !$this->isNew();
        if (null === $this->collAdvParamss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvParamss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvParamss());
            }
            $query = AdvParamsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvParamss);
    }

    /**
     * Method called to associate a AdvParams object to this object
     * through the AdvParams foreign key attribute.
     *
     * @param    AdvParams $l AdvParams
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvParams(AdvParams $l)
    {
        if ($this->collAdvParamss === null) {
            $this->initAdvParamss();
            $this->collAdvParamssPartial = true;
        }

        if (!in_array($l, $this->collAdvParamss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvParams($l);

            if ($this->advParamssScheduledForDeletion and $this->advParamssScheduledForDeletion->contains($l)) {
                $this->advParamssScheduledForDeletion->remove($this->advParamssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvParams $advParams The advParams object to add.
     */
    protected function doAddAdvParams($advParams)
    {
        $this->collAdvParamss[]= $advParams;
        $advParams->setAdvs($this);
    }

    /**
     * @param	AdvParams $advParams The advParams object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvParams($advParams)
    {
        if ($this->getAdvParamss()->contains($advParams)) {
            $this->collAdvParamss->remove($this->collAdvParamss->search($advParams));
            if (null === $this->advParamssScheduledForDeletion) {
                $this->advParamssScheduledForDeletion = clone $this->collAdvParamss;
                $this->advParamssScheduledForDeletion->clear();
            }
            $this->advParamssScheduledForDeletion[]= clone $advParams;
            $advParams->setAdvs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related AdvParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvParams[] List of AdvParams objects
     */
    public function getAdvParamssJoinAdCategoriesFields($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvParamsQuery::create(null, $criteria);
        $query->joinWith('AdCategoriesFields', $join_behavior);

        return $this->getAdvParamss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related AdvParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvParams[] List of AdvParams objects
     */
    public function getAdvParamssJoinAdCategoriesFieldsValues($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvParamsQuery::create(null, $criteria);
        $query->joinWith('AdCategoriesFieldsValues', $join_behavior);

        return $this->getAdvParamss($query, $con);
    }

    /**
     * Clears out the collAdvImagess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvImagess()
     */
    public function clearAdvImagess()
    {
        $this->collAdvImagess = null; // important to set this to null since that means it is uninitialized
        $this->collAdvImagessPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvImagess collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvImagess($v = true)
    {
        $this->collAdvImagessPartial = $v;
    }

    /**
     * Initializes the collAdvImagess collection.
     *
     * By default this just sets the collAdvImagess collection to an empty array (like clearcollAdvImagess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvImagess($overrideExisting = true)
    {
        if (null !== $this->collAdvImagess && !$overrideExisting) {
            return;
        }
        $this->collAdvImagess = new PropelObjectCollection();
        $this->collAdvImagess->setModel('AdvImages');
    }

    /**
     * Gets an array of AdvImages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvImages[] List of AdvImages objects
     * @throws PropelException
     */
    public function getAdvImagess($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvImagessPartial && !$this->isNew();
        if (null === $this->collAdvImagess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvImagess) {
                // return empty collection
                $this->initAdvImagess();
            } else {
                $collAdvImagess = AdvImagesQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvImagessPartial && count($collAdvImagess)) {
                      $this->initAdvImagess(false);

                      foreach ($collAdvImagess as $obj) {
                        if (false == $this->collAdvImagess->contains($obj)) {
                          $this->collAdvImagess->append($obj);
                        }
                      }

                      $this->collAdvImagessPartial = true;
                    }

                    $collAdvImagess->getInternalIterator()->rewind();

                    return $collAdvImagess;
                }

                if ($partial && $this->collAdvImagess) {
                    foreach ($this->collAdvImagess as $obj) {
                        if ($obj->isNew()) {
                            $collAdvImagess[] = $obj;
                        }
                    }
                }

                $this->collAdvImagess = $collAdvImagess;
                $this->collAdvImagessPartial = false;
            }
        }

        return $this->collAdvImagess;
    }

    /**
     * Sets a collection of AdvImages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advImagess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvImagess(PropelCollection $advImagess, PropelPDO $con = null)
    {
        $advImagessToDelete = $this->getAdvImagess(new Criteria(), $con)->diff($advImagess);


        $this->advImagessScheduledForDeletion = $advImagessToDelete;

        foreach ($advImagessToDelete as $advImagesRemoved) {
            $advImagesRemoved->setAdvs(null);
        }

        $this->collAdvImagess = null;
        foreach ($advImagess as $advImages) {
            $this->addAdvImages($advImages);
        }

        $this->collAdvImagess = $advImagess;
        $this->collAdvImagessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvImages objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvImages objects.
     * @throws PropelException
     */
    public function countAdvImagess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvImagessPartial && !$this->isNew();
        if (null === $this->collAdvImagess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvImagess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvImagess());
            }
            $query = AdvImagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvImagess);
    }

    /**
     * Method called to associate a AdvImages object to this object
     * through the AdvImages foreign key attribute.
     *
     * @param    AdvImages $l AdvImages
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvImages(AdvImages $l)
    {
        if ($this->collAdvImagess === null) {
            $this->initAdvImagess();
            $this->collAdvImagessPartial = true;
        }

        if (!in_array($l, $this->collAdvImagess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvImages($l);

            if ($this->advImagessScheduledForDeletion and $this->advImagessScheduledForDeletion->contains($l)) {
                $this->advImagessScheduledForDeletion->remove($this->advImagessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvImages $advImages The advImages object to add.
     */
    protected function doAddAdvImages($advImages)
    {
        $this->collAdvImagess[]= $advImages;
        $advImages->setAdvs($this);
    }

    /**
     * @param	AdvImages $advImages The advImages object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvImages($advImages)
    {
        if ($this->getAdvImagess()->contains($advImages)) {
            $this->collAdvImagess->remove($this->collAdvImagess->search($advImages));
            if (null === $this->advImagessScheduledForDeletion) {
                $this->advImagessScheduledForDeletion = clone $this->collAdvImagess;
                $this->advImagessScheduledForDeletion->clear();
            }
            $this->advImagessScheduledForDeletion[]= $advImages;
            $advImages->setAdvs(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdvVideoss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvVideoss()
     */
    public function clearAdvVideoss()
    {
        $this->collAdvVideoss = null; // important to set this to null since that means it is uninitialized
        $this->collAdvVideossPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvVideoss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvVideoss($v = true)
    {
        $this->collAdvVideossPartial = $v;
    }

    /**
     * Initializes the collAdvVideoss collection.
     *
     * By default this just sets the collAdvVideoss collection to an empty array (like clearcollAdvVideoss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvVideoss($overrideExisting = true)
    {
        if (null !== $this->collAdvVideoss && !$overrideExisting) {
            return;
        }
        $this->collAdvVideoss = new PropelObjectCollection();
        $this->collAdvVideoss->setModel('AdvVideos');
    }

    /**
     * Gets an array of AdvVideos objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvVideos[] List of AdvVideos objects
     * @throws PropelException
     */
    public function getAdvVideoss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvVideossPartial && !$this->isNew();
        if (null === $this->collAdvVideoss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvVideoss) {
                // return empty collection
                $this->initAdvVideoss();
            } else {
                $collAdvVideoss = AdvVideosQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvVideossPartial && count($collAdvVideoss)) {
                      $this->initAdvVideoss(false);

                      foreach ($collAdvVideoss as $obj) {
                        if (false == $this->collAdvVideoss->contains($obj)) {
                          $this->collAdvVideoss->append($obj);
                        }
                      }

                      $this->collAdvVideossPartial = true;
                    }

                    $collAdvVideoss->getInternalIterator()->rewind();

                    return $collAdvVideoss;
                }

                if ($partial && $this->collAdvVideoss) {
                    foreach ($this->collAdvVideoss as $obj) {
                        if ($obj->isNew()) {
                            $collAdvVideoss[] = $obj;
                        }
                    }
                }

                $this->collAdvVideoss = $collAdvVideoss;
                $this->collAdvVideossPartial = false;
            }
        }

        return $this->collAdvVideoss;
    }

    /**
     * Sets a collection of AdvVideos objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advVideoss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvVideoss(PropelCollection $advVideoss, PropelPDO $con = null)
    {
        $advVideossToDelete = $this->getAdvVideoss(new Criteria(), $con)->diff($advVideoss);


        $this->advVideossScheduledForDeletion = $advVideossToDelete;

        foreach ($advVideossToDelete as $advVideosRemoved) {
            $advVideosRemoved->setAdvs(null);
        }

        $this->collAdvVideoss = null;
        foreach ($advVideoss as $advVideos) {
            $this->addAdvVideos($advVideos);
        }

        $this->collAdvVideoss = $advVideoss;
        $this->collAdvVideossPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvVideos objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvVideos objects.
     * @throws PropelException
     */
    public function countAdvVideoss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvVideossPartial && !$this->isNew();
        if (null === $this->collAdvVideoss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvVideoss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvVideoss());
            }
            $query = AdvVideosQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvVideoss);
    }

    /**
     * Method called to associate a AdvVideos object to this object
     * through the AdvVideos foreign key attribute.
     *
     * @param    AdvVideos $l AdvVideos
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvVideos(AdvVideos $l)
    {
        if ($this->collAdvVideoss === null) {
            $this->initAdvVideoss();
            $this->collAdvVideossPartial = true;
        }

        if (!in_array($l, $this->collAdvVideoss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvVideos($l);

            if ($this->advVideossScheduledForDeletion and $this->advVideossScheduledForDeletion->contains($l)) {
                $this->advVideossScheduledForDeletion->remove($this->advVideossScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvVideos $advVideos The advVideos object to add.
     */
    protected function doAddAdvVideos($advVideos)
    {
        $this->collAdvVideoss[]= $advVideos;
        $advVideos->setAdvs($this);
    }

    /**
     * @param	AdvVideos $advVideos The advVideos object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvVideos($advVideos)
    {
        if ($this->getAdvVideoss()->contains($advVideos)) {
            $this->collAdvVideoss->remove($this->collAdvVideoss->search($advVideos));
            if (null === $this->advVideossScheduledForDeletion) {
                $this->advVideossScheduledForDeletion = clone $this->collAdvVideoss;
                $this->advVideossScheduledForDeletion->clear();
            }
            $this->advVideossScheduledForDeletion[]= $advVideos;
            $advVideos->setAdvs(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdvPacketss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvPacketss()
     */
    public function clearAdvPacketss()
    {
        $this->collAdvPacketss = null; // important to set this to null since that means it is uninitialized
        $this->collAdvPacketssPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvPacketss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvPacketss($v = true)
    {
        $this->collAdvPacketssPartial = $v;
    }

    /**
     * Initializes the collAdvPacketss collection.
     *
     * By default this just sets the collAdvPacketss collection to an empty array (like clearcollAdvPacketss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvPacketss($overrideExisting = true)
    {
        if (null !== $this->collAdvPacketss && !$overrideExisting) {
            return;
        }
        $this->collAdvPacketss = new PropelObjectCollection();
        $this->collAdvPacketss->setModel('AdvPackets');
    }

    /**
     * Gets an array of AdvPackets objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvPackets[] List of AdvPackets objects
     * @throws PropelException
     */
    public function getAdvPacketss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvPacketssPartial && !$this->isNew();
        if (null === $this->collAdvPacketss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvPacketss) {
                // return empty collection
                $this->initAdvPacketss();
            } else {
                $collAdvPacketss = AdvPacketsQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvPacketssPartial && count($collAdvPacketss)) {
                      $this->initAdvPacketss(false);

                      foreach ($collAdvPacketss as $obj) {
                        if (false == $this->collAdvPacketss->contains($obj)) {
                          $this->collAdvPacketss->append($obj);
                        }
                      }

                      $this->collAdvPacketssPartial = true;
                    }

                    $collAdvPacketss->getInternalIterator()->rewind();

                    return $collAdvPacketss;
                }

                if ($partial && $this->collAdvPacketss) {
                    foreach ($this->collAdvPacketss as $obj) {
                        if ($obj->isNew()) {
                            $collAdvPacketss[] = $obj;
                        }
                    }
                }

                $this->collAdvPacketss = $collAdvPacketss;
                $this->collAdvPacketssPartial = false;
            }
        }

        return $this->collAdvPacketss;
    }

    /**
     * Sets a collection of AdvPackets objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advPacketss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvPacketss(PropelCollection $advPacketss, PropelPDO $con = null)
    {
        $advPacketssToDelete = $this->getAdvPacketss(new Criteria(), $con)->diff($advPacketss);


        $this->advPacketssScheduledForDeletion = $advPacketssToDelete;

        foreach ($advPacketssToDelete as $advPacketsRemoved) {
            $advPacketsRemoved->setAdvs(null);
        }

        $this->collAdvPacketss = null;
        foreach ($advPacketss as $advPackets) {
            $this->addAdvPackets($advPackets);
        }

        $this->collAdvPacketss = $advPacketss;
        $this->collAdvPacketssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvPackets objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvPackets objects.
     * @throws PropelException
     */
    public function countAdvPacketss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvPacketssPartial && !$this->isNew();
        if (null === $this->collAdvPacketss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvPacketss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvPacketss());
            }
            $query = AdvPacketsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvPacketss);
    }

    /**
     * Method called to associate a AdvPackets object to this object
     * through the AdvPackets foreign key attribute.
     *
     * @param    AdvPackets $l AdvPackets
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvPackets(AdvPackets $l)
    {
        if ($this->collAdvPacketss === null) {
            $this->initAdvPacketss();
            $this->collAdvPacketssPartial = true;
        }

        if (!in_array($l, $this->collAdvPacketss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvPackets($l);

            if ($this->advPacketssScheduledForDeletion and $this->advPacketssScheduledForDeletion->contains($l)) {
                $this->advPacketssScheduledForDeletion->remove($this->advPacketssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvPackets $advPackets The advPackets object to add.
     */
    protected function doAddAdvPackets($advPackets)
    {
        $this->collAdvPacketss[]= $advPackets;
        $advPackets->setAdvs($this);
    }

    /**
     * @param	AdvPackets $advPackets The advPackets object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvPackets($advPackets)
    {
        if ($this->getAdvPacketss()->contains($advPackets)) {
            $this->collAdvPacketss->remove($this->collAdvPacketss->search($advPackets));
            if (null === $this->advPacketssScheduledForDeletion) {
                $this->advPacketssScheduledForDeletion = clone $this->collAdvPacketss;
                $this->advPacketssScheduledForDeletion->clear();
            }
            $this->advPacketssScheduledForDeletion[]= clone $advPackets;
            $advPackets->setAdvs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related AdvPacketss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvPackets[] List of AdvPackets objects
     */
    public function getAdvPacketssJoinPackets($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvPacketsQuery::create(null, $criteria);
        $query->joinWith('Packets', $join_behavior);

        return $this->getAdvPacketss($query, $con);
    }

    /**
     * Clears out the collAdvCommentss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvCommentss()
     */
    public function clearAdvCommentss()
    {
        $this->collAdvCommentss = null; // important to set this to null since that means it is uninitialized
        $this->collAdvCommentssPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvCommentss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvCommentss($v = true)
    {
        $this->collAdvCommentssPartial = $v;
    }

    /**
     * Initializes the collAdvCommentss collection.
     *
     * By default this just sets the collAdvCommentss collection to an empty array (like clearcollAdvCommentss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvCommentss($overrideExisting = true)
    {
        if (null !== $this->collAdvCommentss && !$overrideExisting) {
            return;
        }
        $this->collAdvCommentss = new PropelObjectCollection();
        $this->collAdvCommentss->setModel('AdvComments');
    }

    /**
     * Gets an array of AdvComments objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvComments[] List of AdvComments objects
     * @throws PropelException
     */
    public function getAdvCommentss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvCommentssPartial && !$this->isNew();
        if (null === $this->collAdvCommentss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvCommentss) {
                // return empty collection
                $this->initAdvCommentss();
            } else {
                $collAdvCommentss = AdvCommentsQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvCommentssPartial && count($collAdvCommentss)) {
                      $this->initAdvCommentss(false);

                      foreach ($collAdvCommentss as $obj) {
                        if (false == $this->collAdvCommentss->contains($obj)) {
                          $this->collAdvCommentss->append($obj);
                        }
                      }

                      $this->collAdvCommentssPartial = true;
                    }

                    $collAdvCommentss->getInternalIterator()->rewind();

                    return $collAdvCommentss;
                }

                if ($partial && $this->collAdvCommentss) {
                    foreach ($this->collAdvCommentss as $obj) {
                        if ($obj->isNew()) {
                            $collAdvCommentss[] = $obj;
                        }
                    }
                }

                $this->collAdvCommentss = $collAdvCommentss;
                $this->collAdvCommentssPartial = false;
            }
        }

        return $this->collAdvCommentss;
    }

    /**
     * Sets a collection of AdvComments objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advCommentss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvCommentss(PropelCollection $advCommentss, PropelPDO $con = null)
    {
        $advCommentssToDelete = $this->getAdvCommentss(new Criteria(), $con)->diff($advCommentss);


        $this->advCommentssScheduledForDeletion = $advCommentssToDelete;

        foreach ($advCommentssToDelete as $advCommentsRemoved) {
            $advCommentsRemoved->setAdvs(null);
        }

        $this->collAdvCommentss = null;
        foreach ($advCommentss as $advComments) {
            $this->addAdvComments($advComments);
        }

        $this->collAdvCommentss = $advCommentss;
        $this->collAdvCommentssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvComments objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvComments objects.
     * @throws PropelException
     */
    public function countAdvCommentss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvCommentssPartial && !$this->isNew();
        if (null === $this->collAdvCommentss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvCommentss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvCommentss());
            }
            $query = AdvCommentsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvCommentss);
    }

    /**
     * Method called to associate a AdvComments object to this object
     * through the AdvComments foreign key attribute.
     *
     * @param    AdvComments $l AdvComments
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvComments(AdvComments $l)
    {
        if ($this->collAdvCommentss === null) {
            $this->initAdvCommentss();
            $this->collAdvCommentssPartial = true;
        }

        if (!in_array($l, $this->collAdvCommentss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvComments($l);

            if ($this->advCommentssScheduledForDeletion and $this->advCommentssScheduledForDeletion->contains($l)) {
                $this->advCommentssScheduledForDeletion->remove($this->advCommentssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvComments $advComments The advComments object to add.
     */
    protected function doAddAdvComments($advComments)
    {
        $this->collAdvCommentss[]= $advComments;
        $advComments->setAdvs($this);
    }

    /**
     * @param	AdvComments $advComments The advComments object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvComments($advComments)
    {
        if ($this->getAdvCommentss()->contains($advComments)) {
            $this->collAdvCommentss->remove($this->collAdvCommentss->search($advComments));
            if (null === $this->advCommentssScheduledForDeletion) {
                $this->advCommentssScheduledForDeletion = clone $this->collAdvCommentss;
                $this->advCommentssScheduledForDeletion->clear();
            }
            $this->advCommentssScheduledForDeletion[]= clone $advComments;
            $advComments->setAdvs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related AdvCommentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvComments[] List of AdvComments objects
     */
    public function getAdvCommentssJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvCommentsQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getAdvCommentss($query, $con);
    }

    /**
     * Clears out the collAdvComplaines collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addAdvComplaines()
     */
    public function clearAdvComplaines()
    {
        $this->collAdvComplaines = null; // important to set this to null since that means it is uninitialized
        $this->collAdvComplainesPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvComplaines collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvComplaines($v = true)
    {
        $this->collAdvComplainesPartial = $v;
    }

    /**
     * Initializes the collAdvComplaines collection.
     *
     * By default this just sets the collAdvComplaines collection to an empty array (like clearcollAdvComplaines());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvComplaines($overrideExisting = true)
    {
        if (null !== $this->collAdvComplaines && !$overrideExisting) {
            return;
        }
        $this->collAdvComplaines = new PropelObjectCollection();
        $this->collAdvComplaines->setModel('AdvComplaine');
    }

    /**
     * Gets an array of AdvComplaine objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdvComplaine[] List of AdvComplaine objects
     * @throws PropelException
     */
    public function getAdvComplaines($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvComplainesPartial && !$this->isNew();
        if (null === $this->collAdvComplaines || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvComplaines) {
                // return empty collection
                $this->initAdvComplaines();
            } else {
                $collAdvComplaines = AdvComplaineQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvComplainesPartial && count($collAdvComplaines)) {
                      $this->initAdvComplaines(false);

                      foreach ($collAdvComplaines as $obj) {
                        if (false == $this->collAdvComplaines->contains($obj)) {
                          $this->collAdvComplaines->append($obj);
                        }
                      }

                      $this->collAdvComplainesPartial = true;
                    }

                    $collAdvComplaines->getInternalIterator()->rewind();

                    return $collAdvComplaines;
                }

                if ($partial && $this->collAdvComplaines) {
                    foreach ($this->collAdvComplaines as $obj) {
                        if ($obj->isNew()) {
                            $collAdvComplaines[] = $obj;
                        }
                    }
                }

                $this->collAdvComplaines = $collAdvComplaines;
                $this->collAdvComplainesPartial = false;
            }
        }

        return $this->collAdvComplaines;
    }

    /**
     * Sets a collection of AdvComplaine objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advComplaines A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setAdvComplaines(PropelCollection $advComplaines, PropelPDO $con = null)
    {
        $advComplainesToDelete = $this->getAdvComplaines(new Criteria(), $con)->diff($advComplaines);


        $this->advComplainesScheduledForDeletion = $advComplainesToDelete;

        foreach ($advComplainesToDelete as $advComplaineRemoved) {
            $advComplaineRemoved->setAdvs(null);
        }

        $this->collAdvComplaines = null;
        foreach ($advComplaines as $advComplaine) {
            $this->addAdvComplaine($advComplaine);
        }

        $this->collAdvComplaines = $advComplaines;
        $this->collAdvComplainesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdvComplaine objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdvComplaine objects.
     * @throws PropelException
     */
    public function countAdvComplaines(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvComplainesPartial && !$this->isNew();
        if (null === $this->collAdvComplaines || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvComplaines) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvComplaines());
            }
            $query = AdvComplaineQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collAdvComplaines);
    }

    /**
     * Method called to associate a AdvComplaine object to this object
     * through the AdvComplaine foreign key attribute.
     *
     * @param    AdvComplaine $l AdvComplaine
     * @return Advs The current object (for fluent API support)
     */
    public function addAdvComplaine(AdvComplaine $l)
    {
        if ($this->collAdvComplaines === null) {
            $this->initAdvComplaines();
            $this->collAdvComplainesPartial = true;
        }

        if (!in_array($l, $this->collAdvComplaines->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvComplaine($l);

            if ($this->advComplainesScheduledForDeletion and $this->advComplainesScheduledForDeletion->contains($l)) {
                $this->advComplainesScheduledForDeletion->remove($this->advComplainesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdvComplaine $advComplaine The advComplaine object to add.
     */
    protected function doAddAdvComplaine($advComplaine)
    {
        $this->collAdvComplaines[]= $advComplaine;
        $advComplaine->setAdvs($this);
    }

    /**
     * @param	AdvComplaine $advComplaine The advComplaine object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeAdvComplaine($advComplaine)
    {
        if ($this->getAdvComplaines()->contains($advComplaine)) {
            $this->collAdvComplaines->remove($this->collAdvComplaines->search($advComplaine));
            if (null === $this->advComplainesScheduledForDeletion) {
                $this->advComplainesScheduledForDeletion = clone $this->collAdvComplaines;
                $this->advComplainesScheduledForDeletion->clear();
            }
            $this->advComplainesScheduledForDeletion[]= $advComplaine;
            $advComplaine->setAdvs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related AdvComplaines from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvComplaine[] List of AdvComplaine objects
     */
    public function getAdvComplainesJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvComplaineQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getAdvComplaines($query, $con);
    }

    /**
     * Clears out the collUserFavorites collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Advs The current object (for fluent API support)
     * @see        addUserFavorites()
     */
    public function clearUserFavorites()
    {
        $this->collUserFavorites = null; // important to set this to null since that means it is uninitialized
        $this->collUserFavoritesPartial = null;

        return $this;
    }

    /**
     * reset is the collUserFavorites collection loaded partially
     *
     * @return void
     */
    public function resetPartialUserFavorites($v = true)
    {
        $this->collUserFavoritesPartial = $v;
    }

    /**
     * Initializes the collUserFavorites collection.
     *
     * By default this just sets the collUserFavorites collection to an empty array (like clearcollUserFavorites());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserFavorites($overrideExisting = true)
    {
        if (null !== $this->collUserFavorites && !$overrideExisting) {
            return;
        }
        $this->collUserFavorites = new PropelObjectCollection();
        $this->collUserFavorites->setModel('UserFavorite');
    }

    /**
     * Gets an array of UserFavorite objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Advs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|UserFavorite[] List of UserFavorite objects
     * @throws PropelException
     */
    public function getUserFavorites($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUserFavoritesPartial && !$this->isNew();
        if (null === $this->collUserFavorites || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserFavorites) {
                // return empty collection
                $this->initUserFavorites();
            } else {
                $collUserFavorites = UserFavoriteQuery::create(null, $criteria)
                    ->filterByAdvs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUserFavoritesPartial && count($collUserFavorites)) {
                      $this->initUserFavorites(false);

                      foreach ($collUserFavorites as $obj) {
                        if (false == $this->collUserFavorites->contains($obj)) {
                          $this->collUserFavorites->append($obj);
                        }
                      }

                      $this->collUserFavoritesPartial = true;
                    }

                    $collUserFavorites->getInternalIterator()->rewind();

                    return $collUserFavorites;
                }

                if ($partial && $this->collUserFavorites) {
                    foreach ($this->collUserFavorites as $obj) {
                        if ($obj->isNew()) {
                            $collUserFavorites[] = $obj;
                        }
                    }
                }

                $this->collUserFavorites = $collUserFavorites;
                $this->collUserFavoritesPartial = false;
            }
        }

        return $this->collUserFavorites;
    }

    /**
     * Sets a collection of UserFavorite objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userFavorites A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Advs The current object (for fluent API support)
     */
    public function setUserFavorites(PropelCollection $userFavorites, PropelPDO $con = null)
    {
        $userFavoritesToDelete = $this->getUserFavorites(new Criteria(), $con)->diff($userFavorites);


        $this->userFavoritesScheduledForDeletion = $userFavoritesToDelete;

        foreach ($userFavoritesToDelete as $userFavoriteRemoved) {
            $userFavoriteRemoved->setAdvs(null);
        }

        $this->collUserFavorites = null;
        foreach ($userFavorites as $userFavorite) {
            $this->addUserFavorite($userFavorite);
        }

        $this->collUserFavorites = $userFavorites;
        $this->collUserFavoritesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserFavorite objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related UserFavorite objects.
     * @throws PropelException
     */
    public function countUserFavorites(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUserFavoritesPartial && !$this->isNew();
        if (null === $this->collUserFavorites || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserFavorites) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserFavorites());
            }
            $query = UserFavoriteQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdvs($this)
                ->count($con);
        }

        return count($this->collUserFavorites);
    }

    /**
     * Method called to associate a UserFavorite object to this object
     * through the UserFavorite foreign key attribute.
     *
     * @param    UserFavorite $l UserFavorite
     * @return Advs The current object (for fluent API support)
     */
    public function addUserFavorite(UserFavorite $l)
    {
        if ($this->collUserFavorites === null) {
            $this->initUserFavorites();
            $this->collUserFavoritesPartial = true;
        }

        if (!in_array($l, $this->collUserFavorites->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUserFavorite($l);

            if ($this->userFavoritesScheduledForDeletion and $this->userFavoritesScheduledForDeletion->contains($l)) {
                $this->userFavoritesScheduledForDeletion->remove($this->userFavoritesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	UserFavorite $userFavorite The userFavorite object to add.
     */
    protected function doAddUserFavorite($userFavorite)
    {
        $this->collUserFavorites[]= $userFavorite;
        $userFavorite->setAdvs($this);
    }

    /**
     * @param	UserFavorite $userFavorite The userFavorite object to remove.
     * @return Advs The current object (for fluent API support)
     */
    public function removeUserFavorite($userFavorite)
    {
        if ($this->getUserFavorites()->contains($userFavorite)) {
            $this->collUserFavorites->remove($this->collUserFavorites->search($userFavorite));
            if (null === $this->userFavoritesScheduledForDeletion) {
                $this->userFavoritesScheduledForDeletion = clone $this->collUserFavorites;
                $this->userFavoritesScheduledForDeletion->clear();
            }
            $this->userFavoritesScheduledForDeletion[]= clone $userFavorite;
            $userFavorite->setAdvs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Advs is new, it will return
     * an empty collection; or if this Advs has previously
     * been saved, it will retrieve related UserFavorites from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Advs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|UserFavorite[] List of UserFavorite objects
     */
    public function getUserFavoritesJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = UserFavoriteQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getUserFavorites($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->user_id = null;
        $this->user_type = null;
        $this->company_name = null;
        $this->phone = null;
        $this->name = null;
        $this->alias = null;
        $this->description = null;
        $this->price = null;
        $this->dogovor = null;
        $this->torg = null;
        $this->region_id = null;
        $this->area_id = null;
        $this->shop_id = null;
        $this->cnt = null;
        $this->cnt_today = null;
        $this->cnt_tel = null;
        $this->cnt_tel_today = null;
        $this->cnt_skype = null;
        $this->cnt_site = null;
        $this->coord = null;
        $this->site = null;
        $this->skype = null;
        $this->youtube = null;
        $this->digest = null;
        $this->moder_approved = null;
        $this->enabled = null;
        $this->deleted = null;
        $this->twitter = null;
        $this->facebook = null;
        $this->vk = null;
        $this->vk_share = null;
        $this->google = null;
        $this->mailru = null;
        $this->odnoklassniki = null;
        $this->yandex_partner = null;
        $this->up_date = null;
        $this->hl_date = null;
        $this->social_date = null;
        $this->yandex_date = null;
        $this->yandex_index_date = null;
        $this->yandex_ping = null;
        $this->google_date = null;
        $this->google_index_date = null;
        $this->create_date = null;
        $this->publish_date = null;
        $this->publish_before_date = null;
        $this->last_view_date = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collAdvPrices) {
                foreach ($this->collAdvPrices as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvsStats) {
                foreach ($this->collAdvsStats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvsModerStats) {
                foreach ($this->collAdvsModerStats as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvParamss) {
                foreach ($this->collAdvParamss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvImagess) {
                foreach ($this->collAdvImagess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvVideoss) {
                foreach ($this->collAdvVideoss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvPacketss) {
                foreach ($this->collAdvPacketss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvCommentss) {
                foreach ($this->collAdvCommentss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvComplaines) {
                foreach ($this->collAdvComplaines as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUserFavorites) {
                foreach ($this->collUserFavorites as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aRegions instanceof Persistent) {
              $this->aRegions->clearAllReferences($deep);
            }
            if ($this->aAreas instanceof Persistent) {
              $this->aAreas->clearAllReferences($deep);
            }
            if ($this->aUser instanceof Persistent) {
              $this->aUser->clearAllReferences($deep);
            }
            if ($this->aShops instanceof Persistent) {
              $this->aShops->clearAllReferences($deep);
            }
            if ($this->aAdCategories instanceof Persistent) {
              $this->aAdCategories->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAdvPrices instanceof PropelCollection) {
            $this->collAdvPrices->clearIterator();
        }
        $this->collAdvPrices = null;
        if ($this->collAdvsStats instanceof PropelCollection) {
            $this->collAdvsStats->clearIterator();
        }
        $this->collAdvsStats = null;
        if ($this->collAdvsModerStats instanceof PropelCollection) {
            $this->collAdvsModerStats->clearIterator();
        }
        $this->collAdvsModerStats = null;
        if ($this->collAdvParamss instanceof PropelCollection) {
            $this->collAdvParamss->clearIterator();
        }
        $this->collAdvParamss = null;
        if ($this->collAdvImagess instanceof PropelCollection) {
            $this->collAdvImagess->clearIterator();
        }
        $this->collAdvImagess = null;
        if ($this->collAdvVideoss instanceof PropelCollection) {
            $this->collAdvVideoss->clearIterator();
        }
        $this->collAdvVideoss = null;
        if ($this->collAdvPacketss instanceof PropelCollection) {
            $this->collAdvPacketss->clearIterator();
        }
        $this->collAdvPacketss = null;
        if ($this->collAdvCommentss instanceof PropelCollection) {
            $this->collAdvCommentss->clearIterator();
        }
        $this->collAdvCommentss = null;
        if ($this->collAdvComplaines instanceof PropelCollection) {
            $this->collAdvComplaines->clearIterator();
        }
        $this->collAdvComplaines = null;
        if ($this->collUserFavorites instanceof PropelCollection) {
            $this->collUserFavorites->clearIterator();
        }
        $this->collUserFavorites = null;
        $this->aRegions = null;
        $this->aAreas = null;
        $this->aUser = null;
        $this->aShops = null;
        $this->aAdCategories = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'name' column
     */
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
