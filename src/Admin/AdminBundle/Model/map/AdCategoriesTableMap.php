<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'ad_categories' table.
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
class AdCategoriesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.AdCategoriesTableMap';

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
        $this->setName('ad_categories');
        $this->setPhpName('AdCategories');
        $this->setClassname('Admin\\AdminBundle\\Model\\AdCategories');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('parent_id', 'ParentId', 'INTEGER', 'ad_categories', 'id', false, null, null);
        $this->addColumn('sort', 'Sort', 'INTEGER', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->getColumn('alias', false)->setPrimaryString(true);
        $this->addColumn('pagetitle', 'Pagetitle', 'VARCHAR', false, 255, null);
        $this->getColumn('pagetitle', false)->setPrimaryString(true);
        $this->addColumn('catch_phrase', 'CatchPhrase', 'VARCHAR', false, 255, null);
        $this->getColumn('catch_phrase', false)->setPrimaryString(true);
        $this->addColumn('direct_title', 'DirectTitle', 'VARCHAR', false, 256, null);
        $this->getColumn('direct_title', false)->setPrimaryString(true);
        $this->addColumn('text', 'Text', 'VARCHAR', false, 2000, null);
        $this->getColumn('text', false)->setPrimaryString(true);
        $this->addColumn('icon', 'Icon', 'VARCHAR', false, 255, null);
        $this->getColumn('icon', false)->setPrimaryString(true);
        $this->addColumn('generator', 'Generator', 'VARCHAR', false, 500, null);
        $this->getColumn('generator', false)->setPrimaryString(true);
        $this->addColumn('nametitle', 'Nametitle', 'VARCHAR', false, 255, null);
        $this->getColumn('nametitle', false)->setPrimaryString(true);
        $this->addColumn('desctitle', 'Desctitle', 'VARCHAR', false, 255, null);
        $this->getColumn('desctitle', false)->setPrimaryString(true);
        $this->addColumn('pricetitle', 'Pricetitle', 'VARCHAR', false, 255, null);
        $this->getColumn('pricetitle', false)->setPrimaryString(true);
        $this->addColumn('use_dogovor', 'UseDogovor', 'BOOLEAN', false, 1, true);
        $this->addColumn('use_torg', 'UseTorg', 'BOOLEAN', false, 1, true);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        $this->addColumn('usemap', 'Usemap', 'BOOLEAN', false, 1, false);
        $this->addColumn('onmain', 'Onmain', 'BOOLEAN', false, 1, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AdCategoriesRelatedByParentId', 'Admin\\AdminBundle\\Model\\AdCategories', RelationMap::MANY_TO_ONE, array('parent_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('AdChilds', 'Admin\\AdminBundle\\Model\\AdCategories', RelationMap::ONE_TO_MANY, array('id' => 'parent_id', ), 'CASCADE', null, 'AdChildss');
        $this->addRelation('AdCategoriesFields', 'Admin\\AdminBundle\\Model\\AdCategoriesFields', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), 'CASCADE', null, 'AdCategoriesFieldss');
        $this->addRelation('AdCategoriesSubscribe', 'Admin\\AdminBundle\\Model\\AdCategoriesSubscribe', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), 'CASCADE', null, 'AdCategoriesSubscribes');
        $this->addRelation('Advs', 'Admin\\AdminBundle\\Model\\Advs', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), 'CASCADE', null, 'Advss');
    } // buildRelations()

} // AdCategoriesTableMap
