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
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\Areas;
use Admin\AdminBundle\Model\AreasPeer;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsQuery;

abstract class BaseAreas extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AreasPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AreasPeer
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
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the code field.
     * @var        int
     */
    protected $code;

    /**
     * The value for the alias field.
     * @var        string
     */
    protected $alias;

    /**
     * The value for the path field.
     * @var        string
     */
    protected $path;

    /**
     * The value for the part field.
     * @var        int
     */
    protected $part;

    /**
     * The value for the pagetitle field.
     * @var        string
     */
    protected $pagetitle;

    /**
     * The value for the net field.
     * @var        string
     */
    protected $net;

    /**
     * The value for the deleted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $deleted;

    /**
     * @var        PropelObjectCollection|Regions[] Collection to store aggregation of Regions objects.
     */
    protected $collRegionss;
    protected $collRegionssPartial;

    /**
     * @var        PropelObjectCollection|AdCategoriesSubscribe[] Collection to store aggregation of AdCategoriesSubscribe objects.
     */
    protected $collAdCategoriesSubscribes;
    protected $collAdCategoriesSubscribesPartial;

    /**
     * @var        PropelObjectCollection|Advs[] Collection to store aggregation of Advs objects.
     */
    protected $collAdvss;
    protected $collAdvssPartial;

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
    protected $regionssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $adCategoriesSubscribesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->deleted = false;
    }

    /**
     * Initializes internal state of BaseAreas object.
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
     * Код региона
     * @return int
     */
    public function getCode()
    {

        return $this->code;
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
     * Get the [path] column value.
     *
     * @return string
     */
    public function getPath()
    {

        return $this->path;
    }

    /**
     * Get the [part] column value.
     *
     * @return int
     */
    public function getPart()
    {

        return $this->part;
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
     * Get the [net] column value.
     *
     * @return string
     */
    public function getNet()
    {

        return $this->net;
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
     * @return Areas The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AreasPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AreasPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [code] column.
     * Код региона
     * @param  int $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setCode($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->code !== $v) {
            $this->code = $v;
            $this->modifiedColumns[] = AreasPeer::CODE;
        }


        return $this;
    } // setCode()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = AreasPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [path] column.
     *
     * @param  string $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setPath($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->path !== $v) {
            $this->path = $v;
            $this->modifiedColumns[] = AreasPeer::PATH;
        }


        return $this;
    } // setPath()

    /**
     * Set the value of [part] column.
     *
     * @param  int $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setPart($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->part !== $v) {
            $this->part = $v;
            $this->modifiedColumns[] = AreasPeer::PART;
        }


        return $this;
    } // setPart()

    /**
     * Set the value of [pagetitle] column.
     *
     * @param  string $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setPagetitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pagetitle !== $v) {
            $this->pagetitle = $v;
            $this->modifiedColumns[] = AreasPeer::PAGETITLE;
        }


        return $this;
    } // setPagetitle()

    /**
     * Set the value of [net] column.
     *
     * @param  string $v new value
     * @return Areas The current object (for fluent API support)
     */
    public function setNet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->net !== $v) {
            $this->net = $v;
            $this->modifiedColumns[] = AreasPeer::NET;
        }


        return $this;
    } // setNet()

    /**
     * Sets the value of the [deleted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Areas The current object (for fluent API support)
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
            $this->modifiedColumns[] = AreasPeer::DELETED;
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
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->code = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->alias = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->path = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->part = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->pagetitle = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->net = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->deleted = ($row[$startcol + 8] !== null) ? (boolean) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 9; // 9 = AreasPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Areas object", $e);
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
            $con = Propel::getConnection(AreasPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AreasPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collRegionss = null;

            $this->collAdCategoriesSubscribes = null;

            $this->collAdvss = null;

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
            $con = Propel::getConnection(AreasPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AreasQuery::create()
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
            $con = Propel::getConnection(AreasPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AreasPeer::addInstanceToPool($this);
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

            if ($this->regionssScheduledForDeletion !== null) {
                if (!$this->regionssScheduledForDeletion->isEmpty()) {
                    foreach ($this->regionssScheduledForDeletion as $regions) {
                        // need to save related object because we set the relation to null
                        $regions->save($con);
                    }
                    $this->regionssScheduledForDeletion = null;
                }
            }

            if ($this->collRegionss !== null) {
                foreach ($this->collRegionss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->adCategoriesSubscribesScheduledForDeletion !== null) {
                if (!$this->adCategoriesSubscribesScheduledForDeletion->isEmpty()) {
                    AdCategoriesSubscribeQuery::create()
                        ->filterByPrimaryKeys($this->adCategoriesSubscribesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adCategoriesSubscribesScheduledForDeletion = null;
                }
            }

            if ($this->collAdCategoriesSubscribes !== null) {
                foreach ($this->collAdCategoriesSubscribes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->advssScheduledForDeletion !== null) {
                if (!$this->advssScheduledForDeletion->isEmpty()) {
                    foreach ($this->advssScheduledForDeletion as $advs) {
                        // need to save related object because we set the relation to null
                        $advs->save($con);
                    }
                    $this->advssScheduledForDeletion = null;
                }
            }

            if ($this->collAdvss !== null) {
                foreach ($this->collAdvss as $referrerFK) {
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

        $this->modifiedColumns[] = AreasPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AreasPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AreasPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AreasPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(AreasPeer::CODE)) {
            $modifiedColumns[':p' . $index++]  = '`code`';
        }
        if ($this->isColumnModified(AreasPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(AreasPeer::PATH)) {
            $modifiedColumns[':p' . $index++]  = '`path`';
        }
        if ($this->isColumnModified(AreasPeer::PART)) {
            $modifiedColumns[':p' . $index++]  = '`part`';
        }
        if ($this->isColumnModified(AreasPeer::PAGETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`pagetitle`';
        }
        if ($this->isColumnModified(AreasPeer::NET)) {
            $modifiedColumns[':p' . $index++]  = '`net`';
        }
        if ($this->isColumnModified(AreasPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }

        $sql = sprintf(
            'INSERT INTO `areas` (%s) VALUES (%s)',
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
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`code`':
                        $stmt->bindValue($identifier, $this->code, PDO::PARAM_INT);
                        break;
                    case '`alias`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                    case '`path`':
                        $stmt->bindValue($identifier, $this->path, PDO::PARAM_STR);
                        break;
                    case '`part`':
                        $stmt->bindValue($identifier, $this->part, PDO::PARAM_INT);
                        break;
                    case '`pagetitle`':
                        $stmt->bindValue($identifier, $this->pagetitle, PDO::PARAM_STR);
                        break;
                    case '`net`':
                        $stmt->bindValue($identifier, $this->net, PDO::PARAM_STR);
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


            if (($retval = AreasPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collRegionss !== null) {
                    foreach ($this->collRegionss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdCategoriesSubscribes !== null) {
                    foreach ($this->collAdCategoriesSubscribes as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdvss !== null) {
                    foreach ($this->collAdvss as $referrerFK) {
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
        $pos = AreasPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
                return $this->getCode();
                break;
            case 3:
                return $this->getAlias();
                break;
            case 4:
                return $this->getPath();
                break;
            case 5:
                return $this->getPart();
                break;
            case 6:
                return $this->getPagetitle();
                break;
            case 7:
                return $this->getNet();
                break;
            case 8:
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
        if (isset($alreadyDumpedObjects['Areas'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Areas'][$this->getPrimaryKey()] = true;
        $keys = AreasPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getCode(),
            $keys[3] => $this->getAlias(),
            $keys[4] => $this->getPath(),
            $keys[5] => $this->getPart(),
            $keys[6] => $this->getPagetitle(),
            $keys[7] => $this->getNet(),
            $keys[8] => $this->getDeleted(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collRegionss) {
                $result['Regionss'] = $this->collRegionss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdCategoriesSubscribes) {
                $result['AdCategoriesSubscribes'] = $this->collAdCategoriesSubscribes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvss) {
                $result['Advss'] = $this->collAdvss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AreasPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setName($value);
                break;
            case 2:
                $this->setCode($value);
                break;
            case 3:
                $this->setAlias($value);
                break;
            case 4:
                $this->setPath($value);
                break;
            case 5:
                $this->setPart($value);
                break;
            case 6:
                $this->setPagetitle($value);
                break;
            case 7:
                $this->setNet($value);
                break;
            case 8:
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
        $keys = AreasPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setCode($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAlias($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setPath($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPart($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPagetitle($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setNet($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDeleted($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AreasPeer::DATABASE_NAME);

        if ($this->isColumnModified(AreasPeer::ID)) $criteria->add(AreasPeer::ID, $this->id);
        if ($this->isColumnModified(AreasPeer::NAME)) $criteria->add(AreasPeer::NAME, $this->name);
        if ($this->isColumnModified(AreasPeer::CODE)) $criteria->add(AreasPeer::CODE, $this->code);
        if ($this->isColumnModified(AreasPeer::ALIAS)) $criteria->add(AreasPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(AreasPeer::PATH)) $criteria->add(AreasPeer::PATH, $this->path);
        if ($this->isColumnModified(AreasPeer::PART)) $criteria->add(AreasPeer::PART, $this->part);
        if ($this->isColumnModified(AreasPeer::PAGETITLE)) $criteria->add(AreasPeer::PAGETITLE, $this->pagetitle);
        if ($this->isColumnModified(AreasPeer::NET)) $criteria->add(AreasPeer::NET, $this->net);
        if ($this->isColumnModified(AreasPeer::DELETED)) $criteria->add(AreasPeer::DELETED, $this->deleted);

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
        $criteria = new Criteria(AreasPeer::DATABASE_NAME);
        $criteria->add(AreasPeer::ID, $this->id);

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
     * @param object $copyObj An object of Areas (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setCode($this->getCode());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setPath($this->getPath());
        $copyObj->setPart($this->getPart());
        $copyObj->setPagetitle($this->getPagetitle());
        $copyObj->setNet($this->getNet());
        $copyObj->setDeleted($this->getDeleted());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getRegionss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRegions($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdCategoriesSubscribes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdCategoriesSubscribe($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdvss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvs($relObj->copy($deepCopy));
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
     * @return Areas Clone of current object.
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
     * @return AreasPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AreasPeer();
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
        if ('Regions' == $relationName) {
            $this->initRegionss();
        }
        if ('AdCategoriesSubscribe' == $relationName) {
            $this->initAdCategoriesSubscribes();
        }
        if ('Advs' == $relationName) {
            $this->initAdvss();
        }
    }

    /**
     * Clears out the collRegionss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Areas The current object (for fluent API support)
     * @see        addRegionss()
     */
    public function clearRegionss()
    {
        $this->collRegionss = null; // important to set this to null since that means it is uninitialized
        $this->collRegionssPartial = null;

        return $this;
    }

    /**
     * reset is the collRegionss collection loaded partially
     *
     * @return void
     */
    public function resetPartialRegionss($v = true)
    {
        $this->collRegionssPartial = $v;
    }

    /**
     * Initializes the collRegionss collection.
     *
     * By default this just sets the collRegionss collection to an empty array (like clearcollRegionss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRegionss($overrideExisting = true)
    {
        if (null !== $this->collRegionss && !$overrideExisting) {
            return;
        }
        $this->collRegionss = new PropelObjectCollection();
        $this->collRegionss->setModel('Regions');
    }

    /**
     * Gets an array of Regions objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Areas is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Regions[] List of Regions objects
     * @throws PropelException
     */
    public function getRegionss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collRegionssPartial && !$this->isNew();
        if (null === $this->collRegionss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collRegionss) {
                // return empty collection
                $this->initRegionss();
            } else {
                $collRegionss = RegionsQuery::create(null, $criteria)
                    ->filterByAreas($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collRegionssPartial && count($collRegionss)) {
                      $this->initRegionss(false);

                      foreach ($collRegionss as $obj) {
                        if (false == $this->collRegionss->contains($obj)) {
                          $this->collRegionss->append($obj);
                        }
                      }

                      $this->collRegionssPartial = true;
                    }

                    $collRegionss->getInternalIterator()->rewind();

                    return $collRegionss;
                }

                if ($partial && $this->collRegionss) {
                    foreach ($this->collRegionss as $obj) {
                        if ($obj->isNew()) {
                            $collRegionss[] = $obj;
                        }
                    }
                }

                $this->collRegionss = $collRegionss;
                $this->collRegionssPartial = false;
            }
        }

        return $this->collRegionss;
    }

    /**
     * Sets a collection of Regions objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $regionss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Areas The current object (for fluent API support)
     */
    public function setRegionss(PropelCollection $regionss, PropelPDO $con = null)
    {
        $regionssToDelete = $this->getRegionss(new Criteria(), $con)->diff($regionss);


        $this->regionssScheduledForDeletion = $regionssToDelete;

        foreach ($regionssToDelete as $regionsRemoved) {
            $regionsRemoved->setAreas(null);
        }

        $this->collRegionss = null;
        foreach ($regionss as $regions) {
            $this->addRegions($regions);
        }

        $this->collRegionss = $regionss;
        $this->collRegionssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Regions objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Regions objects.
     * @throws PropelException
     */
    public function countRegionss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collRegionssPartial && !$this->isNew();
        if (null === $this->collRegionss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRegionss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRegionss());
            }
            $query = RegionsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAreas($this)
                ->count($con);
        }

        return count($this->collRegionss);
    }

    /**
     * Method called to associate a Regions object to this object
     * through the Regions foreign key attribute.
     *
     * @param    Regions $l Regions
     * @return Areas The current object (for fluent API support)
     */
    public function addRegions(Regions $l)
    {
        if ($this->collRegionss === null) {
            $this->initRegionss();
            $this->collRegionssPartial = true;
        }

        if (!in_array($l, $this->collRegionss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddRegions($l);

            if ($this->regionssScheduledForDeletion and $this->regionssScheduledForDeletion->contains($l)) {
                $this->regionssScheduledForDeletion->remove($this->regionssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Regions $regions The regions object to add.
     */
    protected function doAddRegions($regions)
    {
        $this->collRegionss[]= $regions;
        $regions->setAreas($this);
    }

    /**
     * @param	Regions $regions The regions object to remove.
     * @return Areas The current object (for fluent API support)
     */
    public function removeRegions($regions)
    {
        if ($this->getRegionss()->contains($regions)) {
            $this->collRegionss->remove($this->collRegionss->search($regions));
            if (null === $this->regionssScheduledForDeletion) {
                $this->regionssScheduledForDeletion = clone $this->collRegionss;
                $this->regionssScheduledForDeletion->clear();
            }
            $this->regionssScheduledForDeletion[]= $regions;
            $regions->setAreas(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdCategoriesSubscribes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Areas The current object (for fluent API support)
     * @see        addAdCategoriesSubscribes()
     */
    public function clearAdCategoriesSubscribes()
    {
        $this->collAdCategoriesSubscribes = null; // important to set this to null since that means it is uninitialized
        $this->collAdCategoriesSubscribesPartial = null;

        return $this;
    }

    /**
     * reset is the collAdCategoriesSubscribes collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdCategoriesSubscribes($v = true)
    {
        $this->collAdCategoriesSubscribesPartial = $v;
    }

    /**
     * Initializes the collAdCategoriesSubscribes collection.
     *
     * By default this just sets the collAdCategoriesSubscribes collection to an empty array (like clearcollAdCategoriesSubscribes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdCategoriesSubscribes($overrideExisting = true)
    {
        if (null !== $this->collAdCategoriesSubscribes && !$overrideExisting) {
            return;
        }
        $this->collAdCategoriesSubscribes = new PropelObjectCollection();
        $this->collAdCategoriesSubscribes->setModel('AdCategoriesSubscribe');
    }

    /**
     * Gets an array of AdCategoriesSubscribe objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Areas is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdCategoriesSubscribe[] List of AdCategoriesSubscribe objects
     * @throws PropelException
     */
    public function getAdCategoriesSubscribes($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdCategoriesSubscribesPartial && !$this->isNew();
        if (null === $this->collAdCategoriesSubscribes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdCategoriesSubscribes) {
                // return empty collection
                $this->initAdCategoriesSubscribes();
            } else {
                $collAdCategoriesSubscribes = AdCategoriesSubscribeQuery::create(null, $criteria)
                    ->filterByAreas($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdCategoriesSubscribesPartial && count($collAdCategoriesSubscribes)) {
                      $this->initAdCategoriesSubscribes(false);

                      foreach ($collAdCategoriesSubscribes as $obj) {
                        if (false == $this->collAdCategoriesSubscribes->contains($obj)) {
                          $this->collAdCategoriesSubscribes->append($obj);
                        }
                      }

                      $this->collAdCategoriesSubscribesPartial = true;
                    }

                    $collAdCategoriesSubscribes->getInternalIterator()->rewind();

                    return $collAdCategoriesSubscribes;
                }

                if ($partial && $this->collAdCategoriesSubscribes) {
                    foreach ($this->collAdCategoriesSubscribes as $obj) {
                        if ($obj->isNew()) {
                            $collAdCategoriesSubscribes[] = $obj;
                        }
                    }
                }

                $this->collAdCategoriesSubscribes = $collAdCategoriesSubscribes;
                $this->collAdCategoriesSubscribesPartial = false;
            }
        }

        return $this->collAdCategoriesSubscribes;
    }

    /**
     * Sets a collection of AdCategoriesSubscribe objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $adCategoriesSubscribes A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Areas The current object (for fluent API support)
     */
    public function setAdCategoriesSubscribes(PropelCollection $adCategoriesSubscribes, PropelPDO $con = null)
    {
        $adCategoriesSubscribesToDelete = $this->getAdCategoriesSubscribes(new Criteria(), $con)->diff($adCategoriesSubscribes);


        $this->adCategoriesSubscribesScheduledForDeletion = $adCategoriesSubscribesToDelete;

        foreach ($adCategoriesSubscribesToDelete as $adCategoriesSubscribeRemoved) {
            $adCategoriesSubscribeRemoved->setAreas(null);
        }

        $this->collAdCategoriesSubscribes = null;
        foreach ($adCategoriesSubscribes as $adCategoriesSubscribe) {
            $this->addAdCategoriesSubscribe($adCategoriesSubscribe);
        }

        $this->collAdCategoriesSubscribes = $adCategoriesSubscribes;
        $this->collAdCategoriesSubscribesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdCategoriesSubscribe objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdCategoriesSubscribe objects.
     * @throws PropelException
     */
    public function countAdCategoriesSubscribes(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdCategoriesSubscribesPartial && !$this->isNew();
        if (null === $this->collAdCategoriesSubscribes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdCategoriesSubscribes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdCategoriesSubscribes());
            }
            $query = AdCategoriesSubscribeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAreas($this)
                ->count($con);
        }

        return count($this->collAdCategoriesSubscribes);
    }

    /**
     * Method called to associate a AdCategoriesSubscribe object to this object
     * through the AdCategoriesSubscribe foreign key attribute.
     *
     * @param    AdCategoriesSubscribe $l AdCategoriesSubscribe
     * @return Areas The current object (for fluent API support)
     */
    public function addAdCategoriesSubscribe(AdCategoriesSubscribe $l)
    {
        if ($this->collAdCategoriesSubscribes === null) {
            $this->initAdCategoriesSubscribes();
            $this->collAdCategoriesSubscribesPartial = true;
        }

        if (!in_array($l, $this->collAdCategoriesSubscribes->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdCategoriesSubscribe($l);

            if ($this->adCategoriesSubscribesScheduledForDeletion and $this->adCategoriesSubscribesScheduledForDeletion->contains($l)) {
                $this->adCategoriesSubscribesScheduledForDeletion->remove($this->adCategoriesSubscribesScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdCategoriesSubscribe $adCategoriesSubscribe The adCategoriesSubscribe object to add.
     */
    protected function doAddAdCategoriesSubscribe($adCategoriesSubscribe)
    {
        $this->collAdCategoriesSubscribes[]= $adCategoriesSubscribe;
        $adCategoriesSubscribe->setAreas($this);
    }

    /**
     * @param	AdCategoriesSubscribe $adCategoriesSubscribe The adCategoriesSubscribe object to remove.
     * @return Areas The current object (for fluent API support)
     */
    public function removeAdCategoriesSubscribe($adCategoriesSubscribe)
    {
        if ($this->getAdCategoriesSubscribes()->contains($adCategoriesSubscribe)) {
            $this->collAdCategoriesSubscribes->remove($this->collAdCategoriesSubscribes->search($adCategoriesSubscribe));
            if (null === $this->adCategoriesSubscribesScheduledForDeletion) {
                $this->adCategoriesSubscribesScheduledForDeletion = clone $this->collAdCategoriesSubscribes;
                $this->adCategoriesSubscribesScheduledForDeletion->clear();
            }
            $this->adCategoriesSubscribesScheduledForDeletion[]= $adCategoriesSubscribe;
            $adCategoriesSubscribe->setAreas(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Areas is new, it will return
     * an empty collection; or if this Areas has previously
     * been saved, it will retrieve related AdCategoriesSubscribes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Areas.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdCategoriesSubscribe[] List of AdCategoriesSubscribe objects
     */
    public function getAdCategoriesSubscribesJoinAdCategories($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdCategoriesSubscribeQuery::create(null, $criteria);
        $query->joinWith('AdCategories', $join_behavior);

        return $this->getAdCategoriesSubscribes($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Areas is new, it will return
     * an empty collection; or if this Areas has previously
     * been saved, it will retrieve related AdCategoriesSubscribes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Areas.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdCategoriesSubscribe[] List of AdCategoriesSubscribe objects
     */
    public function getAdCategoriesSubscribesJoinRegions($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdCategoriesSubscribeQuery::create(null, $criteria);
        $query->joinWith('Regions', $join_behavior);

        return $this->getAdCategoriesSubscribes($query, $con);
    }

    /**
     * Clears out the collAdvss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Areas The current object (for fluent API support)
     * @see        addAdvss()
     */
    public function clearAdvss()
    {
        $this->collAdvss = null; // important to set this to null since that means it is uninitialized
        $this->collAdvssPartial = null;

        return $this;
    }

    /**
     * reset is the collAdvss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdvss($v = true)
    {
        $this->collAdvssPartial = $v;
    }

    /**
     * Initializes the collAdvss collection.
     *
     * By default this just sets the collAdvss collection to an empty array (like clearcollAdvss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdvss($overrideExisting = true)
    {
        if (null !== $this->collAdvss && !$overrideExisting) {
            return;
        }
        $this->collAdvss = new PropelObjectCollection();
        $this->collAdvss->setModel('Advs');
    }

    /**
     * Gets an array of Advs objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Areas is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Advs[] List of Advs objects
     * @throws PropelException
     */
    public function getAdvss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdvssPartial && !$this->isNew();
        if (null === $this->collAdvss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdvss) {
                // return empty collection
                $this->initAdvss();
            } else {
                $collAdvss = AdvsQuery::create(null, $criteria)
                    ->filterByAreas($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdvssPartial && count($collAdvss)) {
                      $this->initAdvss(false);

                      foreach ($collAdvss as $obj) {
                        if (false == $this->collAdvss->contains($obj)) {
                          $this->collAdvss->append($obj);
                        }
                      }

                      $this->collAdvssPartial = true;
                    }

                    $collAdvss->getInternalIterator()->rewind();

                    return $collAdvss;
                }

                if ($partial && $this->collAdvss) {
                    foreach ($this->collAdvss as $obj) {
                        if ($obj->isNew()) {
                            $collAdvss[] = $obj;
                        }
                    }
                }

                $this->collAdvss = $collAdvss;
                $this->collAdvssPartial = false;
            }
        }

        return $this->collAdvss;
    }

    /**
     * Sets a collection of Advs objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $advss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Areas The current object (for fluent API support)
     */
    public function setAdvss(PropelCollection $advss, PropelPDO $con = null)
    {
        $advssToDelete = $this->getAdvss(new Criteria(), $con)->diff($advss);


        $this->advssScheduledForDeletion = $advssToDelete;

        foreach ($advssToDelete as $advsRemoved) {
            $advsRemoved->setAreas(null);
        }

        $this->collAdvss = null;
        foreach ($advss as $advs) {
            $this->addAdvs($advs);
        }

        $this->collAdvss = $advss;
        $this->collAdvssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Advs objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Advs objects.
     * @throws PropelException
     */
    public function countAdvss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdvssPartial && !$this->isNew();
        if (null === $this->collAdvss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdvss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdvss());
            }
            $query = AdvsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAreas($this)
                ->count($con);
        }

        return count($this->collAdvss);
    }

    /**
     * Method called to associate a Advs object to this object
     * through the Advs foreign key attribute.
     *
     * @param    Advs $l Advs
     * @return Areas The current object (for fluent API support)
     */
    public function addAdvs(Advs $l)
    {
        if ($this->collAdvss === null) {
            $this->initAdvss();
            $this->collAdvssPartial = true;
        }

        if (!in_array($l, $this->collAdvss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdvs($l);

            if ($this->advssScheduledForDeletion and $this->advssScheduledForDeletion->contains($l)) {
                $this->advssScheduledForDeletion->remove($this->advssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Advs $advs The advs object to add.
     */
    protected function doAddAdvs($advs)
    {
        $this->collAdvss[]= $advs;
        $advs->setAreas($this);
    }

    /**
     * @param	Advs $advs The advs object to remove.
     * @return Areas The current object (for fluent API support)
     */
    public function removeAdvs($advs)
    {
        if ($this->getAdvss()->contains($advs)) {
            $this->collAdvss->remove($this->collAdvss->search($advs));
            if (null === $this->advssScheduledForDeletion) {
                $this->advssScheduledForDeletion = clone $this->collAdvss;
                $this->advssScheduledForDeletion->clear();
            }
            $this->advssScheduledForDeletion[]= $advs;
            $advs->setAreas(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Areas is new, it will return
     * an empty collection; or if this Areas has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Areas.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Advs[] List of Advs objects
     */
    public function getAdvssJoinRegions($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvsQuery::create(null, $criteria);
        $query->joinWith('Regions', $join_behavior);

        return $this->getAdvss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Areas is new, it will return
     * an empty collection; or if this Areas has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Areas.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Advs[] List of Advs objects
     */
    public function getAdvssJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvsQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getAdvss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Areas is new, it will return
     * an empty collection; or if this Areas has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Areas.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Advs[] List of Advs objects
     */
    public function getAdvssJoinShops($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvsQuery::create(null, $criteria);
        $query->joinWith('Shops', $join_behavior);

        return $this->getAdvss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Areas is new, it will return
     * an empty collection; or if this Areas has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Areas.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Advs[] List of Advs objects
     */
    public function getAdvssJoinAdCategories($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvsQuery::create(null, $criteria);
        $query->joinWith('AdCategories', $join_behavior);

        return $this->getAdvss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->code = null;
        $this->alias = null;
        $this->path = null;
        $this->part = null;
        $this->pagetitle = null;
        $this->net = null;
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
            if ($this->collRegionss) {
                foreach ($this->collRegionss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdCategoriesSubscribes) {
                foreach ($this->collAdCategoriesSubscribes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvss) {
                foreach ($this->collAdvss as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collRegionss instanceof PropelCollection) {
            $this->collRegionss->clearIterator();
        }
        $this->collRegionss = null;
        if ($this->collAdCategoriesSubscribes instanceof PropelCollection) {
            $this->collAdCategoriesSubscribes->clearIterator();
        }
        $this->collAdCategoriesSubscribes = null;
        if ($this->collAdvss instanceof PropelCollection) {
            $this->collAdvss->clearIterator();
        }
        $this->collAdvss = null;
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
