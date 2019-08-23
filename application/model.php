<?php

class Model
{
    private $products;

    private $cart;

    function __construct()
    {
        session_start();
        $this->cart = $this->getCart();

        /** Демо продукты  */
        $products = array();
        $products[] = array(
            'id' => 1,
            'name' => 'Подушка «Padi»',
            'price' => 1,
            'image' => 'img/pillow@1x.jpg',
            'image2x' => 'img/pillow@2x.jpg',
            'alt' => 'подушка'
        );
        $products[] = array(
            'id' => 2,
            'name' => 'Лампа «Lamp»',
            'price' => 1,
            'image' => 'img/lamp@1x.jpg',
            'image2x' => 'img/lamp@2x.jpg',
            'alt' => 'лампа'
        );
        $products[] = array(
            'id' => 3,
            'name' => 'Плед «Tekk»',
            'price' => 1,
            'image' => 'img/blanket@1x.jpg',
            'image2x' => 'img/blanket@2x.jpg',
            'alt' => 'плед'
        );

        foreach ($products as $product) {
            $this->products[$product['id']] = $product;
        }
    }

    /**
     *
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Добавление продукта в корзину
     * @param $id
     * @param int $count
     * @return int|mixed|void
     */
    public function addProduct($id, $count = 1)
    {
        if (!$count) {
            return;
        }
        $id = (int)$id;

        if (!isset($this->cart[$id])) {
            $this->cart[$id] = 0;
        }
        $this->cart[$id] += $count;

        $_SESSION['cart'] = $this->cart;

        return isset($this->cart[$id]) ? $this->cart[$id] : 0;
    }

    /**
     * Удаление продукта из корзины
     *
     * @param $id
     * @param int $count
     * @return int|mixed
     */
    public function deleteProduct($id, $count = 0)
    {
        $id = (int)$id;

        if ($count && isset($this->cart[$id])) {
            $this->cart[$id] -= $count;
            if ($this->cart[$id] <= 0) {
                unset($this->cart[$id]);
            }
        } else {
            unset($this->cart[$id]);
        }

        $_SESSION['cart'] = $this->cart;

        return isset($this->cart[$id]) ? $this->cart[$id] : 0;
    }

    /**
     * Возвращает корзину
     *
     * @return array|mixed
     */
    public function getCart()
    {
        return isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    }

    /**
     * Количество продуктов в корзине
     *
     * @return int|mixed
     */
    public function getCartCount()
    {
        $count = 0;
        foreach ($this->cart as $product_cnt) {
            $count += $product_cnt;
        }

        return $count;
    }

    public function clear()
    {
        unset($_SESSION['cart']);
    }

    /**
     * Корзина пустая
     *
     * @return bool
     */
    public function isEmpty()
    {
        return !count($this->cart);
    }

    /**
     * Получение данных о заказе
     * Так как в демо магазине оформления заказа нет, то заказ это тоже самое что сейчас в корзине
     *
     * @return array
     */
    public function getOrder()
    {
        $cart = $this->getCart();
        $data = array(
            'items' => array(),
            'total_cost' => 0,
            'total_count' => 0
        );
        foreach ($cart as $id => $cnt) {
            if (!$cnt || !isset($this->products[$id])) {
                continue;
            }
            $product = $this->products[$id];
            $data['total_count'] += $cnt;
            $data['total_cost'] += $product['price'] * $cnt;
            $data['items'][$id] = array_merge($product, array(
                'count' => $cnt,
                'cost' => $cnt * $product['price']
            ));
        }

        return $data;
    }

    public function logError($str)
    {
        if (is_array($str)) {
            $str = json_encode($str, JSON_UNESCAPED_UNICODE);
        }
        $file = __DIR__ . '/log.txt';
        $fh = fopen($file, 'a');
        fwrite($fh, $str . "\n");
        fclose($fh);
    }
}

