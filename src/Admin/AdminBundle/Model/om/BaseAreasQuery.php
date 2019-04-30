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
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\Areas;
use Admin\AdminBundle\Model\AreasPeer;
use Admin\AdminBundle\Model\AreasQuery;
use Admin\AdminBundle\Model\Regions;

/**
 * @method AreasQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AreasQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AreasQuery orderByCode($order = Criteria::ASC) Order by the code column
 * @method AreasQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method AreasQuery orderByPath($order = Criteria::ASC) Order by the path column
 * @method AreasQuery orderByPart($order = Criteria::ASC) Order by the part column
 * @method AreasQuery orderByPagetitle($order = Criteria::ASC) Order by the pagetitle column
 * @method AreasQuery orderByNet($order = Criteria::ASC) Order by the net column
 * @method AreasQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 *
 * @method AreasQuery groupById() Group by the id column
 * @method AreasQuery groupByName() Group by the name column
 * @method AreasQuery groupByCode() Group by the code column
 * @method AreasQuery groupByAlias() Group by the alias column
 * @method AreasQuery groupByPath() Group by the path column
 * @method AreasQuery groupByPart() Group by the part column
 * @method AreasQuery groupByPagetitle() Group by the pagetitle column
 * @method AreasQuery groupByNet() Group by the net column
 * @method AreasQuery groupByDeleted() Group by the deleted column
 *
 * @method AreasQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AreasQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AreasQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AreasQuery leftJoinRegions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Regions relation
 * @method AreasQuery rightJoinRegions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Regions relation
 * @method AreasQuery innerJoinRegions($relationAlias = null) Adds a INNER JOIN clause to the query using the Regions relation
 *
 * @method AreasQuery leftJoinAdCategoriesSubscribe($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesSubscribe relation
 * @method AreasQuery rightJoinAdCategoriesSubscribe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesSubscribe relation
 * @method AreasQuery innerJoinAdCategoriesSubscribe($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesSubscribe relation
 *
 * @method AreasQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method AreasQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method AreasQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method Areas findOne(PropelPDO $con = null) Return the first Areas matching the query
 * @method Areas findOneOrCreate(PropelPDO $con = null) Return the first Areas matching the query, or a new Areas object populated from the query conditions when no match is found
 *
 * @method Areas findOneByName(string $name) Return the first Areas filtered by the name column
 * @method Areas findOneByCode(int $code) Return the first Areas filtered by the code column
 * @method Areas findOneByAlias(string $alias) Return the first Areas filtered by the alias column
 * @method Areas findOneByPath(string $path) Return the first Areas filtered by the path column
 * @method Areas findOneByPart(int $part) Return the first Areas filtered by the part column
 * @method Areas findOneByPagetitle(string $pagetitle) Return the first Areas filtered by the pagetitle column
 * @method Areas findOneByNet(string $net) Return the first Areas filtered by the net column
 * @method Areas findOneByDeleted(boolean $deleted) Return the first Areas filtered by the deleted column
 *
 * @method array findById(int $id) Return Areas objects filtered by the id column
 * @method array findByName(string $name) Return Areas objects filtered by the name column
 * @method array findByCode(int $code) Return Areas objects filtered by the code column
 * @method array findByAlias(string $alias) Return Areas objects filtered by the alias column
 * @method array findByPath(string $path) Return Areas objects filtered by the path column
 * @method array findByPart(int $part) Return Areas objects filtered by the part column
 * @method array findByPagetitle(string $pagetitle) Return Areas objects filtered by the pagetitle column
 * @method array findByNet(string $net) Return Areas objects filtered by the net column
 * @method array findByDeleted(boolean $deleted) Return Areas objects filtered by the deleted column
 */
