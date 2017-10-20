<?php

class homepage extends page
{

    public function get()
    {
        $form = '<form action="upload.php" method="post" enctype="multipart/form-data">';
        $form .= '<input type="file" name="fileToUpload" id="fileToUpload">';
        $form .= '<input type="submit" value="Upload CSV file" name="submit">';
        $form .= '</form> ';
        $this->html .= '<h1>Upload Form</h1>';
        $this->html .= $form;

    }

    public function post() {
        echo 'test';
        print_r($_FILES);
    }
}