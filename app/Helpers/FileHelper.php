<?php

namespace App\Helpers;

use CodeIgniter\Files\File;

class FileHelper
{
    protected $basePath = WRITEPATH . "/storage/";
    public File $file;

    public function __construct($filename)
    {
        $filepath = $this->basePath . $filename;
        $this->file = new File($filepath);
    }

    static public function calculateSize($bytes)
    {
        $formated = "";
        $gb = 1073741824;
        $mb = 1048576;
        $kb = 1024;

        if ($bytes >= $gb) {
            $formated = number_format($bytes / $gb, 2) .' GB';
        } elseif ($bytes >= $mb) {
            $formated = number_format($bytes / $mb, 2) .' MB';
        } elseif ($bytes >= $kb) {
            $formated = number_format($bytes / $kb, 2) . ' KB';
        } elseif ($bytes > 1) {
            $formated = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $formated = $bytes . ' byte';
        } else {
            $formated = '0 byte';
        }

        return $formated;
    }
}
