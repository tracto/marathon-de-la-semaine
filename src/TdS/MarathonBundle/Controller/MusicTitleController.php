<?php

namespace TdS\MarathonBundle\Controller;

use TdS\MarathonBundle\Entity\Theme;
use TdS\MarathonBundle\Entity\Joggeur;
use TdS\MarathonBundle\Entity\MusicTitle;
use TdS\MarathonBundle\Form\MusicTitleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MusicTitleController extends Controller{

	

	public function addAction($theme_id, $joggeur_id,  $route, Request $request){
		$theme=new Theme();
		$joggeur=new Joggeur();
		$musicTitle=new MusicTitle();

		if($route == 'joggeur-view'){
			$url=$this->generateUrl('tds_marathon_joggeur_view',array('id'=>$joggeur_id));

		}elseif($route == 'index'){
			$url=$this->generateUrl('tds_home');
		}elseif($route == 'theme-view'){
			$url=$this->generateUrl('tds_marathon_theme_view',array('id'=>$theme_id));
		}else{
			$url=$this->generateUrl('tds_home');
		}

		$em=$this->getDoctrine()->getManager();
		if($theme_id){
			$theme = $em
	      			->getRepository('TdSMarathonBundle:Theme')
	      			->find($theme_id);
	      	$musicTitle->setTheme($theme);
	   	}

		if($joggeur_id){
			$joggeur = $em
	      			->getRepository('TdSMarathonBundle:Joggeur')
	      			->find($joggeur_id);
	      	$musicTitle->setJoggeur($joggeur);
   		}



	    $form=$this->get('form.factory')->create(new MusicTitleType(), $musicTitle); 
		$form->handleRequest($request);

		if($form->isValid()){

			$em=$this->getDoctrine()->getManager();
			$em->persist($musicTitle);
			$em->flush();
			
			$request->getSession()->getFlashBag()->add('notice','joggeur bien enregistré.');
			return $this->redirect($url);
		}

        return $this->render('TdSMarathonBundle:MusicTitle:add.html.twig', array(
        							'theme'=>$theme,
        							'joggeur'=>$joggeur,
        							'form'=>$form->createView()
        ));
	}


	public function listAction($theme_id, Request $request){
		 $em=$this->getDoctrine()->getManager();

		 $theme = $em->getRepository('TdSMarathonBundle:Theme')
	      			 ->find($theme_id);

		 $listeMusicTitles=$em->getRepository('TdSMarathonBundle:MusicTitle')
	           			      ->findBy(array('theme' => $theme));

	    return $this->render('TdSMarathonBundle:MusicTitle:liste.html.twig', array(
        							'theme'=>$theme,
        							 'listeMusicTitles'=>$listeMusicTitles
        							));
	}


	public function deleteAction(MusicTitle $musicTitle, $id, Request $request){
		$referer = $this->getRequest()->headers->get('referer');

		$em=$this->getDoctrine()->getManager();

		// $joggeur = $em->getRepository('TdSMarathonBundle:Joggeur')
  //                   ->findOneBy(array('id' => $id));


        if($musicTitle!=null){
             $em->remove($musicTitle);
             $em->flush();
        }

        return $this->redirect($referer);
	}
}
?>