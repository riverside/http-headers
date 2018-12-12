# HTTP Headers

A WordPress plugin that allows you to easily control HTTP response headers of your website.

Donate link: https://zinoui.com/donation

Requires at least: 3.2

Tested up to: 5.0

Stable tag: 1.11.0

License: GPLv2 or later

## Description

HTTP Headers gives your control over the http headers returned by your blog or website.

Headers supported by HTTP Headers includes:

* Access-Control-Allow-Origin
* Access-Control-Allow-Credentials
* Access-Control-Max-Age
* Access-Control-Allow-Methods
* Access-Control-Allow-Headers
* Access-Control-Expose-Headers
* Age 
* Content-Security-Policy
* Content-Security-Policy-Report-Only
* Cache-Control
* Clear-Site-Data
* Connection
* Content-Encoding
* Expect-CT
* Expires
* Feature-Policy
* Pragma
* Public-Key-Pins
* Public-Key-Pins-Report-Only
* P3P
* Referrer-Policy
* Report-To
* Strict-Transport-Security
* Timing-Allow-Origin
* Vary
* WWW-Authenticate
* X-Content-Type-Options
* X-DNS-Prefetch-Control
* X-Download-Options
* X-Frame-Options
* X-Permitted-Cross-Domain-Policies
* X-Powered-By
* X-UA-Compatible
* X-XSS-Protection

The [getting started tutorial](https://zinoui.com/blog/http-headers-for-wordpress) describes a typical configuration of this plugin.

## Installation

Upload the HTTP Headers plugin to your blog. Then activate it.

That's all.

## Frequently Asked Questions

### Why to use this plugin?

Nowadays security of your social data at the web is essential. This plugin helps you to improve your website overall security. 

### Who use these headers?

These HTTP headers are being used in production services by popular websites as Facebook, Google+, Twitter, LinkedIn, YouTube, Yahoo, Amazon, Instagram, Pinterest.

## Upgrade Notice

Updates are on they way, so stay tuned at [@DimitarIvanov](https://twitter.com/DimitarIvanov)

## Changelog

#### 1.11.0
*Release Date - 9th December, 2018*

* Added support of "Clear-Site-Data" header

#### 1.10.5
*Release Date - 6th November, 2018*

* Hotfix: parallel work with third-party plugins

#### 1.10.4
*Release Date - 30th September, 2018*

* Support of following Server APIs: CGI, FastCGI, PHP-FPM
* Error handling improvement

#### 1.10.3
*Release Date - 8th August, 2018*

* HSTS improvement
* CORS improvement

#### 1.10.2
*Release Date - 31st July, 2018*

* Export feature bug-fixed

#### 1.10.1
*Release Date - 18th July, 2018*

* Feature-Policy header update: new features added

#### 1.10.0
*Release Date - 17th July, 2018*

* Added support of "Feature-Policy" header

#### 1.9.5
*Release Date - 12th July, 2018*

* CORS bugfix

#### 1.9.4
*Release Date - 13th January, 2018*

* In-plugin security improvement

#### 1.9.3
*Release Date - 10th January, 2018*

* Bug fix

#### 1.9.2
*Release Date - 4th January, 2018*

* Security improvements

#### 1.9.1
*Release Date - 27th December, 2017*

* Updated translations

#### 1.9.0
*Release Date - 23th December, 2017*

* Added support of "Report-To" header
* Added support of translations
* Added support of Import/Export
* Updated "Content-Security-Policy" header (added directives: object-src, frame-src, worker-src, manifest-src, base-uri, report-to)
* Updated "WWW-Authenticate" header (support multiple users)
* Updated "Access-Control" headers (added list of origins)

#### 1.8.0
*Release Date - 31st August, 2017*

* Added support of "Timing-Allow-Origin" header
* Added support of "X-Download-Options" header
* Added support of "X-DNS-Prefetch-Control" header
* Added support of "X-Permitted-Cross-Domain-Policies" header
* Added support of Custom headers

#### 1.7.1
*Release Date - 18th August, 2017*

* PHP notice bugfixed

#### 1.7.0
*Release Date - 15th August, 2017*

* Added support of "Content-Security-Policy-Report-Only" header
* Added support of "Public-Key-Pins-Report-Only" header
* Added "1; report=<reporting-URI>" directive to the "X-XSS-Protection" header
* Added "Inspect headers" tool
* UI bugfixes

#### 1.6.0
*Release Date - 5th August, 2017*

* Added support of "Expect-CT" header

#### 1.5.0
*Release Date - 30th July, 2017*

* Added support of "Age" header 
* Added support of "Cache-Control" header
* Added support of "Connection" header
* Added support of "Content-Encoding" header
* Added support of "Expires" header
* Added support of "Pragma" header
* Added support of "Vary" header
* Added support of "WWW-Authenticate" header
* Added support of "X-Powered-By" header
* Added support of "Secure" and "HttpOnly" cookies

#### 1.4.0
*Release Date - 5th July, 2017*

* Added support of Apache (via htaccess) inclusion method

#### 1.3.0
*Release Date - 3rd June, 2017*

* Added support of Content-Security-Policy header
* Added dashboard

#### 1.2.0
*Release Date - 28th April, 2017*

* Added support of Referrer-Policy header

#### 1.1.2
*Release Date - 13th February, 2017*

* Added support of 'preload' directive to HSTS header

#### 1.1.1
*Release Date - 8th November, 2016*

* Fixed typo in the X-Frame-Options header

#### 1.1.0
*Release Date - 20th May, 2016*

* Added support of P3P header

#### 1.0.0
*Release Date - 10th May, 2016*

* Initial version
