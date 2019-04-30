<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'job_categories_fields' table.
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
class JobCategoriesFieldsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobCategoriesFieldsTableMap';

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
        $this->setName('job_categories_fields');
        $this->setPhpName('JobCategoriesFields');
        $this->setClassname('Admin\\AdminBundle\\Model\\JobCategoriesFields');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('category_id', 'CategoryId', 'INTEGER', 'job_categories', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('type', 'Type', 'INTEGER', false, null, null);
        $this->addForeignKey('parent_field_id', 'ParentFieldId', 'INTEGER', 'job_categories_fields', 'id', false, null, null);
        $this->addColumn('helper', 'Helper', 'VARCHAR', false, 255, null);
        $this->getColumn('helper', false)->setPrimaryString(true);
        $this->addColumn('show_in_filter', 'ShowInFilter', 'BOOLEAN', false, 1, null);
        $this->addColumn('show_in_table', 'ShowInTable', 'BOOLEAN', false, 1, false);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('listing', 'Listing', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JobCategories', 'Admin\\AdminBundle\\Model\\JobCategories', RelationMap::MANY_TO_ONE, array('category_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobCategoriesFieldsRelatedByParentFieldId', 'Admin\\AdminBundle\\Model\\JobCategoriesFields', RelationMap::MANY_TO_ONE, array('parent_field_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('ChildsFields', 'Admin\\AdminBundle\\Model\\JobCategoriesFields', RelationMap::ONE_TO_MANY, array('id' => 'parent_field_id', ), 'CASCADE', null, 'ChildsFieldss');
        $this->addRelation('JobCategoriesFieldsValues', 'Admin\\AdminBundle\\Model\\JobCategoriesFieldsValues', RelationMap::ONE_TO_MANY, array('id' => 'field_id', ), 'CASCADE', null, 'JobCategoriesFieldsValuess');
        $this->addRelation('JobParams', 'Admin\\AdminBundle\\Model\\JobParams', RelationMap::ONE_TO_MANY, array('id' => 'field_id', ), 'CASCADE', null, 'JobParamss');
    } // buildRelations()

} // JobCategoriesFieldsTableMap
