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
use Admin\AdminBundle\Model\AdCategoriesFields;
use Admin\AdminBundle\Model\AdCategoriesFieldsPeer;
use Admin\AdminBundle\Model\AdCategoriesFieldsQuery;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdvParams;

/**
 * @method AdCategoriesFieldsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdCategoriesFieldsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method AdCategoriesFieldsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AdCategoriesFieldsQuery orderByFilterName($order = Criteria::ASC) Order by the filter_name column
 * @method AdCategoriesFieldsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method AdCategoriesFieldsQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method AdCategoriesFieldsQuery orderByParentFieldId($order = Criteria::ASC) Order by the parent_field_id column
 * @method AdCategoriesFieldsQuery orderByHelper($order = Criteria::ASC) Order by the helper column
 * @method AdCategoriesFieldsQuery orderByMask($order = Criteria::ASC) Order by the mask column
 * @method AdCategoriesFieldsQuery orderByPostfix($order = Criteria::ASC) Order by the postfix column
 * @method AdCategoriesFieldsQuery orderByShowInFilter($order = Criteria::ASC) Order by the show_in_filter column
 * @method AdCategoriesFieldsQuery orderByRequired($order = Criteria::ASC) Order by the required column
 * @method AdCategoriesFieldsQuery orderByShowInTable($order = Criteria::ASC) Order by the show_in_table column
 * @method AdCategoriesFieldsQuery orderByShowOnMap($order = Criteria::ASC) Order by the show_on_map column
 * @method AdCategoriesFieldsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method AdCategoriesFieldsQuery orderByListing($order = Criteria::ASC) Order by the listing column
 * @method AdCategoriesFieldsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 *
 * @method AdCategoriesFieldsQuery groupById() Group by the id column
 * @method AdCategoriesFieldsQuery groupByCategoryId() Group by the category_id column
 * @method AdCategoriesFieldsQuery groupByName() Group by the name column
 * @method AdCategoriesFieldsQuery groupByFilterName() Group by the filter_name column
 * @method AdCategoriesFieldsQuery groupByType() Group by the type column
 * @method AdCategoriesFieldsQuery groupBySort() Group by the sort column
 * @method AdCategoriesFieldsQuery groupByParentFieldId() Group by the parent_field_id column
 * @method AdCategoriesFieldsQuery groupByHelper() Group by the helper column
 * @method AdCategoriesFieldsQuery groupByMask() Group by the mask column
 * @method AdCategoriesFieldsQuery groupByPostfix() Group by the postfix column
 * @method AdCategoriesFieldsQuery groupByShowInFilter() Group by the show_in_filter column
 * @method AdCategoriesFieldsQuery groupByRequired() Group by the required column
 * @method AdCategoriesFieldsQuery groupByShowInTable() Group by the show_in_table column
 * @method AdCategoriesFieldsQuery groupByShowOnMap() Group by the show_on_map column
 * @method AdCategoriesFieldsQuery groupByEnabled() Group by the enabled column
 * @method AdCategoriesFieldsQuery groupByListing() Group by the listing column
 * @method AdCategoriesFieldsQuery groupByDeleted() Group by the deleted column
 *
 * @method AdCategoriesFieldsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdCategoriesFieldsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdCategoriesFieldsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdCategoriesFieldsQuery leftJoinAdCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategories relation
 * @method AdCategoriesFieldsQuery rightJoinAdCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategories relation
 * @method AdCategoriesFieldsQuery innerJoinAdCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategories relation
 *
 * @method AdCategoriesFieldsQuery leftJoinAdCategoriesFieldsRelatedByParentFieldId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesFieldsRelatedByParentFieldId relation
 * @method AdCategoriesFieldsQuery rightJoinAdCategoriesFieldsRelatedByParentFieldId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesFieldsRelatedByParentFieldId relation
 * @method AdCategoriesFieldsQuery innerJoinAdCategoriesFieldsRelatedByParentFieldId($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesFieldsRelatedByParentFieldId relation
 *
 * @method AdCategoriesFieldsQuery leftJoinChildsFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChildsFields relation
 * @method AdCategoriesFieldsQuery rightJoinChildsFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChildsFields relation
 * @method AdCategoriesFieldsQuery innerJoinChildsFields($relationAlias = null) Adds a INNER JOIN clause to the query using the ChildsFields relation
 *
 * @method AdCategoriesFieldsQuery leftJoinAdCategoriesFieldsValues($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesFieldsValues relation
 * @method AdCategoriesFieldsQuery rightJoinAdCategoriesFieldsValues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesFieldsValues relation
 * @method AdCategoriesFieldsQuery innerJoinAdCategoriesFieldsValues($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesFieldsValues relation
 *
 * @method AdCategoriesFieldsQuery leftJoinAdvParams($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvParams relation
 * @method AdCategoriesFieldsQuery rightJoinAdvParams($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvParams relation
 * @method AdCategoriesFieldsQuery innerJoinAdvParams($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvParams relation
 *
 * @method AdCategoriesFields findOne(PropelPDO $con = null) Return the first AdCategoriesFields matching the query
 * @method AdCategoriesFields findOneOrCreate(PropelPDO $con = null) Return the first AdCategoriesFields matching the query, or a new AdCategoriesFields object populated from the query conditions when no match is found
 *
 * @method AdCategoriesFields findOneByCategoryId(int $category_id) Return the first AdCategoriesFields filtered by the category_id column
 * @method AdCategoriesFields findOneByName(string $name) Return the first AdCategoriesFields filtered by the name column
 * @method AdCategoriesFields findOneByFilterName(string $filter_name) Return the first AdCategoriesFields filtered by the filter_name column
 * @method AdCategoriesFields findOneByType(int $type) Return the first AdCategoriesFields filtered by the type column
 * @method AdCategoriesFields findOneBySort(int $sort) Return the first AdCategoriesFields filtered by the sort column
 * @method AdCategoriesFields findOneByParentFieldId(int $parent_field_id) Return the first AdCategoriesFields filtered by the parent_field_id column
 * @method AdCategoriesFields findOneByHelper(string $helper) Return the first AdCategoriesFields filtered by the helper column
 * @method AdCategoriesFields findOneByMask(string $mask) Return the first AdCategoriesFields filtered by the mask column
 * @method AdCategoriesFields findOneByPostfix(string $postfix) Return the first AdCategoriesFields filtered by the postfix column
 * @method AdCategoriesFields findOneByShowInFilter(boolean $show_in_filter) Return the first AdCategoriesFields filtered by the show_in_filter column
 * @method AdCategoriesFields findOneByRequired(boolean $required) Return the first AdCategoriesFields filtered by the required column
 * @method AdCategoriesFields findOneByShowInTable(boolean $show_in_table) Return the first AdCategoriesFields filtered by the show_in_table column
 * @method AdCategoriesFields findOneByShowOnMap(boolean $show_on_map) Return the first AdCategoriesFields filtered by the show_on_map column
 * @method AdCategoriesFields findOneByEnabled(boolean $enabled) Return the first AdCategoriesFields filtered by the enabled column
 * @method AdCategoriesFields findOneByListing(boolean $listing) Return the first AdCategoriesFields filtered by the listing column
 * @method AdCategoriesFields findOneByDeleted(boolean $deleted) Return the first AdCategoriesFields filtered by the deleted column
 *
 * @method array findById(int $id) Return AdCategoriesFields objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return AdCategoriesFields objects filtered by the category_id column
 * @method array findByName(string $name) Return AdCategoriesFields objects filtered by the name column
 * @method array findByFilterName(string $filter_name) Return AdCategoriesFields objects filtered by the filter_name column
 * @method array findByType(int $type) Return AdCategoriesFields objects filtered by the type column
 * @method array findBySort(int $sort) Return AdCategoriesFields objects filtered by the sort column
 * @method array findByParentFieldId(int $parent_field_id) Return AdCategoriesFields objects filtered by the parent_field_id column
 * @method array findByHelper(string $helper) Return AdCategoriesFields objects filtered by the helper column
 * @method array findByMask(string $mask) Return AdCategoriesFields objects filtered by the mask column
 * @method array findByPostfix(string $postfix) Return AdCategoriesFields objects filtered by the postfix column
 * @method array findByShowInFilter(boolean $show_in_filter) Return AdCategoriesFields objects filtered by the show_in_filter column
 * @method array findByRequired(boolean $required) Return AdCategoriesFields objects filtered by the required column
 * @method array findByShowInTable(boolean $show_in_table) Return AdCategoriesFields objects filtered by the show_in_table column
 * @method array findByShowOnMap(boolean $show_on_map) Return AdCategoriesFields objects filtered by the show_on_map column
 * @method array findByEnabled(boolean $enabled) Return AdCategoriesFields objects filtered by the enabled column
 * @method array findByListing(boolean $listing) Return AdCategoriesFields objects filtered by the listing column
 * @method array findByDeleted(boolean $deleted) Return AdCategoriesFields objects filtered by the deleted column
 */
abstract class BaseAdCategoriesFieldsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdCategoriesFieldsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdCategoriesFields';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdCategoriesFieldsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdCategoriesFieldsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdCategoriesFieldsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdCategoriesFieldsQuery) {
            return $criteria;
        }
        $query = new AdCategoriesFieldsQuery(null, null, $modelAlias);

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
     * @return   AdCategoriesFields|AdCategoriesFields[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdCategoriesFieldsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdCategoriesFields A model object, or null if the key is not found
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
     * @return                 AdCategoriesFields A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `name`, `filter_name`, `type`, `sort`, `parent_field_id`, `helper`, `mask`, `postfix`, `show_in_filter`, `required`, `show_in_table`, `show_on_map`, `enabled`, `listing`, `deleted` FROM `ad_categories_fields` WHERE `id` = :p0';
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
            $obj = new AdCategoriesFields();
            $obj->hydrate($row);
            AdCategoriesFieldsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdCategoriesFields|AdCategoriesFields[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdCategoriesFields[]|mixed the list of results, formatted by the current formatter
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdCategoriesFieldsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdCategoriesFieldsPeer::ID, $keys, Criteria::IN);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::ID, $id, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::CATEGORY_ID, $categoryId, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesFieldsPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the filter_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFilterName('fooValue');   // WHERE filter_name = 'fooValue'
     * $query->filterByFilterName('%fooValue%'); // WHERE filter_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $filterName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByFilterName($filterName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($filterName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $filterName)) {
                $filterName = str_replace('*', '%', $filterName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::FILTER_NAME, $filterName, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the sort column
     *
     * Example usage:
     * <code>
     * $query->filterBySort(1234); // WHERE sort = 1234
     * $query->filterBySort(array(12, 34)); // WHERE sort IN (12, 34)
     * $query->filterBySort(array('min' => 12)); // WHERE sort >= 12
     * $query->filterBySort(array('max' => 12)); // WHERE sort <= 12
     * </code>
     *
     * @param     mixed $sort The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::SORT, $sort, $comparison);
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
     * @see       filterByAdCategoriesFieldsRelatedByParentFieldId()
     *
     * @param     mixed $parentFieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByParentFieldId($parentFieldId = null, $comparison = null)
    {
        if (is_array($parentFieldId)) {
            $useMinMax = false;
            if (isset($parentFieldId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $parentFieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentFieldId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $parentFieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $parentFieldId, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesFieldsPeer::HELPER, $helper, $comparison);
    }

    /**
     * Filter the query on the mask column
     *
     * Example usage:
     * <code>
     * $query->filterByMask('fooValue');   // WHERE mask = 'fooValue'
     * $query->filterByMask('%fooValue%'); // WHERE mask LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mask The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByMask($mask = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mask)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mask)) {
                $mask = str_replace('*', '%', $mask);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::MASK, $mask, $comparison);
    }

    /**
     * Filter the query on the postfix column
     *
     * Example usage:
     * <code>
     * $query->filterByPostfix('fooValue');   // WHERE postfix = 'fooValue'
     * $query->filterByPostfix('%fooValue%'); // WHERE postfix LIKE '%fooValue%'
     * </code>
     *
     * @param     string $postfix The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByPostfix($postfix = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($postfix)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $postfix)) {
                $postfix = str_replace('*', '%', $postfix);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::POSTFIX, $postfix, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByShowInFilter($showInFilter = null, $comparison = null)
    {
        if (is_string($showInFilter)) {
            $showInFilter = in_array(strtolower($showInFilter), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::SHOW_IN_FILTER, $showInFilter, $comparison);
    }

    /**
     * Filter the query on the required column
     *
     * Example usage:
     * <code>
     * $query->filterByRequired(true); // WHERE required = true
     * $query->filterByRequired('yes'); // WHERE required = true
     * </code>
     *
     * @param     boolean|string $required The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByRequired($required = null, $comparison = null)
    {
        if (is_string($required)) {
            $required = in_array(strtolower($required), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::REQUIRED, $required, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByShowInTable($showInTable = null, $comparison = null)
    {
        if (is_string($showInTable)) {
            $showInTable = in_array(strtolower($showInTable), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::SHOW_IN_TABLE, $showInTable, $comparison);
    }

    /**
     * Filter the query on the show_on_map column
     *
     * Example usage:
     * <code>
     * $query->filterByShowOnMap(true); // WHERE show_on_map = true
     * $query->filterByShowOnMap('yes'); // WHERE show_on_map = true
     * </code>
     *
     * @param     boolean|string $showOnMap The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByShowOnMap($showOnMap = null, $comparison = null)
    {
        if (is_string($showOnMap)) {
            $showOnMap = in_array(strtolower($showOnMap), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::SHOW_ON_MAP, $showOnMap, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::ENABLED, $enabled, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByListing($listing = null, $comparison = null)
    {
        if (is_string($listing)) {
            $listing = in_array(strtolower($listing), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::LISTING, $listing, $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query by a related AdCategories object
     *
     * @param   AdCategories|PropelObjectCollection $adCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategories($adCategories, $comparison = null)
    {
        if ($adCategories instanceof AdCategories) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::CATEGORY_ID, $adCategories->getId(), $comparison);
        } elseif ($adCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::CATEGORY_ID, $adCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinAdCategories($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAdCategoriesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategories', '\Admin\AdminBundle\Model\AdCategoriesQuery');
    }

    /**
     * Filter the query by a related AdCategoriesFields object
     *
     * @param   AdCategoriesFields|PropelObjectCollection $adCategoriesFields The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesFieldsRelatedByParentFieldId($adCategoriesFields, $comparison = null)
    {
        if ($adCategoriesFields instanceof AdCategoriesFields) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $adCategoriesFields->getId(), $comparison);
        } elseif ($adCategoriesFields instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::PARENT_FIELD_ID, $adCategoriesFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdCategoriesFieldsRelatedByParentFieldId() only accepts arguments of type AdCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategoriesFieldsRelatedByParentFieldId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinAdCategoriesFieldsRelatedByParentFieldId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategoriesFieldsRelatedByParentFieldId');

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
            $this->addJoinObject($join, 'AdCategoriesFieldsRelatedByParentFieldId');
        }

        return $this;
    }

    /**
     * Use the AdCategoriesFieldsRelatedByParentFieldId relation AdCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesFieldsRelatedByParentFieldIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdCategoriesFieldsRelatedByParentFieldId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategoriesFieldsRelatedByParentFieldId', '\Admin\AdminBundle\Model\AdCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related AdCategoriesFields object
     *
     * @param   AdCategoriesFields|PropelObjectCollection $adCategoriesFields  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByChildsFields($adCategoriesFields, $comparison = null)
    {
        if ($adCategoriesFields instanceof AdCategoriesFields) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::ID, $adCategoriesFields->getParentFieldId(), $comparison);
        } elseif ($adCategoriesFields instanceof PropelObjectCollection) {
            return $this
                ->useChildsFieldsQuery()
                ->filterByPrimaryKeys($adCategoriesFields->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChildsFields() only accepts arguments of type AdCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChildsFields relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
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
     * Use the ChildsFields relation AdCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useChildsFieldsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinChildsFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChildsFields', '\Admin\AdminBundle\Model\AdCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related AdCategoriesFieldsValues object
     *
     * @param   AdCategoriesFieldsValues|PropelObjectCollection $adCategoriesFieldsValues  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesFieldsValues($adCategoriesFieldsValues, $comparison = null)
    {
        if ($adCategoriesFieldsValues instanceof AdCategoriesFieldsValues) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::ID, $adCategoriesFieldsValues->getFieldId(), $comparison);
        } elseif ($adCategoriesFieldsValues instanceof PropelObjectCollection) {
            return $this
                ->useAdCategoriesFieldsValuesQuery()
                ->filterByPrimaryKeys($adCategoriesFieldsValues->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdCategoriesFieldsValues() only accepts arguments of type AdCategoriesFieldsValues or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategoriesFieldsValues relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinAdCategoriesFieldsValues($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategoriesFieldsValues');

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
            $this->addJoinObject($join, 'AdCategoriesFieldsValues');
        }

        return $this;
    }

    /**
     * Use the AdCategoriesFieldsValues relation AdCategoriesFieldsValues object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesFieldsValuesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdCategoriesFieldsValues($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategoriesFieldsValues', '\Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery');
    }

    /**
     * Filter the query by a related AdvParams object
     *
     * @param   AdvParams|PropelObjectCollection $advParams  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvParams($advParams, $comparison = null)
    {
        if ($advParams instanceof AdvParams) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsPeer::ID, $advParams->getFieldId(), $comparison);
        } elseif ($advParams instanceof PropelObjectCollection) {
            return $this
                ->useAdvParamsQuery()
                ->filterByPrimaryKeys($advParams->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvParams() only accepts arguments of type AdvParams or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvParams relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function joinAdvParams($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvParams');

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
            $this->addJoinObject($join, 'AdvParams');
        }

        return $this;
    }

    /**
     * Use the AdvParams relation AdvParams object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvParamsQuery A secondary query class using the current class as primary query
     */
    public function useAdvParamsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvParams($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvParams', '\Admin\AdminBundle\Model\AdvParamsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AdCategoriesFields $adCategoriesFields Object to remove from the list of results
     *
     * @return AdCategoriesFieldsQuery The current query, for fluid interface
     */
    public function prune($adCategoriesFields = null)
    {
        if ($adCategoriesFields) {
            $this->addUsingAlias(AdCategoriesFieldsPeer::ID, $adCategoriesFields->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
