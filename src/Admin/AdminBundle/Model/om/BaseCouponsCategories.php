<?php

namespace Admin\AdminBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Admin\AdminBundle\Model\Coupons;
use Admin\AdminBundle\Model\CouponsCategories;
use Admin\AdminBundle\Model\CouponsCategoriesPeer;
use Admin\AdminBundle\Model\CouponsCategoriesQuery;
use Admin\AdminBundle\Model\CouponsQuery;

abstract class BaseCouponsCategories extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\CouponsCategoriesPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CouponsCategoriesPeer
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
     * The value for the parent_id field.
     * @var        int
     */
    protected $parent_id;

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
     * The value for the pagetitle field.
     * @var        string
     */
    protected $pagetitle;

    /**
     * The value for the catch_phrase field.
     * @var        string
     */
    protected $catch_phrase;

    /**
     * The value for the icon field.
     * @var        string
     */
    protected $icon;

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
     * The value for the usemap field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $usemap;

    /**
     * The value for the onmain field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $onmain;

    /**
     * @var        CouponsCategories
     */
    protected $aCouponsCategoriesRelatedByParentId;

    /**
     * @var        PropelObjectCollection|CouponsCategories[] Collection to store aggregation of CouponsCategories objects.
     */
    protected $collCouponsChildss;
    protected $collCouponsChildssPartial;

    /**
     * @var        PropelObjectCollection|Coupons[] Collection to store aggregation of Coupons objects.
     */
    protected $collCouponss;
    protected $collCouponssPartial;

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
    protected $couponsChildssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $couponssScheduledForDeletion = null;

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
        $this->usemap = false;
        $this->onmain = false;
    }

    /**
     * Initializes internal state of BaseCouponsCategories object.
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
     * Get the [parent_id] column value.
     *
     * @return int
     */
    public function getParentId()
    {

        return $this->parent_id;
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
     * Get the [pagetitle] column value.
     *
     * @return string
     */
    public function getPagetitle()
    {

        return $this->pagetitle;
    }

    /**
     * Get the [catch_phrase] column value.
     *
     * @return string
     */
    public function getCatchPhrase()
    {

        return $this->catch_phrase;
    }

    /**
     * Get the [icon] column value.
     *
     * @return string
     */
    public function getIcon()
    {

        return $this->icon;
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
     * Get the [usemap] column value.
     *
     * @return boolean
     */
    public function getUsemap()
    {

        return $this->usemap;
    }

    /**
     * Get the [onmain] column value.
     *
     * @return boolean
     */
    public function getOnmain()
    {

        return $this->onmain;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param  int $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::PARENT_ID;
        }

        if ($this->aCouponsCategoriesRelatedByParentId !== null && $this->aCouponsCategoriesRelatedByParentId->getId() !== $v) {
            $this->aCouponsCategoriesRelatedByParentId = null;
        }


        return $this;
    } // setParentId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [pagetitle] column.
     *
     * @param  string $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setPagetitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pagetitle !== $v) {
            $this->pagetitle = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::PAGETITLE;
        }


        return $this;
    } // setPagetitle()

    /**
     * Set the value of [catch_phrase] column.
     *
     * @param  string $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setCatchPhrase($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->catch_phrase !== $v) {
            $this->catch_phrase = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::CATCH_PHRASE;
        }


        return $this;
    } // setCatchPhrase()

    /**
     * Set the value of [icon] column.
     *
     * @param  string $v new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::ICON;
        }


        return $this;
    } // setIcon()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return CouponsCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = CouponsCategoriesPeer::ENABLED;
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
     * @return CouponsCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = CouponsCategoriesPeer::DELETED;
        }


        return $this;
    } // setDeleted()

    /**
     * Sets the value of the [usemap] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setUsemap($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->usemap !== $v) {
            $this->usemap = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::USEMAP;
        }


        return $this;
    } // setUsemap()

    /**
     * Sets the value of the [onmain] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setOnmain($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->onmain !== $v) {
            $this->onmain = $v;
            $this->modifiedColumns[] = CouponsCategoriesPeer::ONMAIN;
        }


        return $this;
    } // setOnmain()

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

            if ($this->usemap !== false) {
                return false;
            }

            if ($this->onmain !== false) {
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
            $this->parent_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->alias = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->pagetitle = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->catch_phrase = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->icon = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->enabled = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
            $this->deleted = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
            $this->usemap = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
            $this->onmain = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 11; // 11 = CouponsCategoriesPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating CouponsCategories object", $e);
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

        if ($this->aCouponsCategoriesRelatedByParentId !== null && $this->parent_id !== $this->aCouponsCategoriesRelatedByParentId->getId()) {
            $this->aCouponsCategoriesRelatedByParentId = null;
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
            $con = Propel::getConnection(CouponsCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CouponsCategoriesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCouponsCategoriesRelatedByParentId = null;
            $this->collCouponsChildss = null;

            $this->collCouponss = null;

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
            $con = Propel::getConnection(CouponsCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CouponsCategoriesQuery::create()
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
            $con = Propel::getConnection(CouponsCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                CouponsCategoriesPeer::addInstanceToPool($this);
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

            if ($this->aCouponsCategoriesRelatedByParentId !== null) {
                if ($this->aCouponsCategoriesRelatedByParentId->isModified() || $this->aCouponsCategoriesRelatedByParentId->isNew()) {
                    $affectedRows += $this->aCouponsCategoriesRelatedByParentId->save($con);
                }
                $this->setCouponsCategoriesRelatedByParentId($this->aCouponsCategoriesRelatedByParentId);
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

            if ($this->couponsChildssScheduledForDeletion !== null) {
                if (!$this->couponsChildssScheduledForDeletion->isEmpty()) {
                    CouponsCategoriesQuery::create()
                        ->filterByPrimaryKeys($this->couponsChildssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->couponsChildssScheduledForDeletion = null;
                }
            }

            if ($this->collCouponsChildss !== null) {
                foreach ($this->collCouponsChildss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->couponssScheduledForDeletion !== null) {
                if (!$this->couponssScheduledForDeletion->isEmpty()) {
                    CouponsQuery::create()
                        ->filterByPrimaryKeys($this->couponssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->couponssScheduledForDeletion = null;
                }
            }

            if ($this->collCouponss !== null) {
                foreach ($this->collCouponss as $referrerFK) {
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

        $this->modifiedColumns[] = CouponsCategoriesPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CouponsCategoriesPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CouponsCategoriesPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_id`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::PAGETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`pagetitle`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::CATCH_PHRASE)) {
            $modifiedColumns[':p' . $index++]  = '`catch_phrase`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::USEMAP)) {
            $modifiedColumns[':p' . $index++]  = '`usemap`';
        }
        if ($this->isColumnModified(CouponsCategoriesPeer::ONMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`onmain`';
        }

        $sql = sprintf(
            'INSERT INTO `coupons_categories` (%s) VALUES (%s)',
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
                    case '`parent_id`':
                        $stmt->bindValue($identifier, $this->parent_id, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`alias`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                    case '`pagetitle`':
                        $stmt->bindValue($identifier, $this->pagetitle, PDO::PARAM_STR);
                        break;
                    case '`catch_phrase`':
                        $stmt->bindValue($identifier, $this->catch_phrase, PDO::PARAM_STR);
                        break;
                    case '`icon`':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`deleted`':
                        $stmt->bindValue($identifier, (int) $this->deleted, PDO::PARAM_INT);
                        break;
                    case '`usemap`':
                        $stmt->bindValue($identifier, (int) $this->usemap, PDO::PARAM_INT);
                        break;
                    case '`onmain`':
                        $stmt->bindValue($identifier, (int) $this->onmain, PDO::PARAM_INT);
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

            if ($this->aCouponsCategoriesRelatedByParentId !== null) {
                if (!$this->aCouponsCategoriesRelatedByParentId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCouponsCategoriesRelatedByParentId->getValidationFailures());
                }
            }


            if (($retval = CouponsCategoriesPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collCouponsChildss !== null) {
                    foreach ($this->collCouponsChildss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCouponss !== null) {
                    foreach ($this->collCouponss as $referrerFK) {
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
        $pos = CouponsCategoriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getParentId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getAlias();
                break;
            case 4:
                return $this->getPagetitle();
                break;
            case 5:
                return $this->getCatchPhrase();
                break;
            case 6:
                return $this->getIcon();
                break;
            case 7:
                return $this->getEnabled();
                break;
            case 8:
                return $this->getDeleted();
                break;
            case 9:
                return $this->getUsemap();
                break;
            case 10:
                return $this->getOnmain();
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
        if (isset($alreadyDumpedObjects['CouponsCategories'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CouponsCategories'][$this->getPrimaryKey()] = true;
        $keys = CouponsCategoriesPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getParentId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getAlias(),
            $keys[4] => $this->getPagetitle(),
            $keys[5] => $this->getCatchPhrase(),
            $keys[6] => $this->getIcon(),
            $keys[7] => $this->getEnabled(),
            $keys[8] => $this->getDeleted(),
            $keys[9] => $this->getUsemap(),
            $keys[10] => $this->getOnmain(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aCouponsCategoriesRelatedByParentId) {
                $result['CouponsCategoriesRelatedByParentId'] = $this->aCouponsCategoriesRelatedByParentId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCouponsChildss) {
                $result['CouponsChildss'] = $this->collCouponsChildss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCouponss) {
                $result['Couponss'] = $this->collCouponss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CouponsCategoriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setParentId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setAlias($value);
                break;
            case 4:
                $this->setPagetitle($value);
                break;
            case 5:
                $this->setCatchPhrase($value);
                break;
            case 6:
                $this->setIcon($value);
                break;
            case 7:
                $this->setEnabled($value);
                break;
            case 8:
                $this->setDeleted($value);
                break;
            case 9:
                $this->setUsemap($value);
                break;
            case 10:
                $this->setOnmain($value);
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
        $keys = CouponsCategoriesPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setParentId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAlias($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPagetitle($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setCatchPhrase($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIcon($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setEnabled($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDeleted($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setUsemap($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setOnmain($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CouponsCategoriesPeer::DATABASE_NAME);

        if ($this->isColumnModified(CouponsCategoriesPeer::ID)) $criteria->add(CouponsCategoriesPeer::ID, $this->id);
        if ($this->isColumnModified(CouponsCategoriesPeer::PARENT_ID)) $criteria->add(CouponsCategoriesPeer::PARENT_ID, $this->parent_id);
        if ($this->isColumnModified(CouponsCategoriesPeer::NAME)) $criteria->add(CouponsCategoriesPeer::NAME, $this->name);
        if ($this->isColumnModified(CouponsCategoriesPeer::ALIAS)) $criteria->add(CouponsCategoriesPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(CouponsCategoriesPeer::PAGETITLE)) $criteria->add(CouponsCategoriesPeer::PAGETITLE, $this->pagetitle);
        if ($this->isColumnModified(CouponsCategoriesPeer::CATCH_PHRASE)) $criteria->add(CouponsCategoriesPeer::CATCH_PHRASE, $this->catch_phrase);
        if ($this->isColumnModified(CouponsCategoriesPeer::ICON)) $criteria->add(CouponsCategoriesPeer::ICON, $this->icon);
        if ($this->isColumnModified(CouponsCategoriesPeer::ENABLED)) $criteria->add(CouponsCategoriesPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(CouponsCategoriesPeer::DELETED)) $criteria->add(CouponsCategoriesPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(CouponsCategoriesPeer::USEMAP)) $criteria->add(CouponsCategoriesPeer::USEMAP, $this->usemap);
        if ($this->isColumnModified(CouponsCategoriesPeer::ONMAIN)) $criteria->add(CouponsCategoriesPeer::ONMAIN, $this->onmain);

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
        $criteria = new Criteria(CouponsCategoriesPeer::DATABASE_NAME);
        $criteria->add(CouponsCategoriesPeer::ID, $this->id);

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
     * @param object $copyObj An object of CouponsCategories (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setParentId($this->getParentId());
        $copyObj->setName($this->getName());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setPagetitle($this->getPagetitle());
        $copyObj->setCatchPhrase($this->getCatchPhrase());
        $copyObj->setIcon($this->getIcon());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setDeleted($this->getDeleted());
        $copyObj->setUsemap($this->getUsemap());
        $copyObj->setOnmain($this->getOnmain());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getCouponsChildss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCouponsChilds($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCouponss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCoupons($relObj->copy($deepCopy));
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
     * @return CouponsCategories Clone of current object.
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
     * @return CouponsCategoriesPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CouponsCategoriesPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a CouponsCategories object.
     *
     * @param                  CouponsCategories $v
     * @return CouponsCategories The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCouponsCategoriesRelatedByParentId(CouponsCategories $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aCouponsCategoriesRelatedByParentId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the CouponsCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addCouponsChilds($this);
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
    public function getCouponsCategoriesRelatedByParentId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCouponsCategoriesRelatedByParentId === null && ($this->parent_id !== null) && $doQuery) {
            $this->aCouponsCategoriesRelatedByParentId = CouponsCategoriesQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCouponsCategoriesRelatedByParentId->addCouponsChildss($this);
             */
        }

        return $this->aCouponsCategoriesRelatedByParentId;
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
        if ('CouponsChilds' == $relationName) {
            $this->initCouponsChildss();
        }
        if ('Coupons' == $relationName) {
            $this->initCouponss();
        }
    }

    /**
     * Clears out the collCouponsChildss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return CouponsCategories The current object (for fluent API support)
     * @see        addCouponsChildss()
     */
    public function clearCouponsChildss()
    {
        $this->collCouponsChildss = null; // important to set this to null since that means it is uninitialized
        $this->collCouponsChildssPartial = null;

        return $this;
    }

    /**
     * reset is the collCouponsChildss collection loaded partially
     *
     * @return void
     */
    public function resetPartialCouponsChildss($v = true)
    {
        $this->collCouponsChildssPartial = $v;
    }

    /**
     * Initializes the collCouponsChildss collection.
     *
     * By default this just sets the collCouponsChildss collection to an empty array (like clearcollCouponsChildss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCouponsChildss($overrideExisting = true)
    {
        if (null !== $this->collCouponsChildss && !$overrideExisting) {
            return;
        }
        $this->collCouponsChildss = new PropelObjectCollection();
        $this->collCouponsChildss->setModel('CouponsCategories');
    }

    /**
     * Gets an array of CouponsCategories objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this CouponsCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CouponsCategories[] List of CouponsCategories objects
     * @throws PropelException
     */
    public function getCouponsChildss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCouponsChildssPartial && !$this->isNew();
        if (null === $this->collCouponsChildss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCouponsChildss) {
                // return empty collection
                $this->initCouponsChildss();
            } else {
                $collCouponsChildss = CouponsCategoriesQuery::create(null, $criteria)
                    ->filterByCouponsCategoriesRelatedByParentId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCouponsChildssPartial && count($collCouponsChildss)) {
                      $this->initCouponsChildss(false);

                      foreach ($collCouponsChildss as $obj) {
                        if (false == $this->collCouponsChildss->contains($obj)) {
                          $this->collCouponsChildss->append($obj);
                        }
                      }

                      $this->collCouponsChildssPartial = true;
                    }

                    $collCouponsChildss->getInternalIterator()->rewind();

                    return $collCouponsChildss;
                }

                if ($partial && $this->collCouponsChildss) {
                    foreach ($this->collCouponsChildss as $obj) {
                        if ($obj->isNew()) {
                            $collCouponsChildss[] = $obj;
                        }
                    }
                }

                $this->collCouponsChildss = $collCouponsChildss;
                $this->collCouponsChildssPartial = false;
            }
        }

        return $this->collCouponsChildss;
    }

    /**
     * Sets a collection of CouponsChilds objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $couponsChildss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setCouponsChildss(PropelCollection $couponsChildss, PropelPDO $con = null)
    {
        $couponsChildssToDelete = $this->getCouponsChildss(new Criteria(), $con)->diff($couponsChildss);


        $this->couponsChildssScheduledForDeletion = $couponsChildssToDelete;

        foreach ($couponsChildssToDelete as $couponsChildsRemoved) {
            $couponsChildsRemoved->setCouponsCategoriesRelatedByParentId(null);
        }

        $this->collCouponsChildss = null;
        foreach ($couponsChildss as $couponsChilds) {
            $this->addCouponsChilds($couponsChilds);
        }

        $this->collCouponsChildss = $couponsChildss;
        $this->collCouponsChildssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CouponsCategories objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CouponsCategories objects.
     * @throws PropelException
     */
    public function countCouponsChildss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCouponsChildssPartial && !$this->isNew();
        if (null === $this->collCouponsChildss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCouponsChildss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCouponsChildss());
            }
            $query = CouponsCategoriesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCouponsCategoriesRelatedByParentId($this)
                ->count($con);
        }

        return count($this->collCouponsChildss);
    }

    /**
     * Method called to associate a CouponsCategories object to this object
     * through the CouponsCategories foreign key attribute.
     *
     * @param    CouponsCategories $l CouponsCategories
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function addCouponsChilds(CouponsCategories $l)
    {
        if ($this->collCouponsChildss === null) {
            $this->initCouponsChildss();
            $this->collCouponsChildssPartial = true;
        }

        if (!in_array($l, $this->collCouponsChildss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCouponsChilds($l);

            if ($this->couponsChildssScheduledForDeletion and $this->couponsChildssScheduledForDeletion->contains($l)) {
                $this->couponsChildssScheduledForDeletion->remove($this->couponsChildssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	CouponsChilds $couponsChilds The couponsChilds object to add.
     */
    protected function doAddCouponsChilds($couponsChilds)
    {
        $this->collCouponsChildss[]= $couponsChilds;
        $couponsChilds->setCouponsCategoriesRelatedByParentId($this);
    }

    /**
     * @param	CouponsChilds $couponsChilds The couponsChilds object to remove.
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function removeCouponsChilds($couponsChilds)
    {
        if ($this->getCouponsChildss()->contains($couponsChilds)) {
            $this->collCouponsChildss->remove($this->collCouponsChildss->search($couponsChilds));
            if (null === $this->couponsChildssScheduledForDeletion) {
                $this->couponsChildssScheduledForDeletion = clone $this->collCouponsChildss;
                $this->couponsChildssScheduledForDeletion->clear();
            }
            $this->couponsChildssScheduledForDeletion[]= $couponsChilds;
            $couponsChilds->setCouponsCategoriesRelatedByParentId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCouponss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return CouponsCategories The current object (for fluent API support)
     * @see        addCouponss()
     */
    public function clearCouponss()
    {
        $this->collCouponss = null; // important to set this to null since that means it is uninitialized
        $this->collCouponssPartial = null;

        return $this;
    }

    /**
     * reset is the collCouponss collection loaded partially
     *
     * @return void
     */
    public function resetPartialCouponss($v = true)
    {
        $this->collCouponssPartial = $v;
    }

    /**
     * Initializes the collCouponss collection.
     *
     * By default this just sets the collCouponss collection to an empty array (like clearcollCouponss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCouponss($overrideExisting = true)
    {
        if (null !== $this->collCouponss && !$overrideExisting) {
            return;
        }
        $this->collCouponss = new PropelObjectCollection();
        $this->collCouponss->setModel('Coupons');
    }

    /**
     * Gets an array of Coupons objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this CouponsCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Coupons[] List of Coupons objects
     * @throws PropelException
     */
    public function getCouponss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCouponssPartial && !$this->isNew();
        if (null === $this->collCouponss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCouponss) {
                // return empty collection
                $this->initCouponss();
            } else {
                $collCouponss = CouponsQuery::create(null, $criteria)
                    ->filterByCouponsCategories($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCouponssPartial && count($collCouponss)) {
                      $this->initCouponss(false);

                      foreach ($collCouponss as $obj) {
                        if (false == $this->collCouponss->contains($obj)) {
                          $this->collCouponss->append($obj);
                        }
                      }

                      $this->collCouponssPartial = true;
                    }

                    $collCouponss->getInternalIterator()->rewind();

                    return $collCouponss;
                }

                if ($partial && $this->collCouponss) {
                    foreach ($this->collCouponss as $obj) {
                        if ($obj->isNew()) {
                            $collCouponss[] = $obj;
                        }
                    }
                }

                $this->collCouponss = $collCouponss;
                $this->collCouponssPartial = false;
            }
        }

        return $this->collCouponss;
    }

    /**
     * Sets a collection of Coupons objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $couponss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function setCouponss(PropelCollection $couponss, PropelPDO $con = null)
    {
        $couponssToDelete = $this->getCouponss(new Criteria(), $con)->diff($couponss);


        $this->couponssScheduledForDeletion = $couponssToDelete;

        foreach ($couponssToDelete as $couponsRemoved) {
            $couponsRemoved->setCouponsCategories(null);
        }

        $this->collCouponss = null;
        foreach ($couponss as $coupons) {
            $this->addCoupons($coupons);
        }

        $this->collCouponss = $couponss;
        $this->collCouponssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Coupons objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Coupons objects.
     * @throws PropelException
     */
    public function countCouponss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCouponssPartial && !$this->isNew();
        if (null === $this->collCouponss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCouponss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCouponss());
            }
            $query = CouponsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCouponsCategories($this)
                ->count($con);
        }

        return count($this->collCouponss);
    }

    /**
     * Method called to associate a Coupons object to this object
     * through the Coupons foreign key attribute.
     *
     * @param    Coupons $l Coupons
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function addCoupons(Coupons $l)
    {
        if ($this->collCouponss === null) {
            $this->initCouponss();
            $this->collCouponssPartial = true;
        }

        if (!in_array($l, $this->collCouponss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCoupons($l);

            if ($this->couponssScheduledForDeletion and $this->couponssScheduledForDeletion->contains($l)) {
                $this->couponssScheduledForDeletion->remove($this->couponssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Coupons $coupons The coupons object to add.
     */
    protected function doAddCoupons($coupons)
    {
        $this->collCouponss[]= $coupons;
        $coupons->setCouponsCategories($this);
    }

    /**
     * @param	Coupons $coupons The coupons object to remove.
     * @return CouponsCategories The current object (for fluent API support)
     */
    public function removeCoupons($coupons)
    {
        if ($this->getCouponss()->contains($coupons)) {
            $this->collCouponss->remove($this->collCouponss->search($coupons));
            if (null === $this->couponssScheduledForDeletion) {
                $this->couponssScheduledForDeletion = clone $this->collCouponss;
                $this->couponssScheduledForDeletion->clear();
            }
            $this->couponssScheduledForDeletion[]= clone $coupons;
            $coupons->setCouponsCategories(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this CouponsCategories is new, it will return
     * an empty collection; or if this CouponsCategories has previously
     * been saved, it will retrieve related Couponss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in CouponsCategories.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Coupons[] List of Coupons objects
     */
    public function getCouponssJoinRegions($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CouponsQuery::create(null, $criteria);
        $query->joinWith('Regions', $join_behavior);

        return $this->getCouponss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->parent_id = null;
        $this->name = null;
        $this->alias = null;
        $this->pagetitle = null;
        $this->catch_phrase = null;
        $this->icon = null;
        $this->enabled = null;
        $this->deleted = null;
        $this->usemap = null;
        $this->onmain = null;
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
            if ($this->collCouponsChildss) {
                foreach ($this->collCouponsChildss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCouponss) {
                foreach ($this->collCouponss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCouponsCategoriesRelatedByParentId instanceof Persistent) {
              $this->aCouponsCategoriesRelatedByParentId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collCouponsChildss instanceof PropelCollection) {
            $this->collCouponsChildss->clearIterator();
        }
        $this->collCouponsChildss = null;
        if ($this->collCouponss instanceof PropelCollection) {
            $this->collCouponss->clearIterator();
        }
        $this->collCouponss = null;
        $this->aCouponsCategoriesRelatedByParentId = null;
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
