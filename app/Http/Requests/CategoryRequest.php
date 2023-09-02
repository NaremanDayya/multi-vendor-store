<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
class CategoryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        //حيرجع الvalidate rules يلي خزنتها بالمودل
        //بدنا نجيب ال id يلي واصلنا بالroute 
        $id = $this->route('category');//يعني رجعلنا الباراميتر يلي اسمه category يلي هو غبارة عن ال هي 
        return Category::rules($id);
    }

    public function messages()
    {
        return [
            'required' => 'please fill this (:attribute) feild!',
            //هنا حددت انه بس لحقل الstatus
            'status.required' => 'please choose status!'
        ];
    }
    
}
