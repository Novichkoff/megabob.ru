<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'jobs' table.
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
class JobsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobsTableMap';

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
        $this->setName('jobs');
        $this->setPhpName('Jobs');
        $this->setClassname('Admin\\AdminBundle\\Model\\Jobs');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'job_categories', 'id', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'fos_user', 'id', true, null, null);
        $this->addColumn('user_type', 'UserType', 'INTEGER', true, null, 1);
        $this->addColumn('company_name', 'CompanyName', 'VARCHAR', false, 255, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('dogovor', 'Dogovor', 'BOOLEAN', false, 1, false);
        $this->addColumn('price_from', 'PriceFrom', 'INTEGER', false, null, null);
        $this->addColumn('price_to', 'PriceTo', 'INTEGER', false, null, null);
        $this->addColumn('resume', 'Resume', 'BOOLEAN', false, 1, false);
        $this->addForeignKey('region_id', 'RegionId', 'INTEGER', 'regions', 'id', true, null, null);
        $this->addColumn('area_id', 'AreaId', 'INTEGER', false, null, null);
        $this->addForeignKey('shop_id', 'ShopId', 'INTEGER', 'shops', 'id', false, null, null);
        $this->addColumn('cnt', 'Cnt', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_today', 'CntToday', 'INTEGER', false, null, 0);
        $this->addColumn('cnt_tel', 'CntTel', 'INTEGER', false, null, 0);
        $this->addColumn('moder_approved', 'ModerApproved', 'BOOLEAN', false, 1, false);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        $this->addColumn('create_date', 'CreateDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('publish_date', 'PublishDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('publish_before_date', 'PublishBeforeDate', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Regions', 'Admin\\AdminBundle\\Model\\Regions', RelationMap::MANY_TO_ONE, array('region_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobCategories', 'Admin\\AdminBundle\\Model\\JobCategories', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Shops', 'Admin\\AdminBundle\\Model\\Shops', RelationMap::MANY_TO_ONE, array('shop_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobParams', 'Admin\\AdminBundle\\Model\\JobParams', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null, 'JobParamss');
        $this->addRelation('JobImages', 'Admin\\AdminBundle\\Model\\JobImages', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null, 'JobImagess');
        $this->addRelation('JobVideos', 'Admin\\AdminBundle\\Model\\JobVideos', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null, 'JobVideoss');
        $this->addRelation('JobPackets', 'Admin\\AdminBundle\\Model\\JobPackets', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null, 'JobPacketss');
        $this->addRelation('JobComments', 'Admin\\AdminBundle\\Model\\JobComments', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null, 'JobCommentss');
        $this->addRelation('JobRestRelatedByJobId', 'Admin\\AdminBundle\\Model\\JobRest', RelationMap::ONE_TO_MANY, array('id' => 'job_id', ), 'CASCADE', null, 'JobRestsRelatedByJobId');
        $this->addRelation('JobRestRelatedByVacancyId', 'Admin\\AdminBundle\\Model\\JobRest', RelationMap::ONE_TO_MANY, array('id' => 'vacancy_id', ), 'CASCADE', null, 'JobRestsRelatedByVacancyId');
    } // buildRelations()

} // JobsTableMap
