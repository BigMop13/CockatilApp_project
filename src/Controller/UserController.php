<?php
declare(strict_types=1);

namespace App\Controller;

use App\Dto\RegistrationInput;
use App\Entity\User;
use App\Persister\UserPersister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    public function __construct(private readonly SerializerInterface $serializer, private readonly UserPersister $persister)
    {
    }

    /**
     * @Route("/register", name="app_register", methods={"POST"})
     */
    public function registration(UserPasswordHasherInterface $passwordHasher, Request $request): JsonResponse
    {
        try {
            $registerInput = $this->serializer->deserialize($request->getContent(), RegistrationInput::class, 'json');

            $plaintextPassword = $registerInput->getPassword();
            $user = (new User())->setUsername($registerInput->getUsername())
                ->setEmail($registerInput->getEmail())
                ->setNumber($registerInput->getNumber());

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);

            $this->persister->persist($user);
        }catch (\Exception $e)
        {
            return new JsonResponse([
                'statusCode' => Response::HTTP_BAD_REQUEST,
                'message' => "Error occured"
            ]);
        }

        return new JsonResponse([
            'statusCode' => Response::HTTP_CREATED,
            'message' => "User registered successfully"
        ]);
    }
}