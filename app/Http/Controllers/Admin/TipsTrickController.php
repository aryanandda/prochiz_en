<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TipsTrickController extends ArticleController
{

    public function __construct()
    {
        $this->type = "tips";
        $this->cont_name = "Admin\TipsTrickController";
    }

}
