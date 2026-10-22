const CACHE_NAME = 'eagt-golani-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/assets/css/bootstrap.min.css',
    '/assets/icons/bootstrap-icons.min.css',
    '/assets/js/bootstrap.bundle.min.js',
    '/assets/images/eagt_logo.jpg'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))
            );
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        fetch(event.request)
            .then((networkResponse) => {
                return caches.open(CACHE_NAME).then((cache) => {
                    // Only cache static assets (css, js, images)
                    if (event.request.url.includes('/assets/')) {
                        cache.put(event.request, networkResponse.clone());
                    }
                    return networkResponse;
                });
            })
            .catch(() => caches.match(event.request))
    );
});
