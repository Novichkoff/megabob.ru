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
use Admin\AdminBundle\Model\Banners;
use Admin\AdminBundle\Model\BannersPeer;
use Admin\AdminBundle\Model\BannersQuery;
use Admin\AdminBundle\Model\BannersStat;

/**
 * @method BannersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BannersQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method BannersQuery orderByRegionId($order = Criteria::ASC) Order by the region_id column
 * @method BannersQuery orderByClient($order = Criteria::ASC) Order by the client column
 * @method BannersQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method BannersQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method BannersQuery orderByPicture($order = Criteria::ASC) Order by the picture column
 * @method BannersQuery orderByWidth($order = Criteria::ASC) Order by the width column
 * @method BannersQuery orderByCnt($order = Criteria::ASC) Order by the cnt column
 * @method BannersQuery orderByShowToday($order = Criteria::ASC) Order by the show_today column
 * @method BannersQuery orderByClickToday($order = Criteria::ASC) Order by the click_today column
 * @method BannersQuery orderByBannerZoneId($order = Criteria::ASC) Order by the banner_zone_id column
 * @method BannersQuery orderByMobile($order = Criteria::ASC) Order by the mobile column
 * @method BannersQuery orderByFullSize($order = Criteria::ASC) Order by the full_size column
 * @method BannersQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method BannersQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method BannersQuery orderByLastPublish($order = Criteria::ASC) Order by the last_publish column
 * @method BannersQuery orderByPublishDate($order = Criteria::ASC) Order by the publish_date column
 * @method BannersQuery orderByPublishBeforeDate($order = Criteria::ASC) Order by the publish_before_date column
 *
 * @method BannersQuery groupById() Group by the id column
 * @method BannersQuery groupByCategoryId() Group by the category_id column
 * @method BannersQuery groupByRegionId() Group by the region_id column
 * @method BannersQuery groupByClient() Group by the client column
 * @method BannersQuery groupByName() Group by the name column
 * @method BannersQuery groupByCode() Group by the code column
 * @method BannersQuery groupByPicture() Group by the picture column
 * @method BannersQuery groupByWidth() Group by the width column
 * @method BannersQuery groupByCnt() Group by the cnt column
 * @method BannersQuery groupByShowToday() Group by the show_today column
 * @method BannersQuery groupByClickToday() Group by the click_today column
 * @method BannersQuery groupByBannerZoneId() Group by the banner_zone_id column
 * @method BannersQuery groupByMobile() Group by the mobile column
 * @method BannersQuery groupByFullSize() Group by the full_size column
 * @method BannersQuery groupByEnabled() Group by the enabled column
 * @method BannersQuery groupByDeleted() Group by the deleted column
 * @method BannersQuery groupByLastPublish() Group by the last_publish column
 * @method BannersQuery groupByPublishDate() Group by the publish_date column
 * @method BannersQuery groupByPublishBeforeDate() Group by the publish_before_date column
 *
 * @method BannersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BannersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BannersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BannersQuery leftJoinBannersStat($relationAlias = null) Adds a LEFT JOIN clause to the query using the BannersStat relation
 * @method BannersQuery rightJoinBannersStat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BannersStat relation
 * @method BannersQuery innerJoinBannersStat($relationAlias = null) Adds a INNER JOIN clause to the query using the BannersStat relation
 *
 * @method Banners findOne(PropelPDO $con = null) Return the first Banners matching the query
 * @method Banners findOneOrCreate(PropelPDO $con = null) Return the first Banners matching the query, or a new Banners object populated from the query conditions when no match is found
 *
 * @method Banners findOneByCategoryId(string $category_id) Return the first Banners filtered by the category_id column
 * @method Banners findOneByRegionId(int $region_id) Return the first Banners filtered by the region_id column
 * @method Banners findOneByClient(string $client) Return the first Banners filtered by the client column
 * @method Banners findOneByName(string $name) Return the first Banners filtered by the name column
 * @method Banners findOneByCode(string $code) Return the first Banners filtered by the code column
 * @method Banners findOneByPicture(string $picture) Return the first Banners filtered by the picture column
 * @method Banners findOneByWidth(int $width) Return the first Banners filtered by the width column
 * @method Banners findOneByCnt(int $cnt) Return the first Banners filtered by the cnt column
 * @method Banners findOneByShowToday(int $show_today) Return the first Banners filtered by the show_today column
 * @method Banners findOneByClickToday(int $click_today) Return the first Banners filtered by the click_today column
 * @method Banners findOneByBannerZoneId(int $banner_zone_id) Return the first Banners filtered by the banner_zone_id column
 * @method Banners findOneByMobile(boolean $mobile) Return the first Banners filtered by the mobile column
 * @method Banners findOneByFullSize(boolean $full_size) Return the first Banners filtered by the full_size column
 * @method Banners findOneByEnabled(boolean $enabled) Return the first Banners filtered by the enabled column
 * @method Banners findOneByDeleted(boolean $deleted) Return the first Banners filtered by the deleted column
 * @method Banners findOneByLastPublish(string $last_publish) Return the first Banners filtered by the last_publish column
 * @method Banners findOneByPublishDate(string $publish_date) Return the first Banners filtered by the publish_date column
 * @method Banners findOneByPublishBeforeDate(string $publish_before_date) Return the first Banners filtered by the publish_before_date column
 *
 * @method array findById(int $id) Return Banners objects filtered by the id column
 * @method array findByCategoryId(string $category_id) Return Banners objects filtered by the category_id column
 * @method array findByRegionId(int $region_id) Return Banners objects filtered by the region_id column
 * @method array findByClient(string $client) Return Banners objects filtered by the client column
 * @method array findByName(string $name) Return Banners objects filtered by the name column
 * @method array findByCode(string $code) Return Banners objects filtered by the code column
 * @method array findByPicture(string $picture) Return Banners objects filtered by the picture column
 * @method array findByWidth(int $width) Return Banners objects filtered by the width column
 * @method array findByCnt(int $cnt) Return Banners objects filtered by the cnt column
 * @method array findByShowToday(int $show_today) Return Banners objects filtered by the show_today column
 * @method array findByClickToday(int $click_today) Return Banners objects filtered by the click_today column
 * @method array findByBannerZoneId(int $banner_zone_id) Return Banners objects filtered by the banner_zone_id column
 * @method array findByMobile(boolean $mobile) Return Banners objects filtered by the mobile column
 * @method array findByFullSize(boolean $full_size) Return Banners objects filtered by the full_size column
 * @method array findByEnabled(boolean $enabled) Return Banners objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return Banners objects filtered by the deleted column
 * @method array findByLastPublish(string $last_publish) Return Banners objects filtered by the last_publish column
 * @method array findByPublishDate(string $publish_date) Return Banners objects filtered by the publish_date column
 * @method array findByPublishBeforeDate(string $publish_before_date) Return Banners objects filtered by the publish_before_date column
 */
