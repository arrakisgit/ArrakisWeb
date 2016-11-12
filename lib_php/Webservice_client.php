<?php

class WebService
{
	public function __construct()
	{
		
	}
	
	public function ws_command_shell_conv_mp4($inFile)
	{
		
		$serverpath ='http://192.168.0.44/ArrakisWeb/index.php/webservice_server/index/Start';
		$param = array('inFile'=>$inFile);
		$client = new soap_client($serverpath);
		$result = $client->call('convert_mp4', $param);
		print($client->request);
		
	}
}
?>