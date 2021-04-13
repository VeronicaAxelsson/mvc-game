<?php

/**
 * View for Game 21.
 */

declare(strict_types=1);

// var_dump($_POST);

$header = $header ?? null;
$message = $message ?? null;
$values = $values ?? [];
$savedValues = $savedValues ?? [];
$score = $score ?? [];

$tableValues = [
    "1" => "Ettor",
    "2" => "Tvåor",
    "3" => "Treor",
    "4" => "Fyror",
    "5" => "Femmor",
    "6" => "Sexor"
];
// var_dump($data);
 ?>


<h1>Yatzy</h1>

<form class="" action="yatzy/newround" method="post">
    <table>
        <tr>
            <th>Spelare</th>
            <th>Player1</th>
        </tr>
        <?php foreach ($tableValues as $key => $value) { ?>
            <tr>
                <tr>
                    <td>
                        <?php if (isset($score[$key])) { ?>
                            <?= $value ?>
                        <?php } else { ?>
                            <button name="diceValue" value="<?= $key ?>" type="submit"><?= $value ?></button>
                        <?php } ?>
                    </td>
                    <td><?= isset($score[$key]) ? $score[$key] : ""; ?></td>
                </tr>
            </tr>
        <?php } ?>
        <tr>
            <th>Bonus</th>
            <th><?= isset($score["bonus"]) ? $score["bonus"] : "-"; ?></th>
        </tr>
        <tr>
            <th>Summa</th>
            <th><?= isset($score["summa"]) ? $score["summa"] : ""; ?></th>
        </tr>
    </table>
</form>

<p><?= $message ?></p>

<?php if ($message === "Tryck på kasta för att kasta tärningarna!" || $message === "Välj vilka tärningar du vill behålla, och kasta igen."): ?>
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
            <input type="submit" name="throw" value="Kasta">
        </form>
    </div>
<?php endif; ?>


<div class="dice">
    <?php
    foreach ($savedValues as $value) {
    ?>
    <i class="dice-sprite dice-<?= $value ?>"></i>
    <?php
    }
    ?>
</div>

<?php if ($message === "Game over"): ?>
    <form method="post" action="yatzy/newgame">
        <input type="submit" name="submit" value="Nytt spel">
    </form>
<?php endif; ?>
