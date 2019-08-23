<ul class="popup-down__list">
    <?php foreach ($order['items'] as $item): ?>
        <li class="popup-down__item" data-name="<?= $item['name'] ?>" data-id="<?= $item['id'] ?>" data-price="<?= $item['price'] ?>">
            <img class="popup-down__image" src="<?= $assets_url . $item['image'] ?>" srcset="<?=  $assets_url . $item['image2x'] ?> 2x" alt="<?= $item['alt'] ?>">
            <div class="popup-down__m-group">
                <b class="popup-down__name"><?= $item['name'] ?></b>
                <div class="popup-down__count">
                    <button class="button-cv button-cv--decrease" type="button" name="button" value="0" data-product-id="<?= $item['id'] ?>"><span class="visually-hidden">Уменьшить количество товаров</span></button>
                    <input class="popup-down__field" type="text" value="<?= $item['count'] ?>" id="goodsValue-<?= $item['id'] ?>">
                    <button class="button-cv button-cv--increase" type="button" name="button" value="1" data-product-id="<?= $item['id'] ?>"><span class="visually-hidden">Увеличить количество товаров</span></button>
                </div>
            </div>
            <span class="popup-down__counter"><span id="goodsCost-<?= $item['id'] ?>"><?= $item['cost'] ?></span> р.</span>
        </li>
    <?php endforeach;?>
</ul>
<?php if ($order['total_count']): ?>
<b class="popup-down__sum">Итого: <span id="sumFields"><?= $order['total_cost'] ?></span>р.</b>
<?php endif ?>
