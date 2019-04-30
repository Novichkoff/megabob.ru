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
use Admin\AdminBundle\Model\AdvComments;
use Admin\AdminBundle\Model\AdvComplaine;
use Admin\AdminBundle\Model\AdvImages;
use Admin\AdminBundle\Model\AdvPackets;
use Admin\AdminBundle\Model\AdvParams;
use Admin\AdminBundle\Model\AdvPrice;
use Admin\AdminBundle\Model\AdvVideos;
use Admin\AdminBundle\Model\Advs;
use Admin\AdminBundle\Model\AdvsModerStat;
use Admin\AdminBundle\Model\AdvsPeer;
use Admin\AdminBundle\Model\AdvsQuery;
use Admin\AdminBundle\Model\AdvsStat;
use Admin\AdminBundle\Model\Areas;
use Admin\AdminBundle\Model\Regions;
use Admin\AdminBundle\Model\Shops;
use Admin\AdminBundle\Model\UserFavorite;
use FOS\UserBundle\Propel\User;

/**
 * @method AdvsQuery orderById($order = Criteria::ASC) Order by the id column
 * @method AdvsQuery orderByCategoryId($order = Criteria::ASC) Order by the category_id column
 * @method AdvsQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method AdvsQuery orderByUserType($order = Criteria::ASC) Order by the user_type column
 * @method AdvsQuery orderByCompanyName($order = Criteria::ASC) Order by the company_name column
 * @method AdvsQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method AdvsQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AdvsQuery orderByAlias($order = Criteria::ASC) Order by the alias column
 * @method AdvsQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method AdvsQuery orderByPrice($order = Criteria::ASC) Order by the price column
 * @method AdvsQuery orderByDogovor($order = Criteria::ASC) Order by the dogovor column
 * @method AdvsQuery orderByTorg($order = Criteria::ASC) Order by the torg column
 * @method AdvsQuery orderByRegionId($order = Criteria::ASC) Order by the region_id column
 * @method AdvsQuery orderByAreaId($order = Criteria::ASC) Order by the area_id column
 * @method AdvsQuery orderByShopId($order = Criteria::ASC) Order by the shop_id column
 * @method AdvsQuery orderByCnt($order = Criteria::ASC) Order by the cnt column
 * @method AdvsQuery orderByCntToday($order = Criteria::ASC) Order by the cnt_today column
 * @method AdvsQuery orderByCntTel($order = Criteria::ASC) Order by the cnt_tel column
 * @method AdvsQuery orderByCntTelToday($order = Criteria::ASC) Order by the cnt_tel_today column
 * @method AdvsQuery orderByCntSkype($order = Criteria::ASC) Order by the cnt_skype column
 * @method AdvsQuery orderByCntSite($order = Criteria::ASC) Order by the cnt_site column
 * @method AdvsQuery orderByCoord($order = Criteria::ASC) Order by the coord column
 * @method AdvsQuery orderBySite($order = Criteria::ASC) Order by the site column
 * @method AdvsQuery orderBySkype($order = Criteria::ASC) Order by the skype column
 * @method AdvsQuery orderByYoutube($order = Criteria::ASC) Order by the youtube column
 * @method AdvsQuery orderByDigest($order = Criteria::ASC) Order by the digest column
 * @method AdvsQuery orderByModerApproved($order = Criteria::ASC) Order by the moder_approved column
 * @method AdvsQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method AdvsQuery orderByDeleted($order = Criteria::ASC) Order by the deleted column
 * @method AdvsQuery orderByTwitter($order = Criteria::ASC) Order by the twitter column
 * @method AdvsQuery orderByFacebook($order = Criteria::ASC) Order by the facebook column
 * @method AdvsQuery orderByVk($order = Criteria::ASC) Order by the vk column
 * @method AdvsQuery orderByVkShare($order = Criteria::ASC) Order by the vk_share column
 * @method AdvsQuery orderByGoogle($order = Criteria::ASC) Order by the google column
 * @method AdvsQuery orderByMailru($order = Criteria::ASC) Order by the mailru column
 * @method AdvsQuery orderByOdnoklassniki($order = Criteria::ASC) Order by the odnoklassniki column
 * @method AdvsQuery orderByYandexPartner($order = Criteria::ASC) Order by the yandex_partner column
 * @method AdvsQuery orderByUpDate($order = Criteria::ASC) Order by the up_date column
 * @method AdvsQuery orderByHlDate($order = Criteria::ASC) Order by the hl_date column
 * @method AdvsQuery orderBySocialDate($order = Criteria::ASC) Order by the social_date column
 * @method AdvsQuery orderByYandexDate($order = Criteria::ASC) Order by the yandex_date column
 * @method AdvsQuery orderByYandexIndexDate($order = Criteria::ASC) Order by the yandex_index_date column
 * @method AdvsQuery orderByYandexPing($order = Criteria::ASC) Order by the yandex_ping column
 * @method AdvsQuery orderByGoogleDate($order = Criteria::ASC) Order by the google_date column
 * @method AdvsQuery orderByGoogleIndexDate($order = Criteria::ASC) Order by the google_index_date column
 * @method AdvsQuery orderByCreateDate($order = Criteria::ASC) Order by the create_date column
 * @method AdvsQuery orderByPublishDate($order = Criteria::ASC) Order by the publish_date column
 * @method AdvsQuery orderByPublishBeforeDate($order = Criteria::ASC) Order by the publish_before_date column
 * @method AdvsQuery orderByLastViewDate($order = Criteria::ASC) Order by the last_view_date column
 *
 * @method AdvsQuery groupById() Group by the id column
 * @method AdvsQuery groupByCategoryId() Group by the category_id column
 * @method AdvsQuery groupByUserId() Group by the user_id column
 * @method AdvsQuery groupByUserType() Group by the user_type column
 * @method AdvsQuery groupByCompanyName() Group by the company_name column
 * @method AdvsQuery groupByPhone() Group by the phone column
 * @method AdvsQuery groupByName() Group by the name column
 * @method AdvsQuery groupByAlias() Group by the alias column
 * @method AdvsQuery groupByDescription() Group by the description column
 * @method AdvsQuery groupByPrice() Group by the price column
 * @method AdvsQuery groupByDogovor() Group by the dogovor column
 * @method AdvsQuery groupByTorg() Group by the torg column
 * @method AdvsQuery groupByRegionId() Group by the region_id column
 * @method AdvsQuery groupByAreaId() Group by the area_id column
 * @method AdvsQuery groupByShopId() Group by the shop_id column
 * @method AdvsQuery groupByCnt() Group by the cnt column
 * @method AdvsQuery groupByCntToday() Group by the cnt_today column
 * @method AdvsQuery groupByCntTel() Group by the cnt_tel column
 * @method AdvsQuery groupByCntTelToday() Group by the cnt_tel_today column
 * @method AdvsQuery groupByCntSkype() Group by the cnt_skype column
 * @method AdvsQuery groupByCntSite() Group by the cnt_site column
 * @method AdvsQuery groupByCoord() Group by the coord column
 * @method AdvsQuery groupBySite() Group by the site column
 * @method AdvsQuery groupBySkype() Group by the skype column
 * @method AdvsQuery groupByYoutube() Group by the youtube column
 * @method AdvsQuery groupByDigest() Group by the digest column
 * @method AdvsQuery groupByModerApproved() Group by the moder_approved column
 * @method AdvsQuery groupByEnabled() Group by the enabled column
 * @method AdvsQuery groupByDeleted() Group by the deleted column
 * @method AdvsQuery groupByTwitter() Group by the twitter column
 * @method AdvsQuery groupByFacebook() Group by the facebook column
 * @method AdvsQuery groupByVk() Group by the vk column
 * @method AdvsQuery groupByVkShare() Group by the vk_share column
 * @method AdvsQuery groupByGoogle() Group by the google column
 * @method AdvsQuery groupByMailru() Group by the mailru column
 * @method AdvsQuery groupByOdnoklassniki() Group by the odnoklassniki column
 * @method AdvsQuery groupByYandexPartner() Group by the yandex_partner column
 * @method AdvsQuery groupByUpDate() Group by the up_date column
 * @method AdvsQuery groupByHlDate() Group by the hl_date column
 * @method AdvsQuery groupBySocialDate() Group by the social_date column
 * @method AdvsQuery groupByYandexDate() Group by the yandex_date column
 * @method AdvsQuery groupByYandexIndexDate() Group by the yandex_index_date column
 * @method AdvsQuery groupByYandexPing() Group by the yandex_ping column
 * @method AdvsQuery groupByGoogleDate() Group by the google_date column
 * @method AdvsQuery groupByGoogleIndexDate() Group by the google_index_date column
 * @method AdvsQuery groupByCreateDate() Group by the create_date column
 * @method AdvsQuery groupByPublishDate() Group by the publish_date column
 * @method AdvsQuery groupByPublishBeforeDate() Group by the publish_before_date column
 * @method AdvsQuery groupByLastViewDate() Group by the last_view_date column
 *
 * @method AdvsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AdvsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AdvsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AdvsQuery leftJoinRegions($relationAlias = null) Adds a LEFT JOIN clause to the query using the Regions relation
 * @method AdvsQuery rightJoinRegions($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Regions relation
 * @method AdvsQuery innerJoinRegions($relationAlias = null) Adds a INNER JOIN clause to the query using the Regions relation
 *
 * @method AdvsQuery leftJoinAreas($relationAlias = null) Adds a LEFT JOIN clause to the query using the Areas relation
 * @method AdvsQuery rightJoinAreas($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Areas relation
 * @method AdvsQuery innerJoinAreas($relationAlias = null) Adds a INNER JOIN clause to the query using the Areas relation
 *
 * @method AdvsQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method AdvsQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method AdvsQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method AdvsQuery leftJoinShops($relationAlias = null) Adds a LEFT JOIN clause to the query using the Shops relation
 * @method AdvsQuery rightJoinShops($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Shops relation
 * @method AdvsQuery innerJoinShops($relationAlias = null) Adds a INNER JOIN clause to the query using the Shops relation
 *
 * @method AdvsQuery leftJoinAdCategories($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdCategories relation
 * @method AdvsQuery rightJoinAdCategories($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdCategories relation
 * @method AdvsQuery innerJoinAdCategories($relationAlias = null) Adds a INNER JOIN clause to the query using the AdCategories relation
 *
 * @method AdvsQuery leftJoinAdvPrice($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvPrice relation
 * @method AdvsQuery rightJoinAdvPrice($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvPrice relation
 * @method AdvsQuery innerJoinAdvPrice($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvPrice relation
 *
 * @method AdvsQuery leftJoinAdvsStat($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvsStat relation
 * @method AdvsQuery rightJoinAdvsStat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvsStat relation
 * @method AdvsQuery innerJoinAdvsStat($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvsStat relation
 *
 * @method AdvsQuery leftJoinAdvsModerStat($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvsModerStat relation
 * @method AdvsQuery rightJoinAdvsModerStat($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvsModerStat relation
 * @method AdvsQuery innerJoinAdvsModerStat($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvsModerStat relation
 *
 * @method AdvsQuery leftJoinAdvParams($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvParams relation
 * @method AdvsQuery rightJoinAdvParams($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvParams relation
 * @method AdvsQuery innerJoinAdvParams($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvParams relation
 *
 * @method AdvsQuery leftJoinAdvImages($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvImages relation
 * @method AdvsQuery rightJoinAdvImages($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvImages relation
 * @method AdvsQuery innerJoinAdvImages($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvImages relation
 *
 * @method AdvsQuery leftJoinAdvVideos($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvVideos relation
 * @method AdvsQuery rightJoinAdvVideos($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvVideos relation
 * @method AdvsQuery innerJoinAdvVideos($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvVideos relation
 *
 * @method AdvsQuery leftJoinAdvPackets($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvPackets relation
 * @method AdvsQuery rightJoinAdvPackets($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvPackets relation
 * @method AdvsQuery innerJoinAdvPackets($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvPackets relation
 *
 * @method AdvsQuery leftJoinAdvComments($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvComments relation
 * @method AdvsQuery rightJoinAdvComments($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvComments relation
 * @method AdvsQuery innerJoinAdvComments($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvComments relation
 *
 * @method AdvsQuery leftJoinAdvComplaine($relationAlias = null) Adds a LEFT JOIN clause to the query using the AdvComplaine relation
 * @method AdvsQuery rightJoinAdvComplaine($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AdvComplaine relation
 * @method AdvsQuery innerJoinAdvComplaine($relationAlias = null) Adds a INNER JOIN clause to the query using the AdvComplaine relation
 *
 * @method AdvsQuery leftJoinUserFavorite($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserFavorite relation
 * @method AdvsQuery rightJoinUserFavorite($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserFavorite relation
 * @method AdvsQuery innerJoinUserFavorite($relationAlias = null) Adds a INNER JOIN clause to the query using the UserFavorite relation
 *
 * @method Advs findOne(PropelPDO $con = null) Return the first Advs matching the query
 * @method Advs findOneOrCreate(PropelPDO $con = null) Return the first Advs matching the query, or a new Advs object populated from the query conditions when no match is found
 *
 * @method Advs findOneByCategoryId(int $category_id) Return the first Advs filtered by the category_id column
 * @method Advs findOneByUserId(int $user_id) Return the first Advs filtered by the user_id column
 * @method Advs findOneByUserType(int $user_type) Return the first Advs filtered by the user_type column
 * @method Advs findOneByCompanyName(string $company_name) Return the first Advs filtered by the company_name column
 * @method Advs findOneByPhone(string $phone) Return the first Advs filtered by the phone column
 * @method Advs findOneByName(string $name) Return the first Advs filtered by the name column
 * @method Advs findOneByAlias(string $alias) Return the first Advs filtered by the alias column
 * @method Advs findOneByDescription(string $description) Return the first Advs filtered by the description column
 * @method Advs findOneByPrice(int $price) Return the first Advs filtered by the price column
 * @method Advs findOneByDogovor(boolean $dogovor) Return the first Advs filtered by the dogovor column
 * @method Advs findOneByTorg(boolean $torg) Return the first Advs filtered by the torg column
 * @method Advs findOneByRegionId(int $region_id) Return the first Advs filtered by the region_id column
 * @method Advs findOneByAreaId(int $area_id) Return the first Advs filtered by the area_id column
 * @method Advs findOneByShopId(int $shop_id) Return the first Advs filtered by the shop_id column
 * @method Advs findOneByCnt(int $cnt) Return the first Advs filtered by the cnt column
 * @method Advs findOneByCntToday(int $cnt_today) Return the first Advs filtered by the cnt_today column
 * @method Advs findOneByCntTel(int $cnt_tel) Return the first Advs filtered by the cnt_tel column
 * @method Advs findOneByCntTelToday(int $cnt_tel_today) Return the first Advs filtered by the cnt_tel_today column
 * @method Advs findOneByCntSkype(int $cnt_skype) Return the first Advs filtered by the cnt_skype column
 * @method Advs findOneByCntSite(int $cnt_site) Return the first Advs filtered by the cnt_site column
 * @method Advs findOneByCoord(string $coord) Return the first Advs filtered by the coord column
 * @method Advs findOneBySite(string $site) Return the first Advs filtered by the site column
 * @method Advs findOneBySkype(string $skype) Return the first Advs filtered by the skype column
 * @method Advs findOneByYoutube(string $youtube) Return the first Advs filtered by the youtube column
 * @method Advs findOneByDigest(boolean $digest) Return the first Advs filtered by the digest column
 * @method Advs findOneByModerApproved(boolean $moder_approved) Return the first Advs filtered by the moder_approved column
 * @method Advs findOneByEnabled(boolean $enabled) Return the first Advs filtered by the enabled column
 * @method Advs findOneByDeleted(boolean $deleted) Return the first Advs filtered by the deleted column
 * @method Advs findOneByTwitter(int $twitter) Return the first Advs filtered by the twitter column
 * @method Advs findOneByFacebook(int $facebook) Return the first Advs filtered by the facebook column
 * @method Advs findOneByVk(int $vk) Return the first Advs filtered by the vk column
 * @method Advs findOneByVkShare(int $vk_share) Return the first Advs filtered by the vk_share column
 * @method Advs findOneByGoogle(int $google) Return the first Advs filtered by the google column
 * @method Advs findOneByMailru(int $mailru) Return the first Advs filtered by the mailru column
 * @method Advs findOneByOdnoklassniki(int $odnoklassniki) Return the first Advs filtered by the odnoklassniki column
 * @method Advs findOneByYandexPartner(boolean $yandex_partner) Return the first Advs filtered by the yandex_partner column
 * @method Advs findOneByUpDate(string $up_date) Return the first Advs filtered by the up_date column
 * @method Advs findOneByHlDate(string $hl_date) Return the first Advs filtered by the hl_date column
 * @method Advs findOneBySocialDate(string $social_date) Return the first Advs filtered by the social_date column
 * @method Advs findOneByYandexDate(string $yandex_date) Return the first Advs filtered by the yandex_date column
 * @method Advs findOneByYandexIndexDate(string $yandex_index_date) Return the first Advs filtered by the yandex_index_date column
 * @method Advs findOneByYandexPing(int $yandex_ping) Return the first Advs filtered by the yandex_ping column
 * @method Advs findOneByGoogleDate(string $google_date) Return the first Advs filtered by the google_date column
 * @method Advs findOneByGoogleIndexDate(string $google_index_date) Return the first Advs filtered by the google_index_date column
 * @method Advs findOneByCreateDate(string $create_date) Return the first Advs filtered by the create_date column
 * @method Advs findOneByPublishDate(string $publish_date) Return the first Advs filtered by the publish_date column
 * @method Advs findOneByPublishBeforeDate(string $publish_before_date) Return the first Advs filtered by the publish_before_date column
 * @method Advs findOneByLastViewDate(string $last_view_date) Return the first Advs filtered by the last_view_date column
 *
 * @method array findById(int $id) Return Advs objects filtered by the id column
 * @method array findByCategoryId(int $category_id) Return Advs objects filtered by the category_id column
 * @method array findByUserId(int $user_id) Return Advs objects filtered by the user_id column
 * @method array findByUserType(int $user_type) Return Advs objects filtered by the user_type column
 * @method array findByCompanyName(string $company_name) Return Advs objects filtered by the company_name column
 * @method array findByPhone(string $phone) Return Advs objects filtered by the phone column
 * @method array findByName(string $name) Return Advs objects filtered by the name column
 * @method array findByAlias(string $alias) Return Advs objects filtered by the alias column
 * @method array findByDescription(string $description) Return Advs objects filtered by the description column
 * @method array findByPrice(int $price) Return Advs objects filtered by the price column
 * @method array findByDogovor(boolean $dogovor) Return Advs objects filtered by the dogovor column
 * @method array findByTorg(boolean $torg) Return Advs objects filtered by the torg column
 * @method array findByRegionId(int $region_id) Return Advs objects filtered by the region_id column
 * @method array findByAreaId(int $area_id) Return Advs objects filtered by the area_id column
 * @method array findByShopId(int $shop_id) Return Advs objects filtered by the shop_id column
 * @method array findByCnt(int $cnt) Return Advs objects filtered by the cnt column
 * @method array findByCntToday(int $cnt_today) Return Advs objects filtered by the cnt_today column
 * @method array findByCntTel(int $cnt_tel) Return Advs objects filtered by the cnt_tel column
 * @method array findByCntTelToday(int $cnt_tel_today) Return Advs objects filtered by the cnt_tel_today column
 * @method array findByCntSkype(int $cnt_skype) Return Advs objects filtered by the cnt_skype column
 * @method array findByCntSite(int $cnt_site) Return Advs objects filtered by the cnt_site column
 * @method array findByCoord(string $coord) Return Advs objects filtered by the coord column
 * @method array findBySite(string $site) Return Advs objects filtered by the site column
 * @method array findBySkype(string $skype) Return Advs objects filtered by the skype column
 * @method array findByYoutube(string $youtube) Return Advs objects filtered by the youtube column
 * @method array findByDigest(boolean $digest) Return Advs objects filtered by the digest column
 * @method array findByModerApproved(boolean $moder_approved) Return Advs objects filtered by the moder_approved column
 * @method array findByEnabled(boolean $enabled) Return Advs objects filtered by the enabled column
 * @method array findByDeleted(boolean $deleted) Return Advs objects filtered by the deleted column
 * @method array findByTwitter(int $twitter) Return Advs objects filtered by the twitter column
 * @method array findByFacebook(int $facebook) Return Advs objects filtered by the facebook column
 * @method array findByVk(int $vk) Return Advs objects filtered by the vk column
 * @method array findByVkShare(int $vk_share) Return Advs objects filtered by the vk_share column
 * @method array findByGoogle(int $google) Return Advs objects filtered by the google column
 * @method array findByMailru(int $mailru) Return Advs objects filtered by the mailru column
 * @method array findByOdnoklassniki(int $odnoklassniki) Return Advs objects filtered by the odnoklassniki column
 * @method array findByYandexPartner(boolean $yandex_partner) Return Advs objects filtered by the yandex_partner column
 * @method array findByUpDate(string $up_date) Return Advs objects filtered by the up_date column
 * @method array findByHlDate(string $hl_date) Return Advs objects filtered by the hl_date column
 * @method array findBySocialDate(string $social_date) Return Advs objects filtered by the social_date column
 * @method array findByYandexDate(string $yandex_date) Return Advs objects filtered by the yandex_date column
 * @method array findByYandexIndexDate(string $yandex_index_date) Return Advs objects filtered by the yandex_index_date column
 * @method array findByYandexPing(int $yandex_ping) Return Advs objects filtered by the yandex_ping column
 * @method array findByGoogleDate(string $google_date) Return Advs objects filtered by the google_date column
 * @method array findByGoogleIndexDate(string $google_index_date) Return Advs objects filtered by the google_index_date column
 * @method array findByCreateDate(string $create_date) Return Advs objects filtered by the create_date column
 * @method array findByPublishDate(string $publish_date) Return Advs objects filtered by the publish_date column
 * @method array findByPublishBeforeDate(string $publish_before_date) Return Advs objects filtered by the publish_before_date column
 * @method array findByLastViewDate(string $last_view_date) Return Advs objects filtered by the last_view_date column
 */
