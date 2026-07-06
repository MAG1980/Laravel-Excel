import { z } from 'zod';
import { requiredLimitedFile, requiredString } from '@spa/schemas/';

export const createPostSchema = z.object({
    title: requiredString('title').min(3, 'Минимум 3 символа'),
    content: requiredString('content').min(10, 'Минимум 10 символов'),
    image: requiredLimitedFile(),
});

// Вывод типа для использования в компонентах (TypeScript)
export type CreatePostFormData = z.infer<typeof createPostSchema>;
