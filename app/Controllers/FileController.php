<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Enums\StateEnum;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\ResponseInterface;

class FileController extends BaseController
{
    public function serve($filename)
    {
        try {
            $filepath = WRITEPATH . 'uploads/storage/' . $filename;
            if (!file_exists($filepath)) {
                return redirect()->back()->with(StateEnum::ERROR, 'File not found for ' .  $filename);
            }

            $fileInfo = new File($filepath);
            $mimeType = $fileInfo->getMimeType();
            return $this->response->setHeader('Content-Type', $mimeType)->setBody(file_get_contents($filepath));
        } catch (\Throwable $th) {
            return redirect()->back()->with(StateEnum::ERROR, $th->getMessage());
        }
    }
}
