<?php

// module.php -
// By Anton Van Eechaute

// slots
$response->addSlot('search', 'search_slot');

$rep = new Devine\Shop\Repository\ProductsRepository;

if (null === $request->get('cart')) {
    if (null !== $request->get('user')) {
        $request->set('cart', $rep->getCartIds($request->get('user')->getId()));
        $smarty->assign('cart', $request->get('cart'));
    } else {
        $request->set('cart', array());
        $smarty->assign('cart', array());
    }
} else {
    $smarty->assign('cart', $request->get('cart'));
};

if ($request->get('loggedInEvent')) {
    $cart = $request->get('cart');
    foreach($rep->getCartIds($request->get('user')->getId()) as $id => $amount) {
        $cart[$id] = (array_key_exists($id, $cart) && $amount < $cart[$id]) ? $cart[$id] : $amount;
    }
    foreach($cart as $id => $amount) {
        $rep->updateCart($request->get('user')->getId(), $id, $amount);
    }
    $request->set('cart', $cart);
    $smarty->assign('cart', $cart);
}

if ($request->get('loggedOutEvent')) {
    $request->set('cart', array());
    $smarty->assign('cart', array());
}
