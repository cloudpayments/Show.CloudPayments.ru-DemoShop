<ul class="order__list">
    <?php foreach ($order['items'] as $item): ?>
        <li class="order__item">
            <img class="order__image" src="<?= $assets_url . $item['image'] ?>" srcset="<?=  $assets_url . $item['image2x'] ?> 2x" alt="<?= $item['alt'] ?>" width="70">
            <div class="order__m-group">
                <b class="order__name"><?= $item['name'] ?></b>
                <div class="order__count">
                    <button class="button-cv button-cv--decrease" type="button" name="button" value="0" data-product-id="<?= $item['id'] ?>"><span class="visually-hidden">Уменьшить количество товаров</span></button>
                    <input class="order__field" type="text" value="<?= $item['count'] ?>" id="goodsValue-<?= $item['id'] ?>">
                    <button class="button-cv button-cv--increase" type="button" name="button" value="1" data-product-id="<?= $item['id'] ?>"><span class="visually-hidden">Увеличить количество товаров</span></button>
                </div>
            </div>
            <span class="order__counter"><span id="goodsCost-<?= $item['id'] ?>"><?= $item['cost'] ?></span> р.</span>
        </li>
    <?php endforeach;?>
</ul>
<b class="order__sum">Итого: <span id="sumFields"><?= $order['total_cost'] ?> </span>р.</b>
