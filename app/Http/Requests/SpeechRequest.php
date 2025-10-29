<?php

namespace App\Http\Requests;

use App\Enums\PathWay;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpeechRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'evaluator_id' => 'nullable|exists:users,id',
            'length' => 'required|integer|min:1|max:30',
            'objectives' => 'required',
            'evaluator_notes' => 'nullable|string',
            'pathway' => ['required', Rule::enum(PathWay::class)],
            'workshop_id' => 'nullable|exists:workshops,id',
        ];
    }

    // prepareForValidation
    protected function prepareForValidation(): void
    {
        // dd($this->all());

        if ($this->has('speaker')) {
            $this->merge([
                'user_id' => $this->input('speaker'),
            ]);
        } else {
            $this->merge([
                'user_id' => $this->user()->id,
            ]);
        }
    }
}
