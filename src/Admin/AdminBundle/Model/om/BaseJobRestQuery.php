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
use Admin\AdminBundle\Model\JobRest;
use Admin\AdminBundle\Model\JobRestPeer;
use Admin\AdminBundle\Model\JobRestQuery;
use Admin\AdminBundle\Model\Jobs;
use FOS\UserBundle\Propel\User;

/**
 * @method JobRestQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobRestQuery orderByJobId($order = Criteria::ASC) Order by the job_id column
 * @method JobRestQuery orderByVacancyId($order = Criteria::ASC) Order by the vacancy_id column
 * @method JobRestQuery orderBySenderId($order = Criteria::ASC) Order by the sender_id column
 * @method JobRestQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method JobRestQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method JobRestQuery orderByMessage($order = Criteria::ASC) Order by the message column
 *
 * @method JobRestQuery groupById() Group by the id column
 * @method JobRestQuery groupByJobId() Group by the job_id column
 * @method JobRestQuery groupByVacancyId() Group by the vacancy_id column
 * @method JobRestQuery groupBySenderId() Group by the sender_id column
 * @method JobRestQuery groupByDeleted() Group by the deleted column
 * @method JobRestQuery groupByDate() Group by the date column
 * @method JobRestQuery groupByMessage() Group by the message column
 *
 * @method JobRestQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobRestQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobRestQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobRestQuery leftJoinJobsRelatedByJobId($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobsRelatedByJobId relation
 * @method JobRestQuery rightJoinJobsRelatedByJobId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobsRelatedByJobId relation
 * @method JobRestQuery innerJoinJobsRelatedByJobId($relationAlias = null) Adds a INNER JOIN clause to the query using the JobsRelatedByJobId relation
 *
 * @method JobRestQuery leftJoinJobsRelatedByVacancyId($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobsRelatedByVacancyId relation
 * @method JobRestQuery rightJoinJobsRelatedByVacancyId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobsRelatedByVacancyId relation
 * @method JobRestQuery innerJoinJobsRelatedByVacancyId($relationAlias = null) Adds a INNER JOIN clause to the query using the JobsRelatedByVacancyId relation
 *
 * @method JobRestQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method JobRestQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method JobRestQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method JobRest findOne(PropelPDO $con = null) Return the first JobRest matching the query
 * @method JobRest findOneOrCreate(PropelPDO $con = null) Return the first JobRest matching the query, or a new JobRest object populated from the query conditions when no match is found
 *
 * @method JobRest findOneById(int $id) Return the first JobRest filtered by the id column
 * @method JobRest findOneByJobId(int $job_id) Return the first JobRest filtered by the job_id column
 * @method JobRest findOneByVacancyId(int $vacancy_id) Return the first JobRest filtered by the vacancy_id column
 * @method JobRest findOneBySenderId(int $sender_id) Return the first JobRest filtered by the sender_id column
 * @method JobRest findOneByDeleted(boolean $deleted) Return the first JobRest filtered by the deleted column
 * @method JobRest findOneByDate(string $date) Return the first JobRest filtered by the date column
 * @method JobRest findOneByMessage(string $message) Return the first JobRest filtered by the message column
 *
 * @method array findById(int $id) Return JobRest objects filtered by the id column
 * @method array findByJobId(int $job_id) Return JobRest objects filtered by the job_id column
 * @method array findByVacancyId(int $vacancy_id) Return JobRest objects filtered by the vacancy_id column
 * @method array findBySenderId(int $sender_id) Return JobRest objects filtered by the sender_id column
 * @method array findByDeleted(boolean $deleted) Return JobRest objects filtered by the deleted column
 * @method array findByDate(string $date) Return JobRest objects filtered by the date column
 * @method array findByMessage(string $message) Return JobRest objects filtered by the message column
 */
