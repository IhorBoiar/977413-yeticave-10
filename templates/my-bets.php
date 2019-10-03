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
      <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
        <?php foreach($bets as $bet) : ?>
        <?php   
          $arr = get_dt_range($bet['time_exit']); 
          $hour = $arr[0];
          $min = $arr[1];
          $winner = $bet['winner_id'];            
        ?>
  <tr class="rates__item
      <?php if ($hour <= 0 and $min <= 0) { 
          if ($winner !== $id_user) {
            echo "rates__item--end";  
          } else {
            echo "rates__item--win";
          }
        } 
        ?>">
      <td class="rates__info">
          <div class="rates__img">
            <img src="../<?= $bet['img']; ?>" width="54" height="40" alt="<?= htmlspecialchars($bet['name_lot']); ?>">
          </div>
          <?php if ($winner !== $id_user) : ?>         
          <h3 class="rates__title"><a href="lot.php?id=<?=$bet['lot_id'];?>"><?=htmlspecialchars($bet['name_lot']);?></a></h3>
          <?php else : ?>
          <div>
          <h3 class="rates__title"><a href="lot.php?id=<?=$bet['lot_id'];?>"><?=htmlspecialchars($bet['name_lot']);?></a></h3>
            <p><?= htmlspecialchars($bet['cont_user']); ?></p>
          </div>
        <?php endif; ?>
        </td>
        <td class="rates__category">
            <?=$bet['name_cat'];?>
            </td>
            <td class="rates__timer">  
              <div class="timer
              <?php if ($hour < 1) { 
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
            </div>
        </td>
        <td class="rates__price">
            <?=formatPrice_2($bet['price_bet']);?> р
        </td>
        <td class="rates__time">
        <?= showDate(strtotime($bet['date_bet'])); ?>
        </td>
      </tr>
          <?php endforeach; ?>
        </table>
      </section>
</main>
