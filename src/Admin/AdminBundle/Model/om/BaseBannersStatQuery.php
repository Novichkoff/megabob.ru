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
use Admin\AdminBundle\Model\Banners;
use Admin\AdminBundle\Model\BannersStat;
use Admin\AdminBundle\Model\BannersStatPeer;
use Admin\AdminBundle\Model\BannersStatQuery;

/**
 * @method BannersStatQuery orderById($order = Criteria::ASC) Order by the id column
 * @method BannersStatQuery orderByBannerId($order = Criteria::ASC) Order by the banner_id column
 * @method BannersStatQuery orderByShows($order = Criteria::ASC) Order by the shows column
 * @method BannersStatQuery orderByClicks($order = Criteria::ASC) Order by the clicks column
 * @method BannersStatQuery orderByResidue($order = Criteria::ASC) Order by the residue column
 * @method BannersStatQuery orderByStatDate($order = Criteria::ASC) Order by the stat_date column
 *
 * @method BannersStatQuery groupById() Group by the id column
 * @method BannersStatQuery groupByBannerId() Group by the banner_id column
 * @method BannersStatQuery groupByShows() Group by the shows column
 * @method BannersStatQuery groupByClicks() Group by the clicks column
 * @method BannersStatQuery groupByResidue() Group by the residue column
 * @method BannersStatQuery groupByStatDate() Group by the stat_date column
 *
 * @method BannersStatQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BannersStatQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BannersStatQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BannersStatQuery leftJoinBanners($relationAlias = null) Adds a LEFT JOIN clause to the query using the Banners relation
 * @method BannersStatQuery rightJoinBanners($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Banners relation
 * @method BannersStatQuery innerJoinBanners($relationAlias = null) Adds a INNER JOIN clause to the query using the Banners relation
 *
 * @method BannersStat findOne(PropelPDO $con = null) Return the first BannersStat matching the query
 * @method BannersStat findOneOrCreate(PropelPDO $con = null) Return the first BannersStat matching the query, or a new BannersStat object populated from the query conditions when no match is found
 *
 * @method BannersStat findOneByBannerId(int $banner_id) Return the first BannersStat filtered by the banner_id column
 * @method BannersStat findOneByShows(int $shows) Return the first BannersStat filtered by the shows column
 * @method BannersStat findOneByClicks(int $clicks) Return the first BannersStat filtered by the clicks column
 * @method BannersStat findOneByResidue(int $residue) Return the first BannersStat filtered by the residue column
 * @method BannersStat findOneByStatDate(string $stat_date) Return the first BannersStat filtered by the stat_date column
 *
 * @method array findById(int $id) Return BannersStat objects filtered by the id column
 * @method array findByBannerId(int $banner_id) Return BannersStat objects filtered by the banner_id column
 * @method array findByShows(int $shows) Return BannersStat objects filtered by the shows column
 * @method array findByClicks(int $clicks) Return BannersStat objects filtered by the clicks column
 * @method array findByResidue(int $residue) Return BannersStat objects filtered by the residue column
 * @method array findByStatDate(string $stat_date) Return BannersStat objects filtered by the stat_date column
 */
