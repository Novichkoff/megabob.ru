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
use Admin\AdminBundle\Model\JobCategories;
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\JobComments;
use Admin\AdminBundle\Model\JobCommentsQuery;
use Admin\AdminBundle\Model\JobImages;
use Admin\AdminBundle\Model\JobImagesQuery;
use Admin\AdminBundle\Model\JobPackets;
use Admin\AdminBundle\Model\JobPacketsQuery;
use Admin\AdminBundle\Model\JobParams;
use Admin\AdminBundle\Model\JobParamsQuery;
use Admin\AdminBundle\Model\JobRest;
use Admin\AdminBundle\Model\JobRestQuery;
use Admin\AdminBundle\Model\JobVideos;
use Admin\AdminBundle\Model\JobVideosQuery;
use Admin\AdminBundle\Model\Jobs;
use Admin\AdminBundle\Model\JobsPeer;
use Admin\AdminBundle\Model\JobsQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\Shops;
use Admin\AdminBundle\Model\ShopsQuery;
use FOS\UserBundle\Propel\User;
use FOS\UserBundle\Propel\UserQuery;

abstract class BaseJobs extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\JobsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        JobsPeer
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
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the dogovor field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $dogovor;

    /**
     * The value for the price_from field.
     * @var        int
     */
    protected $price_from;

    /**
     * The value for the price_to field.
     * @var        int
     */
    protected $price_to;

    /**
     * The value for the resume field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $resume;

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
     * @var        Regions
     */
    protected $aRegions;

    /**
     * @var        User
     */
    protected $aUser;

    /**
     * @var        JobCategories
     */
    protected $aJobCategories;

    /**
     * @var        Shops
     */
    protected $aShops;

    /**
     * @var        PropelObjectCollection|JobParams[] Collection to store aggregation of JobParams objects.
     */
    protected $collJobParamss;
    protected $collJobParamssPartial;

    /**
     * @var        PropelObjectCollection|JobImages[] Collection to store aggregation of JobImages objects.
     */
    protected $collJobImagess;
    protected $collJobImagessPartial;

    /**
     * @var        PropelObjectCollection|JobVideos[] Collection to store aggregation of JobVideos objects.
     */
    protected $collJobVideoss;
    protected $collJobVideossPartial;

    /**
     * @var        PropelObjectCollection|JobPackets[] Collection to store aggregation of JobPackets objects.
     */
    protected $collJobPacketss;
    protected $collJobPacketssPartial;

    /**
     * @var        PropelObjectCollection|JobComments[] Collection to store aggregation of JobComments objects.
     */
    protected $collJobCommentss;
    protected $collJobCommentssPartial;

    /**
     * @var        PropelObjectCollection|JobRest[] Collection to store aggregation of JobRest objects.
     */
    protected $collJobRestsRelatedByJobId;
    protected $collJobRestsRelatedByJobIdPartial;

    /**
     * @var        PropelObjectCollection|JobRest[] Collection to store aggregation of JobRest objects.
     */
    protected $collJobRestsRelatedByVacancyId;
    protected $collJobRestsRelatedByVacancyIdPartial;

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
    protected $jobParamssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobImagessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobVideossScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobPacketssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobCommentssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobRestsRelatedByJobIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobRestsRelatedByVacancyIdScheduledForDeletion = null;

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
        $this->resume = false;
        $this->cnt = 0;
        $this->cnt_today = 0;
        $this->cnt_tel = 0;
        $this->moder_approved = false;
        $this->enabled = false;
        $this->deleted = false;
    }

    /**
     * Initializes internal state of BaseJobs object.
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
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {

        return $this->description;
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
     * Get the [price_from] column value.
     *
     * @return int
     */
    public function getPriceFrom()
    {

        return $this->price_from;
    }

    /**
     * Get the [price_to] column value.
     *
     * @return int
     */
    public function getPriceTo()
    {

        return $this->price_to;
    }

    /**
     * Get the [resume] column value.
     *
     * @return boolean
     */
    public function getResume()
    {

        return $this->resume;
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
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = JobsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = JobsPeer::CATEGORY_ID;
        }

        if ($this->aJobCategories !== null && $this->aJobCategories->getId() !== $v) {
            $this->aJobCategories = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [user_id] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[] = JobsPeer::USER_ID;
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
     * @return Jobs The current object (for fluent API support)
     */
    public function setUserType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->user_type !== $v) {
            $this->user_type = $v;
            $this->modifiedColumns[] = JobsPeer::USER_TYPE;
        }


        return $this;
    } // setUserType()

    /**
     * Set the value of [company_name] column.
     *
     * @param  string $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setCompanyName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->company_name !== $v) {
            $this->company_name = $v;
            $this->modifiedColumns[] = JobsPeer::COMPANY_NAME;
        }


        return $this;
    } // setCompanyName()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[] = JobsPeer::PHONE;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = JobsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = JobsPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Sets the value of the [dogovor] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Jobs The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobsPeer::DOGOVOR;
        }


        return $this;
    } // setDogovor()

    /**
     * Set the value of [price_from] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setPriceFrom($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->price_from !== $v) {
            $this->price_from = $v;
            $this->modifiedColumns[] = JobsPeer::PRICE_FROM;
        }


        return $this;
    } // setPriceFrom()

    /**
     * Set the value of [price_to] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setPriceTo($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->price_to !== $v) {
            $this->price_to = $v;
            $this->modifiedColumns[] = JobsPeer::PRICE_TO;
        }


        return $this;
    } // setPriceTo()

    /**
     * Sets the value of the [resume] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setResume($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->resume !== $v) {
            $this->resume = $v;
            $this->modifiedColumns[] = JobsPeer::RESUME;
        }


        return $this;
    } // setResume()

    /**
     * Set the value of [region_id] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setRegionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->region_id !== $v) {
            $this->region_id = $v;
            $this->modifiedColumns[] = JobsPeer::REGION_ID;
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
     * @return Jobs The current object (for fluent API support)
     */
    public function setAreaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->area_id !== $v) {
            $this->area_id = $v;
            $this->modifiedColumns[] = JobsPeer::AREA_ID;
        }


        return $this;
    } // setAreaId()

    /**
     * Set the value of [shop_id] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setShopId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->shop_id !== $v) {
            $this->shop_id = $v;
            $this->modifiedColumns[] = JobsPeer::SHOP_ID;
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
     * @return Jobs The current object (for fluent API support)
     */
    public function setCnt($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt !== $v) {
            $this->cnt = $v;
            $this->modifiedColumns[] = JobsPeer::CNT;
        }


        return $this;
    } // setCnt()

    /**
     * Set the value of [cnt_today] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setCntToday($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_today !== $v) {
            $this->cnt_today = $v;
            $this->modifiedColumns[] = JobsPeer::CNT_TODAY;
        }


        return $this;
    } // setCntToday()

    /**
     * Set the value of [cnt_tel] column.
     *
     * @param  int $v new value
     * @return Jobs The current object (for fluent API support)
     */
    public function setCntTel($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt_tel !== $v) {
            $this->cnt_tel = $v;
            $this->modifiedColumns[] = JobsPeer::CNT_TEL;
        }


        return $this;
    } // setCntTel()

    /**
     * Sets the value of the [moder_approved] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Jobs The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobsPeer::MODER_APPROVED;
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
     * @return Jobs The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobsPeer::ENABLED;
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
     * @return Jobs The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobsPeer::DELETED;
        }


        return $this;
    } // setDeleted()

    /**
     * Sets the value of [create_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Jobs The current object (for fluent API support)
     */
    public function setCreateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->create_date !== null || $dt !== null) {
            $currentDateAsString = ($this->create_date !== null && $tmpDt = new DateTime($this->create_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->create_date = $newDateAsString;
                $this->modifiedColumns[] = JobsPeer::CREATE_DATE;
            }
        } // if either are not null


        return $this;
    } // setCreateDate()

    /**
     * Sets the value of [publish_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Jobs The current object (for fluent API support)
     */
    public function setPublishDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->publish_date !== null || $dt !== null) {
            $currentDateAsString = ($this->publish_date !== null && $tmpDt = new DateTime($this->publish_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->publish_date = $newDateAsString;
                $this->modifiedColumns[] = JobsPeer::PUBLISH_DATE;
            }
        } // if either are not null


        return $this;
    } // setPublishDate()

    /**
     * Sets the value of [publish_before_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Jobs The current object (for fluent API support)
     */
    public function setPublishBeforeDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->publish_before_date !== null || $dt !== null) {
            $currentDateAsString = ($this->publish_before_date !== null && $tmpDt = new DateTime($this->publish_before_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->publish_before_date = $newDateAsString;
                $this->modifiedColumns[] = JobsPeer::PUBLISH_BEFORE_DATE;
            }
        } // if either are not null


        return $this;
    } // setPublishBeforeDate()

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

            if ($this->resume !== false) {
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

            if ($this->moder_approved !== false) {
                return false;
            }

            if ($this->enabled !== false) {
                return false;
            }

            if ($this->deleted !== false) {
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
            $this->description = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->dogovor = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
            $this->price_from = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->price_to = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->resume = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
            $this->region_id = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->area_id = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->shop_id = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->cnt = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
            $this->cnt_today = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
            $this->cnt_tel = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->moder_approved = ($row[$startcol + 18] !== null) ? (boolean) $row[$startcol + 18] : null;
            $this->enabled = ($row[$startcol + 19] !== null) ? (boolean) $row[$startcol + 19] : null;
            $this->deleted = ($row[$startcol + 20] !== null) ? (boolean) $row[$startcol + 20] : null;
            $this->create_date = ($row[$startcol + 21] !== null) ? (string) $row[$startcol + 21] : null;
            $this->publish_date = ($row[$startcol + 22] !== null) ? (string) $row[$startcol + 22] : null;
            $this->publish_before_date = ($row[$startcol + 23] !== null) ? (string) $row[$startcol + 23] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 24; // 24 = JobsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Jobs object", $e);
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

        if ($this->aJobCategories !== null && $this->category_id !== $this->aJobCategories->getId()) {
            $this->aJobCategories = null;
        }
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
        if ($this->aRegions !== null && $this->region_id !== $this->aRegions->getId()) {
            $this->aRegions = null;
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
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = JobsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRegions = null;
            $this->aUser = null;
            $this->aJobCategories = null;
            $this->aShops = null;
            $this->collJobParamss = null;

            $this->collJobImagess = null;

            $this->collJobVideoss = null;

            $this->collJobPacketss = null;

            $this->collJobCommentss = null;

            $this->collJobRestsRelatedByJobId = null;

            $this->collJobRestsRelatedByVacancyId = null;

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
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = JobsQuery::create()
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
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                JobsPeer::addInstanceToPool($this);
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

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aJobCategories !== null) {
                if ($this->aJobCategories->isModified() || $this->aJobCategories->isNew()) {
                    $affectedRows += $this->aJobCategories->save($con);
                }
                $this->setJobCategories($this->aJobCategories);
            }

            if ($this->aShops !== null) {
                if ($this->aShops->isModified() || $this->aShops->isNew()) {
                    $affectedRows += $this->aShops->save($con);
                }
                $this->setShops($this->aShops);
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

            if ($this->jobParamssScheduledForDeletion !== null) {
                if (!$this->jobParamssScheduledForDeletion->isEmpty()) {
                    JobParamsQuery::create()
                        ->filterByPrimaryKeys($this->jobParamssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobParamssScheduledForDeletion = null;
                }
            }

            if ($this->collJobParamss !== null) {
                foreach ($this->collJobParamss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobImagessScheduledForDeletion !== null) {
                if (!$this->jobImagessScheduledForDeletion->isEmpty()) {
                    JobImagesQuery::create()
                        ->filterByPrimaryKeys($this->jobImagessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobImagessScheduledForDeletion = null;
                }
            }

            if ($this->collJobImagess !== null) {
                foreach ($this->collJobImagess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobVideossScheduledForDeletion !== null) {
                if (!$this->jobVideossScheduledForDeletion->isEmpty()) {
                    JobVideosQuery::create()
                        ->filterByPrimaryKeys($this->jobVideossScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobVideossScheduledForDeletion = null;
                }
            }

            if ($this->collJobVideoss !== null) {
                foreach ($this->collJobVideoss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobPacketssScheduledForDeletion !== null) {
                if (!$this->jobPacketssScheduledForDeletion->isEmpty()) {
                    JobPacketsQuery::create()
                        ->filterByPrimaryKeys($this->jobPacketssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobPacketssScheduledForDeletion = null;
                }
            }

            if ($this->collJobPacketss !== null) {
                foreach ($this->collJobPacketss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobCommentssScheduledForDeletion !== null) {
                if (!$this->jobCommentssScheduledForDeletion->isEmpty()) {
                    JobCommentsQuery::create()
                        ->filterByPrimaryKeys($this->jobCommentssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobCommentssScheduledForDeletion = null;
                }
            }

            if ($this->collJobCommentss !== null) {
                foreach ($this->collJobCommentss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobRestsRelatedByJobIdScheduledForDeletion !== null) {
                if (!$this->jobRestsRelatedByJobIdScheduledForDeletion->isEmpty()) {
                    JobRestQuery::create()
                        ->filterByPrimaryKeys($this->jobRestsRelatedByJobIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobRestsRelatedByJobIdScheduledForDeletion = null;
                }
            }

            if ($this->collJobRestsRelatedByJobId !== null) {
                foreach ($this->collJobRestsRelatedByJobId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobRestsRelatedByVacancyIdScheduledForDeletion !== null) {
                if (!$this->jobRestsRelatedByVacancyIdScheduledForDeletion->isEmpty()) {
                    JobRestQuery::create()
                        ->filterByPrimaryKeys($this->jobRestsRelatedByVacancyIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobRestsRelatedByVacancyIdScheduledForDeletion = null;
                }
            }

            if ($this->collJobRestsRelatedByVacancyId !== null) {
                foreach ($this->collJobRestsRelatedByVacancyId as $referrerFK) {
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

        $this->modifiedColumns[] = JobsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . JobsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(JobsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(JobsPeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(JobsPeer::USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`user_id`';
        }
        if ($this->isColumnModified(JobsPeer::USER_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`user_type`';
        }
        if ($this->isColumnModified(JobsPeer::COMPANY_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`company_name`';
        }
        if ($this->isColumnModified(JobsPeer::PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(JobsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(JobsPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(JobsPeer::DOGOVOR)) {
            $modifiedColumns[':p' . $index++]  = '`dogovor`';
        }
        if ($this->isColumnModified(JobsPeer::PRICE_FROM)) {
            $modifiedColumns[':p' . $index++]  = '`price_from`';
        }
        if ($this->isColumnModified(JobsPeer::PRICE_TO)) {
            $modifiedColumns[':p' . $index++]  = '`price_to`';
        }
        if ($this->isColumnModified(JobsPeer::RESUME)) {
            $modifiedColumns[':p' . $index++]  = '`resume`';
        }
        if ($this->isColumnModified(JobsPeer::REGION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`region_id`';
        }
        if ($this->isColumnModified(JobsPeer::AREA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`area_id`';
        }
        if ($this->isColumnModified(JobsPeer::SHOP_ID)) {
            $modifiedColumns[':p' . $index++]  = '`shop_id`';
        }
        if ($this->isColumnModified(JobsPeer::CNT)) {
            $modifiedColumns[':p' . $index++]  = '`cnt`';
        }
        if ($this->isColumnModified(JobsPeer::CNT_TODAY)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_today`';
        }
        if ($this->isColumnModified(JobsPeer::CNT_TEL)) {
            $modifiedColumns[':p' . $index++]  = '`cnt_tel`';
        }
        if ($this->isColumnModified(JobsPeer::MODER_APPROVED)) {
            $modifiedColumns[':p' . $index++]  = '`moder_approved`';
        }
        if ($this->isColumnModified(JobsPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(JobsPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(JobsPeer::CREATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`create_date`';
        }
        if ($this->isColumnModified(JobsPeer::PUBLISH_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`publish_date`';
        }
        if ($this->isColumnModified(JobsPeer::PUBLISH_BEFORE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`publish_before_date`';
        }

        $sql = sprintf(
            'INSERT INTO `jobs` (%s) VALUES (%s)',
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
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`dogovor`':
                        $stmt->bindValue($identifier, (int) $this->dogovor, PDO::PARAM_INT);
                        break;
                    case '`price_from`':
                        $stmt->bindValue($identifier, $this->price_from, PDO::PARAM_INT);
                        break;
                    case '`price_to`':
                        $stmt->bindValue($identifier, $this->price_to, PDO::PARAM_INT);
                        break;
                    case '`resume`':
                        $stmt->bindValue($identifier, (int) $this->resume, PDO::PARAM_INT);
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
                    case '`moder_approved`':
                        $stmt->bindValue($identifier, (int) $this->moder_approved, PDO::PARAM_INT);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`deleted`':
                        $stmt->bindValue($identifier, (int) $this->deleted, PDO::PARAM_INT);
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

            if ($this->aUser !== null) {
                if (!$this->aUser->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
                }
            }

            if ($this->aJobCategories !== null) {
                if (!$this->aJobCategories->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aJobCategories->getValidationFailures());
                }
            }

            if ($this->aShops !== null) {
                if (!$this->aShops->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aShops->getValidationFailures());
                }
            }


            if (($retval = JobsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collJobParamss !== null) {
                    foreach ($this->collJobParamss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobImagess !== null) {
                    foreach ($this->collJobImagess as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobVideoss !== null) {
                    foreach ($this->collJobVideoss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobPacketss !== null) {
                    foreach ($this->collJobPacketss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobCommentss !== null) {
                    foreach ($this->collJobCommentss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobRestsRelatedByJobId !== null) {
                    foreach ($this->collJobRestsRelatedByJobId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobRestsRelatedByVacancyId !== null) {
                    foreach ($this->collJobRestsRelatedByVacancyId as $referrerFK) {
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
        $pos = JobsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getDescription();
                break;
            case 8:
                return $this->getDogovor();
                break;
            case 9:
                return $this->getPriceFrom();
                break;
            case 10:
                return $this->getPriceTo();
                break;
            case 11:
                return $this->getResume();
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
                return $this->getModerApproved();
                break;
            case 19:
                return $this->getEnabled();
                break;
            case 20:
                return $this->getDeleted();
                break;
            case 21:
                return $this->getCreateDate();
                break;
            case 22:
                return $this->getPublishDate();
                break;
            case 23:
                return $this->getPublishBeforeDate();
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
        if (isset($alreadyDumpedObjects['Jobs'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Jobs'][$this->getPrimaryKey()] = true;
        $keys = JobsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getUserId(),
            $keys[3] => $this->getUserType(),
            $keys[4] => $this->getCompanyName(),
            $keys[5] => $this->getPhone(),
            $keys[6] => $this->getName(),
            $keys[7] => $this->getDescription(),
            $keys[8] => $this->getDogovor(),
            $keys[9] => $this->getPriceFrom(),
            $keys[10] => $this->getPriceTo(),
            $keys[11] => $this->getResume(),
            $keys[12] => $this->getRegionId(),
            $keys[13] => $this->getAreaId(),
            $keys[14] => $this->getShopId(),
            $keys[15] => $this->getCnt(),
            $keys[16] => $this->getCntToday(),
            $keys[17] => $this->getCntTel(),
            $keys[18] => $this->getModerApproved(),
            $keys[19] => $this->getEnabled(),
            $keys[20] => $this->getDeleted(),
            $keys[21] => $this->getCreateDate(),
            $keys[22] => $this->getPublishDate(),
            $keys[23] => $this->getPublishBeforeDate(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aRegions) {
                $result['Regions'] = $this->aRegions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aJobCategories) {
                $result['JobCategories'] = $this->aJobCategories->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aShops) {
                $result['Shops'] = $this->aShops->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collJobParamss) {
                $result['JobParamss'] = $this->collJobParamss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobImagess) {
                $result['JobImagess'] = $this->collJobImagess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobVideoss) {
                $result['JobVideoss'] = $this->collJobVideoss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobPacketss) {
                $result['JobPacketss'] = $this->collJobPacketss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobCommentss) {
                $result['JobCommentss'] = $this->collJobCommentss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobRestsRelatedByJobId) {
                $result['JobRestsRelatedByJobId'] = $this->collJobRestsRelatedByJobId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobRestsRelatedByVacancyId) {
                $result['JobRestsRelatedByVacancyId'] = $this->collJobRestsRelatedByVacancyId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = JobsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setDescription($value);
                break;
            case 8:
                $this->setDogovor($value);
                break;
            case 9:
                $this->setPriceFrom($value);
                break;
            case 10:
                $this->setPriceTo($value);
                break;
            case 11:
                $this->setResume($value);
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
                $this->setModerApproved($value);
                break;
            case 19:
                $this->setEnabled($value);
                break;
            case 20:
                $this->setDeleted($value);
                break;
            case 21:
                $this->setCreateDate($value);
                break;
            case 22:
                $this->setPublishDate($value);
                break;
            case 23:
                $this->setPublishBeforeDate($value);
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
        $keys = JobsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setUserId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setUserType($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCompanyName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPhone($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDescription($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDogovor($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPriceFrom($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setPriceTo($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setResume($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setRegionId($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setAreaId($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setShopId($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setCnt($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setCntToday($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setCntTel($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setModerApproved($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setEnabled($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setDeleted($arr[$keys[20]]);
        if (array_key_exists($keys[21], $arr)) $this->setCreateDate($arr[$keys[21]]);
        if (array_key_exists($keys[22], $arr)) $this->setPublishDate($arr[$keys[22]]);
        if (array_key_exists($keys[23], $arr)) $this->setPublishBeforeDate($arr[$keys[23]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(JobsPeer::DATABASE_NAME);

        if ($this->isColumnModified(JobsPeer::ID)) $criteria->add(JobsPeer::ID, $this->id);
        if ($this->isColumnModified(JobsPeer::CATEGORY_ID)) $criteria->add(JobsPeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(JobsPeer::USER_ID)) $criteria->add(JobsPeer::USER_ID, $this->user_id);
        if ($this->isColumnModified(JobsPeer::USER_TYPE)) $criteria->add(JobsPeer::USER_TYPE, $this->user_type);
        if ($this->isColumnModified(JobsPeer::COMPANY_NAME)) $criteria->add(JobsPeer::COMPANY_NAME, $this->company_name);
        if ($this->isColumnModified(JobsPeer::PHONE)) $criteria->add(JobsPeer::PHONE, $this->phone);
        if ($this->isColumnModified(JobsPeer::NAME)) $criteria->add(JobsPeer::NAME, $this->name);
        if ($this->isColumnModified(JobsPeer::DESCRIPTION)) $criteria->add(JobsPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(JobsPeer::DOGOVOR)) $criteria->add(JobsPeer::DOGOVOR, $this->dogovor);
        if ($this->isColumnModified(JobsPeer::PRICE_FROM)) $criteria->add(JobsPeer::PRICE_FROM, $this->price_from);
        if ($this->isColumnModified(JobsPeer::PRICE_TO)) $criteria->add(JobsPeer::PRICE_TO, $this->price_to);
        if ($this->isColumnModified(JobsPeer::RESUME)) $criteria->add(JobsPeer::RESUME, $this->resume);
        if ($this->isColumnModified(JobsPeer::REGION_ID)) $criteria->add(JobsPeer::REGION_ID, $this->region_id);
        if ($this->isColumnModified(JobsPeer::AREA_ID)) $criteria->add(JobsPeer::AREA_ID, $this->area_id);
        if ($this->isColumnModified(JobsPeer::SHOP_ID)) $criteria->add(JobsPeer::SHOP_ID, $this->shop_id);
        if ($this->isColumnModified(JobsPeer::CNT)) $criteria->add(JobsPeer::CNT, $this->cnt);
        if ($this->isColumnModified(JobsPeer::CNT_TODAY)) $criteria->add(JobsPeer::CNT_TODAY, $this->cnt_today);
        if ($this->isColumnModified(JobsPeer::CNT_TEL)) $criteria->add(JobsPeer::CNT_TEL, $this->cnt_tel);
        if ($this->isColumnModified(JobsPeer::MODER_APPROVED)) $criteria->add(JobsPeer::MODER_APPROVED, $this->moder_approved);
        if ($this->isColumnModified(JobsPeer::ENABLED)) $criteria->add(JobsPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(JobsPeer::DELETED)) $criteria->add(JobsPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(JobsPeer::CREATE_DATE)) $criteria->add(JobsPeer::CREATE_DATE, $this->create_date);
        if ($this->isColumnModified(JobsPeer::PUBLISH_DATE)) $criteria->add(JobsPeer::PUBLISH_DATE, $this->publish_date);
        if ($this->isColumnModified(JobsPeer::PUBLISH_BEFORE_DATE)) $criteria->add(JobsPeer::PUBLISH_BEFORE_DATE, $this->publish_before_date);

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
        $criteria = new Criteria(JobsPeer::DATABASE_NAME);
        $criteria->add(JobsPeer::ID, $this->id);

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
     * @param object $copyObj An object of Jobs (or compatible) type.
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
        $copyObj->setDescription($this->getDescription());
        $copyObj->setDogovor($this->getDogovor());
        $copyObj->setPriceFrom($this->getPriceFrom());
        $copyObj->setPriceTo($this->getPriceTo());
        $copyObj->setResume($this->getResume());
        $copyObj->setRegionId($this->getRegionId());
        $copyObj->setAreaId($this->getAreaId());
        $copyObj->setShopId($this->getShopId());
        $copyObj->setCnt($this->getCnt());
        $copyObj->setCntToday($this->getCntToday());
        $copyObj->setCntTel($this->getCntTel());
        $copyObj->setModerApproved($this->getModerApproved());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setDeleted($this->getDeleted());
        $copyObj->setCreateDate($this->getCreateDate());
        $copyObj->setPublishDate($this->getPublishDate());
        $copyObj->setPublishBeforeDate($this->getPublishBeforeDate());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getJobParamss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobParams($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobImagess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobImages($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobVideoss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobVideos($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobPacketss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobPackets($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobCommentss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobComments($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobRestsRelatedByJobId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobRestRelatedByJobId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobRestsRelatedByVacancyId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobRestRelatedByVacancyId($relObj->copy($deepCopy));
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
     * @return Jobs Clone of current object.
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
     * @return JobsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new JobsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Regions object.
     *
     * @param                  Regions $v
     * @return Jobs The current object (for fluent API support)
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
            $v->addJobs($this);
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
                $this->aRegions->addJobss($this);
             */
        }

        return $this->aRegions;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param                  User $v
     * @return Jobs The current object (for fluent API support)
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
            $v->addJobs($this);
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
                $this->aUser->addJobss($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a JobCategories object.
     *
     * @param                  JobCategories $v
     * @return Jobs The current object (for fluent API support)
     * @throws PropelException
     */
    public function setJobCategories(JobCategories $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aJobCategories = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the JobCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addJobs($this);
        }


        return $this;
    }


    /**
     * Get the associated JobCategories object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return JobCategories The associated JobCategories object.
     * @throws PropelException
     */
    public function getJobCategories(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aJobCategories === null && ($this->category_id !== null) && $doQuery) {
            $this->aJobCategories = JobCategoriesQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aJobCategories->addJobss($this);
             */
        }

        return $this->aJobCategories;
    }

    /**
     * Declares an association between this object and a Shops object.
     *
     * @param                  Shops $v
     * @return Jobs The current object (for fluent API support)
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
            $v->addJobs($this);
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
                $this->aShops->addJobss($this);
             */
        }

        return $this->aShops;
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
        if ('JobParams' == $relationName) {
            $this->initJobParamss();
        }
        if ('JobImages' == $relationName) {
            $this->initJobImagess();
        }
        if ('JobVideos' == $relationName) {
            $this->initJobVideoss();
        }
        if ('JobPackets' == $relationName) {
            $this->initJobPacketss();
        }
        if ('JobComments' == $relationName) {
            $this->initJobCommentss();
        }
        if ('JobRestRelatedByJobId' == $relationName) {
            $this->initJobRestsRelatedByJobId();
        }
        if ('JobRestRelatedByVacancyId' == $relationName) {
            $this->initJobRestsRelatedByVacancyId();
        }
    }

    /**
     * Clears out the collJobParamss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobParamss()
     */
    public function clearJobParamss()
    {
        $this->collJobParamss = null; // important to set this to null since that means it is uninitialized
        $this->collJobParamssPartial = null;

        return $this;
    }

    /**
     * reset is the collJobParamss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobParamss($v = true)
    {
        $this->collJobParamssPartial = $v;
    }

    /**
     * Initializes the collJobParamss collection.
     *
     * By default this just sets the collJobParamss collection to an empty array (like clearcollJobParamss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobParamss($overrideExisting = true)
    {
        if (null !== $this->collJobParamss && !$overrideExisting) {
            return;
        }
        $this->collJobParamss = new PropelObjectCollection();
        $this->collJobParamss->setModel('JobParams');
    }

    /**
     * Gets an array of JobParams objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobParams[] List of JobParams objects
     * @throws PropelException
     */
    public function getJobParamss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobParamssPartial && !$this->isNew();
        if (null === $this->collJobParamss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobParamss) {
                // return empty collection
                $this->initJobParamss();
            } else {
                $collJobParamss = JobParamsQuery::create(null, $criteria)
                    ->filterByJobs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobParamssPartial && count($collJobParamss)) {
                      $this->initJobParamss(false);

                      foreach ($collJobParamss as $obj) {
                        if (false == $this->collJobParamss->contains($obj)) {
                          $this->collJobParamss->append($obj);
                        }
                      }

                      $this->collJobParamssPartial = true;
                    }

                    $collJobParamss->getInternalIterator()->rewind();

                    return $collJobParamss;
                }

                if ($partial && $this->collJobParamss) {
                    foreach ($this->collJobParamss as $obj) {
                        if ($obj->isNew()) {
                            $collJobParamss[] = $obj;
                        }
                    }
                }

                $this->collJobParamss = $collJobParamss;
                $this->collJobParamssPartial = false;
            }
        }

        return $this->collJobParamss;
    }

    /**
     * Sets a collection of JobParams objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobParamss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobParamss(PropelCollection $jobParamss, PropelPDO $con = null)
    {
        $jobParamssToDelete = $this->getJobParamss(new Criteria(), $con)->diff($jobParamss);


        $this->jobParamssScheduledForDeletion = $jobParamssToDelete;

        foreach ($jobParamssToDelete as $jobParamsRemoved) {
            $jobParamsRemoved->setJobs(null);
        }

        $this->collJobParamss = null;
        foreach ($jobParamss as $jobParams) {
            $this->addJobParams($jobParams);
        }

        $this->collJobParamss = $jobParamss;
        $this->collJobParamssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobParams objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobParams objects.
     * @throws PropelException
     */
    public function countJobParamss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobParamssPartial && !$this->isNew();
        if (null === $this->collJobParamss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobParamss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobParamss());
            }
            $query = JobParamsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobs($this)
                ->count($con);
        }

        return count($this->collJobParamss);
    }

    /**
     * Method called to associate a JobParams object to this object
     * through the JobParams foreign key attribute.
     *
     * @param    JobParams $l JobParams
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobParams(JobParams $l)
    {
        if ($this->collJobParamss === null) {
            $this->initJobParamss();
            $this->collJobParamssPartial = true;
        }

        if (!in_array($l, $this->collJobParamss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobParams($l);

            if ($this->jobParamssScheduledForDeletion and $this->jobParamssScheduledForDeletion->contains($l)) {
                $this->jobParamssScheduledForDeletion->remove($this->jobParamssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobParams $jobParams The jobParams object to add.
     */
    protected function doAddJobParams($jobParams)
    {
        $this->collJobParamss[]= $jobParams;
        $jobParams->setJobs($this);
    }

    /**
     * @param	JobParams $jobParams The jobParams object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobParams($jobParams)
    {
        if ($this->getJobParamss()->contains($jobParams)) {
            $this->collJobParamss->remove($this->collJobParamss->search($jobParams));
            if (null === $this->jobParamssScheduledForDeletion) {
                $this->jobParamssScheduledForDeletion = clone $this->collJobParamss;
                $this->jobParamssScheduledForDeletion->clear();
            }
            $this->jobParamssScheduledForDeletion[]= clone $jobParams;
            $jobParams->setJobs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Jobs is new, it will return
     * an empty collection; or if this Jobs has previously
     * been saved, it will retrieve related JobParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Jobs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobParams[] List of JobParams objects
     */
    public function getJobParamssJoinJobCategoriesFields($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobParamsQuery::create(null, $criteria);
        $query->joinWith('JobCategoriesFields', $join_behavior);

        return $this->getJobParamss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Jobs is new, it will return
     * an empty collection; or if this Jobs has previously
     * been saved, it will retrieve related JobParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Jobs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobParams[] List of JobParams objects
     */
    public function getJobParamssJoinJobCategoriesFieldsValues($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobParamsQuery::create(null, $criteria);
        $query->joinWith('JobCategoriesFieldsValues', $join_behavior);

        return $this->getJobParamss($query, $con);
    }

    /**
     * Clears out the collJobImagess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobImagess()
     */
    public function clearJobImagess()
    {
        $this->collJobImagess = null; // important to set this to null since that means it is uninitialized
        $this->collJobImagessPartial = null;

        return $this;
    }

    /**
     * reset is the collJobImagess collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobImagess($v = true)
    {
        $this->collJobImagessPartial = $v;
    }

    /**
     * Initializes the collJobImagess collection.
     *
     * By default this just sets the collJobImagess collection to an empty array (like clearcollJobImagess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobImagess($overrideExisting = true)
    {
        if (null !== $this->collJobImagess && !$overrideExisting) {
            return;
        }
        $this->collJobImagess = new PropelObjectCollection();
        $this->collJobImagess->setModel('JobImages');
    }

    /**
     * Gets an array of JobImages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobImages[] List of JobImages objects
     * @throws PropelException
     */
    public function getJobImagess($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobImagessPartial && !$this->isNew();
        if (null === $this->collJobImagess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobImagess) {
                // return empty collection
                $this->initJobImagess();
            } else {
                $collJobImagess = JobImagesQuery::create(null, $criteria)
                    ->filterByJobs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobImagessPartial && count($collJobImagess)) {
                      $this->initJobImagess(false);

                      foreach ($collJobImagess as $obj) {
                        if (false == $this->collJobImagess->contains($obj)) {
                          $this->collJobImagess->append($obj);
                        }
                      }

                      $this->collJobImagessPartial = true;
                    }

                    $collJobImagess->getInternalIterator()->rewind();

                    return $collJobImagess;
                }

                if ($partial && $this->collJobImagess) {
                    foreach ($this->collJobImagess as $obj) {
                        if ($obj->isNew()) {
                            $collJobImagess[] = $obj;
                        }
                    }
                }

                $this->collJobImagess = $collJobImagess;
                $this->collJobImagessPartial = false;
            }
        }

        return $this->collJobImagess;
    }

    /**
     * Sets a collection of JobImages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobImagess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobImagess(PropelCollection $jobImagess, PropelPDO $con = null)
    {
        $jobImagessToDelete = $this->getJobImagess(new Criteria(), $con)->diff($jobImagess);


        $this->jobImagessScheduledForDeletion = $jobImagessToDelete;

        foreach ($jobImagessToDelete as $jobImagesRemoved) {
            $jobImagesRemoved->setJobs(null);
        }

        $this->collJobImagess = null;
        foreach ($jobImagess as $jobImages) {
            $this->addJobImages($jobImages);
        }

        $this->collJobImagess = $jobImagess;
        $this->collJobImagessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobImages objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobImages objects.
     * @throws PropelException
     */
    public function countJobImagess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobImagessPartial && !$this->isNew();
        if (null === $this->collJobImagess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobImagess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobImagess());
            }
            $query = JobImagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobs($this)
                ->count($con);
        }

        return count($this->collJobImagess);
    }

    /**
     * Method called to associate a JobImages object to this object
     * through the JobImages foreign key attribute.
     *
     * @param    JobImages $l JobImages
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobImages(JobImages $l)
    {
        if ($this->collJobImagess === null) {
            $this->initJobImagess();
            $this->collJobImagessPartial = true;
        }

        if (!in_array($l, $this->collJobImagess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobImages($l);

            if ($this->jobImagessScheduledForDeletion and $this->jobImagessScheduledForDeletion->contains($l)) {
                $this->jobImagessScheduledForDeletion->remove($this->jobImagessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobImages $jobImages The jobImages object to add.
     */
    protected function doAddJobImages($jobImages)
    {
        $this->collJobImagess[]= $jobImages;
        $jobImages->setJobs($this);
    }

    /**
     * @param	JobImages $jobImages The jobImages object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobImages($jobImages)
    {
        if ($this->getJobImagess()->contains($jobImages)) {
            $this->collJobImagess->remove($this->collJobImagess->search($jobImages));
            if (null === $this->jobImagessScheduledForDeletion) {
                $this->jobImagessScheduledForDeletion = clone $this->collJobImagess;
                $this->jobImagessScheduledForDeletion->clear();
            }
            $this->jobImagessScheduledForDeletion[]= clone $jobImages;
            $jobImages->setJobs(null);
        }

        return $this;
    }

    /**
     * Clears out the collJobVideoss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobVideoss()
     */
    public function clearJobVideoss()
    {
        $this->collJobVideoss = null; // important to set this to null since that means it is uninitialized
        $this->collJobVideossPartial = null;

        return $this;
    }

    /**
     * reset is the collJobVideoss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobVideoss($v = true)
    {
        $this->collJobVideossPartial = $v;
    }

    /**
     * Initializes the collJobVideoss collection.
     *
     * By default this just sets the collJobVideoss collection to an empty array (like clearcollJobVideoss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobVideoss($overrideExisting = true)
    {
        if (null !== $this->collJobVideoss && !$overrideExisting) {
            return;
        }
        $this->collJobVideoss = new PropelObjectCollection();
        $this->collJobVideoss->setModel('JobVideos');
    }

    /**
     * Gets an array of JobVideos objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobVideos[] List of JobVideos objects
     * @throws PropelException
     */
    public function getJobVideoss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobVideossPartial && !$this->isNew();
        if (null === $this->collJobVideoss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobVideoss) {
                // return empty collection
                $this->initJobVideoss();
            } else {
                $collJobVideoss = JobVideosQuery::create(null, $criteria)
                    ->filterByJobs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobVideossPartial && count($collJobVideoss)) {
                      $this->initJobVideoss(false);

                      foreach ($collJobVideoss as $obj) {
                        if (false == $this->collJobVideoss->contains($obj)) {
                          $this->collJobVideoss->append($obj);
                        }
                      }

                      $this->collJobVideossPartial = true;
                    }

                    $collJobVideoss->getInternalIterator()->rewind();

                    return $collJobVideoss;
                }

                if ($partial && $this->collJobVideoss) {
                    foreach ($this->collJobVideoss as $obj) {
                        if ($obj->isNew()) {
                            $collJobVideoss[] = $obj;
                        }
                    }
                }

                $this->collJobVideoss = $collJobVideoss;
                $this->collJobVideossPartial = false;
            }
        }

        return $this->collJobVideoss;
    }

    /**
     * Sets a collection of JobVideos objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobVideoss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobVideoss(PropelCollection $jobVideoss, PropelPDO $con = null)
    {
        $jobVideossToDelete = $this->getJobVideoss(new Criteria(), $con)->diff($jobVideoss);


        $this->jobVideossScheduledForDeletion = $jobVideossToDelete;

        foreach ($jobVideossToDelete as $jobVideosRemoved) {
            $jobVideosRemoved->setJobs(null);
        }

        $this->collJobVideoss = null;
        foreach ($jobVideoss as $jobVideos) {
            $this->addJobVideos($jobVideos);
        }

        $this->collJobVideoss = $jobVideoss;
        $this->collJobVideossPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobVideos objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobVideos objects.
     * @throws PropelException
     */
    public function countJobVideoss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobVideossPartial && !$this->isNew();
        if (null === $this->collJobVideoss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobVideoss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobVideoss());
            }
            $query = JobVideosQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobs($this)
                ->count($con);
        }

        return count($this->collJobVideoss);
    }

    /**
     * Method called to associate a JobVideos object to this object
     * through the JobVideos foreign key attribute.
     *
     * @param    JobVideos $l JobVideos
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobVideos(JobVideos $l)
    {
        if ($this->collJobVideoss === null) {
            $this->initJobVideoss();
            $this->collJobVideossPartial = true;
        }

        if (!in_array($l, $this->collJobVideoss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobVideos($l);

            if ($this->jobVideossScheduledForDeletion and $this->jobVideossScheduledForDeletion->contains($l)) {
                $this->jobVideossScheduledForDeletion->remove($this->jobVideossScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobVideos $jobVideos The jobVideos object to add.
     */
    protected function doAddJobVideos($jobVideos)
    {
        $this->collJobVideoss[]= $jobVideos;
        $jobVideos->setJobs($this);
    }

    /**
     * @param	JobVideos $jobVideos The jobVideos object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobVideos($jobVideos)
    {
        if ($this->getJobVideoss()->contains($jobVideos)) {
            $this->collJobVideoss->remove($this->collJobVideoss->search($jobVideos));
            if (null === $this->jobVideossScheduledForDeletion) {
                $this->jobVideossScheduledForDeletion = clone $this->collJobVideoss;
                $this->jobVideossScheduledForDeletion->clear();
            }
            $this->jobVideossScheduledForDeletion[]= clone $jobVideos;
            $jobVideos->setJobs(null);
        }

        return $this;
    }

    /**
     * Clears out the collJobPacketss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobPacketss()
     */
    public function clearJobPacketss()
    {
        $this->collJobPacketss = null; // important to set this to null since that means it is uninitialized
        $this->collJobPacketssPartial = null;

        return $this;
    }

    /**
     * reset is the collJobPacketss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobPacketss($v = true)
    {
        $this->collJobPacketssPartial = $v;
    }

    /**
     * Initializes the collJobPacketss collection.
     *
     * By default this just sets the collJobPacketss collection to an empty array (like clearcollJobPacketss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobPacketss($overrideExisting = true)
    {
        if (null !== $this->collJobPacketss && !$overrideExisting) {
            return;
        }
        $this->collJobPacketss = new PropelObjectCollection();
        $this->collJobPacketss->setModel('JobPackets');
    }

    /**
     * Gets an array of JobPackets objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobPackets[] List of JobPackets objects
     * @throws PropelException
     */
    public function getJobPacketss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobPacketssPartial && !$this->isNew();
        if (null === $this->collJobPacketss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobPacketss) {
                // return empty collection
                $this->initJobPacketss();
            } else {
                $collJobPacketss = JobPacketsQuery::create(null, $criteria)
                    ->filterByJobs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobPacketssPartial && count($collJobPacketss)) {
                      $this->initJobPacketss(false);

                      foreach ($collJobPacketss as $obj) {
                        if (false == $this->collJobPacketss->contains($obj)) {
                          $this->collJobPacketss->append($obj);
                        }
                      }

                      $this->collJobPacketssPartial = true;
                    }

                    $collJobPacketss->getInternalIterator()->rewind();

                    return $collJobPacketss;
                }

                if ($partial && $this->collJobPacketss) {
                    foreach ($this->collJobPacketss as $obj) {
                        if ($obj->isNew()) {
                            $collJobPacketss[] = $obj;
                        }
                    }
                }

                $this->collJobPacketss = $collJobPacketss;
                $this->collJobPacketssPartial = false;
            }
        }

        return $this->collJobPacketss;
    }

    /**
     * Sets a collection of JobPackets objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobPacketss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobPacketss(PropelCollection $jobPacketss, PropelPDO $con = null)
    {
        $jobPacketssToDelete = $this->getJobPacketss(new Criteria(), $con)->diff($jobPacketss);


        $this->jobPacketssScheduledForDeletion = $jobPacketssToDelete;

        foreach ($jobPacketssToDelete as $jobPacketsRemoved) {
            $jobPacketsRemoved->setJobs(null);
        }

        $this->collJobPacketss = null;
        foreach ($jobPacketss as $jobPackets) {
            $this->addJobPackets($jobPackets);
        }

        $this->collJobPacketss = $jobPacketss;
        $this->collJobPacketssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobPackets objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobPackets objects.
     * @throws PropelException
     */
    public function countJobPacketss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobPacketssPartial && !$this->isNew();
        if (null === $this->collJobPacketss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobPacketss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobPacketss());
            }
            $query = JobPacketsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobs($this)
                ->count($con);
        }

        return count($this->collJobPacketss);
    }

    /**
     * Method called to associate a JobPackets object to this object
     * through the JobPackets foreign key attribute.
     *
     * @param    JobPackets $l JobPackets
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobPackets(JobPackets $l)
    {
        if ($this->collJobPacketss === null) {
            $this->initJobPacketss();
            $this->collJobPacketssPartial = true;
        }

        if (!in_array($l, $this->collJobPacketss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobPackets($l);

            if ($this->jobPacketssScheduledForDeletion and $this->jobPacketssScheduledForDeletion->contains($l)) {
                $this->jobPacketssScheduledForDeletion->remove($this->jobPacketssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobPackets $jobPackets The jobPackets object to add.
     */
    protected function doAddJobPackets($jobPackets)
    {
        $this->collJobPacketss[]= $jobPackets;
        $jobPackets->setJobs($this);
    }

    /**
     * @param	JobPackets $jobPackets The jobPackets object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobPackets($jobPackets)
    {
        if ($this->getJobPacketss()->contains($jobPackets)) {
            $this->collJobPacketss->remove($this->collJobPacketss->search($jobPackets));
            if (null === $this->jobPacketssScheduledForDeletion) {
                $this->jobPacketssScheduledForDeletion = clone $this->collJobPacketss;
                $this->jobPacketssScheduledForDeletion->clear();
            }
            $this->jobPacketssScheduledForDeletion[]= clone $jobPackets;
            $jobPackets->setJobs(null);
        }

        return $this;
    }

    /**
     * Clears out the collJobCommentss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobCommentss()
     */
    public function clearJobCommentss()
    {
        $this->collJobCommentss = null; // important to set this to null since that means it is uninitialized
        $this->collJobCommentssPartial = null;

        return $this;
    }

    /**
     * reset is the collJobCommentss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobCommentss($v = true)
    {
        $this->collJobCommentssPartial = $v;
    }

    /**
     * Initializes the collJobCommentss collection.
     *
     * By default this just sets the collJobCommentss collection to an empty array (like clearcollJobCommentss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobCommentss($overrideExisting = true)
    {
        if (null !== $this->collJobCommentss && !$overrideExisting) {
            return;
        }
        $this->collJobCommentss = new PropelObjectCollection();
        $this->collJobCommentss->setModel('JobComments');
    }

    /**
     * Gets an array of JobComments objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobComments[] List of JobComments objects
     * @throws PropelException
     */
    public function getJobCommentss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobCommentssPartial && !$this->isNew();
        if (null === $this->collJobCommentss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobCommentss) {
                // return empty collection
                $this->initJobCommentss();
            } else {
                $collJobCommentss = JobCommentsQuery::create(null, $criteria)
                    ->filterByJobs($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobCommentssPartial && count($collJobCommentss)) {
                      $this->initJobCommentss(false);

                      foreach ($collJobCommentss as $obj) {
                        if (false == $this->collJobCommentss->contains($obj)) {
                          $this->collJobCommentss->append($obj);
                        }
                      }

                      $this->collJobCommentssPartial = true;
                    }

                    $collJobCommentss->getInternalIterator()->rewind();

                    return $collJobCommentss;
                }

                if ($partial && $this->collJobCommentss) {
                    foreach ($this->collJobCommentss as $obj) {
                        if ($obj->isNew()) {
                            $collJobCommentss[] = $obj;
                        }
                    }
                }

                $this->collJobCommentss = $collJobCommentss;
                $this->collJobCommentssPartial = false;
            }
        }

        return $this->collJobCommentss;
    }

    /**
     * Sets a collection of JobComments objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobCommentss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobCommentss(PropelCollection $jobCommentss, PropelPDO $con = null)
    {
        $jobCommentssToDelete = $this->getJobCommentss(new Criteria(), $con)->diff($jobCommentss);


        $this->jobCommentssScheduledForDeletion = $jobCommentssToDelete;

        foreach ($jobCommentssToDelete as $jobCommentsRemoved) {
            $jobCommentsRemoved->setJobs(null);
        }

        $this->collJobCommentss = null;
        foreach ($jobCommentss as $jobComments) {
            $this->addJobComments($jobComments);
        }

        $this->collJobCommentss = $jobCommentss;
        $this->collJobCommentssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobComments objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobComments objects.
     * @throws PropelException
     */
    public function countJobCommentss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobCommentssPartial && !$this->isNew();
        if (null === $this->collJobCommentss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobCommentss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobCommentss());
            }
            $query = JobCommentsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobs($this)
                ->count($con);
        }

        return count($this->collJobCommentss);
    }

    /**
     * Method called to associate a JobComments object to this object
     * through the JobComments foreign key attribute.
     *
     * @param    JobComments $l JobComments
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobComments(JobComments $l)
    {
        if ($this->collJobCommentss === null) {
            $this->initJobCommentss();
            $this->collJobCommentssPartial = true;
        }

        if (!in_array($l, $this->collJobCommentss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobComments($l);

            if ($this->jobCommentssScheduledForDeletion and $this->jobCommentssScheduledForDeletion->contains($l)) {
                $this->jobCommentssScheduledForDeletion->remove($this->jobCommentssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobComments $jobComments The jobComments object to add.
     */
    protected function doAddJobComments($jobComments)
    {
        $this->collJobCommentss[]= $jobComments;
        $jobComments->setJobs($this);
    }

    /**
     * @param	JobComments $jobComments The jobComments object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobComments($jobComments)
    {
        if ($this->getJobCommentss()->contains($jobComments)) {
            $this->collJobCommentss->remove($this->collJobCommentss->search($jobComments));
            if (null === $this->jobCommentssScheduledForDeletion) {
                $this->jobCommentssScheduledForDeletion = clone $this->collJobCommentss;
                $this->jobCommentssScheduledForDeletion->clear();
            }
            $this->jobCommentssScheduledForDeletion[]= clone $jobComments;
            $jobComments->setJobs(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Jobs is new, it will return
     * an empty collection; or if this Jobs has previously
     * been saved, it will retrieve related JobCommentss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Jobs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobComments[] List of JobComments objects
     */
    public function getJobCommentssJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobCommentsQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getJobCommentss($query, $con);
    }

    /**
     * Clears out the collJobRestsRelatedByJobId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobRestsRelatedByJobId()
     */
    public function clearJobRestsRelatedByJobId()
    {
        $this->collJobRestsRelatedByJobId = null; // important to set this to null since that means it is uninitialized
        $this->collJobRestsRelatedByJobIdPartial = null;

        return $this;
    }

    /**
     * reset is the collJobRestsRelatedByJobId collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobRestsRelatedByJobId($v = true)
    {
        $this->collJobRestsRelatedByJobIdPartial = $v;
    }

    /**
     * Initializes the collJobRestsRelatedByJobId collection.
     *
     * By default this just sets the collJobRestsRelatedByJobId collection to an empty array (like clearcollJobRestsRelatedByJobId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobRestsRelatedByJobId($overrideExisting = true)
    {
        if (null !== $this->collJobRestsRelatedByJobId && !$overrideExisting) {
            return;
        }
        $this->collJobRestsRelatedByJobId = new PropelObjectCollection();
        $this->collJobRestsRelatedByJobId->setModel('JobRest');
    }

    /**
     * Gets an array of JobRest objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobRest[] List of JobRest objects
     * @throws PropelException
     */
    public function getJobRestsRelatedByJobId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobRestsRelatedByJobIdPartial && !$this->isNew();
        if (null === $this->collJobRestsRelatedByJobId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobRestsRelatedByJobId) {
                // return empty collection
                $this->initJobRestsRelatedByJobId();
            } else {
                $collJobRestsRelatedByJobId = JobRestQuery::create(null, $criteria)
                    ->filterByJobsRelatedByJobId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobRestsRelatedByJobIdPartial && count($collJobRestsRelatedByJobId)) {
                      $this->initJobRestsRelatedByJobId(false);

                      foreach ($collJobRestsRelatedByJobId as $obj) {
                        if (false == $this->collJobRestsRelatedByJobId->contains($obj)) {
                          $this->collJobRestsRelatedByJobId->append($obj);
                        }
                      }

                      $this->collJobRestsRelatedByJobIdPartial = true;
                    }

                    $collJobRestsRelatedByJobId->getInternalIterator()->rewind();

                    return $collJobRestsRelatedByJobId;
                }

                if ($partial && $this->collJobRestsRelatedByJobId) {
                    foreach ($this->collJobRestsRelatedByJobId as $obj) {
                        if ($obj->isNew()) {
                            $collJobRestsRelatedByJobId[] = $obj;
                        }
                    }
                }

                $this->collJobRestsRelatedByJobId = $collJobRestsRelatedByJobId;
                $this->collJobRestsRelatedByJobIdPartial = false;
            }
        }

        return $this->collJobRestsRelatedByJobId;
    }

    /**
     * Sets a collection of JobRestRelatedByJobId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobRestsRelatedByJobId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobRestsRelatedByJobId(PropelCollection $jobRestsRelatedByJobId, PropelPDO $con = null)
    {
        $jobRestsRelatedByJobIdToDelete = $this->getJobRestsRelatedByJobId(new Criteria(), $con)->diff($jobRestsRelatedByJobId);


        $this->jobRestsRelatedByJobIdScheduledForDeletion = $jobRestsRelatedByJobIdToDelete;

        foreach ($jobRestsRelatedByJobIdToDelete as $jobRestRelatedByJobIdRemoved) {
            $jobRestRelatedByJobIdRemoved->setJobsRelatedByJobId(null);
        }

        $this->collJobRestsRelatedByJobId = null;
        foreach ($jobRestsRelatedByJobId as $jobRestRelatedByJobId) {
            $this->addJobRestRelatedByJobId($jobRestRelatedByJobId);
        }

        $this->collJobRestsRelatedByJobId = $jobRestsRelatedByJobId;
        $this->collJobRestsRelatedByJobIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobRest objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobRest objects.
     * @throws PropelException
     */
    public function countJobRestsRelatedByJobId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobRestsRelatedByJobIdPartial && !$this->isNew();
        if (null === $this->collJobRestsRelatedByJobId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobRestsRelatedByJobId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobRestsRelatedByJobId());
            }
            $query = JobRestQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobsRelatedByJobId($this)
                ->count($con);
        }

        return count($this->collJobRestsRelatedByJobId);
    }

    /**
     * Method called to associate a JobRest object to this object
     * through the JobRest foreign key attribute.
     *
     * @param    JobRest $l JobRest
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobRestRelatedByJobId(JobRest $l)
    {
        if ($this->collJobRestsRelatedByJobId === null) {
            $this->initJobRestsRelatedByJobId();
            $this->collJobRestsRelatedByJobIdPartial = true;
        }

        if (!in_array($l, $this->collJobRestsRelatedByJobId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobRestRelatedByJobId($l);

            if ($this->jobRestsRelatedByJobIdScheduledForDeletion and $this->jobRestsRelatedByJobIdScheduledForDeletion->contains($l)) {
                $this->jobRestsRelatedByJobIdScheduledForDeletion->remove($this->jobRestsRelatedByJobIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobRestRelatedByJobId $jobRestRelatedByJobId The jobRestRelatedByJobId object to add.
     */
    protected function doAddJobRestRelatedByJobId($jobRestRelatedByJobId)
    {
        $this->collJobRestsRelatedByJobId[]= $jobRestRelatedByJobId;
        $jobRestRelatedByJobId->setJobsRelatedByJobId($this);
    }

    /**
     * @param	JobRestRelatedByJobId $jobRestRelatedByJobId The jobRestRelatedByJobId object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobRestRelatedByJobId($jobRestRelatedByJobId)
    {
        if ($this->getJobRestsRelatedByJobId()->contains($jobRestRelatedByJobId)) {
            $this->collJobRestsRelatedByJobId->remove($this->collJobRestsRelatedByJobId->search($jobRestRelatedByJobId));
            if (null === $this->jobRestsRelatedByJobIdScheduledForDeletion) {
                $this->jobRestsRelatedByJobIdScheduledForDeletion = clone $this->collJobRestsRelatedByJobId;
                $this->jobRestsRelatedByJobIdScheduledForDeletion->clear();
            }
            $this->jobRestsRelatedByJobIdScheduledForDeletion[]= clone $jobRestRelatedByJobId;
            $jobRestRelatedByJobId->setJobsRelatedByJobId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Jobs is new, it will return
     * an empty collection; or if this Jobs has previously
     * been saved, it will retrieve related JobRestsRelatedByJobId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Jobs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobRest[] List of JobRest objects
     */
    public function getJobRestsRelatedByJobIdJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobRestQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getJobRestsRelatedByJobId($query, $con);
    }

    /**
     * Clears out the collJobRestsRelatedByVacancyId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Jobs The current object (for fluent API support)
     * @see        addJobRestsRelatedByVacancyId()
     */
    public function clearJobRestsRelatedByVacancyId()
    {
        $this->collJobRestsRelatedByVacancyId = null; // important to set this to null since that means it is uninitialized
        $this->collJobRestsRelatedByVacancyIdPartial = null;

        return $this;
    }

    /**
     * reset is the collJobRestsRelatedByVacancyId collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobRestsRelatedByVacancyId($v = true)
    {
        $this->collJobRestsRelatedByVacancyIdPartial = $v;
    }

    /**
     * Initializes the collJobRestsRelatedByVacancyId collection.
     *
     * By default this just sets the collJobRestsRelatedByVacancyId collection to an empty array (like clearcollJobRestsRelatedByVacancyId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobRestsRelatedByVacancyId($overrideExisting = true)
    {
        if (null !== $this->collJobRestsRelatedByVacancyId && !$overrideExisting) {
            return;
        }
        $this->collJobRestsRelatedByVacancyId = new PropelObjectCollection();
        $this->collJobRestsRelatedByVacancyId->setModel('JobRest');
    }

    /**
     * Gets an array of JobRest objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Jobs is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobRest[] List of JobRest objects
     * @throws PropelException
     */
    public function getJobRestsRelatedByVacancyId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobRestsRelatedByVacancyIdPartial && !$this->isNew();
        if (null === $this->collJobRestsRelatedByVacancyId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobRestsRelatedByVacancyId) {
                // return empty collection
                $this->initJobRestsRelatedByVacancyId();
            } else {
                $collJobRestsRelatedByVacancyId = JobRestQuery::create(null, $criteria)
                    ->filterByJobsRelatedByVacancyId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobRestsRelatedByVacancyIdPartial && count($collJobRestsRelatedByVacancyId)) {
                      $this->initJobRestsRelatedByVacancyId(false);

                      foreach ($collJobRestsRelatedByVacancyId as $obj) {
                        if (false == $this->collJobRestsRelatedByVacancyId->contains($obj)) {
                          $this->collJobRestsRelatedByVacancyId->append($obj);
                        }
                      }

                      $this->collJobRestsRelatedByVacancyIdPartial = true;
                    }

                    $collJobRestsRelatedByVacancyId->getInternalIterator()->rewind();

                    return $collJobRestsRelatedByVacancyId;
                }

                if ($partial && $this->collJobRestsRelatedByVacancyId) {
                    foreach ($this->collJobRestsRelatedByVacancyId as $obj) {
                        if ($obj->isNew()) {
                            $collJobRestsRelatedByVacancyId[] = $obj;
                        }
                    }
                }

                $this->collJobRestsRelatedByVacancyId = $collJobRestsRelatedByVacancyId;
                $this->collJobRestsRelatedByVacancyIdPartial = false;
            }
        }

        return $this->collJobRestsRelatedByVacancyId;
    }

    /**
     * Sets a collection of JobRestRelatedByVacancyId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobRestsRelatedByVacancyId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Jobs The current object (for fluent API support)
     */
    public function setJobRestsRelatedByVacancyId(PropelCollection $jobRestsRelatedByVacancyId, PropelPDO $con = null)
    {
        $jobRestsRelatedByVacancyIdToDelete = $this->getJobRestsRelatedByVacancyId(new Criteria(), $con)->diff($jobRestsRelatedByVacancyId);


        $this->jobRestsRelatedByVacancyIdScheduledForDeletion = $jobRestsRelatedByVacancyIdToDelete;

        foreach ($jobRestsRelatedByVacancyIdToDelete as $jobRestRelatedByVacancyIdRemoved) {
            $jobRestRelatedByVacancyIdRemoved->setJobsRelatedByVacancyId(null);
        }

        $this->collJobRestsRelatedByVacancyId = null;
        foreach ($jobRestsRelatedByVacancyId as $jobRestRelatedByVacancyId) {
            $this->addJobRestRelatedByVacancyId($jobRestRelatedByVacancyId);
        }

        $this->collJobRestsRelatedByVacancyId = $jobRestsRelatedByVacancyId;
        $this->collJobRestsRelatedByVacancyIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobRest objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobRest objects.
     * @throws PropelException
     */
    public function countJobRestsRelatedByVacancyId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobRestsRelatedByVacancyIdPartial && !$this->isNew();
        if (null === $this->collJobRestsRelatedByVacancyId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobRestsRelatedByVacancyId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobRestsRelatedByVacancyId());
            }
            $query = JobRestQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobsRelatedByVacancyId($this)
                ->count($con);
        }

        return count($this->collJobRestsRelatedByVacancyId);
    }

    /**
     * Method called to associate a JobRest object to this object
     * through the JobRest foreign key attribute.
     *
     * @param    JobRest $l JobRest
     * @return Jobs The current object (for fluent API support)
     */
    public function addJobRestRelatedByVacancyId(JobRest $l)
    {
        if ($this->collJobRestsRelatedByVacancyId === null) {
            $this->initJobRestsRelatedByVacancyId();
            $this->collJobRestsRelatedByVacancyIdPartial = true;
        }

        if (!in_array($l, $this->collJobRestsRelatedByVacancyId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobRestRelatedByVacancyId($l);

            if ($this->jobRestsRelatedByVacancyIdScheduledForDeletion and $this->jobRestsRelatedByVacancyIdScheduledForDeletion->contains($l)) {
                $this->jobRestsRelatedByVacancyIdScheduledForDeletion->remove($this->jobRestsRelatedByVacancyIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobRestRelatedByVacancyId $jobRestRelatedByVacancyId The jobRestRelatedByVacancyId object to add.
     */
    protected function doAddJobRestRelatedByVacancyId($jobRestRelatedByVacancyId)
    {
        $this->collJobRestsRelatedByVacancyId[]= $jobRestRelatedByVacancyId;
        $jobRestRelatedByVacancyId->setJobsRelatedByVacancyId($this);
    }

    /**
     * @param	JobRestRelatedByVacancyId $jobRestRelatedByVacancyId The jobRestRelatedByVacancyId object to remove.
     * @return Jobs The current object (for fluent API support)
     */
    public function removeJobRestRelatedByVacancyId($jobRestRelatedByVacancyId)
    {
        if ($this->getJobRestsRelatedByVacancyId()->contains($jobRestRelatedByVacancyId)) {
            $this->collJobRestsRelatedByVacancyId->remove($this->collJobRestsRelatedByVacancyId->search($jobRestRelatedByVacancyId));
            if (null === $this->jobRestsRelatedByVacancyIdScheduledForDeletion) {
                $this->jobRestsRelatedByVacancyIdScheduledForDeletion = clone $this->collJobRestsRelatedByVacancyId;
                $this->jobRestsRelatedByVacancyIdScheduledForDeletion->clear();
            }
            $this->jobRestsRelatedByVacancyIdScheduledForDeletion[]= clone $jobRestRelatedByVacancyId;
            $jobRestRelatedByVacancyId->setJobsRelatedByVacancyId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Jobs is new, it will return
     * an empty collection; or if this Jobs has previously
     * been saved, it will retrieve related JobRestsRelatedByVacancyId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Jobs.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobRest[] List of JobRest objects
     */
    public function getJobRestsRelatedByVacancyIdJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobRestQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getJobRestsRelatedByVacancyId($query, $con);
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
        $this->description = null;
        $this->dogovor = null;
        $this->price_from = null;
        $this->price_to = null;
        $this->resume = null;
        $this->region_id = null;
        $this->area_id = null;
        $this->shop_id = null;
        $this->cnt = null;
        $this->cnt_today = null;
        $this->cnt_tel = null;
        $this->moder_approved = null;
        $this->enabled = null;
        $this->deleted = null;
        $this->create_date = null;
        $this->publish_date = null;
        $this->publish_before_date = null;
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
            if ($this->collJobParamss) {
                foreach ($this->collJobParamss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobImagess) {
                foreach ($this->collJobImagess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobVideoss) {
                foreach ($this->collJobVideoss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobPacketss) {
                foreach ($this->collJobPacketss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobCommentss) {
                foreach ($this->collJobCommentss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobRestsRelatedByJobId) {
                foreach ($this->collJobRestsRelatedByJobId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobRestsRelatedByVacancyId) {
                foreach ($this->collJobRestsRelatedByVacancyId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aRegions instanceof Persistent) {
              $this->aRegions->clearAllReferences($deep);
            }
            if ($this->aUser instanceof Persistent) {
              $this->aUser->clearAllReferences($deep);
            }
            if ($this->aJobCategories instanceof Persistent) {
              $this->aJobCategories->clearAllReferences($deep);
            }
            if ($this->aShops instanceof Persistent) {
              $this->aShops->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collJobParamss instanceof PropelCollection) {
            $this->collJobParamss->clearIterator();
        }
        $this->collJobParamss = null;
        if ($this->collJobImagess instanceof PropelCollection) {
            $this->collJobImagess->clearIterator();
        }
        $this->collJobImagess = null;
        if ($this->collJobVideoss instanceof PropelCollection) {
            $this->collJobVideoss->clearIterator();
        }
        $this->collJobVideoss = null;
        if ($this->collJobPacketss instanceof PropelCollection) {
            $this->collJobPacketss->clearIterator();
        }
        $this->collJobPacketss = null;
        if ($this->collJobCommentss instanceof PropelCollection) {
            $this->collJobCommentss->clearIterator();
        }
        $this->collJobCommentss = null;
        if ($this->collJobRestsRelatedByJobId instanceof PropelCollection) {
            $this->collJobRestsRelatedByJobId->clearIterator();
        }
        $this->collJobRestsRelatedByJobId = null;
        if ($this->collJobRestsRelatedByVacancyId instanceof PropelCollection) {
            $this->collJobRestsRelatedByVacancyId->clearIterator();
        }
        $this->collJobRestsRelatedByVacancyId = null;
        $this->aRegions = null;
        $this->aUser = null;
        $this->aJobCategories = null;
        $this->aShops = null;
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
