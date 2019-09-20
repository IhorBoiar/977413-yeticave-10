<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->
            <?php foreach($categories as $cat) : ?>
            <li class="promo__item promo__item--<?= $cat['sim_code']; ?>">
                <a class="promo__link" href="<?= $cat['sim_code']; ?>"><?= htmlspecialchars($cat['name']); ?></a>
            </li>
             <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <!--заполните этот список из массива с товарами-->
            <?php foreach ($items as $item) : ?>
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
                            <span class="lot__cost"><?= formatPrice($item['price']); ?></span>
                          <?php else : ?>
                        <span class="lot__amount">Текущая цена</span>
                            <span class="lot__cost"><?= formatPrice($item['bet_step']); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php   
                        $arr = get_dt_range($item['time_exit']); 
                        $hour = $arr[0];
                        $min = $arr[1];
                        ?>
                        <div class="lot__timer timer <?php if ($hour < 1) { echo "timer--finishing"; } ?>">
                        <?php echo $hour . ':' . $min; ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>