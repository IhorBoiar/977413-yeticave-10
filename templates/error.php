<main>
<h1></h1>
<nav class="nav">
<ul class="nav__list container">
    <?php foreach($categories as $cat) : ?>
        <li class="nav__item">
          <a href="./category.php?category=<?= $cat['sim_code']; ?>"><?= $cat['name']; ?></a>
        </li>
    <?php endforeach; ?>
      </ul>
        </nav>
        <section class="lot-item container">
            <h2><?= $error_message; ?></h2>
                    </section>
</main>