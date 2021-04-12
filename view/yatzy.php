<?php

/**
 * View for Game 21.
 */

declare(strict_types=1);

// var_dump($_POST);

$header = $header ?? null;
$message = $message ?? null;
$sumPlayer = $sumPlayer ?? 0;
$sumComputer = $sumComputer ?? 0;
$pointsPlayer = $pointsPlayer ?? 0;
$pointsComputer = $pointsComputer ?? 0;
$values = $values ?? [];
$savedValues = $savedValues ?? [];
$post = $post ?? null;
$sum = $sum ?? 0;

// var_dump($post);
var_dump($data);
 ?>




<h1>Yatzy</h1>

<div class="points">
    <p><b>Total poäng</b></p>
    <p><?= $_SESSION["yatzySum"] ?></p>
</div>

<div class="points">
    <p><b>Rundans poöng</b></p>
    <p><?= $sum ?></p>
</div>

<p><?= $message ?></p>

<div class="dice">
    <form method="post" action="yatzy/throw">
        <?php
        foreach ($values as $key => $value) {
        ?>
        <i class="dice-sprite dice-<?= $value ?>"></i>
        <input type="checkbox" name="<?= $key ?>" value="<?= $value ?>">
        <?php
        }
        ?>
        <input type="submit" name="submit" value="Kasta">
    </form>
</div>

<div class="dice">
    <?php
    foreach ($savedValues as $value) {
    ?>
    <i class="dice-sprite dice-<?= $value ?>"></i>
    <?php
    }
    ?>
</div>

<form method="post" action="yatzy/endround">
    <input type="submit" name="submit" value="Räkna rundans poäng">
</form>
<form method="post" action="yatzy/newround">
    <input type="submit" name="submit" value="Ny runda">
</form>
<!-- <form method="post" action="game21/reset">
    <input type="submit" name="submit" value="Nollställ poängen">
</form> -->
