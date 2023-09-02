<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //بدنا نحددله خصائص الاشياء يلي رح تتعبى بالجدول
        // $name =$this->faker->words(2, true);
        //بعد ما نزلنا بكج ال mbezhanov ممكن اخليه يجيبلي اسماء departments 
        $name =$this->faker->department();
        return [
            'name' => $name,//حيرجعلنا اسم من كلمتين ويكون عبارة عن نص
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(15),// بيرجعلي جملة من 6 كلمات فاحنا اذا بدنا بنزودهم 
            'image' =>$this->faker->imageUrl(),
        ];
    }
}
