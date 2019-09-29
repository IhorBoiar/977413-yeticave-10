<nav class="nav">
      <ul class="nav__list container">
    <?php foreach($categories as $cat) : ?>
        <li class="nav__item">
          <a href="<?= $cat['sim_code']; ?>"><?= $cat['name']; ?></a>
        </li>
    <?php endforeach; ?>
      </ul>
</nav>
<br>
<?php $form_error = isset($errors) ? "form--invalid" : ""; ?>
<form class="form container <?= $form_error; ?>" action="./sign-up.php" method="post" autocomplete="off">
    <h2>Регистрация нового аккаунта</h2>
    <?php $error_email = isset($errors['email']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $error_email; ?>"> <!-- form__item--invalid -->
    <label for="email">E-mail <sup>*</sup></label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=getPostVal('email');?>">
    <?php if (isset($errors['email'])) {
              echo "<span class='form__error'>" . $errors['email'] . "</span>";
          }      
    ?>
    </div>
    <?php $error_password = isset($errors['password']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $error_password; ?>">
    <label for="password">Пароль <sup>*</sup></label>
    <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=getPostVal('password');?>">
    <?php if (isset($errors['password'])) {
            echo "<span class='form__error'>" . $errors['password'] . "</span>";
           } 
           ?>
    </div>
    <?php $error_name = isset($errors['name']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $error_name; ?>">
    <label for="name">Имя <sup>*</sup></label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=getPostVal('name');?>">
    <?php if (isset($errors['name'])) {
                echo "<span class='form__error'>" . $errors['name'] . "</span>";
          } 
    ?>
    </div>
    <?php $error_message = isset($errors['message']) ? "form__item--invalid" : ""; ?>
    <div class="form__item <?= $error_message; ?>">
    <label for="message">Контактные данные <sup>*</sup></label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?=getPostVal('message');?></textarea>
    <?php if (isset($errors['message'])) {
                echo "<span class='form__error'>" . $errors['message'] . "</span>";
          } 
    ?>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>