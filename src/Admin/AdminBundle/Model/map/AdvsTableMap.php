<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'advs' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Admin.AdminBundle.Model.map
 */
class AdvsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.AdvsTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('advs');
        $this->setPhpName('Advs');
        $this->setClassname('Admin\\AdminBundle\\Model\\Advs');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'ad_categories', 'id', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'fos_user', 'id', true, null, null);
        $this->addColumn('user_type', 'UserType', 'INTEGER', true, null, 1);
        $this->addColumn('company_name', 'CompanyName', 'VARCHAR', false, 255, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('price', 'Price', 'INTEGER', false, null, null);
        $this->addColumn('dogovor', 'Dogovor', 'BOOLEAN', false, 1, false);
        $this->addColumn('torg', 'Torg', 'BOOLEAN', false, 1, false);
        $this->addForeignKey('region_id', 'RegionId', 'INTEGER', 'regions', 'id', true, null, null);
        $this->addForeignKey('area_id', 'AreaId', 'INTEGER', 'areas', 'id', false, null, null);
        $this->addForeignKey('shop_id', 'ShopId', 'INTEGER', 'shops', 'id', false, null, null);
        $this->addColumn('cnt', 'Cnt', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_today', 'CntToday', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_tel', 'CntTel', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_tel_today', 'CntTelToday', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_skype', 'CntSkype', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_site', 'CntSite', 'INTEGER', false, null, 0);
        $this->addColumn('coord', 'Coord', 'VARCHAR', false, 255, null);
        $this->addColumn('site', 'Site', 'VARCHAR', false, 255, null);
        $this->addColumn('skype', 'Skype', 'VARCHAR', false, 255, null);
        $this->addColumn('youtube', 'Youtube', 'VARCHAR', false, 255, null);
        $this->addColumn('digest', 'Digest', 'BOOLEAN', false, 1, false);
        $this->addColumn('moder_approved', 'ModerApproved', 'BOOLEAN', false, 1, false);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        $this->addColumn('twitter', 'Twitter', 'INTEGER', false, null, 0);
        $this->addColumn('facebook', 'Facebook', 'INTEGER', false, null, 0);
        $this->addColumn('vk', 'Vk', 'INTEGER', false, null, 0);
        $this->addColumn('vk_share', 'VkShare', 'INTEGER', false, null, 0);
        $this->addColumn('google', 'Google', 'INTEGER', false, null, 0);
        $this->addColumn('mailru', 'Mailru', 'INTEGER', false, null, 0);
        $this->addColumn('odnoklassniki', 'Odnoklassniki', 'INTEGER', false, null, 0);
        $this->addColumn('yandex_partner', 'YandexPartner', 'BOOLEAN', false, 1, true);
        $this->addColumn('up_date', 'UpDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('hl_date', 'HlDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('social_date', 'SocialDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('yandex_date', 'YandexDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('yandex_index_date', 'YandexIndexDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('yandex_ping', 'YandexPing', 'INTEGER', false, null, 0);
        $this->addColumn('google_date', 'GoogleDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('google_index_date', 'GoogleIndexDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('create_date', 'CreateDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('publish_date', 'PublishDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('publish_before_date', 'PublishBeforeDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_view_date', 'LastViewDate', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Regions', 'Admin\\AdminBundle\\Model\\Regions', RelationMap::MANY_TO_ONE, array('region_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Areas', 'Admin\\AdminBundle\\Model\\Areas', RelationMap::MANY_TO_ONE, array('area_id' => 'id', ), null, null);
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Shops', 'Admin\\AdminBundle\\Model\\Shops', RelationMap::MANY_TO_ONE, array('shop_id' => 'id', ), null, null);
        $this->addRelation('AdCategories', 'Admin\\AdminBundle\\Model\\AdCategories', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('AdvPrice', 'Admin\\AdminBundle\\Model\\AdvPrice', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvPrices');
        $this->addRelation('AdvsStat', 'Admin\\AdminBundle\\Model\\AdvsStat', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvsStats');
        $this->addRelation('AdvsModerStat', 'Admin\\AdminBundle\\Model\\AdvsModerStat', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvsModerStats');
        $this->addRelation('AdvParams', 'Admin\\AdminBundle\\Model\\AdvParams', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvParamss');
        $this->addRelation('AdvImages', 'Admin\\AdminBundle\\Model\\AdvImages', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvImagess');
        $this->addRelation('AdvVideos', 'Admin\\AdminBundle\\Model\\AdvVideos', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvVideoss');
        $this->addRelation('AdvPackets', 'Admin\\AdminBundle\\Model\\AdvPackets', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvPacketss');
        $this->addRelation('AdvComments', 'Admin\\AdminBundle\\Model\\AdvComments', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvCommentss');
        $this->addRelation('AdvComplaine', 'Admin\\AdminBundle\\Model\\AdvComplaine', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'AdvComplaines');
        $this->addRelation('UserFavorite', 'Admin\\AdminBundle\\Model\\UserFavorite', RelationMap::ONE_TO_MANY, array('id' => 'adv_id', ), 'CASCADE', null, 'UserFavorites');
    } // buildRelations()

} // AdvsTableMap
