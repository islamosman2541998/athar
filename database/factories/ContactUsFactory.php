<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contactus>
 */
class ContactUsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name(),
            'email' =>$this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'subject' => $this->faker->sentence(3),
            'message' => $this->faker->paragraph(3),
            'city' => $this->faker->word(),
            'type' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
