Fearless Tattoo Removal - static HTML version
=============================================

Upload the CONTENTS of this folder (including the hidden .htaccess file) to the web root of
www.fearlesstattooremoval.com, or to any subfolder for a staging preview. All links are relative.

Pages (all 17, same URLs as the live site)
  /  /about/  /services/  /services/cosmetic-tattoo-removal/  /full-body-tattoo-removal/
  /permanent-makeup-removal/  /how-it-works/  /pricing/  /secondchances/  /contact/ (Book With Us)
  /thank-you/  /blog/  /site-map/  /privacy-policy/  /mission-statement/  /inclusion-statement/
  /giveaway/fearless-tattoo-removal-second-chances-program-giveaway/  (ended giveaway page)
Found from the sitemap, a full link crawl and WordPress's own list of pages. The site has no
blog posts. Addresses without the trailing slash (e.g. /privacy-policy) open the same pages.

Forms
-----
Both forms post to send.php (needs PHP) and email fearlessremoval@gmail.com
(change $to in send.php to use another address):
- Booking form on /contact/: name, phone, email, message. On success the visitor goes to the
  Thank You page, as on the live site.
- Newsletter email signup in the footer of every page: shows a confirmation after signing up.
Spam protection: a hidden honeypot field plus WPForms' own hidden trap field.

Removed
-------
- Jetpack visitor-stats tracking (it only works on WordPress).

Noindex (staging)
-----------------
Every page has <meta name="robots" content="noindex, nofollow" /> and .htaccess sends an
X-Robots-Tag: noindex, nofollow header, so search engines will not index this copy.
BEFORE GOING LIVE on the real domain: remove that meta line from each page and delete the
"BEGIN noindex ... END noindex" block from .htaccess, or the site will drop out of Google.
