<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends ArticleController
{

    public function __construct()
    {
        $this->type = 'page';
        $this->cont_name = 'Admin\PageController';
    }

}
