<?php

namespace App\Http\Requests\Dashboard\Profile;

// User Model
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
// Use response
use Symfony\Component\HttpFoundation\Response;
// Use rule untuk validasi untuk masing masing field
use Illuminate\Validation\Rule;
// use auth untuk authentication
use Illuminate\Support\Facades\Auth;


class UpdateProfileRequest extends FormRequest
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
      'name' => [
        'required', 'string', 'max:255',
      ],
      'email' => [
        'required', 'string', 'max:255', 'email', Rule::unique('users')->where('id', '!=', Auth::user()->id),
      ],
    ];
  }
}
