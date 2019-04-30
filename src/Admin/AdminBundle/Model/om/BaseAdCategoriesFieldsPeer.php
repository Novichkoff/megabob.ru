<?php

namespace Admin\AdminBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\AdCategoriesFields;
use Admin\AdminBundle\Model\AdCategoriesFieldsPeer;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesPeer;
use Admin\AdminBundle\Model\AdCategoriesPeer;
use Admin\AdminBundle\Model\AdvParamsPeer;
use Admin\AdminBundle\Model\map\AdCategoriesFieldsTableMap;

abstract class BaseAdCategoriesFieldsPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'ad_categories_fields';

    /** the related Propel class for this table */
    const OM_CLASS = 'Admin\\AdminBundle\\Model\\AdCategoriesFields';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Admin\\AdminBundle\\Model\\map\\AdCategoriesFieldsTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 17;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 17;

    /** the column name for the id field */
    const ID = 'ad_categories_fields.id';

    /** the column name for the category_id field */
    const CATEGORY_ID = 'ad_categories_fields.category_id';

    /** the column name for the name field */
    const NAME = 'ad_categories_fields.name';

    /** the column name for the filter_name field */
    const FILTER_NAME = 'ad_categories_fields.filter_name';

    /** the column name for the type field */
    const TYPE = 'ad_categories_fields.type';

    /** the column name for the sort field */
    const SORT = 'ad_categories_fields.sort';

    /** the column name for the parent_field_id field */
    const PARENT_FIELD_ID = 'ad_categories_fields.parent_field_id';

    /** the column name for the helper field */
    const HELPER = 'ad_categories_fields.helper';

    /** the column name for the mask field */
    const MASK = 'ad_categories_fields.mask';

    /** the column name for the postfix field */
    const POSTFIX = 'ad_categories_fields.postfix';

    /** the column name for the show_in_filter field */
    const SHOW_IN_FILTER = 'ad_categories_fields.show_in_filter';

    /** the column name for the required field */
    const REQUIRED = 'ad_categories_fields.required';

    /** the column name for the show_in_table field */
    const SHOW_IN_TABLE = 'ad_categories_fields.show_in_table';

    /** the column name for the show_on_map field */
    const SHOW_ON_MAP = 'ad_categories_fields.show_on_map';

    /** the column name for the enabled field */
    const ENABLED = 'ad_categories_fields.enabled';

    /** the column name for the listing field */
    const LISTING = 'ad_categories_fields.listing';

    /** the column name for the deleted field */
    const DELETED = 'ad_categories_fields.deleted';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of AdCategoriesFields objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array AdCategoriesFields[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AdCategoriesFieldsPeer::$fieldNames[AdCategoriesFieldsPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'CategoryId', 'Name', 'FilterName', 'Type', 'Sort', 'ParentFieldId', 'Helper', 'Mask', 'Postfix', 'ShowInFilter', 'Required', 'ShowInTable', 'ShowOnMap', 'Enabled', 'Listing', 'Deleted', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'categoryId', 'name', 'filterName', 'type', 'sort', 'parentFieldId', 'helper', 'mask', 'postfix', 'showInFilter', 'required', 'showInTable', 'showOnMap', 'enabled', 'listing', 'deleted', ),
        BasePeer::TYPE_COLNAME => array (AdCategoriesFieldsPeer::ID, AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesFieldsPeer::NAME, AdCategoriesFieldsPeer::FILTER_NAME, AdCategoriesFieldsPeer::TYPE, AdCategoriesFieldsPeer::SORT, AdCategoriesFieldsPeer::PARENT_FIELD_ID, AdCategoriesFieldsPeer::HELPER, AdCategoriesFieldsPeer::MASK, AdCategoriesFieldsPeer::POSTFIX, AdCategoriesFieldsPeer::SHOW_IN_FILTER, AdCategoriesFieldsPeer::REQUIRED, AdCategoriesFieldsPeer::SHOW_IN_TABLE, AdCategoriesFieldsPeer::SHOW_ON_MAP, AdCategoriesFieldsPeer::ENABLED, AdCategoriesFieldsPeer::LISTING, AdCategoriesFieldsPeer::DELETED, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'CATEGORY_ID', 'NAME', 'FILTER_NAME', 'TYPE', 'SORT', 'PARENT_FIELD_ID', 'HELPER', 'MASK', 'POSTFIX', 'SHOW_IN_FILTER', 'REQUIRED', 'SHOW_IN_TABLE', 'SHOW_ON_MAP', 'ENABLED', 'LISTING', 'DELETED', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'category_id', 'name', 'filter_name', 'type', 'sort', 'parent_field_id', 'helper', 'mask', 'postfix', 'show_in_filter', 'required', 'show_in_table', 'show_on_map', 'enabled', 'listing', 'deleted', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AdCategoriesFieldsPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CategoryId' => 1, 'Name' => 2, 'FilterName' => 3, 'Type' => 4, 'Sort' => 5, 'ParentFieldId' => 6, 'Helper' => 7, 'Mask' => 8, 'Postfix' => 9, 'ShowInFilter' => 10, 'Required' => 11, 'ShowInTable' => 12, 'ShowOnMap' => 13, 'Enabled' => 14, 'Listing' => 15, 'Deleted' => 16, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'categoryId' => 1, 'name' => 2, 'filterName' => 3, 'type' => 4, 'sort' => 5, 'parentFieldId' => 6, 'helper' => 7, 'mask' => 8, 'postfix' => 9, 'showInFilter' => 10, 'required' => 11, 'showInTable' => 12, 'showOnMap' => 13, 'enabled' => 14, 'listing' => 15, 'deleted' => 16, ),
        BasePeer::TYPE_COLNAME => array (AdCategoriesFieldsPeer::ID => 0, AdCategoriesFieldsPeer::CATEGORY_ID => 1, AdCategoriesFieldsPeer::NAME => 2, AdCategoriesFieldsPeer::FILTER_NAME => 3, AdCategoriesFieldsPeer::TYPE => 4, AdCategoriesFieldsPeer::SORT => 5, AdCategoriesFieldsPeer::PARENT_FIELD_ID => 6, AdCategoriesFieldsPeer::HELPER => 7, AdCategoriesFieldsPeer::MASK => 8, AdCategoriesFieldsPeer::POSTFIX => 9, AdCategoriesFieldsPeer::SHOW_IN_FILTER => 10, AdCategoriesFieldsPeer::REQUIRED => 11, AdCategoriesFieldsPeer::SHOW_IN_TABLE => 12, AdCategoriesFieldsPeer::SHOW_ON_MAP => 13, AdCategoriesFieldsPeer::ENABLED => 14, AdCategoriesFieldsPeer::LISTING => 15, AdCategoriesFieldsPeer::DELETED => 16, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'CATEGORY_ID' => 1, 'NAME' => 2, 'FILTER_NAME' => 3, 'TYPE' => 4, 'SORT' => 5, 'PARENT_FIELD_ID' => 6, 'HELPER' => 7, 'MASK' => 8, 'POSTFIX' => 9, 'SHOW_IN_FILTER' => 10, 'REQUIRED' => 11, 'SHOW_IN_TABLE' => 12, 'SHOW_ON_MAP' => 13, 'ENABLED' => 14, 'LISTING' => 15, 'DELETED' => 16, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'category_id' => 1, 'name' => 2, 'filter_name' => 3, 'type' => 4, 'sort' => 5, 'parent_field_id' => 6, 'helper' => 7, 'mask' => 8, 'postfix' => 9, 'show_in_filter' => 10, 'required' => 11, 'show_in_table' => 12, 'show_on_map' => 13, 'enabled' => 14, 'listing' => 15, 'deleted' => 16, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = AdCategoriesFieldsPeer::getFieldNames($toType);
        $key = isset(AdCategoriesFieldsPeer::$fieldKeys[$fromType][$name]) ? AdCategoriesFieldsPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AdCategoriesFieldsPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, AdCategoriesFieldsPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AdCategoriesFieldsPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. AdCategoriesFieldsPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AdCategoriesFieldsPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::ID);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::CATEGORY_ID);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::NAME);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::FILTER_NAME);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::TYPE);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::SORT);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::PARENT_FIELD_ID);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::HELPER);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::MASK);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::POSTFIX);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::SHOW_IN_FILTER);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::REQUIRED);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::SHOW_IN_TABLE);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::SHOW_ON_MAP);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::ENABLED);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::LISTING);
            $criteria->addSelectColumn(AdCategoriesFieldsPeer::DELETED);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.filter_name');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.sort');
            $criteria->addSelectColumn($alias . '.parent_field_id');
            $criteria->addSelectColumn($alias . '.helper');
            $criteria->addSelectColumn($alias . '.mask');
            $criteria->addSelectColumn($alias . '.postfix');
            $criteria->addSelectColumn($alias . '.show_in_filter');
            $criteria->addSelectColumn($alias . '.required');
            $criteria->addSelectColumn($alias . '.show_in_table');
            $criteria->addSelectColumn($alias . '.show_on_map');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.listing');
            $criteria->addSelectColumn($alias . '.deleted');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesFieldsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesFieldsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return AdCategoriesFields
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AdCategoriesFieldsPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return AdCategoriesFieldsPeer::populateObjects(AdCategoriesFieldsPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AdCategoriesFieldsPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param AdCategoriesFields $obj A AdCategoriesFields object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            AdCategoriesFieldsPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A AdCategoriesFields object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof AdCategoriesFields) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AdCategoriesFields object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AdCategoriesFieldsPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return AdCategoriesFields Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AdCategoriesFieldsPeer::$instances[$key])) {
                return AdCategoriesFieldsPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (AdCategoriesFieldsPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        AdCategoriesFieldsPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to ad_categories_fields
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in AdCategoriesFieldsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdCategoriesFieldsPeer::clearInstancePool();
        // Invalidate objects in AdCategoriesFieldsValuesPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdCategoriesFieldsValuesPeer::clearInstancePool();
        // Invalidate objects in AdvParamsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AdvParamsPeer::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = AdCategoriesFieldsPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AdCategoriesFieldsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AdCategoriesFieldsPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdCategoriesFieldsPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (AdCategoriesFields object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AdCategoriesFieldsPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AdCategoriesFieldsPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AdCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdCategoriesFieldsPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AdCategoriesFieldsPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related AdCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAdCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesFieldsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesFieldsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of AdCategoriesFields objects pre-filled with their AdCategories objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesFields objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAdCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);
        }

        AdCategoriesFieldsPeer::addSelectColumns($criteria);
        $startcol = AdCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS;
        AdCategoriesPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesFieldsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesFieldsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdCategoriesFieldsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesFieldsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AdCategoriesPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AdCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AdCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AdCategoriesFields) to $obj2 (AdCategories)
                $obj2->addAdCategoriesFields($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesFieldsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesFieldsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of AdCategoriesFields objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesFields objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);
        }

        AdCategoriesFieldsPeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesFieldsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesFieldsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesFieldsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesFieldsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined AdCategories rows

            $key2 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AdCategoriesPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AdCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AdCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (AdCategoriesFields) to the collection in $obj2 (AdCategories)
                $obj2->addAdCategoriesFields($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AdCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAdCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesFieldsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesFieldsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related AdCategoriesFieldsRelatedByParentFieldId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAdCategoriesFieldsRelatedByParentFieldId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesFieldsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesFieldsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of AdCategoriesFields objects pre-filled with all related objects except AdCategories.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesFields objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAdCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);
        }

        AdCategoriesFieldsPeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesFieldsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesFieldsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesFieldsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesFieldsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AdCategoriesFields objects pre-filled with all related objects except AdCategoriesFieldsRelatedByParentFieldId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesFields objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAdCategoriesFieldsRelatedByParentFieldId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);
        }

        AdCategoriesFieldsPeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesFieldsPeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdCategoriesFieldsPeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesFieldsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesFieldsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesFieldsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesFieldsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined AdCategories rows

                $key2 = AdCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AdCategoriesPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AdCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AdCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AdCategoriesFields) to the collection in $obj2 (AdCategories)
                $obj2->addAdCategoriesFields($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(AdCategoriesFieldsPeer::DATABASE_NAME)->getTable(AdCategoriesFieldsPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAdCategoriesFieldsPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAdCategoriesFieldsPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Admin\AdminBundle\Model\map\AdCategoriesFieldsTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return AdCategoriesFieldsPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a AdCategoriesFields or Criteria object.
     *
     * @param      mixed $values Criteria or AdCategoriesFields object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from AdCategoriesFields object
        }

        if ($criteria->containsKey(AdCategoriesFieldsPeer::ID) && $criteria->keyContainsValue(AdCategoriesFieldsPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AdCategoriesFieldsPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a AdCategoriesFields or Criteria object.
     *
     * @param      mixed $values Criteria or AdCategoriesFields object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AdCategoriesFieldsPeer::ID);
            $value = $criteria->remove(AdCategoriesFieldsPeer::ID);
            if ($value) {
                $selectCriteria->add(AdCategoriesFieldsPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AdCategoriesFieldsPeer::TABLE_NAME);
            }

        } else { // $values is AdCategoriesFields object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the ad_categories_fields table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += AdCategoriesFieldsPeer::doOnDeleteCascade(new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(AdCategoriesFieldsPeer::TABLE_NAME, $con, AdCategoriesFieldsPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdCategoriesFieldsPeer::clearInstancePool();
            AdCategoriesFieldsPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a AdCategoriesFields or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or AdCategoriesFields object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof AdCategoriesFields) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);
            $criteria->add(AdCategoriesFieldsPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesFieldsPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += AdCategoriesFieldsPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                AdCategoriesFieldsPeer::clearInstancePool();
            } elseif ($values instanceof AdCategoriesFields) { // it's a model object
                AdCategoriesFieldsPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    AdCategoriesFieldsPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AdCategoriesFieldsPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * This is a method for emulating ON DELETE CASCADE for DBs that don't support this
     * feature (like MySQL or SQLite).
     *
     * This method is not very speedy because it must perform a query first to get
     * the implicated records and then perform the deletes by calling those Peer classes.
     *
     * This method should be used within a transaction if possible.
     *
     * @param      Criteria $criteria
     * @param      PropelPDO $con
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    protected static function doOnDeleteCascade(Criteria $criteria, PropelPDO $con)
    {
        // initialize var to track total num of affected rows
        $affectedRows = 0;

        // first find the objects that are implicated by the $criteria
        $objects = AdCategoriesFieldsPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related AdCategoriesFields objects
            $criteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);

            $criteria->add(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $obj->getId());
            $affectedRows += AdCategoriesFieldsPeer::doDelete($criteria, $con);

            // delete related AdCategoriesFieldsValues objects
            $criteria = new Criteria(AdCategoriesFieldsValuesPeer::DATABASE_NAME);

            $criteria->add(AdCategoriesFieldsValuesPeer::FIELD_ID, $obj->getId());
            $affectedRows += AdCategoriesFieldsValuesPeer::doDelete($criteria, $con);

            // delete related AdvParams objects
            $criteria = new Criteria(AdvParamsPeer::DATABASE_NAME);

            $criteria->add(AdvParamsPeer::FIELD_ID, $obj->getId());
            $affectedRows += AdvParamsPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given AdCategoriesFields object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param AdCategoriesFields $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AdCategoriesFieldsPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AdCategoriesFieldsPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(AdCategoriesFieldsPeer::DATABASE_NAME, AdCategoriesFieldsPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return AdCategoriesFields
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AdCategoriesFieldsPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);
        $criteria->add(AdCategoriesFieldsPeer::ID, $pk);

        $v = AdCategoriesFieldsPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return AdCategoriesFields[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AdCategoriesFieldsPeer::DATABASE_NAME);
            $criteria->add(AdCategoriesFieldsPeer::ID, $pks, Criteria::IN);
            $objs = AdCategoriesFieldsPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAdCategoriesFieldsPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAdCategoriesFieldsPeer::buildTableMap();

