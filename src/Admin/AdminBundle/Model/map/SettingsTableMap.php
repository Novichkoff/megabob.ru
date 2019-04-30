<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'settings' table.
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
class SettingsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.SettingsTableMap';

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
        $this->setName('settings');
        $this->setPhpName('Settings');
        $this->setClassname('Admin\\AdminBundle\\Model\\Settings');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 255, null);
        $this->getColumn('url', false)->setPrimaryString(true);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 255, null);
        $this->getColumn('title', false)->setPrimaryString(true);
        $this->addColumn('description', 'Description', 'VARCHAR', true, 255, null);
        $this->addColumn('keywords', 'Keywords', 'VARCHAR', true, 255, null);
        $this->addColumn('logo', 'Logo', 'VARCHAR', false, 255, null);
        $this->getColumn('logo', false)->setPrimaryString(true);
        $this->addColumn('icon', 'Icon', 'VARCHAR', false, 255, null);
        $this->getColumn('icon', false)->setPrimaryString(true);
        $this->addColumn('content', 'Content', 'LONGVARCHAR', false, null, null);
        $this->addColumn('robots', 'Robots', 'LONGVARCHAR', false, null, null);
        $this->addColumn('counters', 'Counters', 'LONGVARCHAR', false, null, null);
        $this->addColumn('fb', 'Fb', 'VARCHAR', false, 255, null);
        $this->getColumn('fb', false)->setPrimaryString(true);
        $this->addColumn('vk', 'Vk', 'VARCHAR', false, 255, null);
        $this->getColumn('vk', false)->setPrimaryString(true);
        $this->addColumn('twitter', 'Twitter', 'VARCHAR', false, 255, null);
        $this->getColumn('twitter', false)->setPrimaryString(true);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // SettingsTableMap
