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
use Admin\AdminBundle\Model\JobCategoriesFields;
use Admin\AdminBundle\Model\JobCategoriesFieldsPeer;
use Admin\AdminBundle\Model\JobCategoriesFieldsQuery;
use Admin\AdminBundle\Model\JobCategoriesFieldsValues;
use Admin\AdminBundle\Model\JobParams;

/**
 * @method JobCategoriesFieldsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobCategoriesFieldsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method JobCategoriesFieldsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method JobCategoriesFieldsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method JobCategoriesFieldsQuery orderByParentFieldId($order = Criteria::ASC) Order by the parent_field_id column
 * @method JobCategoriesFieldsQuery orderByHelper($order = Criteria::ASC) Order by the helper column
 * @method JobCategoriesFieldsQuery orderByShowInFilter($order = Criteria::ASC) Order by the show_in_filter column
 * @method JobCategoriesFieldsQuery orderByShowInTable($order = Criteria::ASC) Order by the show_in_table column
 * @method JobCategoriesFieldsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method JobCategoriesFieldsQuery orderByListing($order = Criteria::ASC) Order by the listing column
 * @method JobCategoriesFieldsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 *
 * @method JobCategoriesFieldsQuery groupById() Group by the id column
 * @method JobCategoriesFieldsQuery groupByCategoryId() Group by the category_id column
 * @method JobCategoriesFieldsQuery groupByName() Group by the name column
 * @method JobCategoriesFieldsQuery groupByType() Group by the type column
 * @method JobCategoriesFieldsQuery groupByParentFieldId() Group by the parent_field_id column
 * @method JobCategoriesFieldsQuery groupByHelper() Group by the helper column
 * @method JobCategoriesFieldsQuery groupByShowInFilter() Group by the show_in_filter column
 * @method JobCategoriesFieldsQuery groupByShowInTable() Group by the show_in_table column
 * @method JobCategoriesFieldsQuery groupByEnabled() Group by the enabled column
 * @method JobCategoriesFieldsQuery groupByListing() Group by the listing column
 * @method JobCategoriesFieldsQuery groupByDeleted() Group by the deleted column
 *
 * @method JobCategoriesFieldsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobCategoriesFieldsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobCategoriesFieldsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobCategoriesFieldsQuery leftJoinJobCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategories relation
 * @method JobCategoriesFieldsQuery rightJoinJobCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategories relation
 * @method JobCategoriesFieldsQuery innerJoinJobCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategories relation
 *
 * @method JobCategoriesFieldsQuery leftJoinJobCategoriesFieldsRelatedByParentFieldId($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesFieldsRelatedByParentFieldId relation
 * @method JobCategoriesFieldsQuery rightJoinJobCategoriesFieldsRelatedByParentFieldId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesFieldsRelatedByParentFieldId relation
 * @method JobCategoriesFieldsQuery innerJoinJobCategoriesFieldsRelatedByParentFieldId($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesFieldsRelatedByParentFieldId relation
 *
 * @method JobCategoriesFieldsQuery leftJoinChildsFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChildsFields relation
 * @method JobCategoriesFieldsQuery rightJoinChildsFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChildsFields relation
 * @method JobCategoriesFieldsQuery innerJoinChildsFields($relationAlias = null) Adds a INNER JOIN clause to the query using the ChildsFields relation
 *
 * @method JobCategoriesFieldsQuery leftJoinJobCategoriesFieldsValues($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesFieldsValues relation
 * @method JobCategoriesFieldsQuery rightJoinJobCategoriesFieldsValues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesFieldsValues relation
 * @method JobCategoriesFieldsQuery innerJoinJobCategoriesFieldsValues($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesFieldsValues relation
 *
 * @method JobCategoriesFieldsQuery leftJoinJobParams($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobParams relation
 * @method JobCategoriesFieldsQuery rightJoinJobParams($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobParams relation
 * @method JobCategoriesFieldsQuery innerJoinJobParams($relationAlias = null) Adds a INNER JOIN clause to the query using the JobParams relation
 *
 * @method JobCategoriesFields findOne(PropelPDO $con = null) Return the first JobCategoriesFields matching the query
 * @method JobCategoriesFields findOneOrCreate(PropelPDO $con = null) Return the first JobCategoriesFields matching the query, or a new JobCategoriesFields object populated from the query conditions when no match is found
 *
 * @method JobCategoriesFields findOneByCategoryId(int $category_id) Return the first JobCategoriesFields filtered by the category_id column
 * @method JobCategoriesFields findOneByName(string $name) Return the first JobCategoriesFields filtered by the name column
 * @method JobCategoriesFields findOneByType(int $type) Return the first JobCategoriesFields filtered by the type column
 * @method JobCategoriesFields findOneByParentFieldId(int $parent_field_id) Return the first JobCategoriesFields filtered by the parent_field_id column
 * @method JobCategoriesFields findOneByHelper(string $helper) Return the first JobCategoriesFields filtered by the helper column
 * @method JobCategoriesFields findOneByShowInFilter(boolean $show_in_filter) Return the first JobCategoriesFields filtered by the show_in_filter column
 * @method JobCategoriesFields findOneByShowInTable(boolean $show_in_table) Return the first JobCategoriesFields filtered by the show_in_table column
 * @method JobCategoriesFields findOneByEnabled(boolean $enabled) Return the first JobCategoriesFields filtered by the enabled column
 * @method JobCategoriesFields findOneByListing(boolean $listing) Return the first JobCategoriesFields filtered by the listing column
 * @method JobCategoriesFields findOneByDeleted(boolean $deleted) Return the first JobCategoriesFields filtered by the deleted column
 *
 * @method array findById(int $id) Return JobCategoriesFields objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return JobCategoriesFields objects filtered by the category_id column
 * @method array findByName(string $name) Return JobCategoriesFields objects filtered by the name column
 * @method array findByType(int $type) Return JobCategoriesFields objects filtered by the type column
 * @method array findByParentFieldId(int $parent_field_id) Return JobCategoriesFields objects filtered by the parent_field_id column
 * @method array findByHelper(string $helper) Return JobCategoriesFields objects filtered by the helper column
 * @method array findByShowInFilter(boolean $show_in_filter) Return JobCategoriesFields objects filtered by the show_in_filter column
 * @method array findByShowInTable(boolean $show_in_table) Return JobCategoriesFields objects filtered by the show_in_table column
 * @method array findByEnabled(boolean $enabled) Return JobCategoriesFields objects filtered by the enabled column
 * @method array findByListing(boolean $listing) Return JobCategoriesFields objects filtered by the listing column
 * @method array findByDeleted(boolean $deleted) Return JobCategoriesFields objects filtered by the deleted column
 */
abstract class BaseJobCategoriesFieldsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobCategoriesFieldsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\JobCategoriesFields';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobCategoriesFieldsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobCategoriesFieldsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobCategoriesFieldsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobCategoriesFieldsQuery) {
            return $criteria;
        }
        $query = new JobCategoriesFieldsQuery(null, null, $modelAlias);

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
     * @return   JobCategoriesFields|JobCategoriesFields[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobCategoriesFieldsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 JobCategoriesFields A model object, or null if the key is not found
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
     * @return                 JobCategoriesFields A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `name`, `type`, `parent_field_id`, `helper`, `show_in_filter`, `show_in_table`, `enabled`, `listing`, `deleted` FROM `job_categories_fields` WHERE `id` = :p0';
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
            $obj = new JobCategoriesFields();
            $obj->hydrate($row);
            JobCategoriesFieldsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return JobCategoriesFields|JobCategoriesFields[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|JobCategoriesFields[]|mixed the list of results, formatted by the current formatter
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobCategoriesFieldsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobCategoriesFieldsPeer::ID, $keys, Criteria::IN);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::ID, $id, $comparison);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::CATEGORY_ID, $categoryId, $comparison);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesFieldsPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType(1234); // WHERE type = 1234
     * $query->filterByType(array(12, 34)); // WHERE type IN (12, 34)
     * $query->filterByType(array('min' => 12)); // WHERE type >= 12
     * $query->filterByType(array('max' => 12)); // WHERE type <= 12
     * </code>
     *
     * @param     mixed $type The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the parent_field_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentFieldId(1234); // WHERE parent_field_id = 1234
     * $query->filterByParentFieldId(array(12, 34)); // WHERE parent_field_id IN (12, 34)
     * $query->filterByParentFieldId(array('min' => 12)); // WHERE parent_field_id >= 12
     * $query->filterByParentFieldId(array('max' => 12)); // WHERE parent_field_id <= 12
     * </code>
     *
     * @see       filterByJobCategoriesFieldsRelatedByParentFieldId()
     *
     * @param     mixed $parentFieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByParentFieldId($parentFieldId = null, $comparison = null)
    {
        if (is_array($parentFieldId)) {
            $useMinMax = false;
            if (isset($parentFieldId['min'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::PARENT_FIELD_ID, $parentFieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentFieldId['max'])) {
                $this->addUsingAlias(JobCategoriesFieldsPeer::PARENT_FIELD_ID, $parentFieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::PARENT_FIELD_ID, $parentFieldId, $comparison);
    }

    /**
     * Filter the query on the helper column
     *
     * Example usage:
     * <code>
     * $query->filterByHelper('fooValue');   // WHERE helper = 'fooValue'
     * $query->filterByHelper('%fooValue%'); // WHERE helper LIKE '%fooValue%'
     * </code>
     *
     * @param     string $helper The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByHelper($helper = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($helper)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $helper)) {
                $helper = str_replace('*', '%', $helper);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::HELPER, $helper, $comparison);
    }

    /**
     * Filter the query on the show_in_filter column
     *
     * Example usage:
     * <code>
     * $query->filterByShowInFilter(true); // WHERE show_in_filter = true
     * $query->filterByShowInFilter('yes'); // WHERE show_in_filter = true
     * </code>
     *
     * @param     boolean|string $showInFilter The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByShowInFilter($showInFilter = null, $comparison = null)
    {
        if (is_string($showInFilter)) {
            $showInFilter = in_array(strtolower($showInFilter), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::SHOW_IN_FILTER, $showInFilter, $comparison);
    }

    /**
     * Filter the query on the show_in_table column
     *
     * Example usage:
     * <code>
     * $query->filterByShowInTable(true); // WHERE show_in_table = true
     * $query->filterByShowInTable('yes'); // WHERE show_in_table = true
     * </code>
     *
     * @param     boolean|string $showInTable The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByShowInTable($showInTable = null, $comparison = null)
    {
        if (is_string($showInTable)) {
            $showInTable = in_array(strtolower($showInTable), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::SHOW_IN_TABLE, $showInTable, $comparison);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::ENABLED, $enabled, $comparison);
    }

    /**
     * Filter the query on the listing column
     *
     * Example usage:
     * <code>
     * $query->filterByListing(true); // WHERE listing = true
     * $query->filterByListing('yes'); // WHERE listing = true
     * </code>
     *
     * @param     boolean|string $listing The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByListing($listing = null, $comparison = null)
    {
        if (is_string($listing)) {
            $listing = in_array(strtolower($listing), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::LISTING, $listing, $comparison);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesFieldsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query by a related JobCategories object
     *
     * @param   JobCategories|PropelObjectCollection $jobCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategories($jobCategories, $comparison = null)
    {
        if ($jobCategories instanceof JobCategories) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::CATEGORY_ID, $jobCategories->getId(), $comparison);
        } elseif ($jobCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::CATEGORY_ID, $jobCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinJobCategories($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useJobCategoriesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategories', '\Admin\AdminBundle\Model\JobCategoriesQuery');
    }

    /**
     * Filter the query by a related JobCategoriesFields object
     *
     * @param   JobCategoriesFields|PropelObjectCollection $jobCategoriesFields The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesFieldsRelatedByParentFieldId($jobCategoriesFields, $comparison = null)
    {
        if ($jobCategoriesFields instanceof JobCategoriesFields) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::PARENT_FIELD_ID, $jobCategoriesFields->getId(), $comparison);
        } elseif ($jobCategoriesFields instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::PARENT_FIELD_ID, $jobCategoriesFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobCategoriesFieldsRelatedByParentFieldId() only accepts arguments of type JobCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobCategoriesFieldsRelatedByParentFieldId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinJobCategoriesFieldsRelatedByParentFieldId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobCategoriesFieldsRelatedByParentFieldId');

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
            $this->addJoinObject($join, 'JobCategoriesFieldsRelatedByParentFieldId');
        }

        return $this;
    }

    /**
     * Use the JobCategoriesFieldsRelatedByParentFieldId relation JobCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useJobCategoriesFieldsRelatedByParentFieldIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobCategoriesFieldsRelatedByParentFieldId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategoriesFieldsRelatedByParentFieldId', '\Admin\AdminBundle\Model\JobCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related JobCategoriesFields object
     *
     * @param   JobCategoriesFields|PropelObjectCollection $jobCategoriesFields  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByChildsFields($jobCategoriesFields, $comparison = null)
    {
        if ($jobCategoriesFields instanceof JobCategoriesFields) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::ID, $jobCategoriesFields->getParentFieldId(), $comparison);
        } elseif ($jobCategoriesFields instanceof PropelObjectCollection) {
            return $this
                ->useChildsFieldsQuery()
                ->filterByPrimaryKeys($jobCategoriesFields->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChildsFields() only accepts arguments of type JobCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChildsFields relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinChildsFields($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChildsFields');

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
            $this->addJoinObject($join, 'ChildsFields');
        }

        return $this;
    }

    /**
     * Use the ChildsFields relation JobCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useChildsFieldsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinChildsFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChildsFields', '\Admin\AdminBundle\Model\JobCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related JobCategoriesFieldsValues object
     *
     * @param   JobCategoriesFieldsValues|PropelObjectCollection $jobCategoriesFieldsValues  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesFieldsValues($jobCategoriesFieldsValues, $comparison = null)
    {
        if ($jobCategoriesFieldsValues instanceof JobCategoriesFieldsValues) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::ID, $jobCategoriesFieldsValues->getFieldId(), $comparison);
        } elseif ($jobCategoriesFieldsValues instanceof PropelObjectCollection) {
            return $this
                ->useJobCategoriesFieldsValuesQuery()
                ->filterByPrimaryKeys($jobCategoriesFieldsValues->getPrimaryKeys())
                ->endUse();
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
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
     * Filter the query by a related JobParams object
     *
     * @param   JobParams|PropelObjectCollection $jobParams  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobParams($jobParams, $comparison = null)
    {
        if ($jobParams instanceof JobParams) {
            return $this
                ->addUsingAlias(JobCategoriesFieldsPeer::ID, $jobParams->getFieldId(), $comparison);
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
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   JobCategoriesFields $jobCategoriesFields Object to remove from the list of results
     *
     * @return JobCategoriesFieldsQuery The current query, for fluid interface
     */
    public function prune($jobCategoriesFields = null)
    {
        if ($jobCategoriesFields) {
            $this->addUsingAlias(JobCategoriesFieldsPeer::ID, $jobCategoriesFields->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
