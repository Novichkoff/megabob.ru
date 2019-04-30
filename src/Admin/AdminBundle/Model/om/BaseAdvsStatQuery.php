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
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsStat;
use Admin\AdminBundle\Model\AdvsStatPeer;
use Admin\AdminBundle\Model\AdvsStatQuery;

/**
 * @method AdvsStatQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdvsStatQuery orderByAdvId($order = Criteria::ASC) Order by the adv_id column
 * @method AdvsStatQuery orderByShows($order = Criteria::ASC) Order by the shows column
 * @method AdvsStatQuery orderByClicks($order = Criteria::ASC) Order by the clicks column
 * @method AdvsStatQuery orderByStatDate($order = Criteria::ASC) Order by the stat_date column
 *
 * @method AdvsStatQuery groupById() Group by the id column
 * @method AdvsStatQuery groupByAdvId() Group by the adv_id column
 * @method AdvsStatQuery groupByShows() Group by the shows column
 * @method AdvsStatQuery groupByClicks() Group by the clicks column
 * @method AdvsStatQuery groupByStatDate() Group by the stat_date column
 *
 * @method AdvsStatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdvsStatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdvsStatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdvsStatQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method AdvsStatQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method AdvsStatQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method AdvsStat findOne(PropelPDO $con = null) Return the first AdvsStat matching the query
 * @method AdvsStat findOneOrCreate(PropelPDO $con = null) Return the first AdvsStat matching the query, or a new AdvsStat object populated from the query conditions when no match is found
 *
 * @method AdvsStat findOneByAdvId(int $adv_id) Return the first AdvsStat filtered by the adv_id column
 * @method AdvsStat findOneByShows(int $shows) Return the first AdvsStat filtered by the shows column
 * @method AdvsStat findOneByClicks(int $clicks) Return the first AdvsStat filtered by the clicks column
 * @method AdvsStat findOneByStatDate(string $stat_date) Return the first AdvsStat filtered by the stat_date column
 *
 * @method array findById(int $id) Return AdvsStat objects filtered by the id column
 * @method array findByAdvId(int $adv_id) Return AdvsStat objects filtered by the adv_id column
 * @method array findByShows(int $shows) Return AdvsStat objects filtered by the shows column
 * @method array findByClicks(int $clicks) Return AdvsStat objects filtered by the clicks column
 * @method array findByStatDate(string $stat_date) Return AdvsStat objects filtered by the stat_date column
 */
abstract class BaseAdvsStatQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdvsStatQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdvsStat';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdvsStatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdvsStatQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdvsStatQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdvsStatQuery) {
            return $criteria;
        }
        $query = new AdvsStatQuery(null, null, $modelAlias);

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
     * @return   AdvsStat|AdvsStat[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdvsStatPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdvsStatPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdvsStat A model object, or null if the key is not found
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
     * @return                 AdvsStat A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `adv_id`, `shows`, `clicks`, `stat_date` FROM `advs_stat` WHERE `id` = :p0';
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
            $obj = new AdvsStat();
            $obj->hydrate($row);
            AdvsStatPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdvsStat|AdvsStat[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdvsStat[]|mixed the list of results, formatted by the current formatter
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
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdvsStatPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdvsStatPeer::ID, $keys, Criteria::IN);
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
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvsStatPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvsStatPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsStatPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the adv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdvId(1234); // WHERE adv_id = 1234
     * $query->filterByAdvId(array(12, 34)); // WHERE adv_id IN (12, 34)
     * $query->filterByAdvId(array('min' => 12)); // WHERE adv_id >= 12
     * $query->filterByAdvId(array('max' => 12)); // WHERE adv_id <= 12
     * </code>
     *
     * @see       filterByAdvs()
     *
     * @param     mixed $advId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterByAdvId($advId = null, $comparison = null)
    {
        if (is_array($advId)) {
            $useMinMax = false;
            if (isset($advId['min'])) {
                $this->addUsingAlias(AdvsStatPeer::ADV_ID, $advId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advId['max'])) {
                $this->addUsingAlias(AdvsStatPeer::ADV_ID, $advId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsStatPeer::ADV_ID, $advId, $comparison);
    }

    /**
     * Filter the query on the shows column
     *
     * Example usage:
     * <code>
     * $query->filterByShows(1234); // WHERE shows = 1234
     * $query->filterByShows(array(12, 34)); // WHERE shows IN (12, 34)
     * $query->filterByShows(array('min' => 12)); // WHERE shows >= 12
     * $query->filterByShows(array('max' => 12)); // WHERE shows <= 12
     * </code>
     *
     * @param     mixed $shows The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterByShows($shows = null, $comparison = null)
    {
        if (is_array($shows)) {
            $useMinMax = false;
            if (isset($shows['min'])) {
                $this->addUsingAlias(AdvsStatPeer::SHOWS, $shows['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shows['max'])) {
                $this->addUsingAlias(AdvsStatPeer::SHOWS, $shows['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsStatPeer::SHOWS, $shows, $comparison);
    }

    /**
     * Filter the query on the clicks column
     *
     * Example usage:
     * <code>
     * $query->filterByClicks(1234); // WHERE clicks = 1234
     * $query->filterByClicks(array(12, 34)); // WHERE clicks IN (12, 34)
     * $query->filterByClicks(array('min' => 12)); // WHERE clicks >= 12
     * $query->filterByClicks(array('max' => 12)); // WHERE clicks <= 12
     * </code>
     *
     * @param     mixed $clicks The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterByClicks($clicks = null, $comparison = null)
    {
        if (is_array($clicks)) {
            $useMinMax = false;
            if (isset($clicks['min'])) {
                $this->addUsingAlias(AdvsStatPeer::CLICKS, $clicks['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clicks['max'])) {
                $this->addUsingAlias(AdvsStatPeer::CLICKS, $clicks['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsStatPeer::CLICKS, $clicks, $comparison);
    }

    /**
     * Filter the query on the stat_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStatDate('2011-03-14'); // WHERE stat_date = '2011-03-14'
     * $query->filterByStatDate('now'); // WHERE stat_date = '2011-03-14'
     * $query->filterByStatDate(array('max' => 'yesterday')); // WHERE stat_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $statDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function filterByStatDate($statDate = null, $comparison = null)
    {
        if (is_array($statDate)) {
            $useMinMax = false;
            if (isset($statDate['min'])) {
                $this->addUsingAlias(AdvsStatPeer::STAT_DATE, $statDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statDate['max'])) {
                $this->addUsingAlias(AdvsStatPeer::STAT_DATE, $statDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsStatPeer::STAT_DATE, $statDate, $comparison);
    }

    /**
     * Filter the query by a related Advs object
     *
     * @param   Advs|PropelObjectCollection $advs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsStatQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(AdvsStatPeer::ADV_ID, $advs->getId(), $comparison);
        } elseif ($advs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvsStatPeer::ADV_ID, $advs->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdvs() only accepts arguments of type Advs or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Advs relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function joinAdvs($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Advs');

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
            $this->addJoinObject($join, 'Advs');
        }

        return $this;
    }

    /**
     * Use the Advs relation Advs object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvsQuery A secondary query class using the current class as primary query
     */
    public function useAdvsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvs($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Advs', '\Admin\AdminBundle\Model\AdvsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AdvsStat $advsStat Object to remove from the list of results
     *
     * @return AdvsStatQuery The current query, for fluid interface
     */
    public function prune($advsStat = null)
    {
        if ($advsStat) {
            $this->addUsingAlias(AdvsStatPeer::ID, $advsStat->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
