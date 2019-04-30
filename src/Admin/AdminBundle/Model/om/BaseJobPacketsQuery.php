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
use Admin\AdminBundle\Model\JobPackets;
use Admin\AdminBundle\Model\JobPacketsPeer;
use Admin\AdminBundle\Model\JobPacketsQuery;
use Admin\AdminBundle\Model\Jobs;
use Admin\AdminBundle\Model\Packets;

/**
 * @method JobPacketsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobPacketsQuery orderByJobId($order = Criteria::ASC) Order by the job_id column
 * @method JobPacketsQuery orderByPacketId($order = Criteria::ASC) Order by the packet_id column
 * @method JobPacketsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method JobPacketsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method JobPacketsQuery orderByPaid($order = Criteria::ASC) Order by the paid column
 * @method JobPacketsQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method JobPacketsQuery orderByUseBefore($order = Criteria::ASC) Order by the use_before column
 * @method JobPacketsQuery orderByPaidDate($order = Criteria::ASC) Order by the paid_date column
 *
 * @method JobPacketsQuery groupById() Group by the id column
 * @method JobPacketsQuery groupByJobId() Group by the job_id column
 * @method JobPacketsQuery groupByPacketId() Group by the packet_id column
 * @method JobPacketsQuery groupByEnabled() Group by the enabled column
 * @method JobPacketsQuery groupByDeleted() Group by the deleted column
 * @method JobPacketsQuery groupByPaid() Group by the paid column
 * @method JobPacketsQuery groupByDate() Group by the date column
 * @method JobPacketsQuery groupByUseBefore() Group by the use_before column
 * @method JobPacketsQuery groupByPaidDate() Group by the paid_date column
 *
 * @method JobPacketsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobPacketsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobPacketsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobPacketsQuery leftJoinJobs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Jobs relation
 * @method JobPacketsQuery rightJoinJobs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Jobs relation
 * @method JobPacketsQuery innerJoinJobs($relationAlias = null) Adds a INNER JOIN clause to the query using the Jobs relation
 *
 * @method JobPacketsQuery leftJoinPackets($relationAlias = null) Adds a LEFT JOIN clause to the query using the Packets relation
 * @method JobPacketsQuery rightJoinPackets($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Packets relation
 * @method JobPacketsQuery innerJoinPackets($relationAlias = null) Adds a INNER JOIN clause to the query using the Packets relation
 *
 * @method JobPackets findOne(PropelPDO $con = null) Return the first JobPackets matching the query
 * @method JobPackets findOneOrCreate(PropelPDO $con = null) Return the first JobPackets matching the query, or a new JobPackets object populated from the query conditions when no match is found
 *
 * @method JobPackets findOneByJobId(int $job_id) Return the first JobPackets filtered by the job_id column
 * @method JobPackets findOneByPacketId(int $packet_id) Return the first JobPackets filtered by the packet_id column
 * @method JobPackets findOneByEnabled(boolean $enabled) Return the first JobPackets filtered by the enabled column
 * @method JobPackets findOneByDeleted(boolean $deleted) Return the first JobPackets filtered by the deleted column
 * @method JobPackets findOneByPaid(boolean $paid) Return the first JobPackets filtered by the paid column
 * @method JobPackets findOneByDate(string $date) Return the first JobPackets filtered by the date column
 * @method JobPackets findOneByUseBefore(string $use_before) Return the first JobPackets filtered by the use_before column
 * @method JobPackets findOneByPaidDate(string $paid_date) Return the first JobPackets filtered by the paid_date column
 *
 * @method array findById(int $id) Return JobPackets objects filtered by the id column
 * @method array findByJobId(int $job_id) Return JobPackets objects filtered by the job_id column
 * @method array findByPacketId(int $packet_id) Return JobPackets objects filtered by the packet_id column
 * @method array findByEnabled(boolean $enabled) Return JobPackets objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return JobPackets objects filtered by the deleted column
 * @method array findByPaid(boolean $paid) Return JobPackets objects filtered by the paid column
 * @method array findByDate(string $date) Return JobPackets objects filtered by the date column
 * @method array findByUseBefore(string $use_before) Return JobPackets objects filtered by the use_before column
 * @method array findByPaidDate(string $paid_date) Return JobPackets objects filtered by the paid_date column
 */
