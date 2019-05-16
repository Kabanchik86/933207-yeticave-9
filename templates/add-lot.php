
  <main>
    <nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($rows as $row) : ?>
        <li class="nav__item">
          <a href="all-lots.html"><?= htmlspecialchars($row['name_category']); ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <form class="form form--add-lot container form--invalid" enctype="multipart/form-data" action="add.php" method="post"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
      <?php $classname = isset($errors['lot_name']) ? "form__item--invalid" : "";
          $value = isset($lot['lot_name']) ? $lot['lot_name'] : ""; ?>
        <div class="form__item <?=$classname;?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot_name" type="text" name="lot_name" value="<?=$value;?>" placeholder="Введите наименование лота">
          <span class="form__error">Введите наименование лота</span>
        </div>
        <?php $classname = isset($errors['name_category']) ? "form__item--invalid" : "";
      $value = isset($lot['name_category']) ? $lot['name_category'] : ""; ?>
        <div class="form__item <?=$classname;?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="name_category">
            <option>Выберите категорию</option>
          <?php foreach ($rows as $row): ?>
            <option><?=htmlspecialchars($row['name_category']);?></option>
            <?php endforeach;?>
          </select>
          <span class="form__error">Выберите категорию</span>
        </div>
      </div>
      <?php $classname = isset($errors['description']) ? "form__item--invalid" : "";
      $value = isset($lot['description']) ? $lot['description'] : ""; ?>
      <div class="form__item form__item--wide <?=$classname;?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="description" value="<?=$value;?>" name="description" placeholder="Напишите описание лота"></textarea>
        <span class="form__error">Напишите описание лота</span>
      </div>
      <?php $classname = isset($errors['picture']) ? "form__item--invalid" : "";
      $value = isset($lot['picture']) ? $lot['picture'] : ""; ?>
      <div class="form__item form__item--file <?=$classname;?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" name="picture" value="30000">
          <label for="lot-img">
            Добавить
          </label>
        </div>
      </div>
      <div class="form__container-three">
      <?php $classname = isset($errors['first_price']) ? "form__item--invalid" : "";
      $value = isset($lot['first_price']) ? $lot['first_price'] : ""; ?>
        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" value="<?=$value;?>" type="text" name="first_price" placeholder="0">
          <span class="form__error">Введите начальную цену</span>
        </div>
        <?php $classname = isset($errors['price_step']) ? "form__item--invalid" : "";
      $value = isset($lot['price_step']) ? $lot['price_step'] : ""; ?>
        <div class="form__item form__item--small <?=$classname;?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" value="<?=$value;?>" type="text" name="price_step" placeholder="0">
          <span class="form__error">Введите шаг ставки</span>
        </div>
        <?php $classname = isset($errors['date_end']) ? "form__item--invalid" : "";
      $value = isset($lot['date_end']) ? $lot['date_end'] : ""; ?>
        <div class="form__item <?=$classname;?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" value="<?=$value;?>"   type="text" name="date_end" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
          <span class="form__error">Введите дату завершения торгов</span>
        </div>
      </div>
      <?php if (isset($errors)): ?>
      <?php foreach($errors as $err => $val): ?>
      <span class="form__error form__error--bottom"><strong><?=$dict[$err];?>: </strong><?=$val;?></span>
      <?php endforeach; ?>
      <?php endif; ?>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>

</div>
