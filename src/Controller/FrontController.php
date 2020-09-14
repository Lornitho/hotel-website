<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\ContactType;
use App\Form\ReservationType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front_index")
     */
    public function index(RoomRepository $roomRepository)
    {
        return $this->render('front/index.html.twig', [
            'rooms' => $roomRepository->getAvaillableHome(),
        ]);
    }

    /**
     * @Route("/rooms", name="rooms")
     */
    public function allrooms(RoomRepository $roomRepository)
    {
        return $this->render('front/rooms.html.twig', [
            'rooms' => $roomRepository->getAvaillable(),
        ]);
    }

    /**
     * @Route("/room/{id}", name="room_detail")
     */
    public function detail(Room $room)
    {
        return $this->render('front/room-detail.html.twig', [
            'room' => $room,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/reserver/{id}", name="reserver")
     */
    public function reserver(Room $room, Request $request)
    {

        if($room->getIsAvailable()==false){
            $this->addFlash(
                'notice',
                'Désolé, cette chambre n\'est pas disponible'
            );
            return $this->redirectToRoute('front_index');
        }

        $reservation= new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $user=$this->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reservation->setRoom($room);
            $reservation->setUser($user);
            $room->setIsAvailable(false);
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash(
                'notice',
                'Votre reservation a été pris en compte avec succès'
        );
            return $this->redirectToRoute('front_index');
        }

        return $this->render('front/reserver.html.twig',[
            'room'=>$room,
            'form' => $form->createView(),]
        );
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('front/about.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();
            $message = (new \Swift_Message('Contact'))
                ->setFrom($contactFormData['email'])
                ->setTo('alemanpierre@gmail.com')
                ->setBody(
                    $contactFormData['message'],
                    'text/plain'
                )
            ;

            $mailer->send($message);

            $this->addFlash('success', 'It sent!');

            return $this->redirectToRoute('contact');
        }
        return $this->render('front/contact.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}