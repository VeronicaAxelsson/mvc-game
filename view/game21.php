<?php

/**
 * View for Game 21.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$sumPlayer = $sumPlayer ?? 0;
$sumComputer = $sumComputer ?? 0;
$pointsPlayer = $pointsPlayer ?? 0;
$pointsComputer = $pointsComputer ?? 0;
$classes = $classes ?? []; ?>




<h1>Spela 21 mot datorn</h1>

<div class="points">
    <p><b>Poängställning</b></p>
    <p>Antal vinster för datorn: <?= $pointsComputer ?></p>
    <p>Antal vinster för dig: <?= $pointsPlayer ?></p>
</div>

<div class="points">
    <p><b>Sammanlagda slag denna omgången</b></p>
    <p>Datorn: <?= $sumComputer ?></p>
    <p>Du: <?= $sumPlayer ?></p>
</div>

<p><?= $message ?></p>

<form method="post" action="game21">
    <label>1
    <input type="radio" name="die" value="1">
    </label>
    <label>2
    <input type="radio" name="die" value="2">
    </label>
    <input type="submit" name="submit" value="Kasta">
</form>

<div class="dice">
<?php
foreach ($classes as $class) {
    ?>
    <i class="dice-sprite <?= $class ?>"></i>
    <?php
}
?>
</div>

<form method="post" action="game21/end">
    <input type="submit" name="submit" value="Stanna">
</form>
<form method="post" action="game21/newround">
    <input type="submit" name="submit" value="Ny runda">
</form>
<form method="post" action="game21/reset">
    <input type="submit" name="submit" value="Nollställ poängen">
</form>
