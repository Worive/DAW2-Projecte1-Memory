<?php
function checkSize($value): bool
{
    if (is_numeric($value)) {
        return ($value % 2 == 0 && $value > 1 && $value < 23);
    }

    return false;
}

function checkPlayer($value): bool
{
    if (is_numeric($value)) {
        return (in_array($value, [1, 2]));
    }

    return false;
}


if (isset($_POST['size']) && isset($_POST['players'])) {
    $size = htmlspecialchars($_POST["size"]);
    $players = htmlspecialchars($_POST["players"]);

    if (!checkSize($size)) {
        printf('INVALID SIZE VALUE');
    }

    if (!checkPlayer($players)) {
        printf('INVALID PLAYER VALUE');
        return;
    }


} else {
    printf('MISSING POST VALUES!');
}

foreach ($_POST as $key => $value) {
    echo "<br>";
    echo $key . ' -> ' . $value;
}