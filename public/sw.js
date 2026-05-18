self.addEventListener('install', event => {
  event.waitUntil(caches.open('ryze-v1').then(cache => cache.addAll(['/', '/shop', '/images/ryze-logo.jpeg'])));
});
self.addEventListener('fetch', event => {
  event.respondWith(caches.match(event.request).then(response => response || fetch(event.request)));
});
