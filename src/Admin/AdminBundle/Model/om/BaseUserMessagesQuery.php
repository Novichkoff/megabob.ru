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
use Admin\AdminBundle\Model\UserMessages;
use Admin\AdminBundle\Model\UserMessagesPeer;
use Admin\AdminBundle\Model\UserMessagesQuery;
use FOS\UserBundle\Propel\User;

/**
 * @method UserMessagesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method UserMessagesQuery orderByFosUserId($order = Criteria::ASC) Order by the fos_user_id column
 * @method UserMessagesQuery orderBySenderName($order = Criteria::ASC) Order by the sender_name column
 * @method UserMessagesQuery orderBySenderEmail($order = Criteria::ASC) Order by the sender_email column
 * @method UserMessagesQuery orderBySenderPhone($order = Criteria::ASC) Order by the sender_phone column
 * @method UserMessagesQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method UserMessagesQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method UserMessagesQuery orderByViewed($order = Criteria::ASC) Order by the viewed column
 *
 * @method UserMessagesQuery groupById() Group by the id column
 * @method UserMessagesQuery groupByFosUserId() Group by the fos_user_id column
 * @method UserMessagesQuery groupBySenderName() Group by the sender_name column
 * @method UserMessagesQuery groupBySenderEmail() Group by the sender_email column
 * @method UserMessagesQuery groupBySenderPhone() Group by the sender_phone column
 * @method UserMessagesQuery groupByDate() Group by the date column
 * @method UserMessagesQuery groupByMessage() Group by the message column
 * @method UserMessagesQuery groupByViewed() Group by the viewed column
 *
 * @method UserMessagesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method UserMessagesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method UserMessagesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method UserMessagesQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method UserMessagesQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method UserMessagesQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method UserMessages findOne(PropelPDO $con = null) Return the first UserMessages matching the query
 * @method UserMessages findOneOrCreate(PropelPDO $con = null) Return the first UserMessages matching the query, or a new UserMessages object populated from the query conditions when no match is found
 *
 * @method UserMessages findOneByFosUserId(int $fos_user_id) Return the first UserMessages filtered by the fos_user_id column
 * @method UserMessages findOneBySenderName(string $sender_name) Return the first UserMessages filtered by the sender_name column
 * @method UserMessages findOneBySenderEmail(string $sender_email) Return the first UserMessages filtered by the sender_email column
 * @method UserMessages findOneBySenderPhone(string $sender_phone) Return the first UserMessages filtered by the sender_phone column
 * @method UserMessages findOneByDate(string $date) Return the first UserMessages filtered by the date column
 * @method UserMessages findOneByMessage(string $message) Return the first UserMessages filtered by the message column
 * @method UserMessages findOneByViewed(boolean $viewed) Return the first UserMessages filtered by the viewed column
 *
 * @method array findById(int $id) Return UserMessages objects filtered by the id column
 * @method array findByFosUserId(int $fos_user_id) Return UserMessages objects filtered by the fos_user_id column
 * @method array findBySenderName(string $sender_name) Return UserMessages objects filtered by the sender_name column
 * @method array findBySenderEmail(string $sender_email) Return UserMessages objects filtered by the sender_email column
 * @method array findBySenderPhone(string $sender_phone) Return UserMessages objects filtered by the sender_phone column
 * @method array findByDate(string $date) Return UserMessages objects filtered by the date column
 * @method array findByMessage(string $message) Return UserMessages objects filtered by the message column
 * @method array findByViewed(boolean $viewed) Return UserMessages objects filtered by the viewed column
 */
