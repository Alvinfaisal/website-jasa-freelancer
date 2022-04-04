<?php

namespace App\Http\Requests\Dashboard\Service;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
// Use response
use Symfony\Component\HttpFoundation\Response;
// Use rule untuk validasi untuk masing masing field
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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
      //Untuk validasi inputan
      'title' => [
        'required', 'string', 'max:255',
      ],
      //Untuk validasi inputan
      'description' => [
        'nullable', 'string', 'max:5000',
      ],
      //Untuk validasi inputan
      'delivery_time' => [
        'required', 'integer', 'max:100',
      ],
      //Untuk validasi inputan
      'revision_limit' => [
        'required', 'integer', 'max:100',
      ],
      'price' => [
        'required', 'string',
      ],
      'note' => [
        'nullable', 'string', 'max:5000'
      ],
    ];
  }
}