abstract class BaseBannersStatQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBannersStatQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\BannersStat';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BannersStatQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BannersStatQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BannersStatQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BannersStatQuery) {
            return $criteria;
        }
        $query = new BannersStatQuery(null, null, $modelAlias);

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
     * @return   BannersStat|BannersStat[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BannersStatPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BannersStatPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BannersStat A model object, or null if the key is not found
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
     * @return                 BannersStat A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `banner_id`, `shows`, `clicks`, `residue`, `stat_date` FROM `banners_stat` WHERE `id` = :p0';
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
            $obj = new BannersStat();
            $obj->hydrate($row);
            BannersStatPeer::addInstanceToPool($obj, (string) $key);
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
     * @return BannersStat|BannersStat[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|BannersStat[]|mixed the list of results, formatted by the current formatter
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
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BannersStatPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BannersStatPeer::ID, $keys, Criteria::IN);
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
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(BannersStatPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(BannersStatPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersStatPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the banner_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBannerId(1234); // WHERE banner_id = 1234
     * $query->filterByBannerId(array(12, 34)); // WHERE banner_id IN (12, 34)
     * $query->filterByBannerId(array('min' => 12)); // WHERE banner_id >= 12
     * $query->filterByBannerId(array('max' => 12)); // WHERE banner_id <= 12
     * </code>
     *
     * @see       filterByBanners()
     *
     * @param     mixed $bannerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByBannerId($bannerId = null, $comparison = null)
    {
        if (is_array($bannerId)) {
            $useMinMax = false;
            if (isset($bannerId['min'])) {
                $this->addUsingAlias(BannersStatPeer::BANNER_ID, $bannerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bannerId['max'])) {
                $this->addUsingAlias(BannersStatPeer::BANNER_ID, $bannerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersStatPeer::BANNER_ID, $bannerId, $comparison);
    }

    /**
     * Filter the query on the shows column
     *
     * Example usage:
     * <code>
     * $query->filterByShows(1234); // WHERE shows = 1234
     * $query->filterByShows(array(12, 34)); // WHERE shows IN (12, 34)
     * $query->filterByShows(array('min' => 12)); // WHERE shows >= 12
     * $query->filterByShows(array('max' => 12)); // WHERE shows <= 12
     * </code>
     *
     * @param     mixed $shows The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByShows($shows = null, $comparison = null)
    {
        if (is_array($shows)) {
            $useMinMax = false;
            if (isset($shows['min'])) {
                $this->addUsingAlias(BannersStatPeer::SHOWS, $shows['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shows['max'])) {
                $this->addUsingAlias(BannersStatPeer::SHOWS, $shows['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersStatPeer::SHOWS, $shows, $comparison);
    }

    /**
     * Filter the query on the clicks column
     *
     * Example usage:
     * <code>
     * $query->filterByClicks(1234); // WHERE clicks = 1234
     * $query->filterByClicks(array(12, 34)); // WHERE clicks IN (12, 34)
     * $query->filterByClicks(array('min' => 12)); // WHERE clicks >= 12
     * $query->filterByClicks(array('max' => 12)); // WHERE clicks <= 12
     * </code>
     *
     * @param     mixed $clicks The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByClicks($clicks = null, $comparison = null)
    {
        if (is_array($clicks)) {
            $useMinMax = false;
            if (isset($clicks['min'])) {
                $this->addUsingAlias(BannersStatPeer::CLICKS, $clicks['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clicks['max'])) {
                $this->addUsingAlias(BannersStatPeer::CLICKS, $clicks['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersStatPeer::CLICKS, $clicks, $comparison);
    }

    /**
     * Filter the query on the residue column
     *
     * Example usage:
     * <code>
     * $query->filterByResidue(1234); // WHERE residue = 1234
     * $query->filterByResidue(array(12, 34)); // WHERE residue IN (12, 34)
     * $query->filterByResidue(array('min' => 12)); // WHERE residue >= 12
     * $query->filterByResidue(array('max' => 12)); // WHERE residue <= 12
     * </code>
     *
     * @param     mixed $residue The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByResidue($residue = null, $comparison = null)
    {
        if (is_array($residue)) {
            $useMinMax = false;
            if (isset($residue['min'])) {
                $this->addUsingAlias(BannersStatPeer::RESIDUE, $residue['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($residue['max'])) {
                $this->addUsingAlias(BannersStatPeer::RESIDUE, $residue['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersStatPeer::RESIDUE, $residue, $comparison);
    }

    /**
     * Filter the query on the stat_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStatDate('2011-03-14'); // WHERE stat_date = '2011-03-14'
     * $query->filterByStatDate('now'); // WHERE stat_date = '2011-03-14'
     * $query->filterByStatDate(array('max' => 'yesterday')); // WHERE stat_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $statDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function filterByStatDate($statDate = null, $comparison = null)
    {
        if (is_array($statDate)) {
            $useMinMax = false;
            if (isset($statDate['min'])) {
                $this->addUsingAlias(BannersStatPeer::STAT_DATE, $statDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($statDate['max'])) {
                $this->addUsingAlias(BannersStatPeer::STAT_DATE, $statDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BannersStatPeer::STAT_DATE, $statDate, $comparison);
    }

    /**
     * Filter the query by a related Banners object
     *
     * @param   Banners|PropelObjectCollection $banners The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BannersStatQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBanners($banners, $comparison = null)
    {
        if ($banners instanceof Banners) {
            return $this
                ->addUsingAlias(BannersStatPeer::BANNER_ID, $banners->getId(), $comparison);
        } elseif ($banners instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BannersStatPeer::BANNER_ID, $banners->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByBanners() only accepts arguments of type Banners or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Banners relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function joinBanners($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Banners');

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
            $this->addJoinObject($join, 'Banners');
        }

        return $this;
    }

    /**
     * Use the Banners relation Banners object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\BannersQuery A secondary query class using the current class as primary query
     */
    public function useBannersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBanners($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Banners', '\Admin\AdminBundle\Model\BannersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   BannersStat $bannersStat Object to remove from the list of results
     *
     * @return BannersStatQuery The current query, for fluid interface
     */
    public function prune($bannersStat = null)
    {
        if ($bannersStat) {
            $this->addUsingAlias(BannersStatPeer::ID, $bannersStat->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
