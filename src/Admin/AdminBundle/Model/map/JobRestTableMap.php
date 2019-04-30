<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'job_rest' table.
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
class JobRestTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobRestTableMap';

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
        $this->setName('job_rest');
        $this->setPhpName('JobRest');
        $this->setClassname('Admin\\AdminBundle\\Model\\JobRest');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('job_id', 'JobId', 'INTEGER', 'jobs', 'id', true, null, null);
        $this->addForeignKey('vacancy_id', 'VacancyId', 'INTEGER', 'jobs', 'id', true, null, null);
        $this->addForeignPrimaryKey('sender_id', 'SenderId', 'INTEGER' , 'fos_user', 'id', true, null, null);
        $this->addColumn('deleted', 'Deleted', 'BOOLEAN', false, 1, false);
        $this->addColumn('date', 'Date', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('message', 'Message', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('JobsRelatedByJobId', 'Admin\\AdminBundle\\Model\\Jobs', RelationMap::MANY_TO_ONE, array('job_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('JobsRelatedByVacancyId', 'Admin\\AdminBundle\\Model\\Jobs', RelationMap::MANY_TO_ONE, array('vacancy_id' => 'id', ), 'CASCADE', null);
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('sender_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // JobRestTableMap
