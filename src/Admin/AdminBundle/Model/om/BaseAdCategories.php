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
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesPeer;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsQuery;

abstract class BaseAdCategories extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Admin\\AdminBundle\\Model\\AdCategoriesPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AdCategoriesPeer
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
     * The value for the direct_title field.
     * @var        string
     */
    protected $direct_title;

    /**
     * The value for the text field.
     * @var        string
     */
    protected $text;

    /**
     * The value for the icon field.
     * @var        string
     */
    protected $icon;

    /**
     * The value for the generator field.
     * @var        string
     */
    protected $generator;

    /**
     * The value for the nametitle field.
     * @var        string
     */
    protected $nametitle;

    /**
     * The value for the desctitle field.
     * @var        string
     */
    protected $desctitle;

    /**
     * The value for the pricetitle field.
     * @var        string
     */
    protected $pricetitle;

    /**
     * The value for the use_dogovor field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $use_dogovor;

    /**
     * The value for the use_torg field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $use_torg;

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
     * @var        AdCategories
     */
    protected $aAdCategoriesRelatedByParentId;

    /**
     * @var        PropelObjectCollection|AdCategories[] Collection to store aggregation of AdCategories objects.
     */
    protected $collAdChildss;
    protected $collAdChildssPartial;

    /**
     * @var        PropelObjectCollection|AdCategoriesFields[] Collection to store aggregation of AdCategoriesFields objects.
     */
    protected $collAdCategoriesFieldss;
    protected $collAdCategoriesFieldssPartial;

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
    protected $adChildssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $adCategoriesFieldssScheduledForDeletion = null;

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
        $this->use_dogovor = true;
        $this->use_torg = true;
        $this->enabled = false;
        $this->deleted = false;
        $this->usemap = false;
        $this->onmain = false;
    }

    /**
     * Initializes internal state of BaseAdCategories object.
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
     * Get the [direct_title] column value.
     *
     * @return string
     */
    public function getDirectTitle()
    {

        return $this->direct_title;
    }

    /**
     * Get the [text] column value.
     *
     * @return string
     */
    public function getText()
    {

        return $this->text;
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
     * Get the [generator] column value.
     *
     * @return string
     */
    public function getGenerator()
    {

        return $this->generator;
    }

    /**
     * Get the [nametitle] column value.
     *
     * @return string
     */
    public function getNametitle()
    {

        return $this->nametitle;
    }

    /**
     * Get the [desctitle] column value.
     *
     * @return string
     */
    public function getDesctitle()
    {

        return $this->desctitle;
    }

    /**
     * Get the [pricetitle] column value.
     *
     * @return string
     */
    public function getPricetitle()
    {

        return $this->pricetitle;
    }

    /**
     * Get the [use_dogovor] column value.
     *
     * @return boolean
     */
    public function getUseDogovor()
    {

        return $this->use_dogovor;
    }

    /**
     * Get the [use_torg] column value.
     *
     * @return boolean
     */
    public function getUseTorg()
    {

        return $this->use_torg;
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
     * @return AdCategories The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [parent_id] column.
     *
     * @param  int $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setParentId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->parent_id !== $v) {
            $this->parent_id = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::PARENT_ID;
        }

        if ($this->aAdCategoriesRelatedByParentId !== null && $this->aAdCategoriesRelatedByParentId->getId() !== $v) {
            $this->aAdCategoriesRelatedByParentId = null;
        }


        return $this;
    } // setParentId()

    /**
     * Set the value of [sort] column.
     *
     * @param  int $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setSort($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->sort !== $v) {
            $this->sort = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::SORT;
        }


        return $this;
    } // setSort()

    /**
     * Set the value of [name] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [alias] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setAlias($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->alias !== $v) {
            $this->alias = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::ALIAS;
        }


        return $this;
    } // setAlias()

    /**
     * Set the value of [pagetitle] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setPagetitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pagetitle !== $v) {
            $this->pagetitle = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::PAGETITLE;
        }


        return $this;
    } // setPagetitle()

    /**
     * Set the value of [catch_phrase] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setCatchPhrase($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->catch_phrase !== $v) {
            $this->catch_phrase = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::CATCH_PHRASE;
        }


        return $this;
    } // setCatchPhrase()

    /**
     * Set the value of [direct_title] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setDirectTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->direct_title !== $v) {
            $this->direct_title = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::DIRECT_TITLE;
        }


        return $this;
    } // setDirectTitle()

    /**
     * Set the value of [text] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::TEXT;
        }


        return $this;
    } // setText()

    /**
     * Set the value of [icon] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setIcon($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->icon !== $v) {
            $this->icon = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::ICON;
        }


        return $this;
    } // setIcon()

    /**
     * Set the value of [generator] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setGenerator($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->generator !== $v) {
            $this->generator = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::GENERATOR;
        }


        return $this;
    } // setGenerator()

    /**
     * Set the value of [nametitle] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setNametitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nametitle !== $v) {
            $this->nametitle = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::NAMETITLE;
        }


        return $this;
    } // setNametitle()

    /**
     * Set the value of [desctitle] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setDesctitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->desctitle !== $v) {
            $this->desctitle = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::DESCTITLE;
        }


        return $this;
    } // setDesctitle()

    /**
     * Set the value of [pricetitle] column.
     *
     * @param  string $v new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setPricetitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->pricetitle !== $v) {
            $this->pricetitle = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::PRICETITLE;
        }


        return $this;
    } // setPricetitle()

    /**
     * Sets the value of the [use_dogovor] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setUseDogovor($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->use_dogovor !== $v) {
            $this->use_dogovor = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::USE_DOGOVOR;
        }


        return $this;
    } // setUseDogovor()

    /**
     * Sets the value of the [use_torg] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategories The current object (for fluent API support)
     */
    public function setUseTorg($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->use_torg !== $v) {
            $this->use_torg = $v;
            $this->modifiedColumns[] = AdCategoriesPeer::USE_TORG;
        }


        return $this;
    } // setUseTorg()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return AdCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesPeer::ENABLED;
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
     * @return AdCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesPeer::DELETED;
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
     * @return AdCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesPeer::USEMAP;
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
     * @return AdCategories The current object (for fluent API support)
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
            $this->modifiedColumns[] = AdCategoriesPeer::ONMAIN;
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
            if ($this->use_dogovor !== true) {
                return false;
            }

            if ($this->use_torg !== true) {
                return false;
            }

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
            $this->sort = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->alias = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->pagetitle = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->catch_phrase = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->direct_title = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->text = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->icon = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->generator = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->nametitle = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->desctitle = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->pricetitle = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->use_dogovor = ($row[$startcol + 14] !== null) ? (boolean) $row[$startcol + 14] : null;
            $this->use_torg = ($row[$startcol + 15] !== null) ? (boolean) $row[$startcol + 15] : null;
            $this->enabled = ($row[$startcol + 16] !== null) ? (boolean) $row[$startcol + 16] : null;
            $this->deleted = ($row[$startcol + 17] !== null) ? (boolean) $row[$startcol + 17] : null;
            $this->usemap = ($row[$startcol + 18] !== null) ? (boolean) $row[$startcol + 18] : null;
            $this->onmain = ($row[$startcol + 19] !== null) ? (boolean) $row[$startcol + 19] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 20; // 20 = AdCategoriesPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AdCategories object", $e);
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

        if ($this->aAdCategoriesRelatedByParentId !== null && $this->parent_id !== $this->aAdCategoriesRelatedByParentId->getId()) {
            $this->aAdCategoriesRelatedByParentId = null;
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
            $con = Propel::getConnection(AdCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AdCategoriesPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAdCategoriesRelatedByParentId = null;
            $this->collAdChildss = null;

            $this->collAdCategoriesFieldss = null;

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
            $con = Propel::getConnection(AdCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AdCategoriesQuery::create()
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
            $con = Propel::getConnection(AdCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AdCategoriesPeer::addInstanceToPool($this);
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

            if ($this->aAdCategoriesRelatedByParentId !== null) {
                if ($this->aAdCategoriesRelatedByParentId->isModified() || $this->aAdCategoriesRelatedByParentId->isNew()) {
                    $affectedRows += $this->aAdCategoriesRelatedByParentId->save($con);
                }
                $this->setAdCategoriesRelatedByParentId($this->aAdCategoriesRelatedByParentId);
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

            if ($this->adChildssScheduledForDeletion !== null) {
                if (!$this->adChildssScheduledForDeletion->isEmpty()) {
                    AdCategoriesQuery::create()
                        ->filterByPrimaryKeys($this->adChildssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adChildssScheduledForDeletion = null;
                }
            }

            if ($this->collAdChildss !== null) {
                foreach ($this->collAdChildss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->adCategoriesFieldssScheduledForDeletion !== null) {
                if (!$this->adCategoriesFieldssScheduledForDeletion->isEmpty()) {
                    AdCategoriesFieldsQuery::create()
                        ->filterByPrimaryKeys($this->adCategoriesFieldssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->adCategoriesFieldssScheduledForDeletion = null;
                }
            }

            if ($this->collAdCategoriesFieldss !== null) {
                foreach ($this->collAdCategoriesFieldss as $referrerFK) {
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

        $this->modifiedColumns[] = AdCategoriesPeer::ID;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AdCategoriesPeer::ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AdCategoriesPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::PARENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '`parent_id`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::SORT)) {
            $modifiedColumns[':p' . $index++]  = '`sort`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '`name`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::ALIAS)) {
            $modifiedColumns[':p' . $index++]  = '`alias`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::PAGETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`pagetitle`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::CATCH_PHRASE)) {
            $modifiedColumns[':p' . $index++]  = '`catch_phrase`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::DIRECT_TITLE)) {
            $modifiedColumns[':p' . $index++]  = '`direct_title`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::TEXT)) {
            $modifiedColumns[':p' . $index++]  = '`text`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::ICON)) {
            $modifiedColumns[':p' . $index++]  = '`icon`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::GENERATOR)) {
            $modifiedColumns[':p' . $index++]  = '`generator`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::NAMETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`nametitle`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::DESCTITLE)) {
            $modifiedColumns[':p' . $index++]  = '`desctitle`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::PRICETITLE)) {
            $modifiedColumns[':p' . $index++]  = '`pricetitle`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::USE_DOGOVOR)) {
            $modifiedColumns[':p' . $index++]  = '`use_dogovor`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::USE_TORG)) {
            $modifiedColumns[':p' . $index++]  = '`use_torg`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::DELETED)) {
            $modifiedColumns[':p' . $index++]  = '`deleted`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::USEMAP)) {
            $modifiedColumns[':p' . $index++]  = '`usemap`';
        }
        if ($this->isColumnModified(AdCategoriesPeer::ONMAIN)) {
            $modifiedColumns[':p' . $index++]  = '`onmain`';
        }

        $sql = sprintf(
            'INSERT INTO `ad_categories` (%s) VALUES (%s)',
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
                    case '`sort`':
                        $stmt->bindValue($identifier, $this->sort, PDO::PARAM_INT);
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
                    case '`direct_title`':
                        $stmt->bindValue($identifier, $this->direct_title, PDO::PARAM_STR);
                        break;
                    case '`text`':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case '`icon`':
                        $stmt->bindValue($identifier, $this->icon, PDO::PARAM_STR);
                        break;
                    case '`generator`':
                        $stmt->bindValue($identifier, $this->generator, PDO::PARAM_STR);
                        break;
                    case '`nametitle`':
                        $stmt->bindValue($identifier, $this->nametitle, PDO::PARAM_STR);
                        break;
                    case '`desctitle`':
                        $stmt->bindValue($identifier, $this->desctitle, PDO::PARAM_STR);
                        break;
                    case '`pricetitle`':
                        $stmt->bindValue($identifier, $this->pricetitle, PDO::PARAM_STR);
                        break;
                    case '`use_dogovor`':
                        $stmt->bindValue($identifier, (int) $this->use_dogovor, PDO::PARAM_INT);
                        break;
                    case '`use_torg`':
                        $stmt->bindValue($identifier, (int) $this->use_torg, PDO::PARAM_INT);
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

            if ($this->aAdCategoriesRelatedByParentId !== null) {
                if (!$this->aAdCategoriesRelatedByParentId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAdCategoriesRelatedByParentId->getValidationFailures());
                }
            }


            if (($retval = AdCategoriesPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAdChildss !== null) {
                    foreach ($this->collAdChildss as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAdCategoriesFieldss !== null) {
                    foreach ($this->collAdCategoriesFieldss as $referrerFK) {
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
        $pos = AdCategoriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getSort();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getAlias();
                break;
            case 5:
                return $this->getPagetitle();
                break;
            case 6:
                return $this->getCatchPhrase();
                break;
            case 7:
                return $this->getDirectTitle();
                break;
            case 8:
                return $this->getText();
                break;
            case 9:
                return $this->getIcon();
                break;
            case 10:
                return $this->getGenerator();
                break;
            case 11:
                return $this->getNametitle();
                break;
            case 12:
                return $this->getDesctitle();
                break;
            case 13:
                return $this->getPricetitle();
                break;
            case 14:
                return $this->getUseDogovor();
                break;
            case 15:
                return $this->getUseTorg();
                break;
            case 16:
                return $this->getEnabled();
                break;
            case 17:
                return $this->getDeleted();
                break;
            case 18:
                return $this->getUsemap();
                break;
            case 19:
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
        if (isset($alreadyDumpedObjects['AdCategories'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AdCategories'][$this->getPrimaryKey()] = true;
        $keys = AdCategoriesPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getParentId(),
            $keys[2] => $this->getSort(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getAlias(),
            $keys[5] => $this->getPagetitle(),
            $keys[6] => $this->getCatchPhrase(),
            $keys[7] => $this->getDirectTitle(),
            $keys[8] => $this->getText(),
            $keys[9] => $this->getIcon(),
            $keys[10] => $this->getGenerator(),
            $keys[11] => $this->getNametitle(),
            $keys[12] => $this->getDesctitle(),
            $keys[13] => $this->getPricetitle(),
            $keys[14] => $this->getUseDogovor(),
            $keys[15] => $this->getUseTorg(),
            $keys[16] => $this->getEnabled(),
            $keys[17] => $this->getDeleted(),
            $keys[18] => $this->getUsemap(),
            $keys[19] => $this->getOnmain(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aAdCategoriesRelatedByParentId) {
                $result['AdCategoriesRelatedByParentId'] = $this->aAdCategoriesRelatedByParentId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAdChildss) {
                $result['AdChildss'] = $this->collAdChildss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAdCategoriesFieldss) {
                $result['AdCategoriesFieldss'] = $this->collAdCategoriesFieldss->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AdCategoriesPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setSort($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setAlias($value);
                break;
            case 5:
                $this->setPagetitle($value);
                break;
            case 6:
                $this->setCatchPhrase($value);
                break;
            case 7:
                $this->setDirectTitle($value);
                break;
            case 8:
                $this->setText($value);
                break;
            case 9:
                $this->setIcon($value);
                break;
            case 10:
                $this->setGenerator($value);
                break;
            case 11:
                $this->setNametitle($value);
                break;
            case 12:
                $this->setDesctitle($value);
                break;
            case 13:
                $this->setPricetitle($value);
                break;
            case 14:
                $this->setUseDogovor($value);
                break;
            case 15:
                $this->setUseTorg($value);
                break;
            case 16:
                $this->setEnabled($value);
                break;
            case 17:
                $this->setDeleted($value);
                break;
            case 18:
                $this->setUsemap($value);
                break;
            case 19:
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
        $keys = AdCategoriesPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setParentId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setSort($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAlias($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPagetitle($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setCatchPhrase($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDirectTitle($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setText($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setIcon($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setGenerator($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setNametitle($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setDesctitle($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setPricetitle($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setUseDogovor($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setUseTorg($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setEnabled($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setDeleted($arr[$keys[17]]);
        if (array_key_exists($keys[18], $arr)) $this->setUsemap($arr[$keys[18]]);
        if (array_key_exists($keys[19], $arr)) $this->setOnmain($arr[$keys[19]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AdCategoriesPeer::DATABASE_NAME);

        if ($this->isColumnModified(AdCategoriesPeer::ID)) $criteria->add(AdCategoriesPeer::ID, $this->id);
        if ($this->isColumnModified(AdCategoriesPeer::PARENT_ID)) $criteria->add(AdCategoriesPeer::PARENT_ID, $this->parent_id);
        if ($this->isColumnModified(AdCategoriesPeer::SORT)) $criteria->add(AdCategoriesPeer::SORT, $this->sort);
        if ($this->isColumnModified(AdCategoriesPeer::NAME)) $criteria->add(AdCategoriesPeer::NAME, $this->name);
        if ($this->isColumnModified(AdCategoriesPeer::ALIAS)) $criteria->add(AdCategoriesPeer::ALIAS, $this->alias);
        if ($this->isColumnModified(AdCategoriesPeer::PAGETITLE)) $criteria->add(AdCategoriesPeer::PAGETITLE, $this->pagetitle);
        if ($this->isColumnModified(AdCategoriesPeer::CATCH_PHRASE)) $criteria->add(AdCategoriesPeer::CATCH_PHRASE, $this->catch_phrase);
        if ($this->isColumnModified(AdCategoriesPeer::DIRECT_TITLE)) $criteria->add(AdCategoriesPeer::DIRECT_TITLE, $this->direct_title);
        if ($this->isColumnModified(AdCategoriesPeer::TEXT)) $criteria->add(AdCategoriesPeer::TEXT, $this->text);
        if ($this->isColumnModified(AdCategoriesPeer::ICON)) $criteria->add(AdCategoriesPeer::ICON, $this->icon);
        if ($this->isColumnModified(AdCategoriesPeer::GENERATOR)) $criteria->add(AdCategoriesPeer::GENERATOR, $this->generator);
        if ($this->isColumnModified(AdCategoriesPeer::NAMETITLE)) $criteria->add(AdCategoriesPeer::NAMETITLE, $this->nametitle);
        if ($this->isColumnModified(AdCategoriesPeer::DESCTITLE)) $criteria->add(AdCategoriesPeer::DESCTITLE, $this->desctitle);
        if ($this->isColumnModified(AdCategoriesPeer::PRICETITLE)) $criteria->add(AdCategoriesPeer::PRICETITLE, $this->pricetitle);
        if ($this->isColumnModified(AdCategoriesPeer::USE_DOGOVOR)) $criteria->add(AdCategoriesPeer::USE_DOGOVOR, $this->use_dogovor);
        if ($this->isColumnModified(AdCategoriesPeer::USE_TORG)) $criteria->add(AdCategoriesPeer::USE_TORG, $this->use_torg);
        if ($this->isColumnModified(AdCategoriesPeer::ENABLED)) $criteria->add(AdCategoriesPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(AdCategoriesPeer::DELETED)) $criteria->add(AdCategoriesPeer::DELETED, $this->deleted);
        if ($this->isColumnModified(AdCategoriesPeer::USEMAP)) $criteria->add(AdCategoriesPeer::USEMAP, $this->usemap);
        if ($this->isColumnModified(AdCategoriesPeer::ONMAIN)) $criteria->add(AdCategoriesPeer::ONMAIN, $this->onmain);

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
        $criteria = new Criteria(AdCategoriesPeer::DATABASE_NAME);
        $criteria->add(AdCategoriesPeer::ID, $this->id);

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
     * @param object $copyObj An object of AdCategories (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setParentId($this->getParentId());
        $copyObj->setSort($this->getSort());
        $copyObj->setName($this->getName());
        $copyObj->setAlias($this->getAlias());
        $copyObj->setPagetitle($this->getPagetitle());
        $copyObj->setCatchPhrase($this->getCatchPhrase());
        $copyObj->setDirectTitle($this->getDirectTitle());
        $copyObj->setText($this->getText());
        $copyObj->setIcon($this->getIcon());
        $copyObj->setGenerator($this->getGenerator());
        $copyObj->setNametitle($this->getNametitle());
        $copyObj->setDesctitle($this->getDesctitle());
        $copyObj->setPricetitle($this->getPricetitle());
        $copyObj->setUseDogovor($this->getUseDogovor());
        $copyObj->setUseTorg($this->getUseTorg());
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

            foreach ($this->getAdChildss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdChilds($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAdCategoriesFieldss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAdCategoriesFields($relObj->copy($deepCopy));
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
     * @return AdCategories Clone of current object.
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
     * @return AdCategoriesPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AdCategoriesPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a AdCategories object.
     *
     * @param                  AdCategories $v
     * @return AdCategories The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAdCategoriesRelatedByParentId(AdCategories $v = null)
    {
        if ($v === null) {
            $this->setParentId(NULL);
        } else {
            $this->setParentId($v->getId());
        }

        $this->aAdCategoriesRelatedByParentId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the AdCategories object, it will not be re-added.
        if ($v !== null) {
            $v->addAdChilds($this);
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
    public function getAdCategoriesRelatedByParentId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAdCategoriesRelatedByParentId === null && ($this->parent_id !== null) && $doQuery) {
            $this->aAdCategoriesRelatedByParentId = AdCategoriesQuery::create()->findPk($this->parent_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAdCategoriesRelatedByParentId->addAdChildss($this);
             */
        }

        return $this->aAdCategoriesRelatedByParentId;
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
        if ('AdChilds' == $relationName) {
            $this->initAdChildss();
        }
        if ('AdCategoriesFields' == $relationName) {
            $this->initAdCategoriesFieldss();
        }
        if ('AdCategoriesSubscribe' == $relationName) {
            $this->initAdCategoriesSubscribes();
        }
        if ('Advs' == $relationName) {
            $this->initAdvss();
        }
    }

    /**
     * Clears out the collAdChildss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategories The current object (for fluent API support)
     * @see        addAdChildss()
     */
    public function clearAdChildss()
    {
        $this->collAdChildss = null; // important to set this to null since that means it is uninitialized
        $this->collAdChildssPartial = null;

        return $this;
    }

    /**
     * reset is the collAdChildss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdChildss($v = true)
    {
        $this->collAdChildssPartial = $v;
    }

    /**
     * Initializes the collAdChildss collection.
     *
     * By default this just sets the collAdChildss collection to an empty array (like clearcollAdChildss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdChildss($overrideExisting = true)
    {
        if (null !== $this->collAdChildss && !$overrideExisting) {
            return;
        }
        $this->collAdChildss = new PropelObjectCollection();
        $this->collAdChildss->setModel('AdCategories');
    }

    /**
     * Gets an array of AdCategories objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this AdCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdCategories[] List of AdCategories objects
     * @throws PropelException
     */
    public function getAdChildss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdChildssPartial && !$this->isNew();
        if (null === $this->collAdChildss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdChildss) {
                // return empty collection
                $this->initAdChildss();
            } else {
                $collAdChildss = AdCategoriesQuery::create(null, $criteria)
                    ->filterByAdCategoriesRelatedByParentId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdChildssPartial && count($collAdChildss)) {
                      $this->initAdChildss(false);

                      foreach ($collAdChildss as $obj) {
                        if (false == $this->collAdChildss->contains($obj)) {
                          $this->collAdChildss->append($obj);
                        }
                      }

                      $this->collAdChildssPartial = true;
                    }

                    $collAdChildss->getInternalIterator()->rewind();

                    return $collAdChildss;
                }

                if ($partial && $this->collAdChildss) {
                    foreach ($this->collAdChildss as $obj) {
                        if ($obj->isNew()) {
                            $collAdChildss[] = $obj;
                        }
                    }
                }

                $this->collAdChildss = $collAdChildss;
                $this->collAdChildssPartial = false;
            }
        }

        return $this->collAdChildss;
    }

    /**
     * Sets a collection of AdChilds objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $adChildss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return AdCategories The current object (for fluent API support)
     */
    public function setAdChildss(PropelCollection $adChildss, PropelPDO $con = null)
    {
        $adChildssToDelete = $this->getAdChildss(new Criteria(), $con)->diff($adChildss);


        $this->adChildssScheduledForDeletion = $adChildssToDelete;

        foreach ($adChildssToDelete as $adChildsRemoved) {
            $adChildsRemoved->setAdCategoriesRelatedByParentId(null);
        }

        $this->collAdChildss = null;
        foreach ($adChildss as $adChilds) {
            $this->addAdChilds($adChilds);
        }

        $this->collAdChildss = $adChildss;
        $this->collAdChildssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AdCategories objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AdCategories objects.
     * @throws PropelException
     */
    public function countAdChildss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdChildssPartial && !$this->isNew();
        if (null === $this->collAdChildss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdChildss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdChildss());
            }
            $query = AdCategoriesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdCategoriesRelatedByParentId($this)
                ->count($con);
        }

        return count($this->collAdChildss);
    }

    /**
     * Method called to associate a AdCategories object to this object
     * through the AdCategories foreign key attribute.
     *
     * @param    AdCategories $l AdCategories
     * @return AdCategories The current object (for fluent API support)
     */
    public function addAdChilds(AdCategories $l)
    {
        if ($this->collAdChildss === null) {
            $this->initAdChildss();
            $this->collAdChildssPartial = true;
        }

        if (!in_array($l, $this->collAdChildss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdChilds($l);

            if ($this->adChildssScheduledForDeletion and $this->adChildssScheduledForDeletion->contains($l)) {
                $this->adChildssScheduledForDeletion->remove($this->adChildssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdChilds $adChilds The adChilds object to add.
     */
    protected function doAddAdChilds($adChilds)
    {
        $this->collAdChildss[]= $adChilds;
        $adChilds->setAdCategoriesRelatedByParentId($this);
    }

    /**
     * @param	AdChilds $adChilds The adChilds object to remove.
     * @return AdCategories The current object (for fluent API support)
     */
    public function removeAdChilds($adChilds)
    {
        if ($this->getAdChildss()->contains($adChilds)) {
            $this->collAdChildss->remove($this->collAdChildss->search($adChilds));
            if (null === $this->adChildssScheduledForDeletion) {
                $this->adChildssScheduledForDeletion = clone $this->collAdChildss;
                $this->adChildssScheduledForDeletion->clear();
            }
            $this->adChildssScheduledForDeletion[]= $adChilds;
            $adChilds->setAdCategoriesRelatedByParentId(null);
        }

        return $this;
    }

    /**
     * Clears out the collAdCategoriesFieldss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategories The current object (for fluent API support)
     * @see        addAdCategoriesFieldss()
     */
    public function clearAdCategoriesFieldss()
    {
        $this->collAdCategoriesFieldss = null; // important to set this to null since that means it is uninitialized
        $this->collAdCategoriesFieldssPartial = null;

        return $this;
    }

    /**
     * reset is the collAdCategoriesFieldss collection loaded partially
     *
     * @return void
     */
    public function resetPartialAdCategoriesFieldss($v = true)
    {
        $this->collAdCategoriesFieldssPartial = $v;
    }

    /**
     * Initializes the collAdCategoriesFieldss collection.
     *
     * By default this just sets the collAdCategoriesFieldss collection to an empty array (like clearcollAdCategoriesFieldss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAdCategoriesFieldss($overrideExisting = true)
    {
        if (null !== $this->collAdCategoriesFieldss && !$overrideExisting) {
            return;
        }
        $this->collAdCategoriesFieldss = new PropelObjectCollection();
        $this->collAdCategoriesFieldss->setModel('AdCategoriesFields');
    }

    /**
     * Gets an array of AdCategoriesFields objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this AdCategories is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AdCategoriesFields[] List of AdCategoriesFields objects
     * @throws PropelException
     */
    public function getAdCategoriesFieldss($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAdCategoriesFieldssPartial && !$this->isNew();
        if (null === $this->collAdCategoriesFieldss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAdCategoriesFieldss) {
                // return empty collection
                $this->initAdCategoriesFieldss();
            } else {
                $collAdCategoriesFieldss = AdCategoriesFieldsQuery::create(null, $criteria)
                    ->filterByAdCategories($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAdCategoriesFieldssPartial && count($collAdCategoriesFieldss)) {
                      $this->initAdCategoriesFieldss(false);

                      foreach ($collAdCategoriesFieldss as $obj) {
                        if (false == $this->collAdCategoriesFieldss->contains($obj)) {
                          $this->collAdCategoriesFieldss->append($obj);
                        }
                      }

                      $this->collAdCategoriesFieldssPartial = true;
                    }

                    $collAdCategoriesFieldss->getInternalIterator()->rewind();

                    return $collAdCategoriesFieldss;
                }

                if ($partial && $this->collAdCategoriesFieldss) {
                    foreach ($this->collAdCategoriesFieldss as $obj) {
                        if ($obj->isNew()) {
                            $collAdCategoriesFieldss[] = $obj;
                        }
                    }
                }

                $this->collAdCategoriesFieldss = $collAdCategoriesFieldss;
                $this->collAdCategoriesFieldssPartial = false;
            }
        }

        return $this->collAdCategoriesFieldss;
    }

    /**
     * Sets a collection of AdCategoriesFields objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $adCategoriesFieldss A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return AdCategories The current object (for fluent API support)
     */
    public function setAdCategoriesFieldss(PropelCollection $adCategoriesFieldss, PropelPDO $con = null)
    {
        $adCategoriesFieldssToDelete = $this->getAdCategoriesFieldss(new Criteria(), $con)->diff($adCategoriesFieldss);


        $this->adCategoriesFieldssScheduledForDeletion = $adCategoriesFieldssToDelete;

        foreach ($adCategoriesFieldssToDelete as $adCategoriesFieldsRemoved) {
            $adCategoriesFieldsRemoved->setAdCategories(null);
        }

        $this->collAdCategoriesFieldss = null;
        foreach ($adCategoriesFieldss as $adCategoriesFields) {
            $this->addAdCategoriesFields($adCategoriesFields);
        }

        $this->collAdCategoriesFieldss = $adCategoriesFieldss;
        $this->collAdCategoriesFieldssPartial = false;

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
    public function countAdCategoriesFieldss(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAdCategoriesFieldssPartial && !$this->isNew();
        if (null === $this->collAdCategoriesFieldss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAdCategoriesFieldss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAdCategoriesFieldss());
            }
            $query = AdCategoriesFieldsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAdCategories($this)
                ->count($con);
        }

        return count($this->collAdCategoriesFieldss);
    }

    /**
     * Method called to associate a AdCategoriesFields object to this object
     * through the AdCategoriesFields foreign key attribute.
     *
     * @param    AdCategoriesFields $l AdCategoriesFields
     * @return AdCategories The current object (for fluent API support)
     */
    public function addAdCategoriesFields(AdCategoriesFields $l)
    {
        if ($this->collAdCategoriesFieldss === null) {
            $this->initAdCategoriesFieldss();
            $this->collAdCategoriesFieldssPartial = true;
        }

        if (!in_array($l, $this->collAdCategoriesFieldss->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAdCategoriesFields($l);

            if ($this->adCategoriesFieldssScheduledForDeletion and $this->adCategoriesFieldssScheduledForDeletion->contains($l)) {
                $this->adCategoriesFieldssScheduledForDeletion->remove($this->adCategoriesFieldssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	AdCategoriesFields $adCategoriesFields The adCategoriesFields object to add.
     */
    protected function doAddAdCategoriesFields($adCategoriesFields)
    {
        $this->collAdCategoriesFieldss[]= $adCategoriesFields;
        $adCategoriesFields->setAdCategories($this);
    }

    /**
     * @param	AdCategoriesFields $adCategoriesFields The adCategoriesFields object to remove.
     * @return AdCategories The current object (for fluent API support)
     */
    public function removeAdCategoriesFields($adCategoriesFields)
    {
        if ($this->getAdCategoriesFieldss()->contains($adCategoriesFields)) {
            $this->collAdCategoriesFieldss->remove($this->collAdCategoriesFieldss->search($adCategoriesFields));
            if (null === $this->adCategoriesFieldssScheduledForDeletion) {
                $this->adCategoriesFieldssScheduledForDeletion = clone $this->collAdCategoriesFieldss;
                $this->adCategoriesFieldssScheduledForDeletion->clear();
            }
            $this->adCategoriesFieldssScheduledForDeletion[]= $adCategoriesFields;
            $adCategoriesFields->setAdCategories(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related AdCategoriesFieldss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AdCategoriesFields[] List of AdCategoriesFields objects
     */
    public function getAdCategoriesFieldssJoinAdCategoriesFieldsRelatedByParentFieldId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AdCategoriesFieldsQuery::create(null, $criteria);
        $query->joinWith('AdCategoriesFieldsRelatedByParentFieldId', $join_behavior);

        return $this->getAdCategoriesFieldss($query, $con);
    }

    /**
     * Clears out the collAdCategoriesSubscribes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return AdCategories The current object (for fluent API support)
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
     * If this AdCategories is new, it will return
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
                    ->filterByAdCategories($this)
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
     * @return AdCategories The current object (for fluent API support)
     */
    public function setAdCategoriesSubscribes(PropelCollection $adCategoriesSubscribes, PropelPDO $con = null)
    {
        $adCategoriesSubscribesToDelete = $this->getAdCategoriesSubscribes(new Criteria(), $con)->diff($adCategoriesSubscribes);


        $this->adCategoriesSubscribesScheduledForDeletion = $adCategoriesSubscribesToDelete;

        foreach ($adCategoriesSubscribesToDelete as $adCategoriesSubscribeRemoved) {
            $adCategoriesSubscribeRemoved->setAdCategories(null);
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
                ->filterByAdCategories($this)
                ->count($con);
        }

        return count($this->collAdCategoriesSubscribes);
    }

    /**
     * Method called to associate a AdCategoriesSubscribe object to this object
     * through the AdCategoriesSubscribe foreign key attribute.
     *
     * @param    AdCategoriesSubscribe $l AdCategoriesSubscribe
     * @return AdCategories The current object (for fluent API support)
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
        $adCategoriesSubscribe->setAdCategories($this);
    }

    /**
     * @param	AdCategoriesSubscribe $adCategoriesSubscribe The adCategoriesSubscribe object to remove.
     * @return AdCategories The current object (for fluent API support)
     */
    public function removeAdCategoriesSubscribe($adCategoriesSubscribe)
    {
        if ($this->getAdCategoriesSubscribes()->contains($adCategoriesSubscribe)) {
            $this->collAdCategoriesSubscribes->remove($this->collAdCategoriesSubscribes->search($adCategoriesSubscribe));
            if (null === $this->adCategoriesSubscribesScheduledForDeletion) {
                $this->adCategoriesSubscribesScheduledForDeletion = clone $this->collAdCategoriesSubscribes;
                $this->adCategoriesSubscribesScheduledForDeletion->clear();
            }
            $this->adCategoriesSubscribesScheduledForDeletion[]= clone $adCategoriesSubscribe;
            $adCategoriesSubscribe->setAdCategories(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related AdCategoriesSubscribes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related AdCategoriesSubscribes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
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
     * @return AdCategories The current object (for fluent API support)
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
     * If this AdCategories is new, it will return
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
                    ->filterByAdCategories($this)
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
     * @return AdCategories The current object (for fluent API support)
     */
    public function setAdvss(PropelCollection $advss, PropelPDO $con = null)
    {
        $advssToDelete = $this->getAdvss(new Criteria(), $con)->diff($advss);


        $this->advssScheduledForDeletion = $advssToDelete;

        foreach ($advssToDelete as $advsRemoved) {
            $advsRemoved->setAdCategories(null);
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
                ->filterByAdCategories($this)
                ->count($con);
        }

        return count($this->collAdvss);
    }

    /**
     * Method called to associate a Advs object to this object
     * through the Advs foreign key attribute.
     *
     * @param    Advs $l Advs
     * @return AdCategories The current object (for fluent API support)
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
        $advs->setAdCategories($this);
    }

    /**
     * @param	Advs $advs The advs object to remove.
     * @return AdCategories The current object (for fluent API support)
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
            $advs->setAdCategories(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
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
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
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
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
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
     * Otherwise if this AdCategories is new, it will return
     * an empty collection; or if this AdCategories has previously
     * been saved, it will retrieve related Advss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in AdCategories.
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
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->parent_id = null;
        $this->sort = null;
        $this->name = null;
        $this->alias = null;
        $this->pagetitle = null;
        $this->catch_phrase = null;
        $this->direct_title = null;
        $this->text = null;
        $this->icon = null;
        $this->generator = null;
        $this->nametitle = null;
        $this->desctitle = null;
        $this->pricetitle = null;
        $this->use_dogovor = null;
        $this->use_torg = null;
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
            if ($this->collAdChildss) {
                foreach ($this->collAdChildss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAdCategoriesFieldss) {
                foreach ($this->collAdCategoriesFieldss as $o) {
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
            if ($this->aAdCategoriesRelatedByParentId instanceof Persistent) {
              $this->aAdCategoriesRelatedByParentId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAdChildss instanceof PropelCollection) {
            $this->collAdChildss->clearIterator();
        }
        $this->collAdChildss = null;
        if ($this->collAdCategoriesFieldss instanceof PropelCollection) {
            $this->collAdCategoriesFieldss->clearIterator();
        }
        $this->collAdCategoriesFieldss = null;
        if ($this->collAdCategoriesSubscribes instanceof PropelCollection) {
            $this->collAdCategoriesSubscribes->clearIterator();
        }
        $this->collAdCategoriesSubscribes = null;
        if ($this->collAdvss instanceof PropelCollection) {
            $this->collAdvss->clearIterator();
        }
        $this->collAdvss = null;
        $this->aAdCategoriesRelatedByParentId = null;
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
