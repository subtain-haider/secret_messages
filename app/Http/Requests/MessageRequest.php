<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool True if the user can make this request
     */
    public function authorize()
    {
        // Authorization logic can be implemented here
        return true; // e.g auth()->user()->can('manage_messages')
    }

    /**
     * Define validation rules for the request.
     *
     * @return array Validation rules
     */
    public function rules()
    {
        return [
            'text' => 'required|string|max:5000', 
            'recipient_id' => 'required|integer|exists:users,id',
            'decryption_key' => 'sometimes|string'  // Optional decryption key
        ];
    }

    /**
     * Prepare the data for validation by sanitizing inputs.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'text' => strip_tags($this->text) // Sanitize the 'text' input to remove HTML tags
        ]);
    }
}
