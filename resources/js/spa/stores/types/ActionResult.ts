import type { ValidationErrors } from '@spa/stores/types/ValidationErrors';

/** Результат операций с возможными ошибками */
export type ActionResult = {
    success: boolean;
    errors?: ValidationErrors;
};
