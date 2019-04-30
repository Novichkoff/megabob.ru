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
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvParamsPeer;
use Admin\AdminBundle\Model\AdvParamsQuery;
use Admin\AdminBundle\Model\Advs;

/**
 * @method AdvParamsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdvParamsQuery orderByAdvId($order = Criteria::ASC) Order by the adv_id column
 * @method AdvParamsQuery orderByFieldId($order = Criteria::ASC) Order by the field_id column
 * @method AdvParamsQuery orderByValueId($order = Criteria::ASC) Order by the value_id column
 * @method AdvParamsQuery orderByTextValue($order = Criteria::ASC) Order by the text_value column
 *
 * @method AdvParamsQuery groupById() Group by the id column
 * @method AdvParamsQuery groupByAdvId() Group by the adv_id column
 * @method AdvParamsQuery groupByFieldId() Group by the field_id column
 * @method AdvParamsQuery groupByValueId() Group by the value_id column
 * @method AdvParamsQuery groupByTextValue() Group by the text_value column
 *
 * @method AdvParamsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdvParamsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdvParamsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdvParamsQuery leftJoinAdCategoriesFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesFields relation
 * @method AdvParamsQuery rightJoinAdCategoriesFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesFields relation
 * @method AdvParamsQuery innerJoinAdCategoriesFields($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesFields relation
 *
 * @method AdvParamsQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method AdvParamsQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method AdvParamsQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method AdvParamsQuery leftJoinAdCategoriesFieldsValues($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesFieldsValues relation
 * @method AdvParamsQuery rightJoinAdCategoriesFieldsValues($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesFieldsValues relation
 * @method AdvParamsQuery innerJoinAdCategoriesFieldsValues($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesFieldsValues relation
 *
 * @method AdvParams findOne(PropelPDO $con = null) Return the first AdvParams matching the query
 * @method AdvParams findOneOrCreate(PropelPDO $con = null) Return the first AdvParams matching the query, or a new AdvParams object populated from the query conditions when no match is found
 *
 * @method AdvParams findOneByAdvId(int $adv_id) Return the first AdvParams filtered by the adv_id column
 * @method AdvParams findOneByFieldId(int $field_id) Return the first AdvParams filtered by the field_id column
 * @method AdvParams findOneByValueId(int $value_id) Return the first AdvParams filtered by the value_id column
 * @method AdvParams findOneByTextValue(string $text_value) Return the first AdvParams filtered by the text_value column
 *
 * @method array findById(int $id) Return AdvParams objects filtered by the id column
 * @method array findByAdvId(int $adv_id) Return AdvParams objects filtered by the adv_id column
 * @method array findByFieldId(int $field_id) Return AdvParams objects filtered by the field_id column
 * @method array findByValueId(int $value_id) Return AdvParams objects filtered by the value_id column
 * @method array findByTextValue(string $text_value) Return AdvParams objects filtered by the text_value column
 */
abstract class BaseAdvParamsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdvParamsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdvParams';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdvParamsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdvParamsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdvParamsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdvParamsQuery) {
            return $criteria;
        }
        $query = new AdvParamsQuery(null, null, $modelAlias);

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
     * @return   AdvParams|AdvParams[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdvParamsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdvParamsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdvParams A model object, or null if the key is not found
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
     * @return                 AdvParams A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `adv_id`, `field_id`, `value_id`, `text_value` FROM `adv_params` WHERE `id` = :p0';
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
            $obj = new AdvParams();
            $obj->hydrate($row);
            AdvParamsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdvParams|AdvParams[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdvParams[]|mixed the list of results, formatted by the current formatter
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
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdvParamsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdvParamsPeer::ID, $keys, Criteria::IN);
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
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvParamsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvParamsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvParamsPeer::ID, $id, $comparison);
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
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function filterByAdvId($advId = null, $comparison = null)
    {
        if (is_array($advId)) {
            $useMinMax = false;
            if (isset($advId['min'])) {
                $this->addUsingAlias(AdvParamsPeer::ADV_ID, $advId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advId['max'])) {
                $this->addUsingAlias(AdvParamsPeer::ADV_ID, $advId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvParamsPeer::ADV_ID, $advId, $comparison);
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
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function filterByFieldId($fieldId = null, $comparison = null)
    {
        if (is_array($fieldId)) {
            $useMinMax = false;
            if (isset($fieldId['min'])) {
                $this->addUsingAlias(AdvParamsPeer::FIELD_ID, $fieldId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fieldId['max'])) {
                $this->addUsingAlias(AdvParamsPeer::FIELD_ID, $fieldId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvParamsPeer::FIELD_ID, $fieldId, $comparison);
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
     * @see       filterByAdCategoriesFieldsValues()
     *
     * @param     mixed $valueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function filterByValueId($valueId = null, $comparison = null)
    {
        if (is_array($valueId)) {
            $useMinMax = false;
            if (isset($valueId['min'])) {
                $this->addUsingAlias(AdvParamsPeer::VALUE_ID, $valueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($valueId['max'])) {
                $this->addUsingAlias(AdvParamsPeer::VALUE_ID, $valueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvParamsPeer::VALUE_ID, $valueId, $comparison);
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
     * @return AdvParamsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdvParamsPeer::TEXT_VALUE, $textValue, $comparison);
    }

    /**
     * Filter the query by a related AdCategoriesFields object
     *
     * @param   AdCategoriesFields|PropelObjectCollection $adCategoriesFields The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvParamsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesFields($adCategoriesFields, $comparison = null)
    {
        if ($adCategoriesFields instanceof AdCategoriesFields) {
            return $this
                ->addUsingAlias(AdvParamsPeer::FIELD_ID, $adCategoriesFields->getId(), $comparison);
        } elseif ($adCategoriesFields instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvParamsPeer::FIELD_ID, $adCategoriesFields->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function joinAdCategoriesFields($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAdCategoriesFieldsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdCategoriesFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategoriesFields', '\Admin\AdminBundle\Model\AdCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related Advs object
     *
     * @param   Advs|PropelObjectCollection $advs The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvParamsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(AdvParamsPeer::ADV_ID, $advs->getId(), $comparison);
        } elseif ($advs instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvParamsPeer::ADV_ID, $advs->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdvParamsQuery The current query, for fluid interface
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
     * Filter the query by a related AdCategoriesFieldsValues object
     *
     * @param   AdCategoriesFieldsValues|PropelObjectCollection $adCategoriesFieldsValues The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvParamsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesFieldsValues($adCategoriesFieldsValues, $comparison = null)
    {
        if ($adCategoriesFieldsValues instanceof AdCategoriesFieldsValues) {
            return $this
                ->addUsingAlias(AdvParamsPeer::VALUE_ID, $adCategoriesFieldsValues->getId(), $comparison);
        } elseif ($adCategoriesFieldsValues instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvParamsPeer::VALUE_ID, $adCategoriesFieldsValues->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdvParamsQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   AdvParams $advParams Object to remove from the list of results
     *
     * @return AdvParamsQuery The current query, for fluid interface
     */
    public function prune($advParams = null)
    {
        if ($advParams) {
            $this->addUsingAlias(AdvParamsPeer::ID, $advParams->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
