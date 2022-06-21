<?php


namespace App\Controller\Chat\Api;


use App\Entity\Conversation;
use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MessageApiConversation extends AbstractController
{

    public function __construct(
        private MessageRepository $messageRepository,
        private SerializerInterface $serializer,
        private EntityManagerInterface $em
    )
    {
    }

    #[Route("/api/conversation/{id}/messages", methods: ["GET"])]
    public function getMessagesConversation(?Conversation $conversation): JsonResponse
    {
        $user = $this->getUser();

        $response = new JsonResponse();
        if (!$conversation) {
            return $response->setData(["error" => "no_conversation"])
                ->setStatusCode(404);
        } else if (!$user) {
            return $response->setData(["error" => "not_connected"])
                ->setStatusCode(400);
        } else if (!in_array($user, $conversation->getUsers()->toArray())) {
            return $response->setData(["error" => "access_denied"])
                ->setStatusCode(403);
        }

        $messages = $this->messageRepository->findBy(["conversation" => $conversation], ["createdAt" => "ASC"]);

        $messages = $this->serializer->serialize($messages, "json", ["groups" => ["read:messages:conversation"]]);

        $response->setJson($messages)
            ->setStatusCode(200);


        return $response;

    }

    #[Route("/api/messages", methods: ["POST"])]
    public function postMessage(Request $request): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            return new JsonResponse(["error" => "not_connected"], 400);
        }

        $data = json_decode($request->getContent(), true);
        $data["owner"] = $user->getId();

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->submit($data);

        if (!$form->isValid()) {
            return new JsonResponse(["error" => "bad request"], 400);
        }

        $conversation = $message->getConversation();

        if (!in_array($user, $conversation->getUsers()->toArray())) {
            return new JsonResponse(["error" => "access_denied"], 403);
        }

        $this->em->persist($message);
        $this->em->flush();

        return new JsonResponse($this->serializer->serialize($message, "json", ["groups" => ["read:messages:conversation"]]), 200, [], true);
    }
}