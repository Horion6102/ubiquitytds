<?php
namespace controllers;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;

 /**
  * Controller StoreController
  */
class StoreController extends \controllers\ControllerBase{

    #[Route('_default',name: 'home')]
	public function index(){
        $section=DAO::getAll(Section::class,included: 'products');
		$this->loadView('viewEval/firstPage.html',compact('section'));
	}

    #[Route('Store/Section/{id}',name: 'Store.section')]
    public function section($id) {
        $section=DAO::getById(Section::class,$id+1);
        $products=$section->getProducts();
        $image=$products->getImage();
        $this->loadView('viewEval/sectionProducts.html',compact('section','products','image'));
    }
}
