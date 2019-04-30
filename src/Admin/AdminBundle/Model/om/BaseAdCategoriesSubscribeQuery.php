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
use Admin\AdminBundle\Model\AdCategories;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\AdCategoriesSubscribePeer;
use Admin\AdminBundle\Model\AdCategoriesSubscribeQuery;
use Admin\AdminBundle\Model\Areas;
use Admin\AdminBundle\Model\Regions;

/**
 * @method AdCategoriesSubscribeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdCategoriesSubscribeQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method AdCategoriesSubscribeQuery orderByTownId($order = Criteria::ASC) Order by the town_id column
 * @method AdCategoriesSubscribeQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method AdCategoriesSubscribeQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method AdCategoriesSubscribeQuery orderByUnsubscribeCode($order = Criteria::ASC) Order by the unsubscribe_code column
 * @method AdCategoriesSubscribeQuery orderByLastAdvId($order = Criteria::ASC) Order by the last_adv_id column
 * @method AdCategoriesSubscribeQuery orderByCnt($order = Criteria::ASC) Order by the cnt column
 *
 * @method AdCategoriesSubscribeQuery groupById() Group by the id column
 * @method AdCategoriesSubscribeQuery groupByCategoryId() Group by the category_id column
 * @method AdCategoriesSubscribeQuery groupByTownId() Group by the town_id column
 * @method AdCategoriesSubscribeQuery groupByAreaId() Group by the area_id column
 * @method AdCategoriesSubscribeQuery groupByEmail() Group by the email column
 * @method AdCategoriesSubscribeQuery groupByUnsubscribeCode() Group by the unsubscribe_code column
 * @method AdCategoriesSubscribeQuery groupByLastAdvId() Group by the last_adv_id column
 * @method AdCategoriesSubscribeQuery groupByCnt() Group by the cnt column
 *
 * @method AdCategoriesSubscribeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdCategoriesSubscribeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdCategoriesSubscribeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdCategoriesSubscribeQuery leftJoinAdCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategories relation
 * @method AdCategoriesSubscribeQuery rightJoinAdCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategories relation
 * @method AdCategoriesSubscribeQuery innerJoinAdCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategories relation
 *
 * @method AdCategoriesSubscribeQuery leftJoinRegions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Regions relation
 * @method AdCategoriesSubscribeQuery rightJoinRegions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Regions relation
 * @method AdCategoriesSubscribeQuery innerJoinRegions($relationAlias = null) Adds a INNER JOIN clause to the query using the Regions relation
 *
 * @method AdCategoriesSubscribeQuery leftJoinAreas($relationAlias = null) Adds a LEFT JOIN clause to the query using the Areas relation
 * @method AdCategoriesSubscribeQuery rightJoinAreas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Areas relation
 * @method AdCategoriesSubscribeQuery innerJoinAreas($relationAlias = null) Adds a INNER JOIN clause to the query using the Areas relation
 *
 * @method AdCategoriesSubscribe findOne(PropelPDO $con = null) Return the first AdCategoriesSubscribe matching the query
 * @method AdCategoriesSubscribe findOneOrCreate(PropelPDO $con = null) Return the first AdCategoriesSubscribe matching the query, or a new AdCategoriesSubscribe object populated from the query conditions when no match is found
 *
 * @method AdCategoriesSubscribe findOneByCategoryId(int $category_id) Return the first AdCategoriesSubscribe filtered by the category_id column
 * @method AdCategoriesSubscribe findOneByTownId(int $town_id) Return the first AdCategoriesSubscribe filtered by the town_id column
 * @method AdCategoriesSubscribe findOneByAreaId(int $area_id) Return the first AdCategoriesSubscribe filtered by the area_id column
 * @method AdCategoriesSubscribe findOneByEmail(string $email) Return the first AdCategoriesSubscribe filtered by the email column
 * @method AdCategoriesSubscribe findOneByUnsubscribeCode(string $unsubscribe_code) Return the first AdCategoriesSubscribe filtered by the unsubscribe_code column
 * @method AdCategoriesSubscribe findOneByLastAdvId(int $last_adv_id) Return the first AdCategoriesSubscribe filtered by the last_adv_id column
 * @method AdCategoriesSubscribe findOneByCnt(int $cnt) Return the first AdCategoriesSubscribe filtered by the cnt column
 *
 * @method array findById(int $id) Return AdCategoriesSubscribe objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return AdCategoriesSubscribe objects filtered by the category_id column
 * @method array findByTownId(int $town_id) Return AdCategoriesSubscribe objects filtered by the town_id column
 * @method array findByAreaId(int $area_id) Return AdCategoriesSubscribe objects filtered by the area_id column
 * @method array findByEmail(string $email) Return AdCategoriesSubscribe objects filtered by the email column
 * @method array findByUnsubscribeCode(string $unsubscribe_code) Return AdCategoriesSubscribe objects filtered by the unsubscribe_code column
 * @method array findByLastAdvId(int $last_adv_id) Return AdCategoriesSubscribe objects filtered by the last_adv_id column
 * @method array findByCnt(int $cnt) Return AdCategoriesSubscribe objects filtered by the cnt column
 */
abstract class BaseAdCategoriesSubscribeQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdCategoriesSubscribeQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdCategoriesSubscribe';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdCategoriesSubscribeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdCategoriesSubscribeQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdCategoriesSubscribeQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdCategoriesSubscribeQuery) {
            return $criteria;
        }
        $query = new AdCategoriesSubscribeQuery(null, null, $modelAlias);

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
     * @return   AdCategoriesSubscribe|AdCategoriesSubscribe[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdCategoriesSubscribePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesSubscribePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdCategoriesSubscribe A model object, or null if the key is not found
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
     * @return                 AdCategoriesSubscribe A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `town_id`, `area_id`, `email`, `unsubscribe_code`, `last_adv_id`, `cnt` FROM `ad_categories_subscribe` WHERE `id` = :p0';
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
            $obj = new AdCategoriesSubscribe();
            $obj->hydrate($row);
            AdCategoriesSubscribePeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdCategoriesSubscribe|AdCategoriesSubscribe[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdCategoriesSubscribe[]|mixed the list of results, formatted by the current formatter
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
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdCategoriesSubscribePeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdCategoriesSubscribePeer::ID, $keys, Criteria::IN);
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
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::ID, $id, $comparison);
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
     * @see       filterByAdCategories()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the town_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTownId(1234); // WHERE town_id = 1234
     * $query->filterByTownId(array(12, 34)); // WHERE town_id IN (12, 34)
     * $query->filterByTownId(array('min' => 12)); // WHERE town_id >= 12
     * $query->filterByTownId(array('max' => 12)); // WHERE town_id <= 12
     * </code>
     *
     * @see       filterByRegions()
     *
     * @param     mixed $townId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByTownId($townId = null, $comparison = null)
    {
        if (is_array($townId)) {
            $useMinMax = false;
            if (isset($townId['min'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::TOWN_ID, $townId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($townId['max'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::TOWN_ID, $townId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::TOWN_ID, $townId, $comparison);
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
     * @see       filterByAreas()
     *
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::AREA_ID, $areaId, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the unsubscribe_code column
     *
     * Example usage:
     * <code>
     * $query->filterByUnsubscribeCode('fooValue');   // WHERE unsubscribe_code = 'fooValue'
     * $query->filterByUnsubscribeCode('%fooValue%'); // WHERE unsubscribe_code LIKE '%fooValue%'
     * </code>
     *
     * @param     string $unsubscribeCode The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByUnsubscribeCode($unsubscribeCode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($unsubscribeCode)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $unsubscribeCode)) {
                $unsubscribeCode = str_replace('*', '%', $unsubscribeCode);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::UNSUBSCRIBE_CODE, $unsubscribeCode, $comparison);
    }

    /**
     * Filter the query on the last_adv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByLastAdvId(1234); // WHERE last_adv_id = 1234
     * $query->filterByLastAdvId(array(12, 34)); // WHERE last_adv_id IN (12, 34)
     * $query->filterByLastAdvId(array('min' => 12)); // WHERE last_adv_id >= 12
     * $query->filterByLastAdvId(array('max' => 12)); // WHERE last_adv_id <= 12
     * </code>
     *
     * @param     mixed $lastAdvId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByLastAdvId($lastAdvId = null, $comparison = null)
    {
        if (is_array($lastAdvId)) {
            $useMinMax = false;
            if (isset($lastAdvId['min'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::LAST_ADV_ID, $lastAdvId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastAdvId['max'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::LAST_ADV_ID, $lastAdvId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::LAST_ADV_ID, $lastAdvId, $comparison);
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
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function filterByCnt($cnt = null, $comparison = null)
    {
        if (is_array($cnt)) {
            $useMinMax = false;
            if (isset($cnt['min'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::CNT, $cnt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cnt['max'])) {
                $this->addUsingAlias(AdCategoriesSubscribePeer::CNT, $cnt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesSubscribePeer::CNT, $cnt, $comparison);
    }

    /**
     * Filter the query by a related AdCategories object
     *
     * @param   AdCategories|PropelObjectCollection $adCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesSubscribeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategories($adCategories, $comparison = null)
    {
        if ($adCategories instanceof AdCategories) {
            return $this
                ->addUsingAlias(AdCategoriesSubscribePeer::CATEGORY_ID, $adCategories->getId(), $comparison);
        } elseif ($adCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesSubscribePeer::CATEGORY_ID, $adCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdCategories() only accepts arguments of type AdCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function joinAdCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategories');

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
            $this->addJoinObject($join, 'AdCategories');
        }

        return $this;
    }

    /**
     * Use the AdCategories relation AdCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategories', '\Admin\AdminBundle\Model\AdCategoriesQuery');
    }

    /**
     * Filter the query by a related Regions object
     *
     * @param   Regions|PropelObjectCollection $regions The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesSubscribeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRegions($regions, $comparison = null)
    {
        if ($regions instanceof Regions) {
            return $this
                ->addUsingAlias(AdCategoriesSubscribePeer::TOWN_ID, $regions->getId(), $comparison);
        } elseif ($regions instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesSubscribePeer::TOWN_ID, $regions->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function joinRegions($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useRegionsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRegions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Regions', '\Admin\AdminBundle\Model\RegionsQuery');
    }

    /**
     * Filter the query by a related Areas object
     *
     * @param   Areas|PropelObjectCollection $areas The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesSubscribeQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAreas($areas, $comparison = null)
    {
        if ($areas instanceof Areas) {
            return $this
                ->addUsingAlias(AdCategoriesSubscribePeer::AREA_ID, $areas->getId(), $comparison);
        } elseif ($areas instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesSubscribePeer::AREA_ID, $areas->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAreas() only accepts arguments of type Areas or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Areas relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function joinAreas($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Areas');

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
            $this->addJoinObject($join, 'Areas');
        }

        return $this;
    }

    /**
     * Use the Areas relation Areas object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AreasQuery A secondary query class using the current class as primary query
     */
    public function useAreasQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAreas($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Areas', '\Admin\AdminBundle\Model\AreasQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AdCategoriesSubscribe $adCategoriesSubscribe Object to remove from the list of results
     *
     * @return AdCategoriesSubscribeQuery The current query, for fluid interface
     */
    public function prune($adCategoriesSubscribe = null)
    {
        if ($adCategoriesSubscribe) {
            $this->addUsingAlias(AdCategoriesSubscribePeer::ID, $adCategoriesSubscribe->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
