<?php


namespace App\Controller\Chat;


use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SideBarController extends AbstractController
{

    public function __construct(
        private ConversationRepository $repository,
    )
    {
    }

    public function sidebar() : Response
    {

        $conversations = $this->repository->findByUserInConversation(($this->getUser())->getId());

        return $this->render("chat/container/sidebar.html.twig", compact("conversations"));
    }

}