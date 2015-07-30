<?php

class serverStart
{
	
	protected $_steam; // Bash
	protected $_mashine; // SSH2 Connect Ip and Port
	protected $_user; // SSH2 User
	protected $_comand; // SSH2 Command
	
	public function __construct($server, $port, $username, $password, $command)
	{
		if (!function_exists("ssh2_connect")) echo "SSH2 PHP Not exist";
		$this->_mashine = ssh2_connect($server, $port);
		$this->_user	= ssh2_auth_password($this->_mashine, $username, $password);
		
		if(!($this->_mashine)){
			echo "I can\'t connect to server!";
		}else{
			if(!($this->_user)){
				echo "Wrong user and pass err1";
			}else{
				/* START FUNCTION */    	    
				$this->_steam = ssh2_shell($this->_mashine, 'vt102', null, 80, 24, SSH2_TERM_UNIT_CHARS);
				fwrite( $this->_steam, "screen -A -m -S $username".PHP_EOL);
				sleep(1);
				fwrite( $this->_steam, "cd /home/$username/".PHP_EOL);
				sleep(1);
				fwrite( $this->_steam, "$command".PHP_EOL);
				sleep(1);
				$data = "";
				while($line = fread($this->_steam, 500)) {
				$data .= $line;
				}
				echo $data;
				/* END FUNCTION */    
				}
			}
	}
}

class stopServer
{
	
	protected $_steam; // Bash
	protected $_mashine; // SSH2 Connect Ip and Port
	protected $_user; // SSH2 User
	protected $_comand; // SSH2 Command
	
	public function __construct($server, $port, $username, $password)
	{
		if (!function_exists("ssh2_connect")) echo "SSH2 PHP Not exist";
		$this->_mashine = ssh2_connect($server, $port);
		$this->_user	= ssh2_auth_password($this->_mashine, $username, $password);
		
		if(!($this->_mashine)){
			echo "I can\'t connect to server!";
		}else{
			if(!($this->_user)){
				echo "Wrong user and pass err2";
			}else{
				/* START FUNCTION */    	    
				$this->_steam = ssh2_shell($this->_mashine, 'vt102', null, 80, 24, SSH2_TERM_UNIT_CHARS);    	    
				fwrite( $this->_steam, 'kill -9 `screen -list | grep "'.$username.'" | awk {\'print $1\'} | cut -d . -f1`'.PHP_EOL);
				sleep(1);
				fwrite( $this->_steam, 'screen -wipe'.PHP_EOL);
				sleep(1);
				$data = "";
				while($line = fgets($this->_steam, 500)) {
					$data .= $line;
				}

				echo $data;
				/* END FUNKCIJE */ 
				}
			}
	}
	
}
