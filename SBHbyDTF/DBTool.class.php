<?php
class DBTool
{
    public $host = "localhost";
    public $username = "root";
    public $password = "111";
    public $dbname = "xwmrn68_sunnybeachhotel";


    public function query($sql)
    {

        $dbConn = new mysqli($this->host,$this->username,$this->password,$this->dbname);
		if ($dbConn->connect_error)
		{
			echo $dbConn->connect_error;
		}
		
		$dbConn->set_charset('utf8');
		
		$result = $dbConn->query($sql);
		
		return $result;
    }

}



?>