<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends ArticleController
{

    public function __construct()
    {
        $this->type = 'news';
        $this->cont_name = 'Admin\NewsController';
    }

}
