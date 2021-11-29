<?php
require_once('../interface/iClient.php');
require_once('../database/connection2.php');
class Client extends Database implements iClient {

	public function loginClient($un, $pwd)
	{
		$sql = "SELECT *
				FROM client 
				WHERE username = ?
				AND password = ?;
		";
		return $this->getRow($sql, [$un, $pwd]);
	}//end loginUser

}//end class User

$user = new User();//instance
/* End of file User.php */
/* Location: .//D/xampp/htdocs/medallion/class/User.php */