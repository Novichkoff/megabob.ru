<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'site_history' table.
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
class SiteHistoryTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.SiteHistoryTableMap';

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
        $this->setName('site_history');
        $this->setPhpName('SiteHistory');
        $this->setClassname('Admin\\AdminBundle\\Model\\SiteHistory');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('all_advs', 'AllAdvs', 'INTEGER', true, null, null);
        $this->addColumn('active_advs', 'ActiveAdvs', 'INTEGER', true, null, null);
        $this->addColumn('today_advs', 'TodayAdvs', 'INTEGER', true, null, null);
        $this->addColumn('google_advs', 'GoogleAdvs', 'INTEGER', true, null, null);
        $this->addColumn('yandex_advs', 'YandexAdvs', 'INTEGER', true, null, null);
        $this->addColumn('companies', 'Companies', 'INTEGER', true, null, null);
        $this->addColumn('twitter', 'Twitter', 'INTEGER', true, null, null);
        $this->addColumn('facebook', 'Facebook', 'INTEGER', true, null, null);
        $this->addColumn('vk', 'Vk', 'INTEGER', true, null, null);
        $this->addColumn('ok', 'Ok', 'INTEGER', true, null, null);
        $this->addColumn('date', 'Date', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

} // SiteHistoryTableMap
