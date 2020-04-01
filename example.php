<?php

include "src/SitemapGenerator.php";

// Setting the document root and the output path relative to it
// robots.txt will always be created at the document root (if needed)
// sitemaps are saved in the output directory
// by default all files are written to the path defined as $rootPath
$rootPath = $_SERVER['DOCUMENT_ROOT'] . 'github/';
// relative to script location. sitemaps will be created there by default
$outputDir = '';

$generator = new \Icamys\SitemapGenerator\SitemapGenerator('https://www.example.com', $outputDir);

// will create also compressed (gzipped) sitemap
$generator->toggleGZipFileCreation();

// determine how many urls should be put into one file;
// this feature is useful in case if you have too large urls
// and your sitemap is out of allowed size (50Mb)
// according to the standard protocol 50000 is maximum value (see http://www.sitemaps.org/protocol.html)
$generator->setMaxURLsPerSitemap(50000);

// sitemap file name
$generator->setSitemapFileName("sitemap.xml");

// sitemap index file name
$generator->setSitemapIndexFileName("sitemap-index.xml");

// alternate languages
$alternates = [
    ['hreflang' => 'de', 'href' => "http://www.example.com/de"],
    ['hreflang' => 'fr', 'href' => "http://www.example.com/fr"],
];

// adding url `loc`, `lastmodified`, `changefreq`, `priority`, `alternates`
$generator->addURL('/url/path/', new DateTime(), 'always', 0.5, $alternates);

// generate internally a sitemap
$generator->createSitemap();

// write early generated sitemap to file(s)
$generator->writeSitemap();

// update robots.txt file in output directory or create a new one
$generator->updateRobots($rootPath);

// submit your sitemaps to Google, Yahoo, Bing and Ask.com
// optional: provide Yahoo AppID to avoid hitting limits when reporting sitemap to Yahoo
$generator->submitSitemap($yahooAppID = '');