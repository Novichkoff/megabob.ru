<?php

namespace Admin\AdminBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Admin\AdminBundle\Model\Settings;
use Admin\AdminBundle\Model\SettingsPeer;
use Admin\AdminBundle\Model\SettingsQuery;

/**
 * @method SettingsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method SettingsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method SettingsQuery orderByUrl($order = Criteria::ASC) Order by the url column
 * @method SettingsQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method SettingsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method SettingsQuery orderByKeywords($order = Criteria::ASC) Order by the keywords column
 * @method SettingsQuery orderByLogo($order = Criteria::ASC) Order by the logo column
 * @method SettingsQuery orderByIcon($order = Criteria::ASC) Order by the icon column
 * @method SettingsQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method SettingsQuery orderByRobots($order = Criteria::ASC) Order by the robots column
 * @method SettingsQuery orderByCounters($order = Criteria::ASC) Order by the counters column
 * @method SettingsQuery orderByFb($order = Criteria::ASC) Order by the fb column
 * @method SettingsQuery orderByVk($order = Criteria::ASC) Order by the vk column
 * @method SettingsQuery orderByTwitter($order = Criteria::ASC) Order by the twitter column
 *
 * @method SettingsQuery groupById() Group by the id column
 * @method SettingsQuery groupByName() Group by the name column
 * @method SettingsQuery groupByUrl() Group by the url column
 * @method SettingsQuery groupByTitle() Group by the title column
 * @method SettingsQuery groupByDescription() Group by the description column
 * @method SettingsQuery groupByKeywords() Group by the keywords column
 * @method SettingsQuery groupByLogo() Group by the logo column
 * @method SettingsQuery groupByIcon() Group by the icon column
 * @method SettingsQuery groupByContent() Group by the content column
 * @method SettingsQuery groupByRobots() Group by the robots column
 * @method SettingsQuery groupByCounters() Group by the counters column
 * @method SettingsQuery groupByFb() Group by the fb column
 * @method SettingsQuery groupByVk() Group by the vk column
 * @method SettingsQuery groupByTwitter() Group by the twitter column
 *
 * @method SettingsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SettingsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SettingsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method Settings findOne(PropelPDO $con = null) Return the first Settings matching the query
 * @method Settings findOneOrCreate(PropelPDO $con = null) Return the first Settings matching the query, or a new Settings object populated from the query conditions when no match is found
 *
 * @method Settings findOneByName(string $name) Return the first Settings filtered by the name column
 * @method Settings findOneByUrl(string $url) Return the first Settings filtered by the url column
 * @method Settings findOneByTitle(string $title) Return the first Settings filtered by the title column
 * @method Settings findOneByDescription(string $description) Return the first Settings filtered by the description column
 * @method Settings findOneByKeywords(string $keywords) Return the first Settings filtered by the keywords column
 * @method Settings findOneByLogo(string $logo) Return the first Settings filtered by the logo column
 * @method Settings findOneByIcon(string $icon) Return the first Settings filtered by the icon column
 * @method Settings findOneByContent(string $content) Return the first Settings filtered by the content column
 * @method Settings findOneByRobots(string $robots) Return the first Settings filtered by the robots column
 * @method Settings findOneByCounters(string $counters) Return the first Settings filtered by the counters column
 * @method Settings findOneByFb(string $fb) Return the first Settings filtered by the fb column
 * @method Settings findOneByVk(string $vk) Return the first Settings filtered by the vk column
 * @method Settings findOneByTwitter(string $twitter) Return the first Settings filtered by the twitter column
 *
 * @method array findById(int $id) Return Settings objects filtered by the id column
 * @method array findByName(string $name) Return Settings objects filtered by the name column
 * @method array findByUrl(string $url) Return Settings objects filtered by the url column
 * @method array findByTitle(string $title) Return Settings objects filtered by the title column
 * @method array findByDescription(string $description) Return Settings objects filtered by the description column
 * @method array findByKeywords(string $keywords) Return Settings objects filtered by the keywords column
 * @method array findByLogo(string $logo) Return Settings objects filtered by the logo column
 * @method array findByIcon(string $icon) Return Settings objects filtered by the icon column
 * @method array findByContent(string $content) Return Settings objects filtered by the content column
 * @method array findByRobots(string $robots) Return Settings objects filtered by the robots column
 * @method array findByCounters(string $counters) Return Settings objects filtered by the counters column
 * @method array findByFb(string $fb) Return Settings objects filtered by the fb column
 * @method array findByVk(string $vk) Return Settings objects filtered by the vk column
 * @method array findByTwitter(string $twitter) Return Settings objects filtered by the twitter column
 */
