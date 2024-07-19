<?php
//session_start();
require_once("DB.php");
include("Smarty/libs/Smarty.class.php");
//echo $_SESSION["dsnw"];
class MySmarty extends Smarty {
	private $_db;
	public function __construct() {
		$this->Smarty();
		$this->template_dir="./templates";
		$this->compile_dir="./templates_c";
		$this->config_dir="./config";
		$this->config_load("chat_app.conf",basename($_SERVER['SCRIPT_NAME'],".php"));
		$this->caching=FALSE;
		$this->security=TRUE;
		$this->secure_dir=array("img");
		$this->_db=DB::connect($this->get_config_vars("db_string"));
		//$this->_db=DB::connect("pgsql://postgres@192.168.1.160/parabola_db");
	}
	public function __destruct() {
		$this->_db->disconnect();
	}
	public function getDb() {return $this->_db;}
}
?>