abstract class BaseJobPacketsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobPacketsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\JobPackets';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobPacketsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobPacketsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobPacketsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobPacketsQuery) {
            return $criteria;
        }
        $query = new JobPacketsQuery(null, null, $modelAlias);

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
     * @return   JobPackets|JobPackets[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobPacketsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobPacketsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 JobPackets A model object, or null if the key is not found
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
     * @return                 JobPackets A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `job_id`, `packet_id`, `enabled`, `deleted`, `paid`, `date`, `use_before`, `paid_date` FROM `job_packets` WHERE `id` = :p0';
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
            $obj = new JobPackets();
            $obj->hydrate($row);
            JobPacketsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return JobPackets|JobPackets[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|JobPackets[]|mixed the list of results, formatted by the current formatter
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobPacketsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobPacketsPeer::ID, $keys, Criteria::IN);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobPacketsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobPacketsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobPacketsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the job_id column
     *
     * Example usage:
     * <code>
     * $query->filterByJobId(1234); // WHERE job_id = 1234
     * $query->filterByJobId(array(12, 34)); // WHERE job_id IN (12, 34)
     * $query->filterByJobId(array('min' => 12)); // WHERE job_id >= 12
     * $query->filterByJobId(array('max' => 12)); // WHERE job_id <= 12
     * </code>
     *
     * @see       filterByJobs()
     *
     * @param     mixed $jobId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByJobId($jobId = null, $comparison = null)
    {
        if (is_array($jobId)) {
            $useMinMax = false;
            if (isset($jobId['min'])) {
                $this->addUsingAlias(JobPacketsPeer::JOB_ID, $jobId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($jobId['max'])) {
                $this->addUsingAlias(JobPacketsPeer::JOB_ID, $jobId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobPacketsPeer::JOB_ID, $jobId, $comparison);
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
     * @param     mixed $packetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByPacketId($packetId = null, $comparison = null)
    {
        if (is_array($packetId)) {
            $useMinMax = false;
            if (isset($packetId['min'])) {
                $this->addUsingAlias(JobPacketsPeer::PACKET_ID, $packetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packetId['max'])) {
                $this->addUsingAlias(JobPacketsPeer::PACKET_ID, $packetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobPacketsPeer::PACKET_ID, $packetId, $comparison);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobPacketsPeer::ENABLED, $enabled, $comparison);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobPacketsPeer::DELETED, $deleted, $comparison);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByPaid($paid = null, $comparison = null)
    {
        if (is_string($paid)) {
            $paid = in_array(strtolower($paid), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobPacketsPeer::PAID, $paid, $comparison);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(JobPacketsPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(JobPacketsPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobPacketsPeer::DATE, $date, $comparison);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByUseBefore($useBefore = null, $comparison = null)
    {
        if (is_array($useBefore)) {
            $useMinMax = false;
            if (isset($useBefore['min'])) {
                $this->addUsingAlias(JobPacketsPeer::USE_BEFORE, $useBefore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useBefore['max'])) {
                $this->addUsingAlias(JobPacketsPeer::USE_BEFORE, $useBefore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobPacketsPeer::USE_BEFORE, $useBefore, $comparison);
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
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function filterByPaidDate($paidDate = null, $comparison = null)
    {
        if (is_array($paidDate)) {
            $useMinMax = false;
            if (isset($paidDate['min'])) {
                $this->addUsingAlias(JobPacketsPeer::PAID_DATE, $paidDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paidDate['max'])) {
                $this->addUsingAlias(JobPacketsPeer::PAID_DATE, $paidDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobPacketsPeer::PAID_DATE, $paidDate, $comparison);
    }

    /**
     * Filter the query by a related Jobs object
     *
     * @param   Jobs|PropelObjectCollection $jobs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobPacketsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobs($jobs, $comparison = null)
    {
        if ($jobs instanceof Jobs) {
            return $this
                ->addUsingAlias(JobPacketsPeer::JOB_ID, $jobs->getId(), $comparison);
        } elseif ($jobs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobPacketsPeer::JOB_ID, $jobs->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobs() only accepts arguments of type Jobs or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Jobs relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function joinJobs($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Jobs');

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
            $this->addJoinObject($join, 'Jobs');
        }

        return $this;
    }

    /**
     * Use the Jobs relation Jobs object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobsQuery A secondary query class using the current class as primary query
     */
    public function useJobsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobs($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Jobs', '\Admin\AdminBundle\Model\JobsQuery');
    }

    /**
     * Filter the query by a related Packets object
     *
     * @param   Packets|PropelObjectCollection $packets  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobPacketsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPackets($packets, $comparison = null)
    {
        if ($packets instanceof Packets) {
            return $this
                ->addUsingAlias(JobPacketsPeer::PACKET_ID, $packets->getId(), $comparison);
        } elseif ($packets instanceof PropelObjectCollection) {
            return $this
                ->usePacketsQuery()
                ->filterByPrimaryKeys($packets->getPrimaryKeys())
                ->endUse();
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
     * @return JobPacketsQuery The current query, for fluid interface
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
     * @param   JobPackets $jobPackets Object to remove from the list of results
     *
     * @return JobPacketsQuery The current query, for fluid interface
     */
    public function prune($jobPackets = null)
    {
        if ($jobPackets) {
            $this->addUsingAlias(JobPacketsPeer::ID, $jobPackets->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
