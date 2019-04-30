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
use Admin\AdminBundle\Model\AdCategoriesFields;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsPeer;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsQuery;

abstract class BaseAdvParams extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AdvParamsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AdvParamsPeer
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
     * The value for the adv_id field.
     * @var        int
     */
    protected $adv_id;

    /**
     * The value for the field_id field.
     * @var        int
     */
    protected $field_id;

    /**
     * The value for the value_id field.
     * @var        int
     */
    protected $value_id;

    /**
     * The value for the text_value field.
     * @var        string
     */
    protected $text_value;

    /**
     * @var        AdCategoriesFields
     */
    protected $aAdCategoriesFields;

    /**
     * @var        Advs
     */
    protected $aAdvs;

    /**
     * @var        AdCategoriesFieldsValues
     */
    protected $aAdCategoriesFieldsValues;

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
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [adv_id] column value.
     *
     * @return int
     */
    public function getAdvId()
    {

        return $this->adv_id;
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
     * Get the [value_id] column value.
     *
     * @return int
     */
    public function getValueId()
    {

        return $this->value_id;
    }

    /**
     * Get the [text_value] column value.
     *
     * @return string
     */
    public function getTextValue()
    {

        return $this->text_value;
    }

    /**
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return AdvParams The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AdvParamsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [adv_id] column.
     *
     * @param  int $v new value
     * @return AdvParams The current object (for fluent API support)
     */
    public function setAdvId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->adv_id !== $v) {
            $this->adv_id = $v;
            $this->modifiedColumns[] = AdvParamsPeer::ADV_ID;
        }

        if ($this->aAdvs !== null && $this->aAdvs->getId() !== $v) {
            $this->aAdvs = null;
        }


        return $this;
    } // setAdvId()

    /**
     * Set the value of [field_id] column.
     *
     * @param  int $v new value
     * @return AdvParams The current object (for fluent API support)
     */
    public function setFieldId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->field_id !== $v) {
            $this->field_id = $v;
            $this->modifiedColumns[] = AdvParamsPeer::FIELD_ID;
        }

        if ($this->aAdCategoriesFields !== null && $this->aAdCategoriesFields->getId() !== $v) {
            $this->aAdCategoriesFields = null;
        }


        return $this;
    } // setFieldId()

    /**
     * Set the value of [value_id] column.
     *
     * @param  int $v new value
     * @return AdvParams The current object (for fluent API support)
     */
    public function setValueId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->value_id !== $v) {
            $this->value_id = $v;
            $this->modifiedColumns[] = AdvParamsPeer::VALUE_ID;
        }

        if ($this->aAdCategoriesFieldsValues !== null && $this->aAdCategoriesFieldsValues->getId() !== $v) {
            $this->aAdCategoriesFieldsValues = null;
        }


        return $this;
    } // setValueId()

    /**
     * Set the value of [text_value] column.
     *
     * @param  string $v new value
     * @return AdvParams The current object (for fluent API support)
     */
    public function setTextValue($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text_value !== $v) {
            $this->text_value = $v;
            $this->modifiedColumns[] = AdvParamsPeer::TEXT_VALUE;
        }


        return $this;
    } // setTextValue()

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
            $this->adv_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->field_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->value_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->text_value = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 5; // 5 = AdvParamsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AdvParams object", $e);
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

        if ($this->aAdvs !== null && $this->adv_id !== $this->aAdvs->getId()) {
            $this->aAdvs = null;
        }
        if ($this->aAdCategoriesFields !== null && $this->field_id !== $this->aAdCategoriesFields->getId()) {
            $this->aAdCategoriesFields = null;
        }
        if ($this->aAdCategoriesFieldsValues !== null && $this->value_id !== $this->aAdCategoriesFieldsValues->getId()) {
            $this->aAdCategoriesFieldsValues = null;
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
            $con = Propel::getConnection(AdvParamsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AdvParamsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdCategoriesFields = null;
            $this->aAdvs = null;
            $this->aAdCategoriesFieldsValues = null;
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
            $con = Propel::getConnection(AdvParamsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AdvParamsQuery::create()
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
            $con = Propel::getConnection(AdvParamsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AdvParamsPeer::addInstanceToPool($this);
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

            if ($this->aAdvs !== null) {
                if ($this->aAdvs->isModified() || $this->aAdvs->isNew()) {
                    $affectedRows += $this->aAdvs->save($con);
                }
                $this->setAdvs($this->aAdvs);
            }

            if ($this->aAdCategoriesFieldsValues !== null) {
                if ($this->aAdCategoriesFieldsValues->isModified() || $this->aAdCategoriesFieldsValues->isNew()) {
                    $affectedRows += $this->aAdCategoriesFieldsValues->save($con);
                }
                $this->setAdCategoriesFieldsValues($this->aAdCategoriesFieldsValues);
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

        $this->modifiedColumns[] = AdvParamsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdvParamsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdvParamsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdvParamsPeer::ADV_ID)) {
            $modifiedColumns[':p' . $index++]  = '`adv_id`';
        }
        if ($this->isColumnModified(AdvParamsPeer::FIELD_ID)) {
            $modifiedColumns[':p' . $index++]  = '`field_id`';
        }
        if ($this->isColumnModified(AdvParamsPeer::VALUE_ID)) {
            $modifiedColumns[':p' . $index++]  = '`value_id`';
        }
        if ($this->isColumnModified(AdvParamsPeer::TEXT_VALUE)) {
            $modifiedColumns[':p' . $index++]  = '`text_value`';
        }

        $sql = sprintf(
            'INSERT INTO `adv_params` (%s) VALUES (%s)',
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
                    case '`adv_id`':
                        $stmt->bindValue($identifier, $this->adv_id, PDO::PARAM_INT);
                        break;
                    case '`field_id`':
                        $stmt->bindValue($identifier, $this->field_id, PDO::PARAM_INT);
                        break;
                    case '`value_id`':
                        $stmt->bindValue($identifier, $this->value_id, PDO::PARAM_INT);
                        break;
                    case '`text_value`':
                        $stmt->bindValue($identifier, $this->text_value, PDO::PARAM_STR);
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

            if ($this->aAdvs !== null) {
                if (!$this->aAdvs->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdvs->getValidationFailures());
                }
            }

            if ($this->aAdCategoriesFieldsValues !== null) {
                if (!$this->aAdCategoriesFieldsValues->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategoriesFieldsValues->getValidationFailures());
                }
            }


            if (($retval = AdvParamsPeer::doValidate($this, $columns)) !== true) {
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
        $pos = AdvParamsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAdvId();
                break;
            case 2:
                return $this->getFieldId();
                break;
            case 3:
                return $this->getValueId();
                break;
            case 4:
                return $this->getTextValue();
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
        if (isset($alreadyDumpedObjects['AdvParams'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdvParams'][$this->getPrimaryKey()] = true;
        $keys = AdvParamsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getAdvId(),
            $keys[2] => $this->getFieldId(),
            $keys[3] => $this->getValueId(),
            $keys[4] => $this->getTextValue(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdCategoriesFields) {
                $result['AdCategoriesFields'] = $this->aAdCategoriesFields->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAdvs) {
                $result['Advs'] = $this->aAdvs->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAdCategoriesFieldsValues) {
                $result['AdCategoriesFieldsValues'] = $this->aAdCategoriesFieldsValues->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = AdvParamsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAdvId($value);
                break;
            case 2:
                $this->setFieldId($value);
                break;
            case 3:
                $this->setValueId($value);
                break;
            case 4:
                $this->setTextValue($value);
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
        $keys = AdvParamsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAdvId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFieldId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setValueId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setTextValue($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AdvParamsPeer::DATABASE_NAME);

        if ($this->isColumnModified(AdvParamsPeer::ID)) $criteria->add(AdvParamsPeer::ID, $this->id);
        if ($this->isColumnModified(AdvParamsPeer::ADV_ID)) $criteria->add(AdvParamsPeer::ADV_ID, $this->adv_id);
        if ($this->isColumnModified(AdvParamsPeer::FIELD_ID)) $criteria->add(AdvParamsPeer::FIELD_ID, $this->field_id);
        if ($this->isColumnModified(AdvParamsPeer::VALUE_ID)) $criteria->add(AdvParamsPeer::VALUE_ID, $this->value_id);
        if ($this->isColumnModified(AdvParamsPeer::TEXT_VALUE)) $criteria->add(AdvParamsPeer::TEXT_VALUE, $this->text_value);

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
        $criteria = new Criteria(AdvParamsPeer::DATABASE_NAME);
        $criteria->add(AdvParamsPeer::ID, $this->id);

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
     * @param object $copyObj An object of AdvParams (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAdvId($this->getAdvId());
        $copyObj->setFieldId($this->getFieldId());
        $copyObj->setValueId($this->getValueId());
        $copyObj->setTextValue($this->getTextValue());

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
     * @return AdvParams Clone of current object.
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
     * @return AdvParamsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AdvParamsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AdCategoriesFields object.
     *
     * @param                  AdCategoriesFields $v
     * @return AdvParams The current object (for fluent API support)
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
            $v->addAdvParams($this);
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
                $this->aAdCategoriesFields->addAdvParamss($this);
             */
        }

        return $this->aAdCategoriesFields;
    }

    /**
     * Declares an association between this object and a Advs object.
     *
     * @param                  Advs $v
     * @return AdvParams The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdvs(Advs $v = null)
    {
        if ($v === null) {
            $this->setAdvId(NULL);
        } else {
            $this->setAdvId($v->getId());
        }

        $this->aAdvs = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Advs object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvParams($this);
        }


        return $this;
    }


    /**
     * Get the associated Advs object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Advs The associated Advs object.
     * @throws PropelException
     */
    public function getAdvs(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdvs === null && ($this->adv_id !== null) && $doQuery) {
            $this->aAdvs = AdvsQuery::create()->findPk($this->adv_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdvs->addAdvParamss($this);
             */
        }

        return $this->aAdvs;
    }

    /**
     * Declares an association between this object and a AdCategoriesFieldsValues object.
     *
     * @param                  AdCategoriesFieldsValues $v
     * @return AdvParams The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdCategoriesFieldsValues(AdCategoriesFieldsValues $v = null)
    {
        if ($v === null) {
            $this->setValueId(NULL);
        } else {
            $this->setValueId($v->getId());
        }

        $this->aAdCategoriesFieldsValues = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AdCategoriesFieldsValues object, it will not be re-added.
        if ($v !== null) {
            $v->addAdvParams($this);
        }


        return $this;
    }


    /**
     * Get the associated AdCategoriesFieldsValues object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return AdCategoriesFieldsValues The associated AdCategoriesFieldsValues object.
     * @throws PropelException
     */
    public function getAdCategoriesFieldsValues(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdCategoriesFieldsValues === null && ($this->value_id !== null) && $doQuery) {
            $this->aAdCategoriesFieldsValues = AdCategoriesFieldsValuesQuery::create()->findPk($this->value_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdCategoriesFieldsValues->addAdvParamss($this);
             */
        }

        return $this->aAdCategoriesFieldsValues;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->adv_id = null;
        $this->field_id = null;
        $this->value_id = null;
        $this->text_value = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
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
            if ($this->aAdCategoriesFields instanceof Persistent) {
              $this->aAdCategoriesFields->clearAllReferences($deep);
            }
            if ($this->aAdvs instanceof Persistent) {
              $this->aAdvs->clearAllReferences($deep);
            }
            if ($this->aAdCategoriesFieldsValues instanceof Persistent) {
              $this->aAdCategoriesFieldsValues->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aAdCategoriesFields = null;
        $this->aAdvs = null;
        $this->aAdCategoriesFieldsValues = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AdvParamsPeer::DEFAULT_STRING_FORMAT);
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
