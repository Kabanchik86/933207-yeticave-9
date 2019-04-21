        <main class="container">
            <section class="promo">
                <h2 class="promo__title">Нужен стафф для катки?</h2>
                <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
                <ul class="promo__list">
                    <?php
                    $index = 0;
                    $num = count($categories);
                    while ($index < $num) : ?>
                        <li class="promo__item promo__item--boards">
                            <a class="promo__link" href="pages/all-lots.html"><?=htmlspecialchars($categories[$index]); ?></a>
                            <?php $index++; ?>
                        </li>
                    <?php endwhile; ?>
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
                                <span class="lot__category"><?=htmlspecialchars($val['category']); ?></span>
                                <h3 class="lot__title"><a class="text-link" href="pages/lot.html"><?=htmlspecialchars($val['name']); ?></a></h3>
                                <div class="lot__state">
                                    <div class="lot__rate">
                                        <span class="lot__amount">Стартовая цена</span>
                                        <span class="lot__cost"><?=htmlspecialchars (sum_of_goods($val['price'])); ?><b class="rub"> &ndash; &#8381;</b></span>
                                    </div>
                                    <?php if (checking_time($value) <= 3600 ): ?>
                                    <div class="lot__timer timer timer--finishing">
                                    <?= date('H:i', checking_time($value)); ?> 
                                    </div>
                                    <?php else:?>
                                    <div class="lot__timer timer">
                                    <?= date('H:i', checking_time($value)); ?>
                                    </div>
                                    <?php endif;?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </main>