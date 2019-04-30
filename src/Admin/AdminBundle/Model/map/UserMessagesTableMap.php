<?php

namespace Admin\AdminBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user_messages' table.
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
class UserMessagesTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Admin.AdminBundle.Model.map.UserMessagesTableMap';

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
        $this->setName('user_messages');
        $this->setPhpName('UserMessages');
        $this->setClassname('Admin\\AdminBundle\\Model\\UserMessages');
        $this->setPackage('src.Admin.AdminBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('fos_user_id', 'FosUserId', 'INTEGER', 'fos_user', 'id', true, null, null);
        $this->addColumn('sender_name', 'SenderName', 'VARCHAR', true, 255, null);
        $this->addColumn('sender_email', 'SenderEmail', 'VARCHAR', true, 255, null);
        $this->addColumn('sender_phone', 'SenderPhone', 'VARCHAR', true, 255, null);
        $this->addColumn('date', 'Date', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('message', 'Message', 'LONGVARCHAR', false, null, null);
        $this->addColumn('viewed', 'Viewed', 'BOOLEAN', false, 1, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', 'FOS\\UserBundle\\Propel\\User', RelationMap::MANY_TO_ONE, array('fos_user_id' => 'id', ), 'CASCADE', null);
    } // buildRelations()

} // UserMessagesTableMap