abstract class BaseUserMessagesQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseUserMessagesQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\UserMessages';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new UserMessagesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   UserMessagesQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return UserMessagesQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof UserMessagesQuery) {
            return $criteria;
        }
        $query = new UserMessagesQuery(null, null, $modelAlias);

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
     * @return   UserMessages|UserMessages[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserMessagesPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(UserMessagesPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 UserMessages A model object, or null if the key is not found
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
     * @return                 UserMessages A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `fos_user_id`, `sender_name`, `sender_email`, `sender_phone`, `date`, `message`, `viewed` FROM `user_messages` WHERE `id` = :p0';
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
            $obj = new UserMessages();
            $obj->hydrate($row);
            UserMessagesPeer::addInstanceToPool($obj, (string) $key);
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
     * @return UserMessages|UserMessages[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|UserMessages[]|mixed the list of results, formatted by the current formatter
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
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserMessagesPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserMessagesPeer::ID, $keys, Criteria::IN);
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
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserMessagesPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserMessagesPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::ID, $id, $comparison);
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
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterByFosUserId($fosUserId = null, $comparison = null)
    {
        if (is_array($fosUserId)) {
            $useMinMax = false;
            if (isset($fosUserId['min'])) {
                $this->addUsingAlias(UserMessagesPeer::FOS_USER_ID, $fosUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fosUserId['max'])) {
                $this->addUsingAlias(UserMessagesPeer::FOS_USER_ID, $fosUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::FOS_USER_ID, $fosUserId, $comparison);
    }

    /**
     * Filter the query on the sender_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderName('fooValue');   // WHERE sender_name = 'fooValue'
     * $query->filterBySenderName('%fooValue%'); // WHERE sender_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senderName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterBySenderName($senderName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senderName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $senderName)) {
                $senderName = str_replace('*', '%', $senderName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::SENDER_NAME, $senderName, $comparison);
    }

    /**
     * Filter the query on the sender_email column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderEmail('fooValue');   // WHERE sender_email = 'fooValue'
     * $query->filterBySenderEmail('%fooValue%'); // WHERE sender_email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senderEmail The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterBySenderEmail($senderEmail = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senderEmail)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $senderEmail)) {
                $senderEmail = str_replace('*', '%', $senderEmail);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::SENDER_EMAIL, $senderEmail, $comparison);
    }

    /**
     * Filter the query on the sender_phone column
     *
     * Example usage:
     * <code>
     * $query->filterBySenderPhone('fooValue');   // WHERE sender_phone = 'fooValue'
     * $query->filterBySenderPhone('%fooValue%'); // WHERE sender_phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $senderPhone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterBySenderPhone($senderPhone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($senderPhone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $senderPhone)) {
                $senderPhone = str_replace('*', '%', $senderPhone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::SENDER_PHONE, $senderPhone, $comparison);
    }

    /**
     * Filter the query on the date column
     *
     * Example usage:
     * <code>
     * $query->filterByDate('2011-03-14'); // WHERE date = '2011-03-14'
     * $query->filterByDate('now'); // WHERE date = '2011-03-14'
     * $query->filterByDate(array('max' => 'yesterday')); // WHERE date < '2011-03-13'
     * </code>
     *
     * @param     mixed $date The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(UserMessagesPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(UserMessagesPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%'); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $message)) {
                $message = str_replace('*', '%', $message);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserMessagesPeer::MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the viewed column
     *
     * Example usage:
     * <code>
     * $query->filterByViewed(true); // WHERE viewed = true
     * $query->filterByViewed('yes'); // WHERE viewed = true
     * </code>
     *
     * @param     boolean|string $viewed The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function filterByViewed($viewed = null, $comparison = null)
    {
        if (is_string($viewed)) {
            $viewed = in_array(strtolower($viewed), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UserMessagesPeer::VIEWED, $viewed, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 UserMessagesQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(UserMessagesPeer::FOS_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserMessagesPeer::FOS_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return UserMessagesQuery The current query, for fluid interface
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
     * @param   UserMessages $userMessages Object to remove from the list of results
     *
     * @return UserMessagesQuery The current query, for fluid interface
     */
    public function prune($userMessages = null)
    {
        if ($userMessages) {
            $this->addUsingAlias(UserMessagesPeer::ID, $userMessages->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
