<main>
  <nav class="nav">
    <ul class="nav__list container">
      <?php foreach ($rows as $row) : ?>
        <li class="nav__item">
          <a href="pages/all-lots.html"><?= htmlspecialchars($row['name_category']); ?></a>
        </li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <section class="rates container">
    <h2>Мои ставки</h2>
    <?php if (isset($bet_data)) : ?>
      <table class="rates__list">
        <?php foreach ($bet_data as $data) : ?>
          <tr class="rates__item">
            <td class="rates__info">
              <div class="rates__img">
                <img src="<?= htmlspecialchars($data['picture']); ?>" width="54" height="40" alt="Сноуборд">
              </div>
              <h3 class="rates__title"><a href="lot.php?id=<?= htmlspecialchars($data['id']); ?>"><?= htmlspecialchars($data['lot_name']); ?></a></h3>
            </td>
            <td class="rates__category">
              <?= htmlspecialchars($data['name_category']); ?>
            </td>
            <td class="rates__timer">
              <?php if (strtotime($data['date_end']) - strtotime('now') <= 3600 && strtotime($data['date_end']) - strtotime('now') > 0) : ?>
                <div class="timer timer--finishing"><?= date('H:i', (strtotime($data['date_end']) - strtotime('now'))); ?></div>
              <?php elseif (strtotime($data['date_end']) - strtotime('now') < 0) : ?>
                <div class="timer timer--end"><?= 'Торги окончены'; ?></div>
              <?php elseif (strtotime($data['date_end']) - strtotime('now') > 0) : ?>
                <div class="timer">
                  <?= date('H:i', (strtotime($data['date_end']) - strtotime('now'))); ?>
                <?php endif; ?>
            </td>
            <td class="rates__price">
              <?= htmlspecialchars($data['price_bet']); ?>
            </td>
            <td class="rates__time">
              <?= $remaining_minutes ?>
              <?= get_noun_plural_form($remaining_minutes, 'час', 'часа', 'часов'); ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    <?php else : ?>
      <table class="rates__list">
      </table>
    <?php endif; ?>
  </section>
</main>

</div>