<?php

class Boring
{
    public function doBoringStuff($m, $n, $someConst, $p = null)
    {
        $mToN = $m/$n;

        return $mToN - $someConst(sqrt(($mToN * (1 - $mToN)/$n)));
    }

    public function secondBoringStuff($s, $u, $n, $s)
    {

    }
}

$imBored = new Boring();