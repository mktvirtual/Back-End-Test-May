<?php

class IndexController extends BaseController
{

    public function indexAction()
    {
        return new \Symfony\Component\HttpFoundation\Response($this->request->get('a'));
    }

}