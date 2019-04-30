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
use Admin\AdminBundle\Model\JobCategories;
use Admin\AdminBundle\Model\JobComments;
use Admin\AdminBundle\Model\JobImages;
use Admin\AdminBundle\Model\JobPackets;
use Admin\AdminBundle\Model\JobParams;
use Admin\AdminBundle\Model\JobRest;
use Admin\AdminBundle\Model\JobVideos;
use Admin\AdminBundle\Model\Jobs;
use Admin\AdminBundle\Model\JobsPeer;
use Admin\AdminBundle\Model\JobsQuery;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\Shops;
use FOS\UserBundle\Propel\User;

/**
 * @method JobsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method JobsQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method JobsQuery orderByUserType($order = Criteria::ASC) Order by the user_type column
 * @method JobsQuery orderByCompanyName($order = Criteria::ASC) Order by the company_name column
 * @method JobsQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method JobsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method JobsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method JobsQuery orderByDogovor($order = Criteria::ASC) Order by the dogovor column
 * @method JobsQuery orderByPriceFrom($order = Criteria::ASC) Order by the price_from column
 * @method JobsQuery orderByPriceTo($order = Criteria::ASC) Order by the price_to column
 * @method JobsQuery orderByResume($order = Criteria::ASC) Order by the resume column
 * @method JobsQuery orderByRegionId($order = Criteria::ASC) Order by the region_id column
 * @method JobsQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method JobsQuery orderByShopId($order = Criteria::ASC) Order by the shop_id column
 * @method JobsQuery orderByCnt($order = Criteria::ASC) Order by the cnt column
 * @method JobsQuery orderByCntToday($order = Criteria::ASC) Order by the cnt_today column
 * @method JobsQuery orderByCntTel($order = Criteria::ASC) Order by the cnt_tel column
 * @method JobsQuery orderByModerApproved($order = Criteria::ASC) Order by the moder_approved column
 * @method JobsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method JobsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method JobsQuery orderByCreateDate($order = Criteria::ASC) Order by the create_date column
 * @method JobsQuery orderByPublishDate($order = Criteria::ASC) Order by the publish_date column
 * @method JobsQuery orderByPublishBeforeDate($order = Criteria::ASC) Order by the publish_before_date column
 *
 * @method JobsQuery groupById() Group by the id column
 * @method JobsQuery groupByCategoryId() Group by the category_id column
 * @method JobsQuery groupByUserId() Group by the user_id column
 * @method JobsQuery groupByUserType() Group by the user_type column
 * @method JobsQuery groupByCompanyName() Group by the company_name column
 * @method JobsQuery groupByPhone() Group by the phone column
 * @method JobsQuery groupByName() Group by the name column
 * @method JobsQuery groupByDescription() Group by the description column
 * @method JobsQuery groupByDogovor() Group by the dogovor column
 * @method JobsQuery groupByPriceFrom() Group by the price_from column
 * @method JobsQuery groupByPriceTo() Group by the price_to column
 * @method JobsQuery groupByResume() Group by the resume column
 * @method JobsQuery groupByRegionId() Group by the region_id column
 * @method JobsQuery groupByAreaId() Group by the area_id column
 * @method JobsQuery groupByShopId() Group by the shop_id column
 * @method JobsQuery groupByCnt() Group by the cnt column
 * @method JobsQuery groupByCntToday() Group by the cnt_today column
 * @method JobsQuery groupByCntTel() Group by the cnt_tel column
 * @method JobsQuery groupByModerApproved() Group by the moder_approved column
 * @method JobsQuery groupByEnabled() Group by the enabled column
 * @method JobsQuery groupByDeleted() Group by the deleted column
 * @method JobsQuery groupByCreateDate() Group by the create_date column
 * @method JobsQuery groupByPublishDate() Group by the publish_date column
 * @method JobsQuery groupByPublishBeforeDate() Group by the publish_before_date column
 *
 * @method JobsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobsQuery leftJoinRegions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Regions relation
 * @method JobsQuery rightJoinRegions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Regions relation
 * @method JobsQuery innerJoinRegions($relationAlias = null) Adds a INNER JOIN clause to the query using the Regions relation
 *
 * @method JobsQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method JobsQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method JobsQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method JobsQuery leftJoinJobCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategories relation
 * @method JobsQuery rightJoinJobCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategories relation
 * @method JobsQuery innerJoinJobCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategories relation
 *
 * @method JobsQuery leftJoinShops($relationAlias = null) Adds a LEFT JOIN clause to the query using the Shops relation
 * @method JobsQuery rightJoinShops($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Shops relation
 * @method JobsQuery innerJoinShops($relationAlias = null) Adds a INNER JOIN clause to the query using the Shops relation
 *
 * @method JobsQuery leftJoinJobParams($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobParams relation
 * @method JobsQuery rightJoinJobParams($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobParams relation
 * @method JobsQuery innerJoinJobParams($relationAlias = null) Adds a INNER JOIN clause to the query using the JobParams relation
 *
 * @method JobsQuery leftJoinJobImages($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobImages relation
 * @method JobsQuery rightJoinJobImages($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobImages relation
 * @method JobsQuery innerJoinJobImages($relationAlias = null) Adds a INNER JOIN clause to the query using the JobImages relation
 *
 * @method JobsQuery leftJoinJobVideos($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobVideos relation
 * @method JobsQuery rightJoinJobVideos($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobVideos relation
 * @method JobsQuery innerJoinJobVideos($relationAlias = null) Adds a INNER JOIN clause to the query using the JobVideos relation
 *
 * @method JobsQuery leftJoinJobPackets($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobPackets relation
 * @method JobsQuery rightJoinJobPackets($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobPackets relation
 * @method JobsQuery innerJoinJobPackets($relationAlias = null) Adds a INNER JOIN clause to the query using the JobPackets relation
 *
 * @method JobsQuery leftJoinJobComments($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobComments relation
 * @method JobsQuery rightJoinJobComments($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobComments relation
 * @method JobsQuery innerJoinJobComments($relationAlias = null) Adds a INNER JOIN clause to the query using the JobComments relation
 *
 * @method JobsQuery leftJoinJobRestRelatedByJobId($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobRestRelatedByJobId relation
 * @method JobsQuery rightJoinJobRestRelatedByJobId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobRestRelatedByJobId relation
 * @method JobsQuery innerJoinJobRestRelatedByJobId($relationAlias = null) Adds a INNER JOIN clause to the query using the JobRestRelatedByJobId relation
 *
 * @method JobsQuery leftJoinJobRestRelatedByVacancyId($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobRestRelatedByVacancyId relation
 * @method JobsQuery rightJoinJobRestRelatedByVacancyId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobRestRelatedByVacancyId relation
 * @method JobsQuery innerJoinJobRestRelatedByVacancyId($relationAlias = null) Adds a INNER JOIN clause to the query using the JobRestRelatedByVacancyId relation
 *
 * @method Jobs findOne(PropelPDO $con = null) Return the first Jobs matching the query
 * @method Jobs findOneOrCreate(PropelPDO $con = null) Return the first Jobs matching the query, or a new Jobs object populated from the query conditions when no match is found
 *
 * @method Jobs findOneByCategoryId(int $category_id) Return the first Jobs filtered by the category_id column
 * @method Jobs findOneByUserId(int $user_id) Return the first Jobs filtered by the user_id column
 * @method Jobs findOneByUserType(int $user_type) Return the first Jobs filtered by the user_type column
 * @method Jobs findOneByCompanyName(string $company_name) Return the first Jobs filtered by the company_name column
 * @method Jobs findOneByPhone(string $phone) Return the first Jobs filtered by the phone column
 * @method Jobs findOneByName(string $name) Return the first Jobs filtered by the name column
 * @method Jobs findOneByDescription(string $description) Return the first Jobs filtered by the description column
 * @method Jobs findOneByDogovor(boolean $dogovor) Return the first Jobs filtered by the dogovor column
 * @method Jobs findOneByPriceFrom(int $price_from) Return the first Jobs filtered by the price_from column
 * @method Jobs findOneByPriceTo(int $price_to) Return the first Jobs filtered by the price_to column
 * @method Jobs findOneByResume(boolean $resume) Return the first Jobs filtered by the resume column
 * @method Jobs findOneByRegionId(int $region_id) Return the first Jobs filtered by the region_id column
 * @method Jobs findOneByAreaId(int $area_id) Return the first Jobs filtered by the area_id column
 * @method Jobs findOneByShopId(int $shop_id) Return the first Jobs filtered by the shop_id column
 * @method Jobs findOneByCnt(int $cnt) Return the first Jobs filtered by the cnt column
 * @method Jobs findOneByCntToday(int $cnt_today) Return the first Jobs filtered by the cnt_today column
 * @method Jobs findOneByCntTel(int $cnt_tel) Return the first Jobs filtered by the cnt_tel column
 * @method Jobs findOneByModerApproved(boolean $moder_approved) Return the first Jobs filtered by the moder_approved column
 * @method Jobs findOneByEnabled(boolean $enabled) Return the first Jobs filtered by the enabled column
 * @method Jobs findOneByDeleted(boolean $deleted) Return the first Jobs filtered by the deleted column
 * @method Jobs findOneByCreateDate(string $create_date) Return the first Jobs filtered by the create_date column
 * @method Jobs findOneByPublishDate(string $publish_date) Return the first Jobs filtered by the publish_date column
 * @method Jobs findOneByPublishBeforeDate(string $publish_before_date) Return the first Jobs filtered by the publish_before_date column
 *
 * @method array findById(int $id) Return Jobs objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return Jobs objects filtered by the category_id column
 * @method array findByUserId(int $user_id) Return Jobs objects filtered by the user_id column
 * @method array findByUserType(int $user_type) Return Jobs objects filtered by the user_type column
 * @method array findByCompanyName(string $company_name) Return Jobs objects filtered by the company_name column
 * @method array findByPhone(string $phone) Return Jobs objects filtered by the phone column
 * @method array findByName(string $name) Return Jobs objects filtered by the name column
 * @method array findByDescription(string $description) Return Jobs objects filtered by the description column
 * @method array findByDogovor(boolean $dogovor) Return Jobs objects filtered by the dogovor column
 * @method array findByPriceFrom(int $price_from) Return Jobs objects filtered by the price_from column
 * @method array findByPriceTo(int $price_to) Return Jobs objects filtered by the price_to column
 * @method array findByResume(boolean $resume) Return Jobs objects filtered by the resume column
 * @method array findByRegionId(int $region_id) Return Jobs objects filtered by the region_id column
 * @method array findByAreaId(int $area_id) Return Jobs objects filtered by the area_id column
 * @method array findByShopId(int $shop_id) Return Jobs objects filtered by the shop_id column
 * @method array findByCnt(int $cnt) Return Jobs objects filtered by the cnt column
 * @method array findByCntToday(int $cnt_today) Return Jobs objects filtered by the cnt_today column
 * @method array findByCntTel(int $cnt_tel) Return Jobs objects filtered by the cnt_tel column
 * @method array findByModerApproved(boolean $moder_approved) Return Jobs objects filtered by the moder_approved column
 * @method array findByEnabled(boolean $enabled) Return Jobs objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return Jobs objects filtered by the deleted column
 * @method array findByCreateDate(string $create_date) Return Jobs objects filtered by the create_date column
 * @method array findByPublishDate(string $publish_date) Return Jobs objects filtered by the publish_date column
 * @method array findByPublishBeforeDate(string $publish_before_date) Return Jobs objects filtered by the publish_before_date column
 */
