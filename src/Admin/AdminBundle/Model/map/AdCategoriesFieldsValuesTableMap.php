<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'ad_categories_fields_values' table.
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
class AdCategoriesFieldsValuesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.AdCategoriesFieldsValuesTableMap';

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
        $this->setName('ad_categories_fields_values');
        $this->setPhpName('AdCategoriesFieldsValues');
        $this->setClassname('Admin\\AdminBundle\\Model\\AdCategoriesFieldsValues');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('field_id', 'FieldId', 'INTEGER', 'ad_categories_fields', 'id', false, null, null);
        $this->addColumn('town_id', 'TownId', 'INTEGER', false, null, null);
        $this->addColumn('area_id', 'AreaId', 'INTEGER', false, null, null);
        $this->addColumn('sort', 'Sort', 'INTEGER', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('alias', 'Alias', 'VARCHAR', false, 255, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('color', 'Color', 'VARCHAR', false, 255, null);
        $this->addColumn('icon', 'Icon', 'VARCHAR', false, 255, null);
        $this->addColumn('parent_field_id', 'ParentFieldId', 'INTEGER', false, null, null);
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
        $this->addRelation('AdCategoriesFields', 'Admin\\AdminBundle\\Model\\AdCategoriesFields', RelationMap::MANY_TO_ONE, array('field_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('AdvParams', 'Admin\\AdminBundle\\Model\\AdvParams', RelationMap::ONE_TO_MANY, array('id' => 'value_id', ), 'CASCADE', null, 'AdvParamss');
    } // buildRelations()

} // AdCategoriesFieldsValuesTableMap
