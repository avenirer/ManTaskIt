<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

// You can find dbforge usage examples here: http://ellislab.com/codeigniter/user-guide/database/forge.html


class Migration_Add_role_field_to_categories_users extends CI_Migration
{
	public function __construct()
	{
		parent::__construct();
		$this->load->dbforge();
	}
	public function up()
	{
	    $fields = array(
            'role' => array(
                'type'=>'varchar',
                'constraint'=>20,
                'default'=>'edit'
            )
        );
        $this->dbforge->add_column('categories_users',$fields);
    }
	public function down()
	{
        	$this->dbforge->drop_column('categories_users','role');
    }
}
/* End of file '20150714123752_add_role_field_to_categories_users' */
/* Location: ./D:\Dropbox\server\mantaskit\application\migrations/20150714123752_add_role_field_to_categories_users.php */
