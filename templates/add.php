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
    <?php $form_error = isset($errors) ? "form--invalid" : ""; ?>
    <form class="form form--add-lot container <?= $form_error; ?>" action="./add.php" method="post" enctype="multipart/form-data">
      <h2>Добавление лота</h2>
      <div class="form__container-two">
          <?php $error_name = isset($errors['lot-name']) ? "form__item--invalid" : "1"; ?>
          <div class="form__item <?= $error_name; ?>">
            <label for="lot-name">Наименование <sup>*</sup></label>          
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=getPostVal('lot-name');?>">
            <?php if (isset($errors['lot-name'])) {
                      echo "<span class='form__error'>" . $errors['lot-name'] . "</span>";
                    } 
            ?> 
          </div>
          <div class="form__item">
            <label for="category">Категория <sup>*</sup></label>
            <select id="category" name="category">
            <option value="" disabled>Выберите категорию</option>
            <?php foreach($categories as $cat) : ?>
            <option value="<?= $cat['id']?>"<?php if($cat['id'] == getPostVal('category')) {echo " selected";} ?> "><?= $cat['name']; ?></option>
            <?php endforeach; ?>
            </select>
          </div>
      </div>
      <?php $error_message = isset($errors['message']) ? "form__item--invalid" : "1"; ?>        
      <div class="form__item form__item--wide <?= $error_message; ?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="message"
         placeholder="Напишите описание лота"><?=getPostVal('message');?></textarea>
         <?php if (isset($errors['message'])) {
              echo "<span class='form__error'>" . $errors['message'] . "</span>";
           } 
          ?>
      </div>
      <div class="form__item form__item--file">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" name="img">
          <?php if (isset($errors['img'])) {
              echo "<span>" . $errors['img'] . "</span>";
           } 
      ?> 
          <label for="lot-img">
            Добавить
          </label>         
        </div> 
      </div>
      <div class="form__container-three">
      <?php $error_rate = isset($errors['lot-rate']) ? "form__item--invalid" : "1"; ?>
        <div class="form__item form__item--small <?= $error_rate; ?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot-rate" placeholder="0" value="<?=getPostVal('lot-rate');?>">
          <?php if (isset($errors['lot-rate'])) {
                  echo "<span class='form__error'>" . $errors['lot-rate'] . "</span>";
                  }
          ?>
        </div>
        <?php $error_step = isset($errors['lot-step']) ? "form__item--invalid" : "1"; ?>
        <div class="form__item form__item--small <?= $error_step; ?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot-step"
           placeholder="0" value="<?=getPostVal('lot-step');?>">
           <?php if (isset($errors['lot-step'])) {
                      echo "<span class='form__error'>" . $errors['lot-step'] . "</span>";
                   }
            ?>
        </div>    
        <?php $error_date = isset($errors['lot-date']) ? "form__item--invalid" : "1"; ?> 
        <div class="form__item <?= $error_date; ?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot-date" 
          placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=getPostVal('lot-date');?>">
        <?php if (isset($errors['lot-date'])) {
                echo "<span class='form__error'>" . $errors['lot-date'] . "</span>";
                }
        ?>
        </div>
      </div>
      <?php
        if(isset($errors)) {
            echo "<span class='form__error form__error--bottom'>Пожалуйста, исправьте ошибки в форме.</span>";
            }
       ?>
      <button type="submit" class="button">Добавить лот</button>
    </form>
</main>