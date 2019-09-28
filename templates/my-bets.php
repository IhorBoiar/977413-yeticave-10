<nav class="nav">
      <ul class="nav__list container">
    <?php foreach($categories as $cat) : ?>
        <li class="nav__item">
          <a href=<?= $cat['sim_code']; ?>><?= $cat['name']; ?></a>
        </li>
    <?php endforeach; ?>
      </ul>
    </nav>
    <section class="rates container">
    
    
  
    
      <h2>Мои ставки</h2>
      <table class="rates__list">
  
     <?php echo var_dump($id_user); ?>
      <?php foreach($bets as $bet) : ?>
    <!--  -->
    <?php   
                        $arr = get_dt_range($bet['time_exit']); 
                        $hour = $arr[0];
                        $min = $arr[1];
                        $winner = $bet['winner_id'];            
                        // echo var_dump($winner);
                        echo "<br>";
                        
                        
                        ?>
                      
                      
      
<tr class="rates__item <?php if ($hour <= 0 and $min <= 0) { 
        if ($winner !== $id_user) {
          echo "rates__item--end";  
        } else {
          echo "rates__item--win";
        }} ?>">

         <!--  -->
          <td class="rates__info">
            <div class="rates__img">
              <img src="../<?= $bet['img']; ?>" width="54" height="40" alt="Сноуборд">
            </div>
            <?php if ($winner !== $id_user) : ?>         
            <h3 class="rates__title"><a href="lot.php?id=<?=$bet['lot_id'];?>"><?=$bet['name_lot'];?></a></h3>
          
            <?php else : ?>
            <div>
            <h3 class="rates__title"><a href="lot.php?id=<?=$bet['lot_id'];?>"><?=$bet['name_lot'];?></a></h3>
              <p><?= $bet['cont_user']; ?></p>
            </div>
          
<?php endif; ?>
          </td>
          <td class="rates__category">
          <?=$bet['name_cat'];?>
          </td>
          <td class="rates__timer">

          
            <div class="timer <?php if ($hour < 1) { 
              if ($hour <= 0 and $min <= 0) {
                if ($winner !== $id_user) {
                echo "timer--end";
              } else {
                echo "timer--win";
              }
              } else {
                echo "timer--finishing";  
              }
            }
             
            ?>">
            <?php if ($hour <= 0 and $min <= 0) {
              if ($winner !== $id_user) {
                echo "Торги окончены";
              } else { 
                echo "Ставка выиграла";
              }
            } else {
              echo $hour . ':' . $min;
            }
            ?> 
            <!-- //   echo "Торги окончены"; }
            //  elseif ($winner) {echo "Ставка выиграла";}
            //  else { echo $hour . ':' . $min;}  -->
           </div>


          </td>
          <td class="rates__price">
          <?=formatPrice_2($bet['price_bet']);?> р
          </td>
          <td class="rates__time">
          <?=$bet['date_bet'];?>
          </td>
        </tr>

        <?php endforeach; ?>
  
<!-- 
        <tr class="rates__item rates__item--win">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../img/rate3.jpg" width="54" height="40" alt="Крепления">
            </div>
            <div>
              <h3 class="rates__title"><a href="lot.html">Крепления Union Contact Pro 2015 года размер L/XL</a></h3>
              <p>Телефон +7 900 667-84-48, Скайп: Vlas92. Звонить с 14 до 20</p>
            </div>
          </td>
          <td class="rates__category">
            Крепления
          </td>
          <td class="rates__timer">
            <div class="timer timer--win">Ставка выиграла</div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            Час назад
          </td>
        </tr>
 
        <tr class="rates__item rates__item--end">
          <td class="rates__info">
            <div class="rates__img">
              <img src="../img/rate5.jpg" width="54" height="40" alt="Куртка">
            </div>
            <h3 class="rates__title"><a href="lot.html">Куртка для сноуборда DC Mutiny Charocal</a></h3>
          </td>
          <td class="rates__category">
            Одежда
          </td>
          <td class="rates__timer">
            <div class="timer timer--end">Торги окончены</div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            Вчера, в 21:30
          </td>
        </tr> -->
      </table>
    </section>