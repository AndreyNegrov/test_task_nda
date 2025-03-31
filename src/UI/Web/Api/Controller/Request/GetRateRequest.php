<?php

declare(strict_types=1);

namespace App\UI\Web\Api\Controller\Request;

use Symfony\Component\Validator\Constraints as Assert;

class GetRateRequest
{
    public function __construct(
        #[Assert\NotBlank(
            message: 'Параметр baseCurrency обязателен для заполнения',
            payload: ['error_code' => 'field_required']
        )]
        #[Assert\Type(
            type: 'string',
            message: 'Параметр baseCurrency должен быть строкой',
            payload: ['error_code' => 'invalid_type']
        )]
        #[Assert\Regex(
            pattern: '/^[A-Z]{3}$/',
            message: 'Параметр baseCurrency должен содержать 3 заглавные буквы (например: USD)',
            payload: ['error_code' => 'invalid_format']
        )]
        public string $baseCurrency,

        #[Assert\NotBlank(
            message: 'Параметр targetCurrency обязателен для заполнения',
            payload: ['error_code' => 'field_required']
        )]
        #[Assert\Type(
            type: 'string',
            message: 'Параметр targetCurrency должен быть строкой',
            payload: ['error_code' => 'invalid_type']
        )]
        #[Assert\Regex(
            pattern: '/^[A-Z]{3}$/',
            message: 'Параметр targetCurrency должен содержать 3 заглавные буквы (например: EUR)',
            payload: ['error_code' => 'invalid_format']
        )]
        public string $targetCurrency,

        #[Assert\NotBlank(
            message: 'Параметр date обязателен для заполнения',
            payload: ['error_code' => 'field_required']
        )]
        #[Assert\Type(
            type: 'string',
            message: 'Параметр date должен быть строкой',
            payload: ['error_code' => 'invalid_type']
        )]
        #[Assert\Regex(
            pattern: '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/',
            message: 'Неверный формат даты. Используйте YYYY-MM-DD HH:MM (например: 2024-03-30 14:30)',
            payload: ['error_code' => 'invalid_format']
        )]
        public string $date
    ) {}
}
