<?php
function xml_pars($xmlfile)
{
    $xmlparser = xml_parser_create();
    $fp = fopen($xmlfile, 'r');
    $xmldata = fread($fp, 4096);
    xml_parse_into_struct($xmlparser, $xmldata, $values);
    $data = xml_parser_free($xmlparser);
    foreach ($values as $key => $val) {
        $array[$val['tag']] = $val['value'] ;
    }
	
    foreach($array as $key => $value){
	    if(!empty($value)){
	        echo $key.'-'.$value.'<br>';
		} else {
		    echo $key.':<br>';

		}
	}
   
}
$xmlfile = 'info.xml';
xml_pars($xmlfile);
echo '<br><br>';

function json_transform($array)
{
    $data = json_encode($array);
    file_put_contents('output.json', $data);
    $file = file_get_contents('output.json');
    $array = json_decode($file, TRUE);
    unset($file);
    $bool = mt_rand(0, 1);
    if ($bool === 1) {
        $array['lisa'] = [$a = rand(0, 50), $b = rand(0, 50), $c = rand(0, 50)];
        $array['volk'] = [$a = rand(0, 50), $b = rand(0, 50), $c = rand(0, 50)];
        $array['zajaz'] = [$a = rand(0, 50), $b = rand(0, 50), $c = rand(0, 50)];
        $data_new = json_encode($array);
        file_put_contents('output2.json', $data_new);
        $file = file_get_contents('output.json');
        $file1 = file_get_contents('output2.json');
        $array = json_decode($file, TRUE);
        $array1 = json_decode($file1, TRUE);
        unset($file);
        unset($file1);

        foreach ($array as $key => $value) {
            $val = array_diff($value, $array1[$key]);
            $array3[] = $val;
        }
        $users = array_keys($array);
        echo 'Результаты изменились:';
        foreach ($array3 as $key => $value) {

            if (!empty($value)) {
                echo $users[$key] . '-';
                foreach ($value as $key => $val) {
                    echo $val . ',';
                }
            }
        }
    }
}

$array = array('lisa' => [10,11,33] ,'volk' => [20,12,33] ,'zajaz' => [30,12,20]);
json_transform($array);
echo '<br><br>';

function array_generator($num){
    $i=0;
    while ($i<$num){
        $array[]= mt_rand(1,100);
        $i++;
    }
    return $array;
}


function csv_transform($arr)
{
    var_dump($fp = fopen('file.csv', 'w'));
    $str = implode(';',$arr);
    fputcsv($fp, $arr,';', '"');
    fclose($fp);

    if (($fp1 = fopen("file.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($fp1, 0, ";")) !== FALSE) {
            //var_dump($data);
            foreach ($data as $value) {
                $n = $value % 2;
                if ($n === 0) {
                   $sum[] = $value;
                }
            }
        }
        fclose($fp1);
        $summ = array_sum($sum);
        print_r($summ);


    }
}
$arr = array_generator(50);
csv_transform($arr);
echo '<br><br>';
function site_reading($url,$json)
{
    $data1 = json_decode($json, true);
    foreach ($data1 as $keys =>$array) {
        foreach ($array as $key => $val) {
            foreach ($val as $k => $v) {
                echo 'номер страницы - '.$v['pageid'].'<br>';
                echo 'название страницы - '.$v['title'];
            }
        }
    }
}
//}
$url = 'https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&rvprop=content&format=json';
$json = file_get_contents($url);
if($json) {
    site_reading($url, $json);
} else{
    echo 'Нет соединения с интернетом';
}
?>
