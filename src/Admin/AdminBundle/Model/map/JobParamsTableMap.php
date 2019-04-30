<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'job_params' table.
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
class JobParamsTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobParamsTableMap';

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
        $this->setName('job_params');
        $this->setPhpName('JobParams');
        $this->setClassname('Admin\\AdminBundle\\Model\\JobParams');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('job_id', 'JobId', 'INTEGER', 'jobs', 'id', true, null, null);
        $this->addForeignKey('field_id', 'FieldId', 'INTEGER', 'job_categories_fields', 'id', true, null, null);
        $this->addForeignKey('value_id', 'ValueId', 'INTEGER', 'job_categories_fields_values', 'id', false, null, null);
        $this->addColumn('text_value', 'TextValue', 'VARCHAR', false, 1000, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JobCategoriesFields', 'Admin\\AdminBundle\\Model\\JobCategoriesFields', RelationMap::MANY_TO_ONE, array('field_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('Jobs', 'Admin\\AdminBundle\\Model\\Jobs', RelationMap::MANY_TO_ONE, array('job_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobCategoriesFieldsValues', 'Admin\\AdminBundle\\Model\\JobCategoriesFieldsValues', RelationMap::MANY_TO_ONE, array('value_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // JobParamsTableMap
