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
use Admin\AdminBundle\Model\JobCategoriesFieldsQuery;
use Admin\AdminBundle\Model\JobCategoriesPeer;
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\Jobs;
use Admin\AdminBundle\Model\JobsQuery;

abstract class BaseJobCategories extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\JobCategoriesPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        JobCategoriesPeer
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
     * @var        JobCategories
     */
    protected $aJobCategoriesRelatedByParentId;

    /**
     * @var        PropelObjectCollection|JobCategories[] Collection to store aggregation of JobCategories objects.
     */
    protected $collJobChildss;
    protected $collJobChildssPartial;

    /**
     * @var        PropelObjectCollection|JobCategoriesFields[] Collection to store aggregation of JobCategoriesFields objects.
     */
    protected $collJobCategoriesFieldss;
    protected $collJobCategoriesFieldssPartial;

    /**
     * @var        PropelObjectCollection|Jobs[] Collection to store aggregation of Jobs objects.
     */
    protected $collJobss;
    protected $collJobssPartial;

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
    protected $jobChildssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobCategoriesFieldssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $jobssScheduledForDeletion = null;

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
     * Initializes internal state of BaseJobCategories object.
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
     * @return JobCategories The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param  int $v new value
     * @return JobCategories The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::PARENT_ID;
        }

        if ($this->aJobCategoriesRelatedByParentId !== null && $this->aJobCategoriesRelatedByParentId->getId() !== $v) {
            $this->aJobCategoriesRelatedByParentId = null;
        }


        return $this;
    } // setParentId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return JobCategories The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return JobCategories The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [pagetitle] column.
     *
     * @param  string $v new value
     * @return JobCategories The current object (for fluent API support)
     */
    public function setPagetitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pagetitle !== $v) {
            $this->pagetitle = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::PAGETITLE;
        }


        return $this;
    } // setPagetitle()

    /**
     * Set the value of [catch_phrase] column.
     *
     * @param  string $v new value
     * @return JobCategories The current object (for fluent API support)
     */
    public function setCatchPhrase($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->catch_phrase !== $v) {
            $this->catch_phrase = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::CATCH_PHRASE;
        }


        return $this;
    } // setCatchPhrase()

    /**
     * Set the value of [icon] column.
     *
     * @param  string $v new value
     * @return JobCategories The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[] = JobCategoriesPeer::ICON;
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
     * @return JobCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobCategoriesPeer::ENABLED;
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
     * @return JobCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobCategoriesPeer::DELETED;
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
     * @return JobCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobCategoriesPeer::USEMAP;
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
     * @return JobCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = JobCategoriesPeer::ONMAIN;
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

            return $startcol + 11; // 11 = JobCategoriesPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating JobCategories object", $e);
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

        if ($this->aJobCategoriesRelatedByParentId !== null && $this->parent_id !== $this->aJobCategoriesRelatedByParentId->getId()) {
            $this->aJobCategoriesRelatedByParentId = null;
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
            $con = Propel::getConnection(JobCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = JobCategoriesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aJobCategoriesRelatedByParentId = null;
            $this->collJobChildss = null;

            $this->collJobCategoriesFieldss = null;

            $this->collJobss = null;

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
            $con = Propel::getConnection(JobCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = JobCategoriesQuery::create()
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
            $con = Propel::getConnection(JobCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                JobCategoriesPeer::addInstanceToPool($this);
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

            if ($this->aJobCategoriesRelatedByParentId !== null) {
                if ($this->aJobCategoriesRelatedByParentId->isModified() || $this->aJobCategoriesRelatedByParentId->isNew()) {
                    $affectedRows += $this->aJobCategoriesRelatedByParentId->save($con);
                }
                $this->setJobCategoriesRelatedByParentId($this->aJobCategoriesRelatedByParentId);
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

            if ($this->jobChildssScheduledForDeletion !== null) {
                if (!$this->jobChildssScheduledForDeletion->isEmpty()) {
                    JobCategoriesQuery::create()
                        ->filterByPrimaryKeys($this->jobChildssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobChildssScheduledForDeletion = null;
                }
            }

            if ($this->collJobChildss !== null) {
                foreach ($this->collJobChildss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobCategoriesFieldssScheduledForDeletion !== null) {
                if (!$this->jobCategoriesFieldssScheduledForDeletion->isEmpty()) {
                    JobCategoriesFieldsQuery::create()
                        ->filterByPrimaryKeys($this->jobCategoriesFieldssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobCategoriesFieldssScheduledForDeletion = null;
                }
            }

            if ($this->collJobCategoriesFieldss !== null) {
                foreach ($this->collJobCategoriesFieldss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->jobssScheduledForDeletion !== null) {
                if (!$this->jobssScheduledForDeletion->isEmpty()) {
                    JobsQuery::create()
                        ->filterByPrimaryKeys($this->jobssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->jobssScheduledForDeletion = null;
                }
            }

            if ($this->collJobss !== null) {
                foreach ($this->collJobss as $referrerFK) {
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

        $this->modifiedColumns[] = JobCategoriesPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . JobCategoriesPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(JobCategoriesPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_id`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::PAGETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`pagetitle`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::CATCH_PHRASE)) {
            $modifiedColumns[':p' . $index++]  = '`catch_phrase`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::USEMAP)) {
            $modifiedColumns[':p' . $index++]  = '`usemap`';
        }
        if ($this->isColumnModified(JobCategoriesPeer::ONMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`onmain`';
        }

        $sql = sprintf(
            'INSERT INTO `job_categories` (%s) VALUES (%s)',
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

            if ($this->aJobCategoriesRelatedByParentId !== null) {
                if (!$this->aJobCategoriesRelatedByParentId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aJobCategoriesRelatedByParentId->getValidationFailures());
                }
            }


            if (($retval = JobCategoriesPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collJobChildss !== null) {
                    foreach ($this->collJobChildss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobCategoriesFieldss !== null) {
                    foreach ($this->collJobCategoriesFieldss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collJobss !== null) {
                    foreach ($this->collJobss as $referrerFK) {
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
        $pos = JobCategoriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
        if (isset($alreadyDumpedObjects['JobCategories'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['JobCategories'][$this->getPrimaryKey()] = true;
        $keys = JobCategoriesPeer::getFieldNames($keyType);
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
            if (null !== $this->aJobCategoriesRelatedByParentId) {
                $result['JobCategoriesRelatedByParentId'] = $this->aJobCategoriesRelatedByParentId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collJobChildss) {
                $result['JobChildss'] = $this->collJobChildss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobCategoriesFieldss) {
                $result['JobCategoriesFieldss'] = $this->collJobCategoriesFieldss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collJobss) {
                $result['Jobss'] = $this->collJobss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = JobCategoriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
        $keys = JobCategoriesPeer::getFieldNames($keyType);

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
        $criteria = new Criteria(JobCategoriesPeer::DATABASE_NAME);

        if ($this->isColumnModified(JobCategoriesPeer::ID)) $criteria->add(JobCategoriesPeer::ID, $this->id);
        if ($this->isColumnModified(JobCategoriesPeer::PARENT_ID)) $criteria->add(JobCategoriesPeer::PARENT_ID, $this->parent_id);
        if ($this->isColumnModified(JobCategoriesPeer::NAME)) $criteria->add(JobCategoriesPeer::NAME, $this->name);
        if ($this->isColumnModified(JobCategoriesPeer::ALIAS)) $criteria->add(JobCategoriesPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(JobCategoriesPeer::PAGETITLE)) $criteria->add(JobCategoriesPeer::PAGETITLE, $this->pagetitle);
        if ($this->isColumnModified(JobCategoriesPeer::CATCH_PHRASE)) $criteria->add(JobCategoriesPeer::CATCH_PHRASE, $this->catch_phrase);
        if ($this->isColumnModified(JobCategoriesPeer::ICON)) $criteria->add(JobCategoriesPeer::ICON, $this->icon);
        if ($this->isColumnModified(JobCategoriesPeer::ENABLED)) $criteria->add(JobCategoriesPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(JobCategoriesPeer::DELETED)) $criteria->add(JobCategoriesPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(JobCategoriesPeer::USEMAP)) $criteria->add(JobCategoriesPeer::USEMAP, $this->usemap);
        if ($this->isColumnModified(JobCategoriesPeer::ONMAIN)) $criteria->add(JobCategoriesPeer::ONMAIN, $this->onmain);

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
        $criteria = new Criteria(JobCategoriesPeer::DATABASE_NAME);
        $criteria->add(JobCategoriesPeer::ID, $this->id);

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
     * @param object $copyObj An object of JobCategories (or compatible) type.
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

            foreach ($this->getJobChildss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobChilds($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobCategoriesFieldss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobCategoriesFields($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getJobss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addJobs($relObj->copy($deepCopy));
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
     * @return JobCategories Clone of current object.
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
     * @return JobCategoriesPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new JobCategoriesPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a JobCategories object.
     *
     * @param                  JobCategories $v
     * @return JobCategories The current object (for fluent API support)
     * @throws PropelException
     */
    public function setJobCategoriesRelatedByParentId(JobCategories $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aJobCategoriesRelatedByParentId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the JobCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addJobChilds($this);
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
    public function getJobCategoriesRelatedByParentId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aJobCategoriesRelatedByParentId === null && ($this->parent_id !== null) && $doQuery) {
            $this->aJobCategoriesRelatedByParentId = JobCategoriesQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aJobCategoriesRelatedByParentId->addJobChildss($this);
             */
        }

        return $this->aJobCategoriesRelatedByParentId;
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
        if ('JobChilds' == $relationName) {
            $this->initJobChildss();
        }
        if ('JobCategoriesFields' == $relationName) {
            $this->initJobCategoriesFieldss();
        }
        if ('Jobs' == $relationName) {
            $this->initJobss();
        }
    }

    /**
     * Clears out the collJobChildss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return JobCategories The current object (for fluent API support)
     * @see        addJobChildss()
     */
    public function clearJobChildss()
    {
        $this->collJobChildss = null; // important to set this to null since that means it is uninitialized
        $this->collJobChildssPartial = null;

        return $this;
    }

    /**
     * reset is the collJobChildss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobChildss($v = true)
    {
        $this->collJobChildssPartial = $v;
    }

    /**
     * Initializes the collJobChildss collection.
     *
     * By default this just sets the collJobChildss collection to an empty array (like clearcollJobChildss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobChildss($overrideExisting = true)
    {
        if (null !== $this->collJobChildss && !$overrideExisting) {
            return;
        }
        $this->collJobChildss = new PropelObjectCollection();
        $this->collJobChildss->setModel('JobCategories');
    }

    /**
     * Gets an array of JobCategories objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this JobCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobCategories[] List of JobCategories objects
     * @throws PropelException
     */
    public function getJobChildss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobChildssPartial && !$this->isNew();
        if (null === $this->collJobChildss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobChildss) {
                // return empty collection
                $this->initJobChildss();
            } else {
                $collJobChildss = JobCategoriesQuery::create(null, $criteria)
                    ->filterByJobCategoriesRelatedByParentId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobChildssPartial && count($collJobChildss)) {
                      $this->initJobChildss(false);

                      foreach ($collJobChildss as $obj) {
                        if (false == $this->collJobChildss->contains($obj)) {
                          $this->collJobChildss->append($obj);
                        }
                      }

                      $this->collJobChildssPartial = true;
                    }

                    $collJobChildss->getInternalIterator()->rewind();

                    return $collJobChildss;
                }

                if ($partial && $this->collJobChildss) {
                    foreach ($this->collJobChildss as $obj) {
                        if ($obj->isNew()) {
                            $collJobChildss[] = $obj;
                        }
                    }
                }

                $this->collJobChildss = $collJobChildss;
                $this->collJobChildssPartial = false;
            }
        }

        return $this->collJobChildss;
    }

    /**
     * Sets a collection of JobChilds objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobChildss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return JobCategories The current object (for fluent API support)
     */
    public function setJobChildss(PropelCollection $jobChildss, PropelPDO $con = null)
    {
        $jobChildssToDelete = $this->getJobChildss(new Criteria(), $con)->diff($jobChildss);


        $this->jobChildssScheduledForDeletion = $jobChildssToDelete;

        foreach ($jobChildssToDelete as $jobChildsRemoved) {
            $jobChildsRemoved->setJobCategoriesRelatedByParentId(null);
        }

        $this->collJobChildss = null;
        foreach ($jobChildss as $jobChilds) {
            $this->addJobChilds($jobChilds);
        }

        $this->collJobChildss = $jobChildss;
        $this->collJobChildssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related JobCategories objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related JobCategories objects.
     * @throws PropelException
     */
    public function countJobChildss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobChildssPartial && !$this->isNew();
        if (null === $this->collJobChildss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobChildss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobChildss());
            }
            $query = JobCategoriesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobCategoriesRelatedByParentId($this)
                ->count($con);
        }

        return count($this->collJobChildss);
    }

    /**
     * Method called to associate a JobCategories object to this object
     * through the JobCategories foreign key attribute.
     *
     * @param    JobCategories $l JobCategories
     * @return JobCategories The current object (for fluent API support)
     */
    public function addJobChilds(JobCategories $l)
    {
        if ($this->collJobChildss === null) {
            $this->initJobChildss();
            $this->collJobChildssPartial = true;
        }

        if (!in_array($l, $this->collJobChildss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobChilds($l);

            if ($this->jobChildssScheduledForDeletion and $this->jobChildssScheduledForDeletion->contains($l)) {
                $this->jobChildssScheduledForDeletion->remove($this->jobChildssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobChilds $jobChilds The jobChilds object to add.
     */
    protected function doAddJobChilds($jobChilds)
    {
        $this->collJobChildss[]= $jobChilds;
        $jobChilds->setJobCategoriesRelatedByParentId($this);
    }

    /**
     * @param	JobChilds $jobChilds The jobChilds object to remove.
     * @return JobCategories The current object (for fluent API support)
     */
    public function removeJobChilds($jobChilds)
    {
        if ($this->getJobChildss()->contains($jobChilds)) {
            $this->collJobChildss->remove($this->collJobChildss->search($jobChilds));
            if (null === $this->jobChildssScheduledForDeletion) {
                $this->jobChildssScheduledForDeletion = clone $this->collJobChildss;
                $this->jobChildssScheduledForDeletion->clear();
            }
            $this->jobChildssScheduledForDeletion[]= $jobChilds;
            $jobChilds->setJobCategoriesRelatedByParentId(null);
        }

        return $this;
    }

    /**
     * Clears out the collJobCategoriesFieldss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return JobCategories The current object (for fluent API support)
     * @see        addJobCategoriesFieldss()
     */
    public function clearJobCategoriesFieldss()
    {
        $this->collJobCategoriesFieldss = null; // important to set this to null since that means it is uninitialized
        $this->collJobCategoriesFieldssPartial = null;

        return $this;
    }

    /**
     * reset is the collJobCategoriesFieldss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobCategoriesFieldss($v = true)
    {
        $this->collJobCategoriesFieldssPartial = $v;
    }

    /**
     * Initializes the collJobCategoriesFieldss collection.
     *
     * By default this just sets the collJobCategoriesFieldss collection to an empty array (like clearcollJobCategoriesFieldss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobCategoriesFieldss($overrideExisting = true)
    {
        if (null !== $this->collJobCategoriesFieldss && !$overrideExisting) {
            return;
        }
        $this->collJobCategoriesFieldss = new PropelObjectCollection();
        $this->collJobCategoriesFieldss->setModel('JobCategoriesFields');
    }

    /**
     * Gets an array of JobCategoriesFields objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this JobCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|JobCategoriesFields[] List of JobCategoriesFields objects
     * @throws PropelException
     */
    public function getJobCategoriesFieldss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobCategoriesFieldssPartial && !$this->isNew();
        if (null === $this->collJobCategoriesFieldss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobCategoriesFieldss) {
                // return empty collection
                $this->initJobCategoriesFieldss();
            } else {
                $collJobCategoriesFieldss = JobCategoriesFieldsQuery::create(null, $criteria)
                    ->filterByJobCategories($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobCategoriesFieldssPartial && count($collJobCategoriesFieldss)) {
                      $this->initJobCategoriesFieldss(false);

                      foreach ($collJobCategoriesFieldss as $obj) {
                        if (false == $this->collJobCategoriesFieldss->contains($obj)) {
                          $this->collJobCategoriesFieldss->append($obj);
                        }
                      }

                      $this->collJobCategoriesFieldssPartial = true;
                    }

                    $collJobCategoriesFieldss->getInternalIterator()->rewind();

                    return $collJobCategoriesFieldss;
                }

                if ($partial && $this->collJobCategoriesFieldss) {
                    foreach ($this->collJobCategoriesFieldss as $obj) {
                        if ($obj->isNew()) {
                            $collJobCategoriesFieldss[] = $obj;
                        }
                    }
                }

                $this->collJobCategoriesFieldss = $collJobCategoriesFieldss;
                $this->collJobCategoriesFieldssPartial = false;
            }
        }

        return $this->collJobCategoriesFieldss;
    }

    /**
     * Sets a collection of JobCategoriesFields objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobCategoriesFieldss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return JobCategories The current object (for fluent API support)
     */
    public function setJobCategoriesFieldss(PropelCollection $jobCategoriesFieldss, PropelPDO $con = null)
    {
        $jobCategoriesFieldssToDelete = $this->getJobCategoriesFieldss(new Criteria(), $con)->diff($jobCategoriesFieldss);


        $this->jobCategoriesFieldssScheduledForDeletion = $jobCategoriesFieldssToDelete;

        foreach ($jobCategoriesFieldssToDelete as $jobCategoriesFieldsRemoved) {
            $jobCategoriesFieldsRemoved->setJobCategories(null);
        }

        $this->collJobCategoriesFieldss = null;
        foreach ($jobCategoriesFieldss as $jobCategoriesFields) {
            $this->addJobCategoriesFields($jobCategoriesFields);
        }

        $this->collJobCategoriesFieldss = $jobCategoriesFieldss;
        $this->collJobCategoriesFieldssPartial = false;

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
    public function countJobCategoriesFieldss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobCategoriesFieldssPartial && !$this->isNew();
        if (null === $this->collJobCategoriesFieldss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobCategoriesFieldss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobCategoriesFieldss());
            }
            $query = JobCategoriesFieldsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobCategories($this)
                ->count($con);
        }

        return count($this->collJobCategoriesFieldss);
    }

    /**
     * Method called to associate a JobCategoriesFields object to this object
     * through the JobCategoriesFields foreign key attribute.
     *
     * @param    JobCategoriesFields $l JobCategoriesFields
     * @return JobCategories The current object (for fluent API support)
     */
    public function addJobCategoriesFields(JobCategoriesFields $l)
    {
        if ($this->collJobCategoriesFieldss === null) {
            $this->initJobCategoriesFieldss();
            $this->collJobCategoriesFieldssPartial = true;
        }

        if (!in_array($l, $this->collJobCategoriesFieldss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobCategoriesFields($l);

            if ($this->jobCategoriesFieldssScheduledForDeletion and $this->jobCategoriesFieldssScheduledForDeletion->contains($l)) {
                $this->jobCategoriesFieldssScheduledForDeletion->remove($this->jobCategoriesFieldssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	JobCategoriesFields $jobCategoriesFields The jobCategoriesFields object to add.
     */
    protected function doAddJobCategoriesFields($jobCategoriesFields)
    {
        $this->collJobCategoriesFieldss[]= $jobCategoriesFields;
        $jobCategoriesFields->setJobCategories($this);
    }

    /**
     * @param	JobCategoriesFields $jobCategoriesFields The jobCategoriesFields object to remove.
     * @return JobCategories The current object (for fluent API support)
     */
    public function removeJobCategoriesFields($jobCategoriesFields)
    {
        if ($this->getJobCategoriesFieldss()->contains($jobCategoriesFields)) {
            $this->collJobCategoriesFieldss->remove($this->collJobCategoriesFieldss->search($jobCategoriesFields));
            if (null === $this->jobCategoriesFieldssScheduledForDeletion) {
                $this->jobCategoriesFieldssScheduledForDeletion = clone $this->collJobCategoriesFieldss;
                $this->jobCategoriesFieldssScheduledForDeletion->clear();
            }
            $this->jobCategoriesFieldssScheduledForDeletion[]= $jobCategoriesFields;
            $jobCategoriesFields->setJobCategories(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategories is new, it will return
     * an empty collection; or if this JobCategories has previously
     * been saved, it will retrieve related JobCategoriesFieldss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategories.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|JobCategoriesFields[] List of JobCategoriesFields objects
     */
    public function getJobCategoriesFieldssJoinJobCategoriesFieldsRelatedByParentFieldId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobCategoriesFieldsQuery::create(null, $criteria);
        $query->joinWith('JobCategoriesFieldsRelatedByParentFieldId', $join_behavior);

        return $this->getJobCategoriesFieldss($query, $con);
    }

    /**
     * Clears out the collJobss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return JobCategories The current object (for fluent API support)
     * @see        addJobss()
     */
    public function clearJobss()
    {
        $this->collJobss = null; // important to set this to null since that means it is uninitialized
        $this->collJobssPartial = null;

        return $this;
    }

    /**
     * reset is the collJobss collection loaded partially
     *
     * @return void
     */
    public function resetPartialJobss($v = true)
    {
        $this->collJobssPartial = $v;
    }

    /**
     * Initializes the collJobss collection.
     *
     * By default this just sets the collJobss collection to an empty array (like clearcollJobss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initJobss($overrideExisting = true)
    {
        if (null !== $this->collJobss && !$overrideExisting) {
            return;
        }
        $this->collJobss = new PropelObjectCollection();
        $this->collJobss->setModel('Jobs');
    }

    /**
     * Gets an array of Jobs objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this JobCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Jobs[] List of Jobs objects
     * @throws PropelException
     */
    public function getJobss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collJobssPartial && !$this->isNew();
        if (null === $this->collJobss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collJobss) {
                // return empty collection
                $this->initJobss();
            } else {
                $collJobss = JobsQuery::create(null, $criteria)
                    ->filterByJobCategories($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collJobssPartial && count($collJobss)) {
                      $this->initJobss(false);

                      foreach ($collJobss as $obj) {
                        if (false == $this->collJobss->contains($obj)) {
                          $this->collJobss->append($obj);
                        }
                      }

                      $this->collJobssPartial = true;
                    }

                    $collJobss->getInternalIterator()->rewind();

                    return $collJobss;
                }

                if ($partial && $this->collJobss) {
                    foreach ($this->collJobss as $obj) {
                        if ($obj->isNew()) {
                            $collJobss[] = $obj;
                        }
                    }
                }

                $this->collJobss = $collJobss;
                $this->collJobssPartial = false;
            }
        }

        return $this->collJobss;
    }

    /**
     * Sets a collection of Jobs objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $jobss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return JobCategories The current object (for fluent API support)
     */
    public function setJobss(PropelCollection $jobss, PropelPDO $con = null)
    {
        $jobssToDelete = $this->getJobss(new Criteria(), $con)->diff($jobss);


        $this->jobssScheduledForDeletion = $jobssToDelete;

        foreach ($jobssToDelete as $jobsRemoved) {
            $jobsRemoved->setJobCategories(null);
        }

        $this->collJobss = null;
        foreach ($jobss as $jobs) {
            $this->addJobs($jobs);
        }

        $this->collJobss = $jobss;
        $this->collJobssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Jobs objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Jobs objects.
     * @throws PropelException
     */
    public function countJobss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collJobssPartial && !$this->isNew();
        if (null === $this->collJobss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collJobss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getJobss());
            }
            $query = JobsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByJobCategories($this)
                ->count($con);
        }

        return count($this->collJobss);
    }

    /**
     * Method called to associate a Jobs object to this object
     * through the Jobs foreign key attribute.
     *
     * @param    Jobs $l Jobs
     * @return JobCategories The current object (for fluent API support)
     */
    public function addJobs(Jobs $l)
    {
        if ($this->collJobss === null) {
            $this->initJobss();
            $this->collJobssPartial = true;
        }

        if (!in_array($l, $this->collJobss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddJobs($l);

            if ($this->jobssScheduledForDeletion and $this->jobssScheduledForDeletion->contains($l)) {
                $this->jobssScheduledForDeletion->remove($this->jobssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Jobs $jobs The jobs object to add.
     */
    protected function doAddJobs($jobs)
    {
        $this->collJobss[]= $jobs;
        $jobs->setJobCategories($this);
    }

    /**
     * @param	Jobs $jobs The jobs object to remove.
     * @return JobCategories The current object (for fluent API support)
     */
    public function removeJobs($jobs)
    {
        if ($this->getJobss()->contains($jobs)) {
            $this->collJobss->remove($this->collJobss->search($jobs));
            if (null === $this->jobssScheduledForDeletion) {
                $this->jobssScheduledForDeletion = clone $this->collJobss;
                $this->jobssScheduledForDeletion->clear();
            }
            $this->jobssScheduledForDeletion[]= clone $jobs;
            $jobs->setJobCategories(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategories is new, it will return
     * an empty collection; or if this JobCategories has previously
     * been saved, it will retrieve related Jobss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategories.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Jobs[] List of Jobs objects
     */
    public function getJobssJoinRegions($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobsQuery::create(null, $criteria);
        $query->joinWith('Regions', $join_behavior);

        return $this->getJobss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategories is new, it will return
     * an empty collection; or if this JobCategories has previously
     * been saved, it will retrieve related Jobss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategories.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Jobs[] List of Jobs objects
     */
    public function getJobssJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobsQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getJobss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this JobCategories is new, it will return
     * an empty collection; or if this JobCategories has previously
     * been saved, it will retrieve related Jobss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in JobCategories.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Jobs[] List of Jobs objects
     */
    public function getJobssJoinShops($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = JobsQuery::create(null, $criteria);
        $query->joinWith('Shops', $join_behavior);

        return $this->getJobss($query, $con);
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
            if ($this->collJobChildss) {
                foreach ($this->collJobChildss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobCategoriesFieldss) {
                foreach ($this->collJobCategoriesFieldss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collJobss) {
                foreach ($this->collJobss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aJobCategoriesRelatedByParentId instanceof Persistent) {
              $this->aJobCategoriesRelatedByParentId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collJobChildss instanceof PropelCollection) {
            $this->collJobChildss->clearIterator();
        }
        $this->collJobChildss = null;
        if ($this->collJobCategoriesFieldss instanceof PropelCollection) {
            $this->collJobCategoriesFieldss->clearIterator();
        }
        $this->collJobCategoriesFieldss = null;
        if ($this->collJobss instanceof PropelCollection) {
            $this->collJobss->clearIterator();
        }
        $this->collJobss = null;
        $this->aJobCategoriesRelatedByParentId = null;
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