abstract class BaseSettingsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSettingsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Settings';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SettingsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SettingsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SettingsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SettingsQuery) {
            return $criteria;
        }
        $query = new SettingsQuery(null, null, $modelAlias);

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
     * @return   Settings|Settings[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SettingsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SettingsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Settings A model object, or null if the key is not found
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
     * @return                 Settings A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `url`, `title`, `description`, `keywords`, `logo`, `icon`, `content`, `robots`, `counters`, `fb`, `vk`, `twitter` FROM `settings` WHERE `id` = :p0';
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
            $obj = new Settings();
            $obj->hydrate($row);
            SettingsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Settings|Settings[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Settings[]|mixed the list of results, formatted by the current formatter
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
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SettingsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SettingsPeer::ID, $keys, Criteria::IN);
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
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SettingsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SettingsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SettingsPeer::ID, $id, $comparison);
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
     * @return SettingsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SettingsPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the url column
     *
     * Example usage:
     * <code>
     * $query->filterByUrl('fooValue');   // WHERE url = 'fooValue'
     * $query->filterByUrl('%fooValue%'); // WHERE url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $url The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByUrl($url = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($url)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $url)) {
                $url = str_replace('*', '%', $url);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::URL, $url, $comparison);
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
     * @return SettingsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SettingsPeer::TITLE, $title, $comparison);
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
     * @return SettingsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SettingsPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the keywords column
     *
     * Example usage:
     * <code>
     * $query->filterByKeywords('fooValue');   // WHERE keywords = 'fooValue'
     * $query->filterByKeywords('%fooValue%'); // WHERE keywords LIKE '%fooValue%'
     * </code>
     *
     * @param     string $keywords The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByKeywords($keywords = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($keywords)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $keywords)) {
                $keywords = str_replace('*', '%', $keywords);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::KEYWORDS, $keywords, $comparison);
    }

    /**
     * Filter the query on the logo column
     *
     * Example usage:
     * <code>
     * $query->filterByLogo('fooValue');   // WHERE logo = 'fooValue'
     * $query->filterByLogo('%fooValue%'); // WHERE logo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $logo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByLogo($logo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($logo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $logo)) {
                $logo = str_replace('*', '%', $logo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::LOGO, $logo, $comparison);
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
     * @return SettingsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SettingsPeer::ICON, $icon, $comparison);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $content)) {
                $content = str_replace('*', '%', $content);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::CONTENT, $content, $comparison);
    }

    /**
     * Filter the query on the robots column
     *
     * Example usage:
     * <code>
     * $query->filterByRobots('fooValue');   // WHERE robots = 'fooValue'
     * $query->filterByRobots('%fooValue%'); // WHERE robots LIKE '%fooValue%'
     * </code>
     *
     * @param     string $robots The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByRobots($robots = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($robots)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $robots)) {
                $robots = str_replace('*', '%', $robots);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::ROBOTS, $robots, $comparison);
    }

    /**
     * Filter the query on the counters column
     *
     * Example usage:
     * <code>
     * $query->filterByCounters('fooValue');   // WHERE counters = 'fooValue'
     * $query->filterByCounters('%fooValue%'); // WHERE counters LIKE '%fooValue%'
     * </code>
     *
     * @param     string $counters The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByCounters($counters = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($counters)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $counters)) {
                $counters = str_replace('*', '%', $counters);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::COUNTERS, $counters, $comparison);
    }

    /**
     * Filter the query on the fb column
     *
     * Example usage:
     * <code>
     * $query->filterByFb('fooValue');   // WHERE fb = 'fooValue'
     * $query->filterByFb('%fooValue%'); // WHERE fb LIKE '%fooValue%'
     * </code>
     *
     * @param     string $fb The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByFb($fb = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($fb)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $fb)) {
                $fb = str_replace('*', '%', $fb);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::FB, $fb, $comparison);
    }

    /**
     * Filter the query on the vk column
     *
     * Example usage:
     * <code>
     * $query->filterByVk('fooValue');   // WHERE vk = 'fooValue'
     * $query->filterByVk('%fooValue%'); // WHERE vk LIKE '%fooValue%'
     * </code>
     *
     * @param     string $vk The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByVk($vk = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($vk)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $vk)) {
                $vk = str_replace('*', '%', $vk);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::VK, $vk, $comparison);
    }

    /**
     * Filter the query on the twitter column
     *
     * Example usage:
     * <code>
     * $query->filterByTwitter('fooValue');   // WHERE twitter = 'fooValue'
     * $query->filterByTwitter('%fooValue%'); // WHERE twitter LIKE '%fooValue%'
     * </code>
     *
     * @param     string $twitter The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function filterByTwitter($twitter = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($twitter)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $twitter)) {
                $twitter = str_replace('*', '%', $twitter);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SettingsPeer::TWITTER, $twitter, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   Settings $settings Object to remove from the list of results
     *
     * @return SettingsQuery The current query, for fluid interface
     */
    public function prune($settings = null)
    {
        if ($settings) {
            $this->addUsingAlias(SettingsPeer::ID, $settings->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
