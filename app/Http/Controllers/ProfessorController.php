<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use App\Models\Video;
use App\Models\Publication;
use App\Models\Article;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Constants\Countries;

class ProfessorController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $professorsPaginated = Professor::paginate($perPage);
            $mapped = $professorsPaginated->getCollection()->map(function ($professor) {
                return [
                    'id' => $professor->id,
                    'name' => $professor->name,
                    'email' => $professor->email,
                    'profile_picture' => $professor->profile_picture,
                    'bio' => $professor->bio,
                ];
            });
            $professorsPaginated->setCollection($mapped);
            return $this->successResponse($professorsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des professeurs');
        }
    }

    public function show($id)
    {
        try {
            $professor = Professor::findOrFail($id);

            // Transform activities to include formatted country data
            $activities = collect($professor->activities)->map(function ($activity) {
                $countryCode = str_pad($activity['country'], 3, '0', STR_PAD_LEFT);
                // Convert the activity country to string after removing leading zeros
                $countryNumber = (string)(int)$activity['country'];

                return [
                    'title' => $activity['title'],
                    'country' => [
                        $countryNumber => [
                            'id' => $countryCode,
                            'name' => Countries::COUNTRIES[$countryCode] ?? 'Unknown',
                            'info' => $activity['description']
                        ]
                    ],
                    'description' => $activity['description']
                ];
            });

            $data = [
                'id' => $professor->id,
                'name' => $professor->name,
                'email' => $professor->email,
                'profile_picture' => $professor->profile_picture,
                'cv_url' => $professor->cv_url,
                'profile_headline' => $professor->profile_headline,
                'profile_details' => $professor->profile_details,
                'bio' => $professor->bio,
                'social_media' => $professor->social_media,
                'education' => $professor->education,
                'experience' => $professor->experience,
                'skills' => $professor->skills,
                'activities' => $activities,
            ];
            return $this->successResponse(["data" => $data]);
        } catch (\Exception $e) {
            return $this->errorResponse('Professeur non trouvé');
        }
    }

    public function videos($id, Request $request)
    {
        try {
            if (!Professor::find($id)) {
                return $this->errorResponse('Professeur non trouvé');
            }

            $perPage = $request->query('per_page', 10);
            $videosPaginated = Video::where('professor_id', $id)->paginate($perPage);
            $mapped = $videosPaginated->getCollection()->map(function ($video) {
                return [
                    'id' => $video->id,
                    'title' => $video->title,
                    'description' => $video->description,
                    'url' => $video->url,
                    'thumbnail' => $video->thumbnail,
                ];
            });
            $videosPaginated->setCollection($mapped);
            return $this->successResponse($videosPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des vidéos');
        }
    }

    public function publications($id, Request $request)
    {
        try {
            if (!Professor::find($id)) {
                return $this->errorResponse('Professeur non trouvé');
            }

            $perPage = $request->query('per_page', 10);
            $publicationsPaginated = Publication::where('professor_id', $id)->paginate($perPage);
            $mapped = $publicationsPaginated->getCollection()->map(function ($publication) {
                return [
                    'id' => $publication->id,
                    'title' => $publication->title,
                    'description' => $publication->description,
                    'type' => $publication->type,
                    'pdf_url' => $publication->pdf,
                ];
            });
            $publicationsPaginated->setCollection($mapped);
            return $this->successResponse($publicationsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des publications');
        }
    }

    public function articles($id, Request $request)
    {
        try {
            if (!Professor::find($id)) {
                return $this->errorResponse('Professeur non trouvé');
            }

            $perPage = $request->query('per_page', 10);
            $articlesPaginated = Article::where('professor_id', $id)->paginate($perPage);
            $mapped = $articlesPaginated->getCollection()->map(function ($article) {
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'created_at' => $article->created_at,
                ];
            });
            $articlesPaginated->setCollection($mapped);
            return $this->successResponse($articlesPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des articles');
        }
    }
}
