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
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesFields;
use Admin\AdminBundle\Model\AdCategoriesFieldsPeer;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsQuery;

abstract class BaseAdCategoriesFields extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AdCategoriesFieldsPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AdCategoriesFieldsPeer
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
     * The value for the filter_name field.
     * @var        string
     */
    protected $filter_name;

    /**
     * The value for the type field.
     * @var        int
     */
    protected $type;

    /**
     * The value for the sort field.
     * @var        int
     */
    protected $sort;

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
     * The value for the mask field.
     * @var        string
     */
    protected $mask;

    /**
     * The value for the postfix field.
     * @var        string
     */
    protected $postfix;

    /**
     * The value for the show_in_filter field.
     * @var        boolean
     */
    protected $show_in_filter;

    /**
     * The value for the required field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $required;

    /**
     * The value for the show_in_table field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $show_in_table;

    /**
     * The value for the show_on_map field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $show_on_map;

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
     * @var        AdCategories
     */
    protected $aAdCategories;

    /**
     * @var        AdCategoriesFields
     */
    protected $aAdCategoriesFieldsRelatedByParentFieldId;

    /**
     * @var        PropelObjectCollection|AdCategoriesFields[] Collection to store aggregation of AdCategoriesFields objects.
     */
    protected $collChildsFieldss;
    protected $collChildsFieldssPartial;

    /**
     * @var        PropelObjectCollection|AdCategoriesFieldsValues[] Collection to store aggregation of AdCategoriesFieldsValues objects.
     */
    protected $collAdCategoriesFieldsValuess;
    protected $collAdCategoriesFieldsValuessPartial;

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
    protected $childsFieldssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $adCategoriesFieldsValuessScheduledForDeletion = null;

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
        $this->required = false;
        $this->show_in_table = false;
        $this->show_on_map = false;
        $this->enabled = false;
        $this->listing = false;
        $this->deleted = false;
    }

    /**
     * Initializes internal state of BaseAdCategoriesFields object.
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
     * Get the [filter_name] column value.
     *
     * @return string
     */
    public function getFilterName()
    {

        return $this->filter_name;
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
     * Get the [sort] column value.
     *
     * @return int
     */
    public function getSort()
    {

        return $this->sort;
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
     * Get the [mask] column value.
     *
     * @return string
     */
    public function getMask()
    {

        return $this->mask;
    }

    /**
     * Get the [postfix] column value.
     *
     * @return string
     */
    public function getPostfix()
    {

        return $this->postfix;
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
     * Get the [required] column value.
     *
     * @return boolean
     */
    public function getRequired()
    {

        return $this->required;
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
     * Get the [show_on_map] column value.
     *
     * @return boolean
     */
    public function getShowOnMap()
    {

        return $this->show_on_map;
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
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [category_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setCategoryId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->category_id !== $v) {
            $this->category_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::CATEGORY_ID;
        }

        if ($this->aAdCategories !== null && $this->aAdCategories->getId() !== $v) {
            $this->aAdCategories = null;
        }


        return $this;
    } // setCategoryId()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [filter_name] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setFilterName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->filter_name !== $v) {
            $this->filter_name = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::FILTER_NAME;
        }


        return $this;
    } // setFilterName()

    /**
     * Set the value of [type] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::TYPE;
        }


        return $this;
    } // setType()

    /**
     * Set the value of [sort] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::SORT;
        }


        return $this;
    } // setSort()

    /**
     * Set the value of [parent_field_id] column.
     *
     * @param  int $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setParentFieldId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_field_id !== $v) {
            $this->parent_field_id = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::PARENT_FIELD_ID;
        }

        if ($this->aAdCategoriesFieldsRelatedByParentFieldId !== null && $this->aAdCategoriesFieldsRelatedByParentFieldId->getId() !== $v) {
            $this->aAdCategoriesFieldsRelatedByParentFieldId = null;
        }


        return $this;
    } // setParentFieldId()

    /**
     * Set the value of [helper] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setHelper($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->helper !== $v) {
            $this->helper = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::HELPER;
        }


        return $this;
    } // setHelper()

    /**
     * Set the value of [mask] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setMask($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->mask !== $v) {
            $this->mask = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::MASK;
        }


        return $this;
    } // setMask()

    /**
     * Set the value of [postfix] column.
     *
     * @param  string $v new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setPostfix($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->postfix !== $v) {
            $this->postfix = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::POSTFIX;
        }


        return $this;
    } // setPostfix()

    /**
     * Sets the value of the [show_in_filter] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::SHOW_IN_FILTER;
        }


        return $this;
    } // setShowInFilter()

    /**
     * Sets the value of the [required] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setRequired($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->required !== $v) {
            $this->required = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::REQUIRED;
        }


        return $this;
    } // setRequired()

    /**
     * Sets the value of the [show_in_table] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::SHOW_IN_TABLE;
        }


        return $this;
    } // setShowInTable()

    /**
     * Sets the value of the [show_on_map] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setShowOnMap($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->show_on_map !== $v) {
            $this->show_on_map = $v;
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::SHOW_ON_MAP;
        }


        return $this;
    } // setShowOnMap()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::ENABLED;
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
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::LISTING;
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
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesFieldsPeer::DELETED;
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
            if ($this->required !== false) {
                return false;
            }

            if ($this->show_in_table !== false) {
                return false;
            }

            if ($this->show_on_map !== false) {
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
            $this->filter_name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->type = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->sort = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->parent_field_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->helper = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->mask = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->postfix = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->show_in_filter = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
            $this->required = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
            $this->show_in_table = ($row[$startcol + 12] !== null) ? (boolean) $row[$startcol + 12] : null;
            $this->show_on_map = ($row[$startcol + 13] !== null) ? (boolean) $row[$startcol + 13] : null;
            $this->enabled = ($row[$startcol + 14] !== null) ? (boolean) $row[$startcol + 14] : null;
            $this->listing = ($row[$startcol + 15] !== null) ? (boolean) $row[$startcol + 15] : null;
            $this->deleted = ($row[$startcol + 16] !== null) ? (boolean) $row[$startcol + 16] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 17; // 17 = AdCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AdCategoriesFields object", $e);
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
        if ($this->aAdCategoriesFieldsRelatedByParentFieldId !== null && $this->parent_field_id !== $this->aAdCategoriesFieldsRelatedByParentFieldId->getId()) {
            $this->aAdCategoriesFieldsRelatedByParentFieldId = null;
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
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AdCategoriesFieldsPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdCategories = null;
            $this->aAdCategoriesFieldsRelatedByParentFieldId = null;
            $this->collChildsFieldss = null;

            $this->collAdCategoriesFieldsValuess = null;

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
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AdCategoriesFieldsQuery::create()
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
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AdCategoriesFieldsPeer::addInstanceToPool($this);
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

            if ($this->aAdCategoriesFieldsRelatedByParentFieldId !== null) {
                if ($this->aAdCategoriesFieldsRelatedByParentFieldId->isModified() || $this->aAdCategoriesFieldsRelatedByParentFieldId->isNew()) {
                    $affectedRows += $this->aAdCategoriesFieldsRelatedByParentFieldId->save($con);
                }
                $this->setAdCategoriesFieldsRelatedByParentFieldId($this->aAdCategoriesFieldsRelatedByParentFieldId);
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
                    AdCategoriesFieldsQuery::create()
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

            if ($this->adCategoriesFieldsValuessScheduledForDeletion !== null) {
                if (!$this->adCategoriesFieldsValuessScheduledForDeletion->isEmpty()) {
                    AdCategoriesFieldsValuesQuery::create()
                        ->filterByPrimaryKeys($this->adCategoriesFieldsValuessScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adCategoriesFieldsValuessScheduledForDeletion = null;
                }
            }

            if ($this->collAdCategoriesFieldsValuess !== null) {
                foreach ($this->collAdCategoriesFieldsValuess as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[] = AdCategoriesFieldsPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdCategoriesFieldsPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdCategoriesFieldsPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::CATEGORY_ID)) {
            $modifiedColumns[':p' . $index++]  = '`category_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::FILTER_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`filter_name`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SORT)) {
            $modifiedColumns[':p' . $index++]  = '`sort`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::PARENT_FIELD_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_field_id`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::HELPER)) {
            $modifiedColumns[':p' . $index++]  = '`helper`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::MASK)) {
            $modifiedColumns[':p' . $index++]  = '`mask`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::POSTFIX)) {
            $modifiedColumns[':p' . $index++]  = '`postfix`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SHOW_IN_FILTER)) {
            $modifiedColumns[':p' . $index++]  = '`show_in_filter`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::REQUIRED)) {
            $modifiedColumns[':p' . $index++]  = '`required`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SHOW_IN_TABLE)) {
            $modifiedColumns[':p' . $index++]  = '`show_in_table`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SHOW_ON_MAP)) {
            $modifiedColumns[':p' . $index++]  = '`show_on_map`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::LISTING)) {
            $modifiedColumns[':p' . $index++]  = '`listing`';
        }
        if ($this->isColumnModified(AdCategoriesFieldsPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }

        $sql = sprintf(
            'INSERT INTO `ad_categories_fields` (%s) VALUES (%s)',
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
                    case '`filter_name`':
                        $stmt->bindValue($identifier, $this->filter_name, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_INT);
                        break;
                    case '`sort`':
                        $stmt->bindValue($identifier, $this->sort, PDO::PARAM_INT);
                        break;
                    case '`parent_field_id`':
                        $stmt->bindValue($identifier, $this->parent_field_id, PDO::PARAM_INT);
                        break;
                    case '`helper`':
                        $stmt->bindValue($identifier, $this->helper, PDO::PARAM_STR);
                        break;
                    case '`mask`':
                        $stmt->bindValue($identifier, $this->mask, PDO::PARAM_STR);
                        break;
                    case '`postfix`':
                        $stmt->bindValue($identifier, $this->postfix, PDO::PARAM_STR);
                        break;
                    case '`show_in_filter`':
                        $stmt->bindValue($identifier, (int) $this->show_in_filter, PDO::PARAM_INT);
                        break;
                    case '`required`':
                        $stmt->bindValue($identifier, (int) $this->required, PDO::PARAM_INT);
                        break;
                    case '`show_in_table`':
                        $stmt->bindValue($identifier, (int) $this->show_in_table, PDO::PARAM_INT);
                        break;
                    case '`show_on_map`':
                        $stmt->bindValue($identifier, (int) $this->show_on_map, PDO::PARAM_INT);
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

            if ($this->aAdCategories !== null) {
                if (!$this->aAdCategories->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategories->getValidationFailures());
                }
            }

            if ($this->aAdCategoriesFieldsRelatedByParentFieldId !== null) {
                if (!$this->aAdCategoriesFieldsRelatedByParentFieldId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategoriesFieldsRelatedByParentFieldId->getValidationFailures());
                }
            }


            if (($retval = AdCategoriesFieldsPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collChildsFieldss !== null) {
                    foreach ($this->collChildsFieldss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdCategoriesFieldsValuess !== null) {
                    foreach ($this->collAdCategoriesFieldsValuess as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
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
        $pos = AdCategoriesFieldsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFilterName();
                break;
            case 4:
                return $this->getType();
                break;
            case 5:
                return $this->getSort();
                break;
            case 6:
                return $this->getParentFieldId();
                break;
            case 7:
                return $this->getHelper();
                break;
            case 8:
                return $this->getMask();
                break;
            case 9:
                return $this->getPostfix();
                break;
            case 10:
                return $this->getShowInFilter();
                break;
            case 11:
                return $this->getRequired();
                break;
            case 12:
                return $this->getShowInTable();
                break;
            case 13:
                return $this->getShowOnMap();
                break;
            case 14:
                return $this->getEnabled();
                break;
            case 15:
                return $this->getListing();
                break;
            case 16:
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
        if (isset($alreadyDumpedObjects['AdCategoriesFields'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdCategoriesFields'][$this->getPrimaryKey()] = true;
        $keys = AdCategoriesFieldsPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCategoryId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getFilterName(),
            $keys[4] => $this->getType(),
            $keys[5] => $this->getSort(),
            $keys[6] => $this->getParentFieldId(),
            $keys[7] => $this->getHelper(),
            $keys[8] => $this->getMask(),
            $keys[9] => $this->getPostfix(),
            $keys[10] => $this->getShowInFilter(),
            $keys[11] => $this->getRequired(),
            $keys[12] => $this->getShowInTable(),
            $keys[13] => $this->getShowOnMap(),
            $keys[14] => $this->getEnabled(),
            $keys[15] => $this->getListing(),
            $keys[16] => $this->getDeleted(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdCategories) {
                $result['AdCategories'] = $this->aAdCategories->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAdCategoriesFieldsRelatedByParentFieldId) {
                $result['AdCategoriesFieldsRelatedByParentFieldId'] = $this->aAdCategoriesFieldsRelatedByParentFieldId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collChildsFieldss) {
                $result['ChildsFieldss'] = $this->collChildsFieldss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdCategoriesFieldsValuess) {
                $result['AdCategoriesFieldsValuess'] = $this->collAdCategoriesFieldsValuess->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AdCategoriesFieldsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFilterName($value);
                break;
            case 4:
                $this->setType($value);
                break;
            case 5:
                $this->setSort($value);
                break;
            case 6:
                $this->setParentFieldId($value);
                break;
            case 7:
                $this->setHelper($value);
                break;
            case 8:
                $this->setMask($value);
                break;
            case 9:
                $this->setPostfix($value);
                break;
            case 10:
                $this->setShowInFilter($value);
                break;
            case 11:
                $this->setRequired($value);
                break;
            case 12:
                $this->setShowInTable($value);
                break;
            case 13:
                $this->setShowOnMap($value);
                break;
            case 14:
                $this->setEnabled($value);
                break;
            case 15:
                $this->setListing($value);
                break;
            case 16:
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
        $keys = AdCategoriesFieldsPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCategoryId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFilterName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setType($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSort($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setParentFieldId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setHelper($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setMask($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPostfix($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setShowInFilter($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setRequired($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setShowInTable($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setShowOnMap($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setEnabled($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setListing($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setDeleted($arr[$keys[16]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);

        if ($this->isColumnModified(AdCategoriesFieldsPeer::ID)) $criteria->add(AdCategoriesFieldsPeer::ID, $this->id);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::CATEGORY_ID)) $criteria->add(AdCategoriesFieldsPeer::CATEGORY_ID, $this->category_id);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::NAME)) $criteria->add(AdCategoriesFieldsPeer::NAME, $this->name);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::FILTER_NAME)) $criteria->add(AdCategoriesFieldsPeer::FILTER_NAME, $this->filter_name);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::TYPE)) $criteria->add(AdCategoriesFieldsPeer::TYPE, $this->type);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SORT)) $criteria->add(AdCategoriesFieldsPeer::SORT, $this->sort);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::PARENT_FIELD_ID)) $criteria->add(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $this->parent_field_id);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::HELPER)) $criteria->add(AdCategoriesFieldsPeer::HELPER, $this->helper);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::MASK)) $criteria->add(AdCategoriesFieldsPeer::MASK, $this->mask);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::POSTFIX)) $criteria->add(AdCategoriesFieldsPeer::POSTFIX, $this->postfix);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SHOW_IN_FILTER)) $criteria->add(AdCategoriesFieldsPeer::SHOW_IN_FILTER, $this->show_in_filter);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::REQUIRED)) $criteria->add(AdCategoriesFieldsPeer::REQUIRED, $this->required);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SHOW_IN_TABLE)) $criteria->add(AdCategoriesFieldsPeer::SHOW_IN_TABLE, $this->show_in_table);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::SHOW_ON_MAP)) $criteria->add(AdCategoriesFieldsPeer::SHOW_ON_MAP, $this->show_on_map);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::ENABLED)) $criteria->add(AdCategoriesFieldsPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::LISTING)) $criteria->add(AdCategoriesFieldsPeer::LISTING, $this->listing);
        if ($this->isColumnModified(AdCategoriesFieldsPeer::DELETED)) $criteria->add(AdCategoriesFieldsPeer::DELETED, $this->deleted);

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
        $criteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);
        $criteria->add(AdCategoriesFieldsPeer::ID, $this->id);

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
     * @param object $copyObj An object of AdCategoriesFields (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCategoryId($this->getCategoryId());
        $copyObj->setName($this->getName());
        $copyObj->setFilterName($this->getFilterName());
        $copyObj->setType($this->getType());
        $copyObj->setSort($this->getSort());
        $copyObj->setParentFieldId($this->getParentFieldId());
        $copyObj->setHelper($this->getHelper());
        $copyObj->setMask($this->getMask());
        $copyObj->setPostfix($this->getPostfix());
        $copyObj->setShowInFilter($this->getShowInFilter());
        $copyObj->setRequired($this->getRequired());
        $copyObj->setShowInTable($this->getShowInTable());
        $copyObj->setShowOnMap($this->getShowOnMap());
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

            foreach ($this->getAdCategoriesFieldsValuess() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdCategoriesFieldsValues($relObj->copy($deepCopy));
                }
            }

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
     * @return AdCategoriesFields Clone of current object.
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
     * @return AdCategoriesFieldsPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AdCategoriesFieldsPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AdCategories object.
     *
     * @param                  AdCategories $v
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $v->addAdCategoriesFields($this);
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
                $this->aAdCategories->addAdCategoriesFieldss($this);
             */
        }

        return $this->aAdCategories;
    }

    /**
     * Declares an association between this object and a AdCategoriesFields object.
     *
     * @param                  AdCategoriesFields $v
     * @return AdCategoriesFields The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdCategoriesFieldsRelatedByParentFieldId(AdCategoriesFields $v = null)
    {
        if ($v === null) {
            $this->setParentFieldId(NULL);
        } else {
            $this->setParentFieldId($v->getId());
        }

        $this->aAdCategoriesFieldsRelatedByParentFieldId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AdCategoriesFields object, it will not be re-added.
        if ($v !== null) {
            $v->addChildsFields($this);
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
    public function getAdCategoriesFieldsRelatedByParentFieldId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdCategoriesFieldsRelatedByParentFieldId === null && ($this->parent_field_id !== null) && $doQuery) {
            $this->aAdCategoriesFieldsRelatedByParentFieldId = AdCategoriesFieldsQuery::create()->findPk($this->parent_field_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdCategoriesFieldsRelatedByParentFieldId->addChildsFieldss($this);
             */
        }

        return $this->aAdCategoriesFieldsRelatedByParentFieldId;
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
        if ('AdCategoriesFieldsValues' == $relationName) {
            $this->initAdCategoriesFieldsValuess();
        }
        if ('AdvParams' == $relationName) {
            $this->initAdvParamss();
        }
    }

    /**
     * Clears out the collChildsFieldss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategoriesFields The current object (for fluent API support)
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
        $this->collChildsFieldss->setModel('AdCategoriesFields');
    }

    /**
     * Gets an array of AdCategoriesFields objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this AdCategoriesFields is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdCategoriesFields[] List of AdCategoriesFields objects
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
                $collChildsFieldss = AdCategoriesFieldsQuery::create(null, $criteria)
                    ->filterByAdCategoriesFieldsRelatedByParentFieldId($this)
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
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setChildsFieldss(PropelCollection $childsFieldss, PropelPDO $con = null)
    {
        $childsFieldssToDelete = $this->getChildsFieldss(new Criteria(), $con)->diff($childsFieldss);


        $this->childsFieldssScheduledForDeletion = $childsFieldssToDelete;

        foreach ($childsFieldssToDelete as $childsFieldsRemoved) {
            $childsFieldsRemoved->setAdCategoriesFieldsRelatedByParentFieldId(null);
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
     * Returns the number of related AdCategoriesFields objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdCategoriesFields objects.
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
            $query = AdCategoriesFieldsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdCategoriesFieldsRelatedByParentFieldId($this)
                ->count($con);
        }

        return count($this->collChildsFieldss);
    }

    /**
     * Method called to associate a AdCategoriesFields object to this object
     * through the AdCategoriesFields foreign key attribute.
     *
     * @param    AdCategoriesFields $l AdCategoriesFields
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function addChildsFields(AdCategoriesFields $l)
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
        $childsFields->setAdCategoriesFieldsRelatedByParentFieldId($this);
    }

    /**
     * @param	ChildsFields $childsFields The childsFields object to remove.
     * @return AdCategoriesFields The current object (for fluent API support)
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
            $childsFields->setAdCategoriesFieldsRelatedByParentFieldId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategoriesFields is new, it will return
     * an empty collection; or if this AdCategoriesFields has previously
     * been saved, it will retrieve related ChildsFieldss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategoriesFields.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdCategoriesFields[] List of AdCategoriesFields objects
     */
    public function getChildsFieldssJoinAdCategories($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdCategoriesFieldsQuery::create(null, $criteria);
        $query->joinWith('AdCategories', $join_behavior);

        return $this->getChildsFieldss($query, $con);
    }

    /**
     * Clears out the collAdCategoriesFieldsValuess collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategoriesFields The current object (for fluent API support)
     * @see        addAdCategoriesFieldsValuess()
     */
    public function clearAdCategoriesFieldsValuess()
    {
        $this->collAdCategoriesFieldsValuess = null; // important to set this to null since that means it is uninitialized
        $this->collAdCategoriesFieldsValuessPartial = null;

        return $this;
    }

    /**
     * reset is the collAdCategoriesFieldsValuess collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdCategoriesFieldsValuess($v = true)
    {
        $this->collAdCategoriesFieldsValuessPartial = $v;
    }

    /**
     * Initializes the collAdCategoriesFieldsValuess collection.
     *
     * By default this just sets the collAdCategoriesFieldsValuess collection to an empty array (like clearcollAdCategoriesFieldsValuess());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdCategoriesFieldsValuess($overrideExisting = true)
    {
        if (null !== $this->collAdCategoriesFieldsValuess && !$overrideExisting) {
            return;
        }
        $this->collAdCategoriesFieldsValuess = new PropelObjectCollection();
        $this->collAdCategoriesFieldsValuess->setModel('AdCategoriesFieldsValues');
    }

    /**
     * Gets an array of AdCategoriesFieldsValues objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this AdCategoriesFields is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdCategoriesFieldsValues[] List of AdCategoriesFieldsValues objects
     * @throws PropelException
     */
    public function getAdCategoriesFieldsValuess($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdCategoriesFieldsValuessPartial && !$this->isNew();
        if (null === $this->collAdCategoriesFieldsValuess || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdCategoriesFieldsValuess) {
                // return empty collection
                $this->initAdCategoriesFieldsValuess();
            } else {
                $collAdCategoriesFieldsValuess = AdCategoriesFieldsValuesQuery::create(null, $criteria)
                    ->filterByAdCategoriesFields($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdCategoriesFieldsValuessPartial && count($collAdCategoriesFieldsValuess)) {
                      $this->initAdCategoriesFieldsValuess(false);

                      foreach ($collAdCategoriesFieldsValuess as $obj) {
                        if (false == $this->collAdCategoriesFieldsValuess->contains($obj)) {
                          $this->collAdCategoriesFieldsValuess->append($obj);
                        }
                      }

                      $this->collAdCategoriesFieldsValuessPartial = true;
                    }

                    $collAdCategoriesFieldsValuess->getInternalIterator()->rewind();

                    return $collAdCategoriesFieldsValuess;
                }

                if ($partial && $this->collAdCategoriesFieldsValuess) {
                    foreach ($this->collAdCategoriesFieldsValuess as $obj) {
                        if ($obj->isNew()) {
                            $collAdCategoriesFieldsValuess[] = $obj;
                        }
                    }
                }

                $this->collAdCategoriesFieldsValuess = $collAdCategoriesFieldsValuess;
                $this->collAdCategoriesFieldsValuessPartial = false;
            }
        }

        return $this->collAdCategoriesFieldsValuess;
    }

    /**
     * Sets a collection of AdCategoriesFieldsValues objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $adCategoriesFieldsValuess A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setAdCategoriesFieldsValuess(PropelCollection $adCategoriesFieldsValuess, PropelPDO $con = null)
    {
        $adCategoriesFieldsValuessToDelete = $this->getAdCategoriesFieldsValuess(new Criteria(), $con)->diff($adCategoriesFieldsValuess);


        $this->adCategoriesFieldsValuessScheduledForDeletion = $adCategoriesFieldsValuessToDelete;

        foreach ($adCategoriesFieldsValuessToDelete as $adCategoriesFieldsValuesRemoved) {
            $adCategoriesFieldsValuesRemoved->setAdCategoriesFields(null);
        }

        $this->collAdCategoriesFieldsValuess = null;
        foreach ($adCategoriesFieldsValuess as $adCategoriesFieldsValues) {
            $this->addAdCategoriesFieldsValues($adCategoriesFieldsValues);
        }

        $this->collAdCategoriesFieldsValuess = $adCategoriesFieldsValuess;
        $this->collAdCategoriesFieldsValuessPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdCategoriesFieldsValues objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdCategoriesFieldsValues objects.
     * @throws PropelException
     */
    public function countAdCategoriesFieldsValuess(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdCategoriesFieldsValuessPartial && !$this->isNew();
        if (null === $this->collAdCategoriesFieldsValuess || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdCategoriesFieldsValuess) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdCategoriesFieldsValuess());
            }
            $query = AdCategoriesFieldsValuesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdCategoriesFields($this)
                ->count($con);
        }

        return count($this->collAdCategoriesFieldsValuess);
    }

    /**
     * Method called to associate a AdCategoriesFieldsValues object to this object
     * through the AdCategoriesFieldsValues foreign key attribute.
     *
     * @param    AdCategoriesFieldsValues $l AdCategoriesFieldsValues
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function addAdCategoriesFieldsValues(AdCategoriesFieldsValues $l)
    {
        if ($this->collAdCategoriesFieldsValuess === null) {
            $this->initAdCategoriesFieldsValuess();
            $this->collAdCategoriesFieldsValuessPartial = true;
        }

        if (!in_array($l, $this->collAdCategoriesFieldsValuess->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdCategoriesFieldsValues($l);

            if ($this->adCategoriesFieldsValuessScheduledForDeletion and $this->adCategoriesFieldsValuessScheduledForDeletion->contains($l)) {
                $this->adCategoriesFieldsValuessScheduledForDeletion->remove($this->adCategoriesFieldsValuessScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdCategoriesFieldsValues $adCategoriesFieldsValues The adCategoriesFieldsValues object to add.
     */
    protected function doAddAdCategoriesFieldsValues($adCategoriesFieldsValues)
    {
        $this->collAdCategoriesFieldsValuess[]= $adCategoriesFieldsValues;
        $adCategoriesFieldsValues->setAdCategoriesFields($this);
    }

    /**
     * @param	AdCategoriesFieldsValues $adCategoriesFieldsValues The adCategoriesFieldsValues object to remove.
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function removeAdCategoriesFieldsValues($adCategoriesFieldsValues)
    {
        if ($this->getAdCategoriesFieldsValuess()->contains($adCategoriesFieldsValues)) {
            $this->collAdCategoriesFieldsValuess->remove($this->collAdCategoriesFieldsValuess->search($adCategoriesFieldsValues));
            if (null === $this->adCategoriesFieldsValuessScheduledForDeletion) {
                $this->adCategoriesFieldsValuessScheduledForDeletion = clone $this->collAdCategoriesFieldsValuess;
                $this->adCategoriesFieldsValuessScheduledForDeletion->clear();
            }
            $this->adCategoriesFieldsValuessScheduledForDeletion[]= $adCategoriesFieldsValues;
            $adCategoriesFieldsValues->setAdCategoriesFields(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdvParamss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategoriesFields The current object (for fluent API support)
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
     * If this AdCategoriesFields is new, it will return
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
                    ->filterByAdCategoriesFields($this)
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
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function setAdvParamss(PropelCollection $advParamss, PropelPDO $con = null)
    {
        $advParamssToDelete = $this->getAdvParamss(new Criteria(), $con)->diff($advParamss);


        $this->advParamssScheduledForDeletion = $advParamssToDelete;

        foreach ($advParamssToDelete as $advParamsRemoved) {
            $advParamsRemoved->setAdCategoriesFields(null);
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
                ->filterByAdCategoriesFields($this)
                ->count($con);
        }

        return count($this->collAdvParamss);
    }

    /**
     * Method called to associate a AdvParams object to this object
     * through the AdvParams foreign key attribute.
     *
     * @param    AdvParams $l AdvParams
     * @return AdCategoriesFields The current object (for fluent API support)
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
        $advParams->setAdCategoriesFields($this);
    }

    /**
     * @param	AdvParams $advParams The advParams object to remove.
     * @return AdCategoriesFields The current object (for fluent API support)
     */
    public function removeAdvParams($advParams)
    {
        if ($this->getAdvParamss()->contains($advParams)) {
            $this->collAdvParamss->remove($this->collAdvParamss->search($advParams));
            if (null === $this->advParamssScheduledForDeletion) {
                $this->advParamssScheduledForDeletion = clone $this->collAdvParamss;
                $this->advParamssScheduledForDeletion->clear();
            }
            $this->advParamssScheduledForDeletion[]= clone $advParams;
            $advParams->setAdCategoriesFields(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategoriesFields is new, it will return
     * an empty collection; or if this AdCategoriesFields has previously
     * been saved, it will retrieve related AdvParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategoriesFields.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategoriesFields is new, it will return
     * an empty collection; or if this AdCategoriesFields has previously
     * been saved, it will retrieve related AdvParamss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategoriesFields.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdvParams[] List of AdvParams objects
     */
    public function getAdvParamssJoinAdCategoriesFieldsValues($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdvParamsQuery::create(null, $criteria);
        $query->joinWith('AdCategoriesFieldsValues', $join_behavior);

        return $this->getAdvParamss($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->category_id = null;
        $this->name = null;
        $this->filter_name = null;
        $this->type = null;
        $this->sort = null;
        $this->parent_field_id = null;
        $this->helper = null;
        $this->mask = null;
        $this->postfix = null;
        $this->show_in_filter = null;
        $this->required = null;
        $this->show_in_table = null;
        $this->show_on_map = null;
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
            if ($this->collAdCategoriesFieldsValuess) {
                foreach ($this->collAdCategoriesFieldsValuess as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdvParamss) {
                foreach ($this->collAdvParamss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAdCategories instanceof Persistent) {
              $this->aAdCategories->clearAllReferences($deep);
            }
            if ($this->aAdCategoriesFieldsRelatedByParentFieldId instanceof Persistent) {
              $this->aAdCategoriesFieldsRelatedByParentFieldId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collChildsFieldss instanceof PropelCollection) {
            $this->collChildsFieldss->clearIterator();
        }
        $this->collChildsFieldss = null;
        if ($this->collAdCategoriesFieldsValuess instanceof PropelCollection) {
            $this->collAdCategoriesFieldsValuess->clearIterator();
        }
        $this->collAdCategoriesFieldsValuess = null;
        if ($this->collAdvParamss instanceof PropelCollection) {
            $this->collAdvParamss->clearIterator();
        }
        $this->collAdvParamss = null;
        $this->aAdCategories = null;
        $this->aAdCategoriesFieldsRelatedByParentFieldId = null;
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
