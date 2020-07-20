/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
          url     => router path
          name    => name to display in sidebar
          slug    => router path name
          icon    => Feather Icon component/icon name
          tag     => text to display on badge
          tagColor  => class to apply on badge element
          i18n    => Internationalization
          submenu   => submenu of current item (current item will become dropdown )
                NOTE: Submenu don't have any icon(you can add icon if u want to display)
          isDisabled  => disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: https://www.dijitalreklam.org
==========================================================================================*/


export default [
  // {
  //   url: "/apps/email",
  //   name: "Email",
  //   slug: "email",
  //   icon: "MailIcon",
  //   i18n: "Email",
  // },


  {
    url: "/",
    name: "Dashboard",
    // tag: "2",
    // tagColor: "warning",
    icon: "HomeIcon",
    i18n: "Dashboard",
  },
  {
    header: "Apps",
    icon: "PackageIcon",
    i18n: "Apps",
    items: [
      // {
      //   url: "/apps/email",
      //   name: "Email",
      //   slug: "email",
      //   icon: "MailIcon",
      //   i18n: "Email",
      // },
      // {
      //   url: "/apps/calendar/vue-simple-calendar",
      //   name: "Calendar",
      //   slug: "calendar-simple-calendar",
      //   icon: "CalendarIcon",
      //   tagColor: "success",
      //   i18n: "Calendar",
      // },
      // {
      //   url: null,
      //   name: "User",
      //   icon: "UserIcon",
      //   i18n: "User",
      //   submenu: [
      //     {
      //       url: '/users',
      //       name: "List",
      //       slug: "app-user-list",
      //       i18n: "List",
      //     },
      //   ]
      // },
      {
        url: null,
        name: "Clients",
        icon: "UserIcon",
        i18n: "Clients",
        submenu: [
          {
            url: '/clients',
            name: "clients",
            slug: "clients",
            i18n: "List",

          },
        ]
      },
      {
        url: null,
        name: "Shopping",
        icon: "ShoppingCartIcon",
        i18n: "Shopping",
        submenu: [
          {
            url: '/shopping-list',
            name: "Shopping",
            slug: "Shopping",
            i18n: "List",
          },
        ]
      },
      {
        url: '/store',
        name: "Store",
        icon: "ArchiveIcon",
        i18n: "Store",
      },
    ]
  },
  // {
  //   header: "UI",
  //   icon: "LayersIcon",
  //   i18n: "UI",
  //   items: [
  //     {
  //       url: null,
  //       name: "Data List",
  //       tag: "new",
  //       tagColor: "primary",
  //       icon: "ListIcon",
  //       i18n: "DataList",
  //       submenu: [
  //         {
  //           url: '/ui-elements/data-list/list-view',
  //           name: "List View",
  //           slug: "data-list-list-view",
  //           i18n: "ListView",
  //         },
  //         {
  //           url: '/ui-elements/data-list/thumb-view',
  //           name: "Thumb View",
  //           slug: "data-list-thumb-view",
  //           i18n: "ThumbView",
  //         },
  //       ]
  //     },
  //     {
  //       url: null,
  //       name: "Grid",
  //       icon: "LayoutIcon",
  //       i18n: "Grid",
  //       submenu: [
  //         {
  //           url: '/ui-elements/grid/vuesax',
  //           name: "Vuesax",
  //           slug: "grid-vuesax",
  //           i18n: "Vuesax",
  //         },
  //         {
  //           url: '/ui-elements/grid/tailwind',
  //           name: "Tailwind",
  //           slug: "grid-tailwind",
  //           i18n: "Tailwind",
  //         },
  //       ]
  //     },
  //     {
  //       url: "/ui-elements/colors",
  //       name: "Colors",
  //       slug: "colors",
  //       icon: "DropletIcon",
  //       i18n: "Colors",
  //     },
  //     {
  //       url: null,
  //       name: "Card",
  //       icon: "CreditCardIcon",
  //       i18n: "Card",
  //       submenu: [
  //         {
  //           url: '/ui-elements/card/basic',
  //           name: "Basic",
  //           slug: "basic-cards",
  //           i18n: "Basic",
  //         },
  //         {
  //           url: '/ui-elements/card/statistics',
  //           name: "Statistics",
  //           slug: "statistics-cards",
  //           i18n: "Statistics",
  //         },
  //         {
  //           url: '/ui-elements/card/analytics',
  //           name: "Analytics",
  //           slug: "analytics-cards",
  //           i18n: "Analytics",
  //         },
  //         {
  //           url: '/ui-elements/card/card-actions',
  //           name: "Card Actions",
  //           slug: "card-actions",
  //           i18n: "CardActions",
  //         },
  //         {
  //           url: '/ui-elements/card/card-colors',
  //           name: "Card Colors",
  //           slug: "card-colors",
  //           i18n: "CardColors",
  //         }
  //       ]
  //     },
  //     {
  //       url: null,
  //       name: "Components",
  //       icon: "ArchiveIcon",
  //       i18n: "Components",
  //       submenu: [
  //         {
  //           url: '/components/alert',
  //           name: "Alert",
  //           slug: "component-alert",
  //           i18n: "Alert",
  //         },
  //         {
  //           url: '/components/avatar',
  //           name: "Avatar",
  //           slug: "component-avatar",
  //           i18n: "Avatar",
  //         },
  //         {
  //           url: '/components/breadcrumb',
  //           name: "Breadcrumb",
  //           slug: "component-breadcrumb",
  //           i18n: "Breadcrumb",
  //         },
  //         {
  //           url: '/components/button',
  //           name: "Button",
  //           slug: "component-button",
  //           i18n: "Button",
  //         },
  //         {
  //           url: '/components/button-group',
  //           name: "Button Group",
  //           slug: "component-button-group",
  //           i18n: "ButtonGroup",
  //         },
  //         {
  //           url: '/components/chip',
  //           name: "Chip",
  //           slug: "component-chip",
  //           i18n: "Chip",
  //         },
  //         {
  //           url: '/components/collapse',
  //           name: "Collapse",
  //           slug: "component-collapse",
  //           i18n: "Collapse",
  //         },
  //         {
  //           url: '/components/dialogs',
  //           name: "Dialogs",
  //           slug: "component-dialog",
  //           i18n: "Dialogs",
  //         },
  //         {
  //           url: '/components/divider',
  //           name: "Divider",
  //           slug: "component-divider",
  //           i18n: "Divider",
  //         },
  //         {
  //           url: '/components/dropdown',
  //           name: "DropDown",
  //           slug: "component-drop-down",
  //           i18n: "DropDown",
  //         },
  //         {
  //           url: '/components/list',
  //           name: "List",
  //           slug: "component-list",
  //           i18n: "List",
  //         },
  //         {
  //           url: '/components/loading',
  //           name: "Loading",
  //           slug: "component-loading",
  //           i18n: "Loading",
  //         },
  //         {
  //           url: '/components/navbar',
  //           name: "Navbar",
  //           slug: "component-navbar",
  //           i18n: "Navbar",
  //         },
  //         {
  //           url: '/components/notifications',
  //           name: "Notifications",
  //           slug: "component-notifications",
  //           i18n: "Notifications",
  //         },
  //         {
  //           url: '/components/pagination',
  //           name: "Pagination",
  //           slug: "component-pagination",
  //           i18n: "Pagination",
  //         },
  //         {
  //           url: '/components/popup',
  //           name: "Popup",
  //           slug: "component-popup",
  //           i18n: "Popup",
  //         },
  //         {
  //           url: '/components/progress',
  //           name: "Progress",
  //           slug: "component-progress",
  //           i18n: "Progress",
  //         },
  //         {
  //           url: '/components/sidebar',
  //           name: "Sidebar",
  //           slug: "component-sidebar",
  //           i18n: "Sidebar",
  //         },
  //         {
  //           url: '/components/slider',
  //           name: "Slider",
  //           slug: "component-slider",
  //           i18n: "Slider",
  //         },
  //         {
  //           url: '/components/tabs',
  //           name: "Tabs",
  //           slug: "component-tabs",
  //           i18n: "Tabs",
  //         },
  //         {
  //           url: '/components/tooltip',
  //           name: "Tooltip",
  //           slug: "component-tooltip",
  //           i18n: "Tooltip",
  //         },
  //         {
  //           url: '/components/upload',
  //           name: "Upload",
  //           slug: "component-upload",
  //           i18n: "Upload",
  //         },
  //       ]
  //     },
  //     {
  //       url: null,
  //       name: "Extensions",
  //       icon: "PlusCircleIcon",
  //       i18n: "Extensions",
  //       submenu: [
  //         {
  //           url: '/extensions/select',
  //           name: "Select",
  //           icon: "PocketIcon",
  //           slug: "extra-component-select",
  //           i18n: "Select",
  //         },
  //         {
  //           url: '/extensions/quill-editor',
  //           name: "Quill Editor",
  //           icon: "EditIcon",
  //           slug: "extra-component-quill-editor",
  //           i18n: "QuillEditor",
  //         },
  //         {
  //           url: '/extensions/drag-and-drop',
  //           name: "Drag & Drop",
  //           icon: "DropletIcon",
  //           slug: "extra-component-drag-and-drop",
  //           i18n: "DragAndDrop",
  //         },
  //         {
  //           url: '/extensions/datepicker',
  //           name: "Datepicker",
  //           icon: "CalendarIcon",
  //           slug: "extra-component-datepicker",
  //           i18n: "Datepicker",
  //         },
  //         {
  //           url: '/extensions/datetime-picker',
  //           name: "Datetime Picker",
  //           icon: "ClockIcon",
  //           slug: "extra-component-datetime-picker",
  //           i18n: "DatetimePicker",
  //         },
  //         {
  //           url: '/extensions/access-control',
  //           name: "Access Control",
  //           slug: "extra-component-access-control",
  //           i18n: "AccessControl",
  //         },
  //         {
  //           url: '/extensions/i18n',
  //           name: "I18n",
  //           slug: "extra-component-i18n",
  //           i18n: "I18n",
  //         },
  //         {
  //           url: '/extensions/carousel',
  //           name: "Carousel",
  //           icon: "LayersIcon",
  //           slug: "extra-component-carousel",
  //           i18n: "Carousel",
  //         },
  //         {
  //           url: '/extensions/clipboard',
  //           name: "Clipboard",
  //           icon: "CopyIcon",
  //           slug: "extra-component-clipboard",
  //           i18n: "Clipboard",
  //         },
  //         {
  //           url: '/extensions/context-menu',
  //           name: "Context Menu",
  //           icon: "MoreHorizontalIcon",
  //           slug: "extra-component-context-menu",
  //           i18n: "ContextMenu",
  //         },
  //         {
  //           url: '/extensions/star-ratings',
  //           name: "Star Ratings",
  //           icon: "StarIcon",
  //           slug: "extra-component-star-ratings",
  //           i18n: "StarRatings",
  //         },
  //         {
  //           url: '/extensions/autocomplete',
  //           name: "Autocomplete",
  //           icon: "Edit3Icon",
  //           slug: "extra-component-autocomplete",
  //           i18n: "Autocomplete",
  //         },
  //         {
  //           url: '/extensions/tree',
  //           name: "Tree",
  //           icon: "GitPullRequestIcon",
  //           slug: "extra-component-tree",
  //           i18n: "Tree",
  //         },
  //         // {
  //         //   name: "Import/Export",
  //         //   i18n: "Import/Export",
  //         //   submenu: [
  //
  //         //   ]
  //         // },
  //         {
  //           url: "/import-export/import",
  //           name: "Import",
  //           icon: "HomeIcon",
  //           slug: "import",
  //           i18n: "Import"
  //         },
  //         {
  //           url: "/import-export/export",
  //           name: "Export",
  //           icon: "HomeIcon",
  //           slug: "export",
  //           i18n: "Export"
  //         },
  //         {
  //           url: "/import-export/export-selected",
  //           name: "Export Selected",
  //           icon: "HomeIcon",
  //           slug: "export-selected",
  //           i18n: "ExportSelected"
  //         }
  //       ]
  //     },
  //   ]
  // },
  // {
  //   header: "Forms & Table",
  //   icon: "Edit3Icon",
  //   i18n: "FormsAndTable",
  //   items: [
  //     {
  //       url: null,
  //       name: "Form Elements",
  //       icon: "CopyIcon",
  //       i18n: "FormElements",
  //       submenu: [
  //         // {
  //         //  url: '/forms/form-elements/select',
  //         //  name: "Select",
  //         //  slug: "form-element-select",
  //         //  i18n: "Select",
  //         // },
  //         {
  //           url: '/forms/form-elements/switch',
  //           name: "Switch",
  //           slug: "form-element-switch",
  //           i18n: "Switch",
  //         },
  //         {
  //           url: '/forms/form-elements/checkbox',
  //           name: "Checkbox",
  //           slug: "form-element-checkbox",
  //           i18n: "Checkbox",
  //         },
  //         {
  //           url: '/forms/form-elements/radio',
  //           name: "Radio",
  //           slug: "form-element-radio",
  //           i18n: "Radio",
  //         },
  //         {
  //           url: '/forms/form-elements/input',
  //           name: "Input",
  //           slug: "form-element-input",
  //           i18n: "Input",
  //         },
  //         {
  //           url: '/forms/form-elements/number-input',
  //           name: "Number Input",
  //           slug: "form-element-number-input",
  //           i18n: "NumberInput",
  //         },
  //         {
  //           url: '/forms/form-elements/textarea',
  //           name: "Textarea",
  //           slug: "form-element-textarea",
  //           i18n: "Textarea",
  //         },
  //       ]
  //     },
  //     {
  //       url: '/forms/form-layouts',
  //       name: "Form Layouts",
  //       icon: "PackageIcon",
  //       slug: "forms-form-layouts",
  //       i18n: "FormLayouts",
  //     },
  //     {
  //       url: '/forms/form-wizard',
  //       name: "Form Wizard",
  //       icon: "PackageIcon",
  //       slug: "extra-component-form-wizard",
  //       i18n: "FormWizard",
  //     },
  //     {
  //       url: '/forms/form-validation',
  //       name: "Form Validation",
  //       icon: "CheckCircleIcon",
  //       slug: "extra-component-form-validation",
  //       i18n: "FormValidation",
  //     },
  //     {
  //       url: '/forms/form-input-group',
  //       name: "Form Input Group",
  //       icon: "MenuIcon",
  //       slug: "extra-component-form-input-group",
  //       i18n: "FormInputGroup",
  //     },
  //
  //     {
  //       url: "/ui-elements/ag-grid-table",
  //       name: "agGrid Table",
  //       slug: "ag-grid-table",
  //       icon: "GridIcon",
  //       i18n: "agGridTable",
  //     },
  //   ]
  // },
  // {
  //   header: "Pages",
  //   icon: "FileIcon",
  //   i18n: "Pages",
  //   items: [
  //     {
  //       url: '/pages/user-settings',
  //       slug: 'page-user-settings',
  //       name: "User Settings",
  //       icon: "SettingsIcon",
  //       i18n: "UserSettings",
  //     },
  //     {
  //       url: '/pages/search',
  //       slug: 'page-search',
  //       name: "Search",
  //       icon: "SearchIcon",
  //       i18n: "Search",
  //     },
  //     {
  //       url: '/pages/invoice',
  //       slug: 'page-invoice',
  //       name: "Invoice",
  //       icon: "InfoIcon",
  //       i18n: "Invoice",
  //     },
  //     {
  //       url: null,
  //       name: "Authentication",
  //       icon: "PieChartIcon",
  //       i18n: "Authentication",
  //       submenu: [
  //         {
  //           url: '/pages/login',
  //           name: "Login",
  //           slug: "pages-login",
  //           i18n: "Login",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/pages/register',
  //           name: "Register",
  //           slug: "pages-register",
  //           i18n: "Register",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/pages/forgot-password',
  //           name: "Forgot Password",
  //           slug: "pages-forgot-password",
  //           i18n: "ForgotPassword",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/pages/reset-password',
  //           name: "Reset Password",
  //           slug: "pages-reset-password",
  //           i18n: "ResetPassword",
  //           target: '_blank',
  //         },
  //       ]
  //     },
  //     {
  //       url: null,
  //       name: "Miscellaneous",
  //       icon: "CoffeeIcon",
  //       i18n: "Miscellaneous",
  //       submenu: [
  //         {
  //           url: '/not-authorized',
  //           name: "Not Authorized",
  //           slug: "page-not-authorized",
  //           icon: "XCircleIcon",
  //           i18n: "NotAuthorized",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/maintenance',
  //           name: "Maintenance",
  //           slug: "page-maintenance",
  //           icon: "AnchorIcon",
  //           i18n: "Maintenance",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/comingsoon',
  //           slug: 'page-coming-soon',
  //           name: "Coming Soon",
  //           icon: "ClockIcon",
  //           i18n: "ComingSoon",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/error-404',
  //           name: "404",
  //           slug: "page-error-404",
  //           i18n: "404",
  //           target: '_blank',
  //         },
  //         {
  //           url: '/error-500',
  //           name: "500",
  //           slug: "page-error-500",
  //           i18n: "500",
  //           target: '_blank',
  //         }
  //       ]
  //     },
  //   ]
  // },


]

