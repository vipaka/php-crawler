Minimalist PHP Crawler

Please note, this crawler is meant only as a proof of concept, and will only run on the initial set of links provided instead of looping through them indefinitely. It is not currently connected to any storage utility (JSON, DB or otherwise) so there is no clean way of keeping track of the links it picks up. To use this crawler in any capacity would require some mechanism of storing the data it obtains, and likely additional functions for handling specific data being crawled seeing as finding a giant list of links is something many spiders already do. 

I am working on creating separate crawlers that do exactly that and create datasets from the useful data found, but this repository is meant simply to store the vanilla version of the crawler for posterity.  

The URLs used in this example are popular public link directories. 

To use, simply add this file to a server (local or live) and visit the URL to the file. Modify the $urls variable, and the $time_limit variable as required. 