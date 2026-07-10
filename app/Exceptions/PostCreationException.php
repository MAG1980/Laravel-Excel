<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class PostCreationException extends Exception
{
    /**
     * @var array|null Дополнительные данные об ошибке
     */
    protected ?array $context = null;

    /**
     * Конструктор исключения.
     *
     * @param  string  $message  Сообщение об ошибке
     * @param  int  $code  Код ошибки
     * @param  Throwable|null  $previous  Предыдущее исключение
     * @param  array|null  $context  Дополнительный контекст
     */
    public function __construct(
        string $message = 'Ошибка создания поста',
        int $code = 0,
        ?Throwable $previous = null,
        ?array $context = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }

    /**
     * Получить контекст ошибки.
     */
    public function getContext(): ?array
    {
        return $this->context;
    }

    /**
     * Получить HTTP статус код для ответа.
     */
    public function getStatusCode(): int
    {
        return match ($this->code) {
            400 => 400,
            403 => 403,
            404 => 404,
            default => 500,
        };
    }

    /**
     * Создать исключение для ошибки валидации.
     */
    public static function validationError(string $field, string $message): self
    {
        return new self(
            "Ошибка валидации поля '{$field}': {$message}",
            400,
            null,
            ['field' => $field, 'validation_message' => $message]
        );
    }

    /**
     * Создать исключение для ошибки сохранения файла.
     */
    public static function uploadError(string $message, ?Throwable $previous = null): self
    {
        return new self(
            "Ошибка загрузки изображения: {$message}",
            500,
            $previous,
            ['operation' => 'upload']
        );
    }

    /**
     * Создать исключение для ошибки транзакции.
     */
    public static function transactionError(string $message, ?Throwable $previous = null): self
    {
        return new self(
            "Ошибка транзакции: {$message}",
            500,
            $previous,
            ['operation' => 'transaction']
        );
    }

    /**
     * Создать исключение для ошибки доступа.
     */
    public static function accessDenied(string $message = 'Доступ запрещен'): self
    {
        return new self(
            $message,
            403,
            null,
            ['operation' => 'access_denied']
        );
    }

    /**
     * Создать исключение для ошибки "пост не найден".
     */
    public static function notFound(int $postId): self
    {
        return new self(
            "Пост с ID {$postId} не найден",
            404,
            null,
            ['post_id' => $postId]
        );
    }
}