abstract class BaseJobsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Jobs';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobsQuery) {
            return $criteria;
        }
        $query = new JobsQuery(null, null, $modelAlias);

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
     * @return   Jobs|Jobs[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Jobs A model object, or null if the key is not found
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
     * @return                 Jobs A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `user_id`, `user_type`, `company_name`, `phone`, `name`, `description`, `dogovor`, `price_from`, `price_to`, `resume`, `region_id`, `area_id`, `shop_id`, `cnt`, `cnt_today`, `cnt_tel`, `moder_approved`, `enabled`, `deleted`, `create_date`, `publish_date`, `publish_before_date` FROM `jobs` WHERE `id` = :p0';
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
            $obj = new Jobs();
            $obj->hydrate($row);
            JobsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Jobs|Jobs[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Jobs[]|mixed the list of results, formatted by the current formatter
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobsPeer::ID, $keys, Criteria::IN);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::ID, $id, $comparison);
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
     * @see       filterByJobCategories()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(JobsPeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(JobsPeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id >= 12
     * $query->filterByUserId(array('max' => 12)); // WHERE user_id <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(JobsPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(JobsPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the user_type column
     *
     * Example usage:
     * <code>
     * $query->filterByUserType(1234); // WHERE user_type = 1234
     * $query->filterByUserType(array(12, 34)); // WHERE user_type IN (12, 34)
     * $query->filterByUserType(array('min' => 12)); // WHERE user_type >= 12
     * $query->filterByUserType(array('max' => 12)); // WHERE user_type <= 12
     * </code>
     *
     * @param     mixed $userType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByUserType($userType = null, $comparison = null)
    {
        if (is_array($userType)) {
            $useMinMax = false;
            if (isset($userType['min'])) {
                $this->addUsingAlias(JobsPeer::USER_TYPE, $userType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userType['max'])) {
                $this->addUsingAlias(JobsPeer::USER_TYPE, $userType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::USER_TYPE, $userType, $comparison);
    }

    /**
     * Filter the query on the company_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyName('fooValue');   // WHERE company_name = 'fooValue'
     * $query->filterByCompanyName('%fooValue%'); // WHERE company_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByCompanyName($companyName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyName)) {
                $companyName = str_replace('*', '%', $companyName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JobsPeer::COMPANY_NAME, $companyName, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobsPeer::PHONE, $phone, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobsPeer::NAME, $name, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobsPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the dogovor column
     *
     * Example usage:
     * <code>
     * $query->filterByDogovor(true); // WHERE dogovor = true
     * $query->filterByDogovor('yes'); // WHERE dogovor = true
     * </code>
     *
     * @param     boolean|string $dogovor The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByDogovor($dogovor = null, $comparison = null)
    {
        if (is_string($dogovor)) {
            $dogovor = in_array(strtolower($dogovor), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobsPeer::DOGOVOR, $dogovor, $comparison);
    }

    /**
     * Filter the query on the price_from column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceFrom(1234); // WHERE price_from = 1234
     * $query->filterByPriceFrom(array(12, 34)); // WHERE price_from IN (12, 34)
     * $query->filterByPriceFrom(array('min' => 12)); // WHERE price_from >= 12
     * $query->filterByPriceFrom(array('max' => 12)); // WHERE price_from <= 12
     * </code>
     *
     * @param     mixed $priceFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByPriceFrom($priceFrom = null, $comparison = null)
    {
        if (is_array($priceFrom)) {
            $useMinMax = false;
            if (isset($priceFrom['min'])) {
                $this->addUsingAlias(JobsPeer::PRICE_FROM, $priceFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceFrom['max'])) {
                $this->addUsingAlias(JobsPeer::PRICE_FROM, $priceFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::PRICE_FROM, $priceFrom, $comparison);
    }

    /**
     * Filter the query on the price_to column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceTo(1234); // WHERE price_to = 1234
     * $query->filterByPriceTo(array(12, 34)); // WHERE price_to IN (12, 34)
     * $query->filterByPriceTo(array('min' => 12)); // WHERE price_to >= 12
     * $query->filterByPriceTo(array('max' => 12)); // WHERE price_to <= 12
     * </code>
     *
     * @param     mixed $priceTo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByPriceTo($priceTo = null, $comparison = null)
    {
        if (is_array($priceTo)) {
            $useMinMax = false;
            if (isset($priceTo['min'])) {
                $this->addUsingAlias(JobsPeer::PRICE_TO, $priceTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceTo['max'])) {
                $this->addUsingAlias(JobsPeer::PRICE_TO, $priceTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::PRICE_TO, $priceTo, $comparison);
    }

    /**
     * Filter the query on the resume column
     *
     * Example usage:
     * <code>
     * $query->filterByResume(true); // WHERE resume = true
     * $query->filterByResume('yes'); // WHERE resume = true
     * </code>
     *
     * @param     boolean|string $resume The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByResume($resume = null, $comparison = null)
    {
        if (is_string($resume)) {
            $resume = in_array(strtolower($resume), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobsPeer::RESUME, $resume, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByRegionId($regionId = null, $comparison = null)
    {
        if (is_array($regionId)) {
            $useMinMax = false;
            if (isset($regionId['min'])) {
                $this->addUsingAlias(JobsPeer::REGION_ID, $regionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regionId['max'])) {
                $this->addUsingAlias(JobsPeer::REGION_ID, $regionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::REGION_ID, $regionId, $comparison);
    }

    /**
     * Filter the query on the area_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAreaId(1234); // WHERE area_id = 1234
     * $query->filterByAreaId(array(12, 34)); // WHERE area_id IN (12, 34)
     * $query->filterByAreaId(array('min' => 12)); // WHERE area_id >= 12
     * $query->filterByAreaId(array('max' => 12)); // WHERE area_id <= 12
     * </code>
     *
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(JobsPeer::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(JobsPeer::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::AREA_ID, $areaId, $comparison);
    }

    /**
     * Filter the query on the shop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShopId(1234); // WHERE shop_id = 1234
     * $query->filterByShopId(array(12, 34)); // WHERE shop_id IN (12, 34)
     * $query->filterByShopId(array('min' => 12)); // WHERE shop_id >= 12
     * $query->filterByShopId(array('max' => 12)); // WHERE shop_id <= 12
     * </code>
     *
     * @see       filterByShops()
     *
     * @param     mixed $shopId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByShopId($shopId = null, $comparison = null)
    {
        if (is_array($shopId)) {
            $useMinMax = false;
            if (isset($shopId['min'])) {
                $this->addUsingAlias(JobsPeer::SHOP_ID, $shopId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shopId['max'])) {
                $this->addUsingAlias(JobsPeer::SHOP_ID, $shopId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::SHOP_ID, $shopId, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByCnt($cnt = null, $comparison = null)
    {
        if (is_array($cnt)) {
            $useMinMax = false;
            if (isset($cnt['min'])) {
                $this->addUsingAlias(JobsPeer::CNT, $cnt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cnt['max'])) {
                $this->addUsingAlias(JobsPeer::CNT, $cnt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::CNT, $cnt, $comparison);
    }

    /**
     * Filter the query on the cnt_today column
     *
     * Example usage:
     * <code>
     * $query->filterByCntToday(1234); // WHERE cnt_today = 1234
     * $query->filterByCntToday(array(12, 34)); // WHERE cnt_today IN (12, 34)
     * $query->filterByCntToday(array('min' => 12)); // WHERE cnt_today >= 12
     * $query->filterByCntToday(array('max' => 12)); // WHERE cnt_today <= 12
     * </code>
     *
     * @param     mixed $cntToday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByCntToday($cntToday = null, $comparison = null)
    {
        if (is_array($cntToday)) {
            $useMinMax = false;
            if (isset($cntToday['min'])) {
                $this->addUsingAlias(JobsPeer::CNT_TODAY, $cntToday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntToday['max'])) {
                $this->addUsingAlias(JobsPeer::CNT_TODAY, $cntToday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::CNT_TODAY, $cntToday, $comparison);
    }

    /**
     * Filter the query on the cnt_tel column
     *
     * Example usage:
     * <code>
     * $query->filterByCntTel(1234); // WHERE cnt_tel = 1234
     * $query->filterByCntTel(array(12, 34)); // WHERE cnt_tel IN (12, 34)
     * $query->filterByCntTel(array('min' => 12)); // WHERE cnt_tel >= 12
     * $query->filterByCntTel(array('max' => 12)); // WHERE cnt_tel <= 12
     * </code>
     *
     * @param     mixed $cntTel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByCntTel($cntTel = null, $comparison = null)
    {
        if (is_array($cntTel)) {
            $useMinMax = false;
            if (isset($cntTel['min'])) {
                $this->addUsingAlias(JobsPeer::CNT_TEL, $cntTel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntTel['max'])) {
                $this->addUsingAlias(JobsPeer::CNT_TEL, $cntTel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::CNT_TEL, $cntTel, $comparison);
    }

    /**
     * Filter the query on the moder_approved column
     *
     * Example usage:
     * <code>
     * $query->filterByModerApproved(true); // WHERE moder_approved = true
     * $query->filterByModerApproved('yes'); // WHERE moder_approved = true
     * </code>
     *
     * @param     boolean|string $moderApproved The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByModerApproved($moderApproved = null, $comparison = null)
    {
        if (is_string($moderApproved)) {
            $moderApproved = in_array(strtolower($moderApproved), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobsPeer::MODER_APPROVED, $moderApproved, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobsPeer::ENABLED, $enabled, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query on the create_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCreateDate('2011-03-14'); // WHERE create_date = '2011-03-14'
     * $query->filterByCreateDate('now'); // WHERE create_date = '2011-03-14'
     * $query->filterByCreateDate(array('max' => 'yesterday')); // WHERE create_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $createDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByCreateDate($createDate = null, $comparison = null)
    {
        if (is_array($createDate)) {
            $useMinMax = false;
            if (isset($createDate['min'])) {
                $this->addUsingAlias(JobsPeer::CREATE_DATE, $createDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createDate['max'])) {
                $this->addUsingAlias(JobsPeer::CREATE_DATE, $createDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::CREATE_DATE, $createDate, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByPublishDate($publishDate = null, $comparison = null)
    {
        if (is_array($publishDate)) {
            $useMinMax = false;
            if (isset($publishDate['min'])) {
                $this->addUsingAlias(JobsPeer::PUBLISH_DATE, $publishDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishDate['max'])) {
                $this->addUsingAlias(JobsPeer::PUBLISH_DATE, $publishDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::PUBLISH_DATE, $publishDate, $comparison);
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
     * @return JobsQuery The current query, for fluid interface
     */
    public function filterByPublishBeforeDate($publishBeforeDate = null, $comparison = null)
    {
        if (is_array($publishBeforeDate)) {
            $useMinMax = false;
            if (isset($publishBeforeDate['min'])) {
                $this->addUsingAlias(JobsPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishBeforeDate['max'])) {
                $this->addUsingAlias(JobsPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobsPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate, $comparison);
    }

    /**
     * Filter the query by a related Regions object
     *
     * @param   Regions|PropelObjectCollection $regions The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRegions($regions, $comparison = null)
    {
        if ($regions instanceof Regions) {
            return $this
                ->addUsingAlias(JobsPeer::REGION_ID, $regions->getId(), $comparison);
        } elseif ($regions instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobsPeer::REGION_ID, $regions->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return JobsQuery The current query, for fluid interface
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
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(JobsPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobsPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FOS\UserBundle\Propel\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\FOS\UserBundle\Propel\UserQuery');
    }

    /**
     * Filter the query by a related JobCategories object
     *
     * @param   JobCategories|PropelObjectCollection $jobCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategories($jobCategories, $comparison = null)
    {
        if ($jobCategories instanceof JobCategories) {
            return $this
                ->addUsingAlias(JobsPeer::CATEGORY_ID, $jobCategories->getId(), $comparison);
        } elseif ($jobCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobsPeer::CATEGORY_ID, $jobCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobCategories() only accepts arguments of type JobCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobCategories');

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
            $this->addJoinObject($join, 'JobCategories');
        }

        return $this;
    }

    /**
     * Use the JobCategories relation JobCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useJobCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategories', '\Admin\AdminBundle\Model\JobCategoriesQuery');
    }

    /**
     * Filter the query by a related Shops object
     *
     * @param   Shops|PropelObjectCollection $shops The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByShops($shops, $comparison = null)
    {
        if ($shops instanceof Shops) {
            return $this
                ->addUsingAlias(JobsPeer::SHOP_ID, $shops->getId(), $comparison);
        } elseif ($shops instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobsPeer::SHOP_ID, $shops->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByShops() only accepts arguments of type Shops or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Shops relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinShops($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Shops');

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
            $this->addJoinObject($join, 'Shops');
        }

        return $this;
    }

    /**
     * Use the Shops relation Shops object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\ShopsQuery A secondary query class using the current class as primary query
     */
    public function useShopsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinShops($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Shops', '\Admin\AdminBundle\Model\ShopsQuery');
    }

    /**
     * Filter the query by a related JobParams object
     *
     * @param   JobParams|PropelObjectCollection $jobParams  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobParams($jobParams, $comparison = null)
    {
        if ($jobParams instanceof JobParams) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobParams->getJobId(), $comparison);
        } elseif ($jobParams instanceof PropelObjectCollection) {
            return $this
                ->useJobParamsQuery()
                ->filterByPrimaryKeys($jobParams->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobParams() only accepts arguments of type JobParams or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobParams relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobParams($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobParams');

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
            $this->addJoinObject($join, 'JobParams');
        }

        return $this;
    }

    /**
     * Use the JobParams relation JobParams object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobParamsQuery A secondary query class using the current class as primary query
     */
    public function useJobParamsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobParams($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobParams', '\Admin\AdminBundle\Model\JobParamsQuery');
    }

    /**
     * Filter the query by a related JobImages object
     *
     * @param   JobImages|PropelObjectCollection $jobImages  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobImages($jobImages, $comparison = null)
    {
        if ($jobImages instanceof JobImages) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobImages->getJobId(), $comparison);
        } elseif ($jobImages instanceof PropelObjectCollection) {
            return $this
                ->useJobImagesQuery()
                ->filterByPrimaryKeys($jobImages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobImages() only accepts arguments of type JobImages or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobImages relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobImages($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobImages');

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
            $this->addJoinObject($join, 'JobImages');
        }

        return $this;
    }

    /**
     * Use the JobImages relation JobImages object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobImagesQuery A secondary query class using the current class as primary query
     */
    public function useJobImagesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobImages($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobImages', '\Admin\AdminBundle\Model\JobImagesQuery');
    }

    /**
     * Filter the query by a related JobVideos object
     *
     * @param   JobVideos|PropelObjectCollection $jobVideos  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobVideos($jobVideos, $comparison = null)
    {
        if ($jobVideos instanceof JobVideos) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobVideos->getJobId(), $comparison);
        } elseif ($jobVideos instanceof PropelObjectCollection) {
            return $this
                ->useJobVideosQuery()
                ->filterByPrimaryKeys($jobVideos->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobVideos() only accepts arguments of type JobVideos or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobVideos relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobVideos($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobVideos');

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
            $this->addJoinObject($join, 'JobVideos');
        }

        return $this;
    }

    /**
     * Use the JobVideos relation JobVideos object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobVideosQuery A secondary query class using the current class as primary query
     */
    public function useJobVideosQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobVideos($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobVideos', '\Admin\AdminBundle\Model\JobVideosQuery');
    }

    /**
     * Filter the query by a related JobPackets object
     *
     * @param   JobPackets|PropelObjectCollection $jobPackets  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobPackets($jobPackets, $comparison = null)
    {
        if ($jobPackets instanceof JobPackets) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobPackets->getJobId(), $comparison);
        } elseif ($jobPackets instanceof PropelObjectCollection) {
            return $this
                ->useJobPacketsQuery()
                ->filterByPrimaryKeys($jobPackets->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobPackets() only accepts arguments of type JobPackets or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobPackets relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobPackets($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobPackets');

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
            $this->addJoinObject($join, 'JobPackets');
        }

        return $this;
    }

    /**
     * Use the JobPackets relation JobPackets object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobPacketsQuery A secondary query class using the current class as primary query
     */
    public function useJobPacketsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobPackets($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobPackets', '\Admin\AdminBundle\Model\JobPacketsQuery');
    }

    /**
     * Filter the query by a related JobComments object
     *
     * @param   JobComments|PropelObjectCollection $jobComments  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobComments($jobComments, $comparison = null)
    {
        if ($jobComments instanceof JobComments) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobComments->getJobId(), $comparison);
        } elseif ($jobComments instanceof PropelObjectCollection) {
            return $this
                ->useJobCommentsQuery()
                ->filterByPrimaryKeys($jobComments->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobComments() only accepts arguments of type JobComments or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobComments relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobComments($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobComments');

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
            $this->addJoinObject($join, 'JobComments');
        }

        return $this;
    }

    /**
     * Use the JobComments relation JobComments object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCommentsQuery A secondary query class using the current class as primary query
     */
    public function useJobCommentsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobComments($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobComments', '\Admin\AdminBundle\Model\JobCommentsQuery');
    }

    /**
     * Filter the query by a related JobRest object
     *
     * @param   JobRest|PropelObjectCollection $jobRest  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobRestRelatedByJobId($jobRest, $comparison = null)
    {
        if ($jobRest instanceof JobRest) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobRest->getJobId(), $comparison);
        } elseif ($jobRest instanceof PropelObjectCollection) {
            return $this
                ->useJobRestRelatedByJobIdQuery()
                ->filterByPrimaryKeys($jobRest->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobRestRelatedByJobId() only accepts arguments of type JobRest or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobRestRelatedByJobId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobRestRelatedByJobId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobRestRelatedByJobId');

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
            $this->addJoinObject($join, 'JobRestRelatedByJobId');
        }

        return $this;
    }

    /**
     * Use the JobRestRelatedByJobId relation JobRest object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobRestQuery A secondary query class using the current class as primary query
     */
    public function useJobRestRelatedByJobIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobRestRelatedByJobId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobRestRelatedByJobId', '\Admin\AdminBundle\Model\JobRestQuery');
    }

    /**
     * Filter the query by a related JobRest object
     *
     * @param   JobRest|PropelObjectCollection $jobRest  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobRestRelatedByVacancyId($jobRest, $comparison = null)
    {
        if ($jobRest instanceof JobRest) {
            return $this
                ->addUsingAlias(JobsPeer::ID, $jobRest->getVacancyId(), $comparison);
        } elseif ($jobRest instanceof PropelObjectCollection) {
            return $this
                ->useJobRestRelatedByVacancyIdQuery()
                ->filterByPrimaryKeys($jobRest->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobRestRelatedByVacancyId() only accepts arguments of type JobRest or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobRestRelatedByVacancyId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function joinJobRestRelatedByVacancyId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobRestRelatedByVacancyId');

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
            $this->addJoinObject($join, 'JobRestRelatedByVacancyId');
        }

        return $this;
    }

    /**
     * Use the JobRestRelatedByVacancyId relation JobRest object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobRestQuery A secondary query class using the current class as primary query
     */
    public function useJobRestRelatedByVacancyIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobRestRelatedByVacancyId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobRestRelatedByVacancyId', '\Admin\AdminBundle\Model\JobRestQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Jobs $jobs Object to remove from the list of results
     *
     * @return JobsQuery The current query, for fluid interface
     */
    public function prune($jobs = null)
    {
        if ($jobs) {
            $this->addUsingAlias(JobsPeer::ID, $jobs->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
