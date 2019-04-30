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
use Admin\AdminBundle\Model\AdvModify;
use Admin\AdminBundle\Model\AdvModifyPeer;
use Admin\AdminBundle\Model\AdvModifyQuery;
use Admin\AdminBundle\Model\Advs;

/**
 * @method AdvModifyQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdvModifyQuery orderByAdvId($order = Criteria::ASC) Order by the adv_id column
 * @method AdvModifyQuery orderByPriceOld($order = Criteria::ASC) Order by the price_old column
 * @method AdvModifyQuery orderByPriceNew($order = Criteria::ASC) Order by the price_new column
 * @method AdvModifyQuery orderByDate($order = Criteria::ASC) Order by the date column
 *
 * @method AdvModifyQuery groupById() Group by the id column
 * @method AdvModifyQuery groupByAdvId() Group by the adv_id column
 * @method AdvModifyQuery groupByPriceOld() Group by the price_old column
 * @method AdvModifyQuery groupByPriceNew() Group by the price_new column
 * @method AdvModifyQuery groupByDate() Group by the date column
 *
 * @method AdvModifyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdvModifyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdvModifyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdvModifyQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method AdvModifyQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method AdvModifyQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method AdvModify findOne(PropelPDO $con = null) Return the first AdvModify matching the query
 * @method AdvModify findOneOrCreate(PropelPDO $con = null) Return the first AdvModify matching the query, or a new AdvModify object populated from the query conditions when no match is found
 *
 * @method AdvModify findOneByAdvId(int $adv_id) Return the first AdvModify filtered by the adv_id column
 * @method AdvModify findOneByPriceOld(int $price_old) Return the first AdvModify filtered by the price_old column
 * @method AdvModify findOneByPriceNew(int $price_new) Return the first AdvModify filtered by the price_new column
 * @method AdvModify findOneByDate(string $date) Return the first AdvModify filtered by the date column
 *
 * @method array findById(int $id) Return AdvModify objects filtered by the id column
 * @method array findByAdvId(int $adv_id) Return AdvModify objects filtered by the adv_id column
 * @method array findByPriceOld(int $price_old) Return AdvModify objects filtered by the price_old column
 * @method array findByPriceNew(int $price_new) Return AdvModify objects filtered by the price_new column
 * @method array findByDate(string $date) Return AdvModify objects filtered by the date column
 */
abstract class BaseAdvModifyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdvModifyQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdvModify';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdvModifyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdvModifyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdvModifyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdvModifyQuery) {
            return $criteria;
        }
        $query = new AdvModifyQuery(null, null, $modelAlias);

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
     * @return   AdvModify|AdvModify[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdvModifyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdvModifyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdvModify A model object, or null if the key is not found
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
     * @return                 AdvModify A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `adv_id`, `price_old`, `price_new`, `date` FROM `adv_modify` WHERE `id` = :p0';
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
            $obj = new AdvModify();
            $obj->hydrate($row);
            AdvModifyPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdvModify|AdvModify[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdvModify[]|mixed the list of results, formatted by the current formatter
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
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdvModifyPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdvModifyPeer::ID, $keys, Criteria::IN);
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
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvModifyPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvModifyPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvModifyPeer::ID, $id, $comparison);
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
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterByAdvId($advId = null, $comparison = null)
    {
        if (is_array($advId)) {
            $useMinMax = false;
            if (isset($advId['min'])) {
                $this->addUsingAlias(AdvModifyPeer::ADV_ID, $advId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advId['max'])) {
                $this->addUsingAlias(AdvModifyPeer::ADV_ID, $advId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvModifyPeer::ADV_ID, $advId, $comparison);
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
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterByPriceOld($priceOld = null, $comparison = null)
    {
        if (is_array($priceOld)) {
            $useMinMax = false;
            if (isset($priceOld['min'])) {
                $this->addUsingAlias(AdvModifyPeer::PRICE_OLD, $priceOld['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceOld['max'])) {
                $this->addUsingAlias(AdvModifyPeer::PRICE_OLD, $priceOld['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvModifyPeer::PRICE_OLD, $priceOld, $comparison);
    }

    /**
     * Filter the query on the price_new column
     *
     * Example usage:
     * <code>
     * $query->filterByPriceNew(1234); // WHERE price_new = 1234
     * $query->filterByPriceNew(array(12, 34)); // WHERE price_new IN (12, 34)
     * $query->filterByPriceNew(array('min' => 12)); // WHERE price_new >= 12
     * $query->filterByPriceNew(array('max' => 12)); // WHERE price_new <= 12
     * </code>
     *
     * @param     mixed $priceNew The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterByPriceNew($priceNew = null, $comparison = null)
    {
        if (is_array($priceNew)) {
            $useMinMax = false;
            if (isset($priceNew['min'])) {
                $this->addUsingAlias(AdvModifyPeer::PRICE_NEW, $priceNew['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($priceNew['max'])) {
                $this->addUsingAlias(AdvModifyPeer::PRICE_NEW, $priceNew['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvModifyPeer::PRICE_NEW, $priceNew, $comparison);
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
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(AdvModifyPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(AdvModifyPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvModifyPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query by a related Advs object
     *
     * @param   Advs|PropelObjectCollection $advs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvModifyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(AdvModifyPeer::ADV_ID, $advs->getId(), $comparison);
        } elseif ($advs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvModifyPeer::ADV_ID, $advs->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdvModifyQuery The current query, for fluid interface
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
     * @param   AdvModify $advModify Object to remove from the list of results
     *
     * @return AdvModifyQuery The current query, for fluid interface
     */
    public function prune($advModify = null)
    {
        if ($advModify) {
            $this->addUsingAlias(AdvModifyPeer::ID, $advModify->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
