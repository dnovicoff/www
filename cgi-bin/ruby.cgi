#!/usr/bin/ruby

require 'cgi'
cgi = CGI.new

puts cgi.header

puts <<EOS
	<html><body>
		Hello World<br />
		This is my first ruby cgi page<br />
		It's the shizzzzzle<br />
		New stuff<br />
	</body></html>
EOS
