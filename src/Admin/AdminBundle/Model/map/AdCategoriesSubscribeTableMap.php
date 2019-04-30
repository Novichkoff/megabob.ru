<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'ad_categories_subscribe' table.
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
class AdCategoriesSubscribeTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.AdCategoriesSubscribeTableMap';

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
        $this->setName('ad_categories_subscribe');
        $this->setPhpName('AdCategoriesSubscribe');
        $this->setClassname('Admin\\AdminBundle\\Model\\AdCategoriesSubscribe');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'ad_categories', 'id', true, null, null);
        $this->addForeignKey('town_id', 'TownId', 'INTEGER', 'regions', 'id', false, null, null);
        $this->addForeignKey('area_id', 'AreaId', 'INTEGER', 'areas', 'id', false, null, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 255, null);
        $this->addColumn('unsubscribe_code', 'UnsubscribeCode', 'VARCHAR', false, 255, null);
        $this->addColumn('last_adv_id', 'LastAdvId', 'INTEGER', false, null, null);
        $this->addColumn('cnt', 'Cnt', 'INTEGER', false, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AdCategories', 'Admin\\AdminBundle\\Model\\AdCategories', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Regions', 'Admin\\AdminBundle\\Model\\Regions', RelationMap::MANY_TO_ONE, array('town_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Areas', 'Admin\\AdminBundle\\Model\\Areas', RelationMap::MANY_TO_ONE, array('area_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // AdCategoriesSubscribeTableMap
