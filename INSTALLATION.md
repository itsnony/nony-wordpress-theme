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

### 2. Install Companion Plugin

After activating the theme, you'll see a notice to install required plugins:

1. Click `Install Required Plugins` in the admin notice
2. Click `Install` next to "Nony Portfolio Companion"
3. After installation, click `Activate`

**Manual Installation:**
1. Go to `Appearance > Install Plugins`
2. Follow the installation wizard

### 3. Configure Your Portfolio

#### General Settings
1. Go to `Portfolio > General Settings`
2. Set your navigation logo text
3. Configure footer brand text and tagline
4. Set copyright text
5. Click `Save Changes`

#### Profile Badges
1. Go to `Portfolio > Profile Badges`
2. Edit existing badges or add new ones
3. Use emojis and text (e.g., "16 y/o", "🇩🇪 Germany")
4. Preview your changes in real-time
5. Click `Save Changes`

#### Social Links
1. Go to `Portfolio > Social Links`
2. Add your social media profiles
3. Set platform name, URL, username/text, and icon class
4. Find icon classes at [remixicon.com](https://remixicon.com/)
5. Click `Save Changes`

### 4. Create Navigation Menus

1. Go to `Appearance > Menus`
2. Create a new menu (e.g., "Main Menu")
3. Add pages/links to your menu
4. Assign to "Primary Menu" location
5. Optionally create a footer menu and assign to "Footer Menu"

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

### Custom Patterns
Edit files in `/patterns/` to create reusable content blocks.

### Styling
All CSS is in `style.css`. The theme uses:
- Glassmorphism effects
- CSS animations
- Responsive design
- Custom properties

## Troubleshooting

### Plugin Not Installing
- Check file permissions on `/wp-content/plugins/`
- Manually upload the plugin from `/plugins/nony-portfolio-companion/`
- Ensure you have admin privileges

### Navigation Not Showing
- Make sure you've created a menu in `Appearance > Menus`
- Assign the menu to "Primary Menu" location
- Check that the companion plugin is activated

### Badges/Social Links Not Appearing
- Ensure the companion plugin is activated
- Check that you've saved your settings
- Clear your browser cache

### Styling Issues
- Clear WordPress cache
- Clear browser cache
- Check that your browser supports CSS backdrop-filter

## Support

For issues or questions:
- Check the FAQ in README.txt
- Review the documentation
- Contact theme support

## Updates

Keep your theme and plugin updated for:
- Security patches
- New features
- Bug fixes
- WordPress compatibility

Check for updates in `Dashboard > Updates`