abstract class BaseBannersQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBannersQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Banners';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BannersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BannersQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BannersQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BannersQuery) {
            return $criteria;
        }
        $query = new BannersQuery(null, null, $modelAlias);

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
     * @return   Banners|Banners[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BannersPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BannersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Banners A model object, or null if the key is not found
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
     * @return                 Banners A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `region_id`, `client`, `name`, `code`, `picture`, `width`, `cnt`, `show_today`, `click_today`, `banner_zone_id`, `mobile`, `full_size`, `enabled`, `deleted`, `last_publish`, `publish_date`, `publish_before_date` FROM `banners` WHERE `id` = :p0';
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
            $obj = new Banners();
            $obj->hydrate($row);
            BannersPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Banners|Banners[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Banners[]|mixed the list of results, formatted by the current formatter
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
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BannersPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BannersPeer::ID, $keys, Criteria::IN);
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
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BannersPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BannersPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId('fooValue');   // WHERE category_id = 'fooValue'
     * $query->filterByCategoryId('%fooValue%'); // WHERE category_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $categoryId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($categoryId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $categoryId)) {
                $categoryId = str_replace('*', '%', $categoryId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BannersPeer::CATEGORY_ID, $categoryId, $comparison);
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
     * @param     mixed $regionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByRegionId($regionId = null, $comparison = null)
    {
        if (is_array($regionId)) {
            $useMinMax = false;
            if (isset($regionId['min'])) {
                $this->addUsingAlias(BannersPeer::REGION_ID, $regionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regionId['max'])) {
                $this->addUsingAlias(BannersPeer::REGION_ID, $regionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::REGION_ID, $regionId, $comparison);
    }

    /**
     * Filter the query on the client column
     *
     * Example usage:
     * <code>
     * $query->filterByClient('fooValue');   // WHERE client = 'fooValue'
     * $query->filterByClient('%fooValue%'); // WHERE client LIKE '%fooValue%'
     * </code>
     *
     * @param     string $client The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByClient($client = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($client)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $client)) {
                $client = str_replace('*', '%', $client);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BannersPeer::CLIENT, $client, $comparison);
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
     * @return BannersQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BannersPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode('fooValue');   // WHERE code = 'fooValue'
     * $query->filterByCode('%fooValue%'); // WHERE code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $code The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($code)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $code)) {
                $code = str_replace('*', '%', $code);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BannersPeer::CODE, $code, $comparison);
    }

    /**
     * Filter the query on the picture column
     *
     * Example usage:
     * <code>
     * $query->filterByPicture('fooValue');   // WHERE picture = 'fooValue'
     * $query->filterByPicture('%fooValue%'); // WHERE picture LIKE '%fooValue%'
     * </code>
     *
     * @param     string $picture The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByPicture($picture = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($picture)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $picture)) {
                $picture = str_replace('*', '%', $picture);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(BannersPeer::PICTURE, $picture, $comparison);
    }

    /**
     * Filter the query on the width column
     *
     * Example usage:
     * <code>
     * $query->filterByWidth(1234); // WHERE width = 1234
     * $query->filterByWidth(array(12, 34)); // WHERE width IN (12, 34)
     * $query->filterByWidth(array('min' => 12)); // WHERE width >= 12
     * $query->filterByWidth(array('max' => 12)); // WHERE width <= 12
     * </code>
     *
     * @param     mixed $width The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByWidth($width = null, $comparison = null)
    {
        if (is_array($width)) {
            $useMinMax = false;
            if (isset($width['min'])) {
                $this->addUsingAlias(BannersPeer::WIDTH, $width['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($width['max'])) {
                $this->addUsingAlias(BannersPeer::WIDTH, $width['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::WIDTH, $width, $comparison);
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
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByCnt($cnt = null, $comparison = null)
    {
        if (is_array($cnt)) {
            $useMinMax = false;
            if (isset($cnt['min'])) {
                $this->addUsingAlias(BannersPeer::CNT, $cnt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cnt['max'])) {
                $this->addUsingAlias(BannersPeer::CNT, $cnt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::CNT, $cnt, $comparison);
    }

    /**
     * Filter the query on the show_today column
     *
     * Example usage:
     * <code>
     * $query->filterByShowToday(1234); // WHERE show_today = 1234
     * $query->filterByShowToday(array(12, 34)); // WHERE show_today IN (12, 34)
     * $query->filterByShowToday(array('min' => 12)); // WHERE show_today >= 12
     * $query->filterByShowToday(array('max' => 12)); // WHERE show_today <= 12
     * </code>
     *
     * @param     mixed $showToday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByShowToday($showToday = null, $comparison = null)
    {
        if (is_array($showToday)) {
            $useMinMax = false;
            if (isset($showToday['min'])) {
                $this->addUsingAlias(BannersPeer::SHOW_TODAY, $showToday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($showToday['max'])) {
                $this->addUsingAlias(BannersPeer::SHOW_TODAY, $showToday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::SHOW_TODAY, $showToday, $comparison);
    }

    /**
     * Filter the query on the click_today column
     *
     * Example usage:
     * <code>
     * $query->filterByClickToday(1234); // WHERE click_today = 1234
     * $query->filterByClickToday(array(12, 34)); // WHERE click_today IN (12, 34)
     * $query->filterByClickToday(array('min' => 12)); // WHERE click_today >= 12
     * $query->filterByClickToday(array('max' => 12)); // WHERE click_today <= 12
     * </code>
     *
     * @param     mixed $clickToday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByClickToday($clickToday = null, $comparison = null)
    {
        if (is_array($clickToday)) {
            $useMinMax = false;
            if (isset($clickToday['min'])) {
                $this->addUsingAlias(BannersPeer::CLICK_TODAY, $clickToday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clickToday['max'])) {
                $this->addUsingAlias(BannersPeer::CLICK_TODAY, $clickToday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::CLICK_TODAY, $clickToday, $comparison);
    }

    /**
     * Filter the query on the banner_zone_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBannerZoneId(1234); // WHERE banner_zone_id = 1234
     * $query->filterByBannerZoneId(array(12, 34)); // WHERE banner_zone_id IN (12, 34)
     * $query->filterByBannerZoneId(array('min' => 12)); // WHERE banner_zone_id >= 12
     * $query->filterByBannerZoneId(array('max' => 12)); // WHERE banner_zone_id <= 12
     * </code>
     *
     * @param     mixed $bannerZoneId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByBannerZoneId($bannerZoneId = null, $comparison = null)
    {
        if (is_array($bannerZoneId)) {
            $useMinMax = false;
            if (isset($bannerZoneId['min'])) {
                $this->addUsingAlias(BannersPeer::BANNER_ZONE_ID, $bannerZoneId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bannerZoneId['max'])) {
                $this->addUsingAlias(BannersPeer::BANNER_ZONE_ID, $bannerZoneId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::BANNER_ZONE_ID, $bannerZoneId, $comparison);
    }

    /**
     * Filter the query on the mobile column
     *
     * Example usage:
     * <code>
     * $query->filterByMobile(true); // WHERE mobile = true
     * $query->filterByMobile('yes'); // WHERE mobile = true
     * </code>
     *
     * @param     boolean|string $mobile The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByMobile($mobile = null, $comparison = null)
    {
        if (is_string($mobile)) {
            $mobile = in_array(strtolower($mobile), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BannersPeer::MOBILE, $mobile, $comparison);
    }

    /**
     * Filter the query on the full_size column
     *
     * Example usage:
     * <code>
     * $query->filterByFullSize(true); // WHERE full_size = true
     * $query->filterByFullSize('yes'); // WHERE full_size = true
     * </code>
     *
     * @param     boolean|string $fullSize The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByFullSize($fullSize = null, $comparison = null)
    {
        if (is_string($fullSize)) {
            $fullSize = in_array(strtolower($fullSize), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BannersPeer::FULL_SIZE, $fullSize, $comparison);
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
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BannersPeer::ENABLED, $enabled, $comparison);
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
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(BannersPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query on the last_publish column
     *
     * Example usage:
     * <code>
     * $query->filterByLastPublish('2011-03-14'); // WHERE last_publish = '2011-03-14'
     * $query->filterByLastPublish('now'); // WHERE last_publish = '2011-03-14'
     * $query->filterByLastPublish(array('max' => 'yesterday')); // WHERE last_publish < '2011-03-13'
     * </code>
     *
     * @param     mixed $lastPublish The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByLastPublish($lastPublish = null, $comparison = null)
    {
        if (is_array($lastPublish)) {
            $useMinMax = false;
            if (isset($lastPublish['min'])) {
                $this->addUsingAlias(BannersPeer::LAST_PUBLISH, $lastPublish['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastPublish['max'])) {
                $this->addUsingAlias(BannersPeer::LAST_PUBLISH, $lastPublish['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::LAST_PUBLISH, $lastPublish, $comparison);
    }

    /**
     * Filter the query on the publish_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishDate('2011-03-14'); // WHERE publish_date = '2011-03-14'
     * $query->filterByPublishDate('now'); // WHERE publish_date = '2011-03-14'
     * $query->filterByPublishDate(array('max' => 'yesterday')); // WHERE publish_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $publishDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByPublishDate($publishDate = null, $comparison = null)
    {
        if (is_array($publishDate)) {
            $useMinMax = false;
            if (isset($publishDate['min'])) {
                $this->addUsingAlias(BannersPeer::PUBLISH_DATE, $publishDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishDate['max'])) {
                $this->addUsingAlias(BannersPeer::PUBLISH_DATE, $publishDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::PUBLISH_DATE, $publishDate, $comparison);
    }

    /**
     * Filter the query on the publish_before_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishBeforeDate('2011-03-14'); // WHERE publish_before_date = '2011-03-14'
     * $query->filterByPublishBeforeDate('now'); // WHERE publish_before_date = '2011-03-14'
     * $query->filterByPublishBeforeDate(array('max' => 'yesterday')); // WHERE publish_before_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $publishBeforeDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function filterByPublishBeforeDate($publishBeforeDate = null, $comparison = null)
    {
        if (is_array($publishBeforeDate)) {
            $useMinMax = false;
            if (isset($publishBeforeDate['min'])) {
                $this->addUsingAlias(BannersPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishBeforeDate['max'])) {
                $this->addUsingAlias(BannersPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate, $comparison);
    }

    /**
     * Filter the query by a related BannersStat object
     *
     * @param   BannersStat|PropelObjectCollection $bannersStat  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BannersQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBannersStat($bannersStat, $comparison = null)
    {
        if ($bannersStat instanceof BannersStat) {
            return $this
                ->addUsingAlias(BannersPeer::ID, $bannersStat->getBannerId(), $comparison);
        } elseif ($bannersStat instanceof PropelObjectCollection) {
            return $this
                ->useBannersStatQuery()
                ->filterByPrimaryKeys($bannersStat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBannersStat() only accepts arguments of type BannersStat or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BannersStat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function joinBannersStat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BannersStat');

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
            $this->addJoinObject($join, 'BannersStat');
        }

        return $this;
    }

    /**
     * Use the BannersStat relation BannersStat object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\BannersStatQuery A secondary query class using the current class as primary query
     */
    public function useBannersStatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBannersStat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BannersStat', '\Admin\AdminBundle\Model\BannersStatQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Banners $banners Object to remove from the list of results
     *
     * @return BannersQuery The current query, for fluid interface
     */
    public function prune($banners = null)
    {
        if ($banners) {
            $this->addUsingAlias(BannersPeer::ID, $banners->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
