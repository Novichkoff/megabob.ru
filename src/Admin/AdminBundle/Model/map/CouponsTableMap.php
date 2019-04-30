<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'coupons' table.
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
class CouponsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.CouponsTableMap';

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
        $this->setName('coupons');
        $this->setPhpName('Coupons');
        $this->setClassname('Admin\\AdminBundle\\Model\\Coupons');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'coupons_categories', 'id', true, null, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        $this->addColumn('date', 'Date', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('use_before', 'UseBefore', 'TIMESTAMP', false, null, null);
        $this->addColumn('period', 'Period', 'INTEGER', false, null, 30);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 255, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 255, null);
        $this->addColumn('site', 'Site', 'VARCHAR', false, 255, null);
        $this->addColumn('time_work', 'TimeWork', 'LONGVARCHAR', false, null, null);
        $this->addColumn('client_name', 'ClientName', 'VARCHAR', false, 255, null);
        $this->addColumn('client_phone', 'ClientPhone', 'VARCHAR', false, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('full_description', 'FullDescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('price', 'Price', 'INTEGER', false, null, null);
        $this->addColumn('sale', 'Sale', 'INTEGER', false, null, null);
        $this->addColumn('price_old', 'PriceOld', 'INTEGER', false, null, null);
        $this->addForeignKey('region_id', 'RegionId', 'INTEGER', 'regions', 'id', true, null, null);
        $this->addColumn('cnt', 'Cnt', 'INTEGER', false, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Regions', 'Admin\\AdminBundle\\Model\\Regions', RelationMap::MANY_TO_ONE, array('region_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('CouponsCategories', 'Admin\\AdminBundle\\Model\\CouponsCategories', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('UserCoupons', 'Admin\\AdminBundle\\Model\\UserCoupons', RelationMap::ONE_TO_MANY, array('id' => 'coupon_id', ), 'CASCADE', null, 'UserCouponss');
        $this->addRelation('CouponImages', 'Admin\\AdminBundle\\Model\\CouponImages', RelationMap::ONE_TO_MANY, array('id' => 'coupon_id', ), 'CASCADE', null, 'CouponImagess');
        $this->addRelation('CouponVideos', 'Admin\\AdminBundle\\Model\\CouponVideos', RelationMap::ONE_TO_MANY, array('id' => 'coupon_id', ), 'CASCADE', null, 'CouponVideoss');
    } // buildRelations()

} // CouponsTableMap
