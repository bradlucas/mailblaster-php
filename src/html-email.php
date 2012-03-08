<?php
error_reporting(E_ALL);
include('Mail.php');
include('Mail/mime.php');

// TODO
// title replace in html using the subject
// image on command line as -i

// -b bcc
// -d delay_in_seconds
// -f from_address
// -s subject
// -e member_list.csv
// -h html_mail.html
// -t text_mail.txt
// -u unsubscribe.csv
// -i image.png

$arguments = getopt("b:d:f:s:e:h:t:u:i:");

if (isset($arguments['b'])) {
  $bcc = $arguments['b'];
}
$delay = $arguments['d'];
$from = $arguments['f'];
$subject = $arguments['s'];
$member_list = $arguments['e'];
$html_file = $arguments['h'];
$text_file = $arguments['t'];
$unsubscribe_list = $arguments['u'];
$image= $arguments['i'];

print $bcc."\n";
print $delay."\n";
print $from."\n";
print $subject."\n";
print $member_list."\n";
print $html_file."\n";
print $text_file."\n";
print $unsubscribe_list."\n";
print $image."\n";

// load addresses
$to_addresses = array();
$file = fopen($member_list, 'r');
while (($line = fgetcsv($file)) != FALSE) {
      $to_addresses[] = $line[0];
}
fclose($file);
print "To address count: " . count($to_addresses) . "\n";

// load unsubscribe addresses
$dont_send = array();
$file = fopen($unsubscribe_list, 'r');
while (($line = fgetcsv($file)) != FALSE) {
      $dont_send[] = $line[0];
}
fclose($file);

if ($dont_send && count($dont_send)>0) {
   print "Dont send count: " . count($dont_send) . "\n";
} else {
  print "No dont sends";
}

// remove unsubscribes from to_address
$to_addresses = array_diff($to_addresses, $dont_send);
print "Reduced to list count " . count($to_addresses)."\n\n";;
// foreach ($to_addresses as $t) {
//         print $t."\n";
// }

$crlf = "\n";

// load text from file
$text = file_get_contents($text_file);

// load html from file
$html = file_get_contents($html_file);
// replace title with subject
$html = preg_replace("/%TITLE%/", $subject, $html);

$hdrs = array(
	      'From' => $from,
	      'Subject' => $subject
	      );

$mime = new Mail_mime($crlf);

$mime->setTXTBody($text);

// get mime type from file
$mime->addHTMLImage($image, 'image/png', '1', true);

$mime->setHTMLBody($html);

$body = $mime->get();
$hdrs = $mime->headers($hdrs);

$mail = Mail::factory('mail');

print "Running...\n";
$cnt = 0;
foreach ($to_addresses as $to) {
	if ($to && strlen($to) > 0) {
	$recipients = array( 'To' => $to);
	$succ = $mail->send($recipients, $hdrs, $body);
	if (PEAR::isError($succ)) {
	    echo 'Error Sending HTML message to ' . $to . ' ' . $succ->getMessage() . "\n";
	} else {
	    echo 'Sending HTML message to ' . $to . "\n";
        }
	$cnt += 1;
	sleep($delay);
	}
}
print "Sent " . $cnt . " emails\n";

?>
