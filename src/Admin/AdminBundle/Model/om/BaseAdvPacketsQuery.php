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
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Model\AdvPacketsPeer;
use Admin\AdminBundle\Model\AdvPacketsQuery;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\Packets;

/**
 * @method AdvPacketsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdvPacketsQuery orderByAdvId($order = Criteria::ASC) Order by the adv_id column
 * @method AdvPacketsQuery orderByPacketId($order = Criteria::ASC) Order by the packet_id column
 * @method AdvPacketsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method AdvPacketsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method AdvPacketsQuery orderByPaid($order = Criteria::ASC) Order by the paid column
 * @method AdvPacketsQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method AdvPacketsQuery orderByUseBefore($order = Criteria::ASC) Order by the use_before column
 * @method AdvPacketsQuery orderByPaidDate($order = Criteria::ASC) Order by the paid_date column
 *
 * @method AdvPacketsQuery groupById() Group by the id column
 * @method AdvPacketsQuery groupByAdvId() Group by the adv_id column
 * @method AdvPacketsQuery groupByPacketId() Group by the packet_id column
 * @method AdvPacketsQuery groupByEnabled() Group by the enabled column
 * @method AdvPacketsQuery groupByDeleted() Group by the deleted column
 * @method AdvPacketsQuery groupByPaid() Group by the paid column
 * @method AdvPacketsQuery groupByDate() Group by the date column
 * @method AdvPacketsQuery groupByUseBefore() Group by the use_before column
 * @method AdvPacketsQuery groupByPaidDate() Group by the paid_date column
 *
 * @method AdvPacketsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdvPacketsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdvPacketsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdvPacketsQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method AdvPacketsQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method AdvPacketsQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method AdvPacketsQuery leftJoinPackets($relationAlias = null) Adds a LEFT JOIN clause to the query using the Packets relation
 * @method AdvPacketsQuery rightJoinPackets($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Packets relation
 * @method AdvPacketsQuery innerJoinPackets($relationAlias = null) Adds a INNER JOIN clause to the query using the Packets relation
 *
 * @method AdvPackets findOne(PropelPDO $con = null) Return the first AdvPackets matching the query
 * @method AdvPackets findOneOrCreate(PropelPDO $con = null) Return the first AdvPackets matching the query, or a new AdvPackets object populated from the query conditions when no match is found
 *
 * @method AdvPackets findOneByAdvId(int $adv_id) Return the first AdvPackets filtered by the adv_id column
 * @method AdvPackets findOneByPacketId(int $packet_id) Return the first AdvPackets filtered by the packet_id column
 * @method AdvPackets findOneByEnabled(boolean $enabled) Return the first AdvPackets filtered by the enabled column
 * @method AdvPackets findOneByDeleted(boolean $deleted) Return the first AdvPackets filtered by the deleted column
 * @method AdvPackets findOneByPaid(boolean $paid) Return the first AdvPackets filtered by the paid column
 * @method AdvPackets findOneByDate(string $date) Return the first AdvPackets filtered by the date column
 * @method AdvPackets findOneByUseBefore(string $use_before) Return the first AdvPackets filtered by the use_before column
 * @method AdvPackets findOneByPaidDate(string $paid_date) Return the first AdvPackets filtered by the paid_date column
 *
 * @method array findById(int $id) Return AdvPackets objects filtered by the id column
 * @method array findByAdvId(int $adv_id) Return AdvPackets objects filtered by the adv_id column
 * @method array findByPacketId(int $packet_id) Return AdvPackets objects filtered by the packet_id column
 * @method array findByEnabled(boolean $enabled) Return AdvPackets objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return AdvPackets objects filtered by the deleted column
 * @method array findByPaid(boolean $paid) Return AdvPackets objects filtered by the paid column
 * @method array findByDate(string $date) Return AdvPackets objects filtered by the date column
 * @method array findByUseBefore(string $use_before) Return AdvPackets objects filtered by the use_before column
 * @method array findByPaidDate(string $paid_date) Return AdvPackets objects filtered by the paid_date column
 */
