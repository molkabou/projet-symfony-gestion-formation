<?php

namespace App\Controller;

use App\Entity\Formation;



use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DecimalType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FormationController extends AbstractController
{
    #[Route('/', name:'home')]
    public function home(){
        $em =$this ->getDoctrine()->getManager();
        $repo=$em ->getRepository(Formation::class);
        $lesformations=$repo->findAll();
        return $this ->render('formation/home.html.twig' , 
        ['lesformations' =>$lesformations , ]);
    }



    #[Route('/add', name: 'Ajout_form')]
    #[IsGranted('ROLE_ADMIN')]
public function ajouter2(Request $request)
{
    $formation= new Formation();
    $form = $this->createForm("App\Form\FormationType",$formation);
    $form->handleRequest($request);
    if($form->isSubmitted()){
        $em=$this->getDoctrine()->getManager();
        $em->persist($formation);
        $em->flush();
        return $this->redirectToRoute('home');
    }
    return $this->render('formation/ajouter.html.twig',
    ['f'=>$form->createView()]);
}


#[IsGranted('ROLE_ADMIN')]
#[Route('/editU/{id}', name: 'edit_user')]
public function edit(Request $request, $id)
{ $formation = new Formation();
    $formation = $this->getDoctrine()
->getRepository(Formation::class)
->find($id);
if (!$formation) {
throw $this->createNotFoundException(
'No participant found for id '.$id
);
}
$fb = $this->createFormBuilder($formation)
->add('titre', TextType::class)
->add('price', NumberType::class)
->add('duree',IntegerType::class)
->add('beginat', dateType::class)
->add('image', TextType::class)
->add('Valider', SubmitType::class);
// générer le formulaire à partir du FormBuilder
$form = $fb->getForm();
$form->handleRequest($request);
if ($form->isSubmitted()) {
$entityManager = $this->getDoctrine()->getManager();
$entityManager->flush();
return $this->redirectToRoute('home');
}
return $this->render('formation/ajouter.html.twig',
['f' => $form->createView()] );
}
#[IsGranted('ROLE_ADMIN')]
#[Route('/supp/{id}', name: 'for_delete')]
public function delete(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $formation = $entityManager->getRepository(Formation::class)->find($id);

    if (!$formation) {
        throw $this->createNotFoundException('No formation found for id ' . $id);
    }

    // Remove associated participants
    foreach ($formation->getParticipants() as $participant) {
        $entityManager->remove($participant);
    }

    // Remove the formation
    $entityManager->remove($formation);
    $entityManager->flush();

    return $this->redirectToRoute('home');
}

}
