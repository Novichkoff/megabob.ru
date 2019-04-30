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
use Admin\AdminBundle\Model\CouponImages;
use Admin\AdminBundle\Model\CouponImagesQuery;
use Admin\AdminBundle\Model\CouponVideos;
use Admin\AdminBundle\Model\CouponVideosQuery;
use Admin\AdminBundle\Model\Coupons;
use Admin\AdminBundle\Model\CouponsCategories;
use Admin\AdminBundle\Model\CouponsCategoriesQuery;
use Admin\AdminBundle\Model\CouponsPeer;
use Admin\AdminBundle\Model\CouponsQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\UserCoupons;
use Admin\AdminBundle\Model\UserCouponsQuery;

abstract class BaseCoupons extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\CouponsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CouponsPeer
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
     * The value for the date field.
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        string
     */
    protected $date;

    /**
     * The value for the use_before field.
     * @var        string
     */
    protected $use_before;

    /**
     * The value for the period field.
     * Note: this column has a database default value of: 30
     * @var        int
     */
    protected $period;

    /**
     * The value for the address field.
     * @var        string
     */
    protected $address;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the site field.
     * @var        string
     */
    protected $site;

    /**
     * The value for the time_work field.
     * @var        string
     */
    protected $time_work;

    /**
     * The value for the client_name field.
     * @var        string
     */
    protected $client_name;

    /**
     * The value for the client_phone field.
     * @var        string
     */
    protected $client_phone;

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
     * The value for the full_description field.
     * @var        string
     */
    protected $full_description;

    /**
     * The value for the price field.
     * @var        int
     */
    protected $price;

    /**
     * The value for the sale field.
     * @var        int
     */
    protected $sale;

    /**
     * The value for the price_old field.
     * @var        int
     */
    protected $price_old;

    /**
     * The value for the region_id field.
     * @var        int
     */
    protected $region_id;

    /**
     * The value for the cnt field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt;

    /**
     * @var        Regions
     */
    protected $aRegions;

    /**
     * @var        CouponsCategories
     */
    protected $aCouponsCategories;

    /**
     * @var        PropelObjectCollection|UserCoupons[] Collection to store aggregation of UserCoupons objects.
     */
    protected $collUserCouponss;
    protected $collUserCouponssPartial;

    /**
     * @var        PropelObjectCollection|CouponImages[] Collection to store aggregation of CouponImages objects.
     */
    protected $collCouponImagess;
    protected $collCouponImagessPartial;

    /**
     * @var        PropelObjectCollection|CouponVideos[] Collection to store aggregation of CouponVideos objects.
     */
    protected $collCouponVideoss;
    protected $collCouponVideossPartial;

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
    protected $userCouponssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $couponImagessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $couponVideossScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->enabled = false;
        $this->deleted = false;
        $this->period = 30;
        $this->cnt = 0;
    }

    /**
     * Initializes internal state of BaseCoupons object.
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
     * Get the [optionally formatted] temporal [date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDate($format = null)
    {
        if ($this->date === null) {
            return null;
        }

        if ($this->date === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->date, true), $x);
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
     * Get the [optionally formatted] temporal [use_before] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUseBefore($format = null)
    {
        if ($this->use_before === null) {
            return null;
        }

        if ($this->use_before === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->use_before);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->use_before, true), $x);
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
     * Get the [period] column value.
     *
     * @return int
     */
    public function getPeriod()
    {

        return $this->period;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {

        return $this->address;
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
     * Get the [site] column value.
     *
     * @return string
     */
    public function getSite()
    {

        return $this->site;
    }

    /**
     * Get the [time_work] column value.
     *
     * @return string
     */
    public function getTimeWork()
    {

        return $this->time_work;
    }

    /**
     * Get the [client_name] column value.
     *
     * @return string
     */
    public function getClientName()
    {

        return $this->client_name;
    }

    /**
     * Get the [client_phone] column value.
     *
     * @return string
     */
    public function getClientPhone()
    {

        return $this->client_phone;
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
     * Get the [full_description] column value.
     *
     * @return string
     */
    public function getFullDescription()
    {

        return $this->full_description;
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
     * Get the [sale] column value.
     *
     * @return int
     */
    public function getSale()
    {

        return $this->sale;
    }

    /**
     * Get the [price_old] column value.
     *
     * @return int
     */
    public function getPriceOld()
    {

        return $this->price_old;
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
     * Get the [cnt] column value.
     *
     * @return int
     */
    public function getCnt()
    {

        return $this->cnt;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CouponsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = CouponsPeer::CATEGORY_ID;
        }

        if ($this->aCouponsCategories !== null && $this->aCouponsCategories->getId() !== $v) {
            $this->aCouponsCategories = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Coupons The current object (for fluent API support)
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
            $this->modifiedColumns[] = CouponsPeer::ENABLED;
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
     * @return Coupons The current object (for fluent API support)
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
            $this->modifiedColumns[] = CouponsPeer::DELETED;
        }


        return $this;
    } // setDeleted()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Coupons The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = CouponsPeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

    /**
     * Sets the value of [use_before] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Coupons The current object (for fluent API support)
     */
    public function setUseBefore($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->use_before !== null || $dt !== null) {
            $currentDateAsString = ($this->use_before !== null && $tmpDt = new DateTime($this->use_before)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->use_before = $newDateAsString;
                $this->modifiedColumns[] = CouponsPeer::USE_BEFORE;
            }
        } // if either are not null


        return $this;
    } // setUseBefore()

    /**
     * Set the value of [period] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setPeriod($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->period !== $v) {
            $this->period = $v;
            $this->modifiedColumns[] = CouponsPeer::PERIOD;
        }


        return $this;
    } // setPeriod()

    /**
     * Set the value of [address] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[] = CouponsPeer::ADDRESS;
        }


        return $this;
    } // setAddress()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[] = CouponsPeer::PHONE;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [site] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setSite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->site !== $v) {
            $this->site = $v;
            $this->modifiedColumns[] = CouponsPeer::SITE;
        }


        return $this;
    } // setSite()

    /**
     * Set the value of [time_work] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setTimeWork($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->time_work !== $v) {
            $this->time_work = $v;
            $this->modifiedColumns[] = CouponsPeer::TIME_WORK;
        }


        return $this;
    } // setTimeWork()

    /**
     * Set the value of [client_name] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setClientName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->client_name !== $v) {
            $this->client_name = $v;
            $this->modifiedColumns[] = CouponsPeer::CLIENT_NAME;
        }


        return $this;
    } // setClientName()

    /**
     * Set the value of [client_phone] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setClientPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->client_phone !== $v) {
            $this->client_phone = $v;
            $this->modifiedColumns[] = CouponsPeer::CLIENT_PHONE;
        }


        return $this;
    } // setClientPhone()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CouponsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = CouponsPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [full_description] column.
     *
     * @param  string $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setFullDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->full_description !== $v) {
            $this->full_description = $v;
            $this->modifiedColumns[] = CouponsPeer::FULL_DESCRIPTION;
        }


        return $this;
    } // setFullDescription()

    /**
     * Set the value of [price] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setPrice($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->price !== $v) {
            $this->price = $v;
            $this->modifiedColumns[] = CouponsPeer::PRICE;
        }


        return $this;
    } // setPrice()

    /**
     * Set the value of [sale] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setSale($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->sale !== $v) {
            $this->sale = $v;
            $this->modifiedColumns[] = CouponsPeer::SALE;
        }


        return $this;
    } // setSale()

    /**
     * Set the value of [price_old] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setPriceOld($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->price_old !== $v) {
            $this->price_old = $v;
            $this->modifiedColumns[] = CouponsPeer::PRICE_OLD;
        }


        return $this;
    } // setPriceOld()

    /**
     * Set the value of [region_id] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setRegionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->region_id !== $v) {
            $this->region_id = $v;
            $this->modifiedColumns[] = CouponsPeer::REGION_ID;
        }

        if ($this->aRegions !== null && $this->aRegions->getId() !== $v) {
            $this->aRegions = null;
        }


        return $this;
    } // setRegionId()

    /**
     * Set the value of [cnt] column.
     *
     * @param  int $v new value
     * @return Coupons The current object (for fluent API support)
     */
    public function setCnt($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt !== $v) {
            $this->cnt = $v;
            $this->modifiedColumns[] = CouponsPeer::CNT;
        }


        return $this;
    } // setCnt()

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
            if ($this->enabled !== false) {
                return false;
            }

            if ($this->deleted !== false) {
                return false;
            }

            if ($this->period !== 30) {
                return false;
            }

            if ($this->cnt !== 0) {
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
            $this->enabled = ($row[$startcol + 2] !== null) ? (boolean) $row[$startcol + 2] : null;
            $this->deleted = ($row[$startcol + 3] !== null) ? (boolean) $row[$startcol + 3] : null;
            $this->date = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->use_before = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->period = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->address = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->phone = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->site = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->time_work = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->client_name = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->client_phone = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->name = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->description = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->full_description = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->price = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
            $this->sale = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->price_old = ($row[$startcol + 18] !== null) ? (int) $row[$startcol + 18] : null;
            $this->region_id = ($row[$startcol + 19] !== null) ? (int) $row[$startcol + 19] : null;
            $this->cnt = ($row[$startcol + 20] !== null) ? (int) $row[$startcol + 20] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 21; // 21 = CouponsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Coupons object", $e);
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

        if ($this->aCouponsCategories !== null && $this->category_id !== $this->aCouponsCategories->getId()) {
            $this->aCouponsCategories = null;
        }
        if ($this->aRegions !== null && $this->region_id !== $this->aRegions->getId()) {
            $this->aRegions = null;
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
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CouponsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRegions = null;
            $this->aCouponsCategories = null;
            $this->collUserCouponss = null;

            $this->collCouponImagess = null;

            $this->collCouponVideoss = null;

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
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CouponsQuery::create()
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
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                CouponsPeer::addInstanceToPool($this);
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

            if ($this->aCouponsCategories !== null) {
                if ($this->aCouponsCategories->isModified() || $this->aCouponsCategories->isNew()) {
                    $affectedRows += $this->aCouponsCategories->save($con);
                }
                $this->setCouponsCategories($this->aCouponsCategories);
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

            if ($this->userCouponssScheduledForDeletion !== null) {
                if (!$this->userCouponssScheduledForDeletion->isEmpty()) {
                    UserCouponsQuery::create()
                        ->filterByPrimaryKeys($this->userCouponssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->userCouponssScheduledForDeletion = null;
                }
            }

            if ($this->collUserCouponss !== null) {
                foreach ($this->collUserCouponss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->couponImagessScheduledForDeletion !== null) {
                if (!$this->couponImagessScheduledForDeletion->isEmpty()) {
                    CouponImagesQuery::create()
                        ->filterByPrimaryKeys($this->couponImagessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->couponImagessScheduledForDeletion = null;
                }
            }

            if ($this->collCouponImagess !== null) {
                foreach ($this->collCouponImagess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->couponVideossScheduledForDeletion !== null) {
                if (!$this->couponVideossScheduledForDeletion->isEmpty()) {
                    CouponVideosQuery::create()
                        ->filterByPrimaryKeys($this->couponVideossScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->couponVideossScheduledForDeletion = null;
                }
            }

            if ($this->collCouponVideoss !== null) {
                foreach ($this->collCouponVideoss as $referrerFK) {
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

        $this->modifiedColumns[] = CouponsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CouponsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CouponsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CouponsPeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(CouponsPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(CouponsPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(CouponsPeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`date`';
        }
        if ($this->isColumnModified(CouponsPeer::USE_BEFORE)) {
            $modifiedColumns[':p' . $index++]  = '`use_before`';
        }
        if ($this->isColumnModified(CouponsPeer::PERIOD)) {
            $modifiedColumns[':p' . $index++]  = '`period`';
        }
        if ($this->isColumnModified(CouponsPeer::ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(CouponsPeer::PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(CouponsPeer::SITE)) {
            $modifiedColumns[':p' . $index++]  = '`site`';
        }
        if ($this->isColumnModified(CouponsPeer::TIME_WORK)) {
            $modifiedColumns[':p' . $index++]  = '`time_work`';
        }
        if ($this->isColumnModified(CouponsPeer::CLIENT_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`client_name`';
        }
        if ($this->isColumnModified(CouponsPeer::CLIENT_PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`client_phone`';
        }
        if ($this->isColumnModified(CouponsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(CouponsPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(CouponsPeer::FULL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`full_description`';
        }
        if ($this->isColumnModified(CouponsPeer::PRICE)) {
            $modifiedColumns[':p' . $index++]  = '`price`';
        }
        if ($this->isColumnModified(CouponsPeer::SALE)) {
            $modifiedColumns[':p' . $index++]  = '`sale`';
        }
        if ($this->isColumnModified(CouponsPeer::PRICE_OLD)) {
            $modifiedColumns[':p' . $index++]  = '`price_old`';
        }
        if ($this->isColumnModified(CouponsPeer::REGION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`region_id`';
        }
        if ($this->isColumnModified(CouponsPeer::CNT)) {
            $modifiedColumns[':p' . $index++]  = '`cnt`';
        }

        $sql = sprintf(
            'INSERT INTO `coupons` (%s) VALUES (%s)',
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
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`deleted`':
                        $stmt->bindValue($identifier, (int) $this->deleted, PDO::PARAM_INT);
                        break;
                    case '`date`':
                        $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
                        break;
                    case '`use_before`':
                        $stmt->bindValue($identifier, $this->use_before, PDO::PARAM_STR);
                        break;
                    case '`period`':
                        $stmt->bindValue($identifier, $this->period, PDO::PARAM_INT);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`site`':
                        $stmt->bindValue($identifier, $this->site, PDO::PARAM_STR);
                        break;
                    case '`time_work`':
                        $stmt->bindValue($identifier, $this->time_work, PDO::PARAM_STR);
                        break;
                    case '`client_name`':
                        $stmt->bindValue($identifier, $this->client_name, PDO::PARAM_STR);
                        break;
                    case '`client_phone`':
                        $stmt->bindValue($identifier, $this->client_phone, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`full_description`':
                        $stmt->bindValue($identifier, $this->full_description, PDO::PARAM_STR);
                        break;
                    case '`price`':
                        $stmt->bindValue($identifier, $this->price, PDO::PARAM_INT);
                        break;
                    case '`sale`':
                        $stmt->bindValue($identifier, $this->sale, PDO::PARAM_INT);
                        break;
                    case '`price_old`':
                        $stmt->bindValue($identifier, $this->price_old, PDO::PARAM_INT);
                        break;
                    case '`region_id`':
                        $stmt->bindValue($identifier, $this->region_id, PDO::PARAM_INT);
                        break;
                    case '`cnt`':
                        $stmt->bindValue($identifier, $this->cnt, PDO::PARAM_INT);
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

            if ($this->aCouponsCategories !== null) {
                if (!$this->aCouponsCategories->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCouponsCategories->getValidationFailures());
                }
            }


            if (($retval = CouponsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collUserCouponss !== null) {
                    foreach ($this->collUserCouponss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCouponImagess !== null) {
                    foreach ($this->collCouponImagess as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCouponVideoss !== null) {
                    foreach ($this->collCouponVideoss as $referrerFK) {
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
        $pos = CouponsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getEnabled();
                break;
            case 3:
                return $this->getDeleted();
                break;
            case 4:
                return $this->getDate();
                break;
            case 5:
                return $this->getUseBefore();
                break;
            case 6:
                return $this->getPeriod();
                break;
            case 7:
                return $this->getAddress();
                break;
            case 8:
                return $this->getPhone();
                break;
            case 9:
                return $this->getSite();
                break;
            case 10:
                return $this->getTimeWork();
                break;
            case 11:
                return $this->getClientName();
                break;
            case 12:
                return $this->getClientPhone();
                break;
            case 13:
                return $this->getName();
                break;
            case 14:
                return $this->getDescription();
                break;
            case 15:
                return $this->getFullDescription();
                break;
            case 16:
                return $this->getPrice();
                break;
            case 17:
                return $this->getSale();
                break;
            case 18:
                return $this->getPriceOld();
                break;
            case 19:
                return $this->getRegionId();
                break;
            case 20:
                return $this->getCnt();
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
        if (isset($alreadyDumpedObjects['Coupons'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Coupons'][$this->getPrimaryKey()] = true;
        $keys = CouponsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getEnabled(),
            $keys[3] => $this->getDeleted(),
            $keys[4] => $this->getDate(),
            $keys[5] => $this->getUseBefore(),
            $keys[6] => $this->getPeriod(),
            $keys[7] => $this->getAddress(),
            $keys[8] => $this->getPhone(),
            $keys[9] => $this->getSite(),
            $keys[10] => $this->getTimeWork(),
            $keys[11] => $this->getClientName(),
            $keys[12] => $this->getClientPhone(),
            $keys[13] => $this->getName(),
            $keys[14] => $this->getDescription(),
            $keys[15] => $this->getFullDescription(),
            $keys[16] => $this->getPrice(),
            $keys[17] => $this->getSale(),
            $keys[18] => $this->getPriceOld(),
            $keys[19] => $this->getRegionId(),
            $keys[20] => $this->getCnt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aRegions) {
                $result['Regions'] = $this->aRegions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCouponsCategories) {
                $result['CouponsCategories'] = $this->aCouponsCategories->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collUserCouponss) {
                $result['UserCouponss'] = $this->collUserCouponss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCouponImagess) {
                $result['CouponImagess'] = $this->collCouponImagess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCouponVideoss) {
                $result['CouponVideoss'] = $this->collCouponVideoss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CouponsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setEnabled($value);
                break;
            case 3:
                $this->setDeleted($value);
                break;
            case 4:
                $this->setDate($value);
                break;
            case 5:
                $this->setUseBefore($value);
                break;
            case 6:
                $this->setPeriod($value);
                break;
            case 7:
                $this->setAddress($value);
                break;
            case 8:
                $this->setPhone($value);
                break;
            case 9:
                $this->setSite($value);
                break;
            case 10:
                $this->setTimeWork($value);
                break;
            case 11:
                $this->setClientName($value);
                break;
            case 12:
                $this->setClientPhone($value);
                break;
            case 13:
                $this->setName($value);
                break;
            case 14:
                $this->setDescription($value);
                break;
            case 15:
                $this->setFullDescription($value);
                break;
            case 16:
                $this->setPrice($value);
                break;
            case 17:
                $this->setSale($value);
                break;
            case 18:
                $this->setPriceOld($value);
                break;
            case 19:
                $this->setRegionId($value);
                break;
            case 20:
                $this->setCnt($value);
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
        $keys = CouponsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setEnabled($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDeleted($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDate($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUseBefore($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPeriod($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setAddress($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPhone($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setSite($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setTimeWork($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setClientName($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setClientPhone($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setName($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setDescription($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setFullDescription($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setPrice($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setSale($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setPriceOld($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setRegionId($arr[$keys[19]]);
        if (array_key_exists($keys[20], $arr)) $this->setCnt($arr[$keys[20]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CouponsPeer::DATABASE_NAME);

        if ($this->isColumnModified(CouponsPeer::ID)) $criteria->add(CouponsPeer::ID, $this->id);
        if ($this->isColumnModified(CouponsPeer::CATEGORY_ID)) $criteria->add(CouponsPeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(CouponsPeer::ENABLED)) $criteria->add(CouponsPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(CouponsPeer::DELETED)) $criteria->add(CouponsPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(CouponsPeer::DATE)) $criteria->add(CouponsPeer::DATE, $this->date);
        if ($this->isColumnModified(CouponsPeer::USE_BEFORE)) $criteria->add(CouponsPeer::USE_BEFORE, $this->use_before);
        if ($this->isColumnModified(CouponsPeer::PERIOD)) $criteria->add(CouponsPeer::PERIOD, $this->period);
        if ($this->isColumnModified(CouponsPeer::ADDRESS)) $criteria->add(CouponsPeer::ADDRESS, $this->address);
        if ($this->isColumnModified(CouponsPeer::PHONE)) $criteria->add(CouponsPeer::PHONE, $this->phone);
        if ($this->isColumnModified(CouponsPeer::SITE)) $criteria->add(CouponsPeer::SITE, $this->site);
        if ($this->isColumnModified(CouponsPeer::TIME_WORK)) $criteria->add(CouponsPeer::TIME_WORK, $this->time_work);
        if ($this->isColumnModified(CouponsPeer::CLIENT_NAME)) $criteria->add(CouponsPeer::CLIENT_NAME, $this->client_name);
        if ($this->isColumnModified(CouponsPeer::CLIENT_PHONE)) $criteria->add(CouponsPeer::CLIENT_PHONE, $this->client_phone);
        if ($this->isColumnModified(CouponsPeer::NAME)) $criteria->add(CouponsPeer::NAME, $this->name);
        if ($this->isColumnModified(CouponsPeer::DESCRIPTION)) $criteria->add(CouponsPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(CouponsPeer::FULL_DESCRIPTION)) $criteria->add(CouponsPeer::FULL_DESCRIPTION, $this->full_description);
        if ($this->isColumnModified(CouponsPeer::PRICE)) $criteria->add(CouponsPeer::PRICE, $this->price);
        if ($this->isColumnModified(CouponsPeer::SALE)) $criteria->add(CouponsPeer::SALE, $this->sale);
        if ($this->isColumnModified(CouponsPeer::PRICE_OLD)) $criteria->add(CouponsPeer::PRICE_OLD, $this->price_old);
        if ($this->isColumnModified(CouponsPeer::REGION_ID)) $criteria->add(CouponsPeer::REGION_ID, $this->region_id);
        if ($this->isColumnModified(CouponsPeer::CNT)) $criteria->add(CouponsPeer::CNT, $this->cnt);

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
        $criteria = new Criteria(CouponsPeer::DATABASE_NAME);
        $criteria->add(CouponsPeer::ID, $this->id);

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
     * @param object $copyObj An object of Coupons (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setDeleted($this->getDeleted());
        $copyObj->setDate($this->getDate());
        $copyObj->setUseBefore($this->getUseBefore());
        $copyObj->setPeriod($this->getPeriod());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setSite($this->getSite());
        $copyObj->setTimeWork($this->getTimeWork());
        $copyObj->setClientName($this->getClientName());
        $copyObj->setClientPhone($this->getClientPhone());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setFullDescription($this->getFullDescription());
        $copyObj->setPrice($this->getPrice());
        $copyObj->setSale($this->getSale());
        $copyObj->setPriceOld($this->getPriceOld());
        $copyObj->setRegionId($this->getRegionId());
        $copyObj->setCnt($this->getCnt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getUserCouponss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUserCoupons($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCouponImagess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCouponImages($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCouponVideoss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCouponVideos($relObj->copy($deepCopy));
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
     * @return Coupons Clone of current object.
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
     * @return CouponsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CouponsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Regions object.
     *
     * @param                  Regions $v
     * @return Coupons The current object (for fluent API support)
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
            $v->addCoupons($this);
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
                $this->aRegions->addCouponss($this);
             */
        }

        return $this->aRegions;
    }

    /**
     * Declares an association between this object and a CouponsCategories object.
     *
     * @param                  CouponsCategories $v
     * @return Coupons The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCouponsCategories(CouponsCategories $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aCouponsCategories = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the CouponsCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addCoupons($this);
        }


        return $this;
    }


    /**
     * Get the associated CouponsCategories object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return CouponsCategories The associated CouponsCategories object.
     * @throws PropelException
     */
    public function getCouponsCategories(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCouponsCategories === null && ($this->category_id !== null) && $doQuery) {
            $this->aCouponsCategories = CouponsCategoriesQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCouponsCategories->addCouponss($this);
             */
        }

        return $this->aCouponsCategories;
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
        if ('UserCoupons' == $relationName) {
            $this->initUserCouponss();
        }
        if ('CouponImages' == $relationName) {
            $this->initCouponImagess();
        }
        if ('CouponVideos' == $relationName) {
            $this->initCouponVideoss();
        }
    }

    /**
     * Clears out the collUserCouponss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Coupons The current object (for fluent API support)
     * @see        addUserCouponss()
     */
    public function clearUserCouponss()
    {
        $this->collUserCouponss = null; // important to set this to null since that means it is uninitialized
        $this->collUserCouponssPartial = null;

        return $this;
    }

    /**
     * reset is the collUserCouponss collection loaded partially
     *
     * @return void
     */
    public function resetPartialUserCouponss($v = true)
    {
        $this->collUserCouponssPartial = $v;
    }

    /**
     * Initializes the collUserCouponss collection.
     *
     * By default this just sets the collUserCouponss collection to an empty array (like clearcollUserCouponss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUserCouponss($overrideExisting = true)
    {
        if (null !== $this->collUserCouponss && !$overrideExisting) {
            return;
        }
        $this->collUserCouponss = new PropelObjectCollection();
        $this->collUserCouponss->setModel('UserCoupons');
    }

    /**
     * Gets an array of UserCoupons objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Coupons is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|UserCoupons[] List of UserCoupons objects
     * @throws PropelException
     */
    public function getUserCouponss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collUserCouponssPartial && !$this->isNew();
        if (null === $this->collUserCouponss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUserCouponss) {
                // return empty collection
                $this->initUserCouponss();
            } else {
                $collUserCouponss = UserCouponsQuery::create(null, $criteria)
                    ->filterByCoupons($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collUserCouponssPartial && count($collUserCouponss)) {
                      $this->initUserCouponss(false);

                      foreach ($collUserCouponss as $obj) {
                        if (false == $this->collUserCouponss->contains($obj)) {
                          $this->collUserCouponss->append($obj);
                        }
                      }

                      $this->collUserCouponssPartial = true;
                    }

                    $collUserCouponss->getInternalIterator()->rewind();

                    return $collUserCouponss;
                }

                if ($partial && $this->collUserCouponss) {
                    foreach ($this->collUserCouponss as $obj) {
                        if ($obj->isNew()) {
                            $collUserCouponss[] = $obj;
                        }
                    }
                }

                $this->collUserCouponss = $collUserCouponss;
                $this->collUserCouponssPartial = false;
            }
        }

        return $this->collUserCouponss;
    }

    /**
     * Sets a collection of UserCoupons objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $userCouponss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Coupons The current object (for fluent API support)
     */
    public function setUserCouponss(PropelCollection $userCouponss, PropelPDO $con = null)
    {
        $userCouponssToDelete = $this->getUserCouponss(new Criteria(), $con)->diff($userCouponss);


        $this->userCouponssScheduledForDeletion = $userCouponssToDelete;

        foreach ($userCouponssToDelete as $userCouponsRemoved) {
            $userCouponsRemoved->setCoupons(null);
        }

        $this->collUserCouponss = null;
        foreach ($userCouponss as $userCoupons) {
            $this->addUserCoupons($userCoupons);
        }

        $this->collUserCouponss = $userCouponss;
        $this->collUserCouponssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UserCoupons objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related UserCoupons objects.
     * @throws PropelException
     */
    public function countUserCouponss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collUserCouponssPartial && !$this->isNew();
        if (null === $this->collUserCouponss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUserCouponss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUserCouponss());
            }
            $query = UserCouponsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCoupons($this)
                ->count($con);
        }

        return count($this->collUserCouponss);
    }

    /**
     * Method called to associate a UserCoupons object to this object
     * through the UserCoupons foreign key attribute.
     *
     * @param    UserCoupons $l UserCoupons
     * @return Coupons The current object (for fluent API support)
     */
    public function addUserCoupons(UserCoupons $l)
    {
        if ($this->collUserCouponss === null) {
            $this->initUserCouponss();
            $this->collUserCouponssPartial = true;
        }

        if (!in_array($l, $this->collUserCouponss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddUserCoupons($l);

            if ($this->userCouponssScheduledForDeletion and $this->userCouponssScheduledForDeletion->contains($l)) {
                $this->userCouponssScheduledForDeletion->remove($this->userCouponssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	UserCoupons $userCoupons The userCoupons object to add.
     */
    protected function doAddUserCoupons($userCoupons)
    {
        $this->collUserCouponss[]= $userCoupons;
        $userCoupons->setCoupons($this);
    }

    /**
     * @param	UserCoupons $userCoupons The userCoupons object to remove.
     * @return Coupons The current object (for fluent API support)
     */
    public function removeUserCoupons($userCoupons)
    {
        if ($this->getUserCouponss()->contains($userCoupons)) {
            $this->collUserCouponss->remove($this->collUserCouponss->search($userCoupons));
            if (null === $this->userCouponssScheduledForDeletion) {
                $this->userCouponssScheduledForDeletion = clone $this->collUserCouponss;
                $this->userCouponssScheduledForDeletion->clear();
            }
            $this->userCouponssScheduledForDeletion[]= clone $userCoupons;
            $userCoupons->setCoupons(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Coupons is new, it will return
     * an empty collection; or if this Coupons has previously
     * been saved, it will retrieve related UserCouponss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Coupons.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|UserCoupons[] List of UserCoupons objects
     */
    public function getUserCouponssJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = UserCouponsQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getUserCouponss($query, $con);
    }

    /**
     * Clears out the collCouponImagess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Coupons The current object (for fluent API support)
     * @see        addCouponImagess()
     */
    public function clearCouponImagess()
    {
        $this->collCouponImagess = null; // important to set this to null since that means it is uninitialized
        $this->collCouponImagessPartial = null;

        return $this;
    }

    /**
     * reset is the collCouponImagess collection loaded partially
     *
     * @return void
     */
    public function resetPartialCouponImagess($v = true)
    {
        $this->collCouponImagessPartial = $v;
    }

    /**
     * Initializes the collCouponImagess collection.
     *
     * By default this just sets the collCouponImagess collection to an empty array (like clearcollCouponImagess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCouponImagess($overrideExisting = true)
    {
        if (null !== $this->collCouponImagess && !$overrideExisting) {
            return;
        }
        $this->collCouponImagess = new PropelObjectCollection();
        $this->collCouponImagess->setModel('CouponImages');
    }

    /**
     * Gets an array of CouponImages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Coupons is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CouponImages[] List of CouponImages objects
     * @throws PropelException
     */
    public function getCouponImagess($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCouponImagessPartial && !$this->isNew();
        if (null === $this->collCouponImagess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCouponImagess) {
                // return empty collection
                $this->initCouponImagess();
            } else {
                $collCouponImagess = CouponImagesQuery::create(null, $criteria)
                    ->filterByCoupons($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCouponImagessPartial && count($collCouponImagess)) {
                      $this->initCouponImagess(false);

                      foreach ($collCouponImagess as $obj) {
                        if (false == $this->collCouponImagess->contains($obj)) {
                          $this->collCouponImagess->append($obj);
                        }
                      }

                      $this->collCouponImagessPartial = true;
                    }

                    $collCouponImagess->getInternalIterator()->rewind();

                    return $collCouponImagess;
                }

                if ($partial && $this->collCouponImagess) {
                    foreach ($this->collCouponImagess as $obj) {
                        if ($obj->isNew()) {
                            $collCouponImagess[] = $obj;
                        }
                    }
                }

                $this->collCouponImagess = $collCouponImagess;
                $this->collCouponImagessPartial = false;
            }
        }

        return $this->collCouponImagess;
    }

    /**
     * Sets a collection of CouponImages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $couponImagess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Coupons The current object (for fluent API support)
     */
    public function setCouponImagess(PropelCollection $couponImagess, PropelPDO $con = null)
    {
        $couponImagessToDelete = $this->getCouponImagess(new Criteria(), $con)->diff($couponImagess);


        $this->couponImagessScheduledForDeletion = $couponImagessToDelete;

        foreach ($couponImagessToDelete as $couponImagesRemoved) {
            $couponImagesRemoved->setCoupons(null);
        }

        $this->collCouponImagess = null;
        foreach ($couponImagess as $couponImages) {
            $this->addCouponImages($couponImages);
        }

        $this->collCouponImagess = $couponImagess;
        $this->collCouponImagessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CouponImages objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CouponImages objects.
     * @throws PropelException
     */
    public function countCouponImagess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCouponImagessPartial && !$this->isNew();
        if (null === $this->collCouponImagess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCouponImagess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCouponImagess());
            }
            $query = CouponImagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCoupons($this)
                ->count($con);
        }

        return count($this->collCouponImagess);
    }

    /**
     * Method called to associate a CouponImages object to this object
     * through the CouponImages foreign key attribute.
     *
     * @param    CouponImages $l CouponImages
     * @return Coupons The current object (for fluent API support)
     */
    public function addCouponImages(CouponImages $l)
    {
        if ($this->collCouponImagess === null) {
            $this->initCouponImagess();
            $this->collCouponImagessPartial = true;
        }

        if (!in_array($l, $this->collCouponImagess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCouponImages($l);

            if ($this->couponImagessScheduledForDeletion and $this->couponImagessScheduledForDeletion->contains($l)) {
                $this->couponImagessScheduledForDeletion->remove($this->couponImagessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CouponImages $couponImages The couponImages object to add.
     */
    protected function doAddCouponImages($couponImages)
    {
        $this->collCouponImagess[]= $couponImages;
        $couponImages->setCoupons($this);
    }

    /**
     * @param	CouponImages $couponImages The couponImages object to remove.
     * @return Coupons The current object (for fluent API support)
     */
    public function removeCouponImages($couponImages)
    {
        if ($this->getCouponImagess()->contains($couponImages)) {
            $this->collCouponImagess->remove($this->collCouponImagess->search($couponImages));
            if (null === $this->couponImagessScheduledForDeletion) {
                $this->couponImagessScheduledForDeletion = clone $this->collCouponImagess;
                $this->couponImagessScheduledForDeletion->clear();
            }
            $this->couponImagessScheduledForDeletion[]= clone $couponImages;
            $couponImages->setCoupons(null);
        }

        return $this;
    }

    /**
     * Clears out the collCouponVideoss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Coupons The current object (for fluent API support)
     * @see        addCouponVideoss()
     */
    public function clearCouponVideoss()
    {
        $this->collCouponVideoss = null; // important to set this to null since that means it is uninitialized
        $this->collCouponVideossPartial = null;

        return $this;
    }

    /**
     * reset is the collCouponVideoss collection loaded partially
     *
     * @return void
     */
    public function resetPartialCouponVideoss($v = true)
    {
        $this->collCouponVideossPartial = $v;
    }

    /**
     * Initializes the collCouponVideoss collection.
     *
     * By default this just sets the collCouponVideoss collection to an empty array (like clearcollCouponVideoss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCouponVideoss($overrideExisting = true)
    {
        if (null !== $this->collCouponVideoss && !$overrideExisting) {
            return;
        }
        $this->collCouponVideoss = new PropelObjectCollection();
        $this->collCouponVideoss->setModel('CouponVideos');
    }

    /**
     * Gets an array of CouponVideos objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Coupons is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CouponVideos[] List of CouponVideos objects
     * @throws PropelException
     */
    public function getCouponVideoss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCouponVideossPartial && !$this->isNew();
        if (null === $this->collCouponVideoss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCouponVideoss) {
                // return empty collection
                $this->initCouponVideoss();
            } else {
                $collCouponVideoss = CouponVideosQuery::create(null, $criteria)
                    ->filterByCoupons($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCouponVideossPartial && count($collCouponVideoss)) {
                      $this->initCouponVideoss(false);

                      foreach ($collCouponVideoss as $obj) {
                        if (false == $this->collCouponVideoss->contains($obj)) {
                          $this->collCouponVideoss->append($obj);
                        }
                      }

                      $this->collCouponVideossPartial = true;
                    }

                    $collCouponVideoss->getInternalIterator()->rewind();

                    return $collCouponVideoss;
                }

                if ($partial && $this->collCouponVideoss) {
                    foreach ($this->collCouponVideoss as $obj) {
                        if ($obj->isNew()) {
                            $collCouponVideoss[] = $obj;
                        }
                    }
                }

                $this->collCouponVideoss = $collCouponVideoss;
                $this->collCouponVideossPartial = false;
            }
        }

        return $this->collCouponVideoss;
    }

    /**
     * Sets a collection of CouponVideos objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $couponVideoss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Coupons The current object (for fluent API support)
     */
    public function setCouponVideoss(PropelCollection $couponVideoss, PropelPDO $con = null)
    {
        $couponVideossToDelete = $this->getCouponVideoss(new Criteria(), $con)->diff($couponVideoss);


        $this->couponVideossScheduledForDeletion = $couponVideossToDelete;

        foreach ($couponVideossToDelete as $couponVideosRemoved) {
            $couponVideosRemoved->setCoupons(null);
        }

        $this->collCouponVideoss = null;
        foreach ($couponVideoss as $couponVideos) {
            $this->addCouponVideos($couponVideos);
        }

        $this->collCouponVideoss = $couponVideoss;
        $this->collCouponVideossPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CouponVideos objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CouponVideos objects.
     * @throws PropelException
     */
    public function countCouponVideoss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCouponVideossPartial && !$this->isNew();
        if (null === $this->collCouponVideoss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCouponVideoss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCouponVideoss());
            }
            $query = CouponVideosQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCoupons($this)
                ->count($con);
        }

        return count($this->collCouponVideoss);
    }

    /**
     * Method called to associate a CouponVideos object to this object
     * through the CouponVideos foreign key attribute.
     *
     * @param    CouponVideos $l CouponVideos
     * @return Coupons The current object (for fluent API support)
     */
    public function addCouponVideos(CouponVideos $l)
    {
        if ($this->collCouponVideoss === null) {
            $this->initCouponVideoss();
            $this->collCouponVideossPartial = true;
        }

        if (!in_array($l, $this->collCouponVideoss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCouponVideos($l);

            if ($this->couponVideossScheduledForDeletion and $this->couponVideossScheduledForDeletion->contains($l)) {
                $this->couponVideossScheduledForDeletion->remove($this->couponVideossScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CouponVideos $couponVideos The couponVideos object to add.
     */
    protected function doAddCouponVideos($couponVideos)
    {
        $this->collCouponVideoss[]= $couponVideos;
        $couponVideos->setCoupons($this);
    }

    /**
     * @param	CouponVideos $couponVideos The couponVideos object to remove.
     * @return Coupons The current object (for fluent API support)
     */
    public function removeCouponVideos($couponVideos)
    {
        if ($this->getCouponVideoss()->contains($couponVideos)) {
            $this->collCouponVideoss->remove($this->collCouponVideoss->search($couponVideos));
            if (null === $this->couponVideossScheduledForDeletion) {
                $this->couponVideossScheduledForDeletion = clone $this->collCouponVideoss;
                $this->couponVideossScheduledForDeletion->clear();
            }
            $this->couponVideossScheduledForDeletion[]= clone $couponVideos;
            $couponVideos->setCoupons(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->enabled = null;
        $this->deleted = null;
        $this->date = null;
        $this->use_before = null;
        $this->period = null;
        $this->address = null;
        $this->phone = null;
        $this->site = null;
        $this->time_work = null;
        $this->client_name = null;
        $this->client_phone = null;
        $this->name = null;
        $this->description = null;
        $this->full_description = null;
        $this->price = null;
        $this->sale = null;
        $this->price_old = null;
        $this->region_id = null;
        $this->cnt = null;
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
            if ($this->collUserCouponss) {
                foreach ($this->collUserCouponss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCouponImagess) {
                foreach ($this->collCouponImagess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCouponVideoss) {
                foreach ($this->collCouponVideoss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aRegions instanceof Persistent) {
              $this->aRegions->clearAllReferences($deep);
            }
            if ($this->aCouponsCategories instanceof Persistent) {
              $this->aCouponsCategories->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collUserCouponss instanceof PropelCollection) {
            $this->collUserCouponss->clearIterator();
        }
        $this->collUserCouponss = null;
        if ($this->collCouponImagess instanceof PropelCollection) {
            $this->collCouponImagess->clearIterator();
        }
        $this->collCouponImagess = null;
        if ($this->collCouponVideoss instanceof PropelCollection) {
            $this->collCouponVideoss->clearIterator();
        }
        $this->collCouponVideoss = null;
        $this->aRegions = null;
        $this->aCouponsCategories = null;
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
