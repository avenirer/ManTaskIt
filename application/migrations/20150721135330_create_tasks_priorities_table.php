<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

// You can find dbforge usage examples here: http://ellislab.com/codeigniter/user-guide/database/forge.html


class Migration_Create_tasks_priorities_table extends CI_Migration
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
            'title' => array(
                'type'=>'VARCHAR',
                'constraint'=>30,
            ),
            'order' => array(
                'type'=>'INT',
                'constraint'=>2,
            ),
            'color' => array(
                'type'=>'VARCHAR',
                'constraint'=>7,
                'default' => '#ffffff'
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
        $this->dbforge->create_table('tasks_priorities', TRUE);
        $this->load->model('task_priority_model');
        $this->task_priority_model->init();
    }
	public function down()
	{
        	$this->dbforge->drop_table('tasks_priorities');
        }
}
/* End of file '20150721135330_create_tasks_priorities_table' */
/* Location: ./D:\Dropbox\server\mantaskit\application\migrations/20150721135330_create_tasks_priorities_table.php */
