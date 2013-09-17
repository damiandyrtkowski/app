<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damian
 * Date: 13.09.13
 * Time: 14:19
 * To change this template use File | Settings | File Templates.
 */

class BlogNewsItem extends FeedSMItem
{
    private $access;
    private $genres;
    private $stock_tickers;



    public function __construct( $title, $pubDate, $keywords = '', $comment = true, $access = null, $genres = null, $stock_tickers = null )
    {
        parent::__construct($title,$pubDate,$keywords,$comment);

        $this->access = $access;
        $this->genres = $genres;
        $this->stock_tickers = $stock_tickers;
    }

    public function getAccess()
    {

        return $this->access;
    }

    public function getGenres()
    {
        return $this->genres;

    }

    public function getStockTickers()
    {
        return $this->stock_tickers;
    }

}