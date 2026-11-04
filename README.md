# Login Customizer

Login Customizer lets you give the Pelican Panel login page a look that fits your server. Add your own logo and welcome message, choose a background image, GIF, or video, and adjust the login card, colors, text, and alignment. There’s also a field for custom CSS if you want to fine-tune the page.

The plugin leaves Pelican’s login form and authentication flow in place. You can change the appearance without replacing how people sign in. Settings are managed from the panel, and you can restore the defaults there whenever you want.

## Install

1. Zip the `logincustomizer` plugin folder.
2. In Pelican Panel, open the Plugins page and import the archive.
3. Open Login Customizer’s settings and save the changes you want.

For a manual install, copy the `logincustomizer` folder into the panel’s `plugins` directory, then run this from the panel root:

```sh
php artisan p:plugin:install
```

The installed directory must be named `logincustomizer` so it matches the plugin ID.

## A few notes

- Leave a setting blank to keep Pelican’s default for that part of the page.
- Use HTTPS URLs for your logo and background media. GIFs animate; video backgrounds can use MP4, WebM, or OGG. If automatic detection doesn’t recognize your video URL, choose **Video** as the media type in settings.
- **Override dark and light themes** applies your configured login colors in both modes.
- Custom CSS is added directly to the login page. Only give access to that setting to people you trust to edit CSS.