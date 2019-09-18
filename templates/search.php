<nav class="nav">
      <ul class="nav__list container">
    <?php foreach($categories as $cat) : ?>
        <li class="nav__item">
          <a href=<?= $cat['sim_code']; ?>><?= $cat['name']; ?></a>
        </li>
    <?php endforeach; ?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <h2>Результаты поиска по запросу «<span><?= $search; ?></span>»</h2>
        <ul class="lots__list">

            <?php foreach($lots as $lot) : ?>
          
            <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= $lot['img']; ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['name_lot']); ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= $lot['name_cat']; ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot['id_lot']?>"><?= htmlspecialchars($lot['name_lot']); ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена/ 12 bets</span>
                  <span class="lot__cost"><?= formatPrice($lot['price']); ?></span>
                        
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
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
    </div>
  </main>