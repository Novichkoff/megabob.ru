<?php

namespace Admin\AdminBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Admin\AdminBundle\Model\SiteHistory;
use Admin\AdminBundle\Model\SiteHistoryPeer;
use Admin\AdminBundle\Model\SiteHistoryQuery;

/**
 * @method SiteHistoryQuery orderById($order = Criteria::ASC) Order by the id column
 * @method SiteHistoryQuery orderByAllAdvs($order = Criteria::ASC) Order by the all_advs column
 * @method SiteHistoryQuery orderByActiveAdvs($order = Criteria::ASC) Order by the active_advs column
 * @method SiteHistoryQuery orderByTodayAdvs($order = Criteria::ASC) Order by the today_advs column
 * @method SiteHistoryQuery orderByGoogleAdvs($order = Criteria::ASC) Order by the google_advs column
 * @method SiteHistoryQuery orderByYandexAdvs($order = Criteria::ASC) Order by the yandex_advs column
 * @method SiteHistoryQuery orderByCompanies($order = Criteria::ASC) Order by the companies column
 * @method SiteHistoryQuery orderByTwitter($order = Criteria::ASC) Order by the twitter column
 * @method SiteHistoryQuery orderByFacebook($order = Criteria::ASC) Order by the facebook column
 * @method SiteHistoryQuery orderByVk($order = Criteria::ASC) Order by the vk column
 * @method SiteHistoryQuery orderByOk($order = Criteria::ASC) Order by the ok column
 * @method SiteHistoryQuery orderByDate($order = Criteria::ASC) Order by the date column
 *
 * @method SiteHistoryQuery groupById() Group by the id column
 * @method SiteHistoryQuery groupByAllAdvs() Group by the all_advs column
 * @method SiteHistoryQuery groupByActiveAdvs() Group by the active_advs column
 * @method SiteHistoryQuery groupByTodayAdvs() Group by the today_advs column
 * @method SiteHistoryQuery groupByGoogleAdvs() Group by the google_advs column
 * @method SiteHistoryQuery groupByYandexAdvs() Group by the yandex_advs column
 * @method SiteHistoryQuery groupByCompanies() Group by the companies column
 * @method SiteHistoryQuery groupByTwitter() Group by the twitter column
 * @method SiteHistoryQuery groupByFacebook() Group by the facebook column
 * @method SiteHistoryQuery groupByVk() Group by the vk column
 * @method SiteHistoryQuery groupByOk() Group by the ok column
 * @method SiteHistoryQuery groupByDate() Group by the date column
 *
 * @method SiteHistoryQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SiteHistoryQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SiteHistoryQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SiteHistory findOne(PropelPDO $con = null) Return the first SiteHistory matching the query
 * @method SiteHistory findOneOrCreate(PropelPDO $con = null) Return the first SiteHistory matching the query, or a new SiteHistory object populated from the query conditions when no match is found
 *
 * @method SiteHistory findOneByAllAdvs(int $all_advs) Return the first SiteHistory filtered by the all_advs column
 * @method SiteHistory findOneByActiveAdvs(int $active_advs) Return the first SiteHistory filtered by the active_advs column
 * @method SiteHistory findOneByTodayAdvs(int $today_advs) Return the first SiteHistory filtered by the today_advs column
 * @method SiteHistory findOneByGoogleAdvs(int $google_advs) Return the first SiteHistory filtered by the google_advs column
 * @method SiteHistory findOneByYandexAdvs(int $yandex_advs) Return the first SiteHistory filtered by the yandex_advs column
 * @method SiteHistory findOneByCompanies(int $companies) Return the first SiteHistory filtered by the companies column
 * @method SiteHistory findOneByTwitter(int $twitter) Return the first SiteHistory filtered by the twitter column
 * @method SiteHistory findOneByFacebook(int $facebook) Return the first SiteHistory filtered by the facebook column
 * @method SiteHistory findOneByVk(int $vk) Return the first SiteHistory filtered by the vk column
 * @method SiteHistory findOneByOk(int $ok) Return the first SiteHistory filtered by the ok column
 * @method SiteHistory findOneByDate(string $date) Return the first SiteHistory filtered by the date column
 *
 * @method array findById(int $id) Return SiteHistory objects filtered by the id column
 * @method array findByAllAdvs(int $all_advs) Return SiteHistory objects filtered by the all_advs column
 * @method array findByActiveAdvs(int $active_advs) Return SiteHistory objects filtered by the active_advs column
 * @method array findByTodayAdvs(int $today_advs) Return SiteHistory objects filtered by the today_advs column
 * @method array findByGoogleAdvs(int $google_advs) Return SiteHistory objects filtered by the google_advs column
 * @method array findByYandexAdvs(int $yandex_advs) Return SiteHistory objects filtered by the yandex_advs column
 * @method array findByCompanies(int $companies) Return SiteHistory objects filtered by the companies column
 * @method array findByTwitter(int $twitter) Return SiteHistory objects filtered by the twitter column
 * @method array findByFacebook(int $facebook) Return SiteHistory objects filtered by the facebook column
 * @method array findByVk(int $vk) Return SiteHistory objects filtered by the vk column
 * @method array findByOk(int $ok) Return SiteHistory objects filtered by the ok column
 * @method array findByDate(string $date) Return SiteHistory objects filtered by the date column
 */
