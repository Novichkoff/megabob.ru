<?php

namespace Admin\AdminBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\Banners;
use Admin\AdminBundle\Model\BannersPeer;
use Admin\AdminBundle\Model\BannersStatPeer;
use Admin\AdminBundle\Model\map\BannersTableMap;

abstract class BaseBannersPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'banners';

    /** the related Propel class for this table */
    const OM_CLASS = 'Admin\\AdminBundle\\Model\\Banners';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Admin\\AdminBundle\\Model\\map\\BannersTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 19;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 19;

    /** the column name for the id field */
    const ID = 'banners.id';

    /** the column name for the category_id field */
    const CATEGORY_ID = 'banners.category_id';

    /** the column name for the region_id field */
    const REGION_ID = 'banners.region_id';

    /** the column name for the client field */
    const CLIENT = 'banners.client';

    /** the column name for the name field */
    const NAME = 'banners.name';

    /** the column name for the code field */
    const CODE = 'banners.code';

    /** the column name for the picture field */
    const PICTURE = 'banners.picture';

    /** the column name for the width field */
    const WIDTH = 'banners.width';

    /** the column name for the cnt field */
    const CNT = 'banners.cnt';

    /** the column name for the show_today field */
    const SHOW_TODAY = 'banners.show_today';

    /** the column name for the click_today field */
    const CLICK_TODAY = 'banners.click_today';

    /** the column name for the banner_zone_id field */
    const BANNER_ZONE_ID = 'banners.banner_zone_id';

    /** the column name for the mobile field */
    const MOBILE = 'banners.mobile';

    /** the column name for the full_size field */
    const FULL_SIZE = 'banners.full_size';

    /** the column name for the enabled field */
    const ENABLED = 'banners.enabled';

    /** the column name for the deleted field */
    const DELETED = 'banners.deleted';

    /** the column name for the last_publish field */
    const LAST_PUBLISH = 'banners.last_publish';

    /** the column name for the publish_date field */
    const PUBLISH_DATE = 'banners.publish_date';

    /** the column name for the publish_before_date field */
    const PUBLISH_BEFORE_DATE = 'banners.publish_before_date';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Banners objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Banners[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BannersPeer::$fieldNames[BannersPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'CategoryId', 'RegionId', 'Client', 'Name', 'Code', 'Picture', 'Width', 'Cnt', 'ShowToday', 'ClickToday', 'BannerZoneId', 'Mobile', 'FullSize', 'Enabled', 'Deleted', 'LastPublish', 'PublishDate', 'PublishBeforeDate', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'categoryId', 'regionId', 'client', 'name', 'code', 'picture', 'width', 'cnt', 'showToday', 'clickToday', 'bannerZoneId', 'mobile', 'fullSize', 'enabled', 'deleted', 'lastPublish', 'publishDate', 'publishBeforeDate', ),
        BasePeer::TYPE_COLNAME => array (BannersPeer::ID, BannersPeer::CATEGORY_ID, BannersPeer::REGION_ID, BannersPeer::CLIENT, BannersPeer::NAME, BannersPeer::CODE, BannersPeer::PICTURE, BannersPeer::WIDTH, BannersPeer::CNT, BannersPeer::SHOW_TODAY, BannersPeer::CLICK_TODAY, BannersPeer::BANNER_ZONE_ID, BannersPeer::MOBILE, BannersPeer::FULL_SIZE, BannersPeer::ENABLED, BannersPeer::DELETED, BannersPeer::LAST_PUBLISH, BannersPeer::PUBLISH_DATE, BannersPeer::PUBLISH_BEFORE_DATE, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'CATEGORY_ID', 'REGION_ID', 'CLIENT', 'NAME', 'CODE', 'PICTURE', 'WIDTH', 'CNT', 'SHOW_TODAY', 'CLICK_TODAY', 'BANNER_ZONE_ID', 'MOBILE', 'FULL_SIZE', 'ENABLED', 'DELETED', 'LAST_PUBLISH', 'PUBLISH_DATE', 'PUBLISH_BEFORE_DATE', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'category_id', 'region_id', 'client', 'name', 'code', 'picture', 'width', 'cnt', 'show_today', 'click_today', 'banner_zone_id', 'mobile', 'full_size', 'enabled', 'deleted', 'last_publish', 'publish_date', 'publish_before_date', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BannersPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CategoryId' => 1, 'RegionId' => 2, 'Client' => 3, 'Name' => 4, 'Code' => 5, 'Picture' => 6, 'Width' => 7, 'Cnt' => 8, 'ShowToday' => 9, 'ClickToday' => 10, 'BannerZoneId' => 11, 'Mobile' => 12, 'FullSize' => 13, 'Enabled' => 14, 'Deleted' => 15, 'LastPublish' => 16, 'PublishDate' => 17, 'PublishBeforeDate' => 18, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'categoryId' => 1, 'regionId' => 2, 'client' => 3, 'name' => 4, 'code' => 5, 'picture' => 6, 'width' => 7, 'cnt' => 8, 'showToday' => 9, 'clickToday' => 10, 'bannerZoneId' => 11, 'mobile' => 12, 'fullSize' => 13, 'enabled' => 14, 'deleted' => 15, 'lastPublish' => 16, 'publishDate' => 17, 'publishBeforeDate' => 18, ),
        BasePeer::TYPE_COLNAME => array (BannersPeer::ID => 0, BannersPeer::CATEGORY_ID => 1, BannersPeer::REGION_ID => 2, BannersPeer::CLIENT => 3, BannersPeer::NAME => 4, BannersPeer::CODE => 5, BannersPeer::PICTURE => 6, BannersPeer::WIDTH => 7, BannersPeer::CNT => 8, BannersPeer::SHOW_TODAY => 9, BannersPeer::CLICK_TODAY => 10, BannersPeer::BANNER_ZONE_ID => 11, BannersPeer::MOBILE => 12, BannersPeer::FULL_SIZE => 13, BannersPeer::ENABLED => 14, BannersPeer::DELETED => 15, BannersPeer::LAST_PUBLISH => 16, BannersPeer::PUBLISH_DATE => 17, BannersPeer::PUBLISH_BEFORE_DATE => 18, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'CATEGORY_ID' => 1, 'REGION_ID' => 2, 'CLIENT' => 3, 'NAME' => 4, 'CODE' => 5, 'PICTURE' => 6, 'WIDTH' => 7, 'CNT' => 8, 'SHOW_TODAY' => 9, 'CLICK_TODAY' => 10, 'BANNER_ZONE_ID' => 11, 'MOBILE' => 12, 'FULL_SIZE' => 13, 'ENABLED' => 14, 'DELETED' => 15, 'LAST_PUBLISH' => 16, 'PUBLISH_DATE' => 17, 'PUBLISH_BEFORE_DATE' => 18, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'category_id' => 1, 'region_id' => 2, 'client' => 3, 'name' => 4, 'code' => 5, 'picture' => 6, 'width' => 7, 'cnt' => 8, 'show_today' => 9, 'click_today' => 10, 'banner_zone_id' => 11, 'mobile' => 12, 'full_size' => 13, 'enabled' => 14, 'deleted' => 15, 'last_publish' => 16, 'publish_date' => 17, 'publish_before_date' => 18, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
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
        $toNames = BannersPeer::getFieldNames($toType);
        $key = isset(BannersPeer::$fieldKeys[$fromType][$name]) ? BannersPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BannersPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BannersPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BannersPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. BannersPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BannersPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BannersPeer::ID);
            $criteria->addSelectColumn(BannersPeer::CATEGORY_ID);
            $criteria->addSelectColumn(BannersPeer::REGION_ID);
            $criteria->addSelectColumn(BannersPeer::CLIENT);
            $criteria->addSelectColumn(BannersPeer::NAME);
            $criteria->addSelectColumn(BannersPeer::CODE);
            $criteria->addSelectColumn(BannersPeer::PICTURE);
            $criteria->addSelectColumn(BannersPeer::WIDTH);
            $criteria->addSelectColumn(BannersPeer::CNT);
            $criteria->addSelectColumn(BannersPeer::SHOW_TODAY);
            $criteria->addSelectColumn(BannersPeer::CLICK_TODAY);
            $criteria->addSelectColumn(BannersPeer::BANNER_ZONE_ID);
            $criteria->addSelectColumn(BannersPeer::MOBILE);
            $criteria->addSelectColumn(BannersPeer::FULL_SIZE);
            $criteria->addSelectColumn(BannersPeer::ENABLED);
            $criteria->addSelectColumn(BannersPeer::DELETED);
            $criteria->addSelectColumn(BannersPeer::LAST_PUBLISH);
            $criteria->addSelectColumn(BannersPeer::PUBLISH_DATE);
            $criteria->addSelectColumn(BannersPeer::PUBLISH_BEFORE_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.region_id');
            $criteria->addSelectColumn($alias . '.client');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.code');
            $criteria->addSelectColumn($alias . '.picture');
            $criteria->addSelectColumn($alias . '.width');
            $criteria->addSelectColumn($alias . '.cnt');
            $criteria->addSelectColumn($alias . '.show_today');
            $criteria->addSelectColumn($alias . '.click_today');
            $criteria->addSelectColumn($alias . '.banner_zone_id');
            $criteria->addSelectColumn($alias . '.mobile');
            $criteria->addSelectColumn($alias . '.full_size');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.deleted');
            $criteria->addSelectColumn($alias . '.last_publish');
            $criteria->addSelectColumn($alias . '.publish_date');
            $criteria->addSelectColumn($alias . '.publish_before_date');
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
        $criteria->setPrimaryTableName(BannersPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BannersPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BannersPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Banners
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BannersPeer::doSelect($critcopy, $con);
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
        return BannersPeer::populateObjects(BannersPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BannersPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BannersPeer::DATABASE_NAME);

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
     * @param Banners $obj A Banners object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            BannersPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Banners object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Banners) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Banners object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BannersPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Banners Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BannersPeer::$instances[$key])) {
                return BannersPeer::$instances[$key];
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
        foreach (BannersPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        BannersPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to banners
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in BannersStatPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BannersStatPeer::clearInstancePool();
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
        $cls = BannersPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BannersPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BannersPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BannersPeer::addInstanceToPool($obj, $key);
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
     * @return array (Banners object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BannersPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BannersPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BannersPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BannersPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BannersPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        return Propel::getDatabaseMap(BannersPeer::DATABASE_NAME)->getTable(BannersPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBannersPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBannersPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Admin\AdminBundle\Model\map\BannersTableMap());
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
        return BannersPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Banners or Criteria object.
     *
     * @param      mixed $values Criteria or Banners object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Banners object
        }

        if ($criteria->containsKey(BannersPeer::ID) && $criteria->keyContainsValue(BannersPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BannersPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BannersPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Banners or Criteria object.
     *
     * @param      mixed $values Criteria or Banners object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BannersPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BannersPeer::ID);
            $value = $criteria->remove(BannersPeer::ID);
            if ($value) {
                $selectCriteria->add(BannersPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BannersPeer::TABLE_NAME);
            }

        } else { // $values is Banners object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BannersPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the banners table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BannersPeer::doOnDeleteCascade(new Criteria(BannersPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(BannersPeer::TABLE_NAME, $con, BannersPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BannersPeer::clearInstancePool();
            BannersPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Banners or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Banners object or primary key or array of primary keys
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
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Banners) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BannersPeer::DATABASE_NAME);
            $criteria->add(BannersPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(BannersPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += BannersPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                BannersPeer::clearInstancePool();
            } elseif ($values instanceof Banners) { // it's a model object
                BannersPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    BannersPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BannersPeer::clearRelatedInstancePool();
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
        $objects = BannersPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related BannersStat objects
            $criteria = new Criteria(BannersStatPeer::DATABASE_NAME);

            $criteria->add(BannersStatPeer::BANNER_ID, $obj->getId());
            $affectedRows += BannersStatPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given Banners object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Banners $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BannersPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BannersPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BannersPeer::DATABASE_NAME, BannersPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Banners
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BannersPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BannersPeer::DATABASE_NAME);
        $criteria->add(BannersPeer::ID, $pk);

        $v = BannersPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Banners[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BannersPeer::DATABASE_NAME);
            $criteria->add(BannersPeer::ID, $pks, Criteria::IN);
            $objs = BannersPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseBannersPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBannersPeer::buildTableMap();

