<?php

namespace Admin\AdminBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Admin\AdminBundle\Model\CouponImages;
use Admin\AdminBundle\Model\CouponVideos;
use Admin\AdminBundle\Model\Coupons;
use Admin\AdminBundle\Model\CouponsCategories;
use Admin\AdminBundle\Model\CouponsPeer;
use Admin\AdminBundle\Model\CouponsQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\UserCoupons;

/**
 * @method CouponsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CouponsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method CouponsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method CouponsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method CouponsQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method CouponsQuery orderByUseBefore($order = Criteria::ASC) Order by the use_before column
 * @method CouponsQuery orderByPeriod($order = Criteria::ASC) Order by the period column
 * @method CouponsQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method CouponsQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method CouponsQuery orderBySite($order = Criteria::ASC) Order by the site column
 * @method CouponsQuery orderByTimeWork($order = Criteria::ASC) Order by the time_work column
 * @method CouponsQuery orderByClientName($order = Criteria::ASC) Order by the client_name column
 * @method CouponsQuery orderByClientPhone($order = Criteria::ASC) Order by the client_phone column
 * @method CouponsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CouponsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method CouponsQuery orderByFullDescription($order = Criteria::ASC) Order by the full_description column
 * @method CouponsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method CouponsQuery orderBySale($order = Criteria::ASC) Order by the sale column
 * @method CouponsQuery orderByPriceOld($order = Criteria::ASC) Order by the price_old column
 * @method CouponsQuery orderByRegionId($order = Criteria::ASC) Order by the region_id column
 * @method CouponsQuery orderByCnt($order = Criteria::ASC) Order by the cnt column
 *
 * @method CouponsQuery groupById() Group by the id column
 * @method CouponsQuery groupByCategoryId() Group by the category_id column
 * @method CouponsQuery groupByEnabled() Group by the enabled column
 * @method CouponsQuery groupByDeleted() Group by the deleted column
 * @method CouponsQuery groupByDate() Group by the date column
 * @method CouponsQuery groupByUseBefore() Group by the use_before column
 * @method CouponsQuery groupByPeriod() Group by the period column
 * @method CouponsQuery groupByAddress() Group by the address column
 * @method CouponsQuery groupByPhone() Group by the phone column
 * @method CouponsQuery groupBySite() Group by the site column
 * @method CouponsQuery groupByTimeWork() Group by the time_work column
 * @method CouponsQuery groupByClientName() Group by the client_name column
 * @method CouponsQuery groupByClientPhone() Group by the client_phone column
 * @method CouponsQuery groupByName() Group by the name column
 * @method CouponsQuery groupByDescription() Group by the description column
 * @method CouponsQuery groupByFullDescription() Group by the full_description column
 * @method CouponsQuery groupByPrice() Group by the price column
 * @method CouponsQuery groupBySale() Group by the sale column
 * @method CouponsQuery groupByPriceOld() Group by the price_old column
 * @method CouponsQuery groupByRegionId() Group by the region_id column
 * @method CouponsQuery groupByCnt() Group by the cnt column
 *
 * @method CouponsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CouponsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CouponsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CouponsQuery leftJoinRegions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Regions relation
 * @method CouponsQuery rightJoinRegions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Regions relation
 * @method CouponsQuery innerJoinRegions($relationAlias = null) Adds a INNER JOIN clause to the query using the Regions relation
 *
 * @method CouponsQuery leftJoinCouponsCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the CouponsCategories relation
 * @method CouponsQuery rightJoinCouponsCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CouponsCategories relation
 * @method CouponsQuery innerJoinCouponsCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the CouponsCategories relation
 *
 * @method CouponsQuery leftJoinUserCoupons($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserCoupons relation
 * @method CouponsQuery rightJoinUserCoupons($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserCoupons relation
 * @method CouponsQuery innerJoinUserCoupons($relationAlias = null) Adds a INNER JOIN clause to the query using the UserCoupons relation
 *
 * @method CouponsQuery leftJoinCouponImages($relationAlias = null) Adds a LEFT JOIN clause to the query using the CouponImages relation
 * @method CouponsQuery rightJoinCouponImages($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CouponImages relation
 * @method CouponsQuery innerJoinCouponImages($relationAlias = null) Adds a INNER JOIN clause to the query using the CouponImages relation
 *
 * @method CouponsQuery leftJoinCouponVideos($relationAlias = null) Adds a LEFT JOIN clause to the query using the CouponVideos relation
 * @method CouponsQuery rightJoinCouponVideos($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CouponVideos relation
 * @method CouponsQuery innerJoinCouponVideos($relationAlias = null) Adds a INNER JOIN clause to the query using the CouponVideos relation
 *
 * @method Coupons findOne(PropelPDO $con = null) Return the first Coupons matching the query
 * @method Coupons findOneOrCreate(PropelPDO $con = null) Return the first Coupons matching the query, or a new Coupons object populated from the query conditions when no match is found
 *
 * @method Coupons findOneByCategoryId(int $category_id) Return the first Coupons filtered by the category_id column
 * @method Coupons findOneByEnabled(boolean $enabled) Return the first Coupons filtered by the enabled column
 * @method Coupons findOneByDeleted(boolean $deleted) Return the first Coupons filtered by the deleted column
 * @method Coupons findOneByDate(string $date) Return the first Coupons filtered by the date column
 * @method Coupons findOneByUseBefore(string $use_before) Return the first Coupons filtered by the use_before column
 * @method Coupons findOneByPeriod(int $period) Return the first Coupons filtered by the period column
 * @method Coupons findOneByAddress(string $address) Return the first Coupons filtered by the address column
 * @method Coupons findOneByPhone(string $phone) Return the first Coupons filtered by the phone column
 * @method Coupons findOneBySite(string $site) Return the first Coupons filtered by the site column
 * @method Coupons findOneByTimeWork(string $time_work) Return the first Coupons filtered by the time_work column
 * @method Coupons findOneByClientName(string $client_name) Return the first Coupons filtered by the client_name column
 * @method Coupons findOneByClientPhone(string $client_phone) Return the first Coupons filtered by the client_phone column
 * @method Coupons findOneByName(string $name) Return the first Coupons filtered by the name column
 * @method Coupons findOneByDescription(string $description) Return the first Coupons filtered by the description column
 * @method Coupons findOneByFullDescription(string $full_description) Return the first Coupons filtered by the full_description column
 * @method Coupons findOneByPrice(int $price) Return the first Coupons filtered by the price column
 * @method Coupons findOneBySale(int $sale) Return the first Coupons filtered by the sale column
 * @method Coupons findOneByPriceOld(int $price_old) Return the first Coupons filtered by the price_old column
 * @method Coupons findOneByRegionId(int $region_id) Return the first Coupons filtered by the region_id column
 * @method Coupons findOneByCnt(int $cnt) Return the first Coupons filtered by the cnt column
 *
 * @method array findById(int $id) Return Coupons objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return Coupons objects filtered by the category_id column
 * @method array findByEnabled(boolean $enabled) Return Coupons objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return Coupons objects filtered by the deleted column
 * @method array findByDate(string $date) Return Coupons objects filtered by the date column
 * @method array findByUseBefore(string $use_before) Return Coupons objects filtered by the use_before column
 * @method array findByPeriod(int $period) Return Coupons objects filtered by the period column
 * @method array findByAddress(string $address) Return Coupons objects filtered by the address column
 * @method array findByPhone(string $phone) Return Coupons objects filtered by the phone column
 * @method array findBySite(string $site) Return Coupons objects filtered by the site column
 * @method array findByTimeWork(string $time_work) Return Coupons objects filtered by the time_work column
 * @method array findByClientName(string $client_name) Return Coupons objects filtered by the client_name column
 * @method array findByClientPhone(string $client_phone) Return Coupons objects filtered by the client_phone column
 * @method array findByName(string $name) Return Coupons objects filtered by the name column
 * @method array findByDescription(string $description) Return Coupons objects filtered by the description column
 * @method array findByFullDescription(string $full_description) Return Coupons objects filtered by the full_description column
 * @method array findByPrice(int $price) Return Coupons objects filtered by the price column
 * @method array findBySale(int $sale) Return Coupons objects filtered by the sale column
 * @method array findByPriceOld(int $price_old) Return Coupons objects filtered by the price_old column
 * @method array findByRegionId(int $region_id) Return Coupons objects filtered by the region_id column
 * @method array findByCnt(int $cnt) Return Coupons objects filtered by the cnt column
 */
