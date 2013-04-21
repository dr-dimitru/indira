###Indira CMS

CMS take the best of idea from Adminizer CMS and creative development from Laravel.
And again we're happy to introduce the most easily customizable CMS in the world - Indira (http://indira-cms.com)

--

Indira CMS - Same idea as in Adminizer CMS, but in new interpretation: Laravel, Bootstrap, Font Awesome

Part of Veliov Group project - http://veliovgroup.com

--

## Quick insallation guide

####Download sources
 - Go to GitHub
 - Download source code from master branch


####Setting up your Application
 - Go to downloaded folder from GitHub (indira-master)
 - Than find `application.php` in `application/config/`
 - Open the application.php in in text-editor or in any code-editor, for example: Notepad++ (Win), Sublime 2 (All platforms)
 - Find the line with  `'url' => 'http://yourdomain.com'` and replace value to your domain url with http:// and without trailing slash!
 - Optionally you may edit:
  - name - The name of your application (Will be used in emails and title tag)
  - site_email - Admin's email
  - no-reply_email - The email from which will be used for sending email's to users
  - google_analytics - Set to track visitors via Google Analytics (XX-00000000-00)
  - meta_tags - Default meta tags of your site (Recommended)
  - meta_creator - Creator's (owner) name
  - key - Secret application key. It's extremely important that you change the application key option before working on your site. This key is used throughout the framework for encryption, hashing, etc.
  - All other setting may be set up in accordance with Laravel's documentation 


####Upload to server

To upload downloaded and edited files you may use build-in functionality of yours hosting-provider, something like "file management" or "FTP-management" or application which will provide direct access to your FTP-server, for example Forklift or Filezilla.

 - Connect to your FTP-server using url, login and password issued by your hosting provider
 - Go to root-folder of server, root-folder will sounds like www , home , home/username , html or http | Attention! Name of root-folder depends from server and hosting settings
 - Drag'n'Drop, copy&past or upload all downloaded and files from GitHub


####Setting up the server side

After uploading all files into your server you need to change rights to public/upload & storage folders you need to make them writable.
 - Go to your server root folder
 - Find there /public/upload & /storage folders
 - Change permissions to 777 and apply this to All included items

More info: http://laravel.com/docs/install#basic-configuration

Also you need to make /public folder as root for your HTTP server, for example (Apache):


```
<VirtualHost *:80>
    DocumentRoot /Users/JonSnow/Sites/MySite/public
    ServerName mysite.dev
</VirtualHost>
```


More info: http://laravel.com/docs/install#server-configuration

If you have no idea or no possibility to edit server's settings (for example at shared hosting) - the .htaccess in root folder will do all work for you.

If you will expect anu issues with routing to /public at first try to remove .htaccess from root folder


####First login /admin

After most of work is done, let's login into admin side go to yourdomain.com/admin:
 - The default username / password is - admin / admin
 - After first login let's change the password - click on "admin" on toolbar -> Admin tools -> Admins
 - Change name (Optionally)
 - Insert new password
 - Insert your email (Will be used to recover password)
 - Click on save button
 - Now logout - "admin" on toolbar -> Logout
 - And try to login with new credentials


######All done !
