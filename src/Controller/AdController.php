<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ad_index")
     */
    public function index(AdRepository $repo): Response
    {
        
        $ads=$repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads'=>$ads
        ]);
    }

    /**
     * Permets de créer une annonce
     * 
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Reponse
     */

     public function create(Request $request, ManagerRegistry $manager){

        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);
        
        
        if($form ->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->getManager()->persist($image);
            }

            $this->addFlash(
                'notice',
                'l\'annonce a bien été enregistrée !'
            );

            $manager->getManager()->persist($ad);
            $manager->getManager()->flush();

           return $this->redirectToRoute('ads_show',['slug'=>$ad->getSlug()]);
         }
         return $this->render('ad/new.html.twig',[
        'form'=>$form->createView()
        ]
      );
     }

    /**
     * @Route("/ads/{slug}", name="ads_show")
     */

     public function show(Ad $ad){

        /*$ad=$repo->findOneBySlug($slug);*/

        return $this->render('ad/show.html.twig', [
            'ad'=>$ad
        ]);
     }
}
