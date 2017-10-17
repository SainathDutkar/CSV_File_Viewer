<?php

class homepage extends page
{

    public function get()
    {
        $form = '<form action="upload.php" method="post" enctype="multipart/form-data">';
        echo $form;
        $form = '<input type="file" name="fileToUpload" id="fileToUpload">';
        echo $form;
        $form = '<input type="submit" value="Upload CSV file" name="submit">';
        echo $form;
        $form = '</form> ';
        echo $form;
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;

    }

    public function post() {
        echo 'test';
        print_r($_FILES);
    }
}