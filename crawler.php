<?php 
/*================
* Minimalist PHP Crawler
* Copyright Amelia Winstead 2017
* Purpose of this crawler is simply a proof of concept
* for a lightweight PHP crawler which can be easily customized for
* specific usages and performance. Currently set to store all crawled URLs
* into an array which is printed to page upon completion.
 ================*/
class crawler{
	//Basic cURL function to crawl sites, add their html page source to array
	function crawl_urls($urls){
		$contents = array();
		$options = array(
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_HEADER         => false,
	        CURLOPT_FOLLOWLOCATION => true,
	        CURLOPT_ENCODING       => "",
	        CURLOPT_USERAGENT      => "crawlerbot",
	        CURLOPT_AUTOREFERER    => true,
	        CURLOPT_CONNECTTIMEOUT => 600,
	        CURLOPT_TIMEOUT        => 600,
	        CURLOPT_MAXREDIRS      => 5,
	        CURLOPT_SSL_VERIFYHOST => 0,
	        CURLOPT_SSL_VERIFYPEER => false,
	        CURLOPT_VERBOSE        => 1
	    ); 
		foreach ($urls as $url){
		    $c = curl_init($url);
         	curl_setopt_array($c, $options);
		    $content = curl_exec($c);
		    $err     = curl_errno($c);
		    $errmsg  = curl_error($c) ;
		    $header  = curl_getinfo($c);
		    $contents[] = $content;
		    curl_close($c); 
		}
		return $contents;
	}
	//Find the links from within the contents of each URL
	function find_links($contents){
		$time_limit = 30; //Set the maximum time allowed for the html link str match
		set_time_limit($time_limit);
		$links = array();
		$start_pos = 0;
		foreach ($contents as $content){
			$pattern = '/href=["\']?([^"\'>]+)["\']?/';
		    preg_match_all($pattern, $content, $matches);
		    foreach ($matches[1] as $match){
		    	$match = rtrim($match, '"');
		    	if (strpos($match, 'http') !== false){
		    		$links[] = $match; //this will exclude some interior site links.
		    	}
		    }
		}
		return $links;
	}
}
//This will grab the initial set of links for the crawler to use
$urls = array(
	0	=> 'https://viesearch.com/',
	1 	=> 'https://moz.com/top500',
);
$crawler = new Crawler(); //Init crawler obj
$contents = $crawler->crawl_urls($urls); //Get content of those URLs
$links = $crawler->find_links($contents); //Find links within that content
print_r($links); //Print links to page

/* Note, to automatically perpetuate this crawler indefinitely, 
you need to loop the above for a condition of links being true,
and change the start URLs to the returned links each time a new link 
is found, which for the purposes of an effectively written crawler
would likely require DB storage of boolean visited and unvisited links*/
?>