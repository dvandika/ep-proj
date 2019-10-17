export default [{
        title: "Home",
        type: "single",
        icon: "dashboard",
        active: false,
        index: 0,
        link: {
            name: "admin-home"
        }
    },
    {
        title: "Order sheet",
        type: "group",
        child: [{
                title: "List Order Sheet",
                icon: "list",
                active: false,
                index: 1,
                link: {
                    name: "list-os"
                }
            },
            {
                title: "Upload Order Sheet",
                icon: "cloud_upload",
                active: false,
                index: 2,
                link: {
                    name: "upload-os"
                }
            }
        ]
    },
    {
        title: "Vendor Report Stock",
        type: "group",
        child: [
            // {
            //     title: "Material Stock",
            //     icon: "storage",
            //     active: false,
            //     index: 3,
            //     link: {
            //         name: "material-stock"
            //     }
            // },
            {
                title: "List Daily Report",
                icon: "file_copy",
                active: false,
                index: 4,
                link: {
                    name: "list-daily-report"
                }
            },
            {
                title: "Template Daily Report",
                icon: "folder",
                active: false,
                index: 5,
                link: {
                    name: "template-daily-report"
                }
            }
        ]
    },
    {
        title: "Master Data",
        type: "group",
        child: [{
                title: "Master Data Vendor",
                icon: "dashboard",
                active: false,
                index: 6,
                link: {
                    name: "md-vendor"
                }
            },
            {
                title: "Master Data User",
                icon: "people",
                active: false,
                index: 7,
                link: {
                    name: "md-user"
                }
                // },
                // {
                //     title: "Master Data Material",
                //     icon: "info",
                //     active: false,
                //     index: 8,
                //     link: {
                //         name: "md-material"
                //     }
            }
        ]
    }
];