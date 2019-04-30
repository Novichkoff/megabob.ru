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
use \PropelDateTime;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\SiteHistory;
use Admin\AdminBundle\Model\SiteHistoryPeer;
use Admin\AdminBundle\Model\SiteHistoryQuery;

abstract class BaseSiteHistory extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\SiteHistoryPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        SiteHistoryPeer
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
     * The value for the all_advs field.
     * @var        int
     */
    protected $all_advs;

    /**
     * The value for the active_advs field.
     * @var        int
     */
    protected $active_advs;

    /**
     * The value for the today_advs field.
     * @var        int
     */
    protected $today_advs;

    /**
     * The value for the google_advs field.
     * @var        int
     */
    protected $google_advs;

    /**
     * The value for the yandex_advs field.
     * @var        int
     */
    protected $yandex_advs;

    /**
     * The value for the companies field.
     * @var        int
     */
    protected $companies;

    /**
     * The value for the twitter field.
     * @var        int
     */
    protected $twitter;

    /**
     * The value for the facebook field.
     * @var        int
     */
    protected $facebook;

    /**
     * The value for the vk field.
     * @var        int
     */
    protected $vk;

    /**
     * The value for the ok field.
     * @var        int
     */
    protected $ok;

    /**
     * The value for the date field.
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        string
     */
    protected $date;

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
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of BaseSiteHistory object.
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
     * Get the [all_advs] column value.
     *
     * @return int
     */
    public function getAllAdvs()
    {

        return $this->all_advs;
    }

    /**
     * Get the [active_advs] column value.
     *
     * @return int
     */
    public function getActiveAdvs()
    {

        return $this->active_advs;
    }

    /**
     * Get the [today_advs] column value.
     *
     * @return int
     */
    public function getTodayAdvs()
    {

        return $this->today_advs;
    }

    /**
     * Get the [google_advs] column value.
     *
     * @return int
     */
    public function getGoogleAdvs()
    {

        return $this->google_advs;
    }

    /**
     * Get the [yandex_advs] column value.
     *
     * @return int
     */
    public function getYandexAdvs()
    {

        return $this->yandex_advs;
    }

    /**
     * Get the [companies] column value.
     *
     * @return int
     */
    public function getCompanies()
    {

        return $this->companies;
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
     * Get the [ok] column value.
     *
     * @return int
     */
    public function getOk()
    {

        return $this->ok;
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
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [all_advs] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setAllAdvs($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->all_advs !== $v) {
            $this->all_advs = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::ALL_ADVS;
        }


        return $this;
    } // setAllAdvs()

    /**
     * Set the value of [active_advs] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setActiveAdvs($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->active_advs !== $v) {
            $this->active_advs = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::ACTIVE_ADVS;
        }


        return $this;
    } // setActiveAdvs()

    /**
     * Set the value of [today_advs] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setTodayAdvs($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->today_advs !== $v) {
            $this->today_advs = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::TODAY_ADVS;
        }


        return $this;
    } // setTodayAdvs()

    /**
     * Set the value of [google_advs] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setGoogleAdvs($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->google_advs !== $v) {
            $this->google_advs = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::GOOGLE_ADVS;
        }


        return $this;
    } // setGoogleAdvs()

    /**
     * Set the value of [yandex_advs] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setYandexAdvs($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->yandex_advs !== $v) {
            $this->yandex_advs = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::YANDEX_ADVS;
        }


        return $this;
    } // setYandexAdvs()

    /**
     * Set the value of [companies] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setCompanies($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->companies !== $v) {
            $this->companies = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::COMPANIES;
        }


        return $this;
    } // setCompanies()

    /**
     * Set the value of [twitter] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setTwitter($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->twitter !== $v) {
            $this->twitter = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::TWITTER;
        }


        return $this;
    } // setTwitter()

    /**
     * Set the value of [facebook] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setFacebook($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->facebook !== $v) {
            $this->facebook = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::FACEBOOK;
        }


        return $this;
    } // setFacebook()

    /**
     * Set the value of [vk] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setVk($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->vk !== $v) {
            $this->vk = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::VK;
        }


        return $this;
    } // setVk()

    /**
     * Set the value of [ok] column.
     *
     * @param  int $v new value
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setOk($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->ok !== $v) {
            $this->ok = $v;
            $this->modifiedColumns[] = SiteHistoryPeer::OK;
        }


        return $this;
    } // setOk()

    /**
     * Sets the value of [date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SiteHistory The current object (for fluent API support)
     */
    public function setDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->date !== null || $dt !== null) {
            $currentDateAsString = ($this->date !== null && $tmpDt = new DateTime($this->date)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->date = $newDateAsString;
                $this->modifiedColumns[] = SiteHistoryPeer::DATE;
            }
        } // if either are not null


        return $this;
    } // setDate()

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
            $this->all_advs = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->active_advs = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->today_advs = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->google_advs = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->yandex_advs = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->companies = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->twitter = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->facebook = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->vk = ($row[$startcol + 9] !== null) ? (int) $row[$startcol + 9] : null;
            $this->ok = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->date = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 12; // 12 = SiteHistoryPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating SiteHistory object", $e);
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
            $con = Propel::getConnection(SiteHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = SiteHistoryPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

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
            $con = Propel::getConnection(SiteHistoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = SiteHistoryQuery::create()
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
            $con = Propel::getConnection(SiteHistoryPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                SiteHistoryPeer::addInstanceToPool($this);
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

        $this->modifiedColumns[] = SiteHistoryPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SiteHistoryPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SiteHistoryPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::ALL_ADVS)) {
            $modifiedColumns[':p' . $index++]  = '`all_advs`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::ACTIVE_ADVS)) {
            $modifiedColumns[':p' . $index++]  = '`active_advs`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::TODAY_ADVS)) {
            $modifiedColumns[':p' . $index++]  = '`today_advs`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::GOOGLE_ADVS)) {
            $modifiedColumns[':p' . $index++]  = '`google_advs`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::YANDEX_ADVS)) {
            $modifiedColumns[':p' . $index++]  = '`yandex_advs`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::COMPANIES)) {
            $modifiedColumns[':p' . $index++]  = '`companies`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::TWITTER)) {
            $modifiedColumns[':p' . $index++]  = '`twitter`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::FACEBOOK)) {
            $modifiedColumns[':p' . $index++]  = '`facebook`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::VK)) {
            $modifiedColumns[':p' . $index++]  = '`vk`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::OK)) {
            $modifiedColumns[':p' . $index++]  = '`ok`';
        }
        if ($this->isColumnModified(SiteHistoryPeer::DATE)) {
            $modifiedColumns[':p' . $index++]  = '`date`';
        }

        $sql = sprintf(
            'INSERT INTO `site_history` (%s) VALUES (%s)',
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
                    case '`all_advs`':
                        $stmt->bindValue($identifier, $this->all_advs, PDO::PARAM_INT);
                        break;
                    case '`active_advs`':
                        $stmt->bindValue($identifier, $this->active_advs, PDO::PARAM_INT);
                        break;
                    case '`today_advs`':
                        $stmt->bindValue($identifier, $this->today_advs, PDO::PARAM_INT);
                        break;
                    case '`google_advs`':
                        $stmt->bindValue($identifier, $this->google_advs, PDO::PARAM_INT);
                        break;
                    case '`yandex_advs`':
                        $stmt->bindValue($identifier, $this->yandex_advs, PDO::PARAM_INT);
                        break;
                    case '`companies`':
                        $stmt->bindValue($identifier, $this->companies, PDO::PARAM_INT);
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
                    case '`ok`':
                        $stmt->bindValue($identifier, $this->ok, PDO::PARAM_INT);
                        break;
                    case '`date`':
                        $stmt->bindValue($identifier, $this->date, PDO::PARAM_STR);
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


            if (($retval = SiteHistoryPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = SiteHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAllAdvs();
                break;
            case 2:
                return $this->getActiveAdvs();
                break;
            case 3:
                return $this->getTodayAdvs();
                break;
            case 4:
                return $this->getGoogleAdvs();
                break;
            case 5:
                return $this->getYandexAdvs();
                break;
            case 6:
                return $this->getCompanies();
                break;
            case 7:
                return $this->getTwitter();
                break;
            case 8:
                return $this->getFacebook();
                break;
            case 9:
                return $this->getVk();
                break;
            case 10:
                return $this->getOk();
                break;
            case 11:
                return $this->getDate();
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
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array())
    {
        if (isset($alreadyDumpedObjects['SiteHistory'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SiteHistory'][$this->getPrimaryKey()] = true;
        $keys = SiteHistoryPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAllAdvs(),
            $keys[2] => $this->getActiveAdvs(),
            $keys[3] => $this->getTodayAdvs(),
            $keys[4] => $this->getGoogleAdvs(),
            $keys[5] => $this->getYandexAdvs(),
            $keys[6] => $this->getCompanies(),
            $keys[7] => $this->getTwitter(),
            $keys[8] => $this->getFacebook(),
            $keys[9] => $this->getVk(),
            $keys[10] => $this->getOk(),
            $keys[11] => $this->getDate(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
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
        $pos = SiteHistoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAllAdvs($value);
                break;
            case 2:
                $this->setActiveAdvs($value);
                break;
            case 3:
                $this->setTodayAdvs($value);
                break;
            case 4:
                $this->setGoogleAdvs($value);
                break;
            case 5:
                $this->setYandexAdvs($value);
                break;
            case 6:
                $this->setCompanies($value);
                break;
            case 7:
                $this->setTwitter($value);
                break;
            case 8:
                $this->setFacebook($value);
                break;
            case 9:
                $this->setVk($value);
                break;
            case 10:
                $this->setOk($value);
                break;
            case 11:
                $this->setDate($value);
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
        $keys = SiteHistoryPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAllAdvs($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setActiveAdvs($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTodayAdvs($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setGoogleAdvs($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setYandexAdvs($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCompanies($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTwitter($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setFacebook($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setVk($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setOk($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDate($arr[$keys[11]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SiteHistoryPeer::DATABASE_NAME);

        if ($this->isColumnModified(SiteHistoryPeer::ID)) $criteria->add(SiteHistoryPeer::ID, $this->id);
        if ($this->isColumnModified(SiteHistoryPeer::ALL_ADVS)) $criteria->add(SiteHistoryPeer::ALL_ADVS, $this->all_advs);
        if ($this->isColumnModified(SiteHistoryPeer::ACTIVE_ADVS)) $criteria->add(SiteHistoryPeer::ACTIVE_ADVS, $this->active_advs);
        if ($this->isColumnModified(SiteHistoryPeer::TODAY_ADVS)) $criteria->add(SiteHistoryPeer::TODAY_ADVS, $this->today_advs);
        if ($this->isColumnModified(SiteHistoryPeer::GOOGLE_ADVS)) $criteria->add(SiteHistoryPeer::GOOGLE_ADVS, $this->google_advs);
        if ($this->isColumnModified(SiteHistoryPeer::YANDEX_ADVS)) $criteria->add(SiteHistoryPeer::YANDEX_ADVS, $this->yandex_advs);
        if ($this->isColumnModified(SiteHistoryPeer::COMPANIES)) $criteria->add(SiteHistoryPeer::COMPANIES, $this->companies);
        if ($this->isColumnModified(SiteHistoryPeer::TWITTER)) $criteria->add(SiteHistoryPeer::TWITTER, $this->twitter);
        if ($this->isColumnModified(SiteHistoryPeer::FACEBOOK)) $criteria->add(SiteHistoryPeer::FACEBOOK, $this->facebook);
        if ($this->isColumnModified(SiteHistoryPeer::VK)) $criteria->add(SiteHistoryPeer::VK, $this->vk);
        if ($this->isColumnModified(SiteHistoryPeer::OK)) $criteria->add(SiteHistoryPeer::OK, $this->ok);
        if ($this->isColumnModified(SiteHistoryPeer::DATE)) $criteria->add(SiteHistoryPeer::DATE, $this->date);

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
        $criteria = new Criteria(SiteHistoryPeer::DATABASE_NAME);
        $criteria->add(SiteHistoryPeer::ID, $this->id);

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
     * @param object $copyObj An object of SiteHistory (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAllAdvs($this->getAllAdvs());
        $copyObj->setActiveAdvs($this->getActiveAdvs());
        $copyObj->setTodayAdvs($this->getTodayAdvs());
        $copyObj->setGoogleAdvs($this->getGoogleAdvs());
        $copyObj->setYandexAdvs($this->getYandexAdvs());
        $copyObj->setCompanies($this->getCompanies());
        $copyObj->setTwitter($this->getTwitter());
        $copyObj->setFacebook($this->getFacebook());
        $copyObj->setVk($this->getVk());
        $copyObj->setOk($this->getOk());
        $copyObj->setDate($this->getDate());
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
     * @return SiteHistory Clone of current object.
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
     * @return SiteHistoryPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new SiteHistoryPeer();
        }

        return self::$peer;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->all_advs = null;
        $this->active_advs = null;
        $this->today_advs = null;
        $this->google_advs = null;
        $this->yandex_advs = null;
        $this->companies = null;
        $this->twitter = null;
        $this->facebook = null;
        $this->vk = null;
        $this->ok = null;
        $this->date = null;
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

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SiteHistoryPeer::DEFAULT_STRING_FORMAT);
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
