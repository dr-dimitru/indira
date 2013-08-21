###Indira CMS

CMS take the best of idea from Adminizer CMS and creative development from Laravel.
And again we're happy to introduce the most easily customizable CMS in the world - Indira (http://indira-cms.com)

--

Indira CMS - Same idea as in Adminizer CMS, but in new interpretation: Laravel, Bootstrap, Font Awesome

Part of Veliov Group project - http://veliovgroup.com

--

## Quick insallation guide

###Requirements (Laravel)

 - Apache, nginx, or another compatible web server.
 - Laravel takes advantage of the powerful features that have become available in PHP 5.3. Consequently, PHP 5.3 is a requirement.
 - Laravel uses the FileInfo library to detect files' mime-types. This is included by default with PHP 5.3. However, Windows users may need to add a line to their php.ini file before the Fileinfo module is enabled. For more information check out the installation / configuration details on PHP.net.
 - Laravel uses the Mcrypt library for encryption and hash generation. Mcrypt typically comes pre-installed. If you can't find Mcrypt in the output of phpinfo() then check the vendor site of your LAMP installation or check out the installation / configuration details on PHP.net.

Find out more in [Laravel's official website](http://laravel.com/docs/install).
Or at unofficial [Laravel 3 docs](http://laravel3.veliovgroup.com/docs/install).

After you meet all Laravel's requirements, please proceed to next step:

--

####Download sources
 - Go to GitHub
 - Download source code from master branch

--

####Upload to server

To upload downloaded and edited files you may use build-in functionality of yours hosting-provider, something like "file management" or "FTP-management" or application which will provide direct access to your FTP-server, for example Forklift or Filezilla.

 - Connect to your FTP-server using url, login and password issued by your hosting provider
 - Go to root-folder of server, root-folder will sounds like www , home , home/username , html or http | Attention! Name of root-folder depends from server and hosting settings
 - Drag'n'Drop, copy&past or upload all downloaded and files from GitHub

--

####Setting up the server side

After uploading all files into your server you need to change rights to public/upload & storage folders you need to make them writable.
 - Go to your server root folder
 - Find there `/public/upload`, `/storage` and `applications/models` folders
 - Change permissions to 777 and apply this to All included items

More info: http://laravel3.veliovgroup.com/docs/install#basic-configuration

Also you need to make /public folder as root for your HTTP server, for example (Apache):


```
<VirtualHost *:80>
    DocumentRoot /Users/JonSnow/Sites/MySite/public
    ServerName mysite.dev
</VirtualHost>
```


More info: http://laravel3.veliovgroup.com/docs/install#server-configuration

If you have no idea or no possibility to edit server's settings (for example at shared hosting) - the .htaccess in root folder will do all work for you.

If you will expect any issues with routing to /public at first try to remove .htaccess from root folder

--

####Setting up Application Key
Secret application key. It's extremely important that you change the application key option before working on your site. This key is used throughout the framework for encryption, hashing, etc.

Method #1:
 - Go to downloaded folder from GitHub (indira-master)
 - Then find application.php in application/config/
 - Open the application.php in in text-editor or in any code-editor, for example: Notepad++ (Win), Sublime 2 (All platforms)
 - Find the line 'key' => '' and place value about 32 characters of random gibberish

Method #2:
 - Login to Admin Side (yourdomain.com/admin)
 - Then go to Settings (Wrench icon) -> CLI (yourdomain.com/admin/cli)
 - Type key:generate 32 (32 - is recommended and max length of key)
 - !Note: you may meet permissions issue with writable file (/application/config/application.php)

--

####First login /admin

After most of work is done, let's login into admin side go to yourdomain.com/admin:
 - The default username / password is - admin / admin
 - After first login let's change the password - click on "admins" on Settings (Wrench icon) ->  Admins
 - Change name (Optionally)
 - Insert new password
 - Insert your email (Will be used to recover password)
 - Click on save button
 - Now logout - "admin" on User Icon -> Logout
 - And login with new credentials

--

####Setting up your Application
 - Go to Admin side - yourdomain.com/admin
 - Then, if you're not logged in yet - login as admin with maximum rights (777)
 - Next - click on settings (wrench icon in top bar) -> Main Settings:
  - You will see few options to edit, all options started with "Laravel:" is controlling Laravel's behaviors like profiler, or database connection settings
  - Click on "Application: Indira":
   - Edit "Name" (Name of your project)
   - Edit email section and email addresses:
    - The Email's SMTP options is optional - fill it to send emails via SMTP
    - SMTP Host, Username, Password and port you may get even from GMail!
 - Click on "Laravel: Application":
  - Here you may edit very main options like "Language" or "Timezone"
  - Find the "URL" (Application URL) and paste into "http://yourdomain.com" with http:// and without trailing slash!
  - Optionally you may edit Template Settings (Wrench icon -> Template):
   - Icon, Shortcut icon and Apple sturtup image - Icons, Logos Splash screens of your web-application
   - Meta - Meta-data or meta-tags - It's really to important to update these values
   - Disqus - Disqus shortname - this option used to activate comments in default template
   - Google_analytics - Set to track visitors via Google Analytics (XX-00000000-00)
   - Logo - Default Logo in default templates. You may use html-tags or image as a logo of your app (Recommended)


######All done !
