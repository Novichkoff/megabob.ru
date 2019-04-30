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
use Admin\AdminBundle\Model\CouponImages;
use Admin\AdminBundle\Model\CouponImagesPeer;
use Admin\AdminBundle\Model\CouponImagesQuery;
use Admin\AdminBundle\Model\Coupons;

/**
 * @method CouponImagesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CouponImagesQuery orderByCouponId($order = Criteria::ASC) Order by the coupon_id column
 * @method CouponImagesQuery orderByPath($order = Criteria::ASC) Order by the path column
 * @method CouponImagesQuery orderByThumb($order = Criteria::ASC) Order by the thumb column
 * @method CouponImagesQuery orderByTempId($order = Criteria::ASC) Order by the temp_id column
 * @method CouponImagesQuery orderByUploadDate($order = Criteria::ASC) Order by the upload_date column
 *
 * @method CouponImagesQuery groupById() Group by the id column
 * @method CouponImagesQuery groupByCouponId() Group by the coupon_id column
 * @method CouponImagesQuery groupByPath() Group by the path column
 * @method CouponImagesQuery groupByThumb() Group by the thumb column
 * @method CouponImagesQuery groupByTempId() Group by the temp_id column
 * @method CouponImagesQuery groupByUploadDate() Group by the upload_date column
 *
 * @method CouponImagesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CouponImagesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CouponImagesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CouponImagesQuery leftJoinCoupons($relationAlias = null) Adds a LEFT JOIN clause to the query using the Coupons relation
 * @method CouponImagesQuery rightJoinCoupons($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Coupons relation
 * @method CouponImagesQuery innerJoinCoupons($relationAlias = null) Adds a INNER JOIN clause to the query using the Coupons relation
 *
 * @method CouponImages findOne(PropelPDO $con = null) Return the first CouponImages matching the query
 * @method CouponImages findOneOrCreate(PropelPDO $con = null) Return the first CouponImages matching the query, or a new CouponImages object populated from the query conditions when no match is found
 *
 * @method CouponImages findOneByCouponId(int $coupon_id) Return the first CouponImages filtered by the coupon_id column
 * @method CouponImages findOneByPath(string $path) Return the first CouponImages filtered by the path column
 * @method CouponImages findOneByThumb(string $thumb) Return the first CouponImages filtered by the thumb column
 * @method CouponImages findOneByTempId(string $temp_id) Return the first CouponImages filtered by the temp_id column
 * @method CouponImages findOneByUploadDate(string $upload_date) Return the first CouponImages filtered by the upload_date column
 *
 * @method array findById(int $id) Return CouponImages objects filtered by the id column
 * @method array findByCouponId(int $coupon_id) Return CouponImages objects filtered by the coupon_id column
 * @method array findByPath(string $path) Return CouponImages objects filtered by the path column
 * @method array findByThumb(string $thumb) Return CouponImages objects filtered by the thumb column
 * @method array findByTempId(string $temp_id) Return CouponImages objects filtered by the temp_id column
 * @method array findByUploadDate(string $upload_date) Return CouponImages objects filtered by the upload_date column
 */
