<?php
$myfile = fopen("tolldata.csv", "r");
    $index = 0;
    if ($myfile !== FALSE) {
        while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
            $num = count($data);
            for($i = 0; $i < $num; $i++){
                $license[$index][$i] = $data[$i];
            }
            $index++;
        }
        fclose($myfile);
        
        $data['data']  = $license;
        $json = json_encode($data);
        echo $json;
    }
    ?>