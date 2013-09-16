<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damian
 * Date: 04.09.13
 * Time: 11:16
 * To change this template use File | Settings | File Templates.
 */

class ArticleList extends SitemapFeed {

    const  TIMECONSTANT = 2000000; // 2 days
    const TIMECONSTANT2 = 600000000; //0,5 year
    public function __construct()
    {
        parent::__construct();

    }

    public function getWikiData($limit,$offset)
    {


      //$limit = 10;
      //$offset = 0;
      //$this->app->wf->GetDB(DB_SLAVE, array());

          $time = wfTimestamp(TS_MW) - self::TIMECONSTANT;

       $connection = wfGetDB(DB_SLAVE,array());
       $result = $connection->select(
           array('page'),
           array('page_id,page_title','page_touched'),
           array('page_namespace'=>500,
           "page_touched > " .$time
           ),
           'DatabaseBase::select',
           array('LIMIT' => $limit, 'OFFSET' =>$offset)
           );


       // $tab = array();

        //$i =0;

        //foreach($result as $r)
        //{
          // $article = new ArticleService($r->page_id);
           //$snippet = $article->getTextSnippet(100);

           //$tab[$i]['id'] =  $r->page_id;
           //$tab[$i]['title'] = $r->page_title;

          // $tab[$i]['snippet'] = $snippet;
          // $i++;

//        }

       return $result;

    }

    public function outItem( $item ) {
        if ( !( $item instanceof BlogNewsItem ) ) {
            throw new MWException( 'Requires a FeedItem or subclass.' );
        }

        wfProfileIn( __METHOD__ );
       // if ( !( $item instanceof BlogNewsItem ) ) {
          //  $item = BlogNewsItem::newFromFeedItem( $item );
        //}

        $this->writer->startElement( 'url' );

        $this->writer->startElement( 'loc' );
        $this->writer->text( $item->getUrl() );
        $this->writer->endElement();

        $this->writer->startElement( 'news:news' );

        $this->writer->startElement( 'news:publication_date' );
        $this->writer->text( wfTimestamp( TS_ISO_8601, $item->getDate() ) );
        $this->writer->endElement();

        $this->writer->startElement( 'news:title' );
        $this->writer->text( $item->getTitle() );
        $this->writer->endElement();

        $this->writer->startElement( 'news:publication' );
        $this->writer->startElement( 'news:name' );
        $this->writer->text( $this->publicationName );
        $this->writer->endElement();
        $this->writer->startElement( 'news:language' );
        $this->writer->text( $this->publicationLang );
        $this->writer->endElement();
        $this->writer->endElement();

        if ( $item->getAccess() ) {
            $this->writer->startElement( 'news:access' );
            $this->writer->text( $item->getAccess() );
            $this->writer->endElement();
        }


        if ( $item->getAccess() ) {
            $this->writer->startElement( 'news:genres' );
            $this->writer->text( $item->getGenres() );
            $this->writer->endElement();
        }

        if ( $item->getStockTickers() ) {
            $this->writer->startElement( 'news:StockTickets' );
            $this->writer->text( $item->getStockTickers() );
            $this->writer->endElement();
        }

        if ( $item->getKeywords() ) {
            $this->writer->startElement( 'news:keywords' );
            $this->writer->text( $item->getKeywords() );
            $this->writer->endElement();
        }

        $this->writer->endElement(); // end news:news

        $this->writer->endElement(); // end url
        wfProfileOut( __METHOD__ );
    }
}