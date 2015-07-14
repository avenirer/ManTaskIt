<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

// You can find dbforge usage examples here: http://ellislab.com/codeigniter/user-guide/database/forge.html


class Migration_Add_projects_users_table extends CI_Migration
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}
	public function up()
	{
        $fields = array(
            'project_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'role' => array(
                'type' => 'VARCHAR',
                'constraint' => 20
            )

        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(array('project_id','user_id'),TRUE);
        $this->dbforge->create_table('projects_users', TRUE);
    }
	public function down()
	{
        	$this->dbforge->drop_table('projects_users');
        }
}
/* End of file '20150714130028_add_projects_users_table' */
/* Location: ./D:\Dropbox\server\mantaskit\application\migrations/20150714130028_add_projects_users_table.php */
