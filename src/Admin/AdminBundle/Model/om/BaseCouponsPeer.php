<?php

namespace Admin\AdminBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\CouponImagesPeer;
use Admin\AdminBundle\Model\CouponVideosPeer;
use Admin\AdminBundle\Model\Coupons;
use Admin\AdminBundle\Model\CouponsCategoriesPeer;
use Admin\AdminBundle\Model\CouponsPeer;
use Admin\AdminBundle\Model\RegionsPeer;
use Admin\AdminBundle\Model\UserCouponsPeer;
use Admin\AdminBundle\Model\map\CouponsTableMap;

abstract class BaseCouponsPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'coupons';

    /** the related Propel class for this table */
    const OM_CLASS = 'Admin\\AdminBundle\\Model\\Coupons';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Admin\\AdminBundle\\Model\\map\\CouponsTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 21;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 21;

    /** the column name for the id field */
    const ID = 'coupons.id';

    /** the column name for the category_id field */
    const CATEGORY_ID = 'coupons.category_id';

    /** the column name for the enabled field */
    const ENABLED = 'coupons.enabled';

    /** the column name for the deleted field */
    const DELETED = 'coupons.deleted';

    /** the column name for the date field */
    const DATE = 'coupons.date';

    /** the column name for the use_before field */
    const USE_BEFORE = 'coupons.use_before';

    /** the column name for the period field */
    const PERIOD = 'coupons.period';

    /** the column name for the address field */
    const ADDRESS = 'coupons.address';

    /** the column name for the phone field */
    const PHONE = 'coupons.phone';

    /** the column name for the site field */
    const SITE = 'coupons.site';

    /** the column name for the time_work field */
    const TIME_WORK = 'coupons.time_work';

    /** the column name for the client_name field */
    const CLIENT_NAME = 'coupons.client_name';

    /** the column name for the client_phone field */
    const CLIENT_PHONE = 'coupons.client_phone';

    /** the column name for the name field */
    const NAME = 'coupons.name';

    /** the column name for the description field */
    const DESCRIPTION = 'coupons.description';

    /** the column name for the full_description field */
    const FULL_DESCRIPTION = 'coupons.full_description';

    /** the column name for the price field */
    const PRICE = 'coupons.price';

    /** the column name for the sale field */
    const SALE = 'coupons.sale';

    /** the column name for the price_old field */
    const PRICE_OLD = 'coupons.price_old';

    /** the column name for the region_id field */
    const REGION_ID = 'coupons.region_id';

    /** the column name for the cnt field */
    const CNT = 'coupons.cnt';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Coupons objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Coupons[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. CouponsPeer::$fieldNames[CouponsPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'CategoryId', 'Enabled', 'Deleted', 'Date', 'UseBefore', 'Period', 'Address', 'Phone', 'Site', 'TimeWork', 'ClientName', 'ClientPhone', 'Name', 'Description', 'FullDescription', 'Price', 'Sale', 'PriceOld', 'RegionId', 'Cnt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'categoryId', 'enabled', 'deleted', 'date', 'useBefore', 'period', 'address', 'phone', 'site', 'timeWork', 'clientName', 'clientPhone', 'name', 'description', 'fullDescription', 'price', 'sale', 'priceOld', 'regionId', 'cnt', ),
        BasePeer::TYPE_COLNAME => array (CouponsPeer::ID, CouponsPeer::CATEGORY_ID, CouponsPeer::ENABLED, CouponsPeer::DELETED, CouponsPeer::DATE, CouponsPeer::USE_BEFORE, CouponsPeer::PERIOD, CouponsPeer::ADDRESS, CouponsPeer::PHONE, CouponsPeer::SITE, CouponsPeer::TIME_WORK, CouponsPeer::CLIENT_NAME, CouponsPeer::CLIENT_PHONE, CouponsPeer::NAME, CouponsPeer::DESCRIPTION, CouponsPeer::FULL_DESCRIPTION, CouponsPeer::PRICE, CouponsPeer::SALE, CouponsPeer::PRICE_OLD, CouponsPeer::REGION_ID, CouponsPeer::CNT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'CATEGORY_ID', 'ENABLED', 'DELETED', 'DATE', 'USE_BEFORE', 'PERIOD', 'ADDRESS', 'PHONE', 'SITE', 'TIME_WORK', 'CLIENT_NAME', 'CLIENT_PHONE', 'NAME', 'DESCRIPTION', 'FULL_DESCRIPTION', 'PRICE', 'SALE', 'PRICE_OLD', 'REGION_ID', 'CNT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'category_id', 'enabled', 'deleted', 'date', 'use_before', 'period', 'address', 'phone', 'site', 'time_work', 'client_name', 'client_phone', 'name', 'description', 'full_description', 'price', 'sale', 'price_old', 'region_id', 'cnt', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. CouponsPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CategoryId' => 1, 'Enabled' => 2, 'Deleted' => 3, 'Date' => 4, 'UseBefore' => 5, 'Period' => 6, 'Address' => 7, 'Phone' => 8, 'Site' => 9, 'TimeWork' => 10, 'ClientName' => 11, 'ClientPhone' => 12, 'Name' => 13, 'Description' => 14, 'FullDescription' => 15, 'Price' => 16, 'Sale' => 17, 'PriceOld' => 18, 'RegionId' => 19, 'Cnt' => 20, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'categoryId' => 1, 'enabled' => 2, 'deleted' => 3, 'date' => 4, 'useBefore' => 5, 'period' => 6, 'address' => 7, 'phone' => 8, 'site' => 9, 'timeWork' => 10, 'clientName' => 11, 'clientPhone' => 12, 'name' => 13, 'description' => 14, 'fullDescription' => 15, 'price' => 16, 'sale' => 17, 'priceOld' => 18, 'regionId' => 19, 'cnt' => 20, ),
        BasePeer::TYPE_COLNAME => array (CouponsPeer::ID => 0, CouponsPeer::CATEGORY_ID => 1, CouponsPeer::ENABLED => 2, CouponsPeer::DELETED => 3, CouponsPeer::DATE => 4, CouponsPeer::USE_BEFORE => 5, CouponsPeer::PERIOD => 6, CouponsPeer::ADDRESS => 7, CouponsPeer::PHONE => 8, CouponsPeer::SITE => 9, CouponsPeer::TIME_WORK => 10, CouponsPeer::CLIENT_NAME => 11, CouponsPeer::CLIENT_PHONE => 12, CouponsPeer::NAME => 13, CouponsPeer::DESCRIPTION => 14, CouponsPeer::FULL_DESCRIPTION => 15, CouponsPeer::PRICE => 16, CouponsPeer::SALE => 17, CouponsPeer::PRICE_OLD => 18, CouponsPeer::REGION_ID => 19, CouponsPeer::CNT => 20, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'CATEGORY_ID' => 1, 'ENABLED' => 2, 'DELETED' => 3, 'DATE' => 4, 'USE_BEFORE' => 5, 'PERIOD' => 6, 'ADDRESS' => 7, 'PHONE' => 8, 'SITE' => 9, 'TIME_WORK' => 10, 'CLIENT_NAME' => 11, 'CLIENT_PHONE' => 12, 'NAME' => 13, 'DESCRIPTION' => 14, 'FULL_DESCRIPTION' => 15, 'PRICE' => 16, 'SALE' => 17, 'PRICE_OLD' => 18, 'REGION_ID' => 19, 'CNT' => 20, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'category_id' => 1, 'enabled' => 2, 'deleted' => 3, 'date' => 4, 'use_before' => 5, 'period' => 6, 'address' => 7, 'phone' => 8, 'site' => 9, 'time_work' => 10, 'client_name' => 11, 'client_phone' => 12, 'name' => 13, 'description' => 14, 'full_description' => 15, 'price' => 16, 'sale' => 17, 'price_old' => 18, 'region_id' => 19, 'cnt' => 20, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, )
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
        $toNames = CouponsPeer::getFieldNames($toType);
        $key = isset(CouponsPeer::$fieldKeys[$fromType][$name]) ? CouponsPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(CouponsPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, CouponsPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return CouponsPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. CouponsPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(CouponsPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(CouponsPeer::ID);
            $criteria->addSelectColumn(CouponsPeer::CATEGORY_ID);
            $criteria->addSelectColumn(CouponsPeer::ENABLED);
            $criteria->addSelectColumn(CouponsPeer::DELETED);
            $criteria->addSelectColumn(CouponsPeer::DATE);
            $criteria->addSelectColumn(CouponsPeer::USE_BEFORE);
            $criteria->addSelectColumn(CouponsPeer::PERIOD);
            $criteria->addSelectColumn(CouponsPeer::ADDRESS);
            $criteria->addSelectColumn(CouponsPeer::PHONE);
            $criteria->addSelectColumn(CouponsPeer::SITE);
            $criteria->addSelectColumn(CouponsPeer::TIME_WORK);
            $criteria->addSelectColumn(CouponsPeer::CLIENT_NAME);
            $criteria->addSelectColumn(CouponsPeer::CLIENT_PHONE);
            $criteria->addSelectColumn(CouponsPeer::NAME);
            $criteria->addSelectColumn(CouponsPeer::DESCRIPTION);
            $criteria->addSelectColumn(CouponsPeer::FULL_DESCRIPTION);
            $criteria->addSelectColumn(CouponsPeer::PRICE);
            $criteria->addSelectColumn(CouponsPeer::SALE);
            $criteria->addSelectColumn(CouponsPeer::PRICE_OLD);
            $criteria->addSelectColumn(CouponsPeer::REGION_ID);
            $criteria->addSelectColumn(CouponsPeer::CNT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.deleted');
            $criteria->addSelectColumn($alias . '.date');
            $criteria->addSelectColumn($alias . '.use_before');
            $criteria->addSelectColumn($alias . '.period');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.site');
            $criteria->addSelectColumn($alias . '.time_work');
            $criteria->addSelectColumn($alias . '.client_name');
            $criteria->addSelectColumn($alias . '.client_phone');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.full_description');
            $criteria->addSelectColumn($alias . '.price');
            $criteria->addSelectColumn($alias . '.sale');
            $criteria->addSelectColumn($alias . '.price_old');
            $criteria->addSelectColumn($alias . '.region_id');
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
        $criteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CouponsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(CouponsPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Coupons
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = CouponsPeer::doSelect($critcopy, $con);
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
        return CouponsPeer::populateObjects(CouponsPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            CouponsPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

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
     * @param Coupons $obj A Coupons object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            CouponsPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Coupons object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Coupons) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Coupons object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(CouponsPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Coupons Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(CouponsPeer::$instances[$key])) {
                return CouponsPeer::$instances[$key];
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
        foreach (CouponsPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        CouponsPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to coupons
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in UserCouponsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        UserCouponsPeer::clearInstancePool();
        // Invalidate objects in CouponImagesPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CouponImagesPeer::clearInstancePool();
        // Invalidate objects in CouponVideosPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CouponVideosPeer::clearInstancePool();
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
        $cls = CouponsPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = CouponsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = CouponsPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CouponsPeer::addInstanceToPool($obj, $key);
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
     * @return array (Coupons object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = CouponsPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = CouponsPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + CouponsPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CouponsPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            CouponsPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        $criteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CouponsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CouponsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related CouponsCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCouponsCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CouponsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CouponsPeer::CATEGORY_ID, CouponsCategoriesPeer::ID, $join_behavior);

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
     * Selects a collection of Coupons objects pre-filled with their Regions objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Coupons objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRegions(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CouponsPeer::DATABASE_NAME);
        }

        CouponsPeer::addSelectColumns($criteria);
        $startcol = CouponsPeer::NUM_HYDRATE_COLUMNS;
        RegionsPeer::addSelectColumns($criteria);

        $criteria->addJoin(CouponsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CouponsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CouponsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CouponsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CouponsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Coupons) to $obj2 (Regions)
                $obj2->addCoupons($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Coupons objects pre-filled with their CouponsCategories objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Coupons objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCouponsCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CouponsPeer::DATABASE_NAME);
        }

        CouponsPeer::addSelectColumns($criteria);
        $startcol = CouponsPeer::NUM_HYDRATE_COLUMNS;
        CouponsCategoriesPeer::addSelectColumns($criteria);

        $criteria->addJoin(CouponsPeer::CATEGORY_ID, CouponsCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CouponsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CouponsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CouponsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CouponsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CouponsCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CouponsCategoriesPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CouponsCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CouponsCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Coupons) to $obj2 (CouponsCategories)
                $obj2->addCoupons($obj1);

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
        $criteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CouponsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CouponsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(CouponsPeer::CATEGORY_ID, CouponsCategoriesPeer::ID, $join_behavior);

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
     * Selects a collection of Coupons objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Coupons objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CouponsPeer::DATABASE_NAME);
        }

        CouponsPeer::addSelectColumns($criteria);
        $startcol2 = CouponsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        CouponsCategoriesPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CouponsCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CouponsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(CouponsPeer::CATEGORY_ID, CouponsCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CouponsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CouponsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CouponsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CouponsPeer::addInstanceToPool($obj1, $key1);
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
                } // if obj2 loaded

                // Add the $obj1 (Coupons) to the collection in $obj2 (Regions)
                $obj2->addCoupons($obj1);
            } // if joined row not null

            // Add objects for joined CouponsCategories rows

            $key3 = CouponsCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = CouponsCategoriesPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = CouponsCategoriesPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CouponsCategoriesPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Coupons) to the collection in $obj3 (CouponsCategories)
                $obj3->addCoupons($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
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
        $criteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CouponsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CouponsPeer::CATEGORY_ID, CouponsCategoriesPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related CouponsCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCouponsCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CouponsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CouponsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

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
     * Selects a collection of Coupons objects pre-filled with all related objects except Regions.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Coupons objects.
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
            $criteria->setDbName(CouponsPeer::DATABASE_NAME);
        }

        CouponsPeer::addSelectColumns($criteria);
        $startcol2 = CouponsPeer::NUM_HYDRATE_COLUMNS;

        CouponsCategoriesPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CouponsCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CouponsPeer::CATEGORY_ID, CouponsCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CouponsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CouponsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CouponsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CouponsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined CouponsCategories rows

                $key2 = CouponsCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = CouponsCategoriesPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = CouponsCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CouponsCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Coupons) to the collection in $obj2 (CouponsCategories)
                $obj2->addCoupons($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Coupons objects pre-filled with all related objects except CouponsCategories.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Coupons objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCouponsCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CouponsPeer::DATABASE_NAME);
        }

        CouponsPeer::addSelectColumns($criteria);
        $startcol2 = CouponsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CouponsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CouponsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CouponsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CouponsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CouponsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Coupons) to the collection in $obj2 (Regions)
                $obj2->addCoupons($obj1);

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
        return Propel::getDatabaseMap(CouponsPeer::DATABASE_NAME)->getTable(CouponsPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseCouponsPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseCouponsPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Admin\AdminBundle\Model\map\CouponsTableMap());
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
        return CouponsPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Coupons or Criteria object.
     *
     * @param      mixed $values Criteria or Coupons object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Coupons object
        }

        if ($criteria->containsKey(CouponsPeer::ID) && $criteria->keyContainsValue(CouponsPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CouponsPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Coupons or Criteria object.
     *
     * @param      mixed $values Criteria or Coupons object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(CouponsPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(CouponsPeer::ID);
            $value = $criteria->remove(CouponsPeer::ID);
            if ($value) {
                $selectCriteria->add(CouponsPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(CouponsPeer::TABLE_NAME);
            }

        } else { // $values is Coupons object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the coupons table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += CouponsPeer::doOnDeleteCascade(new Criteria(CouponsPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(CouponsPeer::TABLE_NAME, $con, CouponsPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CouponsPeer::clearInstancePool();
            CouponsPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Coupons or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Coupons object or primary key or array of primary keys
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
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Coupons) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CouponsPeer::DATABASE_NAME);
            $criteria->add(CouponsPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(CouponsPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += CouponsPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                CouponsPeer::clearInstancePool();
            } elseif ($values instanceof Coupons) { // it's a model object
                CouponsPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    CouponsPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            CouponsPeer::clearRelatedInstancePool();
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
        $objects = CouponsPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related UserCoupons objects
            $criteria = new Criteria(UserCouponsPeer::DATABASE_NAME);

            $criteria->add(UserCouponsPeer::COUPON_ID, $obj->getId());
            $affectedRows += UserCouponsPeer::doDelete($criteria, $con);

            // delete related CouponImages objects
            $criteria = new Criteria(CouponImagesPeer::DATABASE_NAME);

            $criteria->add(CouponImagesPeer::COUPON_ID, $obj->getId());
            $affectedRows += CouponImagesPeer::doDelete($criteria, $con);

            // delete related CouponVideos objects
            $criteria = new Criteria(CouponVideosPeer::DATABASE_NAME);

            $criteria->add(CouponVideosPeer::COUPON_ID, $obj->getId());
            $affectedRows += CouponVideosPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given Coupons object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Coupons $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(CouponsPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(CouponsPeer::TABLE_NAME);

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

        return BasePeer::doValidate(CouponsPeer::DATABASE_NAME, CouponsPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Coupons
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = CouponsPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(CouponsPeer::DATABASE_NAME);
        $criteria->add(CouponsPeer::ID, $pk);

        $v = CouponsPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Coupons[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(CouponsPeer::DATABASE_NAME);
            $criteria->add(CouponsPeer::ID, $pks, Criteria::IN);
            $objs = CouponsPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseCouponsPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseCouponsPeer::buildTableMap();

