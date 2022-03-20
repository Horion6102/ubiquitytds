<?php
namespace controllers;
 use Ubiquity\attributes\items\router\Get;
 use Ubiquity\attributes\items\router\Post;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\cache\CacheManager;
 use Ubiquity\utils\http\URequest;
 use Ubiquity\utils\http\USession;

 /**
  * Controller TodoController
  */
class TodoController extends \controllers\ControllerBase{

    const CACHE_KEY = 'datas/lists/';
    const EMPTY_LIST_ID='not saved';
    const LIST_SESSION_KEY='list';
    const ACTIVE_LIST_SESSION_KEY='active-list';

    public function initialize() {
        if (! URequest::isAjax()) {
            $this->loadView($this->headerView);
        }
    }

    public function finalize(){
        if (!URequest::isAjax()) {
            $this->loadView($this->footerView);
        }
    }

	public function index(){
        $list=USession::get(self::ACTIVE_LIST_SESSION_KEY,[]);
        $temp=CacheManager::$cache->getCacheFiles(self::CACHE_KEY);
		$this->loadView("/list/list.html",compact("list","temp"));
	}

    #[Post('todos/edit/{index}',name: 'todos.edit')]
	public function EditElement($index){
        $list=USession::get(self::ACTIVE_LIST_SESSION_KEY,[]);
        $list[$index] = URequest::post("titre-edit");
        USession::set(self::ACTIVE_LIST_SESSION_KEY,$list);
        $this->index();
	}


	#[Get('todos/remove/{index}',name: 'todos.remove')]
	public function DeleteElement($index){
        $list=USession::get(self::ACTIVE_LIST_SESSION_KEY,[]);
        unset($list[$index]);
        USession::set(self::ACTIVE_LIST_SESSION_KEY,array_values($list));
        $this->index();
	}


	#[Post('todos/add',name: 'todos.add')]
	public function AddElement(){
		$list=USession::get(self::ACTIVE_LIST_SESSION_KEY,[]);
        $list[]=URequest::post("titre");
        USession::set(self::ACTIVE_LIST_SESSION_KEY,$list);
        $this->index();
	}

	#[Route('todos/load/{uniqid}',name: 'todos.load')]
	public function LoadList($uniqid){
        if (CacheManager::$cache->exists(self::CACHE_KEY . $uniqid)) {
            $list = CacheManager::$cache->fetch(self::CACHE_KEY . $uniqid);
            USession::set(self::ACTIVE_LIST_SESSION_KEY,$list);
            $this->index();
        }
	}

    #[Route('todos/new',name: 'todos.new')]
	public function NewList(){
		$newList = USession::get(self::EMPTY_LIST_ID,[]);
        USession::set(self::ACTIVE_LIST_SESSION_KEY,$newList);
        $this->index();
	}

    #[Route('todos/save',name: 'todos.save')]
	public function SaveList(){
        $list=USession::get(self::ACTIVE_LIST_SESSION_KEY,[]);
        $id=uniqid('',true);
        CacheManager::$cache->store(self::CACHE_KEY . $id, $list);
        $this->index();
	}

}
