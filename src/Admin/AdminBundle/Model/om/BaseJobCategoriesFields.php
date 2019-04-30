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
use Admin\AdminBundle\Model\JobCategories;
use Admin\AdminBundle\Model\JobCategoriesFields;
use Admin\AdminBundle\Model\JobCategoriesFieldsPeer;
use Admin\AdminBundle\Model\JobCategoriesFieldsQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsValues;
use Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\JobParams;
use Admin\AdminBundle\Model\JobParamsQuery;

abstract class BaseJobCategoriesFields extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\JobCategoriesFieldsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        JobCategoriesFieldsPeer
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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the type field.
     * @var        int
     */
    protected $type;

    /**
     * The value for the parent_field_id field.
     * @var        int
     */
    protected $parent_field_id;

    /**
     * The value for the helper field.
     * @var        string
     */
    protected $helper;

    /**
     * The value for the show_in_filter field.
     * @var        boolean
     */
    protected $show_in_filter;

    /**
     * The value for the show_in_table field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $show_in_table;

    /**
     * The value for the enabled field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $enabled;

    /**
     * The value for the listing field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $listing;

    /**
     * The value for the deleted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $deleted;

    /**
     * @var        JobCategories
     */
    protected $aJobCategories;

    /**
     * @var        JobCategoriesFields
     */
    protected $aJobCategoriesFieldsRelatedByParentFieldId;

    /**
     * @var        PropelObjectCollection|JobCategoriesFields[] Collection to store aggregation of JobCategoriesFields objects.
     */
    protected $collChildsFieldss;
    protected $collChildsFieldssPartial;

    /**
     * @var        PropelObjectCollection|JobCategoriesFieldsValues[] Collection to store aggregation of JobCategoriesFieldsValues objects.
     */
    protected $collJobCategoriesFieldsValuess;
    protected $collJobCategoriesFieldsValuessPartial;

    /**
     * @var        PropelObjectCollection|JobParams[] Collection to store aggregation of JobParams objects.
     */
    protected $collJobParamss;
    protected $collJobParamssPartial;

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
    protected $childsFieldssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobCategoriesFieldsValuessScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobParamssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->show_in_table = false;
        $this->enabled = false;
        $this->listing = false;
        $this->deleted = false;
    }

    /**
     * Initializes internal state of BaseJobCategoriesFields object.
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * Get the [type] column value.
     *
     * @return int
     */
    public function getType()
    {

        return $this->type;
    }

    /**
     * Get the [parent_field_id] column value.
     *
     * @return int
     */
    public function getParentFieldId()
    {

        return $this->parent_field_id;
    }

    /**
     * Get the [helper] column value.
     *
     * @return string
     */
    public function getHelper()
    {

        return $this->helper;
    }

    /**
     * Get the [show_in_filter] column value.
     *
     * @return boolean
     */
    public function getShowInFilter()
    {

        return $this->show_in_filter;
    }

    /**
     * Get the [show_in_table] column value.
     *
     * @return boolean
     */
    public function getShowInTable()
    {

        return $this->show_in_table;
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
     * Get the [listing] column value.
     *
     * @return boolean
     */
    public function getListing()
    {

        return $this->listing;
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
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  int $v new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::CATEGORY_ID;
        }

        if ($this->aJobCategories !== null && $this->aJobCategories->getId() !== $v) {
            $this->aJobCategories = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [type] column.
     *
     * @param  int $v new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [parent_field_id] column.
     *
     * @param  int $v new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setParentFieldId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_field_id !== $v) {
            $this->parent_field_id = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::PARENT_FIELD_ID;
        }

        if ($this->aJobCategoriesFieldsRelatedByParentFieldId !== null && $this->aJobCategoriesFieldsRelatedByParentFieldId->getId() !== $v) {
            $this->aJobCategoriesFieldsRelatedByParentFieldId = null;
        }


        return $this;
    } // setParentFieldId()

    /**
     * Set the value of [helper] column.
     *
     * @param  string $v new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setHelper($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->helper !== $v) {
            $this->helper = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::HELPER;
        }


        return $this;
    } // setHelper()

    /**
     * Sets the value of the [show_in_filter] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setShowInFilter($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_in_filter !== $v) {
            $this->show_in_filter = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::SHOW_IN_FILTER;
        }


        return $this;
    } // setShowInFilter()

    /**
     * Sets the value of the [show_in_table] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setShowInTable($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_in_table !== $v) {
            $this->show_in_table = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::SHOW_IN_TABLE;
        }


        return $this;
    } // setShowInTable()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return JobCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::ENABLED;
        }


        return $this;
    } // setEnabled()

    /**
     * Sets the value of the [listing] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setListing($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->listing !== $v) {
            $this->listing = $v;
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::LISTING;
        }


        return $this;
    } // setListing()

    /**
     * Sets the value of the [deleted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return JobCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobCategoriesFieldsPeer::DELETED;
        }


        return $this;
    } // setDeleted()

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
            if ($this->show_in_table !== false) {
                return false;
            }

            if ($this->enabled !== false) {
                return false;
            }

            if ($this->listing !== false) {
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
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->type = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->parent_field_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->helper = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->show_in_filter = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
            $this->show_in_table = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
            $this->enabled = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
            $this->listing = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
            $this->deleted = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 11; // 11 = JobCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating JobCategoriesFields object", $e);
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
        if ($this->aJobCategoriesFieldsRelatedByParentFieldId !== null && $this->parent_field_id !== $this->aJobCategoriesFieldsRelatedByParentFieldId->getId()) {
            $this->aJobCategoriesFieldsRelatedByParentFieldId = null;
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
            $con = Propel::getConnection(JobCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = JobCategoriesFieldsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aJobCategories = null;
            $this->aJobCategoriesFieldsRelatedByParentFieldId = null;
            $this->collChildsFieldss = null;

            $this->collJobCategoriesFieldsValuess = null;

            $this->collJobParamss = null;

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
            $con = Propel::getConnection(JobCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = JobCategoriesFieldsQuery::create()
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
            $con = Propel::getConnection(JobCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                JobCategoriesFieldsPeer::addInstanceToPool($this);
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

            if ($this->aJobCategories !== null) {
                if ($this->aJobCategories->isModified() || $this->aJobCategories->isNew()) {
                    $affectedRows += $this->aJobCategories->save($con);
                }
                $this->setJobCategories($this->aJobCategories);
            }

            if ($this->aJobCategoriesFieldsRelatedByParentFieldId !== null) {
                if ($this->aJobCategoriesFieldsRelatedByParentFieldId->isModified() || $this->aJobCategoriesFieldsRelatedByParentFieldId->isNew()) {
                    $affectedRows += $this->aJobCategoriesFieldsRelatedByParentFieldId->save($con);
                }
                $this->setJobCategoriesFieldsRelatedByParentFieldId($this->aJobCategoriesFieldsRelatedByParentFieldId);
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

            if ($this->childsFieldssScheduledForDeletion !== null) {
                if (!$this->childsFieldssScheduledForDeletion->isEmpty()) {
                    JobCategoriesFieldsQuery::create()
                        ->filterByPrimaryKeys($this->childsFieldssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->childsFieldssScheduledForDeletion = null;
                }
            }

            if ($this->collChildsFieldss !== null) {
                foreach ($this->collChildsFieldss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobCategoriesFieldsValuessScheduledForDeletion !== null) {
                if (!$this->jobCategoriesFieldsValuessScheduledForDeletion->isEmpty()) {
                    JobCategoriesFieldsValuesQuery::create()
                        ->filterByPrimaryKeys($this->jobCategoriesFieldsValuessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobCategoriesFieldsValuessScheduledForDeletion = null;
                }
            }

            if ($this->collJobCategoriesFieldsValuess !== null) {
                foreach ($this->collJobCategoriesFieldsValuess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[] = JobCategoriesFieldsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . JobCategoriesFieldsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(JobCategoriesFieldsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::PARENT_FIELD_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_field_id`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::HELPER)) {
            $modifiedColumns[':p' . $index++]  = '`helper`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::SHOW_IN_FILTER)) {
            $modifiedColumns[':p' . $index++]  = '`show_in_filter`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::SHOW_IN_TABLE)) {
            $modifiedColumns[':p' . $index++]  = '`show_in_table`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::LISTING)) {
            $modifiedColumns[':p' . $index++]  = '`listing`';
        }
        if ($this->isColumnModified(JobCategoriesFieldsPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }

        $sql = sprintf(
            'INSERT INTO `job_categories_fields` (%s) VALUES (%s)',
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
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`parent_field_id`':
                        $stmt->bindValue($identifier, $this->parent_field_id, PDO::PARAM_INT);
                        break;
                    case '`helper`':
                        $stmt->bindValue($identifier, $this->helper, PDO::PARAM_STR);
                        break;
                    case '`show_in_filter`':
                        $stmt->bindValue($identifier, (int) $this->show_in_filter, PDO::PARAM_INT);
                        break;
                    case '`show_in_table`':
                        $stmt->bindValue($identifier, (int) $this->show_in_table, PDO::PARAM_INT);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`listing`':
                        $stmt->bindValue($identifier, (int) $this->listing, PDO::PARAM_INT);
                        break;
                    case '`deleted`':
                        $stmt->bindValue($identifier, (int) $this->deleted, PDO::PARAM_INT);
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

            if ($this->aJobCategories !== null) {
                if (!$this->aJobCategories->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aJobCategories->getValidationFailures());
                }
            }

            if ($this->aJobCategoriesFieldsRelatedByParentFieldId !== null) {
                if (!$this->aJobCategoriesFieldsRelatedByParentFieldId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aJobCategoriesFieldsRelatedByParentFieldId->getValidationFailures());
                }
            }


            if (($retval = JobCategoriesFieldsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collChildsFieldss !== null) {
                    foreach ($this->collChildsFieldss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobCategoriesFieldsValuess !== null) {
                    foreach ($this->collJobCategoriesFieldsValuess as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobParamss !== null) {
                    foreach ($this->collJobParamss as $referrerFK) {
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
        $pos = JobCategoriesFieldsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getName();
                break;
            case 3:
                return $this->getType();
                break;
            case 4:
                return $this->getParentFieldId();
                break;
            case 5:
                return $this->getHelper();
                break;
            case 6:
                return $this->getShowInFilter();
                break;
            case 7:
                return $this->getShowInTable();
                break;
            case 8:
                return $this->getEnabled();
                break;
            case 9:
                return $this->getListing();
                break;
            case 10:
                return $this->getDeleted();
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
        if (isset($alreadyDumpedObjects['JobCategoriesFields'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['JobCategoriesFields'][$this->getPrimaryKey()] = true;
        $keys = JobCategoriesFieldsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getType(),
            $keys[4] => $this->getParentFieldId(),
            $keys[5] => $this->getHelper(),
            $keys[6] => $this->getShowInFilter(),
            $keys[7] => $this->getShowInTable(),
            $keys[8] => $this->getEnabled(),
            $keys[9] => $this->getListing(),
            $keys[10] => $this->getDeleted(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aJobCategories) {
                $result['JobCategories'] = $this->aJobCategories->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aJobCategoriesFieldsRelatedByParentFieldId) {
                $result['JobCategoriesFieldsRelatedByParentFieldId'] = $this->aJobCategoriesFieldsRelatedByParentFieldId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collChildsFieldss) {
                $result['ChildsFieldss'] = $this->collChildsFieldss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobCategoriesFieldsValuess) {
                $result['JobCategoriesFieldsValuess'] = $this->collJobCategoriesFieldsValuess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobParamss) {
                $result['JobParamss'] = $this->collJobParamss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = JobCategoriesFieldsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setName($value);
                break;
            case 3:
                $this->setType($value);
                break;
            case 4:
                $this->setParentFieldId($value);
                break;
            case 5:
                $this->setHelper($value);
                break;
            case 6:
                $this->setShowInFilter($value);
                break;
            case 7:
                $this->setShowInTable($value);
                break;
            case 8:
                $this->setEnabled($value);
                break;
            case 9:
                $this->setListing($value);
                break;
            case 10:
                $this->setDeleted($value);
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
        $keys = JobCategoriesFieldsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setType($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setParentFieldId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setHelper($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setShowInFilter($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setShowInTable($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setEnabled($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setListing($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setDeleted($arr[$keys[10]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(JobCategoriesFieldsPeer::DATABASE_NAME);

        if ($this->isColumnModified(JobCategoriesFieldsPeer::ID)) $criteria->add(JobCategoriesFieldsPeer::ID, $this->id);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::CATEGORY_ID)) $criteria->add(JobCategoriesFieldsPeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::NAME)) $criteria->add(JobCategoriesFieldsPeer::NAME, $this->name);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::TYPE)) $criteria->add(JobCategoriesFieldsPeer::TYPE, $this->type);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::PARENT_FIELD_ID)) $criteria->add(JobCategoriesFieldsPeer::PARENT_FIELD_ID, $this->parent_field_id);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::HELPER)) $criteria->add(JobCategoriesFieldsPeer::HELPER, $this->helper);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::SHOW_IN_FILTER)) $criteria->add(JobCategoriesFieldsPeer::SHOW_IN_FILTER, $this->show_in_filter);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::SHOW_IN_TABLE)) $criteria->add(JobCategoriesFieldsPeer::SHOW_IN_TABLE, $this->show_in_table);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::ENABLED)) $criteria->add(JobCategoriesFieldsPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::LISTING)) $criteria->add(JobCategoriesFieldsPeer::LISTING, $this->listing);
        if ($this->isColumnModified(JobCategoriesFieldsPeer::DELETED)) $criteria->add(JobCategoriesFieldsPeer::DELETED, $this->deleted);

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
        $criteria = new Criteria(JobCategoriesFieldsPeer::DATABASE_NAME);
        $criteria->add(JobCategoriesFieldsPeer::ID, $this->id);

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
     * @param object $copyObj An object of JobCategoriesFields (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setName($this->getName());
        $copyObj->setType($this->getType());
        $copyObj->setParentFieldId($this->getParentFieldId());
        $copyObj->setHelper($this->getHelper());
        $copyObj->setShowInFilter($this->getShowInFilter());
        $copyObj->setShowInTable($this->getShowInTable());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setListing($this->getListing());
        $copyObj->setDeleted($this->getDeleted());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getChildsFieldss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChildsFields($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobCategoriesFieldsValuess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobCategoriesFieldsValues($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobParamss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobParams($relObj->copy($deepCopy));
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
     * @return JobCategoriesFields Clone of current object.
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
     * @return JobCategoriesFieldsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new JobCategoriesFieldsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a JobCategories object.
     *
     * @param                  JobCategories $v
     * @return JobCategoriesFields The current object (for fluent API support)
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
            $v->addJobCategoriesFields($this);
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
                $this->aJobCategories->addJobCategoriesFieldss($this);
             */
        }

        return $this->aJobCategories;
    }

    /**
     * Declares an association between this object and a JobCategoriesFields object.
     *
     * @param                  JobCategoriesFields $v
     * @return JobCategoriesFields The current object (for fluent API support)
     * @throws PropelException
     */
    public function setJobCategoriesFieldsRelatedByParentFieldId(JobCategoriesFields $v = null)
    {
        if ($v === null) {
            $this->setParentFieldId(NULL);
        } else {
            $this->setParentFieldId($v->getId());
        }

        $this->aJobCategoriesFieldsRelatedByParentFieldId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the JobCategoriesFields object, it will not be re-added.
        if ($v !== null) {
            $v->addChildsFields($this);
        }


        return $this;
    }


    /**
     * Get the associated JobCategoriesFields object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return JobCategoriesFields The associated JobCategoriesFields object.
     * @throws PropelException
     */
    public function getJobCategoriesFieldsRelatedByParentFieldId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aJobCategoriesFieldsRelatedByParentFieldId === null && ($this->parent_field_id !== null) && $doQuery) {
            $this->aJobCategoriesFieldsRelatedByParentFieldId = JobCategoriesFieldsQuery::create()->findPk($this->parent_field_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aJobCategoriesFieldsRelatedByParentFieldId->addChildsFieldss($this);
             */
        }

        return $this->aJobCategoriesFieldsRelatedByParentFieldId;
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
        if ('ChildsFields' == $relationName) {
            $this->initChildsFieldss();
        }
        if ('JobCategoriesFieldsValues' == $relationName) {
            $this->initJobCategoriesFieldsValuess();
        }
        if ('JobParams' == $relationName) {
            $this->initJobParamss();
        }
    }

    /**
     * Clears out the collChildsFieldss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return JobCategoriesFields The current object (for fluent API support)
     * @see        addChildsFieldss()
     */
    public function clearChildsFieldss()
    {
        $this->collChildsFieldss = null; // important to set this to null since that means it is uninitialized
        $this->collChildsFieldssPartial = null;

        return $this;
    }

    /**
     * reset is the collChildsFieldss collection loaded partially
     *
     * @return void
     */
    public function resetPartialChildsFieldss($v = true)
    {
        $this->collChildsFieldssPartial = $v;
    }

    /**
     * Initializes the collChildsFieldss collection.
     *
     * By default this just sets the collChildsFieldss collection to an empty array (like clearcollChildsFieldss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChildsFieldss($overrideExisting = true)
    {
        if (null !== $this->collChildsFieldss && !$overrideExisting) {
            return;
        }
        $this->collChildsFieldss = new PropelObjectCollection();
        $this->collChildsFieldss->setModel('JobCategoriesFields');
    }

    /**
     * Gets an array of JobCategoriesFields objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this JobCategoriesFields is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobCategoriesFields[] List of JobCategoriesFields objects
     * @throws PropelException
     */
    public function getChildsFieldss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collChildsFieldssPartial && !$this->isNew();
        if (null === $this->collChildsFieldss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChildsFieldss) {
                // return empty collection
                $this->initChildsFieldss();
            } else {
                $collChildsFieldss = JobCategoriesFieldsQuery::create(null, $criteria)
                    ->filterByJobCategoriesFieldsRelatedByParentFieldId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collChildsFieldssPartial && count($collChildsFieldss)) {
                      $this->initChildsFieldss(false);

                      foreach ($collChildsFieldss as $obj) {
                        if (false == $this->collChildsFieldss->contains($obj)) {
                          $this->collChildsFieldss->append($obj);
                        }
                      }

                      $this->collChildsFieldssPartial = true;
                    }

                    $collChildsFieldss->getInternalIterator()->rewind();

                    return $collChildsFieldss;
                }

                if ($partial && $this->collChildsFieldss) {
                    foreach ($this->collChildsFieldss as $obj) {
                        if ($obj->isNew()) {
                            $collChildsFieldss[] = $obj;
                        }
                    }
                }

                $this->collChildsFieldss = $collChildsFieldss;
                $this->collChildsFieldssPartial = false;
            }
        }

        return $this->collChildsFieldss;
    }

    /**
     * Sets a collection of ChildsFields objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $childsFieldss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setChildsFieldss(PropelCollection $childsFieldss, PropelPDO $con = null)
    {
        $childsFieldssToDelete = $this->getChildsFieldss(new Criteria(), $con)->diff($childsFieldss);


        $this->childsFieldssScheduledForDeletion = $childsFieldssToDelete;

        foreach ($childsFieldssToDelete as $childsFieldsRemoved) {
            $childsFieldsRemoved->setJobCategoriesFieldsRelatedByParentFieldId(null);
        }

        $this->collChildsFieldss = null;
        foreach ($childsFieldss as $childsFields) {
            $this->addChildsFields($childsFields);
        }

        $this->collChildsFieldss = $childsFieldss;
        $this->collChildsFieldssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobCategoriesFields objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobCategoriesFields objects.
     * @throws PropelException
     */
    public function countChildsFieldss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collChildsFieldssPartial && !$this->isNew();
        if (null === $this->collChildsFieldss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChildsFieldss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getChildsFieldss());
            }
            $query = JobCategoriesFieldsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobCategoriesFieldsRelatedByParentFieldId($this)
                ->count($con);
        }

        return count($this->collChildsFieldss);
    }

    /**
     * Method called to associate a JobCategoriesFields object to this object
     * through the JobCategoriesFields foreign key attribute.
     *
     * @param    JobCategoriesFields $l JobCategoriesFields
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function addChildsFields(JobCategoriesFields $l)
    {
        if ($this->collChildsFieldss === null) {
            $this->initChildsFieldss();
            $this->collChildsFieldssPartial = true;
        }

        if (!in_array($l, $this->collChildsFieldss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddChildsFields($l);

            if ($this->childsFieldssScheduledForDeletion and $this->childsFieldssScheduledForDeletion->contains($l)) {
                $this->childsFieldssScheduledForDeletion->remove($this->childsFieldssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	ChildsFields $childsFields The childsFields object to add.
     */
    protected function doAddChildsFields($childsFields)
    {
        $this->collChildsFieldss[]= $childsFields;
        $childsFields->setJobCategoriesFieldsRelatedByParentFieldId($this);
    }

    /**
     * @param	ChildsFields $childsFields The childsFields object to remove.
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function removeChildsFields($childsFields)
    {
        if ($this->getChildsFieldss()->contains($childsFields)) {
            $this->collChildsFieldss->remove($this->collChildsFieldss->search($childsFields));
            if (null === $this->childsFieldssScheduledForDeletion) {
                $this->childsFieldssScheduledForDeletion = clone $this->collChildsFieldss;
                $this->childsFieldssScheduledForDeletion->clear();
            }
            $this->childsFieldssScheduledForDeletion[]= $childsFields;
            $childsFields->setJobCategoriesFieldsRelatedByParentFieldId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategoriesFields is new, it will return
     * an empty collection; or if this JobCategoriesFields has previously
     * been saved, it will retrieve related ChildsFieldss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategoriesFields.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobCategoriesFields[] List of JobCategoriesFields objects
     */
    public function getChildsFieldssJoinJobCategories($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobCategoriesFieldsQuery::create(null, $criteria);
        $query->joinWith('JobCategories', $join_behavior);

        return $this->getChildsFieldss($query, $con);
    }

    /**
     * Clears out the collJobCategoriesFieldsValuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return JobCategoriesFields The current object (for fluent API support)
     * @see        addJobCategoriesFieldsValuess()
     */
    public function clearJobCategoriesFieldsValuess()
    {
        $this->collJobCategoriesFieldsValuess = null; // important to set this to null since that means it is uninitialized
        $this->collJobCategoriesFieldsValuessPartial = null;

        return $this;
    }

    /**
     * reset is the collJobCategoriesFieldsValuess collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobCategoriesFieldsValuess($v = true)
    {
        $this->collJobCategoriesFieldsValuessPartial = $v;
    }

    /**
     * Initializes the collJobCategoriesFieldsValuess collection.
     *
     * By default this just sets the collJobCategoriesFieldsValuess collection to an empty array (like clearcollJobCategoriesFieldsValuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobCategoriesFieldsValuess($overrideExisting = true)
    {
        if (null !== $this->collJobCategoriesFieldsValuess && !$overrideExisting) {
            return;
        }
        $this->collJobCategoriesFieldsValuess = new PropelObjectCollection();
        $this->collJobCategoriesFieldsValuess->setModel('JobCategoriesFieldsValues');
    }

    /**
     * Gets an array of JobCategoriesFieldsValues objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this JobCategoriesFields is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobCategoriesFieldsValues[] List of JobCategoriesFieldsValues objects
     * @throws PropelException
     */
    public function getJobCategoriesFieldsValuess($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobCategoriesFieldsValuessPartial && !$this->isNew();
        if (null === $this->collJobCategoriesFieldsValuess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobCategoriesFieldsValuess) {
                // return empty collection
                $this->initJobCategoriesFieldsValuess();
            } else {
                $collJobCategoriesFieldsValuess = JobCategoriesFieldsValuesQuery::create(null, $criteria)
                    ->filterByJobCategoriesFields($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobCategoriesFieldsValuessPartial && count($collJobCategoriesFieldsValuess)) {
                      $this->initJobCategoriesFieldsValuess(false);

                      foreach ($collJobCategoriesFieldsValuess as $obj) {
                        if (false == $this->collJobCategoriesFieldsValuess->contains($obj)) {
                          $this->collJobCategoriesFieldsValuess->append($obj);
                        }
                      }

                      $this->collJobCategoriesFieldsValuessPartial = true;
                    }

                    $collJobCategoriesFieldsValuess->getInternalIterator()->rewind();

                    return $collJobCategoriesFieldsValuess;
                }

                if ($partial && $this->collJobCategoriesFieldsValuess) {
                    foreach ($this->collJobCategoriesFieldsValuess as $obj) {
                        if ($obj->isNew()) {
                            $collJobCategoriesFieldsValuess[] = $obj;
                        }
                    }
                }

                $this->collJobCategoriesFieldsValuess = $collJobCategoriesFieldsValuess;
                $this->collJobCategoriesFieldsValuessPartial = false;
            }
        }

        return $this->collJobCategoriesFieldsValuess;
    }

    /**
     * Sets a collection of JobCategoriesFieldsValues objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobCategoriesFieldsValuess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setJobCategoriesFieldsValuess(PropelCollection $jobCategoriesFieldsValuess, PropelPDO $con = null)
    {
        $jobCategoriesFieldsValuessToDelete = $this->getJobCategoriesFieldsValuess(new Criteria(), $con)->diff($jobCategoriesFieldsValuess);


        $this->jobCategoriesFieldsValuessScheduledForDeletion = $jobCategoriesFieldsValuessToDelete;

        foreach ($jobCategoriesFieldsValuessToDelete as $jobCategoriesFieldsValuesRemoved) {
            $jobCategoriesFieldsValuesRemoved->setJobCategoriesFields(null);
        }

        $this->collJobCategoriesFieldsValuess = null;
        foreach ($jobCategoriesFieldsValuess as $jobCategoriesFieldsValues) {
            $this->addJobCategoriesFieldsValues($jobCategoriesFieldsValues);
        }

        $this->collJobCategoriesFieldsValuess = $jobCategoriesFieldsValuess;
        $this->collJobCategoriesFieldsValuessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobCategoriesFieldsValues objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobCategoriesFieldsValues objects.
     * @throws PropelException
     */
    public function countJobCategoriesFieldsValuess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobCategoriesFieldsValuessPartial && !$this->isNew();
        if (null === $this->collJobCategoriesFieldsValuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobCategoriesFieldsValuess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobCategoriesFieldsValuess());
            }
            $query = JobCategoriesFieldsValuesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobCategoriesFields($this)
                ->count($con);
        }

        return count($this->collJobCategoriesFieldsValuess);
    }

    /**
     * Method called to associate a JobCategoriesFieldsValues object to this object
     * through the JobCategoriesFieldsValues foreign key attribute.
     *
     * @param    JobCategoriesFieldsValues $l JobCategoriesFieldsValues
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function addJobCategoriesFieldsValues(JobCategoriesFieldsValues $l)
    {
        if ($this->collJobCategoriesFieldsValuess === null) {
            $this->initJobCategoriesFieldsValuess();
            $this->collJobCategoriesFieldsValuessPartial = true;
        }

        if (!in_array($l, $this->collJobCategoriesFieldsValuess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobCategoriesFieldsValues($l);

            if ($this->jobCategoriesFieldsValuessScheduledForDeletion and $this->jobCategoriesFieldsValuessScheduledForDeletion->contains($l)) {
                $this->jobCategoriesFieldsValuessScheduledForDeletion->remove($this->jobCategoriesFieldsValuessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobCategoriesFieldsValues $jobCategoriesFieldsValues The jobCategoriesFieldsValues object to add.
     */
    protected function doAddJobCategoriesFieldsValues($jobCategoriesFieldsValues)
    {
        $this->collJobCategoriesFieldsValuess[]= $jobCategoriesFieldsValues;
        $jobCategoriesFieldsValues->setJobCategoriesFields($this);
    }

    /**
     * @param	JobCategoriesFieldsValues $jobCategoriesFieldsValues The jobCategoriesFieldsValues object to remove.
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function removeJobCategoriesFieldsValues($jobCategoriesFieldsValues)
    {
        if ($this->getJobCategoriesFieldsValuess()->contains($jobCategoriesFieldsValues)) {
            $this->collJobCategoriesFieldsValuess->remove($this->collJobCategoriesFieldsValuess->search($jobCategoriesFieldsValues));
            if (null === $this->jobCategoriesFieldsValuessScheduledForDeletion) {
                $this->jobCategoriesFieldsValuessScheduledForDeletion = clone $this->collJobCategoriesFieldsValuess;
                $this->jobCategoriesFieldsValuessScheduledForDeletion->clear();
            }
            $this->jobCategoriesFieldsValuessScheduledForDeletion[]= $jobCategoriesFieldsValues;
            $jobCategoriesFieldsValues->setJobCategoriesFields(null);
        }

        return $this;
    }

    /**
     * Clears out the collJobParamss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return JobCategoriesFields The current object (for fluent API support)
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
     * If this JobCategoriesFields is new, it will return
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
                    ->filterByJobCategoriesFields($this)
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
     * @return JobCategoriesFields The current object (for fluent API support)
     */
    public function setJobParamss(PropelCollection $jobParamss, PropelPDO $con = null)
    {
        $jobParamssToDelete = $this->getJobParamss(new Criteria(), $con)->diff($jobParamss);


        $this->jobParamssScheduledForDeletion = $jobParamssToDelete;

        foreach ($jobParamssToDelete as $jobParamsRemoved) {
            $jobParamsRemoved->setJobCategoriesFields(null);
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
                ->filterByJobCategoriesFields($this)
                ->count($con);
        }

        return count($this->collJobParamss);
    }

    /**
     * Method called to associate a JobParams object to this object
     * through the JobParams foreign key attribute.
     *
     * @param    JobParams $l JobParams
     * @return JobCategoriesFields The current object (for fluent API support)
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
        $jobParams->setJobCategoriesFields($this);
    }

    /**
     * @param	JobParams $jobParams The jobParams object to remove.
     * @return JobCategoriesFields The current object (for fluent API support)
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
            $jobParams->setJobCategoriesFields(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategoriesFields is new, it will return
     * an empty collection; or if this JobCategoriesFields has previously
     * been saved, it will retrieve related JobParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategoriesFields.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobParams[] List of JobParams objects
     */
    public function getJobParamssJoinJobs($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobParamsQuery::create(null, $criteria);
        $query->joinWith('Jobs', $join_behavior);

        return $this->getJobParamss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategoriesFields is new, it will return
     * an empty collection; or if this JobCategoriesFields has previously
     * been saved, it will retrieve related JobParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategoriesFields.
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
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->name = null;
        $this->type = null;
        $this->parent_field_id = null;
        $this->helper = null;
        $this->show_in_filter = null;
        $this->show_in_table = null;
        $this->enabled = null;
        $this->listing = null;
        $this->deleted = null;
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
            if ($this->collChildsFieldss) {
                foreach ($this->collChildsFieldss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobCategoriesFieldsValuess) {
                foreach ($this->collJobCategoriesFieldsValuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobParamss) {
                foreach ($this->collJobParamss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aJobCategories instanceof Persistent) {
              $this->aJobCategories->clearAllReferences($deep);
            }
            if ($this->aJobCategoriesFieldsRelatedByParentFieldId instanceof Persistent) {
              $this->aJobCategoriesFieldsRelatedByParentFieldId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collChildsFieldss instanceof PropelCollection) {
            $this->collChildsFieldss->clearIterator();
        }
        $this->collChildsFieldss = null;
        if ($this->collJobCategoriesFieldsValuess instanceof PropelCollection) {
            $this->collJobCategoriesFieldsValuess->clearIterator();
        }
        $this->collJobCategoriesFieldsValuess = null;
        if ($this->collJobParamss instanceof PropelCollection) {
            $this->collJobParamss->clearIterator();
        }
        $this->collJobParamss = null;
        $this->aJobCategories = null;
        $this->aJobCategoriesFieldsRelatedByParentFieldId = null;
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
