#!/usr/bin/perl -wT


use CGI qw(:standard);
## use CGI::Carp qw(warningsToBrowser fatalsToBrowser);
use strict;
use DBI;


my %formVariables;
foreach my $p (param())  {
	$formVariables{$p} = param($p);
}

$ENV{PATH} = "/usr/sbin";
my $sendmail = "/usr/sbin/sendmail -t";
open (MAIL, "|/usr/sbin/sendmail -t") or 
	&dienice("Can't fork for sendmail: $!\n");

my $recipient = 'dnovicoff@yahoo.com';

print MAIL "From: admin\n";
print MAIL "To: $recipient\n";
print MAIL "Subject: Contact Form\n\n";
print MAIL "Content-type: text/plain\n\n";

print MAIL "Cantact information contained herein\n\n";
foreach my $p (param())  {
	print MAIL "$p = " . param($p) . "\n";
	print STDERR "$p = " . param($p) . "\n";
}

close(MAIL);

print header('text/html');
print <<EndHTML;
	<html>
		<head>
			<META HTTP-EQUIV="Refresh" CONTENT="10;/upland-homeinc/">
			<title>thank you</title>
		</head>
		<body>
			Thank you for your information<br />
			Someone will be in contact shortly<br /><br />	
			This page will redirect to Upland-homeinc in 10 seconds<br />
			If you like, you can click <a href="192.168.1.4/upland-homeinc/">Here</a><br />
		</body>
	</html>
EndHTML

sub dienice  {
	exit;
}
