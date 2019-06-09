        <main class="container">
            <section class="promo">
                <h2 class="promo__title">Нужен стафф для катки?</h2>
                <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
                <ul class="promo__list">
                    <?php foreach ($rows as $row) : ?>
                        <li class="promo__item promo__item--<?= htmlspecialchars($row['symbol_code']); ?>">
                            <a class="promo__link" href="index.php?search=<?= htmlspecialchars($row['name_category']); ?>"><?= htmlspecialchars($row['name_category']); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section class="lots">
                <div class="lots__header">
                    <h2>Открытые лоты</h2>
                </div>
                <ul class="lots__list">
                    <?php foreach ($goods as $key => $val) : ?>
                        <li class="lots__item lot">
                            <div class="lot__image">
                                <img src="<?= $val['picture']; ?>" width="350" height="260" alt="">
                            </div>
                            <div class="lot__info">
                                <span class="lot__category"><?= htmlspecialchars($val['name_category']); ?></span>
                                <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= htmlspecialchars($val['id']); ?>"><?= htmlspecialchars($val['lot_name']); ?></a></h3>
                                <div class="lot__state">
                                    <div class="lot__rate">
                                        <span class="lot__amount">Стартовая цена</span>
                                        <span class="lot__cost"><?= htmlspecialchars(sum_of_goods($val['first_price'])); ?><b class="rub"> &ndash; &#8381;</b></span>
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
            </section>
            <?php if ($pages_count > 1) : ?>
        <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a></a></li>
        <?php if (isset($search)):?>  
        <?php foreach ($pages as $page) : ?>
            <li class="pagination-item"><a href="index.php?search=<?=$search; ?>&page=<?=$page; ?>"><?=$page; ?></a></li>
          <?php endforeach; ?>
          <?php else :?>
          <?php foreach ($pages as $page) : ?>
          <li class="pagination-item"><a href="index.php?page=<?=$page; ?>"><?=$page; ?></a></li>
          <?php endforeach; ?>
        <?php endif;?>
          <li class="pagination-item"><a></a></li>
        <li class="pagination-item pagination-item-next"><a></a></li>
      </ul>
      <?php else : ?>
      <?php endif; ?>
        </main>
        </div>