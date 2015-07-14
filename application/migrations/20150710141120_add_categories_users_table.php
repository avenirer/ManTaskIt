<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

// You can find dbforge usage examples here: http://ellislab.com/codeigniter/user-guide/database/forge.html


class Migration_Add_categories_users_table extends CI_Migration
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}
	public function up()
	{
        $fields = array(
            'category_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'null' => FALSE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(array('category_id','user_id'),TRUE);
        $this->dbforge->create_table('categories_users', TRUE);
    }
	public function down()
	{
        	$this->dbforge->drop_table('categories_users');
    }
}
/* End of file '20150710141120_add_categories_users_table' */
/* Location: ./D:\Dropbox\server\mantaskit\application\migrations/20150710141120_add_categories_users_table.php */
