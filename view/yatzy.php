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
$score = $score ?? [];

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

<!-- <form method="post" action="yatzy/endround">
    <input type="submit" name="submit" value="Räkna rundans poäng">
</form> -->
<form method="post" action="yatzy/newround">
    <input type="submit" name="submit" value="Ny runda">
</form>
<!-- <form method="post" action="game21/reset">
    <input type="submit" name="submit" value="Nollställ poängen">
</form> -->

<table>
    <tr>
        <th>Spelare</th>
        <th>Player1</th>
    </tr>
    <tr>
        <td>Ettor</td>
        <td><?= isset($score["1"]) ? $score["1"] : ""; ?></td>
    </tr>
    <tr>
        <td>Tvåor</td>
        <td><?= isset($score["2"]) ? $score["2"] : ""; ?></td>
    </tr>
    <tr>
        <td>Treor</td>
        <td><?= isset($score["3"]) ? $score["3"] : ""; ?></td>
    </tr>
    <tr>
        <td>Fyror</td>
        <td><?= isset($score["4"]) ? $score["4"] : ""; ?></td>
    </tr>
    <tr>
        <td>Femmor</td>
        <td><?= isset($score["5"]) ? $score["5"] : ""; ?></td>
    </tr>
    <tr>
        <td>Sexor</td>
        <td><?= isset($score["6"]) ? $score["6"] : ""; ?></td>
    </tr>
    <tr>
        <th>Bonus</th>
        <th><?= isset($score["bonus"]) ? $score["bonus"] : "-"; ?></th>
    </tr>
    <tr>
        <th>Summa</th>
        <th><?= isset($score["summa"]) ? $score["summa"] : ""; ?></th>
    </tr>
</table>
