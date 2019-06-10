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
    <section class="lot-item container">
        <h2>404 Страница не найдена</h2>
        <p>Данной страницы не существует на сайте.</p>
    </section>
</main>

</div>