abstract class BaseCouponImagesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCouponImagesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\CouponImages';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CouponImagesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CouponImagesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CouponImagesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CouponImagesQuery) {
            return $criteria;
        }
        $query = new CouponImagesQuery(null, null, $modelAlias);

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
     * @return   CouponImages|CouponImages[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CouponImagesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CouponImagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 CouponImages A model object, or null if the key is not found
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
     * @return                 CouponImages A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `coupon_id`, `path`, `thumb`, `temp_id`, `upload_date` FROM `coupon_images` WHERE `id` = :p0';
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
            $obj = new CouponImages();
            $obj->hydrate($row);
            CouponImagesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return CouponImages|CouponImages[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|CouponImages[]|mixed the list of results, formatted by the current formatter
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
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CouponImagesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CouponImagesPeer::ID, $keys, Criteria::IN);
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
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CouponImagesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CouponImagesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponImagesPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the coupon_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCouponId(1234); // WHERE coupon_id = 1234
     * $query->filterByCouponId(array(12, 34)); // WHERE coupon_id IN (12, 34)
     * $query->filterByCouponId(array('min' => 12)); // WHERE coupon_id >= 12
     * $query->filterByCouponId(array('max' => 12)); // WHERE coupon_id <= 12
     * </code>
     *
     * @see       filterByCoupons()
     *
     * @param     mixed $couponId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterByCouponId($couponId = null, $comparison = null)
    {
        if (is_array($couponId)) {
            $useMinMax = false;
            if (isset($couponId['min'])) {
                $this->addUsingAlias(CouponImagesPeer::COUPON_ID, $couponId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($couponId['max'])) {
                $this->addUsingAlias(CouponImagesPeer::COUPON_ID, $couponId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponImagesPeer::COUPON_ID, $couponId, $comparison);
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
     * @return CouponImagesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CouponImagesPeer::PATH, $path, $comparison);
    }

    /**
     * Filter the query on the thumb column
     *
     * Example usage:
     * <code>
     * $query->filterByThumb('fooValue');   // WHERE thumb = 'fooValue'
     * $query->filterByThumb('%fooValue%'); // WHERE thumb LIKE '%fooValue%'
     * </code>
     *
     * @param     string $thumb The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterByThumb($thumb = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($thumb)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $thumb)) {
                $thumb = str_replace('*', '%', $thumb);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponImagesPeer::THUMB, $thumb, $comparison);
    }

    /**
     * Filter the query on the temp_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTempId('fooValue');   // WHERE temp_id = 'fooValue'
     * $query->filterByTempId('%fooValue%'); // WHERE temp_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tempId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterByTempId($tempId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tempId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tempId)) {
                $tempId = str_replace('*', '%', $tempId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponImagesPeer::TEMP_ID, $tempId, $comparison);
    }

    /**
     * Filter the query on the upload_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUploadDate('2011-03-14'); // WHERE upload_date = '2011-03-14'
     * $query->filterByUploadDate('now'); // WHERE upload_date = '2011-03-14'
     * $query->filterByUploadDate(array('max' => 'yesterday')); // WHERE upload_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $uploadDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function filterByUploadDate($uploadDate = null, $comparison = null)
    {
        if (is_array($uploadDate)) {
            $useMinMax = false;
            if (isset($uploadDate['min'])) {
                $this->addUsingAlias(CouponImagesPeer::UPLOAD_DATE, $uploadDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($uploadDate['max'])) {
                $this->addUsingAlias(CouponImagesPeer::UPLOAD_DATE, $uploadDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponImagesPeer::UPLOAD_DATE, $uploadDate, $comparison);
    }

    /**
     * Filter the query by a related Coupons object
     *
     * @param   Coupons|PropelObjectCollection $coupons The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponImagesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCoupons($coupons, $comparison = null)
    {
        if ($coupons instanceof Coupons) {
            return $this
                ->addUsingAlias(CouponImagesPeer::COUPON_ID, $coupons->getId(), $comparison);
        } elseif ($coupons instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CouponImagesPeer::COUPON_ID, $coupons->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCoupons() only accepts arguments of type Coupons or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Coupons relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function joinCoupons($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Coupons');

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
            $this->addJoinObject($join, 'Coupons');
        }

        return $this;
    }

    /**
     * Use the Coupons relation Coupons object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\CouponsQuery A secondary query class using the current class as primary query
     */
    public function useCouponsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCoupons($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Coupons', '\Admin\AdminBundle\Model\CouponsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   CouponImages $couponImages Object to remove from the list of results
     *
     * @return CouponImagesQuery The current query, for fluid interface
     */
    public function prune($couponImages = null)
    {
        if ($couponImages) {
            $this->addUsingAlias(CouponImagesPeer::ID, $couponImages->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
