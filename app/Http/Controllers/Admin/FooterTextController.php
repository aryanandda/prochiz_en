<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FooterTextController extends ArticleController
{
    public function __construct()
    {
        $this->type = 'footertext';
        $this->cont_name = 'Admin\FooterTextController';
    }
}
