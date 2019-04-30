<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'job_videos' table.
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
class JobVideosTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.JobVideosTableMap';

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
        $this->setName('job_videos');
        $this->setPhpName('JobVideos');
        $this->setClassname('Admin\\AdminBundle\\Model\\JobVideos');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('job_id', 'JobId', 'INTEGER', 'jobs', 'id', true, null, null);
        $this->addColumn('path', 'Path', 'VARCHAR', false, 255, null);
        $this->addColumn('thumb', 'Thumb', 'VARCHAR', false, 255, null);
        $this->addColumn('temp_id', 'TempId', 'VARCHAR', false, 255, null);
        $this->addColumn('upload_date', 'UploadDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Jobs', 'Admin\\AdminBundle\\Model\\Jobs', RelationMap::MANY_TO_ONE, array('job_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // JobVideosTableMap
