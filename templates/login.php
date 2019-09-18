    <nav class="nav">
    <ul class="nav__list container">
    <?php foreach($categories as $cat) : ?>
        <li class="nav__item">
          <a href="<?= $cat['sim_code']; ?>"><?= $cat['name']; ?></a>
        </li>
    <?php endforeach; ?>
      </ul>
    </nav>

    <?php $form_error = isset($errors) ? "form--invalid" : ""; ?>

    <form class="form container <?=$form_error;?>" action="./login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>

      <?php $error_email = isset($errors['email']) ? "form__item--invalid" : ""; ?>

      <div class="form__item <?=$error_email;?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email');?>">
        
    <?php if (isset($errors['email'])) {
            echo "<span class='form__error'>" . $errors['email'] . "</span>";
           }
           var_dump($errors['email']); 
           ?>
     
    </div>

      <?php $error_password = isset($errors['password']) ? "form__item--invalid" : ""; ?>

      <div class="form__item form__item--last <?=$error_password;?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=getPostVal('password');?>">
        
    <?php if (isset($errors['password'])) {
            echo "<span class='form__error'>" . $errors['password'] . "</span>";
           }
           var_dump($errors['password']); 
           ?>

      </div>
      <button type="submit" class="button">Войти</button>
    </form>