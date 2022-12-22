<?php

if (
    $_POST['vardas'] == 'admin'
    &&
    $_POST['slaptazodis'] == '123'
) {
    echo "Sveiki prisijunge, " . $_POST['vardas'];
} else {
    echo "Neteisingi prisijungiumo duomenys";
}

