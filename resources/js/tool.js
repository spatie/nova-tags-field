Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: ':package_name',
            path: '/:package_name',
            component: require('./components/Tool'),
        },
    ])
})
