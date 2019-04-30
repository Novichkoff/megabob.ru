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
use Admin\AdminBundle\Model\AdCategoriesFields;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesPeer;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsQuery;

abstract class BaseAdCategoriesFieldsValues extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AdCategoriesFieldsValuesPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AdCategoriesFieldsValuesPeer
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
     * The value for the field_id field.
     * @var        int
     */
    protected $field_id;

    /**
     * The value for the town_id field.
     * @var        int
     */
    protected $town_id;

    /**
     * The value for the area_id field.
     * @var        int
     */
    protected $area_id;

    /**
     * The value for the sort field.
     * @var        int
     */
    protected $sort;

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
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the color field.
     * @var        string
     */
    protected $color;

    /**
     * The value for the icon field.
     * @var        string
     */
    protected $icon;

    /**
     * The value for the parent_field_id field.
     * @var        int
     */
    protected $parent_field_id;

    /**
     * The value for the parent_value_id field.
     * @var        int
     */
    protected $parent_value_id;

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
     * @var        AdCategoriesFields
     */
    protected $aAdCategoriesFields;

    /**
     * @var        PropelObjectCollection|AdvParams[] Collection to store aggregation of AdvParams objects.
     */
    protected $collAdvParamss;
    protected $collAdvParamssPartial;

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
    protected $advParamssScheduledForDeletion = null;

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
    }

    /**
     * Initializes internal state of BaseAdCategoriesFieldsValues object.
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
     * Get the [field_id] column value.
     *
     * @return int
     */
    public function getFieldId()
    {

        return $this->field_id;
    }

    /**
     * Get the [town_id] column value.
     *
     * @return int
     */
    public function getTownId()
    {

        return $this->town_id;
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
     * Get the [sort] column value.
     *
     * @return int
     */
    public function getSort()
    {

        return $this->sort;
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
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {

        return $this->title;
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
     * Get the [color] column value.
     *
     * @return string
     */
    public function getColor()
    {

        return $this->color;
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
     * Get the [parent_field_id] column value.
     *
     * @return int
     */
    public function getParentFieldId()
    {

        return $this->parent_field_id;
    }

    /**
     * Get the [parent_value_id] column value.
     *
     * @return int
     */
    public function getParentValueId()
    {

        return $this->parent_value_id;
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
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [field_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setFieldId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->field_id !== $v) {
            $this->field_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::FIELD_ID;
        }

        if ($this->aAdCategoriesFields !== null && $this->aAdCategoriesFields->getId() !== $v) {
            $this->aAdCategoriesFields = null;
        }


        return $this;
    } // setFieldId()

    /**
     * Set the value of [town_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setTownId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->town_id !== $v) {
            $this->town_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::TOWN_ID;
        }


        return $this;
    } // setTownId()

    /**
     * Set the value of [area_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setAreaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->area_id !== $v) {
            $this->area_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::AREA_ID;
        }


        return $this;
    } // setAreaId()

    /**
     * Set the value of [sort] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::SORT;
        }


        return $this;
    } // setSort()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [title] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [color] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setColor($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->color !== $v) {
            $this->color = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::COLOR;
        }


        return $this;
    } // setColor()

    /**
     * Set the value of [icon] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::ICON;
        }


        return $this;
    } // setIcon()

    /**
     * Set the value of [parent_field_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setParentFieldId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_field_id !== $v) {
            $this->parent_field_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID;
        }


        return $this;
    } // setParentFieldId()

    /**
     * Set the value of [parent_value_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setParentValueId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_value_id !== $v) {
            $this->parent_value_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID;
        }


        return $this;
    } // setParentValueId()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::ENABLED;
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
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::DELETED;
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
            $this->field_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->town_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->area_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->sort = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->alias = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->title = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->description = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->color = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->icon = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->parent_field_id = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->parent_value_id = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->enabled = ($row[$startcol + 13] !== null) ? (boolean) $row[$startcol + 13] : null;
            $this->deleted = ($row[$startcol + 14] !== null) ? (boolean) $row[$startcol + 14] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 15; // 15 = AdCategoriesFieldsValuesPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AdCategoriesFieldsValues object", $e);
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

        if ($this->aAdCategoriesFields !== null && $this->field_id !== $this->aAdCategoriesFields->getId()) {
            $this->aAdCategoriesFields = null;
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
            $con = Propel::getConnection(AdCategoriesFieldsValuesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AdCategoriesFieldsValuesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdCategoriesFields = null;
            $this->collAdvParamss = null;

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
            $con = Propel::getConnection(AdCategoriesFieldsValuesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AdCategoriesFieldsValuesQuery::create()
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
            $con = Propel::getConnection(AdCategoriesFieldsValuesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AdCategoriesFieldsValuesPeer::addInstanceToPool($this);
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

            if ($this->aAdCategoriesFields !== null) {
                if ($this->aAdCategoriesFields->isModified() || $this->aAdCategoriesFields->isNew()) {
                    $affectedRows += $this->aAdCategoriesFields->save($con);
                }
                $this->setAdCategoriesFields($this->aAdCategoriesFields);
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

        $this->modifiedColumns[] = AdCategoriesFieldsValuesPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdCategoriesFieldsValuesPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::FIELD_ID)) {
            $modifiedColumns[':p' . $index++]  = '`field_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::TOWN_ID)) {
            $modifiedColumns[':p' . $index++]  = '`town_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::AREA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`area_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::SORT)) {
            $modifiedColumns[':p' . $index++]  = '`sort`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::COLOR)) {
            $modifiedColumns[':p' . $index++]  = '`color`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_field_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_value_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }

        $sql = sprintf(
            'INSERT INTO `ad_categories_fields_values` (%s) VALUES (%s)',
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
                    case '`field_id`':
                        $stmt->bindValue($identifier, $this->field_id, PDO::PARAM_INT);
                        break;
                    case '`town_id`':
                        $stmt->bindValue($identifier, $this->town_id, PDO::PARAM_INT);
                        break;
                    case '`area_id`':
                        $stmt->bindValue($identifier, $this->area_id, PDO::PARAM_INT);
                        break;
                    case '`sort`':
                        $stmt->bindValue($identifier, $this->sort, PDO::PARAM_INT);
                        break;
                    case '`name`':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '`alias`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`color`':
                        $stmt->bindValue($identifier, $this->color, PDO::PARAM_STR);
                        break;
                    case '`icon`':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
                        break;
                    case '`parent_field_id`':
                        $stmt->bindValue($identifier, $this->parent_field_id, PDO::PARAM_INT);
                        break;
                    case '`parent_value_id`':
                        $stmt->bindValue($identifier, $this->parent_value_id, PDO::PARAM_INT);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
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

            if ($this->aAdCategoriesFields !== null) {
                if (!$this->aAdCategoriesFields->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategoriesFields->getValidationFailures());
                }
            }


            if (($retval = AdCategoriesFieldsValuesPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAdvParamss !== null) {
                    foreach ($this->collAdvParamss as $referrerFK) {
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
        $pos = AdCategoriesFieldsValuesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFieldId();
                break;
            case 2:
                return $this->getTownId();
                break;
            case 3:
                return $this->getAreaId();
                break;
            case 4:
                return $this->getSort();
                break;
            case 5:
                return $this->getName();
                break;
            case 6:
                return $this->getAlias();
                break;
            case 7:
                return $this->getTitle();
                break;
            case 8:
                return $this->getDescription();
                break;
            case 9:
                return $this->getColor();
                break;
            case 10:
                return $this->getIcon();
                break;
            case 11:
                return $this->getParentFieldId();
                break;
            case 12:
                return $this->getParentValueId();
                break;
            case 13:
                return $this->getEnabled();
                break;
            case 14:
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
        if (isset($alreadyDumpedObjects['AdCategoriesFieldsValues'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdCategoriesFieldsValues'][$this->getPrimaryKey()] = true;
        $keys = AdCategoriesFieldsValuesPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getFieldId(),
            $keys[2] => $this->getTownId(),
            $keys[3] => $this->getAreaId(),
            $keys[4] => $this->getSort(),
            $keys[5] => $this->getName(),
            $keys[6] => $this->getAlias(),
            $keys[7] => $this->getTitle(),
            $keys[8] => $this->getDescription(),
            $keys[9] => $this->getColor(),
            $keys[10] => $this->getIcon(),
            $keys[11] => $this->getParentFieldId(),
            $keys[12] => $this->getParentValueId(),
            $keys[13] => $this->getEnabled(),
            $keys[14] => $this->getDeleted(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdCategoriesFields) {
                $result['AdCategoriesFields'] = $this->aAdCategoriesFields->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAdvParamss) {
                $result['AdvParamss'] = $this->collAdvParamss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AdCategoriesFieldsValuesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFieldId($value);
                break;
            case 2:
                $this->setTownId($value);
                break;
            case 3:
                $this->setAreaId($value);
                break;
            case 4:
                $this->setSort($value);
                break;
            case 5:
                $this->setName($value);
                break;
            case 6:
                $this->setAlias($value);
                break;
            case 7:
                $this->setTitle($value);
                break;
            case 8:
                $this->setDescription($value);
                break;
            case 9:
                $this->setColor($value);
                break;
            case 10:
                $this->setIcon($value);
                break;
            case 11:
                $this->setParentFieldId($value);
                break;
            case 12:
                $this->setParentValueId($value);
                break;
            case 13:
                $this->setEnabled($value);
                break;
            case 14:
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
        $keys = AdCategoriesFieldsValuesPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFieldId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTownId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAreaId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setSort($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setName($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setAlias($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setTitle($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDescription($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setColor($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIcon($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setParentFieldId($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setParentValueId($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setEnabled($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setDeleted($arr[$keys[14]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AdCategoriesFieldsValuesPeer::DATABASE_NAME);

        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ID)) $criteria->add(AdCategoriesFieldsValuesPeer::ID, $this->id);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::FIELD_ID)) $criteria->add(AdCategoriesFieldsValuesPeer::FIELD_ID, $this->field_id);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::TOWN_ID)) $criteria->add(AdCategoriesFieldsValuesPeer::TOWN_ID, $this->town_id);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::AREA_ID)) $criteria->add(AdCategoriesFieldsValuesPeer::AREA_ID, $this->area_id);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::SORT)) $criteria->add(AdCategoriesFieldsValuesPeer::SORT, $this->sort);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::NAME)) $criteria->add(AdCategoriesFieldsValuesPeer::NAME, $this->name);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ALIAS)) $criteria->add(AdCategoriesFieldsValuesPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::TITLE)) $criteria->add(AdCategoriesFieldsValuesPeer::TITLE, $this->title);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::DESCRIPTION)) $criteria->add(AdCategoriesFieldsValuesPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::COLOR)) $criteria->add(AdCategoriesFieldsValuesPeer::COLOR, $this->color);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ICON)) $criteria->add(AdCategoriesFieldsValuesPeer::ICON, $this->icon);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID)) $criteria->add(AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID, $this->parent_field_id);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID)) $criteria->add(AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $this->parent_value_id);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::ENABLED)) $criteria->add(AdCategoriesFieldsValuesPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(AdCategoriesFieldsValuesPeer::DELETED)) $criteria->add(AdCategoriesFieldsValuesPeer::DELETED, $this->deleted);

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
        $criteria = new Criteria(AdCategoriesFieldsValuesPeer::DATABASE_NAME);
        $criteria->add(AdCategoriesFieldsValuesPeer::ID, $this->id);

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
     * @param object $copyObj An object of AdCategoriesFieldsValues (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFieldId($this->getFieldId());
        $copyObj->setTownId($this->getTownId());
        $copyObj->setAreaId($this->getAreaId());
        $copyObj->setSort($this->getSort());
        $copyObj->setName($this->getName());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setColor($this->getColor());
        $copyObj->setIcon($this->getIcon());
        $copyObj->setParentFieldId($this->getParentFieldId());
        $copyObj->setParentValueId($this->getParentValueId());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setDeleted($this->getDeleted());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAdvParamss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdvParams($relObj->copy($deepCopy));
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
     * @return AdCategoriesFieldsValues Clone of current object.
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
     * @return AdCategoriesFieldsValuesPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AdCategoriesFieldsValuesPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AdCategoriesFields object.
     *
     * @param                  AdCategoriesFields $v
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdCategoriesFields(AdCategoriesFields $v = null)
    {
        if ($v === null) {
            $this->setFieldId(NULL);
        } else {
            $this->setFieldId($v->getId());
        }

        $this->aAdCategoriesFields = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AdCategoriesFields object, it will not be re-added.
        if ($v !== null) {
            $v->addAdCategoriesFieldsValues($this);
        }


        return $this;
    }


    /**
     * Get the associated AdCategoriesFields object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return AdCategoriesFields The associated AdCategoriesFields object.
     * @throws PropelException
     */
    public function getAdCategoriesFields(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdCategoriesFields === null && ($this->field_id !== null) && $doQuery) {
            $this->aAdCategoriesFields = AdCategoriesFieldsQuery::create()->findPk($this->field_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdCategoriesFields->addAdCategoriesFieldsValuess($this);
             */
        }

        return $this->aAdCategoriesFields;
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
        if ('AdvParams' == $relationName) {
            $this->initAdvParamss();
        }
    }

    /**
     * Clears out the collAdvParamss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
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
     * If this AdCategoriesFieldsValues is new, it will return
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
                    ->filterByAdCategoriesFieldsValues($this)
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
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function setAdvParamss(PropelCollection $advParamss, PropelPDO $con = null)
    {
        $advParamssToDelete = $this->getAdvParamss(new Criteria(), $con)->diff($advParamss);


        $this->advParamssScheduledForDeletion = $advParamssToDelete;

        foreach ($advParamssToDelete as $advParamsRemoved) {
            $advParamsRemoved->setAdCategoriesFieldsValues(null);
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
                ->filterByAdCategoriesFieldsValues($this)
                ->count($con);
        }

        return count($this->collAdvParamss);
    }

    /**
     * Method called to associate a AdvParams object to this object
     * through the AdvParams foreign key attribute.
     *
     * @param    AdvParams $l AdvParams
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
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
        $advParams->setAdCategoriesFieldsValues($this);
    }

    /**
     * @param	AdvParams $advParams The advParams object to remove.
     * @return AdCategoriesFieldsValues The current object (for fluent API support)
     */
    public function removeAdvParams($advParams)
    {
        if ($this->getAdvParamss()->contains($advParams)) {
            $this->collAdvParamss->remove($this->collAdvParamss->search($advParams));
            if (null === $this->advParamssScheduledForDeletion) {
                $this->advParamssScheduledForDeletion = clone $this->collAdvParamss;
                $this->advParamssScheduledForDeletion->clear();
            }
            $this->advParamssScheduledForDeletion[]= $advParams;
            $advParams->setAdCategoriesFieldsValues(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategoriesFieldsValues is new, it will return
     * an empty collection; or if this AdCategoriesFieldsValues has previously
     * been saved, it will retrieve related AdvParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategoriesFieldsValues.
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
     * Otherwise if this AdCategoriesFieldsValues is new, it will return
     * an empty collection; or if this AdCategoriesFieldsValues has previously
     * been saved, it will retrieve related AdvParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategoriesFieldsValues.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvParams[] List of AdvParams objects
     */
    public function getAdvParamssJoinAdvs($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvParamsQuery::create(null, $criteria);
        $query->joinWith('Advs', $join_behavior);

        return $this->getAdvParamss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->field_id = null;
        $this->town_id = null;
        $this->area_id = null;
        $this->sort = null;
        $this->name = null;
        $this->alias = null;
        $this->title = null;
        $this->description = null;
        $this->color = null;
        $this->icon = null;
        $this->parent_field_id = null;
        $this->parent_value_id = null;
        $this->enabled = null;
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
            if ($this->collAdvParamss) {
                foreach ($this->collAdvParamss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAdCategoriesFields instanceof Persistent) {
              $this->aAdCategoriesFields->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAdvParamss instanceof PropelCollection) {
            $this->collAdvParamss->clearIterator();
        }
        $this->collAdvParamss = null;
        $this->aAdCategoriesFields = null;
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
