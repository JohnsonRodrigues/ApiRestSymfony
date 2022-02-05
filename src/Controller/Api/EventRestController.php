<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\EventService;
use App\Validator\Api\EventValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class EventRestController extends AbstractController
{
    private EventService $eventService;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(EventService $eventService, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->eventService = $eventService;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        try {
            return $this->json([
                'success' => true,
                'data' => $this->eventService->findAll()
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            return $this->json([
                'success' => true,
                'data' => $this->eventService->findById($id)
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $eventValidator = new EventValidator($request, $this->validator);
            $attributes = $eventValidator->validate();
            return $this->json([
                'success' => true,
                'data' => $this->eventService->create($attributes)
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $eventValidator = new EventValidator($request, $this->validator);
            $attributes = $eventValidator->validate();
            return $this->json([
                'success' => true,
                'data' => $this->eventService->update($id, $attributes)
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }


    public function delete(string $id): JsonResponse
    {
        try {
            return $this->json([
                'success' => true,
                'data' => true
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'success' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
