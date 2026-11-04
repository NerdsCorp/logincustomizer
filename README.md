# Login Customizer

Login Customizer lets you give the Pelican Panel login page a look that fits your server. Add your own logo and welcome message, choose a background image, GIF, or video, and adjust the login card, colors, text, and alignment. There’s also a field for custom CSS if you want to fine-tune the page.

The plugin leaves Pelican’s login form and authentication flow in place. You can change the appearance without replacing how people sign in. Settings are managed from the panel, and you can restore the defaults there whenever you want.

# Preview Photos

## Settings Pages

<img width="594" height="900" alt="Screenshot 2026-11-03 223936" src="https://github.com/user-attachments/assets/d783aa07-4a7b-4f41-bf7d-3e6b034e02be" />

<img width="598" height="900" alt="Screenshot 2026-11-03 223905" src="https://github.com/user-attachments/assets/33207edd-01dc-4a4a-9ae8-73650827ccab" />

## Before plugin

<img width="1919" height="956" alt="Screenshot 2026-11-03 223951" src="https://github.com/user-attachments/assets/8c05357b-53e7-478a-9ffd-ec87f36cbc68" />

## Using a GIF and modified settings with plugin

https://github.com/user-attachments/assets/a02d3ac7-881d-4df3-b290-f373e6d252b9


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
