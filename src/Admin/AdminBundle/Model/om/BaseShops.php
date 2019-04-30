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
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\Shops;
use Admin\AdminBundle\Model\ShopsPeer;
use Admin\AdminBundle\Model\ShopsQuery;
use FOS\UserBundle\Propel\User;
use FOS\UserBundle\Propel\UserQuery;

abstract class BaseShops extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\ShopsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ShopsPeer
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
     * The value for the enabled field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $enabled;

    /**
     * The value for the fos_user_id field.
     * @var        int
     */
    protected $fos_user_id;

    /**
     * The value for the address field.
     * @var        string
     */
    protected $address;

    /**
     * The value for the phone field.
     * @var        string
     */
    protected $phone;

    /**
     * The value for the site field.
     * @var        string
     */
    protected $site;

    /**
     * The value for the region_id field.
     * @var        int
     */
    protected $region_id;

    /**
     * @var        Regions
     */
    protected $aRegions;

    /**
     * @var        User
     */
    protected $aUser;

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
    protected $advssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->enabled = false;
    }

    /**
     * Initializes internal state of BaseShops object.
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
     * Get the [enabled] column value.
     *
     * @return boolean
     */
    public function getEnabled()
    {

        return $this->enabled;
    }

    /**
     * Get the [fos_user_id] column value.
     *
     * @return int
     */
    public function getFosUserId()
    {

        return $this->fos_user_id;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {

        return $this->address;
    }

    /**
     * Get the [phone] column value.
     *
     * @return string
     */
    public function getPhone()
    {

        return $this->phone;
    }

    /**
     * Get the [site] column value.
     *
     * @return string
     */
    public function getSite()
    {

        return $this->site;
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
     * Set the value of [id] column.
     *
     * @param  int $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = ShopsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ShopsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = ShopsPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [icon] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[] = ShopsPeer::ICON;
        }


        return $this;
    } // setIcon()

    /**
     * Set the value of [title] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = ShopsPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [description] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = ShopsPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Shops The current object (for fluent API support)
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
            $this->modifiedColumns[] = ShopsPeer::ENABLED;
        }


        return $this;
    } // setEnabled()

    /**
     * Set the value of [fos_user_id] column.
     *
     * @param  int $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setFosUserId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->fos_user_id !== $v) {
            $this->fos_user_id = $v;
            $this->modifiedColumns[] = ShopsPeer::FOS_USER_ID;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }


        return $this;
    } // setFosUserId()

    /**
     * Set the value of [address] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[] = ShopsPeer::ADDRESS;
        }


        return $this;
    } // setAddress()

    /**
     * Set the value of [phone] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setPhone($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phone !== $v) {
            $this->phone = $v;
            $this->modifiedColumns[] = ShopsPeer::PHONE;
        }


        return $this;
    } // setPhone()

    /**
     * Set the value of [site] column.
     *
     * @param  string $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setSite($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->site !== $v) {
            $this->site = $v;
            $this->modifiedColumns[] = ShopsPeer::SITE;
        }


        return $this;
    } // setSite()

    /**
     * Set the value of [region_id] column.
     *
     * @param  int $v new value
     * @return Shops The current object (for fluent API support)
     */
    public function setRegionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->region_id !== $v) {
            $this->region_id = $v;
            $this->modifiedColumns[] = ShopsPeer::REGION_ID;
        }

        if ($this->aRegions !== null && $this->aRegions->getId() !== $v) {
            $this->aRegions = null;
        }


        return $this;
    } // setRegionId()

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
            $this->alias = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->icon = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->title = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->description = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->enabled = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
            $this->fos_user_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->address = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->phone = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->site = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->region_id = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 12; // 12 = ShopsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Shops object", $e);
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

        if ($this->aUser !== null && $this->fos_user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
        if ($this->aRegions !== null && $this->region_id !== $this->aRegions->getId()) {
            $this->aRegions = null;
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
            $con = Propel::getConnection(ShopsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ShopsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aRegions = null;
            $this->aUser = null;
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
            $con = Propel::getConnection(ShopsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ShopsQuery::create()
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
            $con = Propel::getConnection(ShopsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ShopsPeer::addInstanceToPool($this);
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

            if ($this->aRegions !== null) {
                if ($this->aRegions->isModified() || $this->aRegions->isNew()) {
                    $affectedRows += $this->aRegions->save($con);
                }
                $this->setRegions($this->aRegions);
            }

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
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

        $this->modifiedColumns[] = ShopsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ShopsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ShopsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(ShopsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(ShopsPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(ShopsPeer::ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }
        if ($this->isColumnModified(ShopsPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`title`';
        }
        if ($this->isColumnModified(ShopsPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '`description`';
        }
        if ($this->isColumnModified(ShopsPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(ShopsPeer::FOS_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = '`fos_user_id`';
        }
        if ($this->isColumnModified(ShopsPeer::ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = '`address`';
        }
        if ($this->isColumnModified(ShopsPeer::PHONE)) {
            $modifiedColumns[':p' . $index++]  = '`phone`';
        }
        if ($this->isColumnModified(ShopsPeer::SITE)) {
            $modifiedColumns[':p' . $index++]  = '`site`';
        }
        if ($this->isColumnModified(ShopsPeer::REGION_ID)) {
            $modifiedColumns[':p' . $index++]  = '`region_id`';
        }

        $sql = sprintf(
            'INSERT INTO `shops` (%s) VALUES (%s)',
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
                    case '`alias`':
                        $stmt->bindValue($identifier, $this->alias, PDO::PARAM_STR);
                        break;
                    case '`icon`':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
                        break;
                    case '`title`':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '`description`':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`fos_user_id`':
                        $stmt->bindValue($identifier, $this->fos_user_id, PDO::PARAM_INT);
                        break;
                    case '`address`':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case '`phone`':
                        $stmt->bindValue($identifier, $this->phone, PDO::PARAM_STR);
                        break;
                    case '`site`':
                        $stmt->bindValue($identifier, $this->site, PDO::PARAM_STR);
                        break;
                    case '`region_id`':
                        $stmt->bindValue($identifier, $this->region_id, PDO::PARAM_INT);
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

            if ($this->aRegions !== null) {
                if (!$this->aRegions->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aRegions->getValidationFailures());
                }
            }

            if ($this->aUser !== null) {
                if (!$this->aUser->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aUser->getValidationFailures());
                }
            }


            if (($retval = ShopsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = ShopsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAlias();
                break;
            case 3:
                return $this->getIcon();
                break;
            case 4:
                return $this->getTitle();
                break;
            case 5:
                return $this->getDescription();
                break;
            case 6:
                return $this->getEnabled();
                break;
            case 7:
                return $this->getFosUserId();
                break;
            case 8:
                return $this->getAddress();
                break;
            case 9:
                return $this->getPhone();
                break;
            case 10:
                return $this->getSite();
                break;
            case 11:
                return $this->getRegionId();
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
        if (isset($alreadyDumpedObjects['Shops'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Shops'][$this->getPrimaryKey()] = true;
        $keys = ShopsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAlias(),
            $keys[3] => $this->getIcon(),
            $keys[4] => $this->getTitle(),
            $keys[5] => $this->getDescription(),
            $keys[6] => $this->getEnabled(),
            $keys[7] => $this->getFosUserId(),
            $keys[8] => $this->getAddress(),
            $keys[9] => $this->getPhone(),
            $keys[10] => $this->getSite(),
            $keys[11] => $this->getRegionId(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aRegions) {
                $result['Regions'] = $this->aRegions->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUser) {
                $result['User'] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = ShopsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAlias($value);
                break;
            case 3:
                $this->setIcon($value);
                break;
            case 4:
                $this->setTitle($value);
                break;
            case 5:
                $this->setDescription($value);
                break;
            case 6:
                $this->setEnabled($value);
                break;
            case 7:
                $this->setFosUserId($value);
                break;
            case 8:
                $this->setAddress($value);
                break;
            case 9:
                $this->setPhone($value);
                break;
            case 10:
                $this->setSite($value);
                break;
            case 11:
                $this->setRegionId($value);
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
        $keys = ShopsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAlias($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setIcon($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setTitle($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setEnabled($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setFosUserId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setAddress($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPhone($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setSite($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setRegionId($arr[$keys[11]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ShopsPeer::DATABASE_NAME);

        if ($this->isColumnModified(ShopsPeer::ID)) $criteria->add(ShopsPeer::ID, $this->id);
        if ($this->isColumnModified(ShopsPeer::NAME)) $criteria->add(ShopsPeer::NAME, $this->name);
        if ($this->isColumnModified(ShopsPeer::ALIAS)) $criteria->add(ShopsPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(ShopsPeer::ICON)) $criteria->add(ShopsPeer::ICON, $this->icon);
        if ($this->isColumnModified(ShopsPeer::TITLE)) $criteria->add(ShopsPeer::TITLE, $this->title);
        if ($this->isColumnModified(ShopsPeer::DESCRIPTION)) $criteria->add(ShopsPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(ShopsPeer::ENABLED)) $criteria->add(ShopsPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(ShopsPeer::FOS_USER_ID)) $criteria->add(ShopsPeer::FOS_USER_ID, $this->fos_user_id);
        if ($this->isColumnModified(ShopsPeer::ADDRESS)) $criteria->add(ShopsPeer::ADDRESS, $this->address);
        if ($this->isColumnModified(ShopsPeer::PHONE)) $criteria->add(ShopsPeer::PHONE, $this->phone);
        if ($this->isColumnModified(ShopsPeer::SITE)) $criteria->add(ShopsPeer::SITE, $this->site);
        if ($this->isColumnModified(ShopsPeer::REGION_ID)) $criteria->add(ShopsPeer::REGION_ID, $this->region_id);

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
        $criteria = new Criteria(ShopsPeer::DATABASE_NAME);
        $criteria->add(ShopsPeer::ID, $this->id);

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
     * @param object $copyObj An object of Shops (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setIcon($this->getIcon());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setFosUserId($this->getFosUserId());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhone($this->getPhone());
        $copyObj->setSite($this->getSite());
        $copyObj->setRegionId($this->getRegionId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
     * @return Shops Clone of current object.
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
     * @return ShopsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ShopsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Regions object.
     *
     * @param                  Regions $v
     * @return Shops The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRegions(Regions $v = null)
    {
        if ($v === null) {
            $this->setRegionId(NULL);
        } else {
            $this->setRegionId($v->getId());
        }

        $this->aRegions = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Regions object, it will not be re-added.
        if ($v !== null) {
            $v->addShops($this);
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
        if ($this->aRegions === null && ($this->region_id !== null) && $doQuery) {
            $this->aRegions = RegionsQuery::create()->findPk($this->region_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRegions->addShopss($this);
             */
        }

        return $this->aRegions;
    }

    /**
     * Declares an association between this object and a User object.
     *
     * @param                  User $v
     * @return Shops The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(User $v = null)
    {
        if ($v === null) {
            $this->setFosUserId(NULL);
        } else {
            $this->setFosUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the User object, it will not be re-added.
        if ($v !== null) {
            $v->addShops($this);
        }


        return $this;
    }


    /**
     * Get the associated User object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return User The associated User object.
     * @throws PropelException
     */
    public function getUser(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aUser === null && ($this->fos_user_id !== null) && $doQuery) {
            $this->aUser = UserQuery::create()->findPk($this->fos_user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addShopss($this);
             */
        }

        return $this->aUser;
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
        if ('Advs' == $relationName) {
            $this->initAdvss();
        }
    }

    /**
     * Clears out the collAdvss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Shops The current object (for fluent API support)
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
     * If this Shops is new, it will return
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
                    ->filterByShops($this)
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
     * @return Shops The current object (for fluent API support)
     */
    public function setAdvss(PropelCollection $advss, PropelPDO $con = null)
    {
        $advssToDelete = $this->getAdvss(new Criteria(), $con)->diff($advss);


        $this->advssScheduledForDeletion = $advssToDelete;

        foreach ($advssToDelete as $advsRemoved) {
            $advsRemoved->setShops(null);
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
                ->filterByShops($this)
                ->count($con);
        }

        return count($this->collAdvss);
    }

    /**
     * Method called to associate a Advs object to this object
     * through the Advs foreign key attribute.
     *
     * @param    Advs $l Advs
     * @return Shops The current object (for fluent API support)
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
        $advs->setShops($this);
    }

    /**
     * @param	Advs $advs The advs object to remove.
     * @return Shops The current object (for fluent API support)
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
            $advs->setShops(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Shops is new, it will return
     * an empty collection; or if this Shops has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Shops.
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
     * Otherwise if this Shops is new, it will return
     * an empty collection; or if this Shops has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Shops.
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
     * Otherwise if this Shops is new, it will return
     * an empty collection; or if this Shops has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Shops.
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
     * Otherwise if this Shops is new, it will return
     * an empty collection; or if this Shops has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Shops.
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
        $this->alias = null;
        $this->icon = null;
        $this->title = null;
        $this->description = null;
        $this->enabled = null;
        $this->fos_user_id = null;
        $this->address = null;
        $this->phone = null;
        $this->site = null;
        $this->region_id = null;
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
            if ($this->collAdvss) {
                foreach ($this->collAdvss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aRegions instanceof Persistent) {
              $this->aRegions->clearAllReferences($deep);
            }
            if ($this->aUser instanceof Persistent) {
              $this->aUser->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAdvss instanceof PropelCollection) {
            $this->collAdvss->clearIterator();
        }
        $this->collAdvss = null;
        $this->aRegions = null;
        $this->aUser = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'icon' column
     */
    public function __toString()
    {
        return (string) $this->getIcon();
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
