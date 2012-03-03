#!/bin/bash

php -e ../src/html-email.php \
    -d 2 \
    -f foo@foo.com  \
    -s "Mailblaster-php Example"  \
    -h html_mail.html \
    -e member_list.csv \
    -t text_mail.txt \
    -u unsubscribe.csv \
    -i image.png
    | tee log-file.txt  &
