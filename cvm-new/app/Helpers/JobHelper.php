<?php

namespace App\Helpers;

use App\Models\JobEducation;
use App\Models\JobCompanyPerk;
use App\Models\JobSkill;
use App\Models\JobCompanyLocation;

class JobHelper
{
    public static function updateRelatedData($request, $job)
    {
        self::updateTable(JobEducation::class, 'educational_level_id', $request->educational_level_id, $job->id);
        self::updateTable(JobCompanyPerk::class, 'company_perk_id', $request->company_perk_id, $job->id);
        self::updateTable(JobSkill::class, 'skill_id', $request->skill_id, $job->id);
        self::updateTable(JobCompanyLocation::class, 'business_unit_id', $request->company_location_id, $job->id);
    }

    private static function updateTable($model, $column, $ids, $jobId)
    {
        if (is_array($ids)) {
            $model::where('job_id', $jobId)->delete();
            foreach ($ids as $id) {
                $model::create([
                    'job_id' => $jobId,
                    $column => $id,
                ]);
            }
        }
    }
}