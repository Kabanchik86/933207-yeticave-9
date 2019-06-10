  <main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($rows as $row) : ?>
          <li class="nav__item">
            <a href="index.php?search=<?= htmlspecialchars($row['name_category']); ?>"><?= htmlspecialchars($row['name_category']); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="container">
      <section class="lots">
        <?php if ($search) : ?>
          <h2>Результаты поиска по запросу «<span><?= $search; ?></span>»</h2>
        <?php else : ?>
          <h2>Результаты поиска по запросу «<span>Ничего не найдено по вашему запросу</span>»</h2>
        <?php endif; ?>
        <?php if (isset($goods)) : ?>
          <ul class="lots__list">
            <?php foreach ($goods as $key => $val) : ?>
              <li class="lots__item lot">
                <div class="lot__image">
                  <img src="<?= $val['picture']; ?>" width="730" height="548" alt="Сноуборд">
                </div>
                <div class="lot__info">
                  <span class="lot__category"><?= htmlspecialchars($val['name_category']); ?></span>
                  <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= htmlspecialchars($val['id']); ?>"><?= htmlspecialchars($val['lot_name']); ?></a></h3>
                  <div class="lot__state">
                    <div class="lot__rate">
                      <span class="lot__amount">Стартовая цена</span>
                      <span class="lot__cost"><?= htmlspecialchars(sum_of_goods($val['first_price'])); ?><b class="rub">р</b></span>
                    </div>
                    <?php if (strtotime($val['date_end']) - strtotime('now') <= 3600 && strtotime($val['date_end']) - strtotime('now') > 0) : ?>
                      <div class="lot__timer timer timer--finishing">
                        <?= date('H:i', (strtotime($val['date_end']) - strtotime('now'))); ?>
                      </div>
                    <?php elseif (strtotime($val['date_end']) - strtotime('now') < 0) : ?>
                      <div class="lot__timer timer">
                        <?= 'Торги окончены'; ?>
                      </div>
                    <?php elseif (strtotime($val['date_end']) - strtotime('now') > 0) : ?>
                      <div class="lot__timer timer">
                        <?= date('H:i', (strtotime($val['date_end']) - strtotime('now'))); ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else : ?>
          <ul class="lots__list">
            <li class="lots__item lot">
            </li>
          </ul>
        <?php endif; ?>
      </section>
      <ul class="pagination-list">
        <?php if ($back_button > 0) : ?>
          <li class="pagination-item pagination-item-prev"><a href="search.php?search=<?= $search; ?>&page=<?= $back_button; ?>">Назад</a></li>
        <?php else : ?>
          <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php endif; ?>
        <?php if ($pages_count != 0) : ?>
          <?php foreach ($pages as $page) : ?>
            <li class="pagination-item"><a href="search.php?search=<?= $search; ?>&page=<?= $page; ?>"><?= $page; ?></a></li>
          <?php endforeach; ?>
        <?php else : ?>
          <li class="pagination-item"><a></a></li>
        <?php endif; ?>
        <?php if ($next_button <= $pages_count) : ?>
          <li class="pagination-item pagination-item-next"><a href="search.php?search=<?= $search; ?>&page=<?= $next_button; ?>">Вперед</a></li>
        <?php else : ?>
          <li class="pagination-item pagination-item-next"><a>Вперед</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </main>

  </div>