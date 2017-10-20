<?php

//turn on debugging messages
ini_set('display_errors', 'On');
error_reporting(E_ALL);


//instantiate the program object

//Class to load classes it finds the file when the progrm starts to fail for calling a missing class
class Manage {
    public static function autoload($class) {
        //you can put any file name or directory here
        include $class . '.php';
    }
}

spl_autoload_register(array('Manage', 'autoload'));

//instantiate the program object
$obj = new main();

class main {
    
    public function __construct()
    {
        //print_r($_REQUEST);
        //set default page request when no parameters are in URL
        $pageRequest = 'homepage';
        //check if there are parameters
        if(isset($_REQUEST['page'])) {
            //load the type of page the request wants into page request
            $pageRequest = $_REQUEST['page'];
        }
        //instantiate the class that is being requested
        $page = new $pageRequest;
        
        
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $page->get();
        } else {
            $page->post();
        }
        
    }
    
}

abstract class page {
   protected $html;
    
    public function __construct()
    {
        $this->html .= '<html>';
        $this->html .= '<link rel="stylesheet" href="styles.css">';
        $this->html .= '<body>';
    }
    public function __destruct()
    {
        $this->html .= '</body></html>';
        echo($this->html);
    }
    
    public function get() {
        echo 'default get message';
    }
    
    public function post() {
        print_r($_POST);
    }
}


class homepage extends page
{
    
    public function get()
    {
        $form = '<form action="index.php?page=homepage" method="post" enctype="multipart/form-data">';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
        $form .= '<input type="submit" value="Upload CSV file" name="submit">';
        $form .= '</form> ';
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;
        
    }
    
    public function post(){
        upload::uploadFile();
    }
    
}


class upload
{
     public static function uploadFile()
    {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["tmp_name"]);
        $FileType = pathinfo($target_file,PATHINFO_EXTENSION);
        // Check if file is a csv file
        print_r($_FILES);
        if(isset($_POST["submit"])) {
            $fileName=$_FILES["fileToUpload"]["name"];
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], 'uploads/' . $_FILES["fileToUpload"]["name"]);
            header("Location: http://web.njit.edu/~sgd23/IS601101Project1/index.php?page=htmlTable&filename=".$_FILES["fileToUpload"]["name"]);
        }
    }
}

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



?>
