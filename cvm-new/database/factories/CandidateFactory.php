<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CandidateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'first_name' => $this->faker->name(),
            'company_id' => $this->faker->randomElement(Company::query()->get('id')),
            'created_by' => $this->faker->randomElement(Company::query()->get('id')),
            'last_name' => $this->faker->name(),
            'father_name' => $this->faker->name(),
            'mother_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'language_known' => $this->faker->randomElement(Language::query()->get('id')),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'dob' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'phone_number' =>'99'.rand(00000000,99999999),
            'aadhar_card' =>rand(10000,99999),
            'pan_card' =>rand(10000,99999),
            'designation_id' => $this->faker->randomElement(Designation::query()->get('id')),
            'department_id' => $this->faker->randomElement(Department::query()->get('id')),
            'country_id' => $this->faker->randomElement(Country::query()->get('id')),
            'total_experience' => rand(1,10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
