// public/sw.js

const CACHE_NAME = 'weddingkita-v1';
const urlsToCache = ['/', '/listings'];

// Install event
self.addEventListener('install', event => {
  console.log('🎉 WeddingKita Service Worker installed');
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('📦 Caching app shell');
        return cache.addAll(urlsToCache);
      })
  );
});

// Fetch event
self.addEventListener('fetch', event => {
  console.log('🔍 Fetching:', event.request.url);
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Return cached version or fetch new
        return response || fetch(event.request);
      })
  );
});

// Activate event
self.addEventListener('activate', event => {
  console.log('🚀 WeddingKita Service Worker activated');
});