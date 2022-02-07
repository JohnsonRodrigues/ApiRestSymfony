<?php
declare(strict_types=1);

namespace App\Validator\Api;

use App\Validator\Validation\LectureExist;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AnnouncerValidator
{
    private array $content;
    private ValidatorInterface $validator;

    public function __construct(Request $request, ValidatorInterface $validator)
    {
        if ($request->getContentType() === 'json') {
            $this->content = json_decode($request->getContent(), true) ?? [];
        } else {
            $this->content = $request->request->all();
        }
        $this->validator = $validator;
    }

    public function validate(): array
    {
        $violations = $this->validator->validate($this->content, $this->rules());
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors ?? [];
    }

    public function validated(): array
    {
        return $this->content ?? [];
    }

    private function rules(): Collection
    {
        return new Collection([
            'name' => new Assert\Length(['min' => 5, 'max' => 150]),
            'lecture_id' => [new Assert\Required(), new Assert\NotBlank(), new Assert\Ulid(), new LectureExist()],
        ]);
    }
}