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
use Admin\AdminBundle\Model\JobCategories;
use Admin\AdminBundle\Model\JobCategoriesFields;
use Admin\AdminBundle\Model\JobCategoriesPeer;
use Admin\AdminBundle\Model\JobCategoriesQuery;
use Admin\AdminBundle\Model\Jobs;

/**
 * @method JobCategoriesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method JobCategoriesQuery orderByParentId($order = Criteria::ASC) Order by the parent_id column
 * @method JobCategoriesQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method JobCategoriesQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method JobCategoriesQuery orderByPagetitle($order = Criteria::ASC) Order by the pagetitle column
 * @method JobCategoriesQuery orderByCatchPhrase($order = Criteria::ASC) Order by the catch_phrase column
 * @method JobCategoriesQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method JobCategoriesQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method JobCategoriesQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method JobCategoriesQuery orderByUsemap($order = Criteria::ASC) Order by the usemap column
 * @method JobCategoriesQuery orderByOnmain($order = Criteria::ASC) Order by the onmain column
 *
 * @method JobCategoriesQuery groupById() Group by the id column
 * @method JobCategoriesQuery groupByParentId() Group by the parent_id column
 * @method JobCategoriesQuery groupByName() Group by the name column
 * @method JobCategoriesQuery groupByAlias() Group by the alias column
 * @method JobCategoriesQuery groupByPagetitle() Group by the pagetitle column
 * @method JobCategoriesQuery groupByCatchPhrase() Group by the catch_phrase column
 * @method JobCategoriesQuery groupByIcon() Group by the icon column
 * @method JobCategoriesQuery groupByEnabled() Group by the enabled column
 * @method JobCategoriesQuery groupByDeleted() Group by the deleted column
 * @method JobCategoriesQuery groupByUsemap() Group by the usemap column
 * @method JobCategoriesQuery groupByOnmain() Group by the onmain column
 *
 * @method JobCategoriesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method JobCategoriesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method JobCategoriesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method JobCategoriesQuery leftJoinJobCategoriesRelatedByParentId($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesRelatedByParentId relation
 * @method JobCategoriesQuery rightJoinJobCategoriesRelatedByParentId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesRelatedByParentId relation
 * @method JobCategoriesQuery innerJoinJobCategoriesRelatedByParentId($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesRelatedByParentId relation
 *
 * @method JobCategoriesQuery leftJoinJobChilds($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobChilds relation
 * @method JobCategoriesQuery rightJoinJobChilds($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobChilds relation
 * @method JobCategoriesQuery innerJoinJobChilds($relationAlias = null) Adds a INNER JOIN clause to the query using the JobChilds relation
 *
 * @method JobCategoriesQuery leftJoinJobCategoriesFields($relationAlias = null) Adds a LEFT JOIN clause to the query using the JobCategoriesFields relation
 * @method JobCategoriesQuery rightJoinJobCategoriesFields($relationAlias = null) Adds a RIGHT JOIN clause to the query using the JobCategoriesFields relation
 * @method JobCategoriesQuery innerJoinJobCategoriesFields($relationAlias = null) Adds a INNER JOIN clause to the query using the JobCategoriesFields relation
 *
 * @method JobCategoriesQuery leftJoinJobs($relationAlias = null) Adds a LEFT JOIN clause to the query using the Jobs relation
 * @method JobCategoriesQuery rightJoinJobs($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Jobs relation
 * @method JobCategoriesQuery innerJoinJobs($relationAlias = null) Adds a INNER JOIN clause to the query using the Jobs relation
 *
 * @method JobCategories findOne(PropelPDO $con = null) Return the first JobCategories matching the query
 * @method JobCategories findOneOrCreate(PropelPDO $con = null) Return the first JobCategories matching the query, or a new JobCategories object populated from the query conditions when no match is found
 *
 * @method JobCategories findOneByParentId(int $parent_id) Return the first JobCategories filtered by the parent_id column
 * @method JobCategories findOneByName(string $name) Return the first JobCategories filtered by the name column
 * @method JobCategories findOneByAlias(string $alias) Return the first JobCategories filtered by the alias column
 * @method JobCategories findOneByPagetitle(string $pagetitle) Return the first JobCategories filtered by the pagetitle column
 * @method JobCategories findOneByCatchPhrase(string $catch_phrase) Return the first JobCategories filtered by the catch_phrase column
 * @method JobCategories findOneByIcon(string $icon) Return the first JobCategories filtered by the icon column
 * @method JobCategories findOneByEnabled(boolean $enabled) Return the first JobCategories filtered by the enabled column
 * @method JobCategories findOneByDeleted(boolean $deleted) Return the first JobCategories filtered by the deleted column
 * @method JobCategories findOneByUsemap(boolean $usemap) Return the first JobCategories filtered by the usemap column
 * @method JobCategories findOneByOnmain(boolean $onmain) Return the first JobCategories filtered by the onmain column
 *
 * @method array findById(int $id) Return JobCategories objects filtered by the id column
 * @method array findByParentId(int $parent_id) Return JobCategories objects filtered by the parent_id column
 * @method array findByName(string $name) Return JobCategories objects filtered by the name column
 * @method array findByAlias(string $alias) Return JobCategories objects filtered by the alias column
 * @method array findByPagetitle(string $pagetitle) Return JobCategories objects filtered by the pagetitle column
 * @method array findByCatchPhrase(string $catch_phrase) Return JobCategories objects filtered by the catch_phrase column
 * @method array findByIcon(string $icon) Return JobCategories objects filtered by the icon column
 * @method array findByEnabled(boolean $enabled) Return JobCategories objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return JobCategories objects filtered by the deleted column
 * @method array findByUsemap(boolean $usemap) Return JobCategories objects filtered by the usemap column
 * @method array findByOnmain(boolean $onmain) Return JobCategories objects filtered by the onmain column
 */
