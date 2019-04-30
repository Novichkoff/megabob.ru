<?php

namespace Admin\AdminBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Admin\AdminBundle\Model\JobCategoriesPeer;
use Admin\AdminBundle\Model\JobCommentsPeer;
use Admin\AdminBundle\Model\JobImagesPeer;
use Admin\AdminBundle\Model\JobPacketsPeer;
use Admin\AdminBundle\Model\JobParamsPeer;
use Admin\AdminBundle\Model\JobRestPeer;
use Admin\AdminBundle\Model\JobVideosPeer;
use Admin\AdminBundle\Model\Jobs;
use Admin\AdminBundle\Model\JobsPeer;
use Admin\AdminBundle\Model\RegionsPeer;
use Admin\AdminBundle\Model\ShopsPeer;
use Admin\AdminBundle\Model\map\JobsTableMap;
use FOS\UserBundle\Propel\UserPeer;

abstract class BaseJobsPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'jobs';

    /** the related Propel class for this table */
    const OM_CLASS = 'Admin\\AdminBundle\\Model\\Jobs';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Admin\\AdminBundle\\Model\\map\\JobsTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 24;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 24;

    /** the column name for the id field */
    const ID = 'jobs.id';

    /** the column name for the category_id field */
    const CATEGORY_ID = 'jobs.category_id';

    /** the column name for the user_id field */
    const USER_ID = 'jobs.user_id';

    /** the column name for the user_type field */
    const USER_TYPE = 'jobs.user_type';

    /** the column name for the company_name field */
    const COMPANY_NAME = 'jobs.company_name';

    /** the column name for the phone field */
    const PHONE = 'jobs.phone';

    /** the column name for the name field */
    const NAME = 'jobs.name';

    /** the column name for the description field */
    const DESCRIPTION = 'jobs.description';

    /** the column name for the dogovor field */
    const DOGOVOR = 'jobs.dogovor';

    /** the column name for the price_from field */
    const PRICE_FROM = 'jobs.price_from';

    /** the column name for the price_to field */
    const PRICE_TO = 'jobs.price_to';

    /** the column name for the resume field */
    const RESUME = 'jobs.resume';

    /** the column name for the region_id field */
    const REGION_ID = 'jobs.region_id';

    /** the column name for the area_id field */
    const AREA_ID = 'jobs.area_id';

    /** the column name for the shop_id field */
    const SHOP_ID = 'jobs.shop_id';

    /** the column name for the cnt field */
    const CNT = 'jobs.cnt';

    /** the column name for the cnt_today field */
    const CNT_TODAY = 'jobs.cnt_today';

    /** the column name for the cnt_tel field */
    const CNT_TEL = 'jobs.cnt_tel';

    /** the column name for the moder_approved field */
    const MODER_APPROVED = 'jobs.moder_approved';

    /** the column name for the enabled field */
    const ENABLED = 'jobs.enabled';

    /** the column name for the deleted field */
    const DELETED = 'jobs.deleted';

    /** the column name for the create_date field */
    const CREATE_DATE = 'jobs.create_date';

    /** the column name for the publish_date field */
    const PUBLISH_DATE = 'jobs.publish_date';

    /** the column name for the publish_before_date field */
    const PUBLISH_BEFORE_DATE = 'jobs.publish_before_date';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of Jobs objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Jobs[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. JobsPeer::$fieldNames[JobsPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'CategoryId', 'UserId', 'UserType', 'CompanyName', 'Phone', 'Name', 'Description', 'Dogovor', 'PriceFrom', 'PriceTo', 'Resume', 'RegionId', 'AreaId', 'ShopId', 'Cnt', 'CntToday', 'CntTel', 'ModerApproved', 'Enabled', 'Deleted', 'CreateDate', 'PublishDate', 'PublishBeforeDate', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'categoryId', 'userId', 'userType', 'companyName', 'phone', 'name', 'description', 'dogovor', 'priceFrom', 'priceTo', 'resume', 'regionId', 'areaId', 'shopId', 'cnt', 'cntToday', 'cntTel', 'moderApproved', 'enabled', 'deleted', 'createDate', 'publishDate', 'publishBeforeDate', ),
        BasePeer::TYPE_COLNAME => array (JobsPeer::ID, JobsPeer::CATEGORY_ID, JobsPeer::USER_ID, JobsPeer::USER_TYPE, JobsPeer::COMPANY_NAME, JobsPeer::PHONE, JobsPeer::NAME, JobsPeer::DESCRIPTION, JobsPeer::DOGOVOR, JobsPeer::PRICE_FROM, JobsPeer::PRICE_TO, JobsPeer::RESUME, JobsPeer::REGION_ID, JobsPeer::AREA_ID, JobsPeer::SHOP_ID, JobsPeer::CNT, JobsPeer::CNT_TODAY, JobsPeer::CNT_TEL, JobsPeer::MODER_APPROVED, JobsPeer::ENABLED, JobsPeer::DELETED, JobsPeer::CREATE_DATE, JobsPeer::PUBLISH_DATE, JobsPeer::PUBLISH_BEFORE_DATE, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'CATEGORY_ID', 'USER_ID', 'USER_TYPE', 'COMPANY_NAME', 'PHONE', 'NAME', 'DESCRIPTION', 'DOGOVOR', 'PRICE_FROM', 'PRICE_TO', 'RESUME', 'REGION_ID', 'AREA_ID', 'SHOP_ID', 'CNT', 'CNT_TODAY', 'CNT_TEL', 'MODER_APPROVED', 'ENABLED', 'DELETED', 'CREATE_DATE', 'PUBLISH_DATE', 'PUBLISH_BEFORE_DATE', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'category_id', 'user_id', 'user_type', 'company_name', 'phone', 'name', 'description', 'dogovor', 'price_from', 'price_to', 'resume', 'region_id', 'area_id', 'shop_id', 'cnt', 'cnt_today', 'cnt_tel', 'moder_approved', 'enabled', 'deleted', 'create_date', 'publish_date', 'publish_before_date', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. JobsPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CategoryId' => 1, 'UserId' => 2, 'UserType' => 3, 'CompanyName' => 4, 'Phone' => 5, 'Name' => 6, 'Description' => 7, 'Dogovor' => 8, 'PriceFrom' => 9, 'PriceTo' => 10, 'Resume' => 11, 'RegionId' => 12, 'AreaId' => 13, 'ShopId' => 14, 'Cnt' => 15, 'CntToday' => 16, 'CntTel' => 17, 'ModerApproved' => 18, 'Enabled' => 19, 'Deleted' => 20, 'CreateDate' => 21, 'PublishDate' => 22, 'PublishBeforeDate' => 23, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'categoryId' => 1, 'userId' => 2, 'userType' => 3, 'companyName' => 4, 'phone' => 5, 'name' => 6, 'description' => 7, 'dogovor' => 8, 'priceFrom' => 9, 'priceTo' => 10, 'resume' => 11, 'regionId' => 12, 'areaId' => 13, 'shopId' => 14, 'cnt' => 15, 'cntToday' => 16, 'cntTel' => 17, 'moderApproved' => 18, 'enabled' => 19, 'deleted' => 20, 'createDate' => 21, 'publishDate' => 22, 'publishBeforeDate' => 23, ),
        BasePeer::TYPE_COLNAME => array (JobsPeer::ID => 0, JobsPeer::CATEGORY_ID => 1, JobsPeer::USER_ID => 2, JobsPeer::USER_TYPE => 3, JobsPeer::COMPANY_NAME => 4, JobsPeer::PHONE => 5, JobsPeer::NAME => 6, JobsPeer::DESCRIPTION => 7, JobsPeer::DOGOVOR => 8, JobsPeer::PRICE_FROM => 9, JobsPeer::PRICE_TO => 10, JobsPeer::RESUME => 11, JobsPeer::REGION_ID => 12, JobsPeer::AREA_ID => 13, JobsPeer::SHOP_ID => 14, JobsPeer::CNT => 15, JobsPeer::CNT_TODAY => 16, JobsPeer::CNT_TEL => 17, JobsPeer::MODER_APPROVED => 18, JobsPeer::ENABLED => 19, JobsPeer::DELETED => 20, JobsPeer::CREATE_DATE => 21, JobsPeer::PUBLISH_DATE => 22, JobsPeer::PUBLISH_BEFORE_DATE => 23, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'CATEGORY_ID' => 1, 'USER_ID' => 2, 'USER_TYPE' => 3, 'COMPANY_NAME' => 4, 'PHONE' => 5, 'NAME' => 6, 'DESCRIPTION' => 7, 'DOGOVOR' => 8, 'PRICE_FROM' => 9, 'PRICE_TO' => 10, 'RESUME' => 11, 'REGION_ID' => 12, 'AREA_ID' => 13, 'SHOP_ID' => 14, 'CNT' => 15, 'CNT_TODAY' => 16, 'CNT_TEL' => 17, 'MODER_APPROVED' => 18, 'ENABLED' => 19, 'DELETED' => 20, 'CREATE_DATE' => 21, 'PUBLISH_DATE' => 22, 'PUBLISH_BEFORE_DATE' => 23, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'category_id' => 1, 'user_id' => 2, 'user_type' => 3, 'company_name' => 4, 'phone' => 5, 'name' => 6, 'description' => 7, 'dogovor' => 8, 'price_from' => 9, 'price_to' => 10, 'resume' => 11, 'region_id' => 12, 'area_id' => 13, 'shop_id' => 14, 'cnt' => 15, 'cnt_today' => 16, 'cnt_tel' => 17, 'moder_approved' => 18, 'enabled' => 19, 'deleted' => 20, 'create_date' => 21, 'publish_date' => 22, 'publish_before_date' => 23, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, )
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
        $toNames = JobsPeer::getFieldNames($toType);
        $key = isset(JobsPeer::$fieldKeys[$fromType][$name]) ? JobsPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(JobsPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, JobsPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return JobsPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. JobsPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(JobsPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(JobsPeer::ID);
            $criteria->addSelectColumn(JobsPeer::CATEGORY_ID);
            $criteria->addSelectColumn(JobsPeer::USER_ID);
            $criteria->addSelectColumn(JobsPeer::USER_TYPE);
            $criteria->addSelectColumn(JobsPeer::COMPANY_NAME);
            $criteria->addSelectColumn(JobsPeer::PHONE);
            $criteria->addSelectColumn(JobsPeer::NAME);
            $criteria->addSelectColumn(JobsPeer::DESCRIPTION);
            $criteria->addSelectColumn(JobsPeer::DOGOVOR);
            $criteria->addSelectColumn(JobsPeer::PRICE_FROM);
            $criteria->addSelectColumn(JobsPeer::PRICE_TO);
            $criteria->addSelectColumn(JobsPeer::RESUME);
            $criteria->addSelectColumn(JobsPeer::REGION_ID);
            $criteria->addSelectColumn(JobsPeer::AREA_ID);
            $criteria->addSelectColumn(JobsPeer::SHOP_ID);
            $criteria->addSelectColumn(JobsPeer::CNT);
            $criteria->addSelectColumn(JobsPeer::CNT_TODAY);
            $criteria->addSelectColumn(JobsPeer::CNT_TEL);
            $criteria->addSelectColumn(JobsPeer::MODER_APPROVED);
            $criteria->addSelectColumn(JobsPeer::ENABLED);
            $criteria->addSelectColumn(JobsPeer::DELETED);
            $criteria->addSelectColumn(JobsPeer::CREATE_DATE);
            $criteria->addSelectColumn(JobsPeer::PUBLISH_DATE);
            $criteria->addSelectColumn(JobsPeer::PUBLISH_BEFORE_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.category_id');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.user_type');
            $criteria->addSelectColumn($alias . '.company_name');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.dogovor');
            $criteria->addSelectColumn($alias . '.price_from');
            $criteria->addSelectColumn($alias . '.price_to');
            $criteria->addSelectColumn($alias . '.resume');
            $criteria->addSelectColumn($alias . '.region_id');
            $criteria->addSelectColumn($alias . '.area_id');
            $criteria->addSelectColumn($alias . '.shop_id');
            $criteria->addSelectColumn($alias . '.cnt');
            $criteria->addSelectColumn($alias . '.cnt_today');
            $criteria->addSelectColumn($alias . '.cnt_tel');
            $criteria->addSelectColumn($alias . '.moder_approved');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.deleted');
            $criteria->addSelectColumn($alias . '.create_date');
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
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(JobsPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return Jobs
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = JobsPeer::doSelect($critcopy, $con);
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
        return JobsPeer::populateObjects(JobsPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            JobsPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

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
     * @param Jobs $obj A Jobs object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            JobsPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Jobs object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Jobs) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Jobs object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(JobsPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return Jobs Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(JobsPeer::$instances[$key])) {
                return JobsPeer::$instances[$key];
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
        foreach (JobsPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        JobsPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to jobs
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in JobParamsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobParamsPeer::clearInstancePool();
        // Invalidate objects in JobImagesPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobImagesPeer::clearInstancePool();
        // Invalidate objects in JobVideosPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobVideosPeer::clearInstancePool();
        // Invalidate objects in JobPacketsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobPacketsPeer::clearInstancePool();
        // Invalidate objects in JobCommentsPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobCommentsPeer::clearInstancePool();
        // Invalidate objects in JobRestPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobRestPeer::clearInstancePool();
        // Invalidate objects in JobRestPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        JobRestPeer::clearInstancePool();
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
        $cls = JobsPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = JobsPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                JobsPeer::addInstanceToPool($obj, $key);
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
     * @return array (Jobs object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = JobsPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = JobsPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + JobsPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = JobsPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            JobsPeer::addInstanceToPool($obj, $key);
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
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related User table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related JobCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinJobCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Shops table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinShops(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

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
     * Selects a collection of Jobs objects pre-filled with their Regions objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinRegions(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol = JobsPeer::NUM_HYDRATE_COLUMNS;
        RegionsPeer::addSelectColumns($criteria);

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Jobs) to $obj2 (Regions)
                $obj2->addJobs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Jobs objects pre-filled with their User objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol = JobsPeer::NUM_HYDRATE_COLUMNS;
        UserPeer::addSelectColumns($criteria);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = UserPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Jobs) to $obj2 (User)
                $obj2->addJobs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Jobs objects pre-filled with their JobCategories objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinJobCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol = JobsPeer::NUM_HYDRATE_COLUMNS;
        JobCategoriesPeer::addSelectColumns($criteria);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = JobCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = JobCategoriesPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = JobCategoriesPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    JobCategoriesPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Jobs) to $obj2 (JobCategories)
                $obj2->addJobs($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Jobs objects pre-filled with their Shops objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinShops(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol = JobsPeer::NUM_HYDRATE_COLUMNS;
        ShopsPeer::addSelectColumns($criteria);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ShopsPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ShopsPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ShopsPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Jobs) to $obj2 (Shops)
                $obj2->addJobs($obj1);

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
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

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
     * Selects a collection of Jobs objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol2 = JobsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        JobCategoriesPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + JobCategoriesPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Jobs) to the collection in $obj2 (Regions)
                $obj2->addJobs($obj1);
            } // if joined row not null

            // Add objects for joined User rows

            $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = UserPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Jobs) to the collection in $obj3 (User)
                $obj3->addJobs($obj1);
            } // if joined row not null

            // Add objects for joined JobCategories rows

            $key4 = JobCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = JobCategoriesPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = JobCategoriesPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    JobCategoriesPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Jobs) to the collection in $obj4 (JobCategories)
                $obj4->addJobs($obj1);
            } // if joined row not null

            // Add objects for joined Shops rows

            $key5 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = ShopsPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = ShopsPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    ShopsPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (Jobs) to the collection in $obj5 (Shops)
                $obj5->addJobs($obj1);
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
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related User table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptUser(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related JobCategories table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptJobCategories(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Shops table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptShops(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(JobsPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            JobsPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

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
     * Selects a collection of Jobs objects pre-filled with all related objects except Regions.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
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
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol2 = JobsPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + UserPeer::NUM_HYDRATE_COLUMNS;

        JobCategoriesPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + JobCategoriesPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined User rows

                $key2 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = UserPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = UserPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    UserPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj2 (User)
                $obj2->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined JobCategories rows

                $key3 = JobCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = JobCategoriesPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = JobCategoriesPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    JobCategoriesPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj3 (JobCategories)
                $obj3->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key4 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ShopsPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ShopsPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ShopsPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj4 (Shops)
                $obj4->addJobs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Jobs objects pre-filled with all related objects except User.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptUser(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol2 = JobsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        JobCategoriesPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + JobCategoriesPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Jobs) to the collection in $obj2 (Regions)
                $obj2->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined JobCategories rows

                $key3 = JobCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = JobCategoriesPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = JobCategoriesPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    JobCategoriesPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj3 (JobCategories)
                $obj3->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key4 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ShopsPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ShopsPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ShopsPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj4 (Shops)
                $obj4->addJobs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Jobs objects pre-filled with all related objects except JobCategories.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptJobCategories(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol2 = JobsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        ShopsPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ShopsPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::SHOP_ID, ShopsPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Jobs) to the collection in $obj2 (Regions)
                $obj2->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = UserPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj3 (User)
                $obj3->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined Shops rows

                $key4 = ShopsPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ShopsPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ShopsPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ShopsPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj4 (Shops)
                $obj4->addJobs($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Jobs objects pre-filled with all related objects except Shops.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Jobs objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptShops(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(JobsPeer::DATABASE_NAME);
        }

        JobsPeer::addSelectColumns($criteria);
        $startcol2 = JobsPeer::NUM_HYDRATE_COLUMNS;

        RegionsPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + RegionsPeer::NUM_HYDRATE_COLUMNS;

        UserPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + UserPeer::NUM_HYDRATE_COLUMNS;

        JobCategoriesPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + JobCategoriesPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(JobsPeer::REGION_ID, RegionsPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::USER_ID, UserPeer::ID, $join_behavior);

        $criteria->addJoin(JobsPeer::CATEGORY_ID, JobCategoriesPeer::ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = JobsPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = JobsPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = JobsPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                JobsPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Jobs) to the collection in $obj2 (Regions)
                $obj2->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined User rows

                $key3 = UserPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = UserPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = UserPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    UserPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj3 (User)
                $obj3->addJobs($obj1);

            } // if joined row is not null

                // Add objects for joined JobCategories rows

                $key4 = JobCategoriesPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = JobCategoriesPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = JobCategoriesPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    JobCategoriesPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Jobs) to the collection in $obj4 (JobCategories)
                $obj4->addJobs($obj1);

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
        return Propel::getDatabaseMap(JobsPeer::DATABASE_NAME)->getTable(JobsPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseJobsPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseJobsPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Admin\AdminBundle\Model\map\JobsTableMap());
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
        return JobsPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Jobs or Criteria object.
     *
     * @param      mixed $values Criteria or Jobs object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Jobs object
        }

        if ($criteria->containsKey(JobsPeer::ID) && $criteria->keyContainsValue(JobsPeer::ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.JobsPeer::ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Jobs or Criteria object.
     *
     * @param      mixed $values Criteria or Jobs object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(JobsPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(JobsPeer::ID);
            $value = $criteria->remove(JobsPeer::ID);
            if ($value) {
                $selectCriteria->add(JobsPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(JobsPeer::TABLE_NAME);
            }

        } else { // $values is Jobs object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the jobs table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += JobsPeer::doOnDeleteCascade(new Criteria(JobsPeer::DATABASE_NAME), $con);
            $affectedRows += BasePeer::doDeleteAll(JobsPeer::TABLE_NAME, $con, JobsPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            JobsPeer::clearInstancePool();
            JobsPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Jobs or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Jobs object or primary key or array of primary keys
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
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Jobs) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(JobsPeer::DATABASE_NAME);
            $criteria->add(JobsPeer::ID, (array) $values, Criteria::IN);
        }

        // Set the correct dbName
        $criteria->setDbName(JobsPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            // cloning the Criteria in case it's modified by doSelect() or doSelectStmt()
            $c = clone $criteria;
            $affectedRows += JobsPeer::doOnDeleteCascade($c, $con);

            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            if ($values instanceof Criteria) {
                JobsPeer::clearInstancePool();
            } elseif ($values instanceof Jobs) { // it's a model object
                JobsPeer::removeInstanceFromPool($values);
            } else { // it's a primary key, or an array of pks
                foreach ((array) $values as $singleval) {
                    JobsPeer::removeInstanceFromPool($singleval);
                }
            }

            $affectedRows += BasePeer::doDelete($criteria, $con);
            JobsPeer::clearRelatedInstancePool();
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
        $objects = JobsPeer::doSelect($criteria, $con);
        foreach ($objects as $obj) {


            // delete related JobParams objects
            $criteria = new Criteria(JobParamsPeer::DATABASE_NAME);

            $criteria->add(JobParamsPeer::JOB_ID, $obj->getId());
            $affectedRows += JobParamsPeer::doDelete($criteria, $con);

            // delete related JobImages objects
            $criteria = new Criteria(JobImagesPeer::DATABASE_NAME);

            $criteria->add(JobImagesPeer::JOB_ID, $obj->getId());
            $affectedRows += JobImagesPeer::doDelete($criteria, $con);

            // delete related JobVideos objects
            $criteria = new Criteria(JobVideosPeer::DATABASE_NAME);

            $criteria->add(JobVideosPeer::JOB_ID, $obj->getId());
            $affectedRows += JobVideosPeer::doDelete($criteria, $con);

            // delete related JobPackets objects
            $criteria = new Criteria(JobPacketsPeer::DATABASE_NAME);

            $criteria->add(JobPacketsPeer::JOB_ID, $obj->getId());
            $affectedRows += JobPacketsPeer::doDelete($criteria, $con);

            // delete related JobComments objects
            $criteria = new Criteria(JobCommentsPeer::DATABASE_NAME);

            $criteria->add(JobCommentsPeer::JOB_ID, $obj->getId());
            $affectedRows += JobCommentsPeer::doDelete($criteria, $con);

            // delete related JobRest objects
            $criteria = new Criteria(JobRestPeer::DATABASE_NAME);

            $criteria->add(JobRestPeer::JOB_ID, $obj->getId());
            $affectedRows += JobRestPeer::doDelete($criteria, $con);

            // delete related JobRest objects
            $criteria = new Criteria(JobRestPeer::DATABASE_NAME);

            $criteria->add(JobRestPeer::VACANCY_ID, $obj->getId());
            $affectedRows += JobRestPeer::doDelete($criteria, $con);
        }

        return $affectedRows;
    }

    /**
     * Validates all modified columns of given Jobs object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param Jobs $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(JobsPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(JobsPeer::TABLE_NAME);

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

        return BasePeer::doValidate(JobsPeer::DATABASE_NAME, JobsPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Jobs
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = JobsPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(JobsPeer::DATABASE_NAME);
        $criteria->add(JobsPeer::ID, $pk);

        $v = JobsPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Jobs[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(JobsPeer::DATABASE_NAME);
            $criteria->add(JobsPeer::ID, $pks, Criteria::IN);
            $objs = JobsPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseJobsPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseJobsPeer::buildTableMap();

