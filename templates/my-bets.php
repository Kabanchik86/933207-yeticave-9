
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
      <table class="rates__list">
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="img/lot-1.jpg" width="54" height="40" alt="Сноуборд">
            </div>
            <h3 class="rates__title"><a href="lot.html">2014 Rossignol District Snowboard</a></h3>
          </td>
          <td class="rates__category">
            Доски и лыжи
          </td>
          <td class="rates__timer">
            <div class="timer timer--finishing">07:13:34</div>
          </td>
          <td class="rates__price">
            10 999 р
          </td>
          <td class="rates__time">
            5 минут назад
          </td>
        </tr>
      </table>
    </section>
  </main>

</div>

