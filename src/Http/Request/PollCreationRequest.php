<?php

namespace Raj\LaravelPoll\Http\Request;


use Illuminate\Support\Facades\Request;

class PollCreationRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'question' => 'present|required',
            'options.*' => 'present|required'
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'Question should be asked',
            'options.0.required' => 'Two options must be used at least',
            'options.1.required' => 'Two options must be used at least',
        ];
    }
}