abstract class BaseJobCategoriesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseJobCategoriesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\JobCategories';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new JobCategoriesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   JobCategoriesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return JobCategoriesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof JobCategoriesQuery) {
            return $criteria;
        }
        $query = new JobCategoriesQuery(null, null, $modelAlias);

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
     * @return   JobCategories|JobCategories[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = JobCategoriesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(JobCategoriesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 JobCategories A model object, or null if the key is not found
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
     * @return                 JobCategories A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `parent_id`, `name`, `alias`, `pagetitle`, `catch_phrase`, `icon`, `enabled`, `deleted`, `usemap`, `onmain` FROM `job_categories` WHERE `id` = :p0';
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
            $obj = new JobCategories();
            $obj->hydrate($row);
            JobCategoriesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return JobCategories|JobCategories[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|JobCategories[]|mixed the list of results, formatted by the current formatter
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
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(JobCategoriesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(JobCategoriesPeer::ID, $keys, Criteria::IN);
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
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(JobCategoriesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(JobCategoriesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesPeer::ID, $id, $comparison);
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
     * @see       filterByJobCategoriesRelatedByParentId()
     *
     * @param     mixed $parentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByParentId($parentId = null, $comparison = null)
    {
        if (is_array($parentId)) {
            $useMinMax = false;
            if (isset($parentId['min'])) {
                $this->addUsingAlias(JobCategoriesPeer::PARENT_ID, $parentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentId['max'])) {
                $this->addUsingAlias(JobCategoriesPeer::PARENT_ID, $parentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(JobCategoriesPeer::PARENT_ID, $parentId, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesPeer::NAME, $name, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesPeer::ALIAS, $alias, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesPeer::PAGETITLE, $pagetitle, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesPeer::CATCH_PHRASE, $catchPhrase, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
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

        return $this->addUsingAlias(JobCategoriesPeer::ICON, $icon, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesPeer::ENABLED, $enabled, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesPeer::DELETED, $deleted, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByUsemap($usemap = null, $comparison = null)
    {
        if (is_string($usemap)) {
            $usemap = in_array(strtolower($usemap), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesPeer::USEMAP, $usemap, $comparison);
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
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function filterByOnmain($onmain = null, $comparison = null)
    {
        if (is_string($onmain)) {
            $onmain = in_array(strtolower($onmain), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(JobCategoriesPeer::ONMAIN, $onmain, $comparison);
    }

    /**
     * Filter the query by a related JobCategories object
     *
     * @param   JobCategories|PropelObjectCollection $jobCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesRelatedByParentId($jobCategories, $comparison = null)
    {
        if ($jobCategories instanceof JobCategories) {
            return $this
                ->addUsingAlias(JobCategoriesPeer::PARENT_ID, $jobCategories->getId(), $comparison);
        } elseif ($jobCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(JobCategoriesPeer::PARENT_ID, $jobCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByJobCategoriesRelatedByParentId() only accepts arguments of type JobCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobCategoriesRelatedByParentId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function joinJobCategoriesRelatedByParentId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobCategoriesRelatedByParentId');

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
            $this->addJoinObject($join, 'JobCategoriesRelatedByParentId');
        }

        return $this;
    }

    /**
     * Use the JobCategoriesRelatedByParentId relation JobCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useJobCategoriesRelatedByParentIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobCategoriesRelatedByParentId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategoriesRelatedByParentId', '\Admin\AdminBundle\Model\JobCategoriesQuery');
    }

    /**
     * Filter the query by a related JobCategories object
     *
     * @param   JobCategories|PropelObjectCollection $jobCategories  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobChilds($jobCategories, $comparison = null)
    {
        if ($jobCategories instanceof JobCategories) {
            return $this
                ->addUsingAlias(JobCategoriesPeer::ID, $jobCategories->getParentId(), $comparison);
        } elseif ($jobCategories instanceof PropelObjectCollection) {
            return $this
                ->useJobChildsQuery()
                ->filterByPrimaryKeys($jobCategories->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobChilds() only accepts arguments of type JobCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobChilds relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function joinJobChilds($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobChilds');

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
            $this->addJoinObject($join, 'JobChilds');
        }

        return $this;
    }

    /**
     * Use the JobChilds relation JobCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useJobChildsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobChilds($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobChilds', '\Admin\AdminBundle\Model\JobCategoriesQuery');
    }

    /**
     * Filter the query by a related JobCategoriesFields object
     *
     * @param   JobCategoriesFields|PropelObjectCollection $jobCategoriesFields  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobCategoriesFields($jobCategoriesFields, $comparison = null)
    {
        if ($jobCategoriesFields instanceof JobCategoriesFields) {
            return $this
                ->addUsingAlias(JobCategoriesPeer::ID, $jobCategoriesFields->getCategoryId(), $comparison);
        } elseif ($jobCategoriesFields instanceof PropelObjectCollection) {
            return $this
                ->useJobCategoriesFieldsQuery()
                ->filterByPrimaryKeys($jobCategoriesFields->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobCategoriesFields() only accepts arguments of type JobCategoriesFields or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the JobCategoriesFields relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function joinJobCategoriesFields($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('JobCategoriesFields');

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
            $this->addJoinObject($join, 'JobCategoriesFields');
        }

        return $this;
    }

    /**
     * Use the JobCategoriesFields relation JobCategoriesFields object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobCategoriesFieldsQuery A secondary query class using the current class as primary query
     */
    public function useJobCategoriesFieldsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinJobCategoriesFields($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'JobCategoriesFields', '\Admin\AdminBundle\Model\JobCategoriesFieldsQuery');
    }

    /**
     * Filter the query by a related Jobs object
     *
     * @param   Jobs|PropelObjectCollection $jobs  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 JobCategoriesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByJobs($jobs, $comparison = null)
    {
        if ($jobs instanceof Jobs) {
            return $this
                ->addUsingAlias(JobCategoriesPeer::ID, $jobs->getCategoryId(), $comparison);
        } elseif ($jobs instanceof PropelObjectCollection) {
            return $this
                ->useJobsQuery()
                ->filterByPrimaryKeys($jobs->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByJobs() only accepts arguments of type Jobs or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Jobs relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function joinJobs($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Jobs');

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
            $this->addJoinObject($join, 'Jobs');
        }

        return $this;
    }

    /**
     * Use the Jobs relation Jobs object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\JobsQuery A secondary query class using the current class as primary query
     */
    public function useJobsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinJobs($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Jobs', '\Admin\AdminBundle\Model\JobsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   JobCategories $jobCategories Object to remove from the list of results
     *
     * @return JobCategoriesQuery The current query, for fluid interface
     */
    public function prune($jobCategories = null)
    {
        if ($jobCategories) {
            $this->addUsingAlias(JobCategoriesPeer::ID, $jobCategories->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
