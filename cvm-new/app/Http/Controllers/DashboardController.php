<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Job;
use App\Models\User;
use App\Models\Sector;
use App\Models\Company;
use App\Models\Subject;
use App\Models\Candidate;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use App\Models\CandidateProject;
use App\Models\EducationalLevel;
use App\Models\ViewDashboardData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateEducationalDetail;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalCompanyData = ViewDashboardData::where('id', '!=', Auth::user()->company_id)->count('id');
        $totalCandidateData = ViewDashboardData::company()->first();
        $last90DaysCount = ViewDashboardData::company()->first();
        $totalEmployee = ViewDashboardData::company()->first();
        $totalVerifiedCandidate = Candidate::active()->where(function ($query) {
            $query->where('is_email_verified', '1')
                ->orWhere('is_mobile_verified', '1');
        })->count('id');

        if ($request->ajax()) {
            $emailSetting = EmailSetting::ConfiguredEmail()->exists();
            $sectorCounts = $this->getCandidateSectorData(CandidateProject::class, 'sector_id', 'candidate_id', $totalCandidateData['total_candidates']);
            $subjectCounts = $this->getCandidateSubjectData(CandidateEducationalDetail::class, 'subject_id', 'candidate_id', $totalCandidateData['total_candidates']);
            $candidates= Candidate::company()->get();
            $candidateExp = $this->calculateCandidateCountsByExperience($candidates);
            $candidateAge = $this->calculateCandidateCountsByAge($candidates);
            $eduLevelCounts = $this->getCandidateEducationalData(CandidateEducationalDetail::class, 'educational_level_id', 'candidate_id', $totalCandidateData['total_candidates']);
            return response()->json([
                'success' => true,
                'sectorCounts' => $sectorCounts,
                'subjectCounts' => $subjectCounts,
                'candidateExp' => $candidateExp,
                'candidateAge' => $candidateAge,
                'eduLevelCounts' => $eduLevelCounts,
                'emailSetting' => $emailSetting,
            ]);
        }

        return view('dashboard')->with([
        'totalCompanyData' => $totalCompanyData,
        'totalVerifiedCandidate' => $totalVerifiedCandidate,
        'totalCandidateData' => $totalCandidateData?$totalCandidateData['total_candidates']:'0',
        'totalEmployee' => $totalEmployee?$totalEmployee['total_users'] - 1:0,
        'last90DaysCount' => $last90DaysCount?$last90DaysCount['total_last90_days_candidate']:'0',]);
    }

    private function getCandidateSectorData($modelClass, $column, $distinctColumn, $totalCandidateCount)
    {
        $sectors = Sector::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->limit(10)->get();
        $sectorNames = $sectors->pluck('name')->toArray();

        $sectorCounts = [];

        foreach ($sectors as $sector) {
            $sectorId = $sector->id;

            $sectorCount = $modelClass::select(DB::raw('count(DISTINCT candidate_id) as candidate_count'))
            ->join('candidates', 'candidates.id', '=', 'candidate_projects.candidate_id')
            ->where('candidates.company_id', '=', Auth::user()->company_id)
            ->where('candidate_projects.sector_id', '=', $sectorId)
            ->first();


            if ($sectorCount) {
                $sectorCounts[] = $sectorCount->candidate_count;
            } else {
                $sectorCounts[] = 0;
            }
        }
        $data = $sectorCounts;
        $counts = [
            'name' => $sectorNames,
            'data' => $data,
        ];

        $result = [];
        $totalCandidate = $totalCandidateCount;

        foreach ($counts['name'] as $index => $name) {
            $count = isset($counts['data'][$index]) ? $counts['data'][$index] : 0;

            $totalCandidate = ($totalCandidate > 0) ? $totalCandidate : 1;

            $percentage = round(($count / $totalCandidate) * 100);

            $result[] = [
                'name' => $name,
                'count' => $count,
                'percentage' => $percentage,
            ];
        }


        return $result;
    }

    public function getCandidateSubjectData($modelClass, $column, $distinctColumn, $totalCandidateCount)
    {
        $subjects = Subject::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->limit(10)->get();
        $subjectNames = $subjects->pluck('name')->toArray();

        $subjectCounts = [];

        foreach ($subjects as $subject) {
            $subjectId = $subject->id;

            $subjectCount = $modelClass::select(DB::raw('count(DISTINCT candidate_id) as candidate_count'))
            ->join('candidates', 'candidates.id', '=', 'candidate_educational_details.candidate_id')
            ->where('candidates.company_id', '=', Auth::user()->company_id)
            ->where('candidate_educational_details.subject_id', '=', $subjectId)
            ->first();


            if ($subjectCount) {
                $subjectCounts[] = $subjectCount->candidate_count;
            } else {
                $subjectCounts[] = 0;
            }
        }
        $data = $subjectCounts;
        $counts = [
            'name' => $subjectNames,
            'data' => $data,
        ];

        $result = [];
        $totalCandidate = $totalCandidateCount;

            foreach ($counts['name'] as $index => $name) {
                $count = isset($counts['data'][$index]) ? $counts['data'][$index] : 0;
                $totalCandidate = ($totalCandidate > 0) ? $totalCandidate : 1;
                $percentage = round(($count / $totalCandidate) * 100);

                $result[] = [
                    'name' => $name,
                    'count' => $count,
                    'percentage' => $percentage,
                ];
            }

        return $result;
    }

    public function getCandidateEducationalData($modelClass, $column, $distinctColumn, $totalCandidateCount)
    {
        $educations = EducationalLevel::where('company_id',Auth::user()->company_id)->orderBy('id','desc')->limit(10)->get();
        $educationNames = $educations->pluck('name')->toArray();

        $educationCounts = [];

        foreach ($educations as $education) {
            $educationId = $education->id;

            $educationCount = $modelClass::select(DB::raw('count(DISTINCT candidate_id) as candidate_count'))
            ->join('candidates', 'candidates.id', '=', 'candidate_educational_details.candidate_id')
            ->where('candidates.company_id', '=', Auth::user()->company_id)
            ->where('candidate_educational_details.educational_level_id', '=', $educationId)
            ->first();


            if ($educationCount) {
                $educationCounts[] = $educationCount->candidate_count;
            } else {
                $educationCounts[] = 0;
            }
        }
        $data = $educationCounts;
        $counts = [
            'name' => $educationNames,
            'data' => $data,
        ];

        $result = [];
        $totalCandidate = $totalCandidateCount;

            foreach ($counts['name'] as $index => $name) {
                $count = isset($counts['data'][$index]) ? $counts['data'][$index] : 0;
                $totalCandidate = ($totalCandidate > 0) ? $totalCandidate : 1;
                $percentage = round(($count / $totalCandidate) * 100);

                $result[] = [
                    'name' => $name,
                    'count' => $count,
                    'percentage' => $percentage,
                ];
            }

        return $result;
    }

    private function calculatePercentages($counts) {
        $result = [];
        $total = array_sum($counts);
        foreach ($counts as $count) {
            $percentage = $total > 0 ? round(($count * 100) / $total) : 0;
            $result[] = $percentage;
        }

        return $result;
    }

    private function calculateCandidateCountsByExperience($candidates)
    {
        $experienceRanges = [
            '1-15' => [1, 15],
            '16-30' => [16, 30],
            '30+' => [31, null],
        ];

        $candidates1to15 = [];
        $candidates16to30 = [];
        $candidates30plus = [];

        foreach ($candidates as $candidate) {
            $totalExperience = $candidate->total_experience;

            foreach ($experienceRanges as $rangeLabel => $range) {
                [$minExperience, $maxExperience] = $range;

                if ($maxExperience === null) {
                    if ($totalExperience >= $minExperience) {
                        $candidates30plus[] = $candidate;
                        break;
                    }
                } elseif ($totalExperience >= $minExperience && $totalExperience <= $maxExperience) {
                    $minExperience <= 15 ? $candidates1to15[] = $candidate : $candidates16to30[] = $candidate;
                    break;
                }
            }
        }

        $count1to15 = count($candidates1to15);
        $count16to30 = count($candidates16to30);
        $count30plus = count($candidates30plus);

        $percentage1to15 = ($count1to15 > 0) ? round(($count1to15 / count($candidates)) * 100) : 0;
        $percentage16to30 = ($count16to30 > 0) ? round(($count16to30 / count($candidates)) * 100) : 0;
        $percentage30plus = ($count30plus > 0) ? round(($count30plus / count($candidates)) * 100) : 0;

        return [
            'start' => [
                'count' => $count1to15,
                'percentage' => $percentage1to15,
            ],
            'middle' => [
                'count' => $count16to30,
                'percentage' => $percentage16to30,
            ],
            'end' => [
                'count' => $count30plus,
                'percentage' => $percentage30plus,
            ],
        ];

    }

    private function calculateCandidateCountsByAge($candidates)
    {
        $ageRanges = [
            '25-40' => [25, 40],
            '41-60' => [41, 60],
            '60+' => [61, null],
        ];

        $candidates25to40 = [];
        $candidates41to60 = [];
        $candidates60plus = [];

        foreach ($candidates as $candidate) {
            $dob = $candidate->dob;
            $birthDate = Carbon::parse($dob);
            $currentDate = Carbon::now();
            $age = $currentDate->diffInYears($birthDate);

            foreach ($ageRanges as $rangeLabel => $range) {
                [$minAge, $maxAge] = $range;

                if ($maxAge === null) {
                    if ($age >= $minAge) {
                        $candidates60plus[] = $candidate;
                        break;
                    }
                } elseif ($age >= $minAge && $age <= $maxAge) {
                    if ($maxAge <= 40) {
                        $candidates25to40[] = $candidate;
                    } else {
                        $candidates41to60[] = $candidate;
                    }
                    break;
                }
            }
        }

        $count25to40 = count($candidates25to40);
        $count41to60 = count($candidates41to60);
        $count60plus = count($candidates60plus);

        $totalCandidates = count($candidates);

        $percentage25to40 = ($totalCandidates > 0) ? round(($count25to40 / $totalCandidates) * 100) : 0;
        $percentage41to60 = ($totalCandidates > 0) ? round(($count41to60 / $totalCandidates) * 100) : 0;
        $percentage60plus = ($totalCandidates > 0) ? round(($count60plus / $totalCandidates) * 100) : 0;

        return [
            '25-40' => [
                'count' => $count25to40,
                'percentage' => $percentage25to40,
            ],
            '41-60' => [
                'count' => $count41to60,
                'percentage' => $percentage41to60,
            ],
            '60+' => [
                'count' => $count60plus,
                'percentage' => $percentage60plus,
            ],
        ];
    }
    public function getChartData(Request $request)
    {
        $sectors = Sector::where('company_id',Auth::user()->company_id)->get();
        $sectorNames = $sectors->pluck('name')->toArray();

        $sectorCounts = [];

        foreach ($sectors as $sector) {
            $sectorId = $sector->id;

            $sectorCount = CandidateProject::select(\DB::raw('count(DISTINCT candidate_id) as candidate_count'))
                ->join('candidates', 'candidates.id', '=', 'candidate_projects.candidate_id')
                ->where('candidates.company_id', '=', Auth::user()->company_id)
                ->where('candidate_projects.sector_id', '=', $sectorId)
                ->first();
            if ($sectorCount) {
                $sectorCounts[] = $sectorCount->candidate_count;
            } else {
                $sectorCounts[] = 0;
            }
        }

        $data = $sectorCounts;

        $response = [
            'labels' => $sectorNames,
            'data' => $data,
        ];

        return response()->json($response);
    }

    public function getSubjectData(Request $request)
    {
        $subjects = Subject::where('company_id',Auth::user()->company_id)->get();
        $subjectNames = $subjects->pluck('name')->toArray();

        $subjectCounts = [];

        foreach ($subjects as $subject) {
            $subjectId = $subject->id;

            $subjectCount = CandidateEducationalDetail::select(\DB::raw('count(DISTINCT candidate_id) as candidate_count'))
                ->join('candidates', 'candidates.id', '=', 'candidate_educational_details.candidate_id')
                ->where('candidates.company_id', '=', Auth::user()->company_id)
                ->where('candidate_educational_details.subject_id', '=', $subjectId)
                ->first();

            if ($subjectCount) {
                $subjectCounts[] = $subjectCount->candidate_count;
            } else {
                $subjectCounts[] = 0;
            }
        }
        $data = $subjectCounts;
        $response = [
            'name' => $subjectNames,
            'data' => $data,
        ];
        return response()->json($response);
    }
}
