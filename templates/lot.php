    <nav class="nav">
      <ul class="nav__list container">
    <?php foreach($categories as $cat) : ?>
        <li class="nav__item">
          <a href=<?= $cat['sim_code']; ?>><?= $cat['name']; ?></a>
        </li>
    <?php endforeach; ?>
      </ul>
    </nav>
    <section class="lot-item container">

      <h2><?= $lot['name_lot']; ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="../<?= $lot['img']; ?>" width="730" height="548" alt="<?= $lot['name']; ?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= $lot['name_cat']; ?></span></p>
          <p class="lot-item__description"><?= $lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
        <?php   
            $arr = get_dt_range($lot['time_exit']); 
            $hour = $arr[0];
            $min = $arr[1];
            ?>
            <div class="lot-item__timer timer <?php if ($hour < 1) { echo "timer--finishing"; } ?>">
            <?php echo $hour . ':' . $min; ?>
            </div> 
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
              
              
               
              <?php if (!$price_lot) : ?>
                  
                   <span class="lot-item__amount">Стартовая цена</span>
                  <span class="lot-item__cost"><?= formatPrice($lot['price']); ?></span>
              
               <?php else : ?> 
                  
                   <span class="lot-item__amount">Текущая цена</span>
                  <span class="lot-item__cost"><?= formatPrice($price_lot); ?></span>    
               <?php endif; ?>
                </div>
              <div class="lot-item__min-cost">
<?php 
// echo var_dump($price_lot);
?>
              <?php if ($price_lot) :?>
                Мин. ставка <span><?=formatPrice_2($bet_step);?> р</span>
                <?php else :?>
                <?php  
                $lot_bet = (int)$lot['round_of_bet'];
                $price = (int)$lot['price'];
                $min_bet = $lot_bet + $price; 
                ?>
                Мин. ставка <span><?=formatPrice_2($min_bet);?> р</span>
            <?php endif; ?>
              </div>
            </div>
        </div>    
        
        <?php if($_SESSION['email']):?>
            <form class="lot-item__form" action="" method="post" autocomplete="off">

            <?php $form_error = isset($errors['cost']) ? "form__item--invalid" : ""; ?>


              <p class="lot-item__form-item form__item <?= $form_error; ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?=$min_bet;?>" value="<?=getPostVal('cost');?>">
               
                <?php if (isset($errors['cost'])) {
            echo "<span class='form__error'>" . $errors['cost'] . "</span>";
           }
           
           ?>

         </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
          <!-- ///////// -->
          <?php if($bets) : ?>
          <div class="history">
            <h3>История ставок (<span>10</span>)</h3>
            <table class="history__list">
            <?php foreach($bets as $bet) : ?>
              <tr class="history__item">
                <td class="history__name"><?= $bet['name_user']; ?></td>
                <td class="history__price"><?= $bet['price']; ?></td>
                <td class="history__time"><?= $bet['date']; ?></td>
              </tr>
          <?php endforeach; ?>
            </table>
          </div>
          <?php endif; ?>
          <?php endif; ?> 
        </div>
      </div>
    </section>
  