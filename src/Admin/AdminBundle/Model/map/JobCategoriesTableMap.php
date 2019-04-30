<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'job_categories' table.
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
class JobCategoriesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobCategoriesTableMap';

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
        $this->setName('job_categories');
        $this->setPhpName('JobCategories');
        $this->setClassname('Admin\\AdminBundle\\Model\\JobCategories');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('parent_id', 'ParentId', 'INTEGER', 'job_categories', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->getColumn('alias', false)->setPrimaryString(true);
        $this->addColumn('pagetitle', 'Pagetitle', 'VARCHAR', false, 255, null);
        $this->getColumn('pagetitle', false)->setPrimaryString(true);
        $this->addColumn('catch_phrase', 'CatchPhrase', 'VARCHAR', false, 255, null);
        $this->getColumn('catch_phrase', false)->setPrimaryString(true);
        $this->addColumn('icon', 'Icon', 'VARCHAR', false, 255, null);
        $this->getColumn('icon', false)->setPrimaryString(true);
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
        $this->addRelation('JobCategoriesRelatedByParentId', 'Admin\\AdminBundle\\Model\\JobCategories', RelationMap::MANY_TO_ONE, array('parent_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobChilds', 'Admin\\AdminBundle\\Model\\JobCategories', RelationMap::ONE_TO_MANY, array('id' => 'parent_id', ), 'CASCADE', null, 'JobChildss');
        $this->addRelation('JobCategoriesFields', 'Admin\\AdminBundle\\Model\\JobCategoriesFields', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), 'CASCADE', null, 'JobCategoriesFieldss');
        $this->addRelation('Jobs', 'Admin\\AdminBundle\\Model\\Jobs', RelationMap::ONE_TO_MANY, array('id' => 'category_id', ), 'CASCADE', null, 'Jobss');
    } // buildRelations()

} // JobCategoriesTableMap
