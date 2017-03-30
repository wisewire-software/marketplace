<?php

class WiseWireDownloadBatch {
	
	private $host, $username, $password, $directory, $destination; 
	
	public function __construct() {
		$this->host = '162.242.245.131';
		$this->username = 'WRDNUM150031';
		$this->password = 'Rockrose2050!';
		$this->directory = '/Batch Upload Sheets to Celery/';
		$this->destination = '/var/www/html/tmp/';
	}
	
	public function download() {
		
		$ftp_server = $this->host; 
		$conn_id = ftp_connect ($ftp_server) 
			or die("Couldn't connect to $ftp_server"); 

		$login_result = ftp_login($conn_id, $this->username, $this->password); 
		if ((!$conn_id) || (!$login_result)) 
			die("FTP Connection Failed"); 

		chdir( $this->destination );
		
		$this->ftp_sync ($conn_id, $this->directory);    // Use "." if you are in the current directory 

		ftp_close($conn_id);  
	}
	
	private function ftp_sync ($conn_id, $dir) { // $this->ftp_sync - Copy directory and file structure 

		if ($dir != ".") { 
			if (ftp_chdir($conn_id, $dir) == false) { 
				echo ("Change Dir Failed: $dir<BR>\r\n"); 
				return; 
			} 
			if (!(is_dir($this->destination . $dir))) {
				mkdir($this->destination . $dir); 
			}
			chdir ($this->destination . $dir); 
		} 

		$contents = ftp_nlist($conn_id, "."); 
		foreach ($contents as $file) { 

			if ($file == '.' || $file == '..') 
				continue; 

			if (@ftp_chdir($conn_id, $dir . $file)) { 
				ftp_chdir ($conn_id, ".."); 
				$this->ftp_sync ($conn_id, $dir . $file); 
			} 
			else 
				ftp_get($conn_id, $this->destination . $dir . $file, $dir. $file, FTP_BINARY); 
		} 

	} 
}
