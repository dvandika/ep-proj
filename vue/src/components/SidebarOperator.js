export default [{
        title: "Order sheet",
        type: "group",
        child: [{
                title: "Upload Order Sheet",
                icon: "cloud_upload",
                active: false,
                index: 0,
                link: {
                    name: "under-constructed"
                }
            },
            {
                title: "List Order Sheet",
                icon: "list",
                active: false,
                index: 1,
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
            index: 2,
            link: {
                name: "under-constructed"
            }
        }]
    }
];