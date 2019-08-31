export default [{
        title: "Home",
        type: 'single',
        active: true,
        icon: "dashboard",
        index: 0,
        link: {
            name: "home-vendor"
        }
    },
    {
        title: "Order Sheet",
        type: 'single',
        active: true,
        icon: "list",
        index: 1,
        link: {
            name: "under-constructed"
        }
    },
    {
        title: "Component Stock",
        type: "group",
        icon: "store",
        child: [{
                title: "Report Component",
                icon: "store",
                active: true,
                index: 2,
                link: {
                    name: "under-constructed"
                }
            },
            {
                title: "History Report",
                icon: "history",
                active: true,
                index: 3,
                link: {
                    name: "under-constructed"
                }
            }
        ]
    }
]