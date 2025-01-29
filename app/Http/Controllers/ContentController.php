<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\News;
use App\Models\Professor;
use App\Models\Sponsor;
use App\Models\Publication;
use App\Models\Video;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    use ApiResponse;

    /**
     * Display a listing of news items.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNews()
    {
        try {
            $news = News::all()->map(function ($news) {
                return [
                    'id' => $news->id,
                    'title' => $news->title,
                    'description' => $news->description,
                    'content' => $news->content,
                    'cover_image' => $news->cover_image,
                ];
            });
            return $this->successResponse($news);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des actualités');
        }
    }

    /**
     * Display a listing of clubs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClubs()
    {
        try {
            $clubs = Club::all()->map(function ($club) {
                return [
                    'id' => $club->id,
                    'name' => $club->name,
                    'description' => $club->description,
                    'logo' => $club->logo,
                    'website_url' => $club->website_url,
                    'social_media_links' => $club->social_media_links,
                ];
            });
            return $this->successResponse($clubs);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des clubs');
        }
    }

    /**
     * Display a listing of sponsors.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSponsors()
    {
        try {
            $sponsors = Sponsor::all()->map(function ($sponsor) {
                return [
                    'id' => $sponsor->id,
                    'name' => $sponsor->name,
                    'description' => $sponsor->description,
                    'url' => $sponsor->url,
                    'logo' => $sponsor->logo,
                ];
            });
            return $this->successResponse($sponsors);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des sponsors');
        }
    }

    /**
     * Display a listing of professors.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfessors()
    {
        try {
            $professors = Professor::all()->map(function ($professor) {
                return [
                    'id' => $professor->id,
                    'name' => $professor->name,
                    'email' => $professor->email,
                    'profile_picture' => $professor->profile_picture,
                    'bio' => $professor->bio,
                ];
            });
            return $this->successResponse($professors);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des professeurs');
        }
    }

    /**
     * Display a single professor with all details.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getSingleProfessor($id)
    {
        try {
            $professor = Professor::findOrFail($id);
            $data = [
                'id' => $professor->id,
                'name' => $professor->name,
                'email' => $professor->email,
                'profile_picture' => $professor->profile_picture,
                'cv_url' => $professor->cv_url,
                'bio' => $professor->bio,
                'social_media' => $professor->social_media,
                'education' => $professor->education,
                'experience' => $professor->experience,
                'skills' => $professor->skills,
            ];
            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Professeur non trouvé');
        }
    }

    /**
     * Display a paginated list of publications.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getPublications(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $publications = Publication::with('professor')
                ->paginate($perPage)
                ->through(function ($publication) {
                    return [
                        'id' => $publication->id,
                        'title' => $publication->title,
                        'description' => $publication->description,
                        'type' => $publication->type,
                        'professor' => [
                            'id' => $publication->professor->id,
                            'name' => $publication->professor->name,
                        ],
                        'pdf_url' => $publication->pdf,
                    ];
                });

            return $this->successResponse($publications, 'Publications récupérées avec succès');
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des publications');
        }
    }

    /**
     * Display a paginated list of videos.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function getVideos(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $videos = Video::with('professor')
                ->paginate($perPage)
                ->through(function ($video) {
                    return [
                        'id' => $video->id,
                        'title' => $video->title,
                        'description' => $video->description,
                        'url' => $video->url,
                        'thumbnail' => $video->thumbnail,
                        'professor' => [
                            'id' => $video->professor->id,
                            'name' => $video->professor->name,
                        ],
                    ];
                });

            return $this->successResponse($videos, 'Vidéos récupérées avec succès');
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des vidéos');
        }
    }
}
