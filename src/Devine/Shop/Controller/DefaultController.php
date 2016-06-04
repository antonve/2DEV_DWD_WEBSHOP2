<?php

// DefaultController.php - General controller
// By Anton Van Eechaute

namespace Devine\Shop\Controller;

use Devine\Shop\Repository\ProductsRepository;
use Devine\Framework\BaseController;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        // retrieve from database
        $rep = new ProductsRepository();
        $latest_products = $rep->getLatestProducts();
        $hot_products = $rep->getAllHotProducts();

        // pass to template
        $this->add("latest_products", $latest_products);
        $this->add("hot_products", $hot_products);
        $this->setTemplate('index');
    }
}
