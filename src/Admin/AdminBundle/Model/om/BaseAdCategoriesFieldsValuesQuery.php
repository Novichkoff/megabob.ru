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
use Admin\AdminBundle\Model\AdCategoriesFields;
use Admin\AdminBundle\Model\AdCategoriesFieldsValues;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesPeer;
use Admin\AdminBundle\Model\AdCategoriesFieldsValuesQuery;
use Admin\AdminBundle\Model\AdvParams;

/**
 * @method AdCategoriesFieldsValuesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdCategoriesFieldsValuesQuery orderByFieldId($order = Criteria::ASC) Order by the field_id column
 * @method AdCategoriesFieldsValuesQuery orderByTownId($order = Criteria::ASC) Order by the town_id column
 * @method AdCategoriesFieldsValuesQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method AdCategoriesFieldsValuesQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method AdCategoriesFieldsValuesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AdCategoriesFieldsValuesQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method AdCategoriesFieldsValuesQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method AdCategoriesFieldsValuesQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method AdCategoriesFieldsValuesQuery orderByColor($order = Criteria::ASC) Order by the color column
 * @method AdCategoriesFieldsValuesQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method AdCategoriesFieldsValuesQuery orderByParentFieldId($order = Criteria::ASC) Order by the parent_field_id column
 * @method AdCategoriesFieldsValuesQuery orderByParentValueId($order = Criteria::ASC) Order by the parent_value_id column
 * @method AdCategoriesFieldsValuesQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method AdCategoriesFieldsValuesQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 *
 * @method AdCategoriesFieldsValuesQuery groupById() Group by the id column
 * @method AdCategoriesFieldsValuesQuery groupByFieldId() Group by the field_id column
 * @method AdCategoriesFieldsValuesQuery groupByTownId() Group by the town_id column
 * @method AdCategoriesFieldsValuesQuery groupByAreaId() Group by the area_id column
 * @method AdCategoriesFieldsValuesQuery groupBySort() Group by the sort column
 * @method AdCategoriesFieldsValuesQuery groupByName() Group by the name column
 * @method AdCategoriesFieldsValuesQuery groupByAlias() Group by the alias column
 * @method AdCategoriesFieldsValuesQuery groupByTitle() Group by the title column
 * @method AdCategoriesFieldsValuesQuery groupByDescription() Group by the description column
 * @method AdCategoriesFieldsValuesQuery groupByColor() Group by the color column
 * @method AdCategoriesFieldsValuesQuery groupByIcon() Group by the icon column
 * @method AdCategoriesFieldsValuesQuery groupByParentFieldId() Group by the parent_field_id column
 * @method AdCategoriesFieldsValuesQuery groupByParentValueId() Group by the parent_value_id column
 * @method AdCategoriesFieldsValuesQuery groupByEnabled() Group by the enabled column
 * @method AdCategoriesFieldsValuesQuery groupByDeleted() Group by the deleted column
 *
 * @method AdCategoriesFieldsValuesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdCategoriesFieldsValuesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdCategoriesFieldsValuesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdCategoriesFieldsValuesQuery leftJoinAdCategoriesFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesFields relation
 * @method AdCategoriesFieldsValuesQuery rightJoinAdCategoriesFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesFields relation
 * @method AdCategoriesFieldsValuesQuery innerJoinAdCategoriesFields($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesFields relation
 *
 * @method AdCategoriesFieldsValuesQuery leftJoinAdvParams($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvParams relation
 * @method AdCategoriesFieldsValuesQuery rightJoinAdvParams($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvParams relation
 * @method AdCategoriesFieldsValuesQuery innerJoinAdvParams($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvParams relation
 *
 * @method AdCategoriesFieldsValues findOne(PropelPDO $con = null) Return the first AdCategoriesFieldsValues matching the query
 * @method AdCategoriesFieldsValues findOneOrCreate(PropelPDO $con = null) Return the first AdCategoriesFieldsValues matching the query, or a new AdCategoriesFieldsValues object populated from the query conditions when no match is found
 *
 * @method AdCategoriesFieldsValues findOneByFieldId(int $field_id) Return the first AdCategoriesFieldsValues filtered by the field_id column
 * @method AdCategoriesFieldsValues findOneByTownId(int $town_id) Return the first AdCategoriesFieldsValues filtered by the town_id column
 * @method AdCategoriesFieldsValues findOneByAreaId(int $area_id) Return the first AdCategoriesFieldsValues filtered by the area_id column
 * @method AdCategoriesFieldsValues findOneBySort(int $sort) Return the first AdCategoriesFieldsValues filtered by the sort column
 * @method AdCategoriesFieldsValues findOneByName(string $name) Return the first AdCategoriesFieldsValues filtered by the name column
 * @method AdCategoriesFieldsValues findOneByAlias(string $alias) Return the first AdCategoriesFieldsValues filtered by the alias column
 * @method AdCategoriesFieldsValues findOneByTitle(string $title) Return the first AdCategoriesFieldsValues filtered by the title column
 * @method AdCategoriesFieldsValues findOneByDescription(string $description) Return the first AdCategoriesFieldsValues filtered by the description column
 * @method AdCategoriesFieldsValues findOneByColor(string $color) Return the first AdCategoriesFieldsValues filtered by the color column
 * @method AdCategoriesFieldsValues findOneByIcon(string $icon) Return the first AdCategoriesFieldsValues filtered by the icon column
 * @method AdCategoriesFieldsValues findOneByParentFieldId(int $parent_field_id) Return the first AdCategoriesFieldsValues filtered by the parent_field_id column
 * @method AdCategoriesFieldsValues findOneByParentValueId(int $parent_value_id) Return the first AdCategoriesFieldsValues filtered by the parent_value_id column
 * @method AdCategoriesFieldsValues findOneByEnabled(boolean $enabled) Return the first AdCategoriesFieldsValues filtered by the enabled column
 * @method AdCategoriesFieldsValues findOneByDeleted(boolean $deleted) Return the first AdCategoriesFieldsValues filtered by the deleted column
 *
 * @method array findById(int $id) Return AdCategoriesFieldsValues objects filtered by the id column
 * @method array findByFieldId(int $field_id) Return AdCategoriesFieldsValues objects filtered by the field_id column
 * @method array findByTownId(int $town_id) Return AdCategoriesFieldsValues objects filtered by the town_id column
 * @method array findByAreaId(int $area_id) Return AdCategoriesFieldsValues objects filtered by the area_id column
 * @method array findBySort(int $sort) Return AdCategoriesFieldsValues objects filtered by the sort column
 * @method array findByName(string $name) Return AdCategoriesFieldsValues objects filtered by the name column
 * @method array findByAlias(string $alias) Return AdCategoriesFieldsValues objects filtered by the alias column
 * @method array findByTitle(string $title) Return AdCategoriesFieldsValues objects filtered by the title column
 * @method array findByDescription(string $description) Return AdCategoriesFieldsValues objects filtered by the description column
 * @method array findByColor(string $color) Return AdCategoriesFieldsValues objects filtered by the color column
 * @method array findByIcon(string $icon) Return AdCategoriesFieldsValues objects filtered by the icon column
 * @method array findByParentFieldId(int $parent_field_id) Return AdCategoriesFieldsValues objects filtered by the parent_field_id column
 * @method array findByParentValueId(int $parent_value_id) Return AdCategoriesFieldsValues objects filtered by the parent_value_id column
 * @method array findByEnabled(boolean $enabled) Return AdCategoriesFieldsValues objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return AdCategoriesFieldsValues objects filtered by the deleted column
 */
abstract class BaseAdCategoriesFieldsValuesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdCategoriesFieldsValuesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdCategoriesFieldsValues';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdCategoriesFieldsValuesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdCategoriesFieldsValuesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdCategoriesFieldsValuesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdCategoriesFieldsValuesQuery) {
            return $criteria;
        }
        $query = new AdCategoriesFieldsValuesQuery(null, null, $modelAlias);

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
     * @return   AdCategoriesFieldsValues|AdCategoriesFieldsValues[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdCategoriesFieldsValuesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesFieldsValuesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdCategoriesFieldsValues A model object, or null if the key is not found
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
     * @return                 AdCategoriesFieldsValues A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `field_id`, `town_id`, `area_id`, `sort`, `name`, `alias`, `title`, `description`, `color`, `icon`, `parent_field_id`, `parent_value_id`, `enabled`, `deleted` FROM `ad_categories_fields_values` WHERE `id` = :p0';
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
            $obj = new AdCategoriesFieldsValues();
            $obj->hydrate($row);
            AdCategoriesFieldsValuesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdCategoriesFieldsValues|AdCategoriesFieldsValues[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdCategoriesFieldsValues[]|mixed the list of results, formatted by the current formatter
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $keys, Criteria::IN);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $id, $comparison);
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
     * @see       filterByAdCategoriesFields()
     *
     * @param     mixed $fieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByFieldId($fieldId = null, $comparison = null)
    {
        if (is_array($fieldId)) {
            $useMinMax = false;
            if (isset($fieldId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::FIELD_ID, $fieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::FIELD_ID, $fieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::FIELD_ID, $fieldId, $comparison);
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
     * @param     mixed $townId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByTownId($townId = null, $comparison = null)
    {
        if (is_array($townId)) {
            $useMinMax = false;
            if (isset($townId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::TOWN_ID, $townId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($townId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::TOWN_ID, $townId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::TOWN_ID, $townId, $comparison);
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
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::AREA_ID, $areaId, $comparison);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::SORT, $sort, $comparison);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the alias column
     *
     * Example usage:
     * <code>
     * $query->filterByAlias('fooValue');   // WHERE alias = 'fooValue'
     * $query->filterByAlias('%fooValue%'); // WHERE alias LIKE '%fooValue%'
     * </code>
     *
     * @param     string $alias The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByAlias($alias = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($alias)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $alias)) {
                $alias = str_replace('*', '%', $alias);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ALIAS, $alias, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the color column
     *
     * Example usage:
     * <code>
     * $query->filterByColor('fooValue');   // WHERE color = 'fooValue'
     * $query->filterByColor('%fooValue%'); // WHERE color LIKE '%fooValue%'
     * </code>
     *
     * @param     string $color The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByColor($color = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($color)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $color)) {
                $color = str_replace('*', '%', $color);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::COLOR, $color, $comparison);
    }

    /**
     * Filter the query on the icon column
     *
     * Example usage:
     * <code>
     * $query->filterByIcon('fooValue');   // WHERE icon = 'fooValue'
     * $query->filterByIcon('%fooValue%'); // WHERE icon LIKE '%fooValue%'
     * </code>
     *
     * @param     string $icon The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByIcon($icon = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($icon)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $icon)) {
                $icon = str_replace('*', '%', $icon);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ICON, $icon, $comparison);
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
     * @param     mixed $parentFieldId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByParentFieldId($parentFieldId = null, $comparison = null)
    {
        if (is_array($parentFieldId)) {
            $useMinMax = false;
            if (isset($parentFieldId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID, $parentFieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentFieldId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID, $parentFieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::PARENT_FIELD_ID, $parentFieldId, $comparison);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByParentValueId($parentValueId = null, $comparison = null)
    {
        if (is_array($parentValueId)) {
            $useMinMax = false;
            if (isset($parentValueId['min'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $parentValueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentValueId['max'])) {
                $this->addUsingAlias(AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $parentValueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::PARENT_VALUE_ID, $parentValueId, $comparison);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ENABLED, $enabled, $comparison);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesFieldsValuesPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query by a related AdCategoriesFields object
     *
     * @param   AdCategoriesFields|PropelObjectCollection $adCategoriesFields The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsValuesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesFields($adCategoriesFields, $comparison = null)
    {
        if ($adCategoriesFields instanceof AdCategoriesFields) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsValuesPeer::FIELD_ID, $adCategoriesFields->getId(), $comparison);
        } elseif ($adCategoriesFields instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesFieldsValuesPeer::FIELD_ID, $adCategoriesFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdCategoriesFields() only accepts arguments of type AdCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategoriesFields relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function joinAdCategoriesFields($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategoriesFields');

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
            $this->addJoinObject($join, 'AdCategoriesFields');
        }

        return $this;
    }

    /**
     * Use the AdCategoriesFields relation AdCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesFieldsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdCategoriesFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategoriesFields', '\Admin\AdminBundle\Model\AdCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related AdvParams object
     *
     * @param   AdvParams|PropelObjectCollection $advParams  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesFieldsValuesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvParams($advParams, $comparison = null)
    {
        if ($advParams instanceof AdvParams) {
            return $this
                ->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $advParams->getValueId(), $comparison);
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
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function joinAdvParams($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAdvParamsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvParams($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvParams', '\Admin\AdminBundle\Model\AdvParamsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AdCategoriesFieldsValues $adCategoriesFieldsValues Object to remove from the list of results
     *
     * @return AdCategoriesFieldsValuesQuery The current query, for fluid interface
     */
    public function prune($adCategoriesFieldsValues = null)
    {
        if ($adCategoriesFieldsValues) {
            $this->addUsingAlias(AdCategoriesFieldsValuesPeer::ID, $adCategoriesFieldsValues->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
