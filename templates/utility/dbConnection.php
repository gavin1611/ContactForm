<?php
require 'validation.php';

class DbConnection extends Validation
{

        const DB_SERVER = "localhost";
        const DB_USER = "root";
        const DB_PASSWORD = "Andre100";
        const DB = "db_test";


		public function __construct(){
			//parent::__construct();				
			$this->dbConnect();// Initiate Database connection
		}
		public function dbConnect(){
            $this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
            if($this->db)
			mysql_select_db(self::DB,$this->db);
		}
}
