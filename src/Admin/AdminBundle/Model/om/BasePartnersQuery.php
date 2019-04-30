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
use Admin\AdminBundle\Model\Partners;
use Admin\AdminBundle\Model\PartnersPeer;
use Admin\AdminBundle\Model\PartnersQuery;
use FOS\UserBundle\Propel\User;

/**
 * @method PartnersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method PartnersQuery orderByFosUserId($order = Criteria::ASC) Order by the fos_user_id column
 * @method PartnersQuery orderBySite($order = Criteria::ASC) Order by the site column
 * @method PartnersQuery orderByCnt($order = Criteria::ASC) Order by the cnt column
 *
 * @method PartnersQuery groupById() Group by the id column
 * @method PartnersQuery groupByFosUserId() Group by the fos_user_id column
 * @method PartnersQuery groupBySite() Group by the site column
 * @method PartnersQuery groupByCnt() Group by the cnt column
 *
 * @method PartnersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PartnersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PartnersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PartnersQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method PartnersQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method PartnersQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method Partners findOne(PropelPDO $con = null) Return the first Partners matching the query
 * @method Partners findOneOrCreate(PropelPDO $con = null) Return the first Partners matching the query, or a new Partners object populated from the query conditions when no match is found
 *
 * @method Partners findOneByFosUserId(int $fos_user_id) Return the first Partners filtered by the fos_user_id column
 * @method Partners findOneBySite(string $site) Return the first Partners filtered by the site column
 * @method Partners findOneByCnt(int $cnt) Return the first Partners filtered by the cnt column
 *
 * @method array findById(int $id) Return Partners objects filtered by the id column
 * @method array findByFosUserId(int $fos_user_id) Return Partners objects filtered by the fos_user_id column
 * @method array findBySite(string $site) Return Partners objects filtered by the site column
 * @method array findByCnt(int $cnt) Return Partners objects filtered by the cnt column
 */
abstract class BasePartnersQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePartnersQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Partners';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PartnersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PartnersQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PartnersQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PartnersQuery) {
            return $criteria;
        }
        $query = new PartnersQuery(null, null, $modelAlias);

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
     * @return   Partners|Partners[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PartnersPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PartnersPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Partners A model object, or null if the key is not found
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
     * @return                 Partners A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `fos_user_id`, `site`, `cnt` FROM `partners` WHERE `id` = :p0';
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
            $obj = new Partners();
            $obj->hydrate($row);
            PartnersPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Partners|Partners[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Partners[]|mixed the list of results, formatted by the current formatter
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
     * @return PartnersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PartnersPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PartnersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PartnersPeer::ID, $keys, Criteria::IN);
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
     * @return PartnersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PartnersPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PartnersPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartnersPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the fos_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFosUserId(1234); // WHERE fos_user_id = 1234
     * $query->filterByFosUserId(array(12, 34)); // WHERE fos_user_id IN (12, 34)
     * $query->filterByFosUserId(array('min' => 12)); // WHERE fos_user_id >= 12
     * $query->filterByFosUserId(array('max' => 12)); // WHERE fos_user_id <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $fosUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PartnersQuery The current query, for fluid interface
     */
    public function filterByFosUserId($fosUserId = null, $comparison = null)
    {
        if (is_array($fosUserId)) {
            $useMinMax = false;
            if (isset($fosUserId['min'])) {
                $this->addUsingAlias(PartnersPeer::FOS_USER_ID, $fosUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fosUserId['max'])) {
                $this->addUsingAlias(PartnersPeer::FOS_USER_ID, $fosUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartnersPeer::FOS_USER_ID, $fosUserId, $comparison);
    }

    /**
     * Filter the query on the site column
     *
     * Example usage:
     * <code>
     * $query->filterBySite('fooValue');   // WHERE site = 'fooValue'
     * $query->filterBySite('%fooValue%'); // WHERE site LIKE '%fooValue%'
     * </code>
     *
     * @param     string $site The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PartnersQuery The current query, for fluid interface
     */
    public function filterBySite($site = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($site)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $site)) {
                $site = str_replace('*', '%', $site);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PartnersPeer::SITE, $site, $comparison);
    }

    /**
     * Filter the query on the cnt column
     *
     * Example usage:
     * <code>
     * $query->filterByCnt(1234); // WHERE cnt = 1234
     * $query->filterByCnt(array(12, 34)); // WHERE cnt IN (12, 34)
     * $query->filterByCnt(array('min' => 12)); // WHERE cnt >= 12
     * $query->filterByCnt(array('max' => 12)); // WHERE cnt <= 12
     * </code>
     *
     * @param     mixed $cnt The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PartnersQuery The current query, for fluid interface
     */
    public function filterByCnt($cnt = null, $comparison = null)
    {
        if (is_array($cnt)) {
            $useMinMax = false;
            if (isset($cnt['min'])) {
                $this->addUsingAlias(PartnersPeer::CNT, $cnt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cnt['max'])) {
                $this->addUsingAlias(PartnersPeer::CNT, $cnt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PartnersPeer::CNT, $cnt, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PartnersQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(PartnersPeer::FOS_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PartnersPeer::FOS_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type User or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PartnersQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

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
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \FOS\UserBundle\Propel\UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\FOS\UserBundle\Propel\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Partners $partners Object to remove from the list of results
     *
     * @return PartnersQuery The current query, for fluid interface
     */
    public function prune($partners = null)
    {
        if ($partners) {
            $this->addUsingAlias(PartnersPeer::ID, $partners->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
