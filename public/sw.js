self.addEventListener('install', (event) => {
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    const data = event.data ? event.data.json() : {};
    const title = data.title || 'Cyber.Net Notification';
    const message = data.body || 'New update available!';
    const icon = data.icon || '/cyberlogo.jpg';
    const url = data.url || '/';

    const options = {
        body: message,
        icon: icon,
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1,
            url: url
        },
        actions: [
            { action: 'open_url', title: 'Fungua App' }
        ]
    };

    event.waitUntil(
        self.registration.showNotification(title, options)
    );
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    // Open the URL
    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function (clientList) {
            if (clientList.length > 0) {
                let client = clientList[0];
                for (let i = 0; i < clientList.length; i++) {
                    if (clientList[i].focused) {
                        client = clientList[i];
                    }
                }
                if (event.notification.data.url) {
                    client.navigate(event.notification.data.url);
                }
                return client.focus();
            }
            return clients.openWindow(event.notification.data.url || '/');
        })
    );
});
