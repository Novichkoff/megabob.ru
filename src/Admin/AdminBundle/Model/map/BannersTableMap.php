<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'banners' table.
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
class BannersTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.BannersTableMap';

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
        $this->setName('banners');
        $this->setPhpName('Banners');
        $this->setClassname('Admin\\AdminBundle\\Model\\Banners');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('category_id', 'CategoryId', 'VARCHAR', false, 255, '0');
        $this->addColumn('region_id', 'RegionId', 'INTEGER', false, null, 0);
        $this->addColumn('client', 'Client', 'VARCHAR', false, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('code', 'Code', 'LONGVARCHAR', false, null, null);
        $this->addColumn('picture', 'Picture', 'VARCHAR', false, 255, null);
        $this->addColumn('width', 'Width', 'INTEGER', false, null, 640);
        $this->addColumn('cnt', 'Cnt', 'INTEGER', false, null, 0);
        $this->addColumn('show_today', 'ShowToday', 'INTEGER', false, null, 0);
        $this->addColumn('click_today', 'ClickToday', 'INTEGER', false, null, 0);
        $this->addColumn('banner_zone_id', 'BannerZoneId', 'INTEGER', false, null, null);
        $this->addColumn('mobile', 'Mobile', 'BOOLEAN', false, 1, false);
        $this->addColumn('full_size', 'FullSize', 'BOOLEAN', false, 1, false);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        $this->addColumn('last_publish', 'LastPublish', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('publish_date', 'PublishDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('publish_before_date', 'PublishBeforeDate', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('BannersStat', 'Admin\\AdminBundle\\Model\\BannersStat', RelationMap::ONE_TO_MANY, array('id' => 'banner_id', ), 'CASCADE', null, 'BannersStats');
    } // buildRelations()

} // BannersTableMap
