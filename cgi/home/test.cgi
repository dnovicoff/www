#!/usr/bin/perl
use strict;
use warnings;
use POSIX;

my $range = 100;
my $random_number = rand($range);
$random_number = floor($random_number);

print "Content-type: text/xml\n\n";

print <<EndHTML;
<div class="row" style="padding-bottom:2%">
	<div class="row" style="background-color:blue;">
		Hello world <span style=""><b>$random_number</b></span>
	</div>
</div>
EndHTML

