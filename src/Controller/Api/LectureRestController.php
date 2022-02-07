<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Service\LectureService;
use App\Validator\Api\LectureValidator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class LectureRestController extends AbstractController
{
    private LectureService $lectureService;
    private ValidatorInterface $validator;

    public function __construct(LectureService $lectureService, ValidatorInterface $validator)
    {
        $this->lectureService = $lectureService;
        $this->validator = $validator;
    }

    public function index(): Response
    {
        try {
            return $this->json([
                'success' => true,
                'data' => $this->lectureService->findAll()
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
                'data' => $this->lectureService->findById($id)
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
            $lectureValidator = new LectureValidator($request, $this->validator);
            $errors = $lectureValidator->validate();
            if (count($errors) > 0) {
                return $this->json([
                    'status' => false,
                    'data' => $errors
                ], 422);
            }
            return $this->json([
                'success' => true,
                'data' => $this->lectureService->create($lectureValidator->validated())
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
            $lectureValidator = new LectureValidator($request, $this->validator);
            $errors = $lectureValidator->validate();
            if (count($errors) > 0) {
                return $this->json([
                    'status' => false,
                    'data' => $errors
                ], 422);
            }
            return $this->json([
                'success' => true,
                'data' => $this->lectureService->update($id, $lectureValidator->validated())
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
