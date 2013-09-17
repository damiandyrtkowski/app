<?php

class NewsSiteMap {

const  TIMECONSTANT = 2000000; // 2 days
const TIMECONSTANT2 = 600000000; //0,5 year

const limit = 20;
private $writer;
private $sitemap;

public function __construct() {

}

public function GetData()
{
$time = wfTimestamp(TS_MW) - self::TIMECONSTANT2;

$connection = wfGetDB(DB_SLAVE,array());
$result = $connection->select(
array('page'),
array('page_id,page_title','page_touched'),
array('page_namespace'=>500,
"page_touched > " .$time
),
'DatabaseBase::select'
);

return $result;
}



public function GenerateXml($data)
{
global $wgSitename, $wgLanguageCode;

$out  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $out .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n";
        $out .=  "xmlns:news=\"http://www.google.com/schemas/sitemap-news/0.9\">\n";

        foreach($data as $d)
        {
            $t = Title::newFromID($d->page_id);
            $item = new BlogNewsItem($t,$d->page_touched,array("aaa","bbb","ccc"));

            $loc = $item->getUrl();
            $publication = $item->getDate();
            $title = $item->getTitle();
            $name = $wgSitename;
            $lang = $wgLanguageCode;
            $keywords = $item->getKeywords();
            $date = wfTimestamp( TS_ISO_8601, $item->getDate() );
            $access = $item->getAccess();
            $genres = $item->getGenres();
            $stock  = $item->getStockTickers();

            $out .= "<url>\n";
            $out .= "<loc>$loc</loc>\n";
            $out .= "<news:news>\n";
            $out .= "<news:publication>\n";
            $out .= "<news:name>$name</news:name>\n";
            $out .= "<news:language>$lang</news:language>\n";
            $out .= "</news:publication>\n";
            if($access)
            {  $out .= "<news:access> </news:access>\n"; }

            if($genres)
            { $out .= "<news:genres> </news:genres>\n";  }
            $out .= "<news:publication_date> $date </news:publication_date>\n";
            $out .= "<news:title> $title</news:title>\n";
            $out .= "<news:keywords> $keywords </news:keywords>\n";

            if($stock)
            { $out .= "<news:stock_tickers> </news:stock_tickers>\n"; }
            $out .= "</news:news>\n";
            $out .= "</url>\n";

        }

        $out .=  "</urlset>";

        return $out;

    }


}