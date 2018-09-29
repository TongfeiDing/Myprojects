<?php 

function encrypt($data, $key)  
	{  
		$key    =   md5($key);  
		$x      =   0;  
		$len    =   strlen($data);  
		$l      =   strlen($key);  
		for ($i = 0; $i < $len; $i++)  
		{  
			if ($x == $l)   
			{  
				$x = 0;  
			}  
			$char .= $key{$x};  
			$x++;  
		}  
		for ($i = 0; $i < $len; $i++)  
		{  
			$str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);  
		}  
		return base64_encode($str);  
	}  
?>
