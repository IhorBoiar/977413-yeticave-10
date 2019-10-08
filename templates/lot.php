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
    <section class="lot-item container">
      <h2><?= htmlspecialchars($lot['name_lot']); ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="../<?= $lot['img']; ?>" width="730" height="548" alt="<?= htmlspecialchars($lot['name']); ?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= $lot['name_cat']; ?></span></p>
          <p class="lot-item__description"><?= htmlspecialchars($lot['description']); ?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
        <?php   
            $arr = get_dt_range($lot['time_exit']); 
            $hour = $arr[0];
            $min = $arr[1];
            ?>
            <div class="lot-item__timer timer <?php if ($hour < 1) { echo "timer--finishing"; } ?>">
            <?php if ($hour <= 0 and $min <= 0) { echo "Торги окончены"; } else { echo $hour . ':' . $min;} ?>
            </div> 
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
              <?php if (empty($last_bet)) : ?>    
                  <span class="lot-item__amount">Стартовая цена</span>
                  <span class="lot-item__cost"><?= formatPrice($start_price); ?></span>
               <?php else : ?> 
                  <span class="lot-item__amount">Текущая цена</span>
                  <span class="lot-item__cost"><?= formatPrice($new_price); ?></span>    
               <?php endif; ?>
                </div>
              <div class="lot-item__min-cost">
              <?php if (empty($last_bet)) :?>
                Мин. ставка <span><?=formatPrice_2($min_bet_1);?> р</span>
                <?php else :?>
                Мин. ставка <span><?=formatPrice_2($min_bet_2);?> р</span>
                <?php endif; ?>
              </div>
            </div> 
            <?php if ($hour >= 0 and $min >= 1) : ?>
              <?php if(isset($_SESSION['email'])):?>
                <?php if(!$true) : ?>
                  <?php if(!$done) : ?>
            <form class="lot-item__form" action="" method="post" autocomplete="off">
            <?php $form_error = isset($errors['cost']) ? "form__item--invalid" : ""; ?>
              <p class="lot-item__form-item form__item <?= $form_error; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?php if(empty($last_bet)) { echo $min_bet_1; } else { echo $min_bet_2;} ?>" value="<?=getPostVal('cost');?>">               
                <?php if (isset($errors['cost'])) {
                        echo "<span class='form__error'>" . $errors['cost'] . "</span>";
                       }        
                ?>
                
         </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          <?php endif; ?>         
          <?php endif; ?>
          <?php endif; ?>
          <?php endif; ?>
          </div>
          <?php if(isset($bets)) : ?>
          <div class="history">
            <h3>История ставок (<span><?= $count_bets = count($bets); ?></span>)</h3>
            <table class="history__list">
            <?php foreach($bets as $bet) : ?>
              <tr class="history__item">
                <td class="history__name"><?= $bet['name_user']; ?></td>
                <td class="history__price"><?= $bet['price']; ?></td>
                <td class="history__time"><?= showDate(strtotime($bet['date_bet'])); ?></td>
              </tr>
          <?php endforeach; ?>
            </table>
          <?php endif; ?> 
          </div>
        </div>
      </div>
    </section>
</main>