abstract class BaseCouponsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCouponsQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Admin\\AdminBundle\\Model\\Coupons';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CouponsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CouponsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CouponsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CouponsQuery) {
            return $criteria;
        }
        $query = new CouponsQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Coupons|Coupons[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CouponsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CouponsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Coupons A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Coupons A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `enabled`, `deleted`, `date`, `use_before`, `period`, `address`, `phone`, `site`, `time_work`, `client_name`, `client_phone`, `name`, `description`, `full_description`, `price`, `sale`, `price_old`, `region_id`, `cnt` FROM `coupons` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Coupons();
            $obj->hydrate($row);
            CouponsPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Coupons|Coupons[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Coupons[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CouponsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CouponsPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CouponsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CouponsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id >= 12
     * $query->filterByCategoryId(array('max' => 12)); // WHERE category_id <= 12
     * </code>
     *
     * @see       filterByCouponsCategories()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(CouponsPeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(CouponsPeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByEnabled(true); // WHERE enabled = true
     * $query->filterByEnabled('yes'); // WHERE enabled = true
     * </code>
     *
     * @param     boolean|string $enabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CouponsPeer::ENABLED, $enabled, $comparison);
    }

    /**
     * Filter the query on the deleted column
     *
     * Example usage:
     * <code>
     * $query->filterByDeleted(true); // WHERE deleted = true
     * $query->filterByDeleted('yes'); // WHERE deleted = true
     * </code>
     *
     * @param     boolean|string $deleted The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CouponsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date < '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(CouponsPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(CouponsPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the use_before column
     *
     * Example usage:
     * <code>
     * $query->filterByUseBefore('2011-03-14'); // WHERE use_before = '2011-03-14'
     * $query->filterByUseBefore('now'); // WHERE use_before = '2011-03-14'
     * $query->filterByUseBefore(array('max' => 'yesterday')); // WHERE use_before < '2011-03-13'
     * </code>
     *
     * @param     mixed $useBefore The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByUseBefore($useBefore = null, $comparison = null)
    {
        if (is_array($useBefore)) {
            $useMinMax = false;
            if (isset($useBefore['min'])) {
                $this->addUsingAlias(CouponsPeer::USE_BEFORE, $useBefore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useBefore['max'])) {
                $this->addUsingAlias(CouponsPeer::USE_BEFORE, $useBefore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::USE_BEFORE, $useBefore, $comparison);
    }

    /**
     * Filter the query on the period column
     *
     * Example usage:
     * <code>
     * $query->filterByPeriod(1234); // WHERE period = 1234
     * $query->filterByPeriod(array(12, 34)); // WHERE period IN (12, 34)
     * $query->filterByPeriod(array('min' => 12)); // WHERE period >= 12
     * $query->filterByPeriod(array('max' => 12)); // WHERE period <= 12
     * </code>
     *
     * @param     mixed $period The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByPeriod($period = null, $comparison = null)
    {
        if (is_array($period)) {
            $useMinMax = false;
            if (isset($period['min'])) {
                $this->addUsingAlias(CouponsPeer::PERIOD, $period['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($period['max'])) {
                $this->addUsingAlias(CouponsPeer::PERIOD, $period['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::PERIOD, $period, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the site column
     *
     * Example usage:
     * <code>
     * $query->filterBySite('fooValue');   // WHERE site = 'fooValue'
     * $query->filterBySite('%fooValue%'); // WHERE site LIKE '%fooValue%'
     * </code>
     *
     * @param     string $site The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterBySite($site = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($site)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $site)) {
                $site = str_replace('*', '%', $site);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::SITE, $site, $comparison);
    }

    /**
     * Filter the query on the time_work column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeWork('fooValue');   // WHERE time_work = 'fooValue'
     * $query->filterByTimeWork('%fooValue%'); // WHERE time_work LIKE '%fooValue%'
     * </code>
     *
     * @param     string $timeWork The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByTimeWork($timeWork = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($timeWork)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $timeWork)) {
                $timeWork = str_replace('*', '%', $timeWork);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::TIME_WORK, $timeWork, $comparison);
    }

    /**
     * Filter the query on the client_name column
     *
     * Example usage:
     * <code>
     * $query->filterByClientName('fooValue');   // WHERE client_name = 'fooValue'
     * $query->filterByClientName('%fooValue%'); // WHERE client_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByClientName($clientName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientName)) {
                $clientName = str_replace('*', '%', $clientName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::CLIENT_NAME, $clientName, $comparison);
    }

    /**
     * Filter the query on the client_phone column
     *
     * Example usage:
     * <code>
     * $query->filterByClientPhone('fooValue');   // WHERE client_phone = 'fooValue'
     * $query->filterByClientPhone('%fooValue%'); // WHERE client_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $clientPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByClientPhone($clientPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($clientPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $clientPhone)) {
                $clientPhone = str_replace('*', '%', $clientPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::CLIENT_PHONE, $clientPhone, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the full_description column
     *
     * Example usage:
     * <code>
     * $query->filterByFullDescription('fooValue');   // WHERE full_description = 'fooValue'
     * $query->filterByFullDescription('%fooValue%'); // WHERE full_description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fullDescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByFullDescription($fullDescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fullDescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fullDescription)) {
                $fullDescription = str_replace('*', '%', $fullDescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsPeer::FULL_DESCRIPTION, $fullDescription, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price >= 12
     * $query->filterByPrice(array('max' => 12)); // WHERE price <= 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(CouponsPeer::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(CouponsPeer::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the sale column
     *
     * Example usage:
     * <code>
     * $query->filterBySale(1234); // WHERE sale = 1234
     * $query->filterBySale(array(12, 34)); // WHERE sale IN (12, 34)
     * $query->filterBySale(array('min' => 12)); // WHERE sale >= 12
     * $query->filterBySale(array('max' => 12)); // WHERE sale <= 12
     * </code>
     *
     * @param     mixed $sale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterBySale($sale = null, $comparison = null)
    {
        if (is_array($sale)) {
            $useMinMax = false;
            if (isset($sale['min'])) {
                $this->addUsingAlias(CouponsPeer::SALE, $sale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sale['max'])) {
                $this->addUsingAlias(CouponsPeer::SALE, $sale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::SALE, $sale, $comparison);
    }

    /**
     * Filter the query on the price_old column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceOld(1234); // WHERE price_old = 1234
     * $query->filterByPriceOld(array(12, 34)); // WHERE price_old IN (12, 34)
     * $query->filterByPriceOld(array('min' => 12)); // WHERE price_old >= 12
     * $query->filterByPriceOld(array('max' => 12)); // WHERE price_old <= 12
     * </code>
     *
     * @param     mixed $priceOld The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByPriceOld($priceOld = null, $comparison = null)
    {
        if (is_array($priceOld)) {
            $useMinMax = false;
            if (isset($priceOld['min'])) {
                $this->addUsingAlias(CouponsPeer::PRICE_OLD, $priceOld['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceOld['max'])) {
                $this->addUsingAlias(CouponsPeer::PRICE_OLD, $priceOld['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::PRICE_OLD, $priceOld, $comparison);
    }

    /**
     * Filter the query on the region_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRegionId(1234); // WHERE region_id = 1234
     * $query->filterByRegionId(array(12, 34)); // WHERE region_id IN (12, 34)
     * $query->filterByRegionId(array('min' => 12)); // WHERE region_id >= 12
     * $query->filterByRegionId(array('max' => 12)); // WHERE region_id <= 12
     * </code>
     *
     * @see       filterByRegions()
     *
     * @param     mixed $regionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByRegionId($regionId = null, $comparison = null)
    {
        if (is_array($regionId)) {
            $useMinMax = false;
            if (isset($regionId['min'])) {
                $this->addUsingAlias(CouponsPeer::REGION_ID, $regionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regionId['max'])) {
                $this->addUsingAlias(CouponsPeer::REGION_ID, $regionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::REGION_ID, $regionId, $comparison);
    }

    /**
     * Filter the query on the cnt column
     *
     * Example usage:
     * <code>
     * $query->filterByCnt(1234); // WHERE cnt = 1234
     * $query->filterByCnt(array(12, 34)); // WHERE cnt IN (12, 34)
     * $query->filterByCnt(array('min' => 12)); // WHERE cnt >= 12
     * $query->filterByCnt(array('max' => 12)); // WHERE cnt <= 12
     * </code>
     *
     * @param     mixed $cnt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function filterByCnt($cnt = null, $comparison = null)
    {
        if (is_array($cnt)) {
            $useMinMax = false;
            if (isset($cnt['min'])) {
                $this->addUsingAlias(CouponsPeer::CNT, $cnt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cnt['max'])) {
                $this->addUsingAlias(CouponsPeer::CNT, $cnt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsPeer::CNT, $cnt, $comparison);
    }

    /**
     * Filter the query by a related Regions object
     *
     * @param   Regions|PropelObjectCollection $regions The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRegions($regions, $comparison = null)
    {
        if ($regions instanceof Regions) {
            return $this
                ->addUsingAlias(CouponsPeer::REGION_ID, $regions->getId(), $comparison);
        } elseif ($regions instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CouponsPeer::REGION_ID, $regions->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRegions() only accepts arguments of type Regions or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Regions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function joinRegions($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Regions');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Regions');
        }

        return $this;
    }

    /**
     * Use the Regions relation Regions object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\RegionsQuery A secondary query class using the current class as primary query
     */
    public function useRegionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRegions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Regions', '\Admin\AdminBundle\Model\RegionsQuery');
    }

    /**
     * Filter the query by a related CouponsCategories object
     *
     * @param   CouponsCategories|PropelObjectCollection $couponsCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCouponsCategories($couponsCategories, $comparison = null)
    {
        if ($couponsCategories instanceof CouponsCategories) {
            return $this
                ->addUsingAlias(CouponsPeer::CATEGORY_ID, $couponsCategories->getId(), $comparison);
        } elseif ($couponsCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CouponsPeer::CATEGORY_ID, $couponsCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCouponsCategories() only accepts arguments of type CouponsCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CouponsCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function joinCouponsCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CouponsCategories');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CouponsCategories');
        }

        return $this;
    }

    /**
     * Use the CouponsCategories relation CouponsCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\CouponsCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useCouponsCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCouponsCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CouponsCategories', '\Admin\AdminBundle\Model\CouponsCategoriesQuery');
    }

    /**
     * Filter the query by a related UserCoupons object
     *
     * @param   UserCoupons|PropelObjectCollection $userCoupons  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserCoupons($userCoupons, $comparison = null)
    {
        if ($userCoupons instanceof UserCoupons) {
            return $this
                ->addUsingAlias(CouponsPeer::ID, $userCoupons->getCouponId(), $comparison);
        } elseif ($userCoupons instanceof PropelObjectCollection) {
            return $this
                ->useUserCouponsQuery()
                ->filterByPrimaryKeys($userCoupons->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserCoupons() only accepts arguments of type UserCoupons or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserCoupons relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function joinUserCoupons($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserCoupons');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserCoupons');
        }

        return $this;
    }

    /**
     * Use the UserCoupons relation UserCoupons object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\UserCouponsQuery A secondary query class using the current class as primary query
     */
    public function useUserCouponsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserCoupons($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserCoupons', '\Admin\AdminBundle\Model\UserCouponsQuery');
    }

    /**
     * Filter the query by a related CouponImages object
     *
     * @param   CouponImages|PropelObjectCollection $couponImages  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCouponImages($couponImages, $comparison = null)
    {
        if ($couponImages instanceof CouponImages) {
            return $this
                ->addUsingAlias(CouponsPeer::ID, $couponImages->getCouponId(), $comparison);
        } elseif ($couponImages instanceof PropelObjectCollection) {
            return $this
                ->useCouponImagesQuery()
                ->filterByPrimaryKeys($couponImages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCouponImages() only accepts arguments of type CouponImages or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CouponImages relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function joinCouponImages($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CouponImages');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CouponImages');
        }

        return $this;
    }

    /**
     * Use the CouponImages relation CouponImages object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\CouponImagesQuery A secondary query class using the current class as primary query
     */
    public function useCouponImagesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCouponImages($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CouponImages', '\Admin\AdminBundle\Model\CouponImagesQuery');
    }

    /**
     * Filter the query by a related CouponVideos object
     *
     * @param   CouponVideos|PropelObjectCollection $couponVideos  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCouponVideos($couponVideos, $comparison = null)
    {
        if ($couponVideos instanceof CouponVideos) {
            return $this
                ->addUsingAlias(CouponsPeer::ID, $couponVideos->getCouponId(), $comparison);
        } elseif ($couponVideos instanceof PropelObjectCollection) {
            return $this
                ->useCouponVideosQuery()
                ->filterByPrimaryKeys($couponVideos->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCouponVideos() only accepts arguments of type CouponVideos or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CouponVideos relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function joinCouponVideos($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CouponVideos');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CouponVideos');
        }

        return $this;
    }

    /**
     * Use the CouponVideos relation CouponVideos object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\CouponVideosQuery A secondary query class using the current class as primary query
     */
    public function useCouponVideosQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCouponVideos($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CouponVideos', '\Admin\AdminBundle\Model\CouponVideosQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Coupons $coupons Object to remove from the list of results
     *
     * @return CouponsQuery The current query, for fluid interface
     */
    public function prune($coupons = null)
    {
        if ($coupons) {
            $this->addUsingAlias(CouponsPeer::ID, $coupons->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
