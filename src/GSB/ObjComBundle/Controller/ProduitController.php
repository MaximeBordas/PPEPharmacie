<?php

namespace GSB\ObjComBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use GSB\ObjComBundle\Entity\Produit;

class ProduitController extends Controller
{
    public function indexAction()
    {
        return $this->render('GSBObjComBundle:Produit:index.html.twig');
    }

    public function afficherListeAction()
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('GSBObjComBundle:Produit');
        $listProduit = $repository->findAll();

        return $this->render('GSBObjComBundle:Produit:consulterListe.html.twig', array('lesProduits' => $listProduit));
    }

    public function ajouterAction(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            //On crée une instance de produit
            $unProduit = new Produit();

            //On récupere les valeurs pour les ajouter
            $libelle = $this->get('request')->request->get('libelle');
            $prix  = $this->get('request')->request->get('prix');
            $checkbox = $this->get('request')->request->get('isSold');

            //on assigne les valeurs au produit
            $unProduit->setLibelle($libelle);
            $unProduit->setPrix($prix);

            if ($checkbox == true)
            {
                $unProduit->setIsSold(1);
            }
            else
            {
                $unProduit->setIsSold(0);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($unProduit);
            $em->flush();


            $url = $this->get('router')->generate('gsb_obj_com_produit_aff_unproduit',array('id'=>$unProduit->getId()));
            return new RedirectResponse($url);
        }
        else
        {
            return $this->render('GSBObjComBundle:Produit:ajouter.html.twig');
        }
    }

    public function  afficherProduitAction($id)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('GSBObjComBundle:Produit');

        $leProduit= $repository->find($id);

        return $this->render('GSBObjComBundle:Produit:consulter.html.twig',array('leProd'=>$leProduit));
    }

    public function  modifierAction($id,Request $request)
    {
        if($request->isMethod('POST'))
        {

            $libelle = $this->get('request')->request->get('libelle');
            $prix  = $this->get('request')->request->get('prix');
            $em = $this->getDoctrine()->getManager();
            $produitRepository = $em->getRepository('GSBObjComBundle:Produit');
            $unProduit = $produitRepository->find($id);
            $unProduit->setLibelle($libelle);
            $unProduit->setPrix($prix);

            if (isset($_POST['libelle']))
            {
                $unProduit->setIsSold(1);
            }
            else
            {
                $unProduit->setIsSold(0);
            }
            $em->persist($unProduit);
            $em->flush();

            $url = $this->get('router')->generate('gsb_obj_com_produit_aff_unproduit',array('id'=>$id));
            return new RedirectResponse($url);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $produitRepository = $em->getRepository('GSBObjComBundle:Produit');
            $leProduit= $produitRepository->find($id);
            return $this->render('GSBObjComBundle:Produit:modifier.html.twig',array('leProd'=>$leProduit));
        }
    }
    public  function  supprimerAction($id, Request $request)
    {
        if ($request->isMethod('$_POST'))
        {
            //entity manager
            $em = $this->getDoctrine()->getManager();
            //Repository
            $produitRepository = $em->getRepository('GSBObjComBundle:Produit');
            $leProduit = $produitRepository->find($id);

            //on remove avec l'EM le produit
            $em->remove($leProduit);
            $em->flush();
            //flashbag pour le msg
            $request->GetSession()->GetFlashBag()->add('Infos','Produit n°'. $id. ' supprimer');
            $url = $this->get('router')->generate('gsb_obj_com_produit_aff_list');
            return new RedirectResponse($url);
        }
        else
        {
            $em = $this->getDoctrine()->getManager();
            $produitRepository = $em->getRepository('GSBObjComBundle:Produit');
            $LeProduit = $produitRepository->find($id);
            return $this->render('GSBObjComBundle:Produit:supprimer.html.twig',array('leProd'=>$LeProduit));
        }
    }
    public function menuDernProdAction($limit)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('GSBObjComBundle:Produit');

        $lesProduitsSelectionnes= $repository->derniersProduitsCrees($limit);

        return $this->render('GSBObjComBundle:Produit:menuDernProduit.html.twig',array('lesProduits' => $lesProduitsSelectionnes));
    }
}