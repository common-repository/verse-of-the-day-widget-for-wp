=== Verse of the Day Widget for WP ===
Contributors: alfloyd  
Tags: bible verse, daily verse, widget, multilingual, translated verses  
Requires at least: 6.6  
Tested up to: 6.6.2
Stable Tag: 7.3.09  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

The Verse of the Day Widget displays a Bible verse under an AI-generated WebP image with ChatGPT multilingual translations in 100+ languages.

== Description ==

The **Verse of the Day Widget for WP** plugin delivers daily Bible verses below stunning nature backgrounds, providing both spiritual inspiration and visual beauty. Each day, a verse from the King James Version (KJV) is randomly selected and displayed below an AI-generated nature scene in Google’s WebP format. Now, with **ChatGPT-powered language translation**, you can offer these verses in over 100 languages to cater to your global audience.

Watch the **YouTube demo** to learn more about how this widget works and its features: [Watch the demo here](https://youtu.be/xMVAqWzbCCo)

**Key Features:**

- **Daily Bible Verses:** Automatically updates daily with a randomly selected Bible verse from the KJV.
- **Multilingual Support:** Powered by ChatGPT, the widget now offers Bible verses in over 100 languages, ensuring accessibility for users around the world.
- **Beautiful Nature Photos:** Each verse is displayed below a high-quality, AI-generated nature image, providing a visually appealing experience.
- **Shortcode Support:** Easily add the widget to any post or page using the shortcode `[votd_verse_of_the_day_widget_for_wp]`.
- **Widget Customization:** Fully customizable under the "Widgets" section in the WordPress **Appearance** tab.
- **Flexible Placement:** Add the widget to sidebars, headers, or posts for seamless integration with your website’s layout.
- **Optimized Image Format:** All images are displayed in the efficient WebP format for faster loading times and reduced file sizes.

== Installation ==

1. **Download the Plugin:** Upload the plugin files to the `/wp-content/plugins/verse-of-the-day-widget-for-wp` directory, or install the plugin directly through the WordPress plugin screen by searching for **Verse of the Day Widget for WP**.
2. **Activate the Plugin:** Go to the 'Plugins' screen in WordPress and activate the plugin.
3. **Configure the Widget:** Navigate to the "Appearance" tab under "Widgets" in the WordPress admin menu. Add the widget to your sidebar, header, or other available widget areas.
4. **Use the Shortcode:** Optionally, you can also add the widget to a post or page using the shortcode `[votd_verse_of_the_day_widget_for_wp]`.

== Frequently Asked Questions ==

*How do I display the widget?*  
Use the shortcode `[votd_verse_of_the_day_widget_for_wp]` in any post or page, or add the widget through the WordPress Appearance menu.

*Can I display the widget in multiple languages?*  
Yes! With ChatGPT-powered translation, you can display the daily verse in over 100 languages. Simply select your preferred language in the widget’s settings.

*Is the plugin compatible with all themes?*  
The plugin is designed to work with most WordPress themes. If you experience any issues, feel free to contact us at allenfloyd@freesmartphoneapps.com.

== Screenshots ==

1. Mobile view of the widget in the left and right sidebars.
2. Mobile view of the widget in the left and right sidebars with the preferred language being set to Spanish.
3. Desktop view of the widget in the header area.  
4. Desktop view of the widget being Embedded into an HTML page using the shortcode `[votd_verse_of_the_day_widget_for_wp]`.
5. Mobile view of the widget being Embedded into an HTML page using the shortcode `[votd_verse_of_the_day_widget_for_wp]`.
6. Settings page in the WordPress admin panel.

== Changelog ==
= 7.3.05 =  
* **New Feature**: Added a YouTube demo video showcasing the widget's key features. Watch the demo in the plugin description.

= 7.3.01 =
* **Fixed**: Language translations were not functioning as expected. The issue has been resolved.

= 7.2 =
* **Improved Widget Placement** The widget now features two distinct designs: one optimized for left and right sidebars, and another tailored for the header area. 

= 7.1.18 =
* **Bug Fix** – Resolved an issue that temporarily caused the widget to become unavailable. The error was introduced by a recent update to the Verse of the Day Widget for WP API. The root cause has been identified and addressed, ensuring the widget functions as expected. 

= 7.1.03 =
* **Bug Fix** – The Verse of the Day Widget for WP was not functioning on WordPress sites that were not specified in the `CORS_ALLOWED_ORIGINS` setting. This issue has been resolved, and the plugin should now work correctly on all WordPress sites.

= 7.1.02 =
* **Bug Fix** - CORS_ALLOW_ALL_ORIGINS wasn't set to True so the Verse of the Day Widget for WP API could only be fetched from sites that were specified in the CORS_ALLOWED_ORIGINS

= 7.1 =  
* Added ChatGPT-powered language translation for over 100 languages.  

== Third-Party Service ==

This plugin uses two third-party services to function:
**Verse of the Day Widget for WP API**
- This API fetches random Bible verses from the King James Version (KJV) for display.
- **Personal Data**: The API does not collect or store any personal data.
- **Access**: The API is accessed at:
  - [https://www.freesmartphoneapps.com/verseoftheday/api/verse](https://www.freesmartphoneapps.com/verseoftheday/api/verse)  
  - [https://www.freesmartphoneapps.com/verseoftheday/api/translate-verse](https://www.freesmartphoneapps.com/verseoftheday/api/translate-verse)
- **Privacy Policy**: Refer to the API's privacy policy here: [https://freesmartphoneapps.com/privacy-policy-votd/](https://freesmartphoneapps.com/privacy-policy-votd/).

**OpenAI API**
- This API is used to translate the Bible verses into over 100 languages, ensuring a multilingual experience.
- **Personal Data**: The API does not collect or store any personal data.
- **Access**: The API is accessed at [https://api.openai.com/v1](https://api.openai.com/v1).
- **Privacy Policy**: Refer to OpenAI's privacy policy here: [https://openai.com/privacy](https://openai.com/privacy).