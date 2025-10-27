# Nony Portfolio Theme - Installation Guide

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- Modern web browser with CSS backdrop-filter support

## Installation Steps

### 1. Upload Theme

**Option A: Via WordPress Admin**
1. Go to `Appearance > Themes > Add New`
2. Click `Upload Theme`
3. Choose the `nony-portfolio.zip` file
4. Click `Install Now`
5. Click `Activate`

**Option B: Via FTP**
1. Extract the `nony-portfolio.zip` file
2. Upload the `nony-portfolio` folder to `/wp-content/themes/`
3. Go to `Appearance > Themes` in WordPress admin
4. Click `Activate` on Nony Portfolio

### 2. Install NonyLabs Companion Plugin

**IMPORTANT:** The theme requires the NonyLabs Companion plugin to function properly.

**Option A: Automatic Installation (Recommended)**

After activating the theme, you'll see a notice to install required plugins:

1. Click `Install Required Plugins` in the admin notice
2. Click `Install` next to "NonyLabs Companion"
3. After installation, click `Activate`

**Option B: Manual Installation**

1. Upload the `nonylabs-companion` folder to `/wp-content/plugins/`
2. Go to `Plugins > Installed Plugins`
3. Find "NonyLabs Companion" and click `Activate`

**Option C: Via WordPress Admin**

1. Go to `Plugins > Add New > Upload Plugin`
2. Choose the `nonylabs-companion.zip` file
3. Click `Install Now`
4. Click `Activate Plugin`

### 3. Configure Your Portfolio

Once the plugin is activated, you'll see a new "NonyLabs" menu in your WordPress admin.

#### General Settings
1. Go to `NonyLabs > General`
2. Set your navigation logo text (e.g., "nony.cc")
3. Set your site title for SEO
4. Configure footer brand text and tagline
5. Set copyright text
6. Click `Save Changes`

#### Profile Badges
1. Go to `NonyLabs > Profile Badges`
2. Edit existing badges or click `+ Add Badge`
3. Use emojis and text (e.g., "16 y/o", "🇩🇪 Germany", "💀 Horror Fan")
4. Preview your changes in real-time
5. Remove unwanted badges with the `Remove` button
6. Click `Save Changes`

#### Social Links
1. Go to `NonyLabs > Social Links`
2. For each social platform:
   - Set platform name (e.g., "Bluesky", "Discord", "GitHub")
   - Enter the full URL to your profile
   - Add username or display text
   - Set icon class from [remixicon.com](https://remixicon.com/)
   - Choose gradient colors using the color pickers
3. Click `+ Add Social Link` to add more platforms
4. Preview your changes in real-time
5. Click `Save Changes`

**Popular Icon Classes:**
- Bluesky: `ri-bluesky-fill`
- Discord: `ri-discord-fill`
- GitHub: `ri-github-fill`
- Twitter/X: `ri-twitter-x-fill`
- Instagram: `ri-instagram-fill`
- LinkedIn: `ri-linkedin-fill`
- YouTube: `ri-youtube-fill`

### 4. Create Navigation Menus

1. Go to `Appearance > Menus`
2. Create a new menu (e.g., "Main Menu")
3. Add pages/links to your menu
4. Assign to "Primary Menu" location
5. Optionally create a footer menu and assign to "Footer Menu"

**Default Menu Items:**
If you don't create a custom menu, the theme will display:
- Home
- About
- Blog
- Contact

### 5. Customize with Site Editor

1. Go to `Appearance > Editor`
2. Edit templates, patterns, and styles
3. Customize colors in `theme.json`
4. Add your content using block patterns

## Customization Tips

### Adding Custom Colors
Edit `theme.json` to change the color palette and gradients.

### Modifying Templates
Edit files in `/templates/` to change page layouts:
- `index.html` - Homepage
- `singular.html` - Single posts
- `page.html` - Pages
- `archive.html` - Blog archive
- `404.html` - Error page

### Template Parts
Edit files in `/parts/` for reusable components:
- `header.html` - Site header with navigation
- `footer.html` - Site footer

### Custom Patterns
Edit files in `/patterns/` to create reusable content blocks:
- `badges.php` - Profile badges pattern
- `social-links.php` - Social links pattern
- `hero.php` - Hero section pattern

### Styling
All CSS is in `style.css`. The theme uses:
- Glassmorphism effects with backdrop-filter
- CSS animations for blobs and particles
- Responsive design with mobile-first approach
- Custom properties for easy theming

### Using Shortcodes

The NonyLabs Companion plugin provides shortcodes you can use anywhere:

- `[nony_navigation]` - Outputs the navigation header
- `[nony_badges]` - Displays profile badges
- `[nony_social]` - Shows social media cards
- `[nony_footer]` - Renders the footer

## Troubleshooting

### Plugin Not Installing
- Check file permissions on `/wp-content/plugins/` (should be 755)
- Manually upload the `nonylabs-companion` folder to `/wp-content/plugins/`
- Ensure you have admin privileges
- Check PHP memory limit (minimum 64MB recommended)

### Navigation Not Showing
- Make sure you've created a menu in `Appearance > Menus`
- Assign the menu to "Primary Menu" location
- Check that the NonyLabs Companion plugin is activated
- Clear your browser cache

### Badges/Social Links Not Appearing
- Ensure the NonyLabs Companion plugin is activated
- Check that you've saved your settings in `NonyLabs` menu
- Verify shortcodes are properly placed in templates
- Clear WordPress cache and browser cache

### Mobile Menu Not Working
- Ensure JavaScript is enabled in your browser
- Check browser console for errors
- Clear browser cache
- Try a different browser to isolate the issue

### Styling Issues
- Clear WordPress cache (if using a caching plugin)
- Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)
- Check that your browser supports CSS backdrop-filter
- Verify all CSS files are loading (check browser console)