abstract class BaseAdvsQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAdvsQuery object.
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
            $modelName = 'Admin\\AdminBundle\\Model\\Advs';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AdvsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AdvsQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AdvsQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AdvsQuery) {
            return $criteria;
        }
        $query = new AdvsQuery(null, null, $modelAlias);

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
     * @return   Advs|Advs[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AdvsPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AdvsPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Advs A model object, or null if the key is not found
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
     * @return                 Advs A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `category_id`, `user_id`, `user_type`, `company_name`, `phone`, `name`, `alias`, `description`, `price`, `dogovor`, `torg`, `region_id`, `area_id`, `shop_id`, `cnt`, `cnt_today`, `cnt_tel`, `cnt_tel_today`, `cnt_skype`, `cnt_site`, `coord`, `site`, `skype`, `youtube`, `digest`, `moder_approved`, `enabled`, `deleted`, `twitter`, `facebook`, `vk`, `vk_share`, `google`, `mailru`, `odnoklassniki`, `yandex_partner`, `up_date`, `hl_date`, `social_date`, `yandex_date`, `yandex_index_date`, `yandex_ping`, `google_date`, `google_index_date`, `create_date`, `publish_date`, `publish_before_date`, `last_view_date` FROM `advs` WHERE `id` = :p0';
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
            $obj = new Advs();
            $obj->hydrate($row);
            AdvsPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Advs|Advs[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Advs[]|mixed the list of results, formatted by the current formatter
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
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AdvsPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AdvsPeer::ID, $keys, Criteria::IN);
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
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AdvsPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AdvsPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the category_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCategoryId(1234); // WHERE category_id = 1234
     * $query->filterByCategoryId(array(12, 34)); // WHERE category_id IN (12, 34)
     * $query->filterByCategoryId(array('min' => 12)); // WHERE category_id >= 12
     * $query->filterByCategoryId(array('max' => 12)); // WHERE category_id <= 12
     * </code>
     *
     * @see       filterByAdCategories()
     *
     * @param     mixed $categoryId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCategoryId($categoryId = null, $comparison = null)
    {
        if (is_array($categoryId)) {
            $useMinMax = false;
            if (isset($categoryId['min'])) {
                $this->addUsingAlias(AdvsPeer::CATEGORY_ID, $categoryId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($categoryId['max'])) {
                $this->addUsingAlias(AdvsPeer::CATEGORY_ID, $categoryId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CATEGORY_ID, $categoryId, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id >= 12
     * $query->filterByUserId(array('max' => 12)); // WHERE user_id <= 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(AdvsPeer::USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(AdvsPeer::USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the user_type column
     *
     * Example usage:
     * <code>
     * $query->filterByUserType(1234); // WHERE user_type = 1234
     * $query->filterByUserType(array(12, 34)); // WHERE user_type IN (12, 34)
     * $query->filterByUserType(array('min' => 12)); // WHERE user_type >= 12
     * $query->filterByUserType(array('max' => 12)); // WHERE user_type <= 12
     * </code>
     *
     * @param     mixed $userType The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByUserType($userType = null, $comparison = null)
    {
        if (is_array($userType)) {
            $useMinMax = false;
            if (isset($userType['min'])) {
                $this->addUsingAlias(AdvsPeer::USER_TYPE, $userType['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userType['max'])) {
                $this->addUsingAlias(AdvsPeer::USER_TYPE, $userType['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::USER_TYPE, $userType, $comparison);
    }

    /**
     * Filter the query on the company_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCompanyName('fooValue');   // WHERE company_name = 'fooValue'
     * $query->filterByCompanyName('%fooValue%'); // WHERE company_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $companyName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCompanyName($companyName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($companyName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $companyName)) {
                $companyName = str_replace('*', '%', $companyName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdvsPeer::COMPANY_NAME, $companyName, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdvsPeer::PHONE, $phone, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdvsPeer::NAME, $name, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdvsPeer::ALIAS, $alias, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdvsPeer::DESCRIPTION, $description, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByPrice($price = null, $comparison = null)
    {
        if (is_array($price)) {
            $useMinMax = false;
            if (isset($price['min'])) {
                $this->addUsingAlias(AdvsPeer::PRICE, $price['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($price['max'])) {
                $this->addUsingAlias(AdvsPeer::PRICE, $price['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::PRICE, $price, $comparison);
    }

    /**
     * Filter the query on the dogovor column
     *
     * Example usage:
     * <code>
     * $query->filterByDogovor(true); // WHERE dogovor = true
     * $query->filterByDogovor('yes'); // WHERE dogovor = true
     * </code>
     *
     * @param     boolean|string $dogovor The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByDogovor($dogovor = null, $comparison = null)
    {
        if (is_string($dogovor)) {
            $dogovor = in_array(strtolower($dogovor), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::DOGOVOR, $dogovor, $comparison);
    }

    /**
     * Filter the query on the torg column
     *
     * Example usage:
     * <code>
     * $query->filterByTorg(true); // WHERE torg = true
     * $query->filterByTorg('yes'); // WHERE torg = true
     * </code>
     *
     * @param     boolean|string $torg The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByTorg($torg = null, $comparison = null)
    {
        if (is_string($torg)) {
            $torg = in_array(strtolower($torg), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::TORG, $torg, $comparison);
    }

    /**
     * Filter the query on the region_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRegionId(1234); // WHERE region_id = 1234
     * $query->filterByRegionId(array(12, 34)); // WHERE region_id IN (12, 34)
     * $query->filterByRegionId(array('min' => 12)); // WHERE region_id >= 12
     * $query->filterByRegionId(array('max' => 12)); // WHERE region_id <= 12
     * </code>
     *
     * @see       filterByRegions()
     *
     * @param     mixed $regionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByRegionId($regionId = null, $comparison = null)
    {
        if (is_array($regionId)) {
            $useMinMax = false;
            if (isset($regionId['min'])) {
                $this->addUsingAlias(AdvsPeer::REGION_ID, $regionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($regionId['max'])) {
                $this->addUsingAlias(AdvsPeer::REGION_ID, $regionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::REGION_ID, $regionId, $comparison);
    }

    /**
     * Filter the query on the area_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAreaId(1234); // WHERE area_id = 1234
     * $query->filterByAreaId(array(12, 34)); // WHERE area_id IN (12, 34)
     * $query->filterByAreaId(array('min' => 12)); // WHERE area_id >= 12
     * $query->filterByAreaId(array('max' => 12)); // WHERE area_id <= 12
     * </code>
     *
     * @see       filterByAreas()
     *
     * @param     mixed $areaId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByAreaId($areaId = null, $comparison = null)
    {
        if (is_array($areaId)) {
            $useMinMax = false;
            if (isset($areaId['min'])) {
                $this->addUsingAlias(AdvsPeer::AREA_ID, $areaId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($areaId['max'])) {
                $this->addUsingAlias(AdvsPeer::AREA_ID, $areaId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::AREA_ID, $areaId, $comparison);
    }

    /**
     * Filter the query on the shop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByShopId(1234); // WHERE shop_id = 1234
     * $query->filterByShopId(array(12, 34)); // WHERE shop_id IN (12, 34)
     * $query->filterByShopId(array('min' => 12)); // WHERE shop_id >= 12
     * $query->filterByShopId(array('max' => 12)); // WHERE shop_id <= 12
     * </code>
     *
     * @see       filterByShops()
     *
     * @param     mixed $shopId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByShopId($shopId = null, $comparison = null)
    {
        if (is_array($shopId)) {
            $useMinMax = false;
            if (isset($shopId['min'])) {
                $this->addUsingAlias(AdvsPeer::SHOP_ID, $shopId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($shopId['max'])) {
                $this->addUsingAlias(AdvsPeer::SHOP_ID, $shopId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::SHOP_ID, $shopId, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCnt($cnt = null, $comparison = null)
    {
        if (is_array($cnt)) {
            $useMinMax = false;
            if (isset($cnt['min'])) {
                $this->addUsingAlias(AdvsPeer::CNT, $cnt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cnt['max'])) {
                $this->addUsingAlias(AdvsPeer::CNT, $cnt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CNT, $cnt, $comparison);
    }

    /**
     * Filter the query on the cnt_today column
     *
     * Example usage:
     * <code>
     * $query->filterByCntToday(1234); // WHERE cnt_today = 1234
     * $query->filterByCntToday(array(12, 34)); // WHERE cnt_today IN (12, 34)
     * $query->filterByCntToday(array('min' => 12)); // WHERE cnt_today >= 12
     * $query->filterByCntToday(array('max' => 12)); // WHERE cnt_today <= 12
     * </code>
     *
     * @param     mixed $cntToday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCntToday($cntToday = null, $comparison = null)
    {
        if (is_array($cntToday)) {
            $useMinMax = false;
            if (isset($cntToday['min'])) {
                $this->addUsingAlias(AdvsPeer::CNT_TODAY, $cntToday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntToday['max'])) {
                $this->addUsingAlias(AdvsPeer::CNT_TODAY, $cntToday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CNT_TODAY, $cntToday, $comparison);
    }

    /**
     * Filter the query on the cnt_tel column
     *
     * Example usage:
     * <code>
     * $query->filterByCntTel(1234); // WHERE cnt_tel = 1234
     * $query->filterByCntTel(array(12, 34)); // WHERE cnt_tel IN (12, 34)
     * $query->filterByCntTel(array('min' => 12)); // WHERE cnt_tel >= 12
     * $query->filterByCntTel(array('max' => 12)); // WHERE cnt_tel <= 12
     * </code>
     *
     * @param     mixed $cntTel The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCntTel($cntTel = null, $comparison = null)
    {
        if (is_array($cntTel)) {
            $useMinMax = false;
            if (isset($cntTel['min'])) {
                $this->addUsingAlias(AdvsPeer::CNT_TEL, $cntTel['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntTel['max'])) {
                $this->addUsingAlias(AdvsPeer::CNT_TEL, $cntTel['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CNT_TEL, $cntTel, $comparison);
    }

    /**
     * Filter the query on the cnt_tel_today column
     *
     * Example usage:
     * <code>
     * $query->filterByCntTelToday(1234); // WHERE cnt_tel_today = 1234
     * $query->filterByCntTelToday(array(12, 34)); // WHERE cnt_tel_today IN (12, 34)
     * $query->filterByCntTelToday(array('min' => 12)); // WHERE cnt_tel_today >= 12
     * $query->filterByCntTelToday(array('max' => 12)); // WHERE cnt_tel_today <= 12
     * </code>
     *
     * @param     mixed $cntTelToday The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCntTelToday($cntTelToday = null, $comparison = null)
    {
        if (is_array($cntTelToday)) {
            $useMinMax = false;
            if (isset($cntTelToday['min'])) {
                $this->addUsingAlias(AdvsPeer::CNT_TEL_TODAY, $cntTelToday['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntTelToday['max'])) {
                $this->addUsingAlias(AdvsPeer::CNT_TEL_TODAY, $cntTelToday['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CNT_TEL_TODAY, $cntTelToday, $comparison);
    }

    /**
     * Filter the query on the cnt_skype column
     *
     * Example usage:
     * <code>
     * $query->filterByCntSkype(1234); // WHERE cnt_skype = 1234
     * $query->filterByCntSkype(array(12, 34)); // WHERE cnt_skype IN (12, 34)
     * $query->filterByCntSkype(array('min' => 12)); // WHERE cnt_skype >= 12
     * $query->filterByCntSkype(array('max' => 12)); // WHERE cnt_skype <= 12
     * </code>
     *
     * @param     mixed $cntSkype The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCntSkype($cntSkype = null, $comparison = null)
    {
        if (is_array($cntSkype)) {
            $useMinMax = false;
            if (isset($cntSkype['min'])) {
                $this->addUsingAlias(AdvsPeer::CNT_SKYPE, $cntSkype['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntSkype['max'])) {
                $this->addUsingAlias(AdvsPeer::CNT_SKYPE, $cntSkype['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CNT_SKYPE, $cntSkype, $comparison);
    }

    /**
     * Filter the query on the cnt_site column
     *
     * Example usage:
     * <code>
     * $query->filterByCntSite(1234); // WHERE cnt_site = 1234
     * $query->filterByCntSite(array(12, 34)); // WHERE cnt_site IN (12, 34)
     * $query->filterByCntSite(array('min' => 12)); // WHERE cnt_site >= 12
     * $query->filterByCntSite(array('max' => 12)); // WHERE cnt_site <= 12
     * </code>
     *
     * @param     mixed $cntSite The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCntSite($cntSite = null, $comparison = null)
    {
        if (is_array($cntSite)) {
            $useMinMax = false;
            if (isset($cntSite['min'])) {
                $this->addUsingAlias(AdvsPeer::CNT_SITE, $cntSite['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cntSite['max'])) {
                $this->addUsingAlias(AdvsPeer::CNT_SITE, $cntSite['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CNT_SITE, $cntSite, $comparison);
    }

    /**
     * Filter the query on the coord column
     *
     * Example usage:
     * <code>
     * $query->filterByCoord('fooValue');   // WHERE coord = 'fooValue'
     * $query->filterByCoord('%fooValue%'); // WHERE coord LIKE '%fooValue%'
     * </code>
     *
     * @param     string $coord The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCoord($coord = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($coord)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $coord)) {
                $coord = str_replace('*', '%', $coord);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdvsPeer::COORD, $coord, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AdvsPeer::SITE, $site, $comparison);
    }

    /**
     * Filter the query on the skype column
     *
     * Example usage:
     * <code>
     * $query->filterBySkype('fooValue');   // WHERE skype = 'fooValue'
     * $query->filterBySkype('%fooValue%'); // WHERE skype LIKE '%fooValue%'
     * </code>
     *
     * @param     string $skype The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterBySkype($skype = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($skype)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $skype)) {
                $skype = str_replace('*', '%', $skype);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdvsPeer::SKYPE, $skype, $comparison);
    }

    /**
     * Filter the query on the youtube column
     *
     * Example usage:
     * <code>
     * $query->filterByYoutube('fooValue');   // WHERE youtube = 'fooValue'
     * $query->filterByYoutube('%fooValue%'); // WHERE youtube LIKE '%fooValue%'
     * </code>
     *
     * @param     string $youtube The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByYoutube($youtube = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($youtube)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $youtube)) {
                $youtube = str_replace('*', '%', $youtube);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AdvsPeer::YOUTUBE, $youtube, $comparison);
    }

    /**
     * Filter the query on the digest column
     *
     * Example usage:
     * <code>
     * $query->filterByDigest(true); // WHERE digest = true
     * $query->filterByDigest('yes'); // WHERE digest = true
     * </code>
     *
     * @param     boolean|string $digest The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByDigest($digest = null, $comparison = null)
    {
        if (is_string($digest)) {
            $digest = in_array(strtolower($digest), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::DIGEST, $digest, $comparison);
    }

    /**
     * Filter the query on the moder_approved column
     *
     * Example usage:
     * <code>
     * $query->filterByModerApproved(true); // WHERE moder_approved = true
     * $query->filterByModerApproved('yes'); // WHERE moder_approved = true
     * </code>
     *
     * @param     boolean|string $moderApproved The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByModerApproved($moderApproved = null, $comparison = null)
    {
        if (is_string($moderApproved)) {
            $moderApproved = in_array(strtolower($moderApproved), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::MODER_APPROVED, $moderApproved, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::ENABLED, $enabled, $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByDeleted($deleted = null, $comparison = null)
    {
        if (is_string($deleted)) {
            $deleted = in_array(strtolower($deleted), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::DELETED, $deleted, $comparison);
    }

    /**
     * Filter the query on the twitter column
     *
     * Example usage:
     * <code>
     * $query->filterByTwitter(1234); // WHERE twitter = 1234
     * $query->filterByTwitter(array(12, 34)); // WHERE twitter IN (12, 34)
     * $query->filterByTwitter(array('min' => 12)); // WHERE twitter >= 12
     * $query->filterByTwitter(array('max' => 12)); // WHERE twitter <= 12
     * </code>
     *
     * @param     mixed $twitter The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByTwitter($twitter = null, $comparison = null)
    {
        if (is_array($twitter)) {
            $useMinMax = false;
            if (isset($twitter['min'])) {
                $this->addUsingAlias(AdvsPeer::TWITTER, $twitter['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($twitter['max'])) {
                $this->addUsingAlias(AdvsPeer::TWITTER, $twitter['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::TWITTER, $twitter, $comparison);
    }

    /**
     * Filter the query on the facebook column
     *
     * Example usage:
     * <code>
     * $query->filterByFacebook(1234); // WHERE facebook = 1234
     * $query->filterByFacebook(array(12, 34)); // WHERE facebook IN (12, 34)
     * $query->filterByFacebook(array('min' => 12)); // WHERE facebook >= 12
     * $query->filterByFacebook(array('max' => 12)); // WHERE facebook <= 12
     * </code>
     *
     * @param     mixed $facebook The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByFacebook($facebook = null, $comparison = null)
    {
        if (is_array($facebook)) {
            $useMinMax = false;
            if (isset($facebook['min'])) {
                $this->addUsingAlias(AdvsPeer::FACEBOOK, $facebook['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($facebook['max'])) {
                $this->addUsingAlias(AdvsPeer::FACEBOOK, $facebook['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::FACEBOOK, $facebook, $comparison);
    }

    /**
     * Filter the query on the vk column
     *
     * Example usage:
     * <code>
     * $query->filterByVk(1234); // WHERE vk = 1234
     * $query->filterByVk(array(12, 34)); // WHERE vk IN (12, 34)
     * $query->filterByVk(array('min' => 12)); // WHERE vk >= 12
     * $query->filterByVk(array('max' => 12)); // WHERE vk <= 12
     * </code>
     *
     * @param     mixed $vk The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByVk($vk = null, $comparison = null)
    {
        if (is_array($vk)) {
            $useMinMax = false;
            if (isset($vk['min'])) {
                $this->addUsingAlias(AdvsPeer::VK, $vk['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vk['max'])) {
                $this->addUsingAlias(AdvsPeer::VK, $vk['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::VK, $vk, $comparison);
    }

    /**
     * Filter the query on the vk_share column
     *
     * Example usage:
     * <code>
     * $query->filterByVkShare(1234); // WHERE vk_share = 1234
     * $query->filterByVkShare(array(12, 34)); // WHERE vk_share IN (12, 34)
     * $query->filterByVkShare(array('min' => 12)); // WHERE vk_share >= 12
     * $query->filterByVkShare(array('max' => 12)); // WHERE vk_share <= 12
     * </code>
     *
     * @param     mixed $vkShare The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByVkShare($vkShare = null, $comparison = null)
    {
        if (is_array($vkShare)) {
            $useMinMax = false;
            if (isset($vkShare['min'])) {
                $this->addUsingAlias(AdvsPeer::VK_SHARE, $vkShare['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($vkShare['max'])) {
                $this->addUsingAlias(AdvsPeer::VK_SHARE, $vkShare['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::VK_SHARE, $vkShare, $comparison);
    }

    /**
     * Filter the query on the google column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogle(1234); // WHERE google = 1234
     * $query->filterByGoogle(array(12, 34)); // WHERE google IN (12, 34)
     * $query->filterByGoogle(array('min' => 12)); // WHERE google >= 12
     * $query->filterByGoogle(array('max' => 12)); // WHERE google <= 12
     * </code>
     *
     * @param     mixed $google The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByGoogle($google = null, $comparison = null)
    {
        if (is_array($google)) {
            $useMinMax = false;
            if (isset($google['min'])) {
                $this->addUsingAlias(AdvsPeer::GOOGLE, $google['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($google['max'])) {
                $this->addUsingAlias(AdvsPeer::GOOGLE, $google['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::GOOGLE, $google, $comparison);
    }

    /**
     * Filter the query on the mailru column
     *
     * Example usage:
     * <code>
     * $query->filterByMailru(1234); // WHERE mailru = 1234
     * $query->filterByMailru(array(12, 34)); // WHERE mailru IN (12, 34)
     * $query->filterByMailru(array('min' => 12)); // WHERE mailru >= 12
     * $query->filterByMailru(array('max' => 12)); // WHERE mailru <= 12
     * </code>
     *
     * @param     mixed $mailru The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByMailru($mailru = null, $comparison = null)
    {
        if (is_array($mailru)) {
            $useMinMax = false;
            if (isset($mailru['min'])) {
                $this->addUsingAlias(AdvsPeer::MAILRU, $mailru['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($mailru['max'])) {
                $this->addUsingAlias(AdvsPeer::MAILRU, $mailru['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::MAILRU, $mailru, $comparison);
    }

    /**
     * Filter the query on the odnoklassniki column
     *
     * Example usage:
     * <code>
     * $query->filterByOdnoklassniki(1234); // WHERE odnoklassniki = 1234
     * $query->filterByOdnoklassniki(array(12, 34)); // WHERE odnoklassniki IN (12, 34)
     * $query->filterByOdnoklassniki(array('min' => 12)); // WHERE odnoklassniki >= 12
     * $query->filterByOdnoklassniki(array('max' => 12)); // WHERE odnoklassniki <= 12
     * </code>
     *
     * @param     mixed $odnoklassniki The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByOdnoklassniki($odnoklassniki = null, $comparison = null)
    {
        if (is_array($odnoklassniki)) {
            $useMinMax = false;
            if (isset($odnoklassniki['min'])) {
                $this->addUsingAlias(AdvsPeer::ODNOKLASSNIKI, $odnoklassniki['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($odnoklassniki['max'])) {
                $this->addUsingAlias(AdvsPeer::ODNOKLASSNIKI, $odnoklassniki['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::ODNOKLASSNIKI, $odnoklassniki, $comparison);
    }

    /**
     * Filter the query on the yandex_partner column
     *
     * Example usage:
     * <code>
     * $query->filterByYandexPartner(true); // WHERE yandex_partner = true
     * $query->filterByYandexPartner('yes'); // WHERE yandex_partner = true
     * </code>
     *
     * @param     boolean|string $yandexPartner The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByYandexPartner($yandexPartner = null, $comparison = null)
    {
        if (is_string($yandexPartner)) {
            $yandexPartner = in_array(strtolower($yandexPartner), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(AdvsPeer::YANDEX_PARTNER, $yandexPartner, $comparison);
    }

    /**
     * Filter the query on the up_date column
     *
     * Example usage:
     * <code>
     * $query->filterByUpDate('2011-03-14'); // WHERE up_date = '2011-03-14'
     * $query->filterByUpDate('now'); // WHERE up_date = '2011-03-14'
     * $query->filterByUpDate(array('max' => 'yesterday')); // WHERE up_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $upDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByUpDate($upDate = null, $comparison = null)
    {
        if (is_array($upDate)) {
            $useMinMax = false;
            if (isset($upDate['min'])) {
                $this->addUsingAlias(AdvsPeer::UP_DATE, $upDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($upDate['max'])) {
                $this->addUsingAlias(AdvsPeer::UP_DATE, $upDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::UP_DATE, $upDate, $comparison);
    }

    /**
     * Filter the query on the hl_date column
     *
     * Example usage:
     * <code>
     * $query->filterByHlDate('2011-03-14'); // WHERE hl_date = '2011-03-14'
     * $query->filterByHlDate('now'); // WHERE hl_date = '2011-03-14'
     * $query->filterByHlDate(array('max' => 'yesterday')); // WHERE hl_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $hlDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByHlDate($hlDate = null, $comparison = null)
    {
        if (is_array($hlDate)) {
            $useMinMax = false;
            if (isset($hlDate['min'])) {
                $this->addUsingAlias(AdvsPeer::HL_DATE, $hlDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($hlDate['max'])) {
                $this->addUsingAlias(AdvsPeer::HL_DATE, $hlDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::HL_DATE, $hlDate, $comparison);
    }

    /**
     * Filter the query on the social_date column
     *
     * Example usage:
     * <code>
     * $query->filterBySocialDate('2011-03-14'); // WHERE social_date = '2011-03-14'
     * $query->filterBySocialDate('now'); // WHERE social_date = '2011-03-14'
     * $query->filterBySocialDate(array('max' => 'yesterday')); // WHERE social_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $socialDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterBySocialDate($socialDate = null, $comparison = null)
    {
        if (is_array($socialDate)) {
            $useMinMax = false;
            if (isset($socialDate['min'])) {
                $this->addUsingAlias(AdvsPeer::SOCIAL_DATE, $socialDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($socialDate['max'])) {
                $this->addUsingAlias(AdvsPeer::SOCIAL_DATE, $socialDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::SOCIAL_DATE, $socialDate, $comparison);
    }

    /**
     * Filter the query on the yandex_date column
     *
     * Example usage:
     * <code>
     * $query->filterByYandexDate('2011-03-14'); // WHERE yandex_date = '2011-03-14'
     * $query->filterByYandexDate('now'); // WHERE yandex_date = '2011-03-14'
     * $query->filterByYandexDate(array('max' => 'yesterday')); // WHERE yandex_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $yandexDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByYandexDate($yandexDate = null, $comparison = null)
    {
        if (is_array($yandexDate)) {
            $useMinMax = false;
            if (isset($yandexDate['min'])) {
                $this->addUsingAlias(AdvsPeer::YANDEX_DATE, $yandexDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($yandexDate['max'])) {
                $this->addUsingAlias(AdvsPeer::YANDEX_DATE, $yandexDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::YANDEX_DATE, $yandexDate, $comparison);
    }

    /**
     * Filter the query on the yandex_index_date column
     *
     * Example usage:
     * <code>
     * $query->filterByYandexIndexDate('2011-03-14'); // WHERE yandex_index_date = '2011-03-14'
     * $query->filterByYandexIndexDate('now'); // WHERE yandex_index_date = '2011-03-14'
     * $query->filterByYandexIndexDate(array('max' => 'yesterday')); // WHERE yandex_index_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $yandexIndexDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByYandexIndexDate($yandexIndexDate = null, $comparison = null)
    {
        if (is_array($yandexIndexDate)) {
            $useMinMax = false;
            if (isset($yandexIndexDate['min'])) {
                $this->addUsingAlias(AdvsPeer::YANDEX_INDEX_DATE, $yandexIndexDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($yandexIndexDate['max'])) {
                $this->addUsingAlias(AdvsPeer::YANDEX_INDEX_DATE, $yandexIndexDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::YANDEX_INDEX_DATE, $yandexIndexDate, $comparison);
    }

    /**
     * Filter the query on the yandex_ping column
     *
     * Example usage:
     * <code>
     * $query->filterByYandexPing(1234); // WHERE yandex_ping = 1234
     * $query->filterByYandexPing(array(12, 34)); // WHERE yandex_ping IN (12, 34)
     * $query->filterByYandexPing(array('min' => 12)); // WHERE yandex_ping >= 12
     * $query->filterByYandexPing(array('max' => 12)); // WHERE yandex_ping <= 12
     * </code>
     *
     * @param     mixed $yandexPing The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByYandexPing($yandexPing = null, $comparison = null)
    {
        if (is_array($yandexPing)) {
            $useMinMax = false;
            if (isset($yandexPing['min'])) {
                $this->addUsingAlias(AdvsPeer::YANDEX_PING, $yandexPing['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($yandexPing['max'])) {
                $this->addUsingAlias(AdvsPeer::YANDEX_PING, $yandexPing['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::YANDEX_PING, $yandexPing, $comparison);
    }

    /**
     * Filter the query on the google_date column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogleDate('2011-03-14'); // WHERE google_date = '2011-03-14'
     * $query->filterByGoogleDate('now'); // WHERE google_date = '2011-03-14'
     * $query->filterByGoogleDate(array('max' => 'yesterday')); // WHERE google_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $googleDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByGoogleDate($googleDate = null, $comparison = null)
    {
        if (is_array($googleDate)) {
            $useMinMax = false;
            if (isset($googleDate['min'])) {
                $this->addUsingAlias(AdvsPeer::GOOGLE_DATE, $googleDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($googleDate['max'])) {
                $this->addUsingAlias(AdvsPeer::GOOGLE_DATE, $googleDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::GOOGLE_DATE, $googleDate, $comparison);
    }

    /**
     * Filter the query on the google_index_date column
     *
     * Example usage:
     * <code>
     * $query->filterByGoogleIndexDate('2011-03-14'); // WHERE google_index_date = '2011-03-14'
     * $query->filterByGoogleIndexDate('now'); // WHERE google_index_date = '2011-03-14'
     * $query->filterByGoogleIndexDate(array('max' => 'yesterday')); // WHERE google_index_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $googleIndexDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByGoogleIndexDate($googleIndexDate = null, $comparison = null)
    {
        if (is_array($googleIndexDate)) {
            $useMinMax = false;
            if (isset($googleIndexDate['min'])) {
                $this->addUsingAlias(AdvsPeer::GOOGLE_INDEX_DATE, $googleIndexDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($googleIndexDate['max'])) {
                $this->addUsingAlias(AdvsPeer::GOOGLE_INDEX_DATE, $googleIndexDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::GOOGLE_INDEX_DATE, $googleIndexDate, $comparison);
    }

    /**
     * Filter the query on the create_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCreateDate('2011-03-14'); // WHERE create_date = '2011-03-14'
     * $query->filterByCreateDate('now'); // WHERE create_date = '2011-03-14'
     * $query->filterByCreateDate(array('max' => 'yesterday')); // WHERE create_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $createDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByCreateDate($createDate = null, $comparison = null)
    {
        if (is_array($createDate)) {
            $useMinMax = false;
            if (isset($createDate['min'])) {
                $this->addUsingAlias(AdvsPeer::CREATE_DATE, $createDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createDate['max'])) {
                $this->addUsingAlias(AdvsPeer::CREATE_DATE, $createDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::CREATE_DATE, $createDate, $comparison);
    }

    /**
     * Filter the query on the publish_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishDate('2011-03-14'); // WHERE publish_date = '2011-03-14'
     * $query->filterByPublishDate('now'); // WHERE publish_date = '2011-03-14'
     * $query->filterByPublishDate(array('max' => 'yesterday')); // WHERE publish_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $publishDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByPublishDate($publishDate = null, $comparison = null)
    {
        if (is_array($publishDate)) {
            $useMinMax = false;
            if (isset($publishDate['min'])) {
                $this->addUsingAlias(AdvsPeer::PUBLISH_DATE, $publishDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishDate['max'])) {
                $this->addUsingAlias(AdvsPeer::PUBLISH_DATE, $publishDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::PUBLISH_DATE, $publishDate, $comparison);
    }

    /**
     * Filter the query on the publish_before_date column
     *
     * Example usage:
     * <code>
     * $query->filterByPublishBeforeDate('2011-03-14'); // WHERE publish_before_date = '2011-03-14'
     * $query->filterByPublishBeforeDate('now'); // WHERE publish_before_date = '2011-03-14'
     * $query->filterByPublishBeforeDate(array('max' => 'yesterday')); // WHERE publish_before_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $publishBeforeDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByPublishBeforeDate($publishBeforeDate = null, $comparison = null)
    {
        if (is_array($publishBeforeDate)) {
            $useMinMax = false;
            if (isset($publishBeforeDate['min'])) {
                $this->addUsingAlias(AdvsPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($publishBeforeDate['max'])) {
                $this->addUsingAlias(AdvsPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::PUBLISH_BEFORE_DATE, $publishBeforeDate, $comparison);
    }

    /**
     * Filter the query on the last_view_date column
     *
     * Example usage:
     * <code>
     * $query->filterByLastViewDate('2011-03-14'); // WHERE last_view_date = '2011-03-14'
     * $query->filterByLastViewDate('now'); // WHERE last_view_date = '2011-03-14'
     * $query->filterByLastViewDate(array('max' => 'yesterday')); // WHERE last_view_date < '2011-03-13'
     * </code>
     *
     * @param     mixed $lastViewDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function filterByLastViewDate($lastViewDate = null, $comparison = null)
    {
        if (is_array($lastViewDate)) {
            $useMinMax = false;
            if (isset($lastViewDate['min'])) {
                $this->addUsingAlias(AdvsPeer::LAST_VIEW_DATE, $lastViewDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastViewDate['max'])) {
                $this->addUsingAlias(AdvsPeer::LAST_VIEW_DATE, $lastViewDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AdvsPeer::LAST_VIEW_DATE, $lastViewDate, $comparison);
    }

    /**
     * Filter the query by a related Regions object
     *
     * @param   Regions|PropelObjectCollection $regions The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByRegions($regions, $comparison = null)
    {
        if ($regions instanceof Regions) {
            return $this
                ->addUsingAlias(AdvsPeer::REGION_ID, $regions->getId(), $comparison);
        } elseif ($regions instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvsPeer::REGION_ID, $regions->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByRegions() only accepts arguments of type Regions or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Regions relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinRegions($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Regions');

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
            $this->addJoinObject($join, 'Regions');
        }

        return $this;
    }

    /**
     * Use the Regions relation Regions object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\RegionsQuery A secondary query class using the current class as primary query
     */
    public function useRegionsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRegions($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Regions', '\Admin\AdminBundle\Model\RegionsQuery');
    }

    /**
     * Filter the query by a related Areas object
     *
     * @param   Areas|PropelObjectCollection $areas The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAreas($areas, $comparison = null)
    {
        if ($areas instanceof Areas) {
            return $this
                ->addUsingAlias(AdvsPeer::AREA_ID, $areas->getId(), $comparison);
        } elseif ($areas instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvsPeer::AREA_ID, $areas->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAreas() only accepts arguments of type Areas or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Areas relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAreas($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Areas');

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
            $this->addJoinObject($join, 'Areas');
        }

        return $this;
    }

    /**
     * Use the Areas relation Areas object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AreasQuery A secondary query class using the current class as primary query
     */
    public function useAreasQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAreas($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Areas', '\Admin\AdminBundle\Model\AreasQuery');
    }

    /**
     * Filter the query by a related User object
     *
     * @param   User|PropelObjectCollection $user The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof User) {
            return $this
                ->addUsingAlias(AdvsPeer::USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvsPeer::USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
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
     * Filter the query by a related Shops object
     *
     * @param   Shops|PropelObjectCollection $shops The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByShops($shops, $comparison = null)
    {
        if ($shops instanceof Shops) {
            return $this
                ->addUsingAlias(AdvsPeer::SHOP_ID, $shops->getId(), $comparison);
        } elseif ($shops instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvsPeer::SHOP_ID, $shops->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByShops() only accepts arguments of type Shops or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Shops relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinShops($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Shops');

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
            $this->addJoinObject($join, 'Shops');
        }

        return $this;
    }

    /**
     * Use the Shops relation Shops object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\ShopsQuery A secondary query class using the current class as primary query
     */
    public function useShopsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinShops($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Shops', '\Admin\AdminBundle\Model\ShopsQuery');
    }

    /**
     * Filter the query by a related AdCategories object
     *
     * @param   AdCategories|PropelObjectCollection $adCategories The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdCategories($adCategories, $comparison = null)
    {
        if ($adCategories instanceof AdCategories) {
            return $this
                ->addUsingAlias(AdvsPeer::CATEGORY_ID, $adCategories->getId(), $comparison);
        } elseif ($adCategories instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AdvsPeer::CATEGORY_ID, $adCategories->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByAdCategories() only accepts arguments of type AdCategories or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdCategories relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdCategories($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdCategories');

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
            $this->addJoinObject($join, 'AdCategories');
        }

        return $this;
    }

    /**
     * Use the AdCategories relation AdCategories object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdCategoriesQuery A secondary query class using the current class as primary query
     */
    public function useAdCategoriesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdCategories($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdCategories', '\Admin\AdminBundle\Model\AdCategoriesQuery');
    }

    /**
     * Filter the query by a related AdvPrice object
     *
     * @param   AdvPrice|PropelObjectCollection $advPrice  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvPrice($advPrice, $comparison = null)
    {
        if ($advPrice instanceof AdvPrice) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advPrice->getAdvId(), $comparison);
        } elseif ($advPrice instanceof PropelObjectCollection) {
            return $this
                ->useAdvPriceQuery()
                ->filterByPrimaryKeys($advPrice->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvPrice() only accepts arguments of type AdvPrice or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvPrice relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvPrice($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvPrice');

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
            $this->addJoinObject($join, 'AdvPrice');
        }

        return $this;
    }

    /**
     * Use the AdvPrice relation AdvPrice object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvPriceQuery A secondary query class using the current class as primary query
     */
    public function useAdvPriceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvPrice($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvPrice', '\Admin\AdminBundle\Model\AdvPriceQuery');
    }

    /**
     * Filter the query by a related AdvsStat object
     *
     * @param   AdvsStat|PropelObjectCollection $advsStat  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvsStat($advsStat, $comparison = null)
    {
        if ($advsStat instanceof AdvsStat) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advsStat->getAdvId(), $comparison);
        } elseif ($advsStat instanceof PropelObjectCollection) {
            return $this
                ->useAdvsStatQuery()
                ->filterByPrimaryKeys($advsStat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvsStat() only accepts arguments of type AdvsStat or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvsStat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvsStat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvsStat');

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
            $this->addJoinObject($join, 'AdvsStat');
        }

        return $this;
    }

    /**
     * Use the AdvsStat relation AdvsStat object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvsStatQuery A secondary query class using the current class as primary query
     */
    public function useAdvsStatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvsStat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvsStat', '\Admin\AdminBundle\Model\AdvsStatQuery');
    }

    /**
     * Filter the query by a related AdvsModerStat object
     *
     * @param   AdvsModerStat|PropelObjectCollection $advsModerStat  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvsModerStat($advsModerStat, $comparison = null)
    {
        if ($advsModerStat instanceof AdvsModerStat) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advsModerStat->getAdvId(), $comparison);
        } elseif ($advsModerStat instanceof PropelObjectCollection) {
            return $this
                ->useAdvsModerStatQuery()
                ->filterByPrimaryKeys($advsModerStat->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvsModerStat() only accepts arguments of type AdvsModerStat or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvsModerStat relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvsModerStat($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvsModerStat');

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
            $this->addJoinObject($join, 'AdvsModerStat');
        }

        return $this;
    }

    /**
     * Use the AdvsModerStat relation AdvsModerStat object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvsModerStatQuery A secondary query class using the current class as primary query
     */
    public function useAdvsModerStatQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvsModerStat($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvsModerStat', '\Admin\AdminBundle\Model\AdvsModerStatQuery');
    }

    /**
     * Filter the query by a related AdvParams object
     *
     * @param   AdvParams|PropelObjectCollection $advParams  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvParams($advParams, $comparison = null)
    {
        if ($advParams instanceof AdvParams) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advParams->getAdvId(), $comparison);
        } elseif ($advParams instanceof PropelObjectCollection) {
            return $this
                ->useAdvParamsQuery()
                ->filterByPrimaryKeys($advParams->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvParams() only accepts arguments of type AdvParams or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvParams relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvParams($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvParams');

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
            $this->addJoinObject($join, 'AdvParams');
        }

        return $this;
    }

    /**
     * Use the AdvParams relation AdvParams object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvParamsQuery A secondary query class using the current class as primary query
     */
    public function useAdvParamsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvParams($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvParams', '\Admin\AdminBundle\Model\AdvParamsQuery');
    }

    /**
     * Filter the query by a related AdvImages object
     *
     * @param   AdvImages|PropelObjectCollection $advImages  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvImages($advImages, $comparison = null)
    {
        if ($advImages instanceof AdvImages) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advImages->getAdvId(), $comparison);
        } elseif ($advImages instanceof PropelObjectCollection) {
            return $this
                ->useAdvImagesQuery()
                ->filterByPrimaryKeys($advImages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvImages() only accepts arguments of type AdvImages or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvImages relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvImages($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvImages');

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
            $this->addJoinObject($join, 'AdvImages');
        }

        return $this;
    }

    /**
     * Use the AdvImages relation AdvImages object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvImagesQuery A secondary query class using the current class as primary query
     */
    public function useAdvImagesQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvImages($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvImages', '\Admin\AdminBundle\Model\AdvImagesQuery');
    }

    /**
     * Filter the query by a related AdvVideos object
     *
     * @param   AdvVideos|PropelObjectCollection $advVideos  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvVideos($advVideos, $comparison = null)
    {
        if ($advVideos instanceof AdvVideos) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advVideos->getAdvId(), $comparison);
        } elseif ($advVideos instanceof PropelObjectCollection) {
            return $this
                ->useAdvVideosQuery()
                ->filterByPrimaryKeys($advVideos->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvVideos() only accepts arguments of type AdvVideos or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvVideos relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvVideos($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvVideos');

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
            $this->addJoinObject($join, 'AdvVideos');
        }

        return $this;
    }

    /**
     * Use the AdvVideos relation AdvVideos object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvVideosQuery A secondary query class using the current class as primary query
     */
    public function useAdvVideosQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvVideos($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvVideos', '\Admin\AdminBundle\Model\AdvVideosQuery');
    }

    /**
     * Filter the query by a related AdvPackets object
     *
     * @param   AdvPackets|PropelObjectCollection $advPackets  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvPackets($advPackets, $comparison = null)
    {
        if ($advPackets instanceof AdvPackets) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advPackets->getAdvId(), $comparison);
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
     * @return AdvsQuery The current query, for fluid interface
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
     * Filter the query by a related AdvComments object
     *
     * @param   AdvComments|PropelObjectCollection $advComments  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvComments($advComments, $comparison = null)
    {
        if ($advComments instanceof AdvComments) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advComments->getAdvId(), $comparison);
        } elseif ($advComments instanceof PropelObjectCollection) {
            return $this
                ->useAdvCommentsQuery()
                ->filterByPrimaryKeys($advComments->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvComments() only accepts arguments of type AdvComments or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvComments relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvComments($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvComments');

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
            $this->addJoinObject($join, 'AdvComments');
        }

        return $this;
    }

    /**
     * Use the AdvComments relation AdvComments object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvCommentsQuery A secondary query class using the current class as primary query
     */
    public function useAdvCommentsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAdvComments($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvComments', '\Admin\AdminBundle\Model\AdvCommentsQuery');
    }

    /**
     * Filter the query by a related AdvComplaine object
     *
     * @param   AdvComplaine|PropelObjectCollection $advComplaine  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAdvComplaine($advComplaine, $comparison = null)
    {
        if ($advComplaine instanceof AdvComplaine) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $advComplaine->getAdvId(), $comparison);
        } elseif ($advComplaine instanceof PropelObjectCollection) {
            return $this
                ->useAdvComplaineQuery()
                ->filterByPrimaryKeys($advComplaine->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAdvComplaine() only accepts arguments of type AdvComplaine or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AdvComplaine relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinAdvComplaine($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AdvComplaine');

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
            $this->addJoinObject($join, 'AdvComplaine');
        }

        return $this;
    }

    /**
     * Use the AdvComplaine relation AdvComplaine object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\AdvComplaineQuery A secondary query class using the current class as primary query
     */
    public function useAdvComplaineQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAdvComplaine($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AdvComplaine', '\Admin\AdminBundle\Model\AdvComplaineQuery');
    }

    /**
     * Filter the query by a related UserFavorite object
     *
     * @param   UserFavorite|PropelObjectCollection $userFavorite  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AdvsQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByUserFavorite($userFavorite, $comparison = null)
    {
        if ($userFavorite instanceof UserFavorite) {
            return $this
                ->addUsingAlias(AdvsPeer::ID, $userFavorite->getAdvId(), $comparison);
        } elseif ($userFavorite instanceof PropelObjectCollection) {
            return $this
                ->useUserFavoriteQuery()
                ->filterByPrimaryKeys($userFavorite->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserFavorite() only accepts arguments of type UserFavorite or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserFavorite relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function joinUserFavorite($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserFavorite');

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
            $this->addJoinObject($join, 'UserFavorite');
        }

        return $this;
    }

    /**
     * Use the UserFavorite relation UserFavorite object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Admin\AdminBundle\Model\UserFavoriteQuery A secondary query class using the current class as primary query
     */
    public function useUserFavoriteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserFavorite($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserFavorite', '\Admin\AdminBundle\Model\UserFavoriteQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Advs $advs Object to remove from the list of results
     *
     * @return AdvsQuery The current query, for fluid interface
     */
    public function prune($advs = null)
    {
        if ($advs) {
            $this->addUsingAlias(AdvsPeer::ID, $advs->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
