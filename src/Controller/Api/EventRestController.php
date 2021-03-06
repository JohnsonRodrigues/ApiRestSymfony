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
use Symfony\Component\Validator\Validator\ValidatorInterface;


class EventRestController extends AbstractController
{
    private EventService $eventService;
    private ValidatorInterface $validator;

    public function __construct(EventService $eventService, ValidatorInterface $validator)
    {
        $this->eventService = $eventService;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        try {
            return $this->json([
                'status' => true,
                'data' => $this->eventService->findAll()
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'status' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function show(string $id): JsonResponse
    {
        try {
            return $this->json([
                'status' => true,
                'data' => $this->eventService->findById($id)
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'status' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $eventValidator = new EventValidator($request, $this->validator);
            $errors = $eventValidator->validate();
            if (count($errors) > 0) {
                return $this->json([
                    'status' => false,
                    'data' => $errors
                ], 422);
            }
            return $this->json([
                'status' => true,
                'data' => $this->eventService->create($eventValidator->validated())
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'status' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function update(string $id, Request $request): JsonResponse
    {
        try {
            $eventValidator = new EventValidator($request, $this->validator);
            $errors = $eventValidator->validate();
            if (count($errors) > 0) {
                return $this->json([
                    'status' => false,
                    'data' => $errors
                ], 422);
            }
            return $this->json([
                'status' => true,
                'data' => $this->eventService->update($id, $eventValidator->validated())
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'status' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }


    public function delete(string $id): JsonResponse
    {
        try {
            return $this->json([
                'status' => true,
                'data' => true
            ]);
        } catch (Exception $exception) {
            return $this->json([
                'status' => false,
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
