<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use App\Models\Level;
use Illuminate\Http\Request;

class SubjectController
{
    use ApiResponse;

    public function index()
    {
        try {
            $levels = Level::with(['subjects.professor' => function($query) {
                $query->select('id', 'name', 'profile_image');
            }])->get();

            $data = [
                'status' => 'success',
                'data' => $levels->map(function ($level) {
                    return [
                        'id' => $level->id,
                        'name' => $level->name,
                        'subjects' => $level->subjects->map(function ($subject) {
                            return [
                                'id' => $subject->id,
                                'name' => $subject->name,
                                'image' => $subject->image,
                                "semester" => $subject->subject_semester,
                                'professor' => [
                                    'id' => $subject->professor->id,
                                    'name' => $subject->professor->name,
                                    'profile_image' => $subject->professor->profile_image
                                ]
                            ];
                        })
                    ];
                })
            ];
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des subjects');
        }
    }

    public function index2(Request $request)
    {
        try {
            // Retrieve paginated levels using query keys 'per_page' and 'page'
            $perPage = $request->query('per_page', 10);
            $page = $request->query('page', 1);
            $levels = Level::paginate($perPage, ['*'], 'page', $page);

            // Retrieve paginated subjects for each level using 'subjects_per_page' and 'subjects_page'
            $subjectsPerPage = $request->query('subjects_per_page', 5);
            $subjectsPage = $request->query('subjects_page', 1);

            $data = [
                'status' => 'success',
                'data' => $levels->getCollection()->map(function($level) use ($subjectsPerPage, $subjectsPage) {
                    $subjectsPaginated = $level->subjects()
                        ->select('id', 'name', 'image', 'subject_semester', 'professor_id')
                        ->with('professor:id,name,profile_image')
                        ->paginate($subjectsPerPage, ['*'], 'subjects_page', $subjectsPage);

                    // Transform subjects to return only required fields
                    $transformedSubjects = $subjectsPaginated->getCollection()->map(function ($subject) {
                        return [
                            'id' => $subject->id,
                            'name' => $subject->name,
                            'image' => $subject->image,
                            'semester' => $subject->subject_semester,
                            'professor' => [
                                'id' => $subject->professor->id,
                                'name' => $subject->professor->name,
                                'profile_image' => $subject->professor->profile_image
                            ]
                        ];
                    });
                    $subjectsPaginated->setCollection($transformedSubjects);

                    return [
                        'id' => $level->id,
                        'name' => $level->name,
                        'subjects' => $subjectsPaginated->toArray()
                    ];
                }),
                'current_page' => $levels->currentPage(),
                'per_page' => $levels->perPage(),
                'total' => $levels->total()
            ];

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des niveaux avec subjects paginés');
        }
    }
}