abstract class BaseAdvPacketsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdvPacketsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdvPackets';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdvPacketsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdvPacketsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdvPacketsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdvPacketsQuery) {
            return $criteria;
        }
        $query = new AdvPacketsQuery(null, null, $modelAlias);

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
     * @return   AdvPackets|AdvPackets[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdvPacketsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdvPacketsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdvPackets A model object, or null if the key is not found
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
     * @return                 AdvPackets A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `adv_id`, `packet_id`, `enabled`, `deleted`, `paid`, `date`, `use_before`, `paid_date` FROM `adv_packets` WHERE `id` = :p0';
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
            $obj = new AdvPackets();
            $obj->hydrate($row);
            AdvPacketsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdvPackets|AdvPackets[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdvPackets[]|mixed the list of results, formatted by the current formatter
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdvPacketsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdvPacketsPeer::ID, $keys, Criteria::IN);
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvPacketsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvPacketsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvPacketsPeer::ID, $id, $comparison);
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByAdvId($advId = null, $comparison = null)
    {
        if (is_array($advId)) {
            $useMinMax = false;
            if (isset($advId['min'])) {
                $this->addUsingAlias(AdvPacketsPeer::ADV_ID, $advId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advId['max'])) {
                $this->addUsingAlias(AdvPacketsPeer::ADV_ID, $advId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvPacketsPeer::ADV_ID, $advId, $comparison);
    }

    /**
     * Filter the query on the packet_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPacketId(1234); // WHERE packet_id = 1234
     * $query->filterByPacketId(array(12, 34)); // WHERE packet_id IN (12, 34)
     * $query->filterByPacketId(array('min' => 12)); // WHERE packet_id >= 12
     * $query->filterByPacketId(array('max' => 12)); // WHERE packet_id <= 12
     * </code>
     *
     * @see       filterByPackets()
     *
     * @param     mixed $packetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByPacketId($packetId = null, $comparison = null)
    {
        if (is_array($packetId)) {
            $useMinMax = false;
            if (isset($packetId['min'])) {
                $this->addUsingAlias(AdvPacketsPeer::PACKET_ID, $packetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packetId['max'])) {
                $this->addUsingAlias(AdvPacketsPeer::PACKET_ID, $packetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvPacketsPeer::PACKET_ID, $packetId, $comparison);
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvPacketsPeer::ENABLED, $enabled, $comparison);
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvPacketsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query on the paid column
     *
     * Example usage:
     * <code>
     * $query->filterByPaid(true); // WHERE paid = true
     * $query->filterByPaid('yes'); // WHERE paid = true
     * </code>
     *
     * @param     boolean|string $paid The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByPaid($paid = null, $comparison = null)
    {
        if (is_string($paid)) {
            $paid = in_array(strtolower($paid), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvPacketsPeer::PAID, $paid, $comparison);
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(AdvPacketsPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(AdvPacketsPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvPacketsPeer::DATE, $date, $comparison);
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
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByUseBefore($useBefore = null, $comparison = null)
    {
        if (is_array($useBefore)) {
            $useMinMax = false;
            if (isset($useBefore['min'])) {
                $this->addUsingAlias(AdvPacketsPeer::USE_BEFORE, $useBefore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useBefore['max'])) {
                $this->addUsingAlias(AdvPacketsPeer::USE_BEFORE, $useBefore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvPacketsPeer::USE_BEFORE, $useBefore, $comparison);
    }

    /**
     * Filter the query on the paid_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPaidDate('2011-03-14'); // WHERE paid_date = '2011-03-14'
     * $query->filterByPaidDate('now'); // WHERE paid_date = '2011-03-14'
     * $query->filterByPaidDate(array('max' => 'yesterday')); // WHERE paid_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $paidDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function filterByPaidDate($paidDate = null, $comparison = null)
    {
        if (is_array($paidDate)) {
            $useMinMax = false;
            if (isset($paidDate['min'])) {
                $this->addUsingAlias(AdvPacketsPeer::PAID_DATE, $paidDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paidDate['max'])) {
                $this->addUsingAlias(AdvPacketsPeer::PAID_DATE, $paidDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvPacketsPeer::PAID_DATE, $paidDate, $comparison);
    }

    /**
     * Filter the query by a related Advs object
     *
     * @param   Advs|PropelObjectCollection $advs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvPacketsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(AdvPacketsPeer::ADV_ID, $advs->getId(), $comparison);
        } elseif ($advs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvPacketsPeer::ADV_ID, $advs->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdvPacketsQuery The current query, for fluid interface
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
     * Filter the query by a related Packets object
     *
     * @param   Packets|PropelObjectCollection $packets The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvPacketsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPackets($packets, $comparison = null)
    {
        if ($packets instanceof Packets) {
            return $this
                ->addUsingAlias(AdvPacketsPeer::PACKET_ID, $packets->getId(), $comparison);
        } elseif ($packets instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvPacketsPeer::PACKET_ID, $packets->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPackets() only accepts arguments of type Packets or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Packets relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function joinPackets($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Packets');

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
            $this->addJoinObject($join, 'Packets');
        }

        return $this;
    }

    /**
     * Use the Packets relation Packets object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\PacketsQuery A secondary query class using the current class as primary query
     */
    public function usePacketsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPackets($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Packets', '\Admin\AdminBundle\Model\PacketsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AdvPackets $advPackets Object to remove from the list of results
     *
     * @return AdvPacketsQuery The current query, for fluid interface
     */
    public function prune($advPackets = null)
    {
        if ($advPackets) {
            $this->addUsingAlias(AdvPacketsPeer::ID, $advPackets->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