abstract class BaseJobRestQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobRestQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\JobRest';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobRestQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobRestQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobRestQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobRestQuery) {
            return $criteria;
        }
        $query = new JobRestQuery(null, null, $modelAlias);

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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $sender_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   JobRest|JobRest[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobRestPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobRestPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 JobRest A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `job_id`, `vacancy_id`, `sender_id`, `deleted`, `date`, `message` FROM `job_rest` WHERE `id` = :p0 AND `sender_id` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new JobRest();
            $obj->hydrate($row);
            JobRestPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return JobRest|JobRest[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|JobRest[]|mixed the list of results, formatted by the current formatter
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
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(JobRestPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(JobRestPeer::SENDER_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(JobRestPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(JobRestPeer::SENDER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobRestPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobRestPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobRestPeer::ID, $id, $comparison);
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
     * @see       filterByJobsRelatedByJobId()
     *
     * @param     mixed $jobId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByJobId($jobId = null, $comparison = null)
    {
        if (is_array($jobId)) {
            $useMinMax = false;
            if (isset($jobId['min'])) {
                $this->addUsingAlias(JobRestPeer::JOB_ID, $jobId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($jobId['max'])) {
                $this->addUsingAlias(JobRestPeer::JOB_ID, $jobId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobRestPeer::JOB_ID, $jobId, $comparison);
    }

    /**
     * Filter the query on the vacancy_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVacancyId(1234); // WHERE vacancy_id = 1234
     * $query->filterByVacancyId(array(12, 34)); // WHERE vacancy_id IN (12, 34)
     * $query->filterByVacancyId(array('min' => 12)); // WHERE vacancy_id >= 12
     * $query->filterByVacancyId(array('max' => 12)); // WHERE vacancy_id <= 12
     * </code>
     *
     * @see       filterByJobsRelatedByVacancyId()
     *
     * @param     mixed $vacancyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByVacancyId($vacancyId = null, $comparison = null)
    {
        if (is_array($vacancyId)) {
            $useMinMax = false;
            if (isset($vacancyId['min'])) {
                $this->addUsingAlias(JobRestPeer::VACANCY_ID, $vacancyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vacancyId['max'])) {
                $this->addUsingAlias(JobRestPeer::VACANCY_ID, $vacancyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobRestPeer::VACANCY_ID, $vacancyId, $comparison);
    }

    /**
     * Filter the query on the sender_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderId(1234); // WHERE sender_id = 1234
     * $query->filterBySenderId(array(12, 34)); // WHERE sender_id IN (12, 34)
     * $query->filterBySenderId(array('min' => 12)); // WHERE sender_id >= 12
     * $query->filterBySenderId(array('max' => 12)); // WHERE sender_id <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $senderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterBySenderId($senderId = null, $comparison = null)
    {
        if (is_array($senderId)) {
            $useMinMax = false;
            if (isset($senderId['min'])) {
                $this->addUsingAlias(JobRestPeer::SENDER_ID, $senderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($senderId['max'])) {
                $this->addUsingAlias(JobRestPeer::SENDER_ID, $senderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobRestPeer::SENDER_ID, $senderId, $comparison);
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
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobRestPeer::DELETED, $deleted, $comparison);
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
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(JobRestPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(JobRestPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobRestPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $message)) {
                $message = str_replace('*', '%', $message);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JobRestPeer::MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query by a related Jobs object
     *
     * @param   Jobs|PropelObjectCollection $jobs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobRestQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobsRelatedByJobId($jobs, $comparison = null)
    {
        if ($jobs instanceof Jobs) {
            return $this
                ->addUsingAlias(JobRestPeer::JOB_ID, $jobs->getId(), $comparison);
        } elseif ($jobs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobRestPeer::JOB_ID, $jobs->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobsRelatedByJobId() only accepts arguments of type Jobs or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobsRelatedByJobId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function joinJobsRelatedByJobId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobsRelatedByJobId');

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
            $this->addJoinObject($join, 'JobsRelatedByJobId');
        }

        return $this;
    }

    /**
     * Use the JobsRelatedByJobId relation Jobs object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobsQuery A secondary query class using the current class as primary query
     */
    public function useJobsRelatedByJobIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobsRelatedByJobId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobsRelatedByJobId', '\Admin\AdminBundle\Model\JobsQuery');
    }

    /**
     * Filter the query by a related Jobs object
     *
     * @param   Jobs|PropelObjectCollection $jobs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobRestQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobsRelatedByVacancyId($jobs, $comparison = null)
    {
        if ($jobs instanceof Jobs) {
            return $this
                ->addUsingAlias(JobRestPeer::VACANCY_ID, $jobs->getId(), $comparison);
        } elseif ($jobs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobRestPeer::VACANCY_ID, $jobs->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobsRelatedByVacancyId() only accepts arguments of type Jobs or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobsRelatedByVacancyId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function joinJobsRelatedByVacancyId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobsRelatedByVacancyId');

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
            $this->addJoinObject($join, 'JobsRelatedByVacancyId');
        }

        return $this;
    }

    /**
     * Use the JobsRelatedByVacancyId relation Jobs object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobsQuery A secondary query class using the current class as primary query
     */
    public function useJobsRelatedByVacancyIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobsRelatedByVacancyId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobsRelatedByVacancyId', '\Admin\AdminBundle\Model\JobsQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobRestQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(JobRestPeer::SENDER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobRestPeer::SENDER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return JobRestQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   JobRest $jobRest Object to remove from the list of results
     *
     * @return JobRestQuery The current query, for fluid interface
     */
    public function prune($jobRest = null)
    {
        if ($jobRest) {
            $this->addCond('pruneCond0', $this->getAliasedColName(JobRestPeer::ID), $jobRest->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(JobRestPeer::SENDER_ID), $jobRest->getSenderId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
