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
use Admin\AdminBundle\Model\Transactions;
use Admin\AdminBundle\Model\TransactionsPeer;
use Admin\AdminBundle\Model\TransactionsQuery;
use FOS\UserBundle\Propel\User;

/**
 * @method TransactionsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method TransactionsQuery orderByFosUserId($order = Criteria::ASC) Order by the fos_user_id column
 * @method TransactionsQuery orderBySum($order = Criteria::ASC) Order by the sum column
 * @method TransactionsQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method TransactionsQuery orderByOperationId($order = Criteria::ASC) Order by the operation_id column
 * @method TransactionsQuery orderByBonus($order = Criteria::ASC) Order by the bonus column
 * @method TransactionsQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method TransactionsQuery orderByAdvId($order = Criteria::ASC) Order by the adv_id column
 * @method TransactionsQuery orderByPacketId($order = Criteria::ASC) Order by the packet_id column
 * @method TransactionsQuery orderByServiceId($order = Criteria::ASC) Order by the service_id column
 * @method TransactionsQuery orderByDate($order = Criteria::ASC) Order by the date column
 * @method TransactionsQuery orderByTransactionDate($order = Criteria::ASC) Order by the transaction_date column
 *
 * @method TransactionsQuery groupById() Group by the id column
 * @method TransactionsQuery groupByFosUserId() Group by the fos_user_id column
 * @method TransactionsQuery groupBySum() Group by the sum column
 * @method TransactionsQuery groupByEmail() Group by the email column
 * @method TransactionsQuery groupByOperationId() Group by the operation_id column
 * @method TransactionsQuery groupByBonus() Group by the bonus column
 * @method TransactionsQuery groupByType() Group by the type column
 * @method TransactionsQuery groupByAdvId() Group by the adv_id column
 * @method TransactionsQuery groupByPacketId() Group by the packet_id column
 * @method TransactionsQuery groupByServiceId() Group by the service_id column
 * @method TransactionsQuery groupByDate() Group by the date column
 * @method TransactionsQuery groupByTransactionDate() Group by the transaction_date column
 *
 * @method TransactionsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TransactionsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TransactionsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TransactionsQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method TransactionsQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method TransactionsQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method Transactions findOne(PropelPDO $con = null) Return the first Transactions matching the query
 * @method Transactions findOneOrCreate(PropelPDO $con = null) Return the first Transactions matching the query, or a new Transactions object populated from the query conditions when no match is found
 *
 * @method Transactions findOneById(int $id) Return the first Transactions filtered by the id column
 * @method Transactions findOneByFosUserId(int $fos_user_id) Return the first Transactions filtered by the fos_user_id column
 * @method Transactions findOneBySum(double $sum) Return the first Transactions filtered by the sum column
 * @method Transactions findOneByEmail(string $email) Return the first Transactions filtered by the email column
 * @method Transactions findOneByOperationId(string $operation_id) Return the first Transactions filtered by the operation_id column
 * @method Transactions findOneByBonus(int $bonus) Return the first Transactions filtered by the bonus column
 * @method Transactions findOneByType(string $type) Return the first Transactions filtered by the type column
 * @method Transactions findOneByAdvId(int $adv_id) Return the first Transactions filtered by the adv_id column
 * @method Transactions findOneByPacketId(int $packet_id) Return the first Transactions filtered by the packet_id column
 * @method Transactions findOneByServiceId(int $service_id) Return the first Transactions filtered by the service_id column
 * @method Transactions findOneByDate(string $date) Return the first Transactions filtered by the date column
 * @method Transactions findOneByTransactionDate(string $transaction_date) Return the first Transactions filtered by the transaction_date column
 *
 * @method array findById(int $id) Return Transactions objects filtered by the id column
 * @method array findByFosUserId(int $fos_user_id) Return Transactions objects filtered by the fos_user_id column
 * @method array findBySum(double $sum) Return Transactions objects filtered by the sum column
 * @method array findByEmail(string $email) Return Transactions objects filtered by the email column
 * @method array findByOperationId(string $operation_id) Return Transactions objects filtered by the operation_id column
 * @method array findByBonus(int $bonus) Return Transactions objects filtered by the bonus column
 * @method array findByType(string $type) Return Transactions objects filtered by the type column
 * @method array findByAdvId(int $adv_id) Return Transactions objects filtered by the adv_id column
 * @method array findByPacketId(int $packet_id) Return Transactions objects filtered by the packet_id column
 * @method array findByServiceId(int $service_id) Return Transactions objects filtered by the service_id column
 * @method array findByDate(string $date) Return Transactions objects filtered by the date column
 * @method array findByTransactionDate(string $transaction_date) Return Transactions objects filtered by the transaction_date column
 */
