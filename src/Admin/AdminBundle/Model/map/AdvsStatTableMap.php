<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'advs_stat' table.
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
class AdvsStatTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.AdvsStatTableMap';

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
        $this->setName('advs_stat');
        $this->setPhpName('AdvsStat');
        $this->setClassname('Admin\\AdminBundle\\Model\\AdvsStat');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('adv_id', 'AdvId', 'INTEGER', 'advs', 'id', true, null, null);
        $this->addColumn('shows', 'Shows', 'INTEGER', false, null, 0);
        $this->addColumn('clicks', 'Clicks', 'INTEGER', false, null, 0);
        $this->addColumn('stat_date', 'StatDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Advs', 'Admin\\AdminBundle\\Model\\Advs', RelationMap::MANY_TO_ONE, array('adv_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // AdvsStatTableMap
