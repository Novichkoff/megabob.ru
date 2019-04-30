<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'job_categories_fields_values' table.
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
class JobCategoriesFieldsValuesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobCategoriesFieldsValuesTableMap';

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
        $this->setName('job_categories_fields_values');
        $this->setPhpName('JobCategoriesFieldsValues');
        $this->setClassname('Admin\\AdminBundle\\Model\\JobCategoriesFieldsValues');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('field_id', 'FieldId', 'INTEGER', 'job_categories_fields', 'id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('parent_value_id', 'ParentValueId', 'INTEGER', false, null, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, false);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JobCategoriesFields', 'Admin\\AdminBundle\\Model\\JobCategoriesFields', RelationMap::MANY_TO_ONE, array('field_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobParams', 'Admin\\AdminBundle\\Model\\JobParams', RelationMap::ONE_TO_MANY, array('id' => 'value_id', ), 'CASCADE', null, 'JobParamss');
    } // buildRelations()

} // JobCategoriesFieldsValuesTableMap
