<?php
require "database.php";
class controller {

	 public function __construct()
	 {
         
	 }

	public function activeLink($header,$activeLink) 
	{
        $header = str_replace("nav-link active","nav-link", $header);
        $oldString = 'class="nav-link" href="/'.$activeLink.'"';
        $newString = 'class="nav-link active" href="/'.$activeLink.'"';
        $header = str_replace($oldString,$newString, $header);
        return $header;
	}

	public function inputBody($body,$text)
	{
		$body = $this->addServerInfo(str_replace("<!--Replace This Comment with html -->",$text,$body));
		return $body;
	}

	function addServerInfo($body)
	{
        $html = "<p>". $_SERVER['SERVER_NAME']."</p><p>".$_SERVER['SERVER_SOFTWARE']."</p>";
        $body = str_replace("<!--Server Information-->",$html,$body);
        return $body;
	}	
}