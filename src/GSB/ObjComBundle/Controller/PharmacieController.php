<?php

namespace GSB\ObjComBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use GSB\ObjComBundle\Entity\Pharmacie;
use GSB\ObjComBundle\Entity\Image;
use GSB\ObjComBundle\Entity\Suivi;

class PharmacieController extends Controller
{
    public function indexAction()
    {
       return $this->render('GSBObjComBundle:Pharmacie:index.html.twig');
    }
     public function  afficherListeAction()
     {
         //Récupération de la liste des pharmacies
         $repository = $this->getDoctrine()->getManager()->getRepository('GSBObjComBundle:Pharmacie');
         $listPharmacie = $repository->findAll();

         //On demande à la vue d'afficher la liste des pharmacies
         return $this->render('GSBObjComBundle:Pharmacie:consulterListe.html.twig',array('lesPharmacies' => $listPharmacie));
     }
    public function  ajouterAction(Request $request)
     {
         if($request->isMethod('POST'))
         {
             //On crée une instance de Pharmacie
             $unePharm = new Pharmacie();

             //On récupère les valeurs saisi dans l'objet $unePharm
             $nom = $this->get('request')->request->get('nom');
             $ville = $this->get('request')->request->get('ville');
             $checkbox = $this->get('request')->request->get('client');

             //Nom de la pharmacie
             $unePharm->setNom($nom);
             //Ville de la pharmacie
             $unePharm->setVille($ville);

             //Case a cocher pour l'attribut client , si cocher = true sinon false
             if($checkbox == true)
             {
                 $unePharm->setClient(1);
             }
             else
             {
                 $unePharm->setClient(0);
             }

             $uneImage = new Image();

             $urlImage = $this->get('request')->request->get('url');
             $altImage  = $this->get('request')->request->get('alt');

             $uneImage->setUrl($urlImage);
             $uneImage->setAlt($altImage);

             $unePharm->setImage($uneImage);


             //On demande a l'entityManager d'enregistrer dans la bdd
             $em = $this->getDoctrine()->getManager();
             $em->persist($unePharm);
             $em->flush();

             $url = $this->get('router')->generate('gsb_obj_com_pharm_aff_unepharmacie',array('id'=>$unePharm->getId()));
             return new RedirectResponse($url);
         }
         else
         {
             return $this->render('GSBObjComBundle:Pharmacie:ajouter.html.twig');
         }
         
     }
    public function  afficherPharmacieAction($id)
     {
         $repository = $this->getDoctrine()->getManager()->getRepository('GSBObjComBundle:Pharmacie');

         $laPharmacie= $repository->find($id);

         return $this->render('GSBObjComBundle:Pharmacie:consulter.html.twig',array('laPharm'=>$laPharmacie));
     }
    public function  modifierAction($id,Request $request)
     {
         if($request->isMethod('POST'))
         {
             //On récupere les infos de la pharmacie

             $nom = $this->get('request')->request->get('nom');
             $ville = $this->get('request')->request->get('ville');

             $urlImage = $this->get('request')->request->get('url');
             $altImage = $this->get('request')->request->get('alt');

             //on accede a l'id de la pharmacie avec l'entity Manager
             $em = $this->getDoctrine()->getManager();
             $pharmacieRepository = $em->getRepository('GSBObjComBundle:Pharmacie');

             $unePharm = $pharmacieRepository->find($id);

             //On assigne les valeurs
             $unePharm->setNom($nom);
             $unePharm->setVille($ville);
             if(isset($_POST['client']) )
             {
                 $unePharm->setClient(1);
             }
             else
             {
                 $unePharm->setClient(0);
             }
             if($unePharm->getImage() == null)
             {
                 $uneImage = new Image();
             }
             else
             {
                 $idImage = $unePharm->getImage()->getId();
                 $uneImage = $em->getRepository('GSBObjComBundle:Image')->find($idImage);
             }

             $uneImage->setUrl($urlImage);
             $uneImage->setAlt($altImage);

             $unePharm->setImage($uneImage);


             $em->persist($unePharm);
             $em->flush();


             
             $url = $this->get('router')->generate('gsb_obj_com_pharm_aff_unepharmacie',array('id'=>$id));
             return new RedirectResponse($url);
         }
         else
         {
             //permet de mofifier la pharmacie passer en parametre

             $em = $this->getDoctrine()->getManager();
             $pharmacieRepository = $em->getRepository('GSBObjComBundle:Pharmacie');
             $laPharmacie= $pharmacieRepository->find($id);
             return $this->render('GSBObjComBundle:Pharmacie:modifier.html.twig',array('laPharm'=>$laPharmacie));
         }
         
     }
    public function  supprimerAction($id,Request $request)
     {
         if($request->isMethod('POST'))
         {
             //On récupere la pharmacie passer en paramêtre
             $em = $this->getDoctrine()->getManager();
             $pharmacieRepository = $em->getRepository('GSBObjComBundle:Pharmacie');
             $laPharm = $pharmacieRepository->find($id);

             //On use l'entity Manager pour supprimer la pharmacie
             $em->remove($laPharm);
             $em->flush();
             //msg flash pour la suppression de la pharmacie
             $request->GetSession()->GetFlashBag()->add('info','pharmacie n°'.$id.' supprimer');
             $url = $this->get('router')->generate('gsb_obj_com_pharm_aff_list');
             return new RedirectResponse($url);
         }
         else
         {
             $em = $this->getDoctrine()->getManager();
             $pharmacieRepository = $em->getRepository('GSBObjComBundle:Pharmacie');
             $laPharmacie = $pharmacieRepository->find($id);
             return $this->render('GSBObjComBundle:Pharmacie:supprimer.html.twig',array('laPharm'=>$laPharmacie));
         }
         
     }
    
    public function menuDernPharmAction($limit)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('GSBObjComBundle:Pharmacie');

        $lesPharmSelectionnes= $repository->dernieresPharmaciesCrees($limit);

        return $this->render('GSBObjComBundle:Pharmacie:menuDernPharmacie.html.twig',array('lesPharmacies' => $lesPharmSelectionnes));

    }
        
            
}
    