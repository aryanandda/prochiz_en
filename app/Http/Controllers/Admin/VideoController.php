<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends ArticleController
{

    public function __construct()
    {
        $this->type = 'video';
        $this->cont_name = 'Admin\VideoController';
    }

}
