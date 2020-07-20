/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
                    path => router path
                    name => router name
                    component(lazy loading) => component to load
                    meta : {
                      rule => which user can have access (ACL)
                      breadcrumb => Add breadcrumb to specific page
                      pageTitle => Display title besides breadcrumb
                    }
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'




Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: process.env.BASE_URL,
    scrollBehavior () {
        return { x: 0, y: 0 }
    },
    routes: [

        {
    // =============================================================================
    // MAIN LAYOUT ROUTES
    // =============================================================================
            path: '',
            component: () => import('./layouts/main/Main.vue'),
            children: [
        // =============================================================================
        // Theme Routes
        // =============================================================================

                {
                    path: '/',
                    redirect:'/dashboard'
                },
                {
                    path: '/dashboard',
                    name: 'dashboard',
                    component: () => import('./views/DashboardAnalytics.vue'),
                    meta: {
                        rule: 'store',

                    }
                },


        // =============================================================================
        // Application Routes
        // =============================================================================

                {
                    path: '/apps/email',
                    redirect: '/apps/email/inbox',
                    name: 'email',
                    meta: {
                        rule: 'store',

                    }
                },
                {
                    path: '/apps/email/:filter',
                    component: () => import('./views/apps/email/Email.vue'),
                    meta: {
                        rule: 'store',
                        parent: 'email',
                        no_scroll: true,

                    }
                },
                {
                    path: '/apps/calendar/vue-simple-calendar',
                    name: 'calendar-simple-calendar',
                    component: () => import('./views/apps/calendar/SimpleCalendar.vue'),
                    meta: {
                        rule: 'store',
                        no_scroll: true,
                    }
                },
                {
                    path: '/users',
                    name: 'user-list',
                    component: () => import('@/views/pages/users/user-list/UserList.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'User' },
                            { title: 'List', active: true },
                        ],
                        pageTitle: 'User List',
                        rule: 'admin',

                    },
                },
                {
                    path: '/users/user-view/:userId',
                    name: 'app-user-view',
                    component: () => import('@/views/pages/users/UserView.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'User' },
                            { title: 'View', active: true },
                        ],
                        pageTitle: 'User View',
                        rule: 'admin',

                    },
                },
                {
                    path: '/users/edit/:userId',
                    name: 'user-edit',
                    component: () => import('@/views/pages/users/user-edit/UserEdit.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'User' },
                            { title: 'Edit', active: true },
                        ],
                        pageTitle: 'User Edit',
                        rule: 'admin',

                    },
                },

              // =============================================================================
              //                           CLIENTS
              // =============================================================================
              {
                path: '/clients',
                name: 'client-list',
                component: () => import('@/views/pages/clients/client-list/UserList.vue'),
                meta: {
                  breadcrumb: [
                    { title: 'Anasayfa', url: '/' },
                    { title: 'Müşteriler' },
                    { title: 'Liste', active: true },
                  ],
                  pageTitle: 'Müşteri Listeniz',
                  rule: 'store',

                },
              },
              {
                path: '/clients/user-view/:userId',
                name: 'client-view',
                component: () => import('@/views/pages/clients/UserView.vue'),
                meta: {
                  breadcrumb: [
                    { title: 'Home', url: '/' },
                    { title: 'User' },
                    { title: 'View', active: true },
                  ],
                  pageTitle: 'User View',
                  rule: 'store',

                },
              },
              {
                path: '/clients/edit/:userId',
                name: 'client-edit',
                component: () => import('@/views/pages/clients/client-edit/UserEdit.vue'),
                meta: {
                  breadcrumb: [
                    { title: 'Anasayfa', url: '/' },
                    { title: 'Müşteriler' },
                    { title: 'Görüntüle/Düzenle', active: true },
                  ],
                  pageTitle: 'Müşteriyi Görüntüle',
                  rule: 'store',

                },
              },

               // =============================================================================
              //                           INVOICES
              // =============================================================================
              {
                path: '/shopping-list',
                name: 'Shopping',
                component: () => import('@/views/pages/invoices/list/invoiceList.vue'),
                meta: {
                  breadcrumb: [
                    { title: 'Anasayfa', url: '/' },
                    { title: 'Alışverişler' },
                    { title: 'Liste', active: true },
                  ],
                  pageTitle: 'Son Alışverişler',
                  rule: 'store'
                },
              },
              {
                path: '/invoice/view',
                name: 'invoice-view',
                component: () => import('@/views/pages/invoices/thumb/invoiceThumb.vue'),
                meta: {
                  breadcrumb: [
                    { title: 'Home', url: '/' },
                    { title: 'Data List'},
                    { title: 'Invoice View', active: true },
                  ],
                  pageTitle: 'Invoice View',
                  rule: 'store'
                },
              },

        // =============================================================================
        // UI ELEMENTS
        // =============================================================================
                {
                    path: '/ui-elements/data-list/list-view',
                    name: 'data-list-list-view',
                    component: () => import('@/views/ui-elements/data-list/list-view/DataListListView.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Data List'},
                            { title: 'List View', active: true },
                        ],
                        pageTitle: 'List View',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/data-list/thumb-view',
                    name: 'data-list-thumb-view',
                    component: () => import('@/views/ui-elements/data-list/thumb-view/DataListThumbView.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Data List'},
                            { title: 'Thumb View', active: true },
                        ],
                        pageTitle: 'Thumb View',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/grid/vuesax',
                    name: 'grid-vuesax',
                    component: () => import('@/views/ui-elements/grid/vuesax/GridVuesax.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Grid'},
                            { title: 'Vuesax', active: true },
                        ],
                        pageTitle: 'Grid',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/grid/tailwind',
                    name: 'grid-tailwind',
                    component: () => import('@/views/ui-elements/grid/tailwind/GridTailwind.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Grid'},
                            { title: 'Tailwind', active: true },
                        ],
                        pageTitle: 'Tailwind Grid',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/colors',
                    name: 'colors',
                    component: () => import('./views/ui-elements/colors/Colors.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Colors', active: true },
                        ],
                        pageTitle: 'Colors',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/card/basic',
                    name: 'basic-cards',
                    component: () => import('./views/ui-elements/card/CardBasic.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Card' },
                            { title: 'Basic Cards', active: true },
                        ],
                        pageTitle: 'Basic Cards',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/card/statistics',
                    name: 'statistics-cards',
                    component: () => import('./views/ui-elements/card/CardStatistics.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Card' },
                            { title: 'Statistics Cards', active: true },
                        ],
                        pageTitle: 'Statistics Card',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/card/analytics',
                    name: 'analytics-cards',
                    component: () => import('./views/ui-elements/card/CardAnalytics.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Card' },
                            { title: 'Analytics Card', active: true },
                        ],
                        pageTitle: 'Analytics Card',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/card/card-actions',
                    name: 'card-actions',
                    component: () => import('./views/ui-elements/card/CardActions.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Card' },
                            { title: 'Card Actions', active: true },
                        ],
                        pageTitle: 'Card Actions',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/card/card-colors',
                    name: 'card-colors',
                    component: () => import('./views/ui-elements/card/CardColors.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Card' },
                            { title: 'Card Colors', active: true },
                        ],
                        pageTitle: 'Card Colors',
                        rule: 'store'
                    },
                },
                {
                    path: '/ui-elements/ag-grid-table',
                    name: 'ag-grid-table',
                    component: () => import('./views/ui-elements/ag-grid-table/AgGridTable.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'agGrid Table', active: true },
                        ],
                        pageTitle: 'agGrid Table',
                        rule: 'store'
                    },
                },

        // =============================================================================
        // COMPONENT ROUTES
        // =============================================================================
                {
                    path: '/components/alert',
                    name: 'component-alert',
                    component: () => import('@/views/components/vuesax/alert/Alert.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Alert', active: true },
                        ],
                        pageTitle: 'Alert',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/avatar',
                    name: 'component-avatar',
                    component: () => import('@/views/components/vuesax/avatar/Avatar.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Avatar', active: true },
                        ],
                        pageTitle: 'Avatar',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/breadcrumb',
                    name: 'component-breadcrumb',
                    component: () => import('@/views/components/vuesax/breadcrumb/Breadcrumb.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Breadcrumb', active: true },
                        ],
                        pageTitle: 'Breadcrumb',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/button',
                    name: 'component-button',
                    component: () => import('@/views/components/vuesax/button/Button.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Button', active: true },
                        ],
                        pageTitle: 'Button',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/button-group',
                    name: 'component-button-group',
                    component: () => import('@/views/components/vuesax/button-group/ButtonGroup.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Button Group', active: true },
                        ],
                        pageTitle: 'Button Group',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/chip',
                    name: 'component-chip',
                    component: () => import('@/views/components/vuesax/chip/Chip.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Chip', active: true },
                        ],
                        pageTitle: 'Chip',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/collapse',
                    name: 'component-collapse',
                    component: () => import('@/views/components/vuesax/collapse/Collapse.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Collapse', active: true },
                        ],
                        pageTitle: 'Collapse',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/dialogs',
                    name: 'component-dialog',
                    component: () => import('@/views/components/vuesax/dialogs/Dialogs.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Dialogs', active: true },
                        ],
                        pageTitle: 'Dialogs',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/divider',
                    name: 'component-divider',
                    component: () => import('@/views/components/vuesax/divider/Divider.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Divider', active: true },
                        ],
                        pageTitle: 'Divider',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/dropdown',
                    name: 'component-drop-down',
                    component: () => import('@/views/components/vuesax/dropdown/Dropdown.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Dropdown', active: true },
                        ],
                        pageTitle: 'Dropdown',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/list',
                    name: 'component-list',
                    component: () => import('@/views/components/vuesax/list/List.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'List', active: true },
                        ],
                        pageTitle: 'List',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/loading',
                    name: 'component-loading',
                    component: () => import('@/views/components/vuesax/loading/Loading.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Loading', active: true },
                        ],
                        pageTitle: 'Loading',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/navbar',
                    name: 'component-navbar',
                    component: () => import('@/views/components/vuesax/navbar/Navbar.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Navbar', active: true },
                        ],
                        pageTitle: 'Navbar',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/notifications',
                    name: 'component-notifications',
                    component: () => import('@/views/components/vuesax/notifications/Notifications.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Notifications', active: true },
                        ],
                        pageTitle: 'Notifications',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/pagination',
                    name: 'component-pagination',
                    component: () => import('@/views/components/vuesax/pagination/Pagination.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Pagination', active: true },
                        ],
                        pageTitle: 'Pagination',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/popup',
                    name: 'component-popup',
                    component: () => import('@/views/components/vuesax/popup/Popup.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Popup', active: true },
                        ],
                        pageTitle: 'Popup',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/progress',
                    name: 'component-progress',
                    component: () => import('@/views/components/vuesax/progress/Progress.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Progress', active: true },
                        ],
                        pageTitle: 'Progress',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/sidebar',
                    name: 'component-sidebar',
                    component: () => import('@/views/components/vuesax/sidebar/Sidebar.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Sidebar', active: true },
                        ],
                        pageTitle: 'Sidebar',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/slider',
                    name: 'component-slider',
                    component: () => import('@/views/components/vuesax/slider/Slider.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Slider', active: true },
                        ],
                        pageTitle: 'Slider',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/tabs',
                    name: 'component-tabs',
                    component: () => import('@/views/components/vuesax/tabs/Tabs.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Tabs', active: true },
                        ],
                        pageTitle: 'Tabs',
                        rule: 'store'
                    },
                },
                {
                    path: '/components/tooltip',
                    name: 'component-tooltip',
                    component: () => import('@/views/components/vuesax/tooltip/Tooltip.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Tooltip', active: true },
                        ],
                        pageTitle: 'Tooltip',
                        rule: 'admin'
                    },
                },
                {
                    path: '/components/upload',
                    name: 'component-upload',
                    component: () => import('@/views/components/vuesax/upload/Upload.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Components' },
                            { title: 'Upload', active: true },
                        ],
                        pageTitle: 'Upload',
                        rule: 'store'
                    },
                },


        // =============================================================================
        // FORMS
        // =============================================================================
            // =============================================================================
            // FORM ELEMENTS
            // =============================================================================
                {
                    path: '/forms/form-elements/select',
                    name: 'form-element-select',
                    component: () => import('./views/forms/form-elements/select/Select.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Select', active: true },
                        ],
                        pageTitle: 'Select',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-elements/switch',
                    name: 'form-element-switch',
                    component: () => import('./views/forms/form-elements/switch/Switch.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Switch', active: true },
                        ],
                        pageTitle: 'Switch',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-elements/checkbox',
                    name: 'form-element-checkbox',
                    component: () => import('./views/forms/form-elements/checkbox/Checkbox.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Checkbox', active: true },
                        ],
                        pageTitle: 'Checkbox',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-elements/radio',
                    name: 'form-element-radio',
                    component: () => import('./views/forms/form-elements/radio/Radio.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Radio', active: true },
                        ],
                        pageTitle: 'Radio',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-elements/input',
                    name: 'form-element-input',
                    component: () => import('./views/forms/form-elements/input/Input.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Input', active: true },
                        ],
                        pageTitle: 'Input',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-elements/number-input',
                    name: 'form-element-number-input',
                    component: () => import('./views/forms/form-elements/number-input/NumberInput.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Number Input', active: true },
                        ],
                        pageTitle: 'Number Input',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-elements/textarea',
                    name: 'form-element-textarea',
                    component: () => import('./views/forms/form-elements/textarea/Textarea.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Form Elements' },
                            { title: 'Textarea', active: true },
                        ],
                        pageTitle: 'Textarea',
                        rule: 'store'
                    },
                },
        // -------------------------------------------------------------------------------------------------------------------------------------------
                {
                    path: '/forms/form-layouts',
                    name: 'forms-form-layouts',
                    component: () => import('@/views/forms/FormLayouts.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Forms' },
                            { title: 'Form Layouts', active: true },
                        ],
                        pageTitle: 'Form Layouts',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-wizard',
                    name: 'extra-component-form-wizard',
                    component: () => import('@/views/forms/form-wizard/FormWizard.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Form Wizard', active: true },
                        ],
                        pageTitle: 'Form Wizard',
                        rule: 'store'
                    },
                },
                {
                    path: '/forms/form-validation',
                    name: 'extra-component-form-validation',
                    component: () => import('@/views/forms/form-validation/FormValidation.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Form Validation', active: true },
                        ],
                        pageTitle: 'Form Validation',
                        rule: 'store'
                    },
                },
                {
                  path: '/forms/form-input-group',
                  name: 'extra-component-form-input-group',
                  component: () => import('@/views/forms/form-input-group/FormInputGroup.vue'),
                  meta: {
                      breadcrumb: [
                          { title: 'Home', url: '/' },
                          { title: 'Extra Components' },
                          { title: 'Form Input Group', active: true },
                      ],
                      pageTitle: 'Form Input Group',
                      rule: 'store'
                  },
                },

        // =============================================================================
        // Pages Routes
        // =============================================================================
                {
                    path: '/profile',
                    name: 'user-settings',
                    component: () => import('@/views/pages/user-settings/UserSettings.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Anasayfa', url: '/' },
                            { title: 'Kullanıcı Ayarları', active: true },
                        ],
                        pageTitle: 'Kullanıcı Ayarları',
                        rule: 'store',


                    },
                },

                {
                  path: '/store',
                  name: 'store-settings',
                  component: () => import('@/views/pages/store-settings/StoreSettings.vue'),
                  meta: {
                    breadcrumb: [
                      { title: 'Anasayfa', url: '/' },
                      { title: 'İşletme Ayarları', active: true },
                    ],
                    pageTitle: 'İşletme Ayarları',
                    rule: 'store',


                  },
                },
                {
                    path: '/pages/search',
                    name: 'page-search',
                    component: () => import('@/views/pages/Search.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Pages' },
                            { title: 'Search', active: true },
                        ],
                        pageTitle: 'Search',
                        rule: 'store'
                    },
                },
                {
                    path: '/pages/invoice',
                    name: 'page-invoice',
                    component: () => import('@/views/pages/Invoice.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Pages' },
                            { title: 'Invoice', active: true },
                        ],
                        pageTitle: 'Invoice',
                        rule: 'store'
                    },
                },




        // =============================================================================
        // EXTENSIONS
        // =============================================================================
                {
                    path: '/extensions/select',
                    name: 'extra-component-select',
                    component: () => import('@/views/components/extra-components/select/Select.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Select', active: true },
                        ],
                        pageTitle: 'Select',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/quill-user',
                    name: 'extra-component-quill-user',
                    component: () => import('@/views/components/extra-components/quill-editor/Quilleditor.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Quill user', active: true },
                        ],
                        pageTitle: 'Quill user',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/drag-and-drop',
                    name: 'extra-component-drag-and-drop',
                    component: () => import('@/views/components/extra-components/drag-and-drop/DragAndDrop.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Drag & Drop', active: true },
                        ],
                        pageTitle: 'Drag & Drop',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/datepicker',
                    name: 'extra-component-datepicker',
                    component: () => import('@/views/components/extra-components/datepicker/Datepicker.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Datepicker', active: true },
                        ],
                        pageTitle: 'Datepicker',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/datetime-picker',
                    name: 'extra-component-datetime-picker',
                    component: () => import('@/views/components/extra-components/datetime-picker/DatetimePicker.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extra Components' },
                            { title: 'Datetime Picker', active: true },
                        ],
                        pageTitle: 'Datetime Picker',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/access-control',
                    name: 'extra-component-access-control',
                    component: () => import('@/views/components/extra-components/access-control/AccessControl.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Access Control', active: true },
                        ],
                        pageTitle: 'Access Control',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/i18n',
                    name: 'extra-component-i18n',
                    component: () => import('@/views/components/extra-components/I18n.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'I18n', active: true },
                        ],
                        pageTitle: 'I18n',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/carousel',
                    name: 'extra-component-carousel',
                    component: () => import('@/views/components/extra-components/carousel/Carousel.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Carousel', active: true },
                        ],
                        pageTitle: 'Carousel',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/clipboard',
                    name: 'extra-component-clipboard',
                    component: () => import('@/views/components/extra-components/clipboard/Clipboard.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Clipboard', active: true },
                        ],
                        pageTitle: 'Clipboard',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/context-menu',
                    name: 'extra-component-context-menu',
                    component: () => import('@/views/components/extra-components/context-menu/ContextMenu.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Context Menu', active: true },
                        ],
                        pageTitle: 'Context Menu',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/star-ratings',
                    name: 'extra-component-star-ratings',
                    component: () => import('@/views/components/extra-components/star-ratings/StarRatings.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Star Ratings', active: true },
                        ],
                        pageTitle: 'Star Ratings',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/autocomplete',
                    name: 'extra-component-autocomplete',
                    component: () => import('@/views/components/extra-components/autocomplete/Autocomplete.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Autocomplete', active: true },
                        ],
                        pageTitle: 'Autocomplete',
                        rule: 'store'
                    },
                },
                {
                    path: '/extensions/tree',
                    name: 'extra-component-tree',
                    component: () => import('@/views/components/extra-components/tree/Tree.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Tree', active: true },
                        ],
                        pageTitle: 'Tree',
                        rule: 'store'
                    },
                },
                {
                    path: '/import-export/import',
                    name: 'import-excel',
                    component: () => import('@/views/components/extra-components/import-export/Import.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Import/Export' },
                            { title: 'Import', active: true },
                        ],
                        pageTitle: 'Import Excel',
                        rule: 'store'
                    },
                },
                {
                    path: '/import-export/export',
                    name: 'export-excel',
                    component: () => import('@/views/components/extra-components/import-export/Export.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Import/Export' },
                            { title: 'Export', active: true },
                        ],
                        pageTitle: 'Export Excel',
                        rule: 'store'
                    },
                },
                {
                    path: '/import-export/export-selected',
                    name: 'export-excel-selected',
                    component: () => import('@/views/components/extra-components/import-export/ExportSelected.vue'),
                    meta: {
                        breadcrumb: [
                            { title: 'Home', url: '/' },
                            { title: 'Extensions' },
                            { title: 'Import/Export' },
                            { title: 'Export Selected', active: true },
                        ],
                        pageTitle: 'Export Excel',
                        rule: 'store'
                    },
                },
            ],
        },
    // =============================================================================
    // FULL PAGE LAYOUTS
    // =============================================================================
        {
            path: '',
            component: () => import('@/layouts/full-page/FullPage.vue'),
            children: [
        // =============================================================================
        // PAGES
        // =============================================================================
                {
                    path: 'callback',
                    name: 'auth-callback',
                    component: () => import('@/views/Callback.vue'),
                    meta: {
                        rule:'user',

                    }
                },
                {
                    path: 'login',
                    name: 'login',
                    component: () => import('@/views/pages/auth/login/Login.vue'),
                    meta: {
                        rule:'guest',
                    }
                },
                {
                    path: '/register',
                    name: 'register',
                    component: () => import('@/views/pages/auth/register/Register.vue'),
                    meta: {
                        rule:'guest'
                    }
                },

              {
                path: '/email/verify/:id',
                name: 'verification.verify',
                component: () => import('@/views/pages/auth/verification/verify.vue'),
                meta: {
                  rule:'guest',
                }
              },
              {
                path: '/email/resend',
                name: 'verification.resend',
                component: () => import('@/views/pages/auth/verification/resend.vue'),
                meta: {
                  rule: 'guest',

                },
              },
              {
                path: '/password/email',
                name: 'password.email',
                component: () => import('@/views/pages/auth/password/email.vue'),
                meta: {
                  rule: 'guest',

                },
              },
              {
                path: '/password/reset',
                name: 'password.reset',
                component: () => import('@/views/pages/auth/password/reset.vue'),
                meta: {
                  rule: 'guest',
                },
               },

                {
                    path: '/comingsoon',
                    name: 'page-coming-soon',
                    component: () => import('@/views/pages/errors/ComingSoon.vue'),
                    meta: {
                        rule: 'store'
                    }
                },
                {
                    path: '/404',
                    name: '404',
                    component: () => import('@/views/pages/errors/Error404.vue'),
                    meta: {
                          rule: '*'
                    }
                },
                {
                    path: '/error-500',
                    name: 'page-error-500',
                    component: () => import('@/views/pages/errors/Error500.vue'),
                    meta: {
                        rule: '*'
                    }
                },
                {
                    path: '/not-authorized',
                    name: 'page-not-authorized',
                    component: () => import('@/views/pages/errors/NotAuthorized.vue'),
                    meta: {
                        rule: '*'
                    }
                },
                {
                    path: '/maintenance',
                    name: 'page-maintenance',
                    component: () => import('@/views/pages/errors/Maintenance.vue'),
                    meta: {
                        rule: '*'
                    }
                },
            ]
        },
        // Redirect to 404 page, if no match found
         {
            path: '*',
            redirect: '/404'
        }
    ],
})

router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById('loading-bg')
    if (appLoading) {
        appLoading.style.display = "none";
    }
})






export default router