abstract class BaseAreasQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAreasQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Areas';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AreasQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AreasQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AreasQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AreasQuery) {
            return $criteria;
        }
        $query = new AreasQuery(null, null, $modelAlias);

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
     * @return   Areas|Areas[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AreasPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AreasPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Areas A model object, or null if the key is not found
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
     * @return                 Areas A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `code`, `alias`, `path`, `part`, `pagetitle`, `net`, `deleted` FROM `areas` WHERE `id` = :p0';
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
            $obj = new Areas();
            $obj->hydrate($row);
            AreasPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Areas|Areas[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Areas[]|mixed the list of results, formatted by the current formatter
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
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AreasPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AreasPeer::ID, $keys, Criteria::IN);
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
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AreasPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AreasPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AreasPeer::ID, $id, $comparison);
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
     * @return AreasQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AreasPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the code column
     *
     * Example usage:
     * <code>
     * $query->filterByCode(1234); // WHERE code = 1234
     * $query->filterByCode(array(12, 34)); // WHERE code IN (12, 34)
     * $query->filterByCode(array('min' => 12)); // WHERE code >= 12
     * $query->filterByCode(array('max' => 12)); // WHERE code <= 12
     * </code>
     *
     * @param     mixed $code The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByCode($code = null, $comparison = null)
    {
        if (is_array($code)) {
            $useMinMax = false;
            if (isset($code['min'])) {
                $this->addUsingAlias(AreasPeer::CODE, $code['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($code['max'])) {
                $this->addUsingAlias(AreasPeer::CODE, $code['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AreasPeer::CODE, $code, $comparison);
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
     * @return AreasQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AreasPeer::ALIAS, $alias, $comparison);
    }

    /**
     * Filter the query on the path column
     *
     * Example usage:
     * <code>
     * $query->filterByPath('fooValue');   // WHERE path = 'fooValue'
     * $query->filterByPath('%fooValue%'); // WHERE path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $path The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByPath($path = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($path)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $path)) {
                $path = str_replace('*', '%', $path);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AreasPeer::PATH, $path, $comparison);
    }

    /**
     * Filter the query on the part column
     *
     * Example usage:
     * <code>
     * $query->filterByPart(1234); // WHERE part = 1234
     * $query->filterByPart(array(12, 34)); // WHERE part IN (12, 34)
     * $query->filterByPart(array('min' => 12)); // WHERE part >= 12
     * $query->filterByPart(array('max' => 12)); // WHERE part <= 12
     * </code>
     *
     * @param     mixed $part The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByPart($part = null, $comparison = null)
    {
        if (is_array($part)) {
            $useMinMax = false;
            if (isset($part['min'])) {
                $this->addUsingAlias(AreasPeer::PART, $part['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($part['max'])) {
                $this->addUsingAlias(AreasPeer::PART, $part['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AreasPeer::PART, $part, $comparison);
    }

    /**
     * Filter the query on the pagetitle column
     *
     * Example usage:
     * <code>
     * $query->filterByPagetitle('fooValue');   // WHERE pagetitle = 'fooValue'
     * $query->filterByPagetitle('%fooValue%'); // WHERE pagetitle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pagetitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByPagetitle($pagetitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pagetitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pagetitle)) {
                $pagetitle = str_replace('*', '%', $pagetitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AreasPeer::PAGETITLE, $pagetitle, $comparison);
    }

    /**
     * Filter the query on the net column
     *
     * Example usage:
     * <code>
     * $query->filterByNet('fooValue');   // WHERE net = 'fooValue'
     * $query->filterByNet('%fooValue%'); // WHERE net LIKE '%fooValue%'
     * </code>
     *
     * @param     string $net The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByNet($net = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($net)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $net)) {
                $net = str_replace('*', '%', $net);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AreasPeer::NET, $net, $comparison);
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
     * @return AreasQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AreasPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query by a related Regions object
     *
     * @param   Regions|PropelObjectCollection $regions  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AreasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRegions($regions, $comparison = null)
    {
        if ($regions instanceof Regions) {
            return $this
                ->addUsingAlias(AreasPeer::ID, $regions->getAreaId(), $comparison);
        } elseif ($regions instanceof PropelObjectCollection) {
            return $this
                ->useRegionsQuery()
                ->filterByPrimaryKeys($regions->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRegions() only accepts arguments of type Regions or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Regions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function joinRegions($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Regions');

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
            $this->addJoinObject($join, 'Regions');
        }

        return $this;
    }

    /**
     * Use the Regions relation Regions object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\RegionsQuery A secondary query class using the current class as primary query
     */
    public function useRegionsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinRegions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Regions', '\Admin\AdminBundle\Model\RegionsQuery');
    }

    /**
     * Filter the query by a related AdCategoriesSubscribe object
     *
     * @param   AdCategoriesSubscribe|PropelObjectCollection $adCategoriesSubscribe  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AreasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesSubscribe($adCategoriesSubscribe, $comparison = null)
    {
        if ($adCategoriesSubscribe instanceof AdCategoriesSubscribe) {
            return $this
                ->addUsingAlias(AreasPeer::ID, $adCategoriesSubscribe->getAreaId(), $comparison);
        } elseif ($adCategoriesSubscribe instanceof PropelObjectCollection) {
            return $this
                ->useAdCategoriesSubscribeQuery()
                ->filterByPrimaryKeys($adCategoriesSubscribe->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdCategoriesSubscribe() only accepts arguments of type AdCategoriesSubscribe or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategoriesSubscribe relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function joinAdCategoriesSubscribe($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategoriesSubscribe');

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
            $this->addJoinObject($join, 'AdCategoriesSubscribe');
        }

        return $this;
    }

    /**
     * Use the AdCategoriesSubscribe relation AdCategoriesSubscribe object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesSubscribeQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesSubscribeQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdCategoriesSubscribe($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategoriesSubscribe', '\Admin\AdminBundle\Model\AdCategoriesSubscribeQuery');
    }

    /**
     * Filter the query by a related Advs object
     *
     * @param   Advs|PropelObjectCollection $advs  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AreasQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(AreasPeer::ID, $advs->getAreaId(), $comparison);
        } elseif ($advs instanceof PropelObjectCollection) {
            return $this
                ->useAdvsQuery()
                ->filterByPrimaryKeys($advs->getPrimaryKeys())
                ->endUse();
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
     * @return AreasQuery The current query, for fluid interface
     */
    public function joinAdvs($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAdvsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvs($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Advs', '\Admin\AdminBundle\Model\AdvsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Areas $areas Object to remove from the list of results
     *
     * @return AreasQuery The current query, for fluid interface
     */
    public function prune($areas = null)
    {
        if ($areas) {
            $this->addUsingAlias(AreasPeer::ID, $areas->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
