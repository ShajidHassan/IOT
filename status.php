<?php
	$myfile = fopen("tolldata.csv", "r");
    $index = 0;
    if ($myfile !== FALSE) {
        while (($data = fgetcsv($myfile, 1000, ",")) !== FALSE) {
            $num = count($data);
            for($i = 0; $i < $num; $i++){
                $tolldata[$index][$i] = $data[$i];
            }
            $index++;
        }
        fclose($myfile);
        $total_credit = 0;
        for($i = 1; $i < $index; $i++){
        	$total_credit += (int) $tolldata[$i][3];
            // echo $tolldata[$i][0] . "&emsp;" . $tolldata[$i][1]  . "&emsp;" . $tolldata[$i][2]  . "&emsp;" . $tolldata[$i][3] . "<br>";
        }
    	// echo $total_credit;	
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Credit Data</title>
	<style>
		 table {
            font-family: arial, sans-serif;
            border: 1px solid ;
            border-collapse: collapse;
            width: 60%;
            margin-left:auto;
            margin-right:auto;
        }

        td, th{
            border: 1px solid ;
            border-collapse: collapse;
            text-align: center;
            padding: 8px;
            width: 20%;
        }
	</style>
</head>
<body>
	<table id="1", align="center">
		<tr>
			<th>Date</th>
			<th>Time</th>
			<th>License NO</th>
			<th>Credit (TK)</th>
		</tr>
		<?php
		for ($i = 1; $i < $index; $i++) {
			echo "
			<tr>
				<td>" . $tolldata[$i][0] . "</td>
				<td>" . $tolldata[$i][1] . "</td>
				<td>" . $tolldata[$i][2] . "</td>
				<td>" . $tolldata[$i][3] . "</td>
			</tr>";
		}
		?>
		<tr>
			<td colspan="3", ></td>
			<td><?php echo "Total: $total_credit TK" ?></td>
		</tr>
	</table>
</body>
</html>