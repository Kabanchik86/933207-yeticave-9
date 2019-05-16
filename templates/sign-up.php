
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
      <form class="form container" action="sign-up.php" method="post" autocomplete="off">
        <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
        $value = isset($sign_up['email']) ? $sign_up['email'] : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <!-- form__item--invalid -->
          <label for="email">E-mail <sup>*</sup></label>
          <input id="email" value="<?= $value; ?>" type="text" name="email" placeholder="Введите e-mail">
          <span class="form__error"><?=$errors['email']?></span>
        </div>
        <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
        $value = isset($sign_up['password']) ? $sign_up['password'] : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="password">Пароль <sup>*</sup></label>
          <input id="password" value="<?= $value; ?>" type="password" name="password" placeholder="Введите пароль">
          <span class="form__error">Введите пароль</span>
        </div>
        <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
        $value = isset($sign_up['name']) ? $sign_up['name'] : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="name">Имя <sup>*</sup></label>
          <input id="name" value="<?= $value; ?>" type="text" name="name" placeholder="Введите имя">
          <span class="form__error">Введите имя</span>
        </div>
        <?php $classname = isset($errors['contact']) ? "form__item--invalid" : "";
          $value = isset($sign_up['contact']) ? $sign_up['contact'] : ""; ?>
        <div class="form__item <?= $classname; ?>">
          <label for="message">Контактные данные <sup>*</sup></label>
          <textarea id="message" value="<?= $value; ?>" name="contact" placeholder="Напишите как с вами связаться"></textarea>
          <span class="form__error">Напишите как с вами связаться</span>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
      </form>
    </main>

  </div>

  