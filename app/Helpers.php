<?php


function randomHexColor()
{
    $characters = '0123456789ABCDEF';
    $color = '#';
    for ($i = 0; $i < 6; $i++) {
        $color .= $characters[rand(0, 15)];
    }
    return $color;
}
