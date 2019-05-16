
    <main>
      <nav class="nav">
        <ul class="nav__list container">
        <?php foreach ($rows as $row): ?>
                    <li class="nav__item">
                        <a href="pages/all-lots.html"><?=htmlspecialchars($row['name_category']);?></a>
                    </li>
                <?php endforeach;?>
        </ul>
      </nav>
      <section class="lot-item container">
        <?php foreach ($param as $key => $val): ?>
          <h2><?=htmlspecialchars($val['lot_name']);?></h2>
          <div class="lot-item__content">
            <div class="lot-item__left">
              <div class="lot-item__image">
                <img src="<?=$val['picture'];?>" width="730" height="548" alt="Сноуборд">
              </div>
              <p class="lot-item__category">Категория: <span><?=htmlspecialchars($val['name_category']);?></span></p>
              <p class="lot-item__description"><?=htmlspecialchars($val['description']);?></p>
            </div>
            <?php if (isset($_SESSION['user'])): ?>
            <div class="lot-item__right">
              <div class="lot-item__state">
                <?php if (checking_time($value) <= 3600): ?>
                  <div class="lot__timer timer timer--finishing">
                    <?=date('H:i', checking_time($value));?>
                  </div>
                <?php else: ?>
                  <div class="lot-item__timer timer">
                    <?=date('H:i', checking_time($value));?>
                  </div>
                <?php endif;?>
                <div class="lot-item__cost-state">
                  <div class="lot-item__rate">
                    <span class="lot-item__amount">Текущая цена</span>
                    <span class="lot-item__cost"><?=htmlspecialchars($val['first_price']);?></span>
                  </div>
                  <div class="lot-item__min-cost">
                    Мин. ставка <span><?=htmlspecialchars($val['price_step']);?></span>
                  </div>
                </div>
                <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
                  <p class="lot-item__form-item form__item form__item--invalid">
                    <label for="cost">Ваша ставка</label>
                    <input id="cost" type="text" name="cost" placeholder="12 000">
                    <span class="form__error">Введите наименование лота</span>
                  </p>
                  <button type="submit" class="button">Сделать ставку</button>
                </form>
              </div>
              <?php else: ?>
              <div class="lot-item__right">
              <div class="lot-item__state">
                <?php if (checking_time($value) <= 3600): ?>
                  <div class="lot__timer timer timer--finishing">
                    <?=date('H:i', checking_time($value));?>
                  </div>
                <?php else: ?>
                  <div class="lot-item__timer timer">
                    <?=date('H:i', checking_time($value));?>
                  </div>
                <?php endif;?>
                <div class="lot-item__cost-state">
                  <div class="lot-item__rate">
                    <span class="lot-item__amount">Текущая цена</span>
                    <span class="lot-item__cost"><?=htmlspecialchars($val['first_price']);?></span>
                  </div>
                  <div class="lot-item__min-cost">
                    Мин. ставка <span><?=htmlspecialchars($val['price_step']);?></span>
                  </div>
                </div>
              </div>
                <?php endif; ?>
              <div class="history">
                <h3>История ставок </h3>
                <table class="history__list">
                  <tr class="history__item">
                    <td class="history__name">Иван</td>
                    <td class="history__price">10 999 р</td>
                    <td class="history__time">5 минут назад</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        <?php endforeach;?>
      </section>
    </main>

  </div>

