
Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'nova-notifications',
            path: '/nova-notifications',
            component: require('./components/NotificationsOverview'),
        },
        {
            name: 'nova-notifications-send',
            path: '/nova-notifications-send',
            component: require('./components/NotificationsSend'),
        },
    ])

})



