<?php

namespace App\Controller;

use App\Entity\Participant;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParticipantController extends AbstractController
{
    #[Route('/addPart', name: 'add_participant')]
    public function add(Request $request){

        $part=new Participant();

        $form = $this ->createForm("App\Form\ParticipantType",$part);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($part);
            $em ->flush();

            return $this -> redirectToRoute('listeparticipant');
        }
        return $this->render('participant/ajouter.html.twig',
        ['f'=>$form->createView()]);
        
        

    }
    

    #[Route('/listpart', name: 'listeparticipant')]

    
    public function liste()
    {
    $em = $this->getDoctrine()->getManager();
    $respo = $em->getRepository(Participant:: class);
    $listeparticipants = $respo->findAll();
    return $this->render('participant/listeparticipant.html.twig', ['participant' =>$listeparticipants]);
            }
    
}
