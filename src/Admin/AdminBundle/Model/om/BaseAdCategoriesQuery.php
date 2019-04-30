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
use Admin\AdminBundle\Model\AdCategoriesPeer;
use Admin\AdminBundle\Model\AdCategoriesQuery;
use Admin\AdminBundle\Model\AdCategoriesSubscribe;
use Admin\AdminBundle\Model\Advs;

/**
 * @method AdCategoriesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdCategoriesQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method AdCategoriesQuery orderBySort($order = Criteria::ASC) Order by the sort column
 * @method AdCategoriesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AdCategoriesQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method AdCategoriesQuery orderByPagetitle($order = Criteria::ASC) Order by the pagetitle column
 * @method AdCategoriesQuery orderByCatchPhrase($order = Criteria::ASC) Order by the catch_phrase column
 * @method AdCategoriesQuery orderByDirectTitle($order = Criteria::ASC) Order by the direct_title column
 * @method AdCategoriesQuery orderByText($order = Criteria::ASC) Order by the text column
 * @method AdCategoriesQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method AdCategoriesQuery orderByGenerator($order = Criteria::ASC) Order by the generator column
 * @method AdCategoriesQuery orderByNametitle($order = Criteria::ASC) Order by the nametitle column
 * @method AdCategoriesQuery orderByDesctitle($order = Criteria::ASC) Order by the desctitle column
 * @method AdCategoriesQuery orderByPricetitle($order = Criteria::ASC) Order by the pricetitle column
 * @method AdCategoriesQuery orderByUseDogovor($order = Criteria::ASC) Order by the use_dogovor column
 * @method AdCategoriesQuery orderByUseTorg($order = Criteria::ASC) Order by the use_torg column
 * @method AdCategoriesQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method AdCategoriesQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method AdCategoriesQuery orderByUsemap($order = Criteria::ASC) Order by the usemap column
 * @method AdCategoriesQuery orderByOnmain($order = Criteria::ASC) Order by the onmain column
 *
 * @method AdCategoriesQuery groupById() Group by the id column
 * @method AdCategoriesQuery groupByParentId() Group by the parent_id column
 * @method AdCategoriesQuery groupBySort() Group by the sort column
 * @method AdCategoriesQuery groupByName() Group by the name column
 * @method AdCategoriesQuery groupByAlias() Group by the alias column
 * @method AdCategoriesQuery groupByPagetitle() Group by the pagetitle column
 * @method AdCategoriesQuery groupByCatchPhrase() Group by the catch_phrase column
 * @method AdCategoriesQuery groupByDirectTitle() Group by the direct_title column
 * @method AdCategoriesQuery groupByText() Group by the text column
 * @method AdCategoriesQuery groupByIcon() Group by the icon column
 * @method AdCategoriesQuery groupByGenerator() Group by the generator column
 * @method AdCategoriesQuery groupByNametitle() Group by the nametitle column
 * @method AdCategoriesQuery groupByDesctitle() Group by the desctitle column
 * @method AdCategoriesQuery groupByPricetitle() Group by the pricetitle column
 * @method AdCategoriesQuery groupByUseDogovor() Group by the use_dogovor column
 * @method AdCategoriesQuery groupByUseTorg() Group by the use_torg column
 * @method AdCategoriesQuery groupByEnabled() Group by the enabled column
 * @method AdCategoriesQuery groupByDeleted() Group by the deleted column
 * @method AdCategoriesQuery groupByUsemap() Group by the usemap column
 * @method AdCategoriesQuery groupByOnmain() Group by the onmain column
 *
 * @method AdCategoriesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdCategoriesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdCategoriesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdCategoriesQuery leftJoinAdCategoriesRelatedByParentId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesRelatedByParentId relation
 * @method AdCategoriesQuery rightJoinAdCategoriesRelatedByParentId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesRelatedByParentId relation
 * @method AdCategoriesQuery innerJoinAdCategoriesRelatedByParentId($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesRelatedByParentId relation
 *
 * @method AdCategoriesQuery leftJoinAdChilds($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdChilds relation
 * @method AdCategoriesQuery rightJoinAdChilds($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdChilds relation
 * @method AdCategoriesQuery innerJoinAdChilds($relationAlias = null) Adds a INNER JOIN clause to the query using the AdChilds relation
 *
 * @method AdCategoriesQuery leftJoinAdCategoriesFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesFields relation
 * @method AdCategoriesQuery rightJoinAdCategoriesFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesFields relation
 * @method AdCategoriesQuery innerJoinAdCategoriesFields($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesFields relation
 *
 * @method AdCategoriesQuery leftJoinAdCategoriesSubscribe($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategoriesSubscribe relation
 * @method AdCategoriesQuery rightJoinAdCategoriesSubscribe($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategoriesSubscribe relation
 * @method AdCategoriesQuery innerJoinAdCategoriesSubscribe($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategoriesSubscribe relation
 *
 * @method AdCategoriesQuery leftJoinAdvs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Advs relation
 * @method AdCategoriesQuery rightJoinAdvs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Advs relation
 * @method AdCategoriesQuery innerJoinAdvs($relationAlias = null) Adds a INNER JOIN clause to the query using the Advs relation
 *
 * @method AdCategories findOne(PropelPDO $con = null) Return the first AdCategories matching the query
 * @method AdCategories findOneOrCreate(PropelPDO $con = null) Return the first AdCategories matching the query, or a new AdCategories object populated from the query conditions when no match is found
 *
 * @method AdCategories findOneByParentId(int $parent_id) Return the first AdCategories filtered by the parent_id column
 * @method AdCategories findOneBySort(int $sort) Return the first AdCategories filtered by the sort column
 * @method AdCategories findOneByName(string $name) Return the first AdCategories filtered by the name column
 * @method AdCategories findOneByAlias(string $alias) Return the first AdCategories filtered by the alias column
 * @method AdCategories findOneByPagetitle(string $pagetitle) Return the first AdCategories filtered by the pagetitle column
 * @method AdCategories findOneByCatchPhrase(string $catch_phrase) Return the first AdCategories filtered by the catch_phrase column
 * @method AdCategories findOneByDirectTitle(string $direct_title) Return the first AdCategories filtered by the direct_title column
 * @method AdCategories findOneByText(string $text) Return the first AdCategories filtered by the text column
 * @method AdCategories findOneByIcon(string $icon) Return the first AdCategories filtered by the icon column
 * @method AdCategories findOneByGenerator(string $generator) Return the first AdCategories filtered by the generator column
 * @method AdCategories findOneByNametitle(string $nametitle) Return the first AdCategories filtered by the nametitle column
 * @method AdCategories findOneByDesctitle(string $desctitle) Return the first AdCategories filtered by the desctitle column
 * @method AdCategories findOneByPricetitle(string $pricetitle) Return the first AdCategories filtered by the pricetitle column
 * @method AdCategories findOneByUseDogovor(boolean $use_dogovor) Return the first AdCategories filtered by the use_dogovor column
 * @method AdCategories findOneByUseTorg(boolean $use_torg) Return the first AdCategories filtered by the use_torg column
 * @method AdCategories findOneByEnabled(boolean $enabled) Return the first AdCategories filtered by the enabled column
 * @method AdCategories findOneByDeleted(boolean $deleted) Return the first AdCategories filtered by the deleted column
 * @method AdCategories findOneByUsemap(boolean $usemap) Return the first AdCategories filtered by the usemap column
 * @method AdCategories findOneByOnmain(boolean $onmain) Return the first AdCategories filtered by the onmain column
 *
 * @method array findById(int $id) Return AdCategories objects filtered by the id column
 * @method array findByParentId(int $parent_id) Return AdCategories objects filtered by the parent_id column
 * @method array findBySort(int $sort) Return AdCategories objects filtered by the sort column
 * @method array findByName(string $name) Return AdCategories objects filtered by the name column
 * @method array findByAlias(string $alias) Return AdCategories objects filtered by the alias column
 * @method array findByPagetitle(string $pagetitle) Return AdCategories objects filtered by the pagetitle column
 * @method array findByCatchPhrase(string $catch_phrase) Return AdCategories objects filtered by the catch_phrase column
 * @method array findByDirectTitle(string $direct_title) Return AdCategories objects filtered by the direct_title column
 * @method array findByText(string $text) Return AdCategories objects filtered by the text column
 * @method array findByIcon(string $icon) Return AdCategories objects filtered by the icon column
 * @method array findByGenerator(string $generator) Return AdCategories objects filtered by the generator column
 * @method array findByNametitle(string $nametitle) Return AdCategories objects filtered by the nametitle column
 * @method array findByDesctitle(string $desctitle) Return AdCategories objects filtered by the desctitle column
 * @method array findByPricetitle(string $pricetitle) Return AdCategories objects filtered by the pricetitle column
 * @method array findByUseDogovor(boolean $use_dogovor) Return AdCategories objects filtered by the use_dogovor column
 * @method array findByUseTorg(boolean $use_torg) Return AdCategories objects filtered by the use_torg column
 * @method array findByEnabled(boolean $enabled) Return AdCategories objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return AdCategories objects filtered by the deleted column
 * @method array findByUsemap(boolean $usemap) Return AdCategories objects filtered by the usemap column
 * @method array findByOnmain(boolean $onmain) Return AdCategories objects filtered by the onmain column
 */
