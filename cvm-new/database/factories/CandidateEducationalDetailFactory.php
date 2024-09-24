<?php

namespace Database\Factories;

use App\Models\Subject;
use App\Models\University;
use App\Models\EducationMode;
use App\Models\EducationalLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateEducationalDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'candidate_id' => rand(1,500),
            'percentage' => rand(36,100),
            // 'company_id' => 1,
            'educational_level_id' => $this->faker->randomElement(EducationalLevel::query()->get('id')),
            'university_id' => $this->faker->randomElement(University::query()->get('id')),
            'education_mode_id' => $this->faker->randomElement(EducationMode::query()->get('id')),
            'subject_id' => $this->faker->randomElement(Subject::query()->get('id')),
            'specialization'=>'specialization',
            'from_year'=>'2020',
            'to_year'=>'2021',
            'created_by'=>'1',
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
