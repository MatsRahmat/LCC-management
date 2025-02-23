<?php

namespace App\Libraries;

require_once ROOTPATH . 'app/ThirdParty/tcpdf/tcpdf.php'; 

class Tcpdf extends \TCPDF
{
    public function __construct()
    {
        parent::__construct();
    }
}
