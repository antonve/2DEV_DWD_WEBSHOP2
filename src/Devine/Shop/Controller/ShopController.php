<?php

// DefaultController.php - General controller
// By Anton Van Eechaute

namespace Devine\Shop\Controller;

use Devine\Shop\Repository\ProductsRepository;
use Devine\Framework\BaseController;

class ShopController extends BaseController
{
    public function indexAction()
    {
        // get all products from db
        $rep = new ProductsRepository();
        $products = $rep->getAllProducts();
        $categories = $rep->getAllCategoryNames();
        $types = $rep->getAllTypeNames();

        // pass to template
        $this->add("products", $products);
        $this->add("categories", $categories);
        $this->add("types", $types);
        $this->add("filter", "false");
        $this->setTemplate('products');
    }

    public function filterAction()
    {
        $request = $this->getRequest();

        if ($request->isPOST()) {
            $data = $request->getPOST('products_filter');
            $this->redirect('/products/filter/' . $data['category'] . '/' . $data['type']);
        } else {
            $this->forward404();
        }
    }

    public function filterResultAction()
    {
        // get all products from db
        $rep = new ProductsRepository();
        $products = $rep->getAllFilteredProducts($this->get('category'), $this->get('type'));
        $categories = $rep->getAllCategoryNames();
        $types = $rep->getAllTypeNames();

        // pass to template
        $this->add("products", $products);
        $this->add("categories", $categories);
        $this->add("types", $types);
        $this->add("filter", "true");
        $this->setTemplate('products');
    }

    public function searchAction()
    {
        $request = $this->getRequest();

        if ($request->isPOST()) {
            $query = $request->getPOST('search_query');
            $this->redirect('/search/' . $query);
        } else {
            $this->forward404();
        }
    }

    public function searchResultAction()
    {
        // get found products from db
        $rep = new ProductsRepository();
        $products = $rep->findProducts($this->get('query'));

        // pass to template
        $this->add("products", $products);
        $this->setTemplate('search_results');
    }

    public function cartAction()
    {
        $rep = new ProductsRepository();
        $cart = $this->getRequest()->get('cart');
        $products = $rep->getProductsByIds(array_keys($cart));
        $total = 0;
        foreach ($products as $product) {
            $total += $product->getPrice() * $cart[$product->getId()];
        }

        $this->add('products', $products);
        $this->add('total', $total);

        $this->setTemplate('cart');
    }

    public function cartAddAction()
    {

        $request = $this->getRequest();
        $rep = new ProductsRepository();

        if (null === $request->get('cart')) {
            $request->set('cart', array());
        }

        $cart = $request->get('cart');
        $cart[$this->get('id')] = array_key_exists($this->get('id'), $cart) ? $cart[$this->get('id')]+1 : 1;
        $request->set('cart', $cart);

        if ($request->get('user')) {
            $rep->updateCart($request->get('user')->getId(), $this->get('id'), $cart[$this->get('id')]);
        }

        $this->redirect($request->getReferer(), '');
    }

    public function cartRemoveAction()
    {
        $request = $this->getRequest();
        $rep = new ProductsRepository();

        $cart = $request->get('cart');
        if (!array_key_exists($this->get('id'), $cart)) {
            $this->forward404();
        }
        unset($cart[$this->get('id')]);
        $request->set('cart', $cart);

        if ($request->get('user')) {
            $rep->removeCart($request->get('user')->getId(), $this->get('id'));
        }

        $this->redirect($request->getReferer(), '');
    }

    public function cartUpdateAction()
    {
        $request = $this->getRequest();
        $rep = new ProductsRepository();

        $cart = $request->get('cart');
        if (!array_key_exists($this->get('id'), $cart) || !$request->isPOST()) {
            $this->forward404();
        }

        $cart = $request->get('cart');
        $cart[$this->get('id')] = $request->getPOST('amount');

        if (0 == $request->getPOST('amount')) {
            unset($cart[$this->get('id')]);
        }

        if (null !== $request->get('user')) {
            $rep->updateCart($request->get('user')->getId(), $this->get('id'), $request->getPOST('amount'));
        }

        $request->set('cart', $cart);
        $this->add('cart', $cart);

        $this->redirect($request->getReferer(), '');
    }
}
