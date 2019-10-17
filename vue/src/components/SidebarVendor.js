export default [{
        title: "Home",
        type: "single",
        active: false,
        icon: "dashboard",
        index: 0,
        link: {
            name: "vendor-home"
        }
    },
    {
        title: "Order Sheet",
        type: "single",
        active: false,
        icon: "list",
        index: 1,
        link: {
            name: "vendor-os"
        }
    },
    {
        title: "Stock Report",
        type: "group",
        child: [{
                title: "Daily Stock Report",
                icon: "store",
                active: false,
                index: 2,
                link: {
                    name: "vendor-report"
                }
            },
            {
                title: "Template Daily Stock Report",
                icon: "history",
                active: false,
                index: 3,
                link: {
                    name: "vendor-template-report"
                }
            }
        ]
    }
]