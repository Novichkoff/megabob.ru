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
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Model\Packets;
use Admin\AdminBundle\Model\PacketsPeer;
use Admin\AdminBundle\Model\PacketsQuery;

/**
 * @method PacketsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PacketsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method PacketsQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method PacketsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method PacketsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method PacketsQuery orderBySale($order = Criteria::ASC) Order by the sale column
 * @method PacketsQuery orderByDays($order = Criteria::ASC) Order by the days column
 *
 * @method PacketsQuery groupById() Group by the id column
 * @method PacketsQuery groupByName() Group by the name column
 * @method PacketsQuery groupByTitle() Group by the title column
 * @method PacketsQuery groupByDescription() Group by the description column
 * @method PacketsQuery groupByPrice() Group by the price column
 * @method PacketsQuery groupBySale() Group by the sale column
 * @method PacketsQuery groupByDays() Group by the days column
 *
 * @method PacketsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PacketsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PacketsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PacketsQuery leftJoinAdvPackets($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvPackets relation
 * @method PacketsQuery rightJoinAdvPackets($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvPackets relation
 * @method PacketsQuery innerJoinAdvPackets($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvPackets relation
 *
 * @method Packets findOne(PropelPDO $con = null) Return the first Packets matching the query
 * @method Packets findOneOrCreate(PropelPDO $con = null) Return the first Packets matching the query, or a new Packets object populated from the query conditions when no match is found
 *
 * @method Packets findOneByName(string $name) Return the first Packets filtered by the name column
 * @method Packets findOneByTitle(string $title) Return the first Packets filtered by the title column
 * @method Packets findOneByDescription(string $description) Return the first Packets filtered by the description column
 * @method Packets findOneByPrice(int $price) Return the first Packets filtered by the price column
 * @method Packets findOneBySale(int $sale) Return the first Packets filtered by the sale column
 * @method Packets findOneByDays(int $days) Return the first Packets filtered by the days column
 *
 * @method array findById(int $id) Return Packets objects filtered by the id column
 * @method array findByName(string $name) Return Packets objects filtered by the name column
 * @method array findByTitle(string $title) Return Packets objects filtered by the title column
 * @method array findByDescription(string $description) Return Packets objects filtered by the description column
 * @method array findByPrice(int $price) Return Packets objects filtered by the price column
 * @method array findBySale(int $sale) Return Packets objects filtered by the sale column
 * @method array findByDays(int $days) Return Packets objects filtered by the days column
 */
abstract class BasePacketsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePacketsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Packets';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PacketsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PacketsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PacketsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PacketsQuery) {
            return $criteria;
        }
        $query = new PacketsQuery(null, null, $modelAlias);

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
     * @return   Packets|Packets[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PacketsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PacketsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Packets A model object, or null if the key is not found
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
     * @return                 Packets A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `title`, `description`, `price`, `sale`, `days` FROM `packets` WHERE `id` = :p0';
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
            $obj = new Packets();
            $obj->hydrate($row);
            PacketsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Packets|Packets[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Packets[]|mixed the list of results, formatted by the current formatter
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
     * @return PacketsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PacketsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PacketsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PacketsPeer::ID, $keys, Criteria::IN);
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
     * @return PacketsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PacketsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PacketsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacketsPeer::ID, $id, $comparison);
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
     * @return PacketsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PacketsPeer::NAME, $name, $comparison);
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
     * @return PacketsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PacketsPeer::TITLE, $title, $comparison);
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
     * @return PacketsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PacketsPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the price column
     *
     * Example usage:
     * <code>
     * $query->filterByPrice(1234); // WHERE price = 1234
     * $query->filterByPrice(array(12, 34)); // WHERE price IN (12, 34)
     * $query->filterByPrice(array('min' => 12)); // WHERE price >= 12
     * $query->filterByPrice(array('max' => 12)); // WHERE price <= 12
     * </code>
     *
     * @param     mixed $price The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PacketsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(PacketsPeer::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(PacketsPeer::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacketsPeer::PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the sale column
     *
     * Example usage:
     * <code>
     * $query->filterBySale(1234); // WHERE sale = 1234
     * $query->filterBySale(array(12, 34)); // WHERE sale IN (12, 34)
     * $query->filterBySale(array('min' => 12)); // WHERE sale >= 12
     * $query->filterBySale(array('max' => 12)); // WHERE sale <= 12
     * </code>
     *
     * @param     mixed $sale The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PacketsQuery The current query, for fluid interface
     */
    public function filterBySale($sale = null, $comparison = null)
    {
        if (is_array($sale)) {
            $useMinMax = false;
            if (isset($sale['min'])) {
                $this->addUsingAlias(PacketsPeer::SALE, $sale['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sale['max'])) {
                $this->addUsingAlias(PacketsPeer::SALE, $sale['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacketsPeer::SALE, $sale, $comparison);
    }

    /**
     * Filter the query on the days column
     *
     * Example usage:
     * <code>
     * $query->filterByDays(1234); // WHERE days = 1234
     * $query->filterByDays(array(12, 34)); // WHERE days IN (12, 34)
     * $query->filterByDays(array('min' => 12)); // WHERE days >= 12
     * $query->filterByDays(array('max' => 12)); // WHERE days <= 12
     * </code>
     *
     * @param     mixed $days The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PacketsQuery The current query, for fluid interface
     */
    public function filterByDays($days = null, $comparison = null)
    {
        if (is_array($days)) {
            $useMinMax = false;
            if (isset($days['min'])) {
                $this->addUsingAlias(PacketsPeer::DAYS, $days['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($days['max'])) {
                $this->addUsingAlias(PacketsPeer::DAYS, $days['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PacketsPeer::DAYS, $days, $comparison);
    }

    /**
     * Filter the query by a related AdvPackets object
     *
     * @param   AdvPackets|PropelObjectCollection $advPackets  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PacketsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvPackets($advPackets, $comparison = null)
    {
        if ($advPackets instanceof AdvPackets) {
            return $this
                ->addUsingAlias(PacketsPeer::ID, $advPackets->getPacketId(), $comparison);
        } elseif ($advPackets instanceof PropelObjectCollection) {
            return $this
                ->useAdvPacketsQuery()
                ->filterByPrimaryKeys($advPackets->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvPackets() only accepts arguments of type AdvPackets or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvPackets relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PacketsQuery The current query, for fluid interface
     */
    public function joinAdvPackets($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvPackets');

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
            $this->addJoinObject($join, 'AdvPackets');
        }

        return $this;
    }

    /**
     * Use the AdvPackets relation AdvPackets object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvPacketsQuery A secondary query class using the current class as primary query
     */
    public function useAdvPacketsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvPackets($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvPackets', '\Admin\AdminBundle\Model\AdvPacketsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Packets $packets Object to remove from the list of results
     *
     * @return PacketsQuery The current query, for fluid interface
     */
    public function prune($packets = null)
    {
        if ($packets) {
            $this->addUsingAlias(PacketsPeer::ID, $packets->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
