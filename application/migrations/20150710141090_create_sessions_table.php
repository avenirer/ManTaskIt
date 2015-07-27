<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

// You can find dbforge usage examples here: http://ellislab.com/codeigniter/user-guide/database/forge.html


class Migration_Create_sessions_table extends CI_Migration
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
                'type'=>'VARCHAR',
                'constraint'=>40,
                'null'=>FALSE
            ),
            'ip_address' => array(
                'type' => 'VARCHAR',
                'constraint'=>45,
                'null' => FALSE
            ),
            'timestamp' => array(
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'null' => FALSE,
                'default' => '0'
            ),
            'data' => array(
                'type' => 'blob',
                'null'=>'false'
            )
        );
        $this->dbforge->add_field($fields);
        $this->dbforge->add_key(array('id','ip_address'), TRUE);
        $this->dbforge->create_table('ci_sessions', TRUE);
    }

	public function down()
	{
	    $this->dbforge->drop_table('ci_sessions', TRUE);
    }
}
/* End of file '20150727091440_create_sessions_table' */
/* Location: ./D:\Dropbox\server\mantaskit\application\migrations/20150727091440_create_sessions_table.php */