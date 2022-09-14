<?php
$page = str_replace(
        '#',
        '',
    basename(htmlspecialchars($_SERVER['REQUEST_URI']))
);


function isActive($pageName, $page, $alsoDefault): void
{

    if ($alsoDefault) {
        if ($page === 'index.php' || $page === 'DAW2-Projecte1-Memory') {
            echo ' active';
        }
    } else {
        if ($page === $pageName) {
            echo ' active';
        }
    }

}

?>

<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom px-5">
    <a href="/DAW2-Projecte1-Memory/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <span class="fs-4">Projecte 1: Memograma</span>
    </a>

    <ul class="nav nav-pills">
        <li class="nav-item">
            <a href="/DAW2-Projecte1-Memory/" class="nav-link<?php isActive('memory.php', $page, true) ?>" aria-current="page">Game</a>
        </li>
        <li class="nav-item">
            <a href="leaderboard.php" class="nav-link<?php isActive('leaderboard.php', $page, false) ?>">Leaderboard</a>
        </li>
    </ul>
</header>