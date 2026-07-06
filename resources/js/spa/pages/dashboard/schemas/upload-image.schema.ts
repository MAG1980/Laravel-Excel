import { z } from 'zod';
import { requiredLimitedFile } from '@spa/schemas';

export const uploadImageSchema = z.object({
    image: requiredLimitedFile(),
    postId: z.number().optional(),
    isActive: z.number().int().min(0).max(1).optional(),
});

export type UploadImageFormData = z.infer<typeof uploadImageSchema>;
