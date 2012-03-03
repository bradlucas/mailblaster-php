# mailblaster-php
=================

Project to send Html mail using PHP. See `html-email.php` in the src directory.


### Usage

Copy the example directory to one of your choosing. Edit the following files.

- html_mail.html is the email template. As is it will use the image.png file as it's sole content save for a brief message at the bottom. Edit the href (currently http://foo.com) so users can click back to your server. Also in the footer you might include a mailto link for unsubscribing.g

- member_list.csv is the file you should put all of your emails in. Each should be on it's own line.

- unsubscribe.csv is optional. If included it is for putting emails that you don't want to sent to. In some situations it is easier to maintain two lists the current active list and those who don't want to receive mail.

- text_mail.txt is the email message in text format that will be displayed for users not viewing their mail as html.

- image.png is the email messages image.

- cmd.sh is the script to launch the script. Note that you'll want to edit the email address and subject lines.


## License

Distributed under the Eclipse Public License
