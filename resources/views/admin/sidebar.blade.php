<div class="site-menubar no-print">
    <div class="site-menubar-body">
        <div>
            <div>
                <ul class="site-menu" data-plugin="menu">
                    <li class="site-menu-category">General</li>
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\DashboardController@index') }}">
                            <i class="site-menu-icon md-desktop-windows" aria-hidden="true"></i>
                            <span class="site-menu-title">Dashboard</span>
                        </a>
                    </li>

                    <li class="site-menu-category">Contents</li>     
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\PageController@index') }}">
                            <i class="site-menu-icon md-collection-text" aria-hidden="true"></i>
                            <span class="site-menu-title">Page</span>
                        </a>
                    </li>                
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\NewsController@index') }}">
                            <i class="site-menu-icon md-assignment" aria-hidden="true"></i>
                            <span class="site-menu-title">News</span>
                        </a>
                    </li>                        
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\TipsTrickController@index') }}">
                            <i class="site-menu-icon md-puzzle-piece" aria-hidden="true"></i>
                            <span class="site-menu-title">Tips</span>
                        </a>
                    </li>                          
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\VideoController@index') }}">
                            <i class="site-menu-icon md-play" aria-hidden="true"></i>
                            <span class="site-menu-title">Video</span>
                        </a>
                    </li>   
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\FooterTextController@index') }}">
                            <i class="site-menu-icon md-file-text" aria-hidden="true"></i>
                            <span class="site-menu-title">Footer Text</span>
                        </a>
                    </li>                    
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\ProductController@index') }}">
                            <i class="site-menu-icon md-labels" aria-hidden="true"></i>
                            <span class="site-menu-title">Product</span>
                        </a>
                    </li>                     
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\RecipeController@index') }}">
                            <i class="site-menu-icon md-cake" aria-hidden="true"></i>
                            <span class="site-menu-title">Recipe</span>
                        </a>
                    </li>                       
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\RecipeUserController@index') }}">
                            <i class="site-menu-icon md-cutlery" aria-hidden="true"></i>
                            <span class="site-menu-title">Recipe by User</span>
                        </a>
                    </li>              
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\EventController@index') }}">
                            <i class="site-menu-icon md-ticket-star" aria-hidden="true"></i>
                            <span class="site-menu-title">Event</span>
                        </a>
                    </li>                             
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\BannerController@index') }}">
                            <i class="site-menu-icon md-image" aria-hidden="true"></i>
                            <span class="site-menu-title">Banner</span>
                        </a>
                    </li>                             
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\PartnerGalleryController@index') }}">
                            <i class="site-menu-icon md-image" aria-hidden="true"></i>
                            <span class="site-menu-title">Partner Gallery</span>
                        </a>
                    </li>   

                    <li class="site-menu-category">Accounts</li>                    
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\AdminController@index') }}">
                            <i class="site-menu-icon md-face" aria-hidden="true"></i>
                            <span class="site-menu-title">Admins</span>
                        </a>
                    </li>    
                    <li class="site-menu-item has-sub">
                        <a href="javascript:void(0)">
                        <i class="site-menu-icon md-accounts-list" aria-hidden="true"></i>
                        <span class="site-menu-title">Partners</span>
                        <span class="site-menu-arrow"></span>
                        </a>
                        <ul class="site-menu-sub">
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ action('Admin\PartnerController@index') }}">
                                    <span class="site-menu-title">Partners</span>
                                </a>
                            </li>  
                            <li class="site-menu-item">
                                <a class="animsition-link" href="{{ action('Admin\PartnerCategoryController@index') }}">
                                    <span class="site-menu-title">Partner Categories</span>
                                </a>
                            </li>
                        </ul>
                    </li>            
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\UserController@index') }}">
                            <i class="site-menu-icon md-accounts-alt" aria-hidden="true"></i>
                            <span class="site-menu-title">Users</span>
                        </a>
                    </li>
                    <li class="site-menu-item">
                        <a class="animsition-link" href="{{ action('Admin\AuthController@logout') }}">
                            <i class="site-menu-icon md-power" aria-hidden="true"></i>
                            <span class="site-menu-title">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>