<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Specialization;

class SubjectController
{
    use ApiResponse;

    // API to get all specializations (id, name, image)
    public function getSpecializations()
    {
        try {
            $specializations = Specialization::all();
            $data = $specializations->map(function ($sp) {
                return [
                    'id'    => $sp->id,
                    'name'  => $sp->name,
                    'image' => $sp->image,
                ];
            });
            return $this->successResponse(['data' => $data]);
        } catch (\Exception $e) {
            return $this->errorResponse('Error fetching specializations.');
        }
    }

    // API to get specialization details with levels & subjects
    public function getSpecializationLevels(Request $request, $specializationId)
    {
        try {
            $specialization = Specialization::with(['levels.subjects.professor'])->find($specializationId);
            if (!$specialization) {
                return $this->errorResponse('Specialization not found.');
            }
            $levels = $specialization->levels->map(function ($level) {
                return [
                    'id'       => $level->id,
                    'name'     => $level->name,
                    'subjects' => $level->subjects->map(function ($subject) {
                        return [
                            'id'       => $subject->id,
                            'name'     => $subject->name,
                            'image'    => $subject->image,
                            'semester' => $subject->subject_semester,
                            'professor' => [
                                'id'            => $subject->professor->id,
                                'name'          => $subject->professor->name,
                                'profile_image' =>  $subject->professor->hasMedia('profile_picture') ? $subject->professor->getFirstMediaUrl('profile_picture') : null,
                            ],
                        ];
                    }),
                ];
            });
            $data = [
                'id'     => $specialization->id,
                'name'   => $specialization->name,
                'image'  => $specialization->image,
                'levels' => $levels,
            ];
            return $this->successResponse(["data" => $data]);
        } catch (\Exception $e) {
            return $this->errorResponse('Error fetching specialization levels.');
        }
    }
}
