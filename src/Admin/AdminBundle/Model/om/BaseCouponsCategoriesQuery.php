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
use Admin\AdminBundle\Model\Coupons;
use Admin\AdminBundle\Model\CouponsCategories;
use Admin\AdminBundle\Model\CouponsCategoriesPeer;
use Admin\AdminBundle\Model\CouponsCategoriesQuery;

/**
 * @method CouponsCategoriesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method CouponsCategoriesQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method CouponsCategoriesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CouponsCategoriesQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method CouponsCategoriesQuery orderByPagetitle($order = Criteria::ASC) Order by the pagetitle column
 * @method CouponsCategoriesQuery orderByCatchPhrase($order = Criteria::ASC) Order by the catch_phrase column
 * @method CouponsCategoriesQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method CouponsCategoriesQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method CouponsCategoriesQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method CouponsCategoriesQuery orderByUsemap($order = Criteria::ASC) Order by the usemap column
 * @method CouponsCategoriesQuery orderByOnmain($order = Criteria::ASC) Order by the onmain column
 *
 * @method CouponsCategoriesQuery groupById() Group by the id column
 * @method CouponsCategoriesQuery groupByParentId() Group by the parent_id column
 * @method CouponsCategoriesQuery groupByName() Group by the name column
 * @method CouponsCategoriesQuery groupByAlias() Group by the alias column
 * @method CouponsCategoriesQuery groupByPagetitle() Group by the pagetitle column
 * @method CouponsCategoriesQuery groupByCatchPhrase() Group by the catch_phrase column
 * @method CouponsCategoriesQuery groupByIcon() Group by the icon column
 * @method CouponsCategoriesQuery groupByEnabled() Group by the enabled column
 * @method CouponsCategoriesQuery groupByDeleted() Group by the deleted column
 * @method CouponsCategoriesQuery groupByUsemap() Group by the usemap column
 * @method CouponsCategoriesQuery groupByOnmain() Group by the onmain column
 *
 * @method CouponsCategoriesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CouponsCategoriesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CouponsCategoriesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CouponsCategoriesQuery leftJoinCouponsCategoriesRelatedByParentId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CouponsCategoriesRelatedByParentId relation
 * @method CouponsCategoriesQuery rightJoinCouponsCategoriesRelatedByParentId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CouponsCategoriesRelatedByParentId relation
 * @method CouponsCategoriesQuery innerJoinCouponsCategoriesRelatedByParentId($relationAlias = null) Adds a INNER JOIN clause to the query using the CouponsCategoriesRelatedByParentId relation
 *
 * @method CouponsCategoriesQuery leftJoinCouponsChilds($relationAlias = null) Adds a LEFT JOIN clause to the query using the CouponsChilds relation
 * @method CouponsCategoriesQuery rightJoinCouponsChilds($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CouponsChilds relation
 * @method CouponsCategoriesQuery innerJoinCouponsChilds($relationAlias = null) Adds a INNER JOIN clause to the query using the CouponsChilds relation
 *
 * @method CouponsCategoriesQuery leftJoinCoupons($relationAlias = null) Adds a LEFT JOIN clause to the query using the Coupons relation
 * @method CouponsCategoriesQuery rightJoinCoupons($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Coupons relation
 * @method CouponsCategoriesQuery innerJoinCoupons($relationAlias = null) Adds a INNER JOIN clause to the query using the Coupons relation
 *
 * @method CouponsCategories findOne(PropelPDO $con = null) Return the first CouponsCategories matching the query
 * @method CouponsCategories findOneOrCreate(PropelPDO $con = null) Return the first CouponsCategories matching the query, or a new CouponsCategories object populated from the query conditions when no match is found
 *
 * @method CouponsCategories findOneByParentId(int $parent_id) Return the first CouponsCategories filtered by the parent_id column
 * @method CouponsCategories findOneByName(string $name) Return the first CouponsCategories filtered by the name column
 * @method CouponsCategories findOneByAlias(string $alias) Return the first CouponsCategories filtered by the alias column
 * @method CouponsCategories findOneByPagetitle(string $pagetitle) Return the first CouponsCategories filtered by the pagetitle column
 * @method CouponsCategories findOneByCatchPhrase(string $catch_phrase) Return the first CouponsCategories filtered by the catch_phrase column
 * @method CouponsCategories findOneByIcon(string $icon) Return the first CouponsCategories filtered by the icon column
 * @method CouponsCategories findOneByEnabled(boolean $enabled) Return the first CouponsCategories filtered by the enabled column
 * @method CouponsCategories findOneByDeleted(boolean $deleted) Return the first CouponsCategories filtered by the deleted column
 * @method CouponsCategories findOneByUsemap(boolean $usemap) Return the first CouponsCategories filtered by the usemap column
 * @method CouponsCategories findOneByOnmain(boolean $onmain) Return the first CouponsCategories filtered by the onmain column
 *
 * @method array findById(int $id) Return CouponsCategories objects filtered by the id column
 * @method array findByParentId(int $parent_id) Return CouponsCategories objects filtered by the parent_id column
 * @method array findByName(string $name) Return CouponsCategories objects filtered by the name column
 * @method array findByAlias(string $alias) Return CouponsCategories objects filtered by the alias column
 * @method array findByPagetitle(string $pagetitle) Return CouponsCategories objects filtered by the pagetitle column
 * @method array findByCatchPhrase(string $catch_phrase) Return CouponsCategories objects filtered by the catch_phrase column
 * @method array findByIcon(string $icon) Return CouponsCategories objects filtered by the icon column
 * @method array findByEnabled(boolean $enabled) Return CouponsCategories objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return CouponsCategories objects filtered by the deleted column
 * @method array findByUsemap(boolean $usemap) Return CouponsCategories objects filtered by the usemap column
 * @method array findByOnmain(boolean $onmain) Return CouponsCategories objects filtered by the onmain column
 */