abstract class BaseSiteHistoryQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSiteHistoryQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\SiteHistory';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SiteHistoryQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SiteHistoryQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SiteHistoryQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SiteHistoryQuery) {
            return $criteria;
        }
        $query = new SiteHistoryQuery(null, null, $modelAlias);

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
     * @return   SiteHistory|SiteHistory[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SiteHistoryPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SiteHistoryPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 SiteHistory A model object, or null if the key is not found
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
     * @return                 SiteHistory A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `all_advs`, `active_advs`, `today_advs`, `google_advs`, `yandex_advs`, `companies`, `twitter`, `facebook`, `vk`, `ok`, `date` FROM `site_history` WHERE `id` = :p0';
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
            $obj = new SiteHistory();
            $obj->hydrate($row);
            SiteHistoryPeer::addInstanceToPool($obj, (string) $key);
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
     * @return SiteHistory|SiteHistory[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|SiteHistory[]|mixed the list of results, formatted by the current formatter
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
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SiteHistoryPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SiteHistoryPeer::ID, $keys, Criteria::IN);
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
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the all_advs column
     *
     * Example usage:
     * <code>
     * $query->filterByAllAdvs(1234); // WHERE all_advs = 1234
     * $query->filterByAllAdvs(array(12, 34)); // WHERE all_advs IN (12, 34)
     * $query->filterByAllAdvs(array('min' => 12)); // WHERE all_advs >= 12
     * $query->filterByAllAdvs(array('max' => 12)); // WHERE all_advs <= 12
     * </code>
     *
     * @param     mixed $allAdvs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByAllAdvs($allAdvs = null, $comparison = null)
    {
        if (is_array($allAdvs)) {
            $useMinMax = false;
            if (isset($allAdvs['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::ALL_ADVS, $allAdvs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($allAdvs['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::ALL_ADVS, $allAdvs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::ALL_ADVS, $allAdvs, $comparison);
    }

    /**
     * Filter the query on the active_advs column
     *
     * Example usage:
     * <code>
     * $query->filterByActiveAdvs(1234); // WHERE active_advs = 1234
     * $query->filterByActiveAdvs(array(12, 34)); // WHERE active_advs IN (12, 34)
     * $query->filterByActiveAdvs(array('min' => 12)); // WHERE active_advs >= 12
     * $query->filterByActiveAdvs(array('max' => 12)); // WHERE active_advs <= 12
     * </code>
     *
     * @param     mixed $activeAdvs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByActiveAdvs($activeAdvs = null, $comparison = null)
    {
        if (is_array($activeAdvs)) {
            $useMinMax = false;
            if (isset($activeAdvs['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::ACTIVE_ADVS, $activeAdvs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($activeAdvs['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::ACTIVE_ADVS, $activeAdvs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::ACTIVE_ADVS, $activeAdvs, $comparison);
    }

    /**
     * Filter the query on the today_advs column
     *
     * Example usage:
     * <code>
     * $query->filterByTodayAdvs(1234); // WHERE today_advs = 1234
     * $query->filterByTodayAdvs(array(12, 34)); // WHERE today_advs IN (12, 34)
     * $query->filterByTodayAdvs(array('min' => 12)); // WHERE today_advs >= 12
     * $query->filterByTodayAdvs(array('max' => 12)); // WHERE today_advs <= 12
     * </code>
     *
     * @param     mixed $todayAdvs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByTodayAdvs($todayAdvs = null, $comparison = null)
    {
        if (is_array($todayAdvs)) {
            $useMinMax = false;
            if (isset($todayAdvs['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::TODAY_ADVS, $todayAdvs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($todayAdvs['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::TODAY_ADVS, $todayAdvs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::TODAY_ADVS, $todayAdvs, $comparison);
    }

    /**
     * Filter the query on the google_advs column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogleAdvs(1234); // WHERE google_advs = 1234
     * $query->filterByGoogleAdvs(array(12, 34)); // WHERE google_advs IN (12, 34)
     * $query->filterByGoogleAdvs(array('min' => 12)); // WHERE google_advs >= 12
     * $query->filterByGoogleAdvs(array('max' => 12)); // WHERE google_advs <= 12
     * </code>
     *
     * @param     mixed $googleAdvs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByGoogleAdvs($googleAdvs = null, $comparison = null)
    {
        if (is_array($googleAdvs)) {
            $useMinMax = false;
            if (isset($googleAdvs['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::GOOGLE_ADVS, $googleAdvs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($googleAdvs['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::GOOGLE_ADVS, $googleAdvs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::GOOGLE_ADVS, $googleAdvs, $comparison);
    }

    /**
     * Filter the query on the yandex_advs column
     *
     * Example usage:
     * <code>
     * $query->filterByYandexAdvs(1234); // WHERE yandex_advs = 1234
     * $query->filterByYandexAdvs(array(12, 34)); // WHERE yandex_advs IN (12, 34)
     * $query->filterByYandexAdvs(array('min' => 12)); // WHERE yandex_advs >= 12
     * $query->filterByYandexAdvs(array('max' => 12)); // WHERE yandex_advs <= 12
     * </code>
     *
     * @param     mixed $yandexAdvs The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByYandexAdvs($yandexAdvs = null, $comparison = null)
    {
        if (is_array($yandexAdvs)) {
            $useMinMax = false;
            if (isset($yandexAdvs['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::YANDEX_ADVS, $yandexAdvs['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($yandexAdvs['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::YANDEX_ADVS, $yandexAdvs['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::YANDEX_ADVS, $yandexAdvs, $comparison);
    }

    /**
     * Filter the query on the companies column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanies(1234); // WHERE companies = 1234
     * $query->filterByCompanies(array(12, 34)); // WHERE companies IN (12, 34)
     * $query->filterByCompanies(array('min' => 12)); // WHERE companies >= 12
     * $query->filterByCompanies(array('max' => 12)); // WHERE companies <= 12
     * </code>
     *
     * @param     mixed $companies The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByCompanies($companies = null, $comparison = null)
    {
        if (is_array($companies)) {
            $useMinMax = false;
            if (isset($companies['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::COMPANIES, $companies['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($companies['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::COMPANIES, $companies['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::COMPANIES, $companies, $comparison);
    }

    /**
     * Filter the query on the twitter column
     *
     * Example usage:
     * <code>
     * $query->filterByTwitter(1234); // WHERE twitter = 1234
     * $query->filterByTwitter(array(12, 34)); // WHERE twitter IN (12, 34)
     * $query->filterByTwitter(array('min' => 12)); // WHERE twitter >= 12
     * $query->filterByTwitter(array('max' => 12)); // WHERE twitter <= 12
     * </code>
     *
     * @param     mixed $twitter The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByTwitter($twitter = null, $comparison = null)
    {
        if (is_array($twitter)) {
            $useMinMax = false;
            if (isset($twitter['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::TWITTER, $twitter['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($twitter['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::TWITTER, $twitter['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::TWITTER, $twitter, $comparison);
    }

    /**
     * Filter the query on the facebook column
     *
     * Example usage:
     * <code>
     * $query->filterByFacebook(1234); // WHERE facebook = 1234
     * $query->filterByFacebook(array(12, 34)); // WHERE facebook IN (12, 34)
     * $query->filterByFacebook(array('min' => 12)); // WHERE facebook >= 12
     * $query->filterByFacebook(array('max' => 12)); // WHERE facebook <= 12
     * </code>
     *
     * @param     mixed $facebook The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByFacebook($facebook = null, $comparison = null)
    {
        if (is_array($facebook)) {
            $useMinMax = false;
            if (isset($facebook['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::FACEBOOK, $facebook['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($facebook['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::FACEBOOK, $facebook['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::FACEBOOK, $facebook, $comparison);
    }

    /**
     * Filter the query on the vk column
     *
     * Example usage:
     * <code>
     * $query->filterByVk(1234); // WHERE vk = 1234
     * $query->filterByVk(array(12, 34)); // WHERE vk IN (12, 34)
     * $query->filterByVk(array('min' => 12)); // WHERE vk >= 12
     * $query->filterByVk(array('max' => 12)); // WHERE vk <= 12
     * </code>
     *
     * @param     mixed $vk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByVk($vk = null, $comparison = null)
    {
        if (is_array($vk)) {
            $useMinMax = false;
            if (isset($vk['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::VK, $vk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vk['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::VK, $vk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::VK, $vk, $comparison);
    }

    /**
     * Filter the query on the ok column
     *
     * Example usage:
     * <code>
     * $query->filterByOk(1234); // WHERE ok = 1234
     * $query->filterByOk(array(12, 34)); // WHERE ok IN (12, 34)
     * $query->filterByOk(array('min' => 12)); // WHERE ok >= 12
     * $query->filterByOk(array('max' => 12)); // WHERE ok <= 12
     * </code>
     *
     * @param     mixed $ok The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByOk($ok = null, $comparison = null)
    {
        if (is_array($ok)) {
            $useMinMax = false;
            if (isset($ok['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::OK, $ok['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($ok['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::OK, $ok['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::OK, $ok, $comparison);
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
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(SiteHistoryPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(SiteHistoryPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteHistoryPeer::DATE, $date, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   SiteHistory $siteHistory Object to remove from the list of results
     *
     * @return SiteHistoryQuery The current query, for fluid interface
     */
    public function prune($siteHistory = null)
    {
        if ($siteHistory) {
            $this->addUsingAlias(SiteHistoryPeer::ID, $siteHistory->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
