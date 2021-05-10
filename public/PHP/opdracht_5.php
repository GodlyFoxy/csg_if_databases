<?PHP
$titel=str_replace("_"," ",substr(__FILE__,strpos(__FILE__,"opdracht"),-4));
include('opdracht_begin.php');
/****************************
TYP HIERONDER JOUW PHPCODE
****************************/

$reeks=array();
$macht3=array();
//Deze for-loop vult de array $reeks met getallen
for ($t=1;$t<=16;$t++) {
    if ($t%2 == 1){
        array_push($reeks,$t);
    }
}

foreach($reeks as $item) {

    array_push($macht3, pow($item, 3));
}

print_r($reeks);
echo "<br>";
print_r($macht3);
echo "<br>";

$i = 0;
while($macht3[$i] < 1000){
    echo $macht3[$i]." | ";
    $i++;
}

/****************************
EINDE VAN JOUW PHPCODE
****************************/
include('opdracht_eind.php');
?>