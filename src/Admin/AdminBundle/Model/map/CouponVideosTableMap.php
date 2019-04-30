<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'coupon_videos' table.
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
class CouponVideosTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.CouponVideosTableMap';

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
        $this->setName('coupon_videos');
        $this->setPhpName('CouponVideos');
        $this->setClassname('Admin\\AdminBundle\\Model\\CouponVideos');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('coupon_id', 'CouponId', 'INTEGER', 'coupons', 'id', true, null, null);
        $this->addColumn('path', 'Path', 'VARCHAR', false, 255, null);
        $this->addColumn('thumb', 'Thumb', 'VARCHAR', false, 255, null);
        $this->addColumn('temp_id', 'TempId', 'VARCHAR', false, 255, null);
        $this->addColumn('upload_date', 'UploadDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Coupons', 'Admin\\AdminBundle\\Model\\Coupons', RelationMap::MANY_TO_ONE, array('coupon_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // CouponVideosTableMap
