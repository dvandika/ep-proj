export default [{
        title: "Home",
        type: "single",
        active: false,
        index: 0,
        link: {
            name: "under-constructed"
        }
    },
    {
        title: "Master Data",
        type: "group",
        child: [{
                title: "Master Data Vendor",
                icon: "dashboard",
                active: false,
                index: 1,
                link: {
                    name: "under-constructed"
                }
            },
            {
                title: "Master Data User",
                icon: "people",
                active: false,
                index: 2,
                link: {
                    name: "under-constructed"
                }
            },
            {
                title: "Master Data Informasi",
                icon: "info",
                active: false,
                index: 3,
                link: {
                    name: "under-constructed"
                }
            }
        ]
    },
    {
        title: "Order sheet",
        type: "group",
        child: [{
                title: "List Order Sheet",
                icon: "list",
                active: false,
                index: 4,
                link: {
                    name: "under-constructed"
                }
            },
            {
                title: "Upload Order Sheet",
                icon: "cloud_upload",
                active: false,
                index: 5,
                link: {
                    name: "under-constructed"
                }
            }
        ]
    },
    {
        title: "Vendor Stock",
        type: "group",
        child: [{
            title: "Component Stock",
            icon: "storage",
            active: false,
            index: 6,
            link: {
                name: "under-constructed"
            }
        }]
    }
];