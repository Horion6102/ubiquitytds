<?php
namespace controllers;
 use models\Product;
 use models\Section;
 use Ubiquity\attributes\items\router\Route;
 use Ubiquity\orm\DAO;
 use Ubiquity\utils\http\USession;

 /**
  * Controller StoreController
  */
class StoreController extends \controllers\ControllerBase{

    const CART = "cart";


    #[Route('_default',name: 'home')]
	public function index(){
        $section=DAO::getAll(Section::class,included: 'products');
		$this->loadView('viewEval/firstPage.html',compact('section'));
	}

    #[Route('Store/Section/{id}',name: 'Store.section')]
    public function section($id) {
        $section=DAO::getById(Section::class,$id+1);
        $products=$section->getProducts();
        $this->loadView('viewEval/sectionProducts.html',compact('section','products'));
    }

    #[Route('Store/all',name: 'Store.all')]
    public function all() {
        $products=DAO::getAll(Product::class);
        $this->loadView('viewEval/sectionProducts.html',compact('products'));
    }

    #[Route('Store/addToCart/{id}/{quantity}',name: 'Store.addToCart')]
    public function addToCart($id, $quantity) {
        $cart = USession::get(self::CART,['_count'=>0,'_amount'=>0]);
        if(isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        USession::set(self::CART,$cart);
        $this->index();
    }

    public function initialize()
    {
        $nbr = 0;
        $list = USession::get(self::CART,[]);
        foreach ($list as $produit){
            $nbr = $nbr + $produit;
        }
        $this->view->setVar('panier', $list);
        $this->view->setVar('nbr', $nbr);
        parent::initialize();
    }

}
