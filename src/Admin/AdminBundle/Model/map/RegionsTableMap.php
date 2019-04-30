<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'regions' table.
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
class RegionsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.RegionsTableMap';

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
        $this->setName('regions');
        $this->setPhpName('Regions');
        $this->setClassname('Admin\\AdminBundle\\Model\\Regions');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addForeignKey('area_id', 'AreaId', 'INTEGER', 'areas', 'id', false, null, null);
        $this->addColumn('pagetitle', 'Pagetitle', 'VARCHAR', false, 255, null);
        $this->getColumn('pagetitle', false)->setPrimaryString(true);
        $this->addColumn('net', 'Net', 'VARCHAR', false, 255, null);
        $this->getColumn('net', false)->setPrimaryString(true);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->getColumn('alias', false)->setPrimaryString(true);
        $this->addColumn('icon', 'Icon', 'VARCHAR', false, 255, null);
        $this->getColumn('icon', false)->setPrimaryString(true);
        $this->addColumn('type', 'Type', 'INTEGER', false, null, null);
        $this->addColumn('weather', 'Weather', 'INTEGER', false, null, null);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Areas', 'Admin\\AdminBundle\\Model\\Areas', RelationMap::MANY_TO_ONE, array('area_id' => 'id', ), null, null);
        $this->addRelation('AdCategoriesSubscribe', 'Admin\\AdminBundle\\Model\\AdCategoriesSubscribe', RelationMap::ONE_TO_MANY, array('id' => 'town_id', ), 'CASCADE', null, 'AdCategoriesSubscribes');
        $this->addRelation('Advs', 'Admin\\AdminBundle\\Model\\Advs', RelationMap::ONE_TO_MANY, array('id' => 'region_id', ), 'CASCADE', null, 'Advss');
        $this->addRelation('Shops', 'Admin\\AdminBundle\\Model\\Shops', RelationMap::ONE_TO_MANY, array('id' => 'region_id', ), 'CASCADE', null, 'Shopss');
    } // buildRelations()

} // RegionsTableMap
