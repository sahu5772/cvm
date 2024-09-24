<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Phase;
use App\Models\State;
use App\Models\Sector;
use App\Models\Company;
use App\Models\Country;
use App\Models\Industry;
use App\Models\Language;
use App\Models\Terrains;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Support\Str;
use App\Models\ContractMode;
use App\Models\FundingAgency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidateProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => 'Project -' .$this->faker->name(),
            'candidate_id' => rand(1,100),
            'company_id' => 1,
            'from' => date('y-m-d'),
            'to' => date('y-m-d'),
            'designation_id' => $this->faker->randomElement(Designation::query()->get('id')),
            'industry_id' => $this->faker->randomElement(Industry::query()->get('id')),
            'sector_id' => $this->faker->randomElement(Sector::query()->get('id')),
            'phase_id' => $this->faker->randomElement(Phase::query()->get('id')),
            'funding_agency_id' => $this->faker->randomElement(FundingAgency::query()->get('id')),
            'contract_mode_id' => $this->faker->randomElement(ContractMode::query()->get('id')),
            'terrain_id' => $this->faker->randomElement(Terrains::query()->get('id')),
            'project_type' => 'National',
            'country_id' => $this->faker->randomElement(Country::query()->get('id')),
            'state_id' => $this->faker->randomElement(State::query()->get('id')),
            'city_id' => $this->faker->randomElement(City::query()->get('id')),
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
