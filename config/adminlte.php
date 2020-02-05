
<?php    return [

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


        'title_prefix' => '',

        'title_postfix' => '',

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

        'logo' => 'wedBooker',

        'logo_mini' => 'wB',

        /*
        |--------------------------------------------------------------------------
        | Skin Color
        |--------------------------------------------------------------------------
        |
        | Choose a skin color for your admin panel. The available skin colors:
        | blue, black, purple, yellow, red, and green. Each skin also has a
        | ligth variant: blue-light, purple-light, purple-light, etc.
        |
        */

        'skin' => 'blue',

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

        'layout' => 'fixed',

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

        'collapse_sidebar' => false,

        /*
        |--------------------------------------------------------------------------
        | URLs
        |--------------------------------------------------------------------------
        |
        | Register here your dashboard, logout, login and register URLs. The
        | logout URL automatically sends a POST request in Laravel 5.3 or higher.
        | You can set the request to a GET or POST with logout_method.
        | Set register_url to null if you don't want a register link.
        |
        */

        'dashboard_url' => 'home',

        'logout_url' => '/logout',

        'logout_method' => null,

        'login_url' => 'login',

        'register_url' => 'register',

        /*
        |--------------------------------------------------------------------------
        | Menu Items
        |--------------------------------------------------------------------------
        |
        | Specify your menu items to display in the left sidebar. Each menu item
        | should have a text and and a URL. You can also specify an icon from
        | Font Awesome. A string instead of an array represents a header in sidebar
        | layout. The 'can' is a filter on Laravel's built in Gate functionality.
        |
        */

        'menu' => [
            'MAIN NAVIGATION',
            [
                'text'        => 'Dashboard',
                'url'         => 'dashboard',
                'icon'        => 'desktop',
                'label_color' => 'success',
            ],
            [
                'text'        => 'Administration Managers',
                'url'         => 'admin/accounts',
                'icon'        => 'cogs',
                'label_color' => 'success'
            ],
            [
                'text'        => 'Business Accounts',
                'icon'        => 'user',
                'label_color' => 'success',
                'submenu'     => [[
                    'text'        => 'Pending Vendors',
                    'url'         => 'admin/vendors/pending',
                    'icon'        => 'eye',
                    'label_color' => 'success',
                ],[
                    'text'        => 'Active Vendors',
                    'url'         => 'admin/vendors/active',
                    'icon'        => 'eye',
                    'label_color' => 'success',
                ],[
                    'text'        => 'Archive',
                    'url'         => 'admin/vendors/archive',
                    'icon'        => 'eye',
                    'label_color' => 'success',
                ]]
            ],
            [
                'text'        => 'Couple Accounts',
                'icon'        => 'user',
                'label_color' => 'success',
                'submenu'     => [
                    [
                    'text'        => 'Pending Email Verification',
                    'url'         => 'admin/couple/pending-email-verification',
                    'icon'        => 'eye',
                    'label_color' => 'success',
                ],[
                    'text'        => 'Active',
                    'url'         => 'admin/couple/active',
                    'icon'        => 'eye',
                    'label_color' => 'success',
                ],[
                    'text'        => 'Archive',
                    'url'         => 'admin/couple/archive',
                    'icon'        => 'eye',
                    'label_color' => 'success',
                ],]
            ],
            [
                'text'        => 'Parent Accounts',
                'icon'        => 'users',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'All Parent Accounts',
                        'url'      => 'admin/parent-accounts',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Create New Parent',
                        'url'      => 'admin/parent-accounts/create',
                        'label_color' => 'success',
                    ],
                ]
            ],
            [
                'text'        => 'Job Management',
                'icon'        => 'briefcase',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Quotes',
                        'url'      => 'admin/job-quotes',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Live Jobs',
                        'url'      => 'admin/job-posts',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Deleted Jobs',
                        'url'      => 'admin/deleted-job-posts',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Pending Approval',
                        'url'      => 'admin/pending-job-posts',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Confirmed Bookings',
                        'url'      => 'admin/confirmed-bookings',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Expired Jobs',
                        'url'      => 'admin/expired-jobs',
                        'label_color' => 'success',
                    ],
                ]
            ],
            [
                'text'        => 'Business Reviews',
                'url'         => 'admin/businesses/reviews',
                'icon'        => 'money',
                'label_color' => 'success',
            ],
            [
                'text'        => 'Ordering Suppliers & Venues',
                'url'         => 'admin/vendors/ordering',
                'icon'        => 'eye',
                'label_color' => 'success',
            ],
            [
                'text'        => 'Notifications',
                'icon'        => 'bell',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Automated Notifications',
                        'url'         => 'admin/automated-notifications',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Custom Notifications',
                        'url'         => 'admin/notifications',
                        'label_color' => 'success'
                    ],
                    // [
                    //     'text'        => 'Dashboard Notifications',
                    //     'url'         => 'admin/dashboard-notifications',
                    //     'label_color' => 'success',
                    // ],
                    // [
                    //     'text'        => 'Email Notifications',
                    //     'url'         => 'admin/emails',
                    //     'label_color' => 'success',
                    // ],
                    // [
                    //     'text'        => 'Templates',
                    //     'url'         => 'admin/email-templates',
                    //     'label_color' => 'success',
                    // ]
                ]
            ],
            [
                'text'        => 'Post A Job Templates',
                'icon'        => 'briefcase',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Templates',
                        'url'         => 'admin/job-post-templates',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Create New Template',
                        'url'         => 'admin/job-post-templates/create',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Assign Template',
                        'url'         => 'admin/assign-template-category',
                        'label_color' => 'success',
                    ]
                ]
            ],
            [
                'text'        => 'Categories Management',
                'icon'        => 'money',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Categories',
                        'url'         => 'admin/categories',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Create New Category',
                        'url'         => 'admin/categories/create',
                        'label_color' => 'success',
                    ],
                ]
            ],
            [
                'text'        => 'Fees Management',
                'icon'        => 'money',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Fees',
                        'url'         => 'admin/fees',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Create New Fee',
                        'url'         => 'admin/fees/create',
                        'label_color' => 'success',
                    ],
                ]
            ],
            [
                'text'        => 'CMS',
                'icon'        => 'envelope',
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Pages',
                        'url'         => 'admin/pages',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Create',
                        'url'         => 'admin/pages/create',
                        'label_color' => 'success',
                    ],
                ]
            ],
            [
                'text'        => 'Enquiries',
                'icon'        => 'phone',
                
                'label_color' => 'success',
                'submenu'     => [
                    [
                        'text'        => 'Contact Us Form',
                        'url'         => 'admin/contact-us',
                        'label_color' => 'success',
                    ],
                    [
                        'text'        => 'Refund Request Form',
                        'url'         => 'admin/refund-request',
                        'label_color' => 'success',
                    ],
                ]
            ],            
            // [
            //     'text'        => 'Custom Notifications',
            //     'icon'        => 'comment',
            //     'url'         => 'admin/notifications',
            //     'label_color' => 'success'
            // ],
            [
                'text'        => 'DB Backup',
                'icon'        => 'envelope',
                'label_color' => 'success',
                'url'         => 'admin/database-backup',
            ],
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

        'filters' => [
            JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
            JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
            JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
            JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
            JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class
        ],

        /*
        |--------------------------------------------------------------------------
        | Plugins Initialization
        |--------------------------------------------------------------------------
        |
        | Choose which JavaScript plugins should be included. At this moment,
        | only DataTables is supported as a plugin. Set the value to true
        | to include the JavaScript file from a CDN via a script tag.
        |
        */

        'plugins' => [
            'datatables' => true,
            'select2'    => true,
            'chartjs'    => true,
        ],
    ];