### Glassmorphic Effects Not Showing
- Ensure your browser supports `backdrop-filter` CSS property
- Check if hardware acceleration is enabled in browser settings
- Try updating your browser to the latest version
- Some older browsers may not support these effects

### Theme/Plugin Compatibility
- Deactivate other plugins to check for conflicts
- Switch to a default WordPress theme to isolate theme issues
- Check WordPress debug log for errors
- Ensure WordPress, PHP, and MySQL meet minimum requirements

## File Structure

\`\`\`
nony-portfolio/
├── assets/
│   └── js/
│       └── script.js          # Custom JavaScript
├── inc/
│   └── class-tgm-plugin-activation.php
├── parts/
│   ├── header.html            # Header template part
│   └── footer.html            # Footer template part
├── patterns/
│   ├── badges.php             # Badges pattern
│   ├── hero.php               # Hero pattern
│   └── social-links.php       # Social links pattern
├── styles/
│   └── default.json           # Style variation
├── templates/
│   ├── 404.html               # 404 error page
│   ├── archive.html           # Blog archive
│   ├── index.html             # Homepage
│   ├── page.html              # Page template
│   └── singular.html          # Single post
├── functions.php              # Theme functions
├── README.txt                 # Theme readme
├── screenshot.png             # Theme screenshot
├── style.css                  # Main stylesheet
└── theme.json                 # Theme configuration

nonylabs-companion/
├── includes/
│   ├── class-admin.php        # Admin interface
│   ├── class-settings.php     # Settings management
│   └── class-shortcodes.php   # Shortcode handlers
├── templates/
│   ├── admin-general.php      # General settings page
│   ├── admin-badges.php       # Badges settings page
│   └── admin-social.php       # Social settings page
├── nonylabs-companion.php     # Main plugin file
└── README.txt                 # Plugin readme
\`\`\`

## Support

For issues or questions:
- Check the FAQ in README.txt
- Review the documentation
- Check WordPress.org support forums
- Contact theme support at https://nony.cc

## Updates

Keep your theme and plugin updated for:
- Security patches
- New features
- Bug fixes
- WordPress compatibility

Check for updates in `Dashboard > Updates`

## Uninstallation

To completely remove the theme:

1. Switch to a different theme in `Appearance > Themes`
2. Delete Nony Portfolio theme
3. Deactivate NonyLabs Companion plugin
4. Delete NonyLabs Companion plugin
5. (Optional) Clean up database options if desired

**Note:** Deactivating the plugin will not delete your settings. They will be preserved if you reactivate it later.
