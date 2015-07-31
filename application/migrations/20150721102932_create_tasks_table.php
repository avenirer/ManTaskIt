<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

// You can find dbforge usage examples here: http://ellislab.com/codeigniter/user-guide/database/forge.html


class Migration_Create_tasks_table extends CI_Migration
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}
	public function up()
	{
	    $fields = array(
            'id' => array(
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>TRUE,
                'auto_increment' => TRUE
            ),
            'project_id' => array(
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>TRUE
            ),
            'assigned_to' => array(
                'type'=>'INT',
                'constraint'=>11,
                'unsigned'=>TRUE
            ),
            'title' => array(
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null' => FALSE
            ),
            'summary' => array(
                'type' => 'text',
            ),
            'status' => array(
                'type'=>'INT',
                'constraint'=>2,
                'unsigned'=>TRUE,
            ),
            'priority' => array(
                'type'=>'INT',
                'constraint'=>1,
                'unsigned'=>TRUE,
                'after'=>'status'
            ),
            'progress' => array(
                'type' => 'INT',
                'constraint' => 3,
                'unsigned' => TRUE
            ),
            'due_date' => array(
                'type' => 'datetime',
                'null' => FALSE
            ),
            'created_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'created_at' => array(
                'type' => 'datetime',
                'null' => TRUE,
            ),
            'updated_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'updated_at' => array(
                'type' => 'datetime',
                'null' => TRUE,
            ),
            'deleted_by' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'deleted_at' => array(
                'type' => 'datetime',
                'null' => TRUE,
            )

        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('tasks', TRUE);
    }
	public function down()
	{
        	$this->dbforge->drop_table('tasks');
        }
}
/* End of file '20150721102932_create_tasks_table' */
/* Location: ./D:\Dropbox\server\mantaskit\application\migrations/20150721102932_create_tasks_table.php */
