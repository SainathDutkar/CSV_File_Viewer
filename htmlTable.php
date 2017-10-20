<?php

class htmlTable extends page {

public function get(){
$csvFile=$_REQUEST["filename"];
$row = 1;
$tabledata = "";
if (($handle = fopen("uploads/".$csvFile, "r")) !== FALSE) 
{
    $tabledata .= '<table border="1">';
    
    while (($data = fgetcsv($handle)) !== FALSE) {
        $num = count($data);
        if ($row == 1) {
            $tabledata .= '<thead><tr>';
        }else{
            $tabledata .= '<tr>';
        }
        
        for ($c=0; $c < $num; $c++) {
            //echo $data[$c] . "<br />\n";
            if(!isset($data[$c])) {
               $value = "&nbsp;";
            }else{
               $value = $data[$c];
            }
            if ($row == 1) {
                $tabledata .= '<th>'.$value.'</th>';
            }else{
                $tabledata .= '<td>'.$value.'</td>';
            }
        }
        
        if ($row == 1) {
            $tabledata .= '</tr></thead><tbody>';
        }else{
            $tabledata .= '</tr>';
        }
        $row++;
    }
    
    $tabledata .= '</tbody></table>';
    fclose($handle);
    $this->html .= $tabledata;
}
}
}