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
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\RegionsPeer;
use Admin\AdminBundle\Model\RegionsQuery;
use Admin\AdminBundle\Model\Shops;

/**
 * @method RegionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method RegionsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method RegionsQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method RegionsQuery orderByPagetitle($order = Criteria::ASC) Order by the pagetitle column
 * @method RegionsQuery orderByNet($order = Criteria::ASC) Order by the net column
 * @method RegionsQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method RegionsQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method RegionsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method RegionsQuery orderByWeather($order = Criteria::ASC) Order by the weather column
 * @method RegionsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 *
 * @method RegionsQuery groupById() Group by the id column
 * @method RegionsQuery groupByName() Group by the name column
 * @method RegionsQuery groupByAreaId() Group by the area_id column
 * @method RegionsQuery groupByPagetitle() Group by the pagetitle column
 * @method RegionsQuery groupByNet() Group by the net column
 * @method RegionsQuery groupByAlias() Group by the alias column
 * @method RegionsQuery groupByIcon() Group by the icon column
 * @method RegionsQuery groupByType() Group by the type column
 * @method RegionsQuery groupByWeather() Group by the weather column
 * @method RegionsQuery groupByDeleted() Group by the deleted column
 *
 * @method RegionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method RegionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method RegionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method RegionsQuery leftJoinAreas($relationAlias = null) Adds a LEFT JOIN clause to the query using the Areas relation
 * @method RegionsQuery rightJoinAreas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Areas relation
 * @method RegionsQuery innerJoinAreas($relationAlias = null) Adds a INNER JOIN clause to the query using the Areas relation
 *
 * @method RegionsQuery leftJoinAdCategoriesSubscribe($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesSubscribe relation
 * @method RegionsQuery rightJoinAdCategoriesSubscribe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesSubscribe relation
 * @method RegionsQuery innerJoinAdCategoriesSubscribe($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesSubscribe relation
 *
 * @method RegionsQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method RegionsQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method RegionsQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method RegionsQuery leftJoinShops($relationAlias = null) Adds a LEFT JOIN clause to the query using the Shops relation
 * @method RegionsQuery rightJoinShops($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Shops relation
 * @method RegionsQuery innerJoinShops($relationAlias = null) Adds a INNER JOIN clause to the query using the Shops relation
 *
 * @method Regions findOne(PropelPDO $con = null) Return the first Regions matching the query
 * @method Regions findOneOrCreate(PropelPDO $con = null) Return the first Regions matching the query, or a new Regions object populated from the query conditions when no match is found
 *
 * @method Regions findOneByName(string $name) Return the first Regions filtered by the name column
 * @method Regions findOneByAreaId(int $area_id) Return the first Regions filtered by the area_id column
 * @method Regions findOneByPagetitle(string $pagetitle) Return the first Regions filtered by the pagetitle column
 * @method Regions findOneByNet(string $net) Return the first Regions filtered by the net column
 * @method Regions findOneByAlias(string $alias) Return the first Regions filtered by the alias column
 * @method Regions findOneByIcon(string $icon) Return the first Regions filtered by the icon column
 * @method Regions findOneByType(int $type) Return the first Regions filtered by the type column
 * @method Regions findOneByWeather(int $weather) Return the first Regions filtered by the weather column
 * @method Regions findOneByDeleted(boolean $deleted) Return the first Regions filtered by the deleted column
 *
 * @method array findById(int $id) Return Regions objects filtered by the id column
 * @method array findByName(string $name) Return Regions objects filtered by the name column
 * @method array findByAreaId(int $area_id) Return Regions objects filtered by the area_id column
 * @method array findByPagetitle(string $pagetitle) Return Regions objects filtered by the pagetitle column
 * @method array findByNet(string $net) Return Regions objects filtered by the net column
 * @method array findByAlias(string $alias) Return Regions objects filtered by the alias column
 * @method array findByIcon(string $icon) Return Regions objects filtered by the icon column
 * @method array findByType(int $type) Return Regions objects filtered by the type column
 * @method array findByWeather(int $weather) Return Regions objects filtered by the weather column
 * @method array findByDeleted(boolean $deleted) Return Regions objects filtered by the deleted column
 */
abstract class BaseRegionsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseRegionsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Regions';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new RegionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   RegionsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return RegionsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof RegionsQuery) {
            return $criteria;
        }
        $query = new RegionsQuery(null, null, $modelAlias);

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
     * @return   Regions|Regions[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = RegionsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(RegionsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Regions A model object, or null if the key is not found
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
     * @return                 Regions A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `area_id`, `pagetitle`, `net`, `alias`, `icon`, `type`, `weather`, `deleted` FROM `regions` WHERE `id` = :p0';
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
            $obj = new Regions();
            $obj->hydrate($row);
            RegionsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Regions|Regions[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Regions[]|mixed the list of results, formatted by the current formatter
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
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RegionsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RegionsPeer::ID, $keys, Criteria::IN);
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
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RegionsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RegionsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegionsPeer::ID, $id, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RegionsPeer::NAME, $name, $comparison);
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
     * @see       filterByAreas()
     *
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(RegionsPeer::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(RegionsPeer::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegionsPeer::AREA_ID, $areaId, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RegionsPeer::PAGETITLE, $pagetitle, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RegionsPeer::NET, $net, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RegionsPeer::ALIAS, $alias, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(RegionsPeer::ICON, $icon, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (is_array($type)) {
            $useMinMax = false;
            if (isset($type['min'])) {
                $this->addUsingAlias(RegionsPeer::TYPE, $type['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($type['max'])) {
                $this->addUsingAlias(RegionsPeer::TYPE, $type['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegionsPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the weather column
     *
     * Example usage:
     * <code>
     * $query->filterByWeather(1234); // WHERE weather = 1234
     * $query->filterByWeather(array(12, 34)); // WHERE weather IN (12, 34)
     * $query->filterByWeather(array('min' => 12)); // WHERE weather >= 12
     * $query->filterByWeather(array('max' => 12)); // WHERE weather <= 12
     * </code>
     *
     * @param     mixed $weather The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterByWeather($weather = null, $comparison = null)
    {
        if (is_array($weather)) {
            $useMinMax = false;
            if (isset($weather['min'])) {
                $this->addUsingAlias(RegionsPeer::WEATHER, $weather['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($weather['max'])) {
                $this->addUsingAlias(RegionsPeer::WEATHER, $weather['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RegionsPeer::WEATHER, $weather, $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(RegionsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query by a related Areas object
     *
     * @param   Areas|PropelObjectCollection $areas The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RegionsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAreas($areas, $comparison = null)
    {
        if ($areas instanceof Areas) {
            return $this
                ->addUsingAlias(RegionsPeer::AREA_ID, $areas->getId(), $comparison);
        } elseif ($areas instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RegionsPeer::AREA_ID, $areas->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAreas() only accepts arguments of type Areas or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Areas relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RegionsQuery The current query, for fluid interface
     */
    public function joinAreas($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Areas');

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
            $this->addJoinObject($join, 'Areas');
        }

        return $this;
    }

    /**
     * Use the Areas relation Areas object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AreasQuery A secondary query class using the current class as primary query
     */
    public function useAreasQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAreas($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Areas', '\Admin\AdminBundle\Model\AreasQuery');
    }

    /**
     * Filter the query by a related AdCategoriesSubscribe object
     *
     * @param   AdCategoriesSubscribe|PropelObjectCollection $adCategoriesSubscribe  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RegionsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesSubscribe($adCategoriesSubscribe, $comparison = null)
    {
        if ($adCategoriesSubscribe instanceof AdCategoriesSubscribe) {
            return $this
                ->addUsingAlias(RegionsPeer::ID, $adCategoriesSubscribe->getTownId(), $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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
     * @return                 RegionsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(RegionsPeer::ID, $advs->getRegionId(), $comparison);
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
     * @return RegionsQuery The current query, for fluid interface
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
     * Filter the query by a related Shops object
     *
     * @param   Shops|PropelObjectCollection $shops  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 RegionsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByShops($shops, $comparison = null)
    {
        if ($shops instanceof Shops) {
            return $this
                ->addUsingAlias(RegionsPeer::ID, $shops->getRegionId(), $comparison);
        } elseif ($shops instanceof PropelObjectCollection) {
            return $this
                ->useShopsQuery()
                ->filterByPrimaryKeys($shops->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByShops() only accepts arguments of type Shops or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Shops relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return RegionsQuery The current query, for fluid interface
     */
    public function joinShops($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Shops');

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
            $this->addJoinObject($join, 'Shops');
        }

        return $this;
    }

    /**
     * Use the Shops relation Shops object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\ShopsQuery A secondary query class using the current class as primary query
     */
    public function useShopsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinShops($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Shops', '\Admin\AdminBundle\Model\ShopsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Regions $regions Object to remove from the list of results
     *
     * @return RegionsQuery The current query, for fluid interface
     */
    public function prune($regions = null)
    {
        if ($regions) {
            $this->addUsingAlias(RegionsPeer::ID, $regions->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
