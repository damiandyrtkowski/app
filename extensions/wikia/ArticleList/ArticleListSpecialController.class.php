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

    public function __construct() {
        parent::__construct( 'ArticleList','', false );
    }

    public function init() {
       // $this->businessLogic = F::build( 'ArticleList', array( 'currentTitle' => $this->app->wg->Title ) );
    }

    public function index() {

        //$offset = 0;
        //$limit = 20;

        $data = F::build('ArticleList', array());
        $offset = $this->request->getVal('offset',0);

        //$params = $request->getParams();


        $articles = $data->getWikiData(self::limit,$offset);

        $t = Title::newFromText("ArticleList",NS_SPECIAL);
        $link = $t->getFullURL("offset=");

        $this->setVal('list',$articles);
        $this->setVal('link', $link);
        $this->setVal('offset',$offset);
        $this->setVal('limit',self::limit);

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
}