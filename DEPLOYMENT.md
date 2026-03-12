# Deployment checklist (hosting)

When you host this app on a real server (not `http://127.0.0.1:8000`), do the following so the site looks and works the same as locally (especially **user profile images**, menu images, and other assets).

## 1. Set `APP_URL` in `.env`

Set `APP_URL` to your public URL **without** a trailing slash, for example:

- `APP_URL=https://yourdomain.com`
- or `APP_URL=http://your-server-ip`

If you leave it as `http://127.0.0.1:8000` or `http://localhost`, links and images (including user profile photos) can point to the wrong place or show as broken. The app will try to fix this when the request host is not localhost, but setting `APP_URL` correctly is recommended.

## 2. Create the storage link

User profile photos and other uploads are stored under `storage/app/public`. They are served from `public/storage` via a symlink. On the server, run once:

```bash
php artisan storage:link
```

If this is not run, URLs like `/storage/profile-photos/...` will return 404 and user images will not show.

## 3. (Optional) Reverse proxy

If the app is behind Nginx/Apache and you use HTTPS, ensure the proxy forwards the correct scheme and host. Laravel’s `TrustProxies` middleware should be configured for your proxy (see `app/Http/Middleware/TrustProxies.php` and set the proxy IPs if needed).

---

**Summary:** Set `APP_URL` to your real site URL and run `php artisan storage:link` on the host. That should resolve “no image” and wrong URLs when hosting.
