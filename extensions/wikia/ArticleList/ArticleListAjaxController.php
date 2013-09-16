<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Damian
 * Date: 05.09.13
 * Time: 17:39
 * To change this template use File | Settings | File Templates.
 */

class ArticleListAjaxController extends WikiaController {
    public function index() {
        //$this->set
       $category = $this->request->getVal("category");
       $title = $this->request->getVal("title");
        $this->setVal("result",$category);
        $this->setVal("title",$title);
       /// $this->setResponse()->setVal();

        //$this->getResponse()->setData(["x" => 1]);






    }
}