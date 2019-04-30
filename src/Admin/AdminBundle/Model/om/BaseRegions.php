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
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsPeer;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\Shops;
use Admin\AdminBundle\Model\ShopsQuery;

abstract class BaseRegions extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\RegionsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        RegionsPeer
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
     * The value for the area_id field.
     * @var        int
     */
    protected $area_id;

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
     * The value for the alias field.
     * @var        string
     */
    protected $alias;

    /**
     * The value for the icon field.
     * @var        string
     */
    protected $icon;

    /**
     * The value for the type field.
     * @var        int
     */
    protected $type;

    /**
     * The value for the weather field.
     * @var        int
     */
    protected $weather;

    /**
     * The value for the deleted field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $deleted;

    /**
     * @var        Areas
     */
    protected $aAreas;

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
     * @var        PropelObjectCollection|Shops[] Collection to store aggregation of Shops objects.
     */
    protected $collShopss;
    protected $collShopssPartial;

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
    protected $adCategoriesSubscribesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $advssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $shopssScheduledForDeletion = null;

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
     * Initializes internal state of BaseRegions object.
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
     * Get the [area_id] column value.
     *
     * @return int
     */
    public function getAreaId()
    {

        return $this->area_id;
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
     * Get the [alias] column value.
     *
     * @return string
     */
    public function getAlias()
    {

        return $this->alias;
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
     * Get the [type] column value.
     * Тип населенного пункта
     * @return int
     */
    public function getType()
    {

        return $this->type;
    }

    /**
     * Get the [weather] column value.
     * Код города для ГИС-Метео
     * @return int
     */
    public function getWeather()
    {

        return $this->weather;
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
     * @return Regions The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = RegionsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = RegionsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [area_id] column.
     *
     * @param  int $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setAreaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->area_id !== $v) {
            $this->area_id = $v;
            $this->modifiedColumns[] = RegionsPeer::AREA_ID;
        }

        if ($this->aAreas !== null && $this->aAreas->getId() !== $v) {
            $this->aAreas = null;
        }


        return $this;
    } // setAreaId()

    /**
     * Set the value of [pagetitle] column.
     *
     * @param  string $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setPagetitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pagetitle !== $v) {
            $this->pagetitle = $v;
            $this->modifiedColumns[] = RegionsPeer::PAGETITLE;
        }


        return $this;
    } // setPagetitle()

    /**
     * Set the value of [net] column.
     *
     * @param  string $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setNet($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->net !== $v) {
            $this->net = $v;
            $this->modifiedColumns[] = RegionsPeer::NET;
        }


        return $this;
    } // setNet()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = RegionsPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [icon] column.
     *
     * @param  string $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[] = RegionsPeer::ICON;
        }


        return $this;
    } // setIcon()

    /**
     * Set the value of [type] column.
     * Тип населенного пункта
     * @param  int $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = RegionsPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [weather] column.
     * Код города для ГИС-Метео
     * @param  int $v new value
     * @return Regions The current object (for fluent API support)
     */
    public function setWeather($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->weather !== $v) {
            $this->weather = $v;
            $this->modifiedColumns[] = RegionsPeer::WEATHER;
        }


        return $this;
    } // setWeather()

    /**
     * Sets the value of the [deleted] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Regions The current object (for fluent API support)
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
            $this->modifiedColumns[] = RegionsPeer::DELETED;
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
            $this->area_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->pagetitle = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->net = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->alias = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->icon = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->type = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->weather = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->deleted = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 10; // 10 = RegionsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Regions object", $e);
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

        if ($this->aAreas !== null && $this->area_id !== $this->aAreas->getId()) {
            $this->aAreas = null;
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
            $con = Propel::getConnection(RegionsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = RegionsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAreas = null;
            $this->collAdCategoriesSubscribes = null;

            $this->collAdvss = null;

            $this->collShopss = null;

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
            $con = Propel::getConnection(RegionsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = RegionsQuery::create()
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
            $con = Propel::getConnection(RegionsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                RegionsPeer::addInstanceToPool($this);
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

            if ($this->aAreas !== null) {
                if ($this->aAreas->isModified() || $this->aAreas->isNew()) {
                    $affectedRows += $this->aAreas->save($con);
                }
                $this->setAreas($this->aAreas);
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
                    AdvsQuery::create()
                        ->filterByPrimaryKeys($this->advssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

            if ($this->shopssScheduledForDeletion !== null) {
                if (!$this->shopssScheduledForDeletion->isEmpty()) {
                    ShopsQuery::create()
                        ->filterByPrimaryKeys($this->shopssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->shopssScheduledForDeletion = null;
                }
            }

            if ($this->collShopss !== null) {
                foreach ($this->collShopss as $referrerFK) {
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

        $this->modifiedColumns[] = RegionsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . RegionsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(RegionsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(RegionsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(RegionsPeer::AREA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`area_id`';
        }
        if ($this->isColumnModified(RegionsPeer::PAGETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`pagetitle`';
        }
        if ($this->isColumnModified(RegionsPeer::NET)) {
            $modifiedColumns[':p' . $index++]  = '`net`';
        }
        if ($this->isColumnModified(RegionsPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(RegionsPeer::ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }
        if ($this->isColumnModified(RegionsPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(RegionsPeer::WEATHER)) {
            $modifiedColumns[':p' . $index++]  = '`weather`';
        }
        if ($this->isColumnModified(RegionsPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }

        $sql = sprintf(
            'INSERT INTO `regions` (%s) VALUES (%s)',
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
                    case '`area_id`':
                        $stmt->bindValue($identifier, $this->area_id, PDO::PARAM_INT);
                        break;
                    case '`pagetitle`':
                        $stmt->bindValue($identifier, $this->pagetitle, PDO::PARAM_STR);
                        break;
                    case '`net`':
                        $stmt->bindValue($identifier, $this->net, PDO::PARAM_STR);
                        break;
                    case '`alias`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                    case '`icon`':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`weather`':
                        $stmt->bindValue($identifier, $this->weather, PDO::PARAM_INT);
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

            if ($this->aAreas !== null) {
                if (!$this->aAreas->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAreas->getValidationFailures());
                }
            }


            if (($retval = RegionsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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

                if ($this->collShopss !== null) {
                    foreach ($this->collShopss as $referrerFK) {
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
        $pos = RegionsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAreaId();
                break;
            case 3:
                return $this->getPagetitle();
                break;
            case 4:
                return $this->getNet();
                break;
            case 5:
                return $this->getAlias();
                break;
            case 6:
                return $this->getIcon();
                break;
            case 7:
                return $this->getType();
                break;
            case 8:
                return $this->getWeather();
                break;
            case 9:
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
        if (isset($alreadyDumpedObjects['Regions'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Regions'][$this->getPrimaryKey()] = true;
        $keys = RegionsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAreaId(),
            $keys[3] => $this->getPagetitle(),
            $keys[4] => $this->getNet(),
            $keys[5] => $this->getAlias(),
            $keys[6] => $this->getIcon(),
            $keys[7] => $this->getType(),
            $keys[8] => $this->getWeather(),
            $keys[9] => $this->getDeleted(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAreas) {
                $result['Areas'] = $this->aAreas->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAdCategoriesSubscribes) {
                $result['AdCategoriesSubscribes'] = $this->collAdCategoriesSubscribes->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdvss) {
                $result['Advss'] = $this->collAdvss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collShopss) {
                $result['Shopss'] = $this->collShopss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = RegionsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAreaId($value);
                break;
            case 3:
                $this->setPagetitle($value);
                break;
            case 4:
                $this->setNet($value);
                break;
            case 5:
                $this->setAlias($value);
                break;
            case 6:
                $this->setIcon($value);
                break;
            case 7:
                $this->setType($value);
                break;
            case 8:
                $this->setWeather($value);
                break;
            case 9:
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
        $keys = RegionsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAreaId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPagetitle($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setNet($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setAlias($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIcon($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setType($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setWeather($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDeleted($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(RegionsPeer::DATABASE_NAME);

        if ($this->isColumnModified(RegionsPeer::ID)) $criteria->add(RegionsPeer::ID, $this->id);
        if ($this->isColumnModified(RegionsPeer::NAME)) $criteria->add(RegionsPeer::NAME, $this->name);
        if ($this->isColumnModified(RegionsPeer::AREA_ID)) $criteria->add(RegionsPeer::AREA_ID, $this->area_id);
        if ($this->isColumnModified(RegionsPeer::PAGETITLE)) $criteria->add(RegionsPeer::PAGETITLE, $this->pagetitle);
        if ($this->isColumnModified(RegionsPeer::NET)) $criteria->add(RegionsPeer::NET, $this->net);
        if ($this->isColumnModified(RegionsPeer::ALIAS)) $criteria->add(RegionsPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(RegionsPeer::ICON)) $criteria->add(RegionsPeer::ICON, $this->icon);
        if ($this->isColumnModified(RegionsPeer::TYPE)) $criteria->add(RegionsPeer::TYPE, $this->type);
        if ($this->isColumnModified(RegionsPeer::WEATHER)) $criteria->add(RegionsPeer::WEATHER, $this->weather);
        if ($this->isColumnModified(RegionsPeer::DELETED)) $criteria->add(RegionsPeer::DELETED, $this->deleted);

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
        $criteria = new Criteria(RegionsPeer::DATABASE_NAME);
        $criteria->add(RegionsPeer::ID, $this->id);

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
     * @param object $copyObj An object of Regions (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setAreaId($this->getAreaId());
        $copyObj->setPagetitle($this->getPagetitle());
        $copyObj->setNet($this->getNet());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setIcon($this->getIcon());
        $copyObj->setType($this->getType());
        $copyObj->setWeather($this->getWeather());
        $copyObj->setDeleted($this->getDeleted());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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

            foreach ($this->getShopss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addShops($relObj->copy($deepCopy));
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
     * @return Regions Clone of current object.
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
     * @return RegionsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new RegionsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Areas object.
     *
     * @param                  Areas $v
     * @return Regions The current object (for fluent API support)
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
            $v->addRegions($this);
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
                $this->aAreas->addRegionss($this);
             */
        }

        return $this->aAreas;
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
        if ('AdCategoriesSubscribe' == $relationName) {
            $this->initAdCategoriesSubscribes();
        }
        if ('Advs' == $relationName) {
            $this->initAdvss();
        }
        if ('Shops' == $relationName) {
            $this->initShopss();
        }
    }

    /**
     * Clears out the collAdCategoriesSubscribes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Regions The current object (for fluent API support)
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
     * If this Regions is new, it will return
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
                    ->filterByRegions($this)
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
     * @return Regions The current object (for fluent API support)
     */
    public function setAdCategoriesSubscribes(PropelCollection $adCategoriesSubscribes, PropelPDO $con = null)
    {
        $adCategoriesSubscribesToDelete = $this->getAdCategoriesSubscribes(new Criteria(), $con)->diff($adCategoriesSubscribes);


        $this->adCategoriesSubscribesScheduledForDeletion = $adCategoriesSubscribesToDelete;

        foreach ($adCategoriesSubscribesToDelete as $adCategoriesSubscribeRemoved) {
            $adCategoriesSubscribeRemoved->setRegions(null);
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
                ->filterByRegions($this)
                ->count($con);
        }

        return count($this->collAdCategoriesSubscribes);
    }

    /**
     * Method called to associate a AdCategoriesSubscribe object to this object
     * through the AdCategoriesSubscribe foreign key attribute.
     *
     * @param    AdCategoriesSubscribe $l AdCategoriesSubscribe
     * @return Regions The current object (for fluent API support)
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
        $adCategoriesSubscribe->setRegions($this);
    }

    /**
     * @param	AdCategoriesSubscribe $adCategoriesSubscribe The adCategoriesSubscribe object to remove.
     * @return Regions The current object (for fluent API support)
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
            $adCategoriesSubscribe->setRegions(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related AdCategoriesSubscribes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
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
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related AdCategoriesSubscribes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdCategoriesSubscribe[] List of AdCategoriesSubscribe objects
     */
    public function getAdCategoriesSubscribesJoinAreas($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdCategoriesSubscribeQuery::create(null, $criteria);
        $query->joinWith('Areas', $join_behavior);

        return $this->getAdCategoriesSubscribes($query, $con);
    }

    /**
     * Clears out the collAdvss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Regions The current object (for fluent API support)
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
     * If this Regions is new, it will return
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
                    ->filterByRegions($this)
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
     * @return Regions The current object (for fluent API support)
     */
    public function setAdvss(PropelCollection $advss, PropelPDO $con = null)
    {
        $advssToDelete = $this->getAdvss(new Criteria(), $con)->diff($advss);


        $this->advssScheduledForDeletion = $advssToDelete;

        foreach ($advssToDelete as $advsRemoved) {
            $advsRemoved->setRegions(null);
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
                ->filterByRegions($this)
                ->count($con);
        }

        return count($this->collAdvss);
    }

    /**
     * Method called to associate a Advs object to this object
     * through the Advs foreign key attribute.
     *
     * @param    Advs $l Advs
     * @return Regions The current object (for fluent API support)
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
        $advs->setRegions($this);
    }

    /**
     * @param	Advs $advs The advs object to remove.
     * @return Regions The current object (for fluent API support)
     */
    public function removeAdvs($advs)
    {
        if ($this->getAdvss()->contains($advs)) {
            $this->collAdvss->remove($this->collAdvss->search($advs));
            if (null === $this->advssScheduledForDeletion) {
                $this->advssScheduledForDeletion = clone $this->collAdvss;
                $this->advssScheduledForDeletion->clear();
            }
            $this->advssScheduledForDeletion[]= clone $advs;
            $advs->setRegions(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Advs[] List of Advs objects
     */
    public function getAdvssJoinAreas($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvsQuery::create(null, $criteria);
        $query->joinWith('Areas', $join_behavior);

        return $this->getAdvss($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
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
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
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
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
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
     * Clears out the collShopss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Regions The current object (for fluent API support)
     * @see        addShopss()
     */
    public function clearShopss()
    {
        $this->collShopss = null; // important to set this to null since that means it is uninitialized
        $this->collShopssPartial = null;

        return $this;
    }

    /**
     * reset is the collShopss collection loaded partially
     *
     * @return void
     */
    public function resetPartialShopss($v = true)
    {
        $this->collShopssPartial = $v;
    }

    /**
     * Initializes the collShopss collection.
     *
     * By default this just sets the collShopss collection to an empty array (like clearcollShopss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initShopss($overrideExisting = true)
    {
        if (null !== $this->collShopss && !$overrideExisting) {
            return;
        }
        $this->collShopss = new PropelObjectCollection();
        $this->collShopss->setModel('Shops');
    }

    /**
     * Gets an array of Shops objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Regions is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Shops[] List of Shops objects
     * @throws PropelException
     */
    public function getShopss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collShopssPartial && !$this->isNew();
        if (null === $this->collShopss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collShopss) {
                // return empty collection
                $this->initShopss();
            } else {
                $collShopss = ShopsQuery::create(null, $criteria)
                    ->filterByRegions($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collShopssPartial && count($collShopss)) {
                      $this->initShopss(false);

                      foreach ($collShopss as $obj) {
                        if (false == $this->collShopss->contains($obj)) {
                          $this->collShopss->append($obj);
                        }
                      }

                      $this->collShopssPartial = true;
                    }

                    $collShopss->getInternalIterator()->rewind();

                    return $collShopss;
                }

                if ($partial && $this->collShopss) {
                    foreach ($this->collShopss as $obj) {
                        if ($obj->isNew()) {
                            $collShopss[] = $obj;
                        }
                    }
                }

                $this->collShopss = $collShopss;
                $this->collShopssPartial = false;
            }
        }

        return $this->collShopss;
    }

    /**
     * Sets a collection of Shops objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $shopss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Regions The current object (for fluent API support)
     */
    public function setShopss(PropelCollection $shopss, PropelPDO $con = null)
    {
        $shopssToDelete = $this->getShopss(new Criteria(), $con)->diff($shopss);


        $this->shopssScheduledForDeletion = $shopssToDelete;

        foreach ($shopssToDelete as $shopsRemoved) {
            $shopsRemoved->setRegions(null);
        }

        $this->collShopss = null;
        foreach ($shopss as $shops) {
            $this->addShops($shops);
        }

        $this->collShopss = $shopss;
        $this->collShopssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Shops objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Shops objects.
     * @throws PropelException
     */
    public function countShopss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collShopssPartial && !$this->isNew();
        if (null === $this->collShopss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collShopss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getShopss());
            }
            $query = ShopsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRegions($this)
                ->count($con);
        }

        return count($this->collShopss);
    }

    /**
     * Method called to associate a Shops object to this object
     * through the Shops foreign key attribute.
     *
     * @param    Shops $l Shops
     * @return Regions The current object (for fluent API support)
     */
    public function addShops(Shops $l)
    {
        if ($this->collShopss === null) {
            $this->initShopss();
            $this->collShopssPartial = true;
        }

        if (!in_array($l, $this->collShopss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddShops($l);

            if ($this->shopssScheduledForDeletion and $this->shopssScheduledForDeletion->contains($l)) {
                $this->shopssScheduledForDeletion->remove($this->shopssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	Shops $shops The shops object to add.
     */
    protected function doAddShops($shops)
    {
        $this->collShopss[]= $shops;
        $shops->setRegions($this);
    }

    /**
     * @param	Shops $shops The shops object to remove.
     * @return Regions The current object (for fluent API support)
     */
    public function removeShops($shops)
    {
        if ($this->getShopss()->contains($shops)) {
            $this->collShopss->remove($this->collShopss->search($shops));
            if (null === $this->shopssScheduledForDeletion) {
                $this->shopssScheduledForDeletion = clone $this->collShopss;
                $this->shopssScheduledForDeletion->clear();
            }
            $this->shopssScheduledForDeletion[]= $shops;
            $shops->setRegions(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Regions is new, it will return
     * an empty collection; or if this Regions has previously
     * been saved, it will retrieve related Shopss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Regions.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Shops[] List of Shops objects
     */
    public function getShopssJoinUser($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ShopsQuery::create(null, $criteria);
        $query->joinWith('User', $join_behavior);

        return $this->getShopss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->area_id = null;
        $this->pagetitle = null;
        $this->net = null;
        $this->alias = null;
        $this->icon = null;
        $this->type = null;
        $this->weather = null;
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
            if ($this->collShopss) {
                foreach ($this->collShopss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAreas instanceof Persistent) {
              $this->aAreas->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAdCategoriesSubscribes instanceof PropelCollection) {
            $this->collAdCategoriesSubscribes->clearIterator();
        }
        $this->collAdCategoriesSubscribes = null;
        if ($this->collAdvss instanceof PropelCollection) {
            $this->collAdvss->clearIterator();
        }
        $this->collAdvss = null;
        if ($this->collShopss instanceof PropelCollection) {
            $this->collShopss->clearIterator();
        }
        $this->collShopss = null;
        $this->aAreas = null;
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
