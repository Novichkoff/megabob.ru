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
use Admin\AdminBundle\Model\Banners;
use Admin\AdminBundle\Model\BannersPeer;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\BannersStat;
use Admin\AdminBundle\Model\BannersStatQuery;

abstract class BaseBanners extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\BannersPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        BannersPeer
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
     * Note: this column has a database default value of: '0'
     * @var        string
     */
    protected $category_id;

    /**
     * The value for the region_id field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $region_id;

    /**
     * The value for the client field.
     * @var        string
     */
    protected $client;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the code field.
     * @var        string
     */
    protected $code;

    /**
     * The value for the picture field.
     * @var        string
     */
    protected $picture;

    /**
     * The value for the width field.
     * Note: this column has a database default value of: 640
     * @var        int
     */
    protected $width;

    /**
     * The value for the cnt field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt;

    /**
     * The value for the show_today field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $show_today;

    /**
     * The value for the click_today field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $click_today;

    /**
     * The value for the banner_zone_id field.
     * @var        int
     */
    protected $banner_zone_id;

    /**
     * The value for the mobile field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $mobile;

    /**
     * The value for the full_size field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $full_size;

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
     * The value for the last_publish field.
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        string
     */
    protected $last_publish;

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
     * @var        PropelObjectCollection|BannersStat[] Collection to store aggregation of BannersStat objects.
     */
    protected $collBannersStats;
    protected $collBannersStatsPartial;

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
    protected $bannersStatsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->category_id = '0';
        $this->region_id = 0;
        $this->width = 640;
        $this->cnt = 0;
        $this->show_today = 0;
        $this->click_today = 0;
        $this->mobile = false;
        $this->full_size = false;
        $this->enabled = false;
        $this->deleted = false;
    }

    /**
     * Initializes internal state of BaseBanners object.
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
     * @return string
     */
    public function getCategoryId()
    {

        return $this->category_id;
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
     * Get the [client] column value.
     *
     * @return string
     */
    public function getClient()
    {

        return $this->client;
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
     * Get the [code] column value.
     *
     * @return string
     */
    public function getCode()
    {

        return $this->code;
    }

    /**
     * Get the [picture] column value.
     *
     * @return string
     */
    public function getPicture()
    {

        return $this->picture;
    }

    /**
     * Get the [width] column value.
     *
     * @return int
     */
    public function getWidth()
    {

        return $this->width;
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
     * Get the [show_today] column value.
     *
     * @return int
     */
    public function getShowToday()
    {

        return $this->show_today;
    }

    /**
     * Get the [click_today] column value.
     *
     * @return int
     */
    public function getClickToday()
    {

        return $this->click_today;
    }

    /**
     * Get the [banner_zone_id] column value.
     *
     * @return int
     */
    public function getBannerZoneId()
    {

        return $this->banner_zone_id;
    }

    /**
     * Get the [mobile] column value.
     *
     * @return boolean
     */
    public function getMobile()
    {

        return $this->mobile;
    }

    /**
     * Get the [full_size] column value.
     *
     * @return boolean
     */
    public function getFullSize()
    {

        return $this->full_size;
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
     * Get the [optionally formatted] temporal [last_publish] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastPublish($format = null)
    {
        if ($this->last_publish === null) {
            return null;
        }

        if ($this->last_publish === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->last_publish);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_publish, true), $x);
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
     * @return Banners The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = BannersPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  string $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = BannersPeer::CATEGORY_ID;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [region_id] column.
     *
     * @param  int $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setRegionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->region_id !== $v) {
            $this->region_id = $v;
            $this->modifiedColumns[] = BannersPeer::REGION_ID;
        }


        return $this;
    } // setRegionId()

    /**
     * Set the value of [client] column.
     *
     * @param  string $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setClient($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->client !== $v) {
            $this->client = $v;
            $this->modifiedColumns[] = BannersPeer::CLIENT;
        }


        return $this;
    } // setClient()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = BannersPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [code] column.
     *
     * @param  string $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[] = BannersPeer::CODE;
        }


        return $this;
    } // setCode()

    /**
     * Set the value of [picture] column.
     *
     * @param  string $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setPicture($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->picture !== $v) {
            $this->picture = $v;
            $this->modifiedColumns[] = BannersPeer::PICTURE;
        }


        return $this;
    } // setPicture()

    /**
     * Set the value of [width] column.
     *
     * @param  int $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setWidth($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->width !== $v) {
            $this->width = $v;
            $this->modifiedColumns[] = BannersPeer::WIDTH;
        }


        return $this;
    } // setWidth()

    /**
     * Set the value of [cnt] column.
     *
     * @param  int $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setCnt($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt !== $v) {
            $this->cnt = $v;
            $this->modifiedColumns[] = BannersPeer::CNT;
        }


        return $this;
    } // setCnt()

    /**
     * Set the value of [show_today] column.
     *
     * @param  int $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setShowToday($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->show_today !== $v) {
            $this->show_today = $v;
            $this->modifiedColumns[] = BannersPeer::SHOW_TODAY;
        }


        return $this;
    } // setShowToday()

    /**
     * Set the value of [click_today] column.
     *
     * @param  int $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setClickToday($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->click_today !== $v) {
            $this->click_today = $v;
            $this->modifiedColumns[] = BannersPeer::CLICK_TODAY;
        }


        return $this;
    } // setClickToday()

    /**
     * Set the value of [banner_zone_id] column.
     *
     * @param  int $v new value
     * @return Banners The current object (for fluent API support)
     */
    public function setBannerZoneId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->banner_zone_id !== $v) {
            $this->banner_zone_id = $v;
            $this->modifiedColumns[] = BannersPeer::BANNER_ZONE_ID;
        }


        return $this;
    } // setBannerZoneId()

    /**
     * Sets the value of the [mobile] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Banners The current object (for fluent API support)
     */
    public function setMobile($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->mobile !== $v) {
            $this->mobile = $v;
            $this->modifiedColumns[] = BannersPeer::MOBILE;
        }


        return $this;
    } // setMobile()

    /**
     * Sets the value of the [full_size] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Banners The current object (for fluent API support)
     */
    public function setFullSize($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->full_size !== $v) {
            $this->full_size = $v;
            $this->modifiedColumns[] = BannersPeer::FULL_SIZE;
        }


        return $this;
    } // setFullSize()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Banners The current object (for fluent API support)
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
            $this->modifiedColumns[] = BannersPeer::ENABLED;
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
     * @return Banners The current object (for fluent API support)
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
            $this->modifiedColumns[] = BannersPeer::DELETED;
        }


        return $this;
    } // setDeleted()

    /**
     * Sets the value of [last_publish] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Banners The current object (for fluent API support)
     */
    public function setLastPublish($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_publish !== null || $dt !== null) {
            $currentDateAsString = ($this->last_publish !== null && $tmpDt = new DateTime($this->last_publish)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->last_publish = $newDateAsString;
                $this->modifiedColumns[] = BannersPeer::LAST_PUBLISH;
            }
        } // if either are not null


        return $this;
    } // setLastPublish()

    /**
     * Sets the value of [publish_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Banners The current object (for fluent API support)
     */
    public function setPublishDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->publish_date !== null || $dt !== null) {
            $currentDateAsString = ($this->publish_date !== null && $tmpDt = new DateTime($this->publish_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->publish_date = $newDateAsString;
                $this->modifiedColumns[] = BannersPeer::PUBLISH_DATE;
            }
        } // if either are not null


        return $this;
    } // setPublishDate()

    /**
     * Sets the value of [publish_before_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Banners The current object (for fluent API support)
     */
    public function setPublishBeforeDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->publish_before_date !== null || $dt !== null) {
            $currentDateAsString = ($this->publish_before_date !== null && $tmpDt = new DateTime($this->publish_before_date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->publish_before_date = $newDateAsString;
                $this->modifiedColumns[] = BannersPeer::PUBLISH_BEFORE_DATE;
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
            if ($this->category_id !== '0') {
                return false;
            }

            if ($this->region_id !== 0) {
                return false;
            }

            if ($this->width !== 640) {
                return false;
            }

            if ($this->cnt !== 0) {
                return false;
            }

            if ($this->show_today !== 0) {
                return false;
            }

            if ($this->click_today !== 0) {
                return false;
            }

            if ($this->mobile !== false) {
                return false;
            }

            if ($this->full_size !== false) {
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
            $this->category_id = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->region_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->client = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->code = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->picture = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->width = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->cnt = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->show_today = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->click_today = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->banner_zone_id = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->mobile = ($row[$startcol + 12] !== null) ? (boolean) $row[$startcol + 12] : null;
            $this->full_size = ($row[$startcol + 13] !== null) ? (boolean) $row[$startcol + 13] : null;
            $this->enabled = ($row[$startcol + 14] !== null) ? (boolean) $row[$startcol + 14] : null;
            $this->deleted = ($row[$startcol + 15] !== null) ? (boolean) $row[$startcol + 15] : null;
            $this->last_publish = ($row[$startcol + 16] !== null) ? (string) $row[$startcol + 16] : null;
            $this->publish_date = ($row[$startcol + 17] !== null) ? (string) $row[$startcol + 17] : null;
            $this->publish_before_date = ($row[$startcol + 18] !== null) ? (string) $row[$startcol + 18] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 19; // 19 = BannersPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Banners object", $e);
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
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = BannersPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBannersStats = null;

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
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = BannersQuery::create()
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
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                BannersPeer::addInstanceToPool($this);
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

            if ($this->bannersStatsScheduledForDeletion !== null) {
                if (!$this->bannersStatsScheduledForDeletion->isEmpty()) {
                    BannersStatQuery::create()
                        ->filterByPrimaryKeys($this->bannersStatsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->bannersStatsScheduledForDeletion = null;
                }
            }

            if ($this->collBannersStats !== null) {
                foreach ($this->collBannersStats as $referrerFK) {
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

        $this->modifiedColumns[] = BannersPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BannersPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BannersPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(BannersPeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(BannersPeer::REGION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`region_id`';
        }
        if ($this->isColumnModified(BannersPeer::CLIENT)) {
            $modifiedColumns[':p' . $index++]  = '`client`';
        }
        if ($this->isColumnModified(BannersPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(BannersPeer::CODE)) {
            $modifiedColumns[':p' . $index++]  = '`code`';
        }
        if ($this->isColumnModified(BannersPeer::PICTURE)) {
            $modifiedColumns[':p' . $index++]  = '`picture`';
        }
        if ($this->isColumnModified(BannersPeer::WIDTH)) {
            $modifiedColumns[':p' . $index++]  = '`width`';
        }
        if ($this->isColumnModified(BannersPeer::CNT)) {
            $modifiedColumns[':p' . $index++]  = '`cnt`';
        }
        if ($this->isColumnModified(BannersPeer::SHOW_TODAY)) {
            $modifiedColumns[':p' . $index++]  = '`show_today`';
        }
        if ($this->isColumnModified(BannersPeer::CLICK_TODAY)) {
            $modifiedColumns[':p' . $index++]  = '`click_today`';
        }
        if ($this->isColumnModified(BannersPeer::BANNER_ZONE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`banner_zone_id`';
        }
        if ($this->isColumnModified(BannersPeer::MOBILE)) {
            $modifiedColumns[':p' . $index++]  = '`mobile`';
        }
        if ($this->isColumnModified(BannersPeer::FULL_SIZE)) {
            $modifiedColumns[':p' . $index++]  = '`full_size`';
        }
        if ($this->isColumnModified(BannersPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(BannersPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(BannersPeer::LAST_PUBLISH)) {
            $modifiedColumns[':p' . $index++]  = '`last_publish`';
        }
        if ($this->isColumnModified(BannersPeer::PUBLISH_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`publish_date`';
        }
        if ($this->isColumnModified(BannersPeer::PUBLISH_BEFORE_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`publish_before_date`';
        }

        $sql = sprintf(
            'INSERT INTO `banners` (%s) VALUES (%s)',
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
                        $stmt->bindValue($identifier, $this->category_id, PDO::PARAM_STR);
                        break;
                    case '`region_id`':
                        $stmt->bindValue($identifier, $this->region_id, PDO::PARAM_INT);
                        break;
                    case '`client`':
                        $stmt->bindValue($identifier, $this->client, PDO::PARAM_STR);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`code`':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_STR);
                        break;
                    case '`picture`':
                        $stmt->bindValue($identifier, $this->picture, PDO::PARAM_STR);
                        break;
                    case '`width`':
                        $stmt->bindValue($identifier, $this->width, PDO::PARAM_INT);
                        break;
                    case '`cnt`':
                        $stmt->bindValue($identifier, $this->cnt, PDO::PARAM_INT);
                        break;
                    case '`show_today`':
                        $stmt->bindValue($identifier, $this->show_today, PDO::PARAM_INT);
                        break;
                    case '`click_today`':
                        $stmt->bindValue($identifier, $this->click_today, PDO::PARAM_INT);
                        break;
                    case '`banner_zone_id`':
                        $stmt->bindValue($identifier, $this->banner_zone_id, PDO::PARAM_INT);
                        break;
                    case '`mobile`':
                        $stmt->bindValue($identifier, (int) $this->mobile, PDO::PARAM_INT);
                        break;
                    case '`full_size`':
                        $stmt->bindValue($identifier, (int) $this->full_size, PDO::PARAM_INT);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`deleted`':
                        $stmt->bindValue($identifier, (int) $this->deleted, PDO::PARAM_INT);
                        break;
                    case '`last_publish`':
                        $stmt->bindValue($identifier, $this->last_publish, PDO::PARAM_STR);
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


            if (($retval = BannersPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collBannersStats !== null) {
                    foreach ($this->collBannersStats as $referrerFK) {
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
        $pos = BannersPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getRegionId();
                break;
            case 3:
                return $this->getClient();
                break;
            case 4:
                return $this->getName();
                break;
            case 5:
                return $this->getCode();
                break;
            case 6:
                return $this->getPicture();
                break;
            case 7:
                return $this->getWidth();
                break;
            case 8:
                return $this->getCnt();
                break;
            case 9:
                return $this->getShowToday();
                break;
            case 10:
                return $this->getClickToday();
                break;
            case 11:
                return $this->getBannerZoneId();
                break;
            case 12:
                return $this->getMobile();
                break;
            case 13:
                return $this->getFullSize();
                break;
            case 14:
                return $this->getEnabled();
                break;
            case 15:
                return $this->getDeleted();
                break;
            case 16:
                return $this->getLastPublish();
                break;
            case 17:
                return $this->getPublishDate();
                break;
            case 18:
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
        if (isset($alreadyDumpedObjects['Banners'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Banners'][$this->getPrimaryKey()] = true;
        $keys = BannersPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getRegionId(),
            $keys[3] => $this->getClient(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getCode(),
            $keys[6] => $this->getPicture(),
            $keys[7] => $this->getWidth(),
            $keys[8] => $this->getCnt(),
            $keys[9] => $this->getShowToday(),
            $keys[10] => $this->getClickToday(),
            $keys[11] => $this->getBannerZoneId(),
            $keys[12] => $this->getMobile(),
            $keys[13] => $this->getFullSize(),
            $keys[14] => $this->getEnabled(),
            $keys[15] => $this->getDeleted(),
            $keys[16] => $this->getLastPublish(),
            $keys[17] => $this->getPublishDate(),
            $keys[18] => $this->getPublishBeforeDate(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collBannersStats) {
                $result['BannersStats'] = $this->collBannersStats->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = BannersPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setRegionId($value);
                break;
            case 3:
                $this->setClient($value);
                break;
            case 4:
                $this->setName($value);
                break;
            case 5:
                $this->setCode($value);
                break;
            case 6:
                $this->setPicture($value);
                break;
            case 7:
                $this->setWidth($value);
                break;
            case 8:
                $this->setCnt($value);
                break;
            case 9:
                $this->setShowToday($value);
                break;
            case 10:
                $this->setClickToday($value);
                break;
            case 11:
                $this->setBannerZoneId($value);
                break;
            case 12:
                $this->setMobile($value);
                break;
            case 13:
                $this->setFullSize($value);
                break;
            case 14:
                $this->setEnabled($value);
                break;
            case 15:
                $this->setDeleted($value);
                break;
            case 16:
                $this->setLastPublish($value);
                break;
            case 17:
                $this->setPublishDate($value);
                break;
            case 18:
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
        $keys = BannersPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setRegionId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setClient($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCode($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPicture($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setWidth($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setCnt($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setShowToday($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setClickToday($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setBannerZoneId($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setMobile($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setFullSize($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setEnabled($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setDeleted($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setLastPublish($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setPublishDate($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setPublishBeforeDate($arr[$keys[18]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(BannersPeer::DATABASE_NAME);

        if ($this->isColumnModified(BannersPeer::ID)) $criteria->add(BannersPeer::ID, $this->id);
        if ($this->isColumnModified(BannersPeer::CATEGORY_ID)) $criteria->add(BannersPeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(BannersPeer::REGION_ID)) $criteria->add(BannersPeer::REGION_ID, $this->region_id);
        if ($this->isColumnModified(BannersPeer::CLIENT)) $criteria->add(BannersPeer::CLIENT, $this->client);
        if ($this->isColumnModified(BannersPeer::NAME)) $criteria->add(BannersPeer::NAME, $this->name);
        if ($this->isColumnModified(BannersPeer::CODE)) $criteria->add(BannersPeer::CODE, $this->code);
        if ($this->isColumnModified(BannersPeer::PICTURE)) $criteria->add(BannersPeer::PICTURE, $this->picture);
        if ($this->isColumnModified(BannersPeer::WIDTH)) $criteria->add(BannersPeer::WIDTH, $this->width);
        if ($this->isColumnModified(BannersPeer::CNT)) $criteria->add(BannersPeer::CNT, $this->cnt);
        if ($this->isColumnModified(BannersPeer::SHOW_TODAY)) $criteria->add(BannersPeer::SHOW_TODAY, $this->show_today);
        if ($this->isColumnModified(BannersPeer::CLICK_TODAY)) $criteria->add(BannersPeer::CLICK_TODAY, $this->click_today);
        if ($this->isColumnModified(BannersPeer::BANNER_ZONE_ID)) $criteria->add(BannersPeer::BANNER_ZONE_ID, $this->banner_zone_id);
        if ($this->isColumnModified(BannersPeer::MOBILE)) $criteria->add(BannersPeer::MOBILE, $this->mobile);
        if ($this->isColumnModified(BannersPeer::FULL_SIZE)) $criteria->add(BannersPeer::FULL_SIZE, $this->full_size);
        if ($this->isColumnModified(BannersPeer::ENABLED)) $criteria->add(BannersPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(BannersPeer::DELETED)) $criteria->add(BannersPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(BannersPeer::LAST_PUBLISH)) $criteria->add(BannersPeer::LAST_PUBLISH, $this->last_publish);
        if ($this->isColumnModified(BannersPeer::PUBLISH_DATE)) $criteria->add(BannersPeer::PUBLISH_DATE, $this->publish_date);
        if ($this->isColumnModified(BannersPeer::PUBLISH_BEFORE_DATE)) $criteria->add(BannersPeer::PUBLISH_BEFORE_DATE, $this->publish_before_date);

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
        $criteria = new Criteria(BannersPeer::DATABASE_NAME);
        $criteria->add(BannersPeer::ID, $this->id);

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
     * @param object $copyObj An object of Banners (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setRegionId($this->getRegionId());
        $copyObj->setClient($this->getClient());
        $copyObj->setName($this->getName());
        $copyObj->setCode($this->getCode());
        $copyObj->setPicture($this->getPicture());
        $copyObj->setWidth($this->getWidth());
        $copyObj->setCnt($this->getCnt());
        $copyObj->setShowToday($this->getShowToday());
        $copyObj->setClickToday($this->getClickToday());
        $copyObj->setBannerZoneId($this->getBannerZoneId());
        $copyObj->setMobile($this->getMobile());
        $copyObj->setFullSize($this->getFullSize());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setDeleted($this->getDeleted());
        $copyObj->setLastPublish($this->getLastPublish());
        $copyObj->setPublishDate($this->getPublishDate());
        $copyObj->setPublishBeforeDate($this->getPublishBeforeDate());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getBannersStats() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBannersStat($relObj->copy($deepCopy));
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
     * @return Banners Clone of current object.
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
     * @return BannersPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new BannersPeer();
        }

        return self::$peer;
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
        if ('BannersStat' == $relationName) {
            $this->initBannersStats();
        }
    }

    /**
     * Clears out the collBannersStats collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Banners The current object (for fluent API support)
     * @see        addBannersStats()
     */
    public function clearBannersStats()
    {
        $this->collBannersStats = null; // important to set this to null since that means it is uninitialized
        $this->collBannersStatsPartial = null;

        return $this;
    }

    /**
     * reset is the collBannersStats collection loaded partially
     *
     * @return void
     */
    public function resetPartialBannersStats($v = true)
    {
        $this->collBannersStatsPartial = $v;
    }

    /**
     * Initializes the collBannersStats collection.
     *
     * By default this just sets the collBannersStats collection to an empty array (like clearcollBannersStats());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBannersStats($overrideExisting = true)
    {
        if (null !== $this->collBannersStats && !$overrideExisting) {
            return;
        }
        $this->collBannersStats = new PropelObjectCollection();
        $this->collBannersStats->setModel('BannersStat');
    }

    /**
     * Gets an array of BannersStat objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Banners is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BannersStat[] List of BannersStat objects
     * @throws PropelException
     */
    public function getBannersStats($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBannersStatsPartial && !$this->isNew();
        if (null === $this->collBannersStats || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBannersStats) {
                // return empty collection
                $this->initBannersStats();
            } else {
                $collBannersStats = BannersStatQuery::create(null, $criteria)
                    ->filterByBanners($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBannersStatsPartial && count($collBannersStats)) {
                      $this->initBannersStats(false);

                      foreach ($collBannersStats as $obj) {
                        if (false == $this->collBannersStats->contains($obj)) {
                          $this->collBannersStats->append($obj);
                        }
                      }

                      $this->collBannersStatsPartial = true;
                    }

                    $collBannersStats->getInternalIterator()->rewind();

                    return $collBannersStats;
                }

                if ($partial && $this->collBannersStats) {
                    foreach ($this->collBannersStats as $obj) {
                        if ($obj->isNew()) {
                            $collBannersStats[] = $obj;
                        }
                    }
                }

                $this->collBannersStats = $collBannersStats;
                $this->collBannersStatsPartial = false;
            }
        }

        return $this->collBannersStats;
    }

    /**
     * Sets a collection of BannersStat objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $bannersStats A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Banners The current object (for fluent API support)
     */
    public function setBannersStats(PropelCollection $bannersStats, PropelPDO $con = null)
    {
        $bannersStatsToDelete = $this->getBannersStats(new Criteria(), $con)->diff($bannersStats);


        $this->bannersStatsScheduledForDeletion = $bannersStatsToDelete;

        foreach ($bannersStatsToDelete as $bannersStatRemoved) {
            $bannersStatRemoved->setBanners(null);
        }

        $this->collBannersStats = null;
        foreach ($bannersStats as $bannersStat) {
            $this->addBannersStat($bannersStat);
        }

        $this->collBannersStats = $bannersStats;
        $this->collBannersStatsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BannersStat objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BannersStat objects.
     * @throws PropelException
     */
    public function countBannersStats(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBannersStatsPartial && !$this->isNew();
        if (null === $this->collBannersStats || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBannersStats) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getBannersStats());
            }
            $query = BannersStatQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBanners($this)
                ->count($con);
        }

        return count($this->collBannersStats);
    }

    /**
     * Method called to associate a BannersStat object to this object
     * through the BannersStat foreign key attribute.
     *
     * @param    BannersStat $l BannersStat
     * @return Banners The current object (for fluent API support)
     */
    public function addBannersStat(BannersStat $l)
    {
        if ($this->collBannersStats === null) {
            $this->initBannersStats();
            $this->collBannersStatsPartial = true;
        }

        if (!in_array($l, $this->collBannersStats->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBannersStat($l);

            if ($this->bannersStatsScheduledForDeletion and $this->bannersStatsScheduledForDeletion->contains($l)) {
                $this->bannersStatsScheduledForDeletion->remove($this->bannersStatsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	BannersStat $bannersStat The bannersStat object to add.
     */
    protected function doAddBannersStat($bannersStat)
    {
        $this->collBannersStats[]= $bannersStat;
        $bannersStat->setBanners($this);
    }

    /**
     * @param	BannersStat $bannersStat The bannersStat object to remove.
     * @return Banners The current object (for fluent API support)
     */
    public function removeBannersStat($bannersStat)
    {
        if ($this->getBannersStats()->contains($bannersStat)) {
            $this->collBannersStats->remove($this->collBannersStats->search($bannersStat));
            if (null === $this->bannersStatsScheduledForDeletion) {
                $this->bannersStatsScheduledForDeletion = clone $this->collBannersStats;
                $this->bannersStatsScheduledForDeletion->clear();
            }
            $this->bannersStatsScheduledForDeletion[]= clone $bannersStat;
            $bannersStat->setBanners(null);
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
        $this->region_id = null;
        $this->client = null;
        $this->name = null;
        $this->code = null;
        $this->picture = null;
        $this->width = null;
        $this->cnt = null;
        $this->show_today = null;
        $this->click_today = null;
        $this->banner_zone_id = null;
        $this->mobile = null;
        $this->full_size = null;
        $this->enabled = null;
        $this->deleted = null;
        $this->last_publish = null;
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
            if ($this->collBannersStats) {
                foreach ($this->collBannersStats as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collBannersStats instanceof PropelCollection) {
            $this->collBannersStats->clearIterator();
        }
        $this->collBannersStats = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BannersPeer::DEFAULT_STRING_FORMAT);
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
