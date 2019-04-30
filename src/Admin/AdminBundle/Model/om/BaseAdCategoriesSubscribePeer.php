<?php

namespace Admin\AdminBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\AdCategoriesPeer;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribePeer;
use Admin\AdminBundle\Model\AreasPeer;
use Admin\AdminBundle\Model\RegionsPeer;
use Admin\AdminBundle\Model\map\AdCategoriesSubscribeTableMap;

abstract class BaseAdCategoriesSubscribePeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'ad_categories_subscribe';

    /** the related Propel class for this table */
    const OM_CLASS = 'Admin\\AdminBundle\\Model\\AdCategoriesSubscribe';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Admin\\AdminBundle\\Model\\map\\AdCategoriesSubscribeTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 8;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    /** the column name for the id field */
    const ID = 'ad_categories_subscribe.id';

    /** the column name for the category_id field */
    const CATEGORY_ID = 'ad_categories_subscribe.category_id';

    /** the column name for the town_id field */
    const TOWN_ID = 'ad_categories_subscribe.town_id';

    /** the column name for the area_id field */
    const AREA_ID = 'ad_categories_subscribe.area_id';

    /** the column name for the email field */
    const EMAIL = 'ad_categories_subscribe.email';

    /** the column name for the unsubscribe_code field */
    const UNSUBSCRIBE_CODE = 'ad_categories_subscribe.unsubscribe_code';

    /** the column name for the last_adv_id field */
    const LAST_ADV_ID = 'ad_categories_subscribe.last_adv_id';

    /** the column name for the cnt field */
    const CNT = 'ad_categories_subscribe.cnt';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of AdCategoriesSubscribe objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array AdCategoriesSubscribe[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. AdCategoriesSubscribePeer::$fieldNames[AdCategoriesSubscribePeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'CategoryId', 'TownId', 'AreaId', 'Email', 'UnsubscribeCode', 'LastAdvId', 'Cnt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'categoryId', 'townId', 'areaId', 'email', 'unsubscribeCode', 'lastAdvId', 'cnt', ),
        BasePeer::TYPE_COLNAME => array (AdCategoriesSubscribePeer::ID, AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesSubscribePeer::TOWN_ID, AdCategoriesSubscribePeer::AREA_ID, AdCategoriesSubscribePeer::EMAIL, AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE, AdCategoriesSubscribePeer::LAST_ADV_ID, AdCategoriesSubscribePeer::CNT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'CATEGORY_ID', 'TOWN_ID', 'AREA_ID', 'EMAIL', 'UNSUBSCRIBE_CODE', 'LAST_ADV_ID', 'CNT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'category_id', 'town_id', 'area_id', 'email', 'unsubscribe_code', 'last_adv_id', 'cnt', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. AdCategoriesSubscribePeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CategoryId' => 1, 'TownId' => 2, 'AreaId' => 3, 'Email' => 4, 'UnsubscribeCode' => 5, 'LastAdvId' => 6, 'Cnt' => 7, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'categoryId' => 1, 'townId' => 2, 'areaId' => 3, 'email' => 4, 'unsubscribeCode' => 5, 'lastAdvId' => 6, 'cnt' => 7, ),
        BasePeer::TYPE_COLNAME => array (AdCategoriesSubscribePeer::ID => 0, AdCategoriesSubscribePeer::CATEGORY_ID => 1, AdCategoriesSubscribePeer::TOWN_ID => 2, AdCategoriesSubscribePeer::AREA_ID => 3, AdCategoriesSubscribePeer::EMAIL => 4, AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE => 5, AdCategoriesSubscribePeer::LAST_ADV_ID => 6, AdCategoriesSubscribePeer::CNT => 7, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'CATEGORY_ID' => 1, 'TOWN_ID' => 2, 'AREA_ID' => 3, 'EMAIL' => 4, 'UNSUBSCRIBE_CODE' => 5, 'LAST_ADV_ID' => 6, 'CNT' => 7, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'category_id' => 1, 'town_id' => 2, 'area_id' => 3, 'email' => 4, 'unsubscribe_code' => 5, 'last_adv_id' => 6, 'cnt' => 7, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
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
        $toNames = AdCategoriesSubscribePeer::getFieldNames($toType);
        $key = isset(AdCategoriesSubscribePeer::$fieldKeys[$fromType][$name]) ? AdCategoriesSubscribePeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(AdCategoriesSubscribePeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, AdCategoriesSubscribePeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return AdCategoriesSubscribePeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. AdCategoriesSubscribePeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(AdCategoriesSubscribePeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::ID);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::CATEGORY_ID);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::TOWN_ID);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::AREA_ID);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::EMAIL);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::LAST_ADV_ID);
            $criteria->addSelectColumn(AdCategoriesSubscribePeer::CNT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.town_id');
            $criteria->addSelectColumn($alias . '.area_id');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.unsubscribe_code');
            $criteria->addSelectColumn($alias . '.last_adv_id');
            $criteria->addSelectColumn($alias . '.cnt');
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
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return AdCategoriesSubscribe
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = AdCategoriesSubscribePeer::doSelect($critcopy, $con);
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
        return AdCategoriesSubscribePeer::populateObjects(AdCategoriesSubscribePeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

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
     * @param AdCategoriesSubscribe $obj A AdCategoriesSubscribe object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            AdCategoriesSubscribePeer::$instances[$key] = $obj;
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
     * @param      mixed $value A AdCategoriesSubscribe object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof AdCategoriesSubscribe) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or AdCategoriesSubscribe object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(AdCategoriesSubscribePeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return AdCategoriesSubscribe Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(AdCategoriesSubscribePeer::$instances[$key])) {
                return AdCategoriesSubscribePeer::$instances[$key];
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
        foreach (AdCategoriesSubscribePeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        AdCategoriesSubscribePeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to ad_categories_subscribe
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
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
        $cls = AdCategoriesSubscribePeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = AdCategoriesSubscribePeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AdCategoriesSubscribePeer::addInstanceToPool($obj, $key);
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
     * @return array (AdCategoriesSubscribe object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = AdCategoriesSubscribePeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AdCategoriesSubscribePeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            AdCategoriesSubscribePeer::addInstanceToPool($obj, $key);
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
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Regions table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinRegions(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Areas table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAreas(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);

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
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with their AdCategories objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAdCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;
        AdCategoriesPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AdCategoriesSubscribe) to $obj2 (AdCategories)
                $obj2->addAdCategoriesSubscribe($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with their Regions objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRegions(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;
        RegionsPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = RegionsPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AdCategoriesSubscribe) to $obj2 (Regions)
                $obj2->addAdCategoriesSubscribe($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with their Areas objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAreas(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;
        AreasPeer::addSelectColumns($criteria);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AreasPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AreasPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AreasPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (AdCategoriesSubscribe) to $obj2 (Areas)
                $obj2->addAdCategoriesSubscribe($obj1);

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
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);

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
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + AreasPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj2 (AdCategories)
                $obj2->addAdCategoriesSubscribe($obj1);
            } // if joined row not null

            // Add objects for joined Regions rows

            $key3 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = RegionsPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = RegionsPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    RegionsPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj3 (Regions)
                $obj3->addAdCategoriesSubscribe($obj1);
            } // if joined row not null

            // Add objects for joined Areas rows

            $key4 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = AreasPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = AreasPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    AreasPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj4 (Areas)
                $obj4->addAdCategoriesSubscribe($obj1);
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
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Regions table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptRegions(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Areas table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAreas(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            AdCategoriesSubscribePeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

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
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with all related objects except AdCategories.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
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
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AreasPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Regions rows

                $key2 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = RegionsPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = RegionsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    RegionsPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj2 (Regions)
                $obj2->addAdCategoriesSubscribe($obj1);

            } // if joined row is not null

                // Add objects for joined Areas rows

                $key3 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AreasPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AreasPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AreasPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj3 (Areas)
                $obj3->addAdCategoriesSubscribe($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with all related objects except Regions.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptRegions(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        AreasPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AreasPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::AREA_ID, AreasPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj2 (AdCategories)
                $obj2->addAdCategoriesSubscribe($obj1);

            } // if joined row is not null

                // Add objects for joined Areas rows

                $key3 = AreasPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AreasPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AreasPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AreasPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj3 (Areas)
                $obj3->addAdCategoriesSubscribe($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of AdCategoriesSubscribe objects pre-filled with all related objects except Areas.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of AdCategoriesSubscribe objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAreas(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);
        }

        AdCategoriesSubscribePeer::addSelectColumns($criteria);
        $startcol2 = AdCategoriesSubscribePeer::NUM_HYDRATE_COLUMNS;

        AdCategoriesPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AdCategoriesPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(AdCategoriesSubscribePeer::CATEGORY_ID, AdCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(AdCategoriesSubscribePeer::TOWN_ID, RegionsPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = AdCategoriesSubscribePeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = AdCategoriesSubscribePeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = AdCategoriesSubscribePeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                AdCategoriesSubscribePeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj2 (AdCategories)
                $obj2->addAdCategoriesSubscribe($obj1);

            } // if joined row is not null

                // Add objects for joined Regions rows

                $key3 = RegionsPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = RegionsPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = RegionsPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    RegionsPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (AdCategoriesSubscribe) to the collection in $obj3 (Regions)
                $obj3->addAdCategoriesSubscribe($obj1);

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
        return Propel::getDatabaseMap(AdCategoriesSubscribePeer::DATABASE_NAME)->getTable(AdCategoriesSubscribePeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseAdCategoriesSubscribePeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseAdCategoriesSubscribePeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Admin\AdminBundle\Model\map\AdCategoriesSubscribeTableMap());
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
        return AdCategoriesSubscribePeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a AdCategoriesSubscribe or Criteria object.
     *
     * @param      mixed $values Criteria or AdCategoriesSubscribe object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from AdCategoriesSubscribe object
        }

        if ($criteria->containsKey(AdCategoriesSubscribePeer::ID) && $criteria->keyContainsValue(AdCategoriesSubscribePeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AdCategoriesSubscribePeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a AdCategoriesSubscribe or Criteria object.
     *
     * @param      mixed $values Criteria or AdCategoriesSubscribe object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(AdCategoriesSubscribePeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(AdCategoriesSubscribePeer::ID);
            $value = $criteria->remove(AdCategoriesSubscribePeer::ID);
            if ($value) {
                $selectCriteria->add(AdCategoriesSubscribePeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(AdCategoriesSubscribePeer::TABLE_NAME);
            }

        } else { // $values is AdCategoriesSubscribe object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the ad_categories_subscribe table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(AdCategoriesSubscribePeer::TABLE_NAME, $con, AdCategoriesSubscribePeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AdCategoriesSubscribePeer::clearInstancePool();
            AdCategoriesSubscribePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a AdCategoriesSubscribe or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or AdCategoriesSubscribe object or primary key or array of primary keys
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
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            AdCategoriesSubscribePeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof AdCategoriesSubscribe) { // it's a model object
            // invalidate the cache for this single object
            AdCategoriesSubscribePeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AdCategoriesSubscribePeer::DATABASE_NAME);
            $criteria->add(AdCategoriesSubscribePeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                AdCategoriesSubscribePeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(AdCategoriesSubscribePeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            AdCategoriesSubscribePeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given AdCategoriesSubscribe object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param AdCategoriesSubscribe $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(AdCategoriesSubscribePeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(AdCategoriesSubscribePeer::TABLE_NAME);

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

        return BasePeer::doValidate(AdCategoriesSubscribePeer::DATABASE_NAME, AdCategoriesSubscribePeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return AdCategoriesSubscribe
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = AdCategoriesSubscribePeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(AdCategoriesSubscribePeer::DATABASE_NAME);
        $criteria->add(AdCategoriesSubscribePeer::ID, $pk);

        $v = AdCategoriesSubscribePeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return AdCategoriesSubscribe[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(AdCategoriesSubscribePeer::DATABASE_NAME);
            $criteria->add(AdCategoriesSubscribePeer::ID, $pks, Criteria::IN);
            $objs = AdCategoriesSubscribePeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseAdCategoriesSubscribePeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseAdCategoriesSubscribePeer::buildTableMap();

