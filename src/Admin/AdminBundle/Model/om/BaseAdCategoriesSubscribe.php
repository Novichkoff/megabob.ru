<?php

namespace Admin\AdminBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribePeer;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\Areas;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsQuery;

abstract class BaseAdCategoriesSubscribe extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AdCategoriesSubscribePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AdCategoriesSubscribePeer
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
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the unsubscribe_code field.
     * @var        string
     */
    protected $unsubscribe_code;

    /**
     * The value for the last_adv_id field.
     * @var        int
     */
    protected $last_adv_id;

    /**
     * The value for the cnt field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $cnt;

    /**
     * @var        AdCategories
     */
    protected $aAdCategories;

    /**
     * @var        Regions
     */
    protected $aRegions;

    /**
     * @var        Areas
     */
    protected $aAreas;

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
        $this->cnt = 0;
    }

    /**
     * Initializes internal state of BaseAdCategoriesSubscribe object.
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
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * Get the [unsubscribe_code] column value.
     *
     * @return string
     */
    public function getUnsubscribeCode()
    {

        return $this->unsubscribe_code;
    }

    /**
     * Get the [last_adv_id] column value.
     *
     * @return int
     */
    public function getLastAdvId()
    {

        return $this->last_adv_id;
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
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::CATEGORY_ID;
        }

        if ($this->aAdCategories !== null && $this->aAdCategories->getId() !== $v) {
            $this->aAdCategories = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [town_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setTownId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->town_id !== $v) {
            $this->town_id = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::TOWN_ID;
        }

        if ($this->aRegions !== null && $this->aRegions->getId() !== $v) {
            $this->aRegions = null;
        }


        return $this;
    } // setTownId()

    /**
     * Set the value of [area_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setAreaId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->area_id !== $v) {
            $this->area_id = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::AREA_ID;
        }

        if ($this->aAreas !== null && $this->aAreas->getId() !== $v) {
            $this->aAreas = null;
        }


        return $this;
    } // setAreaId()

    /**
     * Set the value of [email] column.
     *
     * @param  string $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [unsubscribe_code] column.
     *
     * @param  string $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setUnsubscribeCode($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->unsubscribe_code !== $v) {
            $this->unsubscribe_code = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE;
        }


        return $this;
    } // setUnsubscribeCode()

    /**
     * Set the value of [last_adv_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setLastAdvId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->last_adv_id !== $v) {
            $this->last_adv_id = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::LAST_ADV_ID;
        }


        return $this;
    } // setLastAdvId()

    /**
     * Set the value of [cnt] column.
     *
     * @param  int $v new value
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     */
    public function setCnt($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cnt !== $v) {
            $this->cnt = $v;
            $this->modifiedColumns[] = AdCategoriesSubscribePeer::CNT;
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
            $this->town_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->area_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->email = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->unsubscribe_code = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->last_adv_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->cnt = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 8; // 8 = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AdCategoriesSubscribe object", $e);
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

        if ($this->aAdCategories !== null && $this->category_id !== $this->aAdCategories->getId()) {
            $this->aAdCategories = null;
        }
        if ($this->aRegions !== null && $this->town_id !== $this->aRegions->getId()) {
            $this->aRegions = null;
        }
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
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AdCategoriesSubscribePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdCategories = null;
            $this->aRegions = null;
            $this->aAreas = null;
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
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AdCategoriesSubscribeQuery::create()
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
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AdCategoriesSubscribePeer::addInstanceToPool($this);
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

            if ($this->aAdCategories !== null) {
                if ($this->aAdCategories->isModified() || $this->aAdCategories->isNew()) {
                    $affectedRows += $this->aAdCategories->save($con);
                }
                $this->setAdCategories($this->aAdCategories);
            }

            if ($this->aRegions !== null) {
                if ($this->aRegions->isModified() || $this->aRegions->isNew()) {
                    $affectedRows += $this->aRegions->save($con);
                }
                $this->setRegions($this->aRegions);
            }

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

        $this->modifiedColumns[] = AdCategoriesSubscribePeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdCategoriesSubscribePeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdCategoriesSubscribePeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::TOWN_ID)) {
            $modifiedColumns[':p' . $index++]  = '`town_id`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::AREA_ID)) {
            $modifiedColumns[':p' . $index++]  = '`area_id`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE)) {
            $modifiedColumns[':p' . $index++]  = '`unsubscribe_code`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::LAST_ADV_ID)) {
            $modifiedColumns[':p' . $index++]  = '`last_adv_id`';
        }
        if ($this->isColumnModified(AdCategoriesSubscribePeer::CNT)) {
            $modifiedColumns[':p' . $index++]  = '`cnt`';
        }

        $sql = sprintf(
            'INSERT INTO `ad_categories_subscribe` (%s) VALUES (%s)',
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
                    case '`town_id`':
                        $stmt->bindValue($identifier, $this->town_id, PDO::PARAM_INT);
                        break;
                    case '`area_id`':
                        $stmt->bindValue($identifier, $this->area_id, PDO::PARAM_INT);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`unsubscribe_code`':
                        $stmt->bindValue($identifier, $this->unsubscribe_code, PDO::PARAM_STR);
                        break;
                    case '`last_adv_id`':
                        $stmt->bindValue($identifier, $this->last_adv_id, PDO::PARAM_INT);
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

            if ($this->aAdCategories !== null) {
                if (!$this->aAdCategories->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategories->getValidationFailures());
                }
            }

            if ($this->aRegions !== null) {
                if (!$this->aRegions->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aRegions->getValidationFailures());
                }
            }

            if ($this->aAreas !== null) {
                if (!$this->aAreas->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAreas->getValidationFailures());
                }
            }


            if (($retval = AdCategoriesSubscribePeer::doValidate($this, $columns)) !== true) {
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
        $pos = AdCategoriesSubscribePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getTownId();
                break;
            case 3:
                return $this->getAreaId();
                break;
            case 4:
                return $this->getEmail();
                break;
            case 5:
                return $this->getUnsubscribeCode();
                break;
            case 6:
                return $this->getLastAdvId();
                break;
            case 7:
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
        if (isset($alreadyDumpedObjects['AdCategoriesSubscribe'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdCategoriesSubscribe'][$this->getPrimaryKey()] = true;
        $keys = AdCategoriesSubscribePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getTownId(),
            $keys[3] => $this->getAreaId(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getUnsubscribeCode(),
            $keys[6] => $this->getLastAdvId(),
            $keys[7] => $this->getCnt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdCategories) {
                $result['AdCategories'] = $this->aAdCategories->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aRegions) {
                $result['Regions'] = $this->aRegions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAreas) {
                $result['Areas'] = $this->aAreas->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = AdCategoriesSubscribePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setTownId($value);
                break;
            case 3:
                $this->setAreaId($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setUnsubscribeCode($value);
                break;
            case 6:
                $this->setLastAdvId($value);
                break;
            case 7:
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
        $keys = AdCategoriesSubscribePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTownId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAreaId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setEmail($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUnsubscribeCode($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setLastAdvId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setCnt($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($this->isColumnModified(AdCategoriesSubscribePeer::ID)) $criteria->add(AdCategoriesSubscribePeer::ID, $this->id);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::CATEGORY_ID)) $criteria->add(AdCategoriesSubscribePeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::TOWN_ID)) $criteria->add(AdCategoriesSubscribePeer::TOWN_ID, $this->town_id);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::AREA_ID)) $criteria->add(AdCategoriesSubscribePeer::AREA_ID, $this->area_id);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::EMAIL)) $criteria->add(AdCategoriesSubscribePeer::EMAIL, $this->email);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE)) $criteria->add(AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE, $this->unsubscribe_code);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::LAST_ADV_ID)) $criteria->add(AdCategoriesSubscribePeer::LAST_ADV_ID, $this->last_adv_id);
        if ($this->isColumnModified(AdCategoriesSubscribePeer::CNT)) $criteria->add(AdCategoriesSubscribePeer::CNT, $this->cnt);

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
        $criteria = new Criteria(AdCategoriesSubscribePeer::DATABASE_NAME);
        $criteria->add(AdCategoriesSubscribePeer::ID, $this->id);

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
     * @param object $copyObj An object of AdCategoriesSubscribe (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setTownId($this->getTownId());
        $copyObj->setAreaId($this->getAreaId());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setUnsubscribeCode($this->getUnsubscribeCode());
        $copyObj->setLastAdvId($this->getLastAdvId());
        $copyObj->setCnt($this->getCnt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return AdCategoriesSubscribe Clone of current object.
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
     * @return AdCategoriesSubscribePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AdCategoriesSubscribePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AdCategories object.
     *
     * @param                  AdCategories $v
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdCategories(AdCategories $v = null)
    {
        if ($v === null) {
            $this->setCategoryId(NULL);
        } else {
            $this->setCategoryId($v->getId());
        }

        $this->aAdCategories = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AdCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addAdCategoriesSubscribe($this);
        }


        return $this;
    }


    /**
     * Get the associated AdCategories object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return AdCategories The associated AdCategories object.
     * @throws PropelException
     */
    public function getAdCategories(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdCategories === null && ($this->category_id !== null) && $doQuery) {
            $this->aAdCategories = AdCategoriesQuery::create()->findPk($this->category_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdCategories->addAdCategoriesSubscribes($this);
             */
        }

        return $this->aAdCategories;
    }

    /**
     * Declares an association between this object and a Regions object.
     *
     * @param                  Regions $v
     * @return AdCategoriesSubscribe The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRegions(Regions $v = null)
    {
        if ($v === null) {
            $this->setTownId(NULL);
        } else {
            $this->setTownId($v->getId());
        }

        $this->aRegions = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Regions object, it will not be re-added.
        if ($v !== null) {
            $v->addAdCategoriesSubscribe($this);
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
        if ($this->aRegions === null && ($this->town_id !== null) && $doQuery) {
            $this->aRegions = RegionsQuery::create()->findPk($this->town_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRegions->addAdCategoriesSubscribes($this);
             */
        }

        return $this->aRegions;
    }

    /**
     * Declares an association between this object and a Areas object.
     *
     * @param                  Areas $v
     * @return AdCategoriesSubscribe The current object (for fluent API support)
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
            $v->addAdCategoriesSubscribe($this);
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
                $this->aAreas->addAdCategoriesSubscribes($this);
             */
        }

        return $this->aAreas;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->town_id = null;
        $this->area_id = null;
        $this->email = null;
        $this->unsubscribe_code = null;
        $this->last_adv_id = null;
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
            if ($this->aAdCategories instanceof Persistent) {
              $this->aAdCategories->clearAllReferences($deep);
            }
            if ($this->aRegions instanceof Persistent) {
              $this->aRegions->clearAllReferences($deep);
            }
            if ($this->aAreas instanceof Persistent) {
              $this->aAreas->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aAdCategories = null;
        $this->aRegions = null;
        $this->aAreas = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AdCategoriesSubscribePeer::DEFAULT_STRING_FORMAT);
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
