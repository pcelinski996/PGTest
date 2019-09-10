<?php

//getStuff('2019-09-01');
function getStuff($start,$end)
{

    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, 'http://api.nbp.pl/api/exchangerates/tables/C/'.$start.'/'.$end.'/');
    curl_setopt($c, CURLOPT_POST, false);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
    $wynik = curl_exec($c);
    curl_close($c);
    $array =json_decode($wynik,true);
    foreach ($array as $item) {
        echo '<div class="alert alert-light">';
        print_r('Dane z dnia: '.$item['tradingDate']);
        echo '<br>';
        print_r('Obowiązujące od dnia: '.$item['effectiveDate']);
        echo '<br>';
        foreach ($item['rates'] as $rate)
        {
            if($rate['code']=='USD')
            {
                print_r('Cena kupna: '.$rate['bid']);
                echo '<br>';
                print_r('Cena sprzedaży: '.$rate['ask']);
                echo '<br>';
                $diff = $rate['ask']-$rate['bid'];
                print_r('Różnica cen: '.$diff);
            }
        }
        echo '</div>';
    }
}


function countdown($d1)
{
    $d2 = date('Y-m-d');
    $start =date_create($d1);
    $end = date_create($d2);

     $xd =(array) date_diff($end,$start);

    $days = $xd['days'];
    $qwe = $d1;
    $n= ceil($days/90);

    $licznik = 0;
    for($i=1;$i<$n;$i++)
    {
        $l = 90*$i;
        $date = strtotime($d1);
        $date = strtotime("+".$l." day", $date);

        $rty =date('Y-m-d', $date);
        getStuff($qwe,$rty);
        $qwe = $rty;
        $licznik++;
    }

    getStuff($qwe,$d2);
}