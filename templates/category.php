<main>
  <nav class="nav">
        <ul class="nav__list container">
      <?php foreach($categories as $cat) : ?>
          <li class="nav__item">
            <a href="./category.php?category=<?= $cat['sim_code']; ?>"><?= $cat['name']; ?></a>
          </li>
      <?php endforeach; ?>
        </ul>
      </nav>
      <div class="container">
        <section class="lots">
          <h2>Все лоты в категории — <?= $category_name; ?></h2>
          <ul class="lots__list">
              <?php foreach($lots as $lot) : ?>
              <?php   
                      $arr = get_dt_range($lot['time_exit']); 
                      $hour = $arr[0];
                      $min = $arr[1];
                    ?>
               <?php if ($hour >= 0 and $min > 0) : ?>      
              <li class="lots__item lot">
              
              <div class="lot__image">
                <img src="<?= $lot['img']; ?>" width="350" height="260" alt="<?= htmlspecialchars($lot['name_lot']); ?>">
              </div>
              <div class="lot__info">
                <span class="lot__category"><?= $lot['name_cat']; ?></span>
                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $lot['id_lot']?>"><?= htmlspecialchars($lot['name_lot']); ?></a></h3>
                <div class="lot__state">
                  <div class="lot__rate">
                  <?php if (!($lot['bet_step'])) : ?>
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?= formatPrice($lot['price']); ?></span>
                          <?php else : ?>
                        <span class="lot__amount">Текущая цена</span>
                            <span class="lot__cost"><?= formatPrice($lot['bet_step']); ?></span>
                            <?php endif; ?>  
                  </div>
                  <?php   
                      $arr = get_dt_range($lot['time_exit']); 
                      $hour = $arr[0];
                      $min = $arr[1];
                    ?>
                    
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
              <li class="pagination-item pagination-item-prev"><a href="./category.php?category=<?= $category?>&page=<?=$back;?>">Назад</a></li>
            <?php else : ?>
              <li class="pagination-item pagination-item-prev"></li>
            <?php endif;?>    
            <?php for($i=1;$i<=$pages_count;$i++) { ?>
              <li class="pagination-item <?php if ($i == $cur_page) : ?>pagination-item-active<?php endif; ?>">
              <a href=./category.php?category=<?= $category;?>&page=<?=$i;?>><?=$i;?></a></li>
            <?php
                    } ?>
            <?php if($cur_page < $pages_count) : ?>
              <li class="pagination-item pagination-item-next"><a href="./category.php?category=<?= $category?>&page=<?=$next;?>">Вперед</a></li>
            <?php else : ?>
              <li class="pagination-item pagination-item-next"></li>
            <?php endif;?>    
           </ul>
          <?php endif; ?>
      </div>
</main>