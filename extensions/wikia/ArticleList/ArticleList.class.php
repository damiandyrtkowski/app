<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damian
 * Date: 04.09.13
 * Time: 11:16
 * To change this template use File | Settings | File Templates.
 */

class ArticleList {
    private $title = null;
    private $app = null;


    public function __construct()
    {
        $this->app = F::app();

    }

    public function getWikiData($limit,$offset)
    {

      //$limit = 10;
      //$offset = 0;
      //$this->app->wf->GetDB(DB_SLAVE, array());

       $connection = wfGetDB(DB_SLAVE,array());
       $result = $connection->select(
           array('page'),
           array('page_id,page_title'),
           array('page_namespace'=>0,'page_is_redirect'=>0),
           'DatabaseBase::select',
           array('LIMIT' => $limit, 'OFFSET' =>$offset)
           );





        $tab = array();

        $i =0;

        foreach($result as $r)
        {
           $article = new ArticleService($r->page_id);
           $snippet = $article->getTextSnippet(100);

           $tab[$i]['id'] =  $r->page_id;
           $tab[$i]['title'] = $r->page_title;
           $tab[$i]['snippet'] = $snippet;
           $i++;

        }

       return $tab;




    }

    public function getCount()
    {

    }
}