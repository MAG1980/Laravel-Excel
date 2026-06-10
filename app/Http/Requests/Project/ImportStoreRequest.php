<?php

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Validation\ValidationRule;
// use Nette\Schema\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ImportStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Проверка типа файла по его расширению без MIME types.
        if (! in_array($this->file->getClientOriginalExtension(), ['xlsx', 'xls'])) {
            throw ValidationException::withMessages(['Incorrect file extension']);
        }

        return [
            'file' => 'required|file|mimes:xlsx,xls',
            'type' => 'required|integer|in:1,2',
        ];
    }
}
