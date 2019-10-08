<main class="container">
<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach($categories as $cat) : ?>
            <li class="promo__item promo__item--<?= $cat['sim_code']; ?>">
                <a class="promo__link" href="./category.php?category=<?= $cat['sim_code']; ?>"><?= htmlspecialchars($cat['name']); ?></a>
            </li>
             <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($items as $item) : ?>
            <?php   
                        $arr = get_dt_range($item['time_exit']); 
                        $hour = $arr[0];
                        $min = $arr[1];
                        ?>
           <?php if ($hour >= 0 and $min > 0) : ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="" width="350" height="260" alt="">
                    <img src="<?= $item['img']; ?>" width="350" height="260" alt="<?= htmlspecialchars($item['name_l']); ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $item['name_c']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $item['id_lot']; ?>"><?= htmlspecialchars($item['name_l']); ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <?php if (!$item['bet_step']) : ?>
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= formatPrice($item['lot_price']); ?></span>
                          <?php else : ?>
                        <span class="lot__amount">Текущая цена</span>
                            <span class="lot__cost"><?= formatPrice($item['bet_step']); ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="lot__timer timer <?php if ($hour < 1) { echo "timer--finishing"; } ?>">
                        <?php if ($hour <= 0 and $min <= 0) { echo "Торги окончены"; } else { echo $hour . ':' . $min;} ?>
                        </div>
                    </div>
                </div>
            </li>
<?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </section>
        <?php if ($pages_count > 1) : 
        $back = $cur_page - 1;
        $next = $cur_page + 1;
        ?>
        <ul class="pagination-list">
        <?php if($cur_page > 1) : ?>
            <li class="pagination-item pagination-item-prev"><a href="/?page=<?=$back;?>">Назад</a></li>
        <?php else : ?>
            <li class="pagination-item pagination-item-prev"></li>
        <?php endif;?>    
        <?php for($i=1;$i<=$pages_count;$i++) { ?>
            <li class="pagination-item <?php if ($i == $cur_page) : ?>pagination-item-active<?php endif; ?>">
            <a href="/?page=<?=$i;?>"><?=$i;?></a></li>
        <?php
                } ?>
        <?php if($cur_page < $pages_count) : ?>
            <li class="pagination-item pagination-item-next"><a href="/?page=<?=$next;?>">Вперед</a></li>
        <?php else : ?>
            <li class="pagination-item pagination-item-next"></li>
        <?php endif;?>
        </ul>    
        <?php endif; ?>
</main>