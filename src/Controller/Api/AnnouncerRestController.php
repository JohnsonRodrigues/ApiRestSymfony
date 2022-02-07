<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\AnnouncerService;
use App\Validator\Api\AnnouncerValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class AnnouncerRestController extends AbstractController
{
    private AnnouncerService $announcerService;
    private ValidatorInterface $validator;

    public function __construct(AnnouncerService $announcerService, ValidatorInterface $validator)
    {
        $this->announcerService = $announcerService;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        try {
            return $this->json([
                'success' => true,
                'data' => $this->announcerService->findAll()
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
                'data' => $this->announcerService->findById($id)
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
            $lectureValidator = new AnnouncerValidator($request, $this->validator);
            $errors = $lectureValidator->validate();
            if (count($errors) > 0) {
                return $this->json([
                    'status' => false,
                    'data' => $errors
                ], 422);
            }
            return $this->json([
                'success' => true,
                'data' => $this->announcerService->create($lectureValidator->validated())
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
            $lectureValidator = new AnnouncerValidator($request, $this->validator);
            $errors = $lectureValidator->validate();
            if (count($errors) > 0) {
                return $this->json([
                    'status' => false,
                    'data' => $errors
                ], 422);
            }
            return $this->json([
                'success' => true,
                'data' => $this->announcerService->update($id, $lectureValidator->validated())
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
