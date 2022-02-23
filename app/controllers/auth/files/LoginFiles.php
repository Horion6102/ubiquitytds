<?php
namespace controllers\auth\files;

use Ubiquity\controllers\auth\AuthFiles;
 /**
  * Class LoginFiles
  */
class LoginFiles extends AuthFiles{
	public function getViewIndex(){
		return "Login/index.html";
	}

	public function getViewInfo(){
		return "Login/info.html";
	}

	public function getViewNoAccess(){
		return "Login/noAccess.html";
	}

	public function getViewDisconnected(){
		return "Login/disconnected.html";
	}

	public function getViewMessage(){
		return "Login/message.html";
	}

	public function getViewBaseTemplate(){
		return "Login/baseTemplate.html";
	}


}
