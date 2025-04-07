const CACHE_NAME = 'quiz-app-v1';

const STATIC_ASSETS = [
    '/',
    '/manifest.json',
    '/offline.html',
    '/images/icon-light.svg',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png',
];

// Cache static assets on install
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            console.log('📦 Installing service worker & caching static assets');
            return cache.addAll(STATIC_ASSETS);
        })
    );
    self.skipWaiting();
});

// Delete old caches on activate
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) =>
            Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        console.log('🧹 Removing old cache:', name);
                        return caches.delete(name);
                    }
                })
            )
        )
    );
    self.clients.claim();
});

// Serve from cache or fetch from network
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    event.respondWith(
        caches.match(event.request).then((cachedResponse) => {
            return (
                cachedResponse ||
                fetch(event.request).then((networkResponse) => {
                    // Runtime cache new requests (like hashed Vite assets)
                    return caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, networkResponse.clone());
                        return networkResponse;
                    });
                })
            );
        }).catch(() => {
            // Optional fallback page if offline
            return caches.match('/offline.html');
        })
    );
});
