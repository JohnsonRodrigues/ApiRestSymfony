<?php
declare(strict_types=1);

namespace App\Validator\Api;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EventValidator
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

    public function validate(): ?array
    {
        $violations = $this->validator->validate($this->content, $this->rules());
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }
        if (!empty($errors)) {
            return [
                'success' => false,
                'data' => $errors
            ];
        }
        return $this->content;
    }


    private function rules(): Collection
    {
        return new Collection([
            'title' => new Assert\Length(['min' => 5, 'max' => 150]),
            'description' => new Assert\NotBlank(),
            'start' => new Assert\DateTime(),
            'end' => new Assert\DateTime(),
            'status' => new Assert\Choice(['Agendado', 'Acontecendo', 'Finalizado', 'Cancelado'])
        ]);
    }

}