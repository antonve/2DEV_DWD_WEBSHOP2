<?php

// ProductsRepository.php -
// By Anton Van Eechaute

namespace Devine\Shop\Repository;

use Devine\Framework\SingletonPDO;
use Devine\Shop\Model\Product;

class ProductsRepository
{
    /**
     * @var PDO  
     */
    private $dbh;

    /**
     * Initializes a products repository  
     */
    public function __construct()
    {
        $this->dbh = SingletonPDO::getInstance();
    }


    /**
     * Retrieves the last 4 products added
     * @return array 
     */
    public function getLatestProducts()
    {
        $query = $this->dbh->query('SELECT products.*, types.name as type_name, categories.name as category_name
                                    FROM products
                                    INNER JOIN types ON (products.type_id = types.id)
                                    INNER JOIN categories ON (products.category_id = categories.id)
                                    ORDER BY products.date_created DESC
                                    LIMIT 4');

        $products = array();

        while ($row = $query->fetch()) {
            $products[] = new Product($row['id'], $row['title'], $row['description'], $row['thumb'], $row['price'], $row['hot'], $row['type_name'], $row['category_name']);
        }

        return $products;
    }

    /**
     * Retrieves all hot products
     * @return array
     */
    public function getAllHotProducts()
    {
        $query = $this->dbh->query('SELECT products.*, types.name as type_name, categories.name as category_name
                                    FROM products
                                    INNER JOIN types ON (products.type_id = types.id)
                                    INNER JOIN categories ON (products.category_id = categories.id)
                                    WHERE products.hot = true
                                    ORDER BY products.date_created DESC');

        $products = array();

        while ($row = $query->fetch()) {
            $products[] = new Product($row['id'], $row['title'], $row['description'], $row['thumb'], $row['price'], $row['hot'], $row['type_name'], $row['category_name']);
        }

        return $products;
    }

    /**
     * Retrieves all products
     * @return array
     */
    public function getAllProducts()
    {
        $query = $this->dbh->query('SELECT products.*, types.name as type_name, categories.name as category_name
                                    FROM products
                                    INNER JOIN types ON (products.type_id = types.id)
                                    INNER JOIN categories ON (products.category_id = categories.id)
                                    ORDER BY products.title ASC');

        $products = array();

        while ($row = $query->fetch()) {
            $products[] = new Product($row['id'], $row['title'], $row['description'], $row['thumb'], $row['price'], $row['hot'], $row['type_name'], $row['category_name']);
        }

        return $products;
    }

    /**
     * Retrieves all products
     * @return array
     */
    public function findProducts($keywords)
    {
        $stmt = $this->dbh->prepare('SELECT products.*, types.name as type_name, categories.name as category_name
                                     FROM products
                                     INNER JOIN types ON (products.type_id = types.id)
                                     INNER JOIN categories ON (products.category_id = categories.id)
                                     WHERE products.title LIKE :keywords
                                     OR products.description LIKE :keywords
                                     OR types.name LIKE :keywords
                                     OR categories.name LIKE :keywords
                                     ORDER BY products.title ASC');

        $keywords = '%' . $keywords . '%';
        $stmt->bindParam(':keywords', $keywords);
        $stmt->execute();

        $products = array();

        while ($row = $stmt->fetch()) {
            $products[] = new Product($row['id'], $row['title'], $row['description'], $row['thumb'], $row['price'], $row['hot'], $row['type_name'], $row['category_name']);
        }

        return $products;
    }

    /**
     * Retrieves all products
     * @return array
     */
    public function getAllFilteredProducts($category, $type)
    {
        $query = 'SELECT products.*, types.name as type_name, categories.name as category_name
                  FROM products
                  INNER JOIN types ON (products.type_id = types.id)
                  INNER JOIN categories ON (products.category_id = categories.id)';

        // add conditions if they're different from 'all'
        if('all' !== $category || 'all' !== $type) {
            $query .= ' WHERE';
            if ('all' !== $category) {
                $query .= ' categories.name = :cat';
            }
            if ('all' !== $category && 'all' !== $type) {
                $query .= ' AND';
            }
            if ('all' !== $type) {
                $query .= ' types.name = :type';
            }
        }

        $query .= ' ORDER BY products.title ASC';

        $stmt = $this->dbh->prepare($query);

        // bind parameters if needed
        if ('all' !== $category) {
            $stmt->bindParam(':cat', $category);
        }
        if ('all' !== $type) {
            $stmt->bindParam(':type', $type);
        }

        $stmt->execute();

        $products = array();

        while ($row = $stmt->fetch()) {
            $products[] = new Product($row['id'], $row['title'], $row['description'], $row['thumb'], $row['price'], $row['hot'], $row['type_name'], $row['category_name']);
        }

        return $products;
    }

    /**
     * Retrieves all category names
     * @return array  
     */
    public function getAllCategoryNames()
    {
        $query = $this->dbh->query("SELECT * FROM categories");

        $categories = array();

        while($row = $query->fetch()) {
            $categories[] = $row['name'];
        }

        return $categories;
    }

    /**
     * Retrieves all type names
     * @return array  
     */
    public function getAllTypeNames()
    {
        $query = $this->dbh->query("SELECT * FROM types");

        $types = array();

        while($row = $query->fetch()) {
            $types[] = $row['name'];
        }

        return $types;
    }

    /**
     * Updates the users' cart, insert if not exist and update when it does
     * @param type $uid
     * @param type $id
     * @param type $amount  
     */
    public function updateCart($uid, $id, $amount)
    {
        $stmt = $this->dbh->prepare('SELECT id FROM carts WHERE user_id = :id');
        $stmt->execute(array('id' => $uid));

        if (0 !== $stmt->rowCount()) { // update
            $idCart = $stmt->fetch();
            $idCart = $idCart['id'];

        } else { // create new
            $stmt = $this->dbh->prepare('INSERT INTO carts (user_id) VALUES(:id)');
            $stmt->execute(array('id' => $uid));
            $idCart = $this->dbh->lastInsertId();
        }

        $stmt = $this->dbh->prepare('SELECT amount FROM carts_products WHERE id_products = :idp AND id_carts = :idc');
        $stmt->execute(array('idc' => $idCart, 'idp' => $id));
        if (0 == $amount && $stmt->rowCount() > 0) {
            $stmt = $this->dbh->prepare('DELETE FROM carts_products WHERE id_products = :idp AND id_carts = :idc');
            $stmt->execute(array('idc' => $idCart, 'idp' => $id));
        } elseif ($stmt->rowCount() > 0) {
            // try to update
            $stmt = $this->dbh->prepare('UPDATE carts_products SET amount = :amount WHERE id_products = :idp AND id_carts = :idc');
            $stmt->execute(array('idc' => $idCart, 'idp' => $id, 'amount' => $amount));
        } else {
            // if none were found, insert
            $stmt = $this->dbh->prepare('INSERT INTO carts_products (id_carts, id_products, amount) VALUES(:idc, :idp, :amount)');
            $stmt->execute(array('idc' => $idCart, 'idp' => $id, 'amount' => $amount));
        }
    }

    /**
     * Removes an item from the cart
     * @param type $uid
     * @param type $id
     * @return type  
     */
    public function removeCart($uid, $id)
    {
        $stmt = $this->dbh->prepare('DELETE FROM carts_products
                                     WHERE id_products = :idp AND id_carts = (SELECT id FROM carts WHERE user_id = :id)');
        $stmt->execute(array('id' => $uid, 'idp' => $id));

        return $stmt->rowCount();
    }

    /**
     * Get the ids & amount of your current cart
     * @param integer $uid
     * @return array
     */
    public function getCartIds($uid)
    {
        $stmt = $this->dbh->prepare('SELECT carts_products.id_products as id, carts_products.amount as amount
                                     FROM carts_products
                                     INNER JOIN carts ON (carts_products.id_carts = carts.id)
                                     WHERE carts.user_id = :id');
        $stmt->execute(array('id' => $uid));

        $results = array();
        while ($row = $stmt->fetch()) {
            $results[$row['id']] = $row['amount'];
        }

        return $results;
    }

    /**
     * Gets product information by an array of product id's
     * @param array $ids
     * @return array  
     */
    public function getProductsByIds($ids)
    {
        // if the ids are empty, no need to search the db
        if (empty($ids)) {
            return array();
        }

        // build query
        $query = 'SELECT products.*, types.name as type_name, categories.name as category_name
                  FROM products
                  INNER JOIN types ON (products.type_id = types.id)
                  INNER JOIN categories ON (products.category_id = categories.id)
                  WHERE products.id IN (';

        foreach($ids as $id) {
            $query .=  '?,';
        }
        $query = substr($query, 0, strlen($query) - 1) . ')';

        // execute
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($ids);


        $products = array();

        while ($row = $stmt->fetch()) {
            $products[] = new Product($row['id'], $row['title'], $row['description'], $row['thumb'], $row['price'], $row['hot'], $row['type_name'], $row['category_name']);
        }

        return $products;
    }
}