abstract class BaseCouponsCategoriesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCouponsCategoriesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\CouponsCategories';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CouponsCategoriesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CouponsCategoriesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CouponsCategoriesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CouponsCategoriesQuery) {
            return $criteria;
        }
        $query = new CouponsCategoriesQuery(null, null, $modelAlias);

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
     * @return   CouponsCategories|CouponsCategories[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CouponsCategoriesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CouponsCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 CouponsCategories A model object, or null if the key is not found
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
     * @return                 CouponsCategories A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `parent_id`, `name`, `alias`, `pagetitle`, `catch_phrase`, `icon`, `enabled`, `deleted`, `usemap`, `onmain` FROM `coupons_categories` WHERE `id` = :p0';
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
            $obj = new CouponsCategories();
            $obj->hydrate($row);
            CouponsCategoriesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return CouponsCategories|CouponsCategories[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|CouponsCategories[]|mixed the list of results, formatted by the current formatter
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CouponsCategoriesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CouponsCategoriesPeer::ID, $keys, Criteria::IN);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CouponsCategoriesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CouponsCategoriesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the parent_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentId(1234); // WHERE parent_id = 1234
     * $query->filterByParentId(array(12, 34)); // WHERE parent_id IN (12, 34)
     * $query->filterByParentId(array('min' => 12)); // WHERE parent_id >= 12
     * $query->filterByParentId(array('max' => 12)); // WHERE parent_id <= 12
     * </code>
     *
     * @see       filterByCouponsCategoriesRelatedByParentId()
     *
     * @param     mixed $parentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (is_array($parentId)) {
            $useMinMax = false;
            if (isset($parentId['min'])) {
                $this->addUsingAlias(CouponsCategoriesPeer::PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentId['max'])) {
                $this->addUsingAlias(CouponsCategoriesPeer::PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::PARENT_ID, $parentId, $comparison);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CouponsCategoriesPeer::NAME, $name, $comparison);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CouponsCategoriesPeer::ALIAS, $alias, $comparison);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CouponsCategoriesPeer::PAGETITLE, $pagetitle, $comparison);
    }

    /**
     * Filter the query on the catch_phrase column
     *
     * Example usage:
     * <code>
     * $query->filterByCatchPhrase('fooValue');   // WHERE catch_phrase = 'fooValue'
     * $query->filterByCatchPhrase('%fooValue%'); // WHERE catch_phrase LIKE '%fooValue%'
     * </code>
     *
     * @param     string $catchPhrase The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByCatchPhrase($catchPhrase = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($catchPhrase)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $catchPhrase)) {
                $catchPhrase = str_replace('*', '%', $catchPhrase);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::CATCH_PHRASE, $catchPhrase, $comparison);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CouponsCategoriesPeer::ICON, $icon, $comparison);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::ENABLED, $enabled, $comparison);
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query on the usemap column
     *
     * Example usage:
     * <code>
     * $query->filterByUsemap(true); // WHERE usemap = true
     * $query->filterByUsemap('yes'); // WHERE usemap = true
     * </code>
     *
     * @param     boolean|string $usemap The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByUsemap($usemap = null, $comparison = null)
    {
        if (is_string($usemap)) {
            $usemap = in_array(strtolower($usemap), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::USEMAP, $usemap, $comparison);
    }

    /**
     * Filter the query on the onmain column
     *
     * Example usage:
     * <code>
     * $query->filterByOnmain(true); // WHERE onmain = true
     * $query->filterByOnmain('yes'); // WHERE onmain = true
     * </code>
     *
     * @param     boolean|string $onmain The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function filterByOnmain($onmain = null, $comparison = null)
    {
        if (is_string($onmain)) {
            $onmain = in_array(strtolower($onmain), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CouponsCategoriesPeer::ONMAIN, $onmain, $comparison);
    }

    /**
     * Filter the query by a related CouponsCategories object
     *
     * @param   CouponsCategories|PropelObjectCollection $couponsCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCouponsCategoriesRelatedByParentId($couponsCategories, $comparison = null)
    {
        if ($couponsCategories instanceof CouponsCategories) {
            return $this
                ->addUsingAlias(CouponsCategoriesPeer::PARENT_ID, $couponsCategories->getId(), $comparison);
        } elseif ($couponsCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CouponsCategoriesPeer::PARENT_ID, $couponsCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCouponsCategoriesRelatedByParentId() only accepts arguments of type CouponsCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CouponsCategoriesRelatedByParentId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function joinCouponsCategoriesRelatedByParentId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CouponsCategoriesRelatedByParentId');

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
            $this->addJoinObject($join, 'CouponsCategoriesRelatedByParentId');
        }

        return $this;
    }

    /**
     * Use the CouponsCategoriesRelatedByParentId relation CouponsCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\CouponsCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useCouponsCategoriesRelatedByParentIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCouponsCategoriesRelatedByParentId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CouponsCategoriesRelatedByParentId', '\Admin\AdminBundle\Model\CouponsCategoriesQuery');
    }

    /**
     * Filter the query by a related CouponsCategories object
     *
     * @param   CouponsCategories|PropelObjectCollection $couponsCategories  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCouponsChilds($couponsCategories, $comparison = null)
    {
        if ($couponsCategories instanceof CouponsCategories) {
            return $this
                ->addUsingAlias(CouponsCategoriesPeer::ID, $couponsCategories->getParentId(), $comparison);
        } elseif ($couponsCategories instanceof PropelObjectCollection) {
            return $this
                ->useCouponsChildsQuery()
                ->filterByPrimaryKeys($couponsCategories->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCouponsChilds() only accepts arguments of type CouponsCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CouponsChilds relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function joinCouponsChilds($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CouponsChilds');

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
            $this->addJoinObject($join, 'CouponsChilds');
        }

        return $this;
    }

    /**
     * Use the CouponsChilds relation CouponsCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\CouponsCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useCouponsChildsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCouponsChilds($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CouponsChilds', '\Admin\AdminBundle\Model\CouponsCategoriesQuery');
    }

    /**
     * Filter the query by a related Coupons object
     *
     * @param   Coupons|PropelObjectCollection $coupons  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CouponsCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCoupons($coupons, $comparison = null)
    {
        if ($coupons instanceof Coupons) {
            return $this
                ->addUsingAlias(CouponsCategoriesPeer::ID, $coupons->getCategoryId(), $comparison);
        } elseif ($coupons instanceof PropelObjectCollection) {
            return $this
                ->useCouponsQuery()
                ->filterByPrimaryKeys($coupons->getPrimaryKeys())
                ->endUse();
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
     * @return CouponsCategoriesQuery The current query, for fluid interface
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
     * @param   CouponsCategories $couponsCategories Object to remove from the list of results
     *
     * @return CouponsCategoriesQuery The current query, for fluid interface
     */
    public function prune($couponsCategories = null)
    {
        if ($couponsCategories) {
            $this->addUsingAlias(CouponsCategoriesPeer::ID, $couponsCategories->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
