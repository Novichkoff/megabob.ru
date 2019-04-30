<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'areas' table.
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
class AreasTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.AreasTableMap';

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
        $this->setName('areas');
        $this->setPhpName('Areas');
        $this->setClassname('Admin\\AdminBundle\\Model\\Areas');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('code', 'Code', 'INTEGER', false, null, null);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->getColumn('alias', false)->setPrimaryString(true);
        $this->addColumn('path', 'Path', 'LONGVARCHAR', false, null, null);
        $this->addColumn('part', 'Part', 'INTEGER', false, null, null);
        $this->addColumn('pagetitle', 'Pagetitle', 'VARCHAR', false, 255, null);
        $this->getColumn('pagetitle', false)->setPrimaryString(true);
        $this->addColumn('net', 'Net', 'VARCHAR', false, 255, null);
        $this->getColumn('net', false)->setPrimaryString(true);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Regions', 'Admin\\AdminBundle\\Model\\Regions', RelationMap::ONE_TO_MANY, array('id' => 'area_id', ), null, null, 'Regionss');
        $this->addRelation('AdCategoriesSubscribe', 'Admin\\AdminBundle\\Model\\AdCategoriesSubscribe', RelationMap::ONE_TO_MANY, array('id' => 'area_id', ), 'CASCADE', null, 'AdCategoriesSubscribes');
        $this->addRelation('Advs', 'Admin\\AdminBundle\\Model\\Advs', RelationMap::ONE_TO_MANY, array('id' => 'area_id', ), null, null, 'Advss');
    } // buildRelations()

} // AreasTableMap
