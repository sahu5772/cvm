<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
class FormateController extends Controller
{
    public function formate($id, $formate)
    {
        $candidate = Candidate::whereId($id)->with(
                'designation',
                'department',
                'language',
                'educationalDetail',
                'educationalDetail.educationLevel',
                'educationalDetail.university',
                'training',
                'membership',
                'country',
                'project',
                'project.country',
                'project.designation',
                'getKeywordRecord',
                'workExperience',
                'workExperience.designation',
                'workExperience.country',
            )->first();

        if($candidate->workExperience->count() > 0)
        {
            $workExperience = $candidate->workExperience->whereNull('to_date')->first();
            $currentFirmName = ($workExperience) ?  $workExperience->company_name : 'Currently Not working';
        }
        else
        {
            $currentFirmName = 'Fresher';
        }

        $name = (($candidate->first_name) ? ucwords($candidate->first_name) . ' ' . ucfirst($candidate->last_name) : 'NA');
        $designation = ($candidate->designation_id) ? ucwords($candidate->designation->name) : 'NA';
        $dob = ($candidate->dob) ? ucwords($candidate->dob) : 'NA';
        $nationality = ($candidate->country_id) ? ucwords($candidate->country->name) : 'NA';

        if($formate == '1'){
            $templateProcessor = new TemplateProcessor(storage_path('templates/5.docx'));
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('firm', $currentFirmName);
            $templateProcessor->setValue('designation', $designation);
            $templateProcessor->setValue('dob', $dob);
            $templateProcessor->setValue('nationality', $nationality);
            $templateProcessor->setValue('language', $candidate->language->name);
            $templateProcessor->setValue('nameSignature', $name);
            $templateProcessor->setValue('position', $designation);

            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('education', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('sno#' . $i,  $i);
                    $templateProcessor->setValue('education#' . $i, $value->educationLevel->name);
                    $templateProcessor->setValue('university#' . $i, $value->university->name);
                    $templateProcessor->setValue('passOutYear#' . $i, $value->to_year);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('education_block', '');
                $templateProcessor->setValue('/education_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('education_block', 0, true, true);
            }

            if (count($candidate->workExperience) > 0) {
                $templateProcessor->cloneBlock('professional_data_block', count($candidate->workExperience), true, true);
                $i = 1;
                foreach ($candidate->workExperience as $key => $value) {
                    $templateProcessor->setValue('from#' . $i, ($value->from_date . '/' . $value->to_date));
                    $templateProcessor->setValue('employer#' . $i, 'q');
                    $templateProcessor->setValue('jobPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('jobLocation#' . $i, $value->country->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('professional_block', '');
                $templateProcessor->setValue('/professional_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('professional_block', 0, true, true);
            }

            if (count($candidate->project) > 0) {
                $templateProcessor->cloneRow('srNo', count($candidate->project));
                $i = 1;
                foreach ($candidate->project as $key => $value) {
                    $templateProcessor->setValue('srNo#' . $i,  $i);
                    $templateProcessor->setValue('startDate#' . $i, $value->from);
                    $templateProcessor->setValue('endDate#' . $i, $value->to);
                    $templateProcessor->setValue('projectPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('organizationReferences#' . $i, $value->to);
                    $templateProcessor->setValue('nationality#' . $i, $value->country->name);
                    $templateProcessor->setValue('projectName#' . $i, $value->name);
                    $templateProcessor->setValue('projectDesignation#' . $i, $value->designation->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('project_block', '');
                $templateProcessor->setValue('/project_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('project_block', 0, true, true);
            }


            $fileTitle = 'firstFormate-' . str_replace(' ', '-', ($candidate->first_name != '' ? $candidate->first_name : '') . ' ' . $candidate->id);
            $templateProcessor->saveAs(storage_path('candidate-data/' . $fileTitle . '.docx'));
            return response()->download(storage_path('candidate-data/' . $fileTitle . '.docx'))->deleteFileAfterSend(true);
        }
        elseif($formate == '2'){
            $templateProcessor = new TemplateProcessor(storage_path('templates/Asset Information Manager_Sunil Kumar.docx'));
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('firm', $currentFirmName);
            $templateProcessor->setValue('designation', $designation);
            $templateProcessor->setValue('dob', $dob);
            $templateProcessor->setValue('nationality', $nationality);
            $templateProcessor->setValue('language', $candidate->language->name);
            $templateProcessor->setValue('nameSignature', $name);
            $templateProcessor->setValue('position', $designation);

            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('keyQulificationEducation', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('keyQulificationEducation#' . $i, $value->educationLevel->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('key_block', '');
                $templateProcessor->setValue('/key_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('key_block', 0, true, true);
            }
            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('education', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('sno#' . $i,  $i);
                    $templateProcessor->setValue('education#' . $i, $value->educationLevel->name);
                    $templateProcessor->setValue('university#' . $i, $value->university->name);
                    $templateProcessor->setValue('passOutYear#' . $i, $value->to_year);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('education_block', '');
                $templateProcessor->setValue('/education_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('education_block', 0, true, true);
            }

            if (count($candidate->project) > 0) {
                $templateProcessor->cloneRow('projectName', count($candidate->project));
                // dd('hello');
                $i = 1;
                foreach ($candidate->project as $key => $value) {
                    $templateProcessor->setValue('srNo#' . $i,  $i);
                    $templateProcessor->setValue('startDate#' . $i, $value->from);
                    $templateProcessor->setValue('endDate#' . $i, $value->to);
                    $templateProcessor->setValue('projectPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('organizationReferences#' . $i, $value->to);
                    $templateProcessor->setValue('nationality#' . $i, $value->country->name);
                    $templateProcessor->setValue('projectName#' . $i, $value->name);
                    $templateProcessor->setValue('projectDesignation#' . $i, $value->designation->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('project_block', '');
                $templateProcessor->setValue('/project_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('project_block', 0, true, true);
            }

            $fileTitle = 'firstFormate-' . str_replace(' ', '-', ($candidate->first_name != '' ? $candidate->first_name : '') . ' ' . $candidate->id);
            $templateProcessor->saveAs(storage_path('candidate-data/' . $fileTitle . '.docx'));
            return response()->download(storage_path('candidate-data/' . $fileTitle . '.docx'))->deleteFileAfterSend(true);
        }
        elseif($formate == '3'){
            $templateProcessor = new TemplateProcessor(storage_path('templates/A V  Nageswararao _Formatted.docx'));
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('firm', $currentFirmName);
            $templateProcessor->setValue('designation', $designation);
            $templateProcessor->setValue('dob', $dob);
            $templateProcessor->setValue('nationality', $nationality);
            $templateProcessor->setValue('language', $candidate->language->name);
            $templateProcessor->setValue('nameSignature', $name);
            $templateProcessor->setValue('position', $designation);

            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('education', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('sno#' . $i,  $i);
                    $templateProcessor->setValue('education#' . $i, $value->educationLevel->name);
                    $templateProcessor->setValue('university#' . $i, $value->university->name);
                    $templateProcessor->setValue('passOutYear#' . $i, $value->to_year);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('education_block', '');
                $templateProcessor->setValue('/education_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('education_block', 0, true, true);
            }

            if (count($candidate->membership) > 0) {
                $templateProcessor->cloneRow('membership', count($candidate->membership));
                $i = 1;
                foreach ($candidate->membership as $key => $value) {
                    $templateProcessor->setValue('membership#' . $i, $value->membership->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('membership_block', '');
                $templateProcessor->setValue('/membership_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('membership_block', 0, true, true);
            }

            if (count($candidate->workExperience) > 0) {
                $templateProcessor->cloneBlock('professional_data__block', count($candidate->workExperience), true, true);
                $i = 1;
                foreach ($candidate->workExperience as $key => $value) {
                    $templateProcessor->setValue('from#' . $i, ($value->from_date . '/' . $value->to_date));
                    $templateProcessor->setValue('employer#' . $i, 'q');
                    $templateProcessor->setValue('jobPosition#' . $i, $value->designation->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('professional_block', '');
                $templateProcessor->setValue('/professional_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('professional_block', 0, true, true);
            }

            if (count($candidate->project) > 0) {
                $templateProcessor->cloneRow('srNo', count($candidate->project));
                $i = 1;
                foreach ($candidate->project as $key => $value) {
                    $templateProcessor->setValue('srNo#' . $i,  $i);
                    $templateProcessor->setValue('startDate#' . $i, $value->from);
                    $templateProcessor->setValue('endDate#' . $i, $value->to);
                    $templateProcessor->setValue('projectPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('organizationReferences#' . $i, $value->to);
                    $templateProcessor->setValue('nationality#' . $i, $value->country->name);
                    $templateProcessor->setValue('projectName#' . $i, $value->name);
                    $templateProcessor->setValue('projectDesignation#' . $i, $value->designation->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('project_block', '');
                $templateProcessor->setValue('/project_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('project_block', 0, true, true);
            }


            $fileTitle = 'firstFormate-' . str_replace(' ', '-', ($candidate->first_name != '' ? $candidate->first_name : '') . ' ' . $candidate->id);
            $templateProcessor->saveAs(storage_path('candidate-data/' . $fileTitle . '.docx'));
            return response()->download(storage_path('candidate-data/' . $fileTitle . '.docx'))->deleteFileAfterSend(true);
        }
        elseif($formate == '4'){
            $templateProcessor = new TemplateProcessor(storage_path('templates/Bhullar Sitaram Pal_Formatted CV.docx'));
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('firm', $currentFirmName);
            $templateProcessor->setValue('designation', $designation);
            $templateProcessor->setValue('dob', $dob);
            $templateProcessor->setValue('nationality', $nationality);
            $templateProcessor->setValue('language', $candidate->language->name);
            $templateProcessor->setValue('nameSignature', $name);
            $templateProcessor->setValue('position', $designation);

            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('education', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('sno#' . $i,  $i);
                    $templateProcessor->setValue('education#' . $i, $value->educationLevel->name);
                    $templateProcessor->setValue('university#' . $i, $value->university->name);
                    $templateProcessor->setValue('passOutYear#' . $i, $value->to_year);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('education_block', '');
                $templateProcessor->setValue('/education_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('education_block', 0, true, true);
            }

            if (count($candidate->workExperience) > 0) {
                // dd(count($candidate->workExperience));
                $templateProcessor->cloneBlock('professional_data_block', count($candidate->workExperience), true, true);
                $i = 1;
                foreach ($candidate->workExperience as $key => $value) {
                    $templateProcessor->setValue('from#' . $i, ($value->from_date . '/' . $value->to_date));
                    $templateProcessor->setValue('employer#' . $i, 'q');
                    $templateProcessor->setValue('organizationReferences#' . $i, 'reference');
                    $templateProcessor->setValue('referencePosition#' . $i, 'reference Position');
                    $templateProcessor->setValue('referenceMobileNumber#' . $i, '123456789');
                    $templateProcessor->setValue('referenceEmail#' . $i, 'referenceEmail@gmail.com');
                    $templateProcessor->setValue('jobPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('jobLocation#' . $i, $value->country->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('professional_block', '');
                $templateProcessor->setValue('/professional_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('professional_block', 0, true, true);
            }

            if (count($candidate->project) > 0) {
                $templateProcessor->cloneBlock('project_block', count($candidate->project), true, true);
                $i = 1;

                foreach ($candidate->project as $key => $value) {
                    $templateProcessor->setValue('startDate#' . $i, $value->from);
                    $templateProcessor->setValue('endDate#' . $i, $value->to);
                    $templateProcessor->setValue('projectPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('projectName#' . $i, 'project name');
                    $templateProcessor->setValue('projectClient#' . $i, 'project client');
                    $templateProcessor->setValue('projectFeature#' . $i, 'project feature');
                    $templateProcessor->setValue('projectLocation#' . $i, $value->country->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('project_block', '');
                $templateProcessor->setValue('/project_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('project_block', 0, true, true);
            }


            $fileTitle = 'firstFormate-' . str_replace(' ', '-', ($candidate->first_name != '' ? $candidate->first_name : '') . ' ' . $candidate->id);
            $templateProcessor->saveAs(storage_path('candidate-data/' . $fileTitle . '.docx'));
            return response()->download(storage_path('candidate-data/' . $fileTitle . '.docx'))->deleteFileAfterSend(true);
        }
        elseif($formate == '5'){
            $templateProcessor = new TemplateProcessor(storage_path('templates/Bhupendra Singh Chittoria_Final CV.docx'));
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('firm', $currentFirmName);
            $templateProcessor->setValue('designation', $designation);
            $templateProcessor->setValue('dob', $dob);
            $templateProcessor->setValue('nationality', $nationality);
            $templateProcessor->setValue('language', $candidate->language->name);
            $templateProcessor->setValue('nameSignature', $name);
            $templateProcessor->setValue('position', $designation);

            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('education', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('sno#' . $i,  $i);
                    $templateProcessor->setValue('education#' . $i, $value->educationLevel->name);
                    $templateProcessor->setValue('university#' . $i, $value->university->name);
                    $templateProcessor->setValue('passOutYear#' . $i, $value->to_year);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('education_block', '');
                $templateProcessor->setValue('/education_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('education_block', 0, true, true);
            }

            if (count($candidate->membership) > 0) {
                $templateProcessor->cloneRow('membership', count($candidate->membership));
                $i = 1;
                foreach ($candidate->membership as $key => $value) {
                    $templateProcessor->setValue('membership#' . $i, $value->membership->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('membership_block', '');
                $templateProcessor->setValue('/membership_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('membership_block', 0, true, true);
            }

            if (count($candidate->workExperience) > 0) {
                $templateProcessor->cloneRow('workExperienceCountries', count($candidate->workExperience));
                $i = 1;
                foreach ($candidate->workExperience as $key => $value) {
                    $templateProcessor->setValue('workExperienceCountries#' . $i, $value->country->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('work_country_block', '');
                $templateProcessor->setValue('/work_country_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('work_country_block', 0, true, true);
            }

            // if (count($candidate->workExperience) > 0) {
            //     $templateProcessor->cloneRow('employer', count($candidate->workExperience));
            //     $i = 1;
            //     foreach ($candidate->workExperience as $key => $value) {
            //         // dump( $value->from_date,$value->to_date,$value->designation->name);
            //         $templateProcessor->setValue('professionStart#' . $i, $value->from_date);
            //         $templateProcessor->setValue('professionEnd#' . $i, $value->to_date);
            //         $templateProcessor->setValue('employer#' . $i, (($value->designation->name)?$value->designation->name:'dsd'));
            //         $templateProcessor->setValue('jobPosition#' . $i, (($value->designation->name)?$value->designation->name:'dsd'));
            //         $i++;
            //     }
            //     //remove block name
            //     $templateProcessor->setValue('work_experience_block', '');
            //     $templateProcessor->setValue('/work_experience_block', '');
            // }
            // else
            // {
            //     //Delete Block
            //     $templateProcessor->cloneBlock('work_experience_block', 0, true, true);
            // }
            // dd();
            if (count($candidate->project) > 0) {
                $templateProcessor->cloneRow('projectName', count($candidate->project));
                $i = 1;
                foreach ($candidate->project as $key => $value) {
                    $templateProcessor->setValue('projectName#' . $i, $value->name);
                    $templateProcessor->setValue('startDate#' . $i, $value->from);
                    $templateProcessor->setValue('endDate#' . $i, $value->to);
                    $templateProcessor->setValue('nationality#' . $i, $value->country->name);
                    $templateProcessor->setValue('projectEmployer#' . $i, 'project employer');
                    $templateProcessor->setValue('projectFeature#' . $i, 'project feature');
                    $templateProcessor->setValue('projectPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('activities#' . $i, $value->to);
                    $templateProcessor->setValue('projectCost#' . $i, '101');
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('project_block', '');
                $templateProcessor->setValue('/project_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('project_block', 0, true, true);
            }


            $fileTitle = 'firstFormate-' . str_replace(' ', '-', ($candidate->first_name != '' ? $candidate->first_name : '') . ' ' . $candidate->id);
            $templateProcessor->saveAs(storage_path('candidate-data/' . $fileTitle . '.docx'));
            return response()->download(storage_path('candidate-data/' . $fileTitle . '.docx'))->deleteFileAfterSend(true);
        }
        elseif($formate == '6'){
            $templateProcessor = new TemplateProcessor(storage_path('templates/Bhupendra Singh Chittoria_Final CV.docx'));
            $templateProcessor->setValue('name', $name);
            $templateProcessor->setValue('firm', $currentFirmName);
            $templateProcessor->setValue('designation', $designation);
            $templateProcessor->setValue('dob', $dob);
            $templateProcessor->setValue('nationality', $nationality);
            $templateProcessor->setValue('language', $candidate->language->name);
            $templateProcessor->setValue('nameSignature', $name);
            $templateProcessor->setValue('position', $designation);

            if (count($candidate->educationalDetail) > 0) {
                $templateProcessor->cloneRow('education', count($candidate->educationalDetail));
                $i = 1;
                foreach ($candidate->educationalDetail as $key => $value) {
                    $templateProcessor->setValue('sno#' . $i,  $i);
                    $templateProcessor->setValue('education#' . $i, $value->educationLevel->name);
                    $templateProcessor->setValue('university#' . $i, $value->university->name);
                    $templateProcessor->setValue('passOutYear#' . $i, $value->to_year);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('education_block', '');
                $templateProcessor->setValue('/education_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('education_block', 0, true, true);
            }

            if (count($candidate->membership) > 0) {
                $templateProcessor->cloneRow('membership', count($candidate->membership));
                $i = 1;
                foreach ($candidate->membership as $key => $value) {
                    $templateProcessor->setValue('membership#' . $i, $value->membership->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('membership_block', '');
                $templateProcessor->setValue('/membership_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('membership_block', 0, true, true);
            }

            if (count($candidate->workExperience) > 0) {
                $templateProcessor->cloneRow('workExperienceCountries', count($candidate->workExperience));
                $i = 1;
                foreach ($candidate->workExperience as $key => $value) {
                    $templateProcessor->setValue('workExperienceCountries#' . $i, $value->country->name);
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('work_country_block', '');
                $templateProcessor->setValue('/work_country_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('work_country_block', 0, true, true);
            }


            if (count($candidate->project) > 0) {
                $templateProcessor->cloneRow('projectName', count($candidate->project));
                $i = 1;
                foreach ($candidate->project as $key => $value) {
                    $templateProcessor->setValue('projectName#' . $i, $value->name);
                    $templateProcessor->setValue('startDate#' . $i, $value->from);
                    $templateProcessor->setValue('endDate#' . $i, $value->to);
                    $templateProcessor->setValue('nationality#' . $i, $value->country->name);
                    $templateProcessor->setValue('projectEmployer#' . $i, 'project employer');
                    $templateProcessor->setValue('projectFeature#' . $i, 'project feature');
                    $templateProcessor->setValue('projectPosition#' . $i, $value->designation->name);
                    $templateProcessor->setValue('activities#' . $i, $value->to);
                    $templateProcessor->setValue('projectCost#' . $i, '101');
                    $i++;
                }
                //remove block name
                $templateProcessor->setValue('project_block', '');
                $templateProcessor->setValue('/project_block', '');
            }
            else
            {
                //Delete Block
                $templateProcessor->cloneBlock('project_block', 0, true, true);
            }


            $fileTitle = 'firstFormate-' . str_replace(' ', '-', ($candidate->first_name != '' ? $candidate->first_name : '') . ' ' . $candidate->id);
            $templateProcessor->saveAs(storage_path('candidate-data/' . $fileTitle . '.docx'));
            return response()->download(storage_path('candidate-data/' . $fileTitle . '.docx'))->deleteFileAfterSend(true);
        }

    }
}
