<?php

namespace GSB\ObjComBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name,$surname)
    {
        /*return $this->render('GSBObjComBundle:Default:index.html.twig',array('name'=> $name));*/
        return $this->render('GSBObjComBundle:Default:bienvenue.html.twig',array('name'=>$name,'surname'=>$surname));
    }
}
