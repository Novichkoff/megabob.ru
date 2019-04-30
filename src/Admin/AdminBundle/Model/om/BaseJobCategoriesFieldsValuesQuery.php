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
use Admin\AdminBundle\Model\JobCategoriesFieldsValuesPeer;
use Admin\AdminBundle\Model\JobCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\JobParams;

/**
 * @method JobCategoriesFieldsValuesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobCategoriesFieldsValuesQuery orderByFieldId($order = Criteria::ASC) Order by the field_id column
 * @method JobCategoriesFieldsValuesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method JobCategoriesFieldsValuesQuery orderByParentValueId($order = Criteria::ASC) Order by the parent_value_id column
 * @method JobCategoriesFieldsValuesQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method JobCategoriesFieldsValuesQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 *
 * @method JobCategoriesFieldsValuesQuery groupById() Group by the id column
 * @method JobCategoriesFieldsValuesQuery groupByFieldId() Group by the field_id column
 * @method JobCategoriesFieldsValuesQuery groupByName() Group by the name column
 * @method JobCategoriesFieldsValuesQuery groupByParentValueId() Group by the parent_value_id column
 * @method JobCategoriesFieldsValuesQuery groupByEnabled() Group by the enabled column
 * @method JobCategoriesFieldsValuesQuery groupByDeleted() Group by the deleted column
 *
 * @method JobCategoriesFieldsValuesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobCategoriesFieldsValuesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobCategoriesFieldsValuesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobCategoriesFieldsValuesQuery leftJoinJobCategoriesFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesFields relation
 * @method JobCategoriesFieldsValuesQuery rightJoinJobCategoriesFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesFields relation
 * @method JobCategoriesFieldsValuesQuery innerJoinJobCategoriesFields($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesFields relation
 *
 * @method JobCategoriesFieldsValuesQuery leftJoinJobParams($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobParams relation
 * @method JobCategoriesFieldsValuesQuery rightJoinJobParams($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobParams relation
 * @method JobCategoriesFieldsValuesQuery innerJoinJobParams($relationAlias = null) Adds a INNER JOIN clause to the query using the JobParams relation
 *
 * @method JobCategoriesFieldsValues findOne(PropelPDO $con = null) Return the first JobCategoriesFieldsValues matching the query
 * @method JobCategoriesFieldsValues findOneOrCreate(PropelPDO $con = null) Return the first JobCategoriesFieldsValues matching the query, or a new JobCategoriesFieldsValues object populated from the query conditions when no match is found
 *
 * @method JobCategoriesFieldsValues findOneByFieldId(int $field_id) Return the first JobCategoriesFieldsValues filtered by the field_id column
 * @method JobCategoriesFieldsValues findOneByName(string $name) Return the first JobCategoriesFieldsValues filtered by the name column
 * @method JobCategoriesFieldsValues findOneByParentValueId(int $parent_value_id) Return the first JobCategoriesFieldsValues filtered by the parent_value_id column
 * @method JobCategoriesFieldsValues findOneByEnabled(boolean $enabled) Return the first JobCategoriesFieldsValues filtered by the enabled column
 * @method JobCategoriesFieldsValues findOneByDeleted(boolean $deleted) Return the first JobCategoriesFieldsValues filtered by the deleted column
 *
 * @method array findById(int $id) Return JobCategoriesFieldsValues objects filtered by the id column
 * @method array findByFieldId(int $field_id) Return JobCategoriesFieldsValues objects filtered by the field_id column
 * @method array findByName(string $name) Return JobCategoriesFieldsValues objects filtered by the name column
 * @method array findByParentValueId(int $parent_value_id) Return JobCategoriesFieldsValues objects filtered by the parent_value_id column
 * @method array findByEnabled(boolean $enabled) Return JobCategoriesFieldsValues objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return JobCategoriesFieldsValues objects filtered by the deleted column
 */
abstract class BaseJobCategoriesFieldsValuesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobCategoriesFieldsValuesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\JobCategoriesFieldsValues';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobCategoriesFieldsValuesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobCategoriesFieldsValuesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobCategoriesFieldsValuesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobCategoriesFieldsValuesQuery) {
            return $criteria;
        }
        $query = new JobCategoriesFieldsValuesQuery(null, null, $modelAlias);

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
     * @return   JobCategoriesFieldsValues|JobCategoriesFieldsValues[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobCategoriesFieldsValuesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobCategoriesFieldsValuesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 JobCategoriesFieldsValues A model object, or null if the key is not found
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
     * @return                 JobCategoriesFieldsValues A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `field_id`, `name`, `parent_value_id`, `enabled`, `deleted` FROM `job_categories_fields_values` WHERE `id` = :p0';
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
            $obj = new JobCategoriesFieldsValues();
            $obj->hydrate($row);
            JobCategoriesFieldsValuesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return JobCategoriesFieldsValues|JobCategoriesFieldsValues[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|JobCategoriesFieldsValues[]|mixed the list of results, formatted by the current formatter
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $keys, Criteria::IN);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $id, $comparison);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByFieldId($fieldId = null, $comparison = null)
    {
        if (is_array($fieldId)) {
            $useMinMax = false;
            if (isset($fieldId['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsValuesPeer::FIELD_ID, $fieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldId['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsValuesPeer::FIELD_ID, $fieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::FIELD_ID, $fieldId, $comparison);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the parent_value_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentValueId(1234); // WHERE parent_value_id = 1234
     * $query->filterByParentValueId(array(12, 34)); // WHERE parent_value_id IN (12, 34)
     * $query->filterByParentValueId(array('min' => 12)); // WHERE parent_value_id >= 12
     * $query->filterByParentValueId(array('max' => 12)); // WHERE parent_value_id <= 12
     * </code>
     *
     * @param     mixed $parentValueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByParentValueId($parentValueId = null, $comparison = null)
    {
        if (is_array($parentValueId)) {
            $useMinMax = false;
            if (isset($parentValueId['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $parentValueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentValueId['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $parentValueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $parentValueId, $comparison);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ENABLED, $enabled, $comparison);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsValuesPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query by a related JobCategoriesFields object
     *
     * @param   JobCategoriesFields|PropelObjectCollection $jobCategoriesFields The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsValuesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesFields($jobCategoriesFields, $comparison = null)
    {
        if ($jobCategoriesFields instanceof JobCategoriesFields) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsValuesPeer::FIELD_ID, $jobCategoriesFields->getId(), $comparison);
        } elseif ($jobCategoriesFields instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobCategoriesFieldsValuesPeer::FIELD_ID, $jobCategoriesFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function joinJobCategoriesFields($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useJobCategoriesFieldsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobCategoriesFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategoriesFields', '\Admin\AdminBundle\Model\JobCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related JobParams object
     *
     * @param   JobParams|PropelObjectCollection $jobParams  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsValuesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobParams($jobParams, $comparison = null)
    {
        if ($jobParams instanceof JobParams) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $jobParams->getValueId(), $comparison);
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
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function joinJobParams($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useJobParamsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobParams($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobParams', '\Admin\AdminBundle\Model\JobParamsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   JobCategoriesFieldsValues $jobCategoriesFieldsValues Object to remove from the list of results
     *
     * @return JobCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function prune($jobCategoriesFieldsValues = null)
    {
        if ($jobCategoriesFieldsValues) {
            $this->addUsingAlias(JobCategoriesFieldsValuesPeer::ID, $jobCategoriesFieldsValues->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
