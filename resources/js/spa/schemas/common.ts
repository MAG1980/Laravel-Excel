import { z } from 'zod';

export const emailSchema = z.string().email('Некорректный email');
export const passwordSchema = z.string().min(8, 'Минимум 8 символов');
export const requiredString = (field: string) =>
    z.string().nonempty(`${field} обязательно для заполнения`);

export const requiredLimitedFile = (
    maxSizeKB: number = 2048,
    allowedTypes: string[] = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ],
) =>
    z
        .instanceof(File, { message: 'Необходимо загрузить файл изображения' })
        .refine((file) => file.size <= maxSizeKB * 1024, {
            message: `Размер файла не должен превышать ${maxSizeKB} КБ`,
        })
        .refine((file) => allowedTypes.includes(file.type), {
            message: `Допустимые форматы: ${allowedTypes.join(', ')}`,
        });
