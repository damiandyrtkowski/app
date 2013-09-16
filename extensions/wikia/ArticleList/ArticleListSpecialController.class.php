<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damian
 * Date: 04.09.13
 * Time: 11:17
 * To change this template use File | Settings | File Templates.
 */

class ArticleListSpecialController extends WikiaSpecialPageController {

    const limit = 20;
    private $writer;
    private $sitemap;

    public function __construct() {


        parent::__construct( 'ArticleList','', false );
        //$this->writer = new XMLWriter();
        }

    public function init() {
       // $this->businessLogic = F::build( 'ArticleList', array( 'currentTitle' => $this->app->wg->Title ) );
    }

    public function index() {

       // $time = "20100809003006";
      //  $tt = wfTimestamp(TS_MW) - wfTimestamp(TS_MW,"20130910000000");
    //var_dump("dasd");
        //die();



        $lista = new ArticleList();
        $data = $lista->getWikiData(100,0);

      //  var_dump($data);
      //  die();
        $sitemap = new ArticleList();
        $sitemap->contentType();
        $sitemap->outHeader();

        foreach($data as $d)
        {
            //var_dump($d->page_id);
            //var_dump($d->page_touched);
            $t = Title::newFromID($d->page_id);

            $item = new BlogNewsItem($t,$d->page_touched,array("aaa","bbb","ccc"));
            $sitemap->outItem($item);

            // $sitemap = new ArticleList();
        }

           $sitemap->outFooter();


        //$sitemap = new SitemapFeed();

       // var_dump($sitemap);

     //   var_dump($s);







       // var_dump($item->getTitle());
       // var_dump($item->getAccess());
       // die();

        /*
        $dbr = wfGetDB( DB_SLAVE );
        if( $dbr->tableExists( 'sitemap_blobs' ) ) {
            $sitemapContent = $dbr->selectField(
                'sitemap_blobs',
                'sbl_content'
            );

            $test = gzdecode($sitemapContent);
            var_dump($test);
        }
*/

        /*
         *
         *

        $dbr = wfGetDB( DB_SLAVE, "vslow" );
        $res = $dbr->select(
            'page',
            array( 'page_namespace' ),
            array(),
            __METHOD__,
            array(
                'GROUP BY' => 'page_namespace',
                'ORDER BY' => 'page_namespace',
            )
        );

        while ( $row = $dbr->fetchObject( $res ) )
        {
            var_dump($row);


        }
        */


        //$title = new Title();
       // $a = new FeedSMItem();

        //$this->sitemap = new SitemapFeed();
        //$this->sitemap->outItem($item);

        /*
        $connection = wfGetDB(DB_SLAVE,array());
        $result = $connection->selectRow(
            array('page'),
            array('page_id,page_title'),
            array('page_namespace'=>0)
        );

       //$a =  $result->page_id;
        //var_dump($a);

        $title = Title::newFromID($result->page_id);
        $time = $title->getEarliestRevTime();
       //  var_dump($title);
        //var_dump($a);

        $item = new FeedSMItem($title,$time,array("aaa","bbb","ccc"),true,"ACCESS","GENRES","TICKERS");



        $sitemap = new SitemapFeed();

        $sitemap->contentType();
        $sitemap->outHeader();
        $sitemap->outItem($item);


        $sitemap->outFooter();
        */
        //var_dump($sitemap);
        //die();

        //var_dump($item);

       // $sitemap = new SitemapFeed();

       // var_dump($item->getTitle());
       // die();


      //$xml = new SimpleXMLElement('')

       // $xml = new SimpleXMLElement("<xml>");
       // die();


       //var_dump($xml->asXML());
        //$this->setVal('xml',$xml);
       // $this->response->addAsset('extensions/wikia/ArticleList/js/cookie.js') ;

        // $this->response->addAsset('extensions/wikia/ArticleList/js/ArticleListAjax.js');
      //  $this->response->addAsset('extensions/wikia/ArticleList/css/arkusz.css');


     //   $button_list = array("movie","music","game","others");

       // $data = F::build('ArticleList', array());

       // $offset = $this->request->getVal('offset',0);

        //$params = $request->getParams();

      //  $articles = $data->getWikiData(self::limit,$offset);

        /*
        $t = Title::newFromText("ArticleList",NS_SPECIAL);

        $link = $t->getFullURL("offset=");

        $this->setVal('list',$articles);
        $this->setVal('link', $link);
        $this->setVal('offset',$offset);
        $this->setVal('limit',self::limit);
        $this->setVal('buttons',$button_list);
        */

        /*
        $connection = wfGetDB(DB_SLAVE,array());
        $result = $connection->select(
            array('page'),
            array('page_id,page_title'),
            array('page_namespace'=>0)
        );

        //var_dump($result); die;

        $tab = array();

        foreach($result as $r)
        {
         $tab['id'][] =  $r->page_id;
         $tab['title'][] = $r->page_title;
        }
        */


        //var_dump($tab); die ();


        //$app = F::app();
        //$list = $app->sendRequest( 'ArticlesApiController', 'getList', [ 'namespaces' => 0, 'limit'=> 100, 'expand' => 1 ] )->getData();

        //var_dump($list['items'][0]['id']); die();
        //var_dump($list); die();

        //$this->setVal('list', $list );

        //$this->wg->Out->setPageTitle(wfMessage( 'helloworld-specialpage-title' ) );

        //$wikiId = $this->getVal( 'wikiId', $this->wg->CityId );
        // setting response data
        //$this->setVal( 'header', wfMessage('helloworld-hello-msg') );
        //$this->setVal( 'wikiData', $this->businessLogic->getWikiData( $wikiId ) );
    }

    public function test()
    {


    }

}