<?php

function percentile(array $items, float $procent, bool $high = false): int|float
{
    $high ? rsort($items) : sort($items);
    $key = (int)(($procent / 100) * count($items));
    $value = 0;
    if ($high) {
        for ($i = 0; $i <= $key; $i++) {
            $value += $items[$i];
        }
        $value = $value / ($key + 1);
    } else {
        $value = $key;
    }
    return $value;
}
