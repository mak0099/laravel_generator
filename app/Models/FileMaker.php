<?php

namespace App\Models;
use App\Inflector;

use Illuminate\Database\Eloquent\Model;

class FileMaker
{
    // private $project_root = "generated_files/";
    
    public function createFile($file_name, $directory, $file_content) {
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        $myfile = fopen("{$directory}/{$file_name}", "w") or die("Unable to make model!");
        fwrite($myfile, $file_content);
        fclose($myfile);
        return true;
    }
}
