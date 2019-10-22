<?php

use App\Helpers\ActiveFilter;
use App\Helpers\RBACFilter;

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
     */

    'title'               => 'کاروان های پیاده سال ۹۶',

    'title_prefix'        => '',

    'title_postfix'       => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
     */

    'logo'                => 'کاروان های پیاده سال ۹۶',

    'logo_mini'           => '<b>A</b>LT',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | light variant: blue-light, purple-light, purple-light, etc.
    |
     */

    'skin'                => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
     */

    'layout'              => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
     */

    'collapse_sidebar'    => false,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we have the option to enable a right sidebar.
    | When active, you can use @section('right-sidebar')
    | The icon you configured will be displayed at the end of the top menu,
    | and will show/hide de sidebar.
    | The slide option will slide the sidebar over the content, while false
    | will push the content, and have no animation.
    | You can also choose the sidebar theme (dark or light).
    | The right Sidebar can only be used if layout is not top-nav.
    |
     */

    'right_sidebar'       => false,
    'right_sidebar_icon'  => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs.
    | This was automatically set on install, only change if you really need.
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | Set register_url to null if you don't want a register link.
    |
     */

    'dashboard_url'       => '/',

    'logout_url'          => 'logout',

    'login_url'           => 'login',

    'register_url'        => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and a URL. You can also specify an icon from Font
    | Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
     */

    'menu'                => [
        'منوی اصلی',
        [
            'text'    => 'کاربران',
            'regex'   => 'users.*',
            'icon'    => 'users',
            'perm'    => ['مدیریت کاربران'],
            'submenu' => [
                [
                    'text'        => 'مدیریت',
                    'route'       => 'users.index',
                    'activateVia' => ['users.edit'],
                ],
                [
                    'text'  => 'ایجاد',
                    'icon'  => 'pencil',
                    'route' => 'users.create',
                ],
            ],
        ],

        [
            'text'    => 'سطوح دسترسی',
            'regex'   => 'rbac.*',
            'icon'    => 'lock',
            'perm'    => ['سطوح دسترسی'],
            'submenu' => [
                [
                    'text'        => 'مدیریت نقش ها',
                    'route'       => 'rbac.roles',
                    'activateVia' => ['rbac.roles.edit'],
                ],
                [
                    'text'  => 'ایجاد نقش جدید',
                    'route' => 'rbac.roles.create',
                ],
                [
                    'text'        => 'مدیریت مجوز ها',
                    'route'       => 'rbac.permissions',
                    'activateVia' => ['rbac.permissions.edit'],
                ],
                [
                    'text'  => 'ایجاد مجوز جدید',
                    'route' => 'rbac.permissions.create',
                ],
            ],
        ],

        [
            'text'        => 'زائرین',
            'regex'       => 'persons.*',
            'icon'        => 'users',
            'activateVia' => ['status.index', 'person.register', 'taradod.index', 'screenshot.index', 'persontocode', 'bankarevan'],
            'perm'        => ['مدیریت زائرین', 'جستجوی زائر', 'ثبت نام زائر', 'ثبت تردد زائر', 'تهیه عکس زائر', 'ارتباط زائر با کد تردد', 'مسدود کردن کاروان'],
            'submenu'     => [
                [
                    'text'        => 'مدیریت',
                    'route'       => 'persons.index',
                    'activateVia' => ['persons.edit', 'persons.message'],
                    'perm'        => ['مدیریت زائرین'],
                ],
                [
                    'text'  => 'جستجوی زائر (وضعیت)',
                    'icon'  => 'search',
                    'route' => 'status.index',
                    'perm'  => ['جستجوی زائر'],
                ],
                [
                    'text'  => 'ثبت نام',
                    'icon'  => 'pencil',
                    'route' => 'person.register',
                    'perm'  => ['ثبت نام زائر'],
                ],
                [
                    'text'  => 'ثبت تردد',
                    'icon'  => 'sign-in',
                    'route' => 'taradod.index',
                    'perm'  => ['ثبت تردد زائر'],
                ],
                [
                    'text'  => 'تهیه عکس',
                    'icon'  => 'camera',
                    'route' => 'screenshot.index',
                    'perm'  => ['تهیه عکس زائر'],
                ],
                [
                    'text'  => 'ارتباط زائر با کد تردد',
                    'icon'  => 'exchange',
                    'route' => 'persontocode',
                    'perm'  => ['ارتباط زائر با کد تردد'],
                ],
                [
                    'text'  => 'مسدود/رفع مسدودیت کاروان',
                    'icon'  => 'ban',
                    'route' => 'bankarevan',
                    'perm'  => ['مسدود کردن کاروان'],
                ],
            ],
        ],

        [
            'text'    => 'پیام ها',
            'regex'   => 'messages.*',
            'icon'    => 'envelope',
            'perm'    => ['مدیریت پیام ها'],
            'submenu' => [
                [
                    'text'        => 'مدیریت',
                    'route'       => 'messages.index',
                    'activateVia' => ['messages.edit'],
                ],
            ],
        ],

        [
            'text'    => 'گزارشات',
            'regex'   => 'report.*',
            'icon'    => 'bar-chart',
            'perm'    => ['گزارشات'],
            'submenu' => [
                [
                    'text'  => 'کاروان ها',
                    'icon'  => 'pie-chart',
                    'route' => 'report.karevan.index',
                ],
                [
                    'text'  => 'خطاها',
                    'icon'  => 'bug',
                    'route' => 'report.error.index',
                ],
                [
                    'text'  => 'تردد',
                    'icon'  => 'bar-chart',
                    'route' => 'report.taradod.index',
                ],
            ],
        ],

        [
            'text'    => 'شهر ها',
            'regex'   => 'cities.*',
            // 'icon'    => 'envelope',
            'perm'    => ['مدیریت اسامی شهر ها'],
            'submenu' => [
                [
                    'text'        => 'مدیریت',
                    'route'       => 'cities.index',
                    'activateVia' => ['cities.edit'],
                ],
                [
                    'text'  => 'ایجاد',
                    'route' => 'cities.create',
                ],
            ],
        ],

        [
            'text'    => 'مدیران کاروان ها',
            'regex'   => 'modirkarevans.*',
            // 'icon'    => 'envelope',
            'perm'    => ['مدیریت اسامی مدیران کاروان ها'],
            'submenu' => [
                [
                    'text'        => 'مدیریت',
                    'route'       => 'modirkarevans.index',
                    'activateVia' => ['modirkarevans.edit'],
                ],
                [
                    'text'  => 'ایجاد',
                    'route' => 'modirkarevans.create',
                ],
            ],
        ],

        [
            'text'        => 'ورود اطلاعات',
            'icon'        => 'database',
            'perm'        => ['ورود اطلاعات'],
            'route'       => 'importer',
            'activateVia' => ['importer.barresi', 'importer.import'],
        ],

        // [
        //     'text' => 'ویرایش مشخصات',
        //     'icon' => 'pencil',
        //     'route' => 'profile'
        // ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
     */

    'filters'             => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        // JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        RBACFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Configure which JavaScript plugins should be included. At this moment,
    | DataTables, Select2, Chartjs and SweetAlert are added out-of-the-box,
    | including the Javascript and CSS files from a CDN via script and link tag.
    | Plugin Name, active status and files array (even empty) are required.
    | Files, when added, need to have type (js or css), asset (true or false) and location (string).
    | When asset is set to true, the location will be output using asset() function.
    |
     */

    'plugins'             => [],
];