abstract class BaseTransactionsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTransactionsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Transactions';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TransactionsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TransactionsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TransactionsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TransactionsQuery) {
            return $criteria;
        }
        $query = new TransactionsQuery(null, null, $modelAlias);

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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$id, $fos_user_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Transactions|Transactions[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TransactionsPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TransactionsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Transactions A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `fos_user_id`, `sum`, `email`, `operation_id`, `bonus`, `type`, `adv_id`, `packet_id`, `service_id`, `date`, `transaction_date` FROM `transactions` WHERE `id` = :p0 AND `fos_user_id` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Transactions();
            $obj->hydrate($row);
            TransactionsPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return Transactions|Transactions[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Transactions[]|mixed the list of results, formatted by the current formatter
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
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(TransactionsPeer::ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(TransactionsPeer::FOS_USER_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(TransactionsPeer::ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(TransactionsPeer::FOS_USER_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TransactionsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TransactionsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::ID, $id, $comparison);
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
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByFosUserId($fosUserId = null, $comparison = null)
    {
        if (is_array($fosUserId)) {
            $useMinMax = false;
            if (isset($fosUserId['min'])) {
                $this->addUsingAlias(TransactionsPeer::FOS_USER_ID, $fosUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fosUserId['max'])) {
                $this->addUsingAlias(TransactionsPeer::FOS_USER_ID, $fosUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::FOS_USER_ID, $fosUserId, $comparison);
    }

    /**
     * Filter the query on the sum column
     *
     * Example usage:
     * <code>
     * $query->filterBySum(1234); // WHERE sum = 1234
     * $query->filterBySum(array(12, 34)); // WHERE sum IN (12, 34)
     * $query->filterBySum(array('min' => 12)); // WHERE sum >= 12
     * $query->filterBySum(array('max' => 12)); // WHERE sum <= 12
     * </code>
     *
     * @param     mixed $sum The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterBySum($sum = null, $comparison = null)
    {
        if (is_array($sum)) {
            $useMinMax = false;
            if (isset($sum['min'])) {
                $this->addUsingAlias(TransactionsPeer::SUM, $sum['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sum['max'])) {
                $this->addUsingAlias(TransactionsPeer::SUM, $sum['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::SUM, $sum, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the operation_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOperationId('fooValue');   // WHERE operation_id = 'fooValue'
     * $query->filterByOperationId('%fooValue%'); // WHERE operation_id LIKE '%fooValue%'
     * </code>
     *
     * @param     string $operationId The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByOperationId($operationId = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($operationId)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $operationId)) {
                $operationId = str_replace('*', '%', $operationId);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::OPERATION_ID, $operationId, $comparison);
    }

    /**
     * Filter the query on the bonus column
     *
     * Example usage:
     * <code>
     * $query->filterByBonus(1234); // WHERE bonus = 1234
     * $query->filterByBonus(array(12, 34)); // WHERE bonus IN (12, 34)
     * $query->filterByBonus(array('min' => 12)); // WHERE bonus >= 12
     * $query->filterByBonus(array('max' => 12)); // WHERE bonus <= 12
     * </code>
     *
     * @param     mixed $bonus The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByBonus($bonus = null, $comparison = null)
    {
        if (is_array($bonus)) {
            $useMinMax = false;
            if (isset($bonus['min'])) {
                $this->addUsingAlias(TransactionsPeer::BONUS, $bonus['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($bonus['max'])) {
                $this->addUsingAlias(TransactionsPeer::BONUS, $bonus['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::BONUS, $bonus, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%'); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $type)) {
                $type = str_replace('*', '%', $type);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the adv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAdvId(1234); // WHERE adv_id = 1234
     * $query->filterByAdvId(array(12, 34)); // WHERE adv_id IN (12, 34)
     * $query->filterByAdvId(array('min' => 12)); // WHERE adv_id >= 12
     * $query->filterByAdvId(array('max' => 12)); // WHERE adv_id <= 12
     * </code>
     *
     * @param     mixed $advId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByAdvId($advId = null, $comparison = null)
    {
        if (is_array($advId)) {
            $useMinMax = false;
            if (isset($advId['min'])) {
                $this->addUsingAlias(TransactionsPeer::ADV_ID, $advId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($advId['max'])) {
                $this->addUsingAlias(TransactionsPeer::ADV_ID, $advId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::ADV_ID, $advId, $comparison);
    }

    /**
     * Filter the query on the packet_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPacketId(1234); // WHERE packet_id = 1234
     * $query->filterByPacketId(array(12, 34)); // WHERE packet_id IN (12, 34)
     * $query->filterByPacketId(array('min' => 12)); // WHERE packet_id >= 12
     * $query->filterByPacketId(array('max' => 12)); // WHERE packet_id <= 12
     * </code>
     *
     * @param     mixed $packetId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByPacketId($packetId = null, $comparison = null)
    {
        if (is_array($packetId)) {
            $useMinMax = false;
            if (isset($packetId['min'])) {
                $this->addUsingAlias(TransactionsPeer::PACKET_ID, $packetId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packetId['max'])) {
                $this->addUsingAlias(TransactionsPeer::PACKET_ID, $packetId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::PACKET_ID, $packetId, $comparison);
    }

    /**
     * Filter the query on the service_id column
     *
     * Example usage:
     * <code>
     * $query->filterByServiceId(1234); // WHERE service_id = 1234
     * $query->filterByServiceId(array(12, 34)); // WHERE service_id IN (12, 34)
     * $query->filterByServiceId(array('min' => 12)); // WHERE service_id >= 12
     * $query->filterByServiceId(array('max' => 12)); // WHERE service_id <= 12
     * </code>
     *
     * @param     mixed $serviceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByServiceId($serviceId = null, $comparison = null)
    {
        if (is_array($serviceId)) {
            $useMinMax = false;
            if (isset($serviceId['min'])) {
                $this->addUsingAlias(TransactionsPeer::SERVICE_ID, $serviceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($serviceId['max'])) {
                $this->addUsingAlias(TransactionsPeer::SERVICE_ID, $serviceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::SERVICE_ID, $serviceId, $comparison);
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
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByDate($date = null, $comparison = null)
    {
        if (is_array($date)) {
            $useMinMax = false;
            if (isset($date['min'])) {
                $this->addUsingAlias(TransactionsPeer::DATE, $date['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($date['max'])) {
                $this->addUsingAlias(TransactionsPeer::DATE, $date['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::DATE, $date, $comparison);
    }

    /**
     * Filter the query on the transaction_date column
     *
     * Example usage:
     * <code>
     * $query->filterByTransactionDate('2011-03-14'); // WHERE transaction_date = '2011-03-14'
     * $query->filterByTransactionDate('now'); // WHERE transaction_date = '2011-03-14'
     * $query->filterByTransactionDate(array('max' => 'yesterday')); // WHERE transaction_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $transactionDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function filterByTransactionDate($transactionDate = null, $comparison = null)
    {
        if (is_array($transactionDate)) {
            $useMinMax = false;
            if (isset($transactionDate['min'])) {
                $this->addUsingAlias(TransactionsPeer::TRANSACTION_DATE, $transactionDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transactionDate['max'])) {
                $this->addUsingAlias(TransactionsPeer::TRANSACTION_DATE, $transactionDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransactionsPeer::TRANSACTION_DATE, $transactionDate, $comparison);
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TransactionsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(TransactionsPeer::FOS_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransactionsPeer::FOS_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return TransactionsQuery The current query, for fluid interface
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
     * @param   Transactions $transactions Object to remove from the list of results
     *
     * @return TransactionsQuery The current query, for fluid interface
     */
    public function prune($transactions = null)
    {
        if ($transactions) {
            $this->addCond('pruneCond0', $this->getAliasedColName(TransactionsPeer::ID), $transactions->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(TransactionsPeer::FOS_USER_ID), $transactions->getFosUserId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