abstract class BaseAdCategoriesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdCategoriesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\AdCategories';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdCategoriesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdCategoriesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdCategoriesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdCategoriesQuery) {
            return $criteria;
        }
        $query = new AdCategoriesQuery(null, null, $modelAlias);

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
     * @return   AdCategories|AdCategories[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdCategoriesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AdCategories A model object, or null if the key is not found
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
     * @return                 AdCategories A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `parent_id`, `sort`, `name`, `alias`, `pagetitle`, `catch_phrase`, `direct_title`, `text`, `icon`, `generator`, `nametitle`, `desctitle`, `pricetitle`, `use_dogovor`, `use_torg`, `enabled`, `deleted`, `usemap`, `onmain` FROM `ad_categories` WHERE `id` = :p0';
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
            $obj = new AdCategories();
            $obj->hydrate($row);
            AdCategoriesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AdCategories|AdCategories[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AdCategories[]|mixed the list of results, formatted by the current formatter
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdCategoriesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdCategoriesPeer::ID, $keys, Criteria::IN);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdCategoriesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdCategoriesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::ID, $id, $comparison);
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
     * @see       filterByAdCategoriesRelatedByParentId()
     *
     * @param     mixed $parentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (is_array($parentId)) {
            $useMinMax = false;
            if (isset($parentId['min'])) {
                $this->addUsingAlias(AdCategoriesPeer::PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentId['max'])) {
                $this->addUsingAlias(AdCategoriesPeer::PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::PARENT_ID, $parentId, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterBySort($sort = null, $comparison = null)
    {
        if (is_array($sort)) {
            $useMinMax = false;
            if (isset($sort['min'])) {
                $this->addUsingAlias(AdCategoriesPeer::SORT, $sort['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sort['max'])) {
                $this->addUsingAlias(AdCategoriesPeer::SORT, $sort['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::SORT, $sort, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesPeer::NAME, $name, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesPeer::ALIAS, $alias, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesPeer::PAGETITLE, $pagetitle, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesPeer::CATCH_PHRASE, $catchPhrase, $comparison);
    }

    /**
     * Filter the query on the direct_title column
     *
     * Example usage:
     * <code>
     * $query->filterByDirectTitle('fooValue');   // WHERE direct_title = 'fooValue'
     * $query->filterByDirectTitle('%fooValue%'); // WHERE direct_title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $directTitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByDirectTitle($directTitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($directTitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $directTitle)) {
                $directTitle = str_replace('*', '%', $directTitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::DIRECT_TITLE, $directTitle, $comparison);
    }

    /**
     * Filter the query on the text column
     *
     * Example usage:
     * <code>
     * $query->filterByText('fooValue');   // WHERE text = 'fooValue'
     * $query->filterByText('%fooValue%'); // WHERE text LIKE '%fooValue%'
     * </code>
     *
     * @param     string $text The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByText($text = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($text)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $text)) {
                $text = str_replace('*', '%', $text);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::TEXT, $text, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdCategoriesPeer::ICON, $icon, $comparison);
    }

    /**
     * Filter the query on the generator column
     *
     * Example usage:
     * <code>
     * $query->filterByGenerator('fooValue');   // WHERE generator = 'fooValue'
     * $query->filterByGenerator('%fooValue%'); // WHERE generator LIKE '%fooValue%'
     * </code>
     *
     * @param     string $generator The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByGenerator($generator = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($generator)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $generator)) {
                $generator = str_replace('*', '%', $generator);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::GENERATOR, $generator, $comparison);
    }

    /**
     * Filter the query on the nametitle column
     *
     * Example usage:
     * <code>
     * $query->filterByNametitle('fooValue');   // WHERE nametitle = 'fooValue'
     * $query->filterByNametitle('%fooValue%'); // WHERE nametitle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nametitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByNametitle($nametitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nametitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $nametitle)) {
                $nametitle = str_replace('*', '%', $nametitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::NAMETITLE, $nametitle, $comparison);
    }

    /**
     * Filter the query on the desctitle column
     *
     * Example usage:
     * <code>
     * $query->filterByDesctitle('fooValue');   // WHERE desctitle = 'fooValue'
     * $query->filterByDesctitle('%fooValue%'); // WHERE desctitle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $desctitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByDesctitle($desctitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($desctitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $desctitle)) {
                $desctitle = str_replace('*', '%', $desctitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::DESCTITLE, $desctitle, $comparison);
    }

    /**
     * Filter the query on the pricetitle column
     *
     * Example usage:
     * <code>
     * $query->filterByPricetitle('fooValue');   // WHERE pricetitle = 'fooValue'
     * $query->filterByPricetitle('%fooValue%'); // WHERE pricetitle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pricetitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByPricetitle($pricetitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pricetitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pricetitle)) {
                $pricetitle = str_replace('*', '%', $pricetitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdCategoriesPeer::PRICETITLE, $pricetitle, $comparison);
    }

    /**
     * Filter the query on the use_dogovor column
     *
     * Example usage:
     * <code>
     * $query->filterByUseDogovor(true); // WHERE use_dogovor = true
     * $query->filterByUseDogovor('yes'); // WHERE use_dogovor = true
     * </code>
     *
     * @param     boolean|string $useDogovor The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByUseDogovor($useDogovor = null, $comparison = null)
    {
        if (is_string($useDogovor)) {
            $useDogovor = in_array(strtolower($useDogovor), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesPeer::USE_DOGOVOR, $useDogovor, $comparison);
    }

    /**
     * Filter the query on the use_torg column
     *
     * Example usage:
     * <code>
     * $query->filterByUseTorg(true); // WHERE use_torg = true
     * $query->filterByUseTorg('yes'); // WHERE use_torg = true
     * </code>
     *
     * @param     boolean|string $useTorg The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByUseTorg($useTorg = null, $comparison = null)
    {
        if (is_string($useTorg)) {
            $useTorg = in_array(strtolower($useTorg), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesPeer::USE_TORG, $useTorg, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesPeer::ENABLED, $enabled, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesPeer::DELETED, $deleted, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByUsemap($usemap = null, $comparison = null)
    {
        if (is_string($usemap)) {
            $usemap = in_array(strtolower($usemap), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesPeer::USEMAP, $usemap, $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function filterByOnmain($onmain = null, $comparison = null)
    {
        if (is_string($onmain)) {
            $onmain = in_array(strtolower($onmain), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdCategoriesPeer::ONMAIN, $onmain, $comparison);
    }

    /**
     * Filter the query by a related AdCategories object
     *
     * @param   AdCategories|PropelObjectCollection $adCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesRelatedByParentId($adCategories, $comparison = null)
    {
        if ($adCategories instanceof AdCategories) {
            return $this
                ->addUsingAlias(AdCategoriesPeer::PARENT_ID, $adCategories->getId(), $comparison);
        } elseif ($adCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdCategoriesPeer::PARENT_ID, $adCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdCategoriesRelatedByParentId() only accepts arguments of type AdCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategoriesRelatedByParentId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function joinAdCategoriesRelatedByParentId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategoriesRelatedByParentId');

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
            $this->addJoinObject($join, 'AdCategoriesRelatedByParentId');
        }

        return $this;
    }

    /**
     * Use the AdCategoriesRelatedByParentId relation AdCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesRelatedByParentIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdCategoriesRelatedByParentId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategoriesRelatedByParentId', '\Admin\AdminBundle\Model\AdCategoriesQuery');
    }

    /**
     * Filter the query by a related AdCategories object
     *
     * @param   AdCategories|PropelObjectCollection $adCategories  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdChilds($adCategories, $comparison = null)
    {
        if ($adCategories instanceof AdCategories) {
            return $this
                ->addUsingAlias(AdCategoriesPeer::ID, $adCategories->getParentId(), $comparison);
        } elseif ($adCategories instanceof PropelObjectCollection) {
            return $this
                ->useAdChildsQuery()
                ->filterByPrimaryKeys($adCategories->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdChilds() only accepts arguments of type AdCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdChilds relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function joinAdChilds($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdChilds');

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
            $this->addJoinObject($join, 'AdChilds');
        }

        return $this;
    }

    /**
     * Use the AdChilds relation AdCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useAdChildsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdChilds($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdChilds', '\Admin\AdminBundle\Model\AdCategoriesQuery');
    }

    /**
     * Filter the query by a related AdCategoriesFields object
     *
     * @param   AdCategoriesFields|PropelObjectCollection $adCategoriesFields  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesFields($adCategoriesFields, $comparison = null)
    {
        if ($adCategoriesFields instanceof AdCategoriesFields) {
            return $this
                ->addUsingAlias(AdCategoriesPeer::ID, $adCategoriesFields->getCategoryId(), $comparison);
        } elseif ($adCategoriesFields instanceof PropelObjectCollection) {
            return $this
                ->useAdCategoriesFieldsQuery()
                ->filterByPrimaryKeys($adCategoriesFields->getPrimaryKeys())
                ->endUse();
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
     * @return AdCategoriesQuery The current query, for fluid interface
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
     * Filter the query by a related AdCategoriesSubscribe object
     *
     * @param   AdCategoriesSubscribe|PropelObjectCollection $adCategoriesSubscribe  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategoriesSubscribe($adCategoriesSubscribe, $comparison = null)
    {
        if ($adCategoriesSubscribe instanceof AdCategoriesSubscribe) {
            return $this
                ->addUsingAlias(AdCategoriesPeer::ID, $adCategoriesSubscribe->getCategoryId(), $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function joinAdCategoriesSubscribe($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAdCategoriesSubscribeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return                 AdCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvs($advs, $comparison = null)
    {
        if ($advs instanceof Advs) {
            return $this
                ->addUsingAlias(AdCategoriesPeer::ID, $advs->getCategoryId(), $comparison);
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
     * @return AdCategoriesQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   AdCategories $adCategories Object to remove from the list of results
     *
     * @return AdCategoriesQuery The current query, for fluid interface
     */
    public function prune($adCategories = null)
    {
        if ($adCategories) {
            $this->addUsingAlias(AdCategoriesPeer::ID, $adCategories->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
