<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'shops' table.
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
class ShopsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.ShopsTableMap';

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
        $this->setName('shops');
        $this->setPhpName('Shops');
        $this->setClassname('Admin\\AdminBundle\\Model\\Shops');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->addColumn('icon', 'Icon', 'VARCHAR', false, 255, null);
        $this->getColumn('icon', false)->setPrimaryString(true);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 255, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addForeignKey('fos_user_id', 'FosUserId', 'INTEGER', 'fos_user', 'id', true, null, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 255, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 255, null);
        $this->addColumn('site', 'Site', 'VARCHAR', false, 255, null);
        $this->addForeignKey('region_id', 'RegionId', 'INTEGER', 'regions', 'id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Regions', 'Admin\\AdminBundle\\Model\\Regions', RelationMap::MANY_TO_ONE, array('region_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('fos_user_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Advs', 'Admin\\AdminBundle\\Model\\Advs', RelationMap::ONE_TO_MANY, array('id' => 'shop_id', ), null, null, 'Advss');
    } // buildRelations()

} // ShopsTableMap
