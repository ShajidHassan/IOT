<?php

// Echo OUTPUT:
//     1 = Success
//     2 = LOW Balance
//     3 = Not Registered
//     4 = Verification Failed

//
if(!empty($_GET['license']) && !empty($_GET['bridge'])){
    $req_license = $_GET["license"];
    $req_bridge = $_GET["bridge"];
    // echo "Requested User: $req_license &emsp; Bridge: $req_bridge <br>";
// 
// echo "<br><br>";
    $myfile = fopen("licensedata.csv", "r");
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

        // for($i = 1; $i < $index; $i++){
        //     echo "License Info: $license[$i][0] &emsp; $license[$i][1] &emsp; $license[$i][2]<br>";
        // }
    }
// 
// echo "<br><br>";
$check = "NULL";
for($i = 1; $i < $index; $i++){
    if($req_license == $license[$i][0]){
        $check = "OK";
        $vehicle_type = $license[$i][1];
        $user_acc = $license[$i][2];
        $user_pass = $license[$i][3];
    }
}

if($check == "NULL"){
    // echo "Vehicle is NOT REGISTERED!!!";
    echo "3A";
}
else{
    // echo "User: $user_acc &emsp; Vehicle Type: $vehicle_type <br>";

// 
// echo "<br><br>";
    $myfile = fopen("vehicledata.csv", "r");
    $index = 0;
    if ($myfile !== FALSE) {
        while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
            $num = count($data);
            for($i = 0; $i < $num; $i++){
                $vehicle[$index][$i] = $data[$i];
            }
            $index++;
        }
        fclose($myfile);
        // for($i = 1; $i < $index; $i++){
        //     echo "Bridge ID: " . $vehicle[$i][0] . "&emsp;" . "Toll Fee= " . $vehicle[$i][2] . "TK" . "<br>";
        // }
    }

    for($i = 1; $i < $index; $i++){
        if($req_bridge == $vehicle[$i][0]){
            $credit_ammount = $vehicle[$i][$vehicle_type];
        }
    }

    // echo "Credit Ammount: $credit_ammount TK <br>";

// 
// echo "<br><br>";
    $myfile = fopen("userdata.csv", "r");
    $index = 0;
    if ($myfile !== FALSE) {
        while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
            $num = count($data);
            for($i = 0; $i < $num; $i++){
                $user[$index][$i] = $data[$i];
            }
            $index++;
        }
        fclose($myfile);
        // for($i = 1; $i < $index; $i++){
        //     echo "USER ID: " . $user[$i][0] . "&emsp;" . "Balance= " . $user[$i][2] . "TK" . "<br>";
        // }
    }

//
    for($i = 1; $i < $index; $i++){
        if($user_acc == $user[$i][0]){
            if($user_pass == $user[$i][1]){
                // echo "Trans";
                if($credit_ammount <= $user[$i][2]){
                    // echo "Transanction Success";
                    $user[$i][2] -= $credit_ammount;
                    echo "1A" . $credit_ammount;
        // //////////////////////////////////////////////
                    $newfile = fopen("userdata.csv", "w");
                    foreach($user as $row){
                        fputcsv($newfile, $row);
                    }
                    fclose($newfile);
        // ////////////////////////////////////////////////
                    $myfile = fopen("tolldata.csv", "r");
                    $index = 0;
                    if ($myfile !== FALSE) {
                        while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
                            $num = count($data);
                            for($i = 0; $i < $num; $i++){
                                $toll_data[$index][$i] = $data[$i];
                            }
                            $index++;
                        }
                        fclose($myfile);

                        $toll_data[$index][0] = date("d-m-Y");
                        $toll_data[$index][1] = date("h:iA");
                        $toll_data[$index][2] = $req_license;
                        $toll_data[$index][3] = $credit_ammount;
                        
                        // for($i = 1; $i <= $index; $i++){
                        //     echo "Toll data: " . $toll_data[$i][0] . "&emsp;" . $toll_data[$i][1] . "&emsp;" . $toll_data[$i][2] . "&emsp;" . $toll_data[$i][3] . "<br>";
                        // }
                    }
                    $newfile = fopen("tolldata.csv", "w");
                    foreach($toll_data as $row){
                        fputcsv($newfile, $row);
                    }
                    fclose($newfile);
        // ////////////////////////////////////////////////
                }
                else{
                    // echo "Balance is LOW; Please Recharge";
                    echo "2A" . $credit_ammount;
                }
            }
            else{
                // echo "Verification Failed; User Password mismatch";
                echo "4A" . $credit_ammount;
            }
        }
    }


    
}
// 
}
?>
