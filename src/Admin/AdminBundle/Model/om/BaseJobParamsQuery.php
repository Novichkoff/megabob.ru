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
use Admin\AdminBundle\Model\JobCategoriesFields;
use Admin\AdminBundle\Model\JobCategoriesFieldsValues;
use Admin\AdminBundle\Model\JobParams;
use Admin\AdminBundle\Model\JobParamsPeer;
use Admin\AdminBundle\Model\JobParamsQuery;
use Admin\AdminBundle\Model\Jobs;

/**
 * @method JobParamsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobParamsQuery orderByJobId($order = Criteria::ASC) Order by the job_id column
 * @method JobParamsQuery orderByFieldId($order = Criteria::ASC) Order by the field_id column
 * @method JobParamsQuery orderByValueId($order = Criteria::ASC) Order by the value_id column
 * @method JobParamsQuery orderByTextValue($order = Criteria::ASC) Order by the text_value column
 *
 * @method JobParamsQuery groupById() Group by the id column
 * @method JobParamsQuery groupByJobId() Group by the job_id column
 * @method JobParamsQuery groupByFieldId() Group by the field_id column
 * @method JobParamsQuery groupByValueId() Group by the value_id column
 * @method JobParamsQuery groupByTextValue() Group by the text_value column
 *
 * @method JobParamsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobParamsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobParamsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobParamsQuery leftJoinJobCategoriesFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesFields relation
 * @method JobParamsQuery rightJoinJobCategoriesFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesFields relation
 * @method JobParamsQuery innerJoinJobCategoriesFields($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesFields relation
 *
 * @method JobParamsQuery leftJoinJobs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Jobs relation
 * @method JobParamsQuery rightJoinJobs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Jobs relation
 * @method JobParamsQuery innerJoinJobs($relationAlias = null) Adds a INNER JOIN clause to the query using the Jobs relation
 *
 * @method JobParamsQuery leftJoinJobCategoriesFieldsValues($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesFieldsValues relation
 * @method JobParamsQuery rightJoinJobCategoriesFieldsValues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesFieldsValues relation
 * @method JobParamsQuery innerJoinJobCategoriesFieldsValues($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesFieldsValues relation
 *
 * @method JobParams findOne(PropelPDO $con = null) Return the first JobParams matching the query
 * @method JobParams findOneOrCreate(PropelPDO $con = null) Return the first JobParams matching the query, or a new JobParams object populated from the query conditions when no match is found
 *
 * @method JobParams findOneByJobId(int $job_id) Return the first JobParams filtered by the job_id column
 * @method JobParams findOneByFieldId(int $field_id) Return the first JobParams filtered by the field_id column
 * @method JobParams findOneByValueId(int $value_id) Return the first JobParams filtered by the value_id column
 * @method JobParams findOneByTextValue(string $text_value) Return the first JobParams filtered by the text_value column
 *
 * @method array findById(int $id) Return JobParams objects filtered by the id column
 * @method array findByJobId(int $job_id) Return JobParams objects filtered by the job_id column
 * @method array findByFieldId(int $field_id) Return JobParams objects filtered by the field_id column
 * @method array findByValueId(int $value_id) Return JobParams objects filtered by the value_id column
 * @method array findByTextValue(string $text_value) Return JobParams objects filtered by the text_value column
 */
abstract class BaseJobParamsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobParamsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\JobParams';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobParamsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobParamsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobParamsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobParamsQuery) {
            return $criteria;
        }
        $query = new JobParamsQuery(null, null, $modelAlias);

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
     * @return   JobParams|JobParams[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobParamsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobParamsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 JobParams A model object, or null if the key is not found
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
     * @return                 JobParams A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `job_id`, `field_id`, `value_id`, `text_value` FROM `job_params` WHERE `id` = :p0';
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
            $obj = new JobParams();
            $obj->hydrate($row);
            JobParamsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return JobParams|JobParams[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|JobParams[]|mixed the list of results, formatted by the current formatter
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
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobParamsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobParamsPeer::ID, $keys, Criteria::IN);
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
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobParamsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobParamsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobParamsPeer::ID, $id, $comparison);
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
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterByJobId($jobId = null, $comparison = null)
    {
        if (is_array($jobId)) {
            $useMinMax = false;
            if (isset($jobId['min'])) {
                $this->addUsingAlias(JobParamsPeer::JOB_ID, $jobId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($jobId['max'])) {
                $this->addUsingAlias(JobParamsPeer::JOB_ID, $jobId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobParamsPeer::JOB_ID, $jobId, $comparison);
    }

    /**
     * Filter the query on the field_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFieldId(1234); // WHERE field_id = 1234
     * $query->filterByFieldId(array(12, 34)); // WHERE field_id IN (12, 34)
     * $query->filterByFieldId(array('min' => 12)); // WHERE field_id >= 12
     * $query->filterByFieldId(array('max' => 12)); // WHERE field_id <= 12
     * </code>
     *
     * @see       filterByJobCategoriesFields()
     *
     * @param     mixed $fieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterByFieldId($fieldId = null, $comparison = null)
    {
        if (is_array($fieldId)) {
            $useMinMax = false;
            if (isset($fieldId['min'])) {
                $this->addUsingAlias(JobParamsPeer::FIELD_ID, $fieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldId['max'])) {
                $this->addUsingAlias(JobParamsPeer::FIELD_ID, $fieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobParamsPeer::FIELD_ID, $fieldId, $comparison);
    }

    /**
     * Filter the query on the value_id column
     *
     * Example usage:
     * <code>
     * $query->filterByValueId(1234); // WHERE value_id = 1234
     * $query->filterByValueId(array(12, 34)); // WHERE value_id IN (12, 34)
     * $query->filterByValueId(array('min' => 12)); // WHERE value_id >= 12
     * $query->filterByValueId(array('max' => 12)); // WHERE value_id <= 12
     * </code>
     *
     * @see       filterByJobCategoriesFieldsValues()
     *
     * @param     mixed $valueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterByValueId($valueId = null, $comparison = null)
    {
        if (is_array($valueId)) {
            $useMinMax = false;
            if (isset($valueId['min'])) {
                $this->addUsingAlias(JobParamsPeer::VALUE_ID, $valueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valueId['max'])) {
                $this->addUsingAlias(JobParamsPeer::VALUE_ID, $valueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobParamsPeer::VALUE_ID, $valueId, $comparison);
    }

    /**
     * Filter the query on the text_value column
     *
     * Example usage:
     * <code>
     * $query->filterByTextValue('fooValue');   // WHERE text_value = 'fooValue'
     * $query->filterByTextValue('%fooValue%'); // WHERE text_value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $textValue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function filterByTextValue($textValue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($textValue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $textValue)) {
                $textValue = str_replace('*', '%', $textValue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JobParamsPeer::TEXT_VALUE, $textValue, $comparison);
    }

    /**
     * Filter the query by a related JobCategoriesFields object
     *
     * @param   JobCategoriesFields|PropelObjectCollection $jobCategoriesFields The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobParamsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesFields($jobCategoriesFields, $comparison = null)
    {
        if ($jobCategoriesFields instanceof JobCategoriesFields) {
            return $this
                ->addUsingAlias(JobParamsPeer::FIELD_ID, $jobCategoriesFields->getId(), $comparison);
        } elseif ($jobCategoriesFields instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobParamsPeer::FIELD_ID, $jobCategoriesFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobCategoriesFields() only accepts arguments of type JobCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobCategoriesFields relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function joinJobCategoriesFields($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobCategoriesFields');

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
            $this->addJoinObject($join, 'JobCategoriesFields');
        }

        return $this;
    }

    /**
     * Use the JobCategoriesFields relation JobCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useJobCategoriesFieldsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobCategoriesFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategoriesFields', '\Admin\AdminBundle\Model\JobCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related Jobs object
     *
     * @param   Jobs|PropelObjectCollection $jobs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobParamsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobs($jobs, $comparison = null)
    {
        if ($jobs instanceof Jobs) {
            return $this
                ->addUsingAlias(JobParamsPeer::JOB_ID, $jobs->getId(), $comparison);
        } elseif ($jobs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobParamsPeer::JOB_ID, $jobs->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return JobParamsQuery The current query, for fluid interface
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
     * Filter the query by a related JobCategoriesFieldsValues object
     *
     * @param   JobCategoriesFieldsValues|PropelObjectCollection $jobCategoriesFieldsValues The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobParamsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesFieldsValues($jobCategoriesFieldsValues, $comparison = null)
    {
        if ($jobCategoriesFieldsValues instanceof JobCategoriesFieldsValues) {
            return $this
                ->addUsingAlias(JobParamsPeer::VALUE_ID, $jobCategoriesFieldsValues->getId(), $comparison);
        } elseif ($jobCategoriesFieldsValues instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobParamsPeer::VALUE_ID, $jobCategoriesFieldsValues->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobCategoriesFieldsValues() only accepts arguments of type JobCategoriesFieldsValues or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobCategoriesFieldsValues relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function joinJobCategoriesFieldsValues($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobCategoriesFieldsValues');

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
            $this->addJoinObject($join, 'JobCategoriesFieldsValues');
        }

        return $this;
    }

    /**
     * Use the JobCategoriesFieldsValues relation JobCategoriesFieldsValues object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery A secondary query class using the current class as primary query
     */
    public function useJobCategoriesFieldsValuesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobCategoriesFieldsValues($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategoriesFieldsValues', '\Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   JobParams $jobParams Object to remove from the list of results
     *
     * @return JobParamsQuery The current query, for fluid interface
     */
    public function prune($jobParams = null)
    {
        if ($jobParams) {
            $this->addUsingAlias(JobParamsPeer::ID, $jobParams->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
