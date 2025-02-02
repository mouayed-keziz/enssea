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
use App\Settings\LandingPageContent;

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
            $newsPaginated = News::paginate();
            $mapped = $newsPaginated->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'content' => $item->content,
                    'cover_image' => $item->cover_image,
                ];
            });
            $newsPaginated->setCollection($mapped);
            return $this->successResponse($newsPaginated->toArray());
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
            $clubsPaginated = Club::paginate();
            $mapped = $clubsPaginated->getCollection()->map(function ($club) {
                return [
                    'id' => $club->id,
                    'name' => $club->name,
                    'description' => $club->description,
                    'logo' => $club->logo,
                    'website_url' => $club->website_url,
                    'social_media_links' => $club->social_media_links,
                ];
            });
            $clubsPaginated->setCollection($mapped);
            return $this->successResponse($clubsPaginated->toArray());
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
            $sponsorsPaginated = Sponsor::paginate();
            $mapped = $sponsorsPaginated->getCollection()->map(function ($sponsor) {
                return [
                    'id' => $sponsor->id,
                    'name' => $sponsor->name,
                    'description' => $sponsor->description,
                    'url' => $sponsor->url,
                    'logo' => $sponsor->logo,
                ];
            });
            $sponsorsPaginated->setCollection($mapped);
            return $this->successResponse($sponsorsPaginated->toArray());
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
            $professorsPaginated = Professor::paginate();
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
                'activities' => $professor->activities,
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
            $publicationsPaginated = Publication::with('professor')->paginate($perPage);
            $mapped = $publicationsPaginated->getCollection()->map(function ($publication) {
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
            $publicationsPaginated->setCollection($mapped);
            return $this->successResponse($publicationsPaginated->toArray());
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
            $videosPaginated = Video::with('professor')->paginate($perPage);
            $mapped = $videosPaginated->getCollection()->map(function ($video) {
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
            $videosPaginated->setCollection($mapped);
            return $this->successResponse($videosPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des vidéos');
        }
    }

    /**
     * Get landing page content and settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLandingPageContent()
    {
        try {
            $settings = app(LandingPageContent::class);

            $data = [
                'hero' => [
                    'header' => $settings->hero_header,
                    'description' => $settings->hero_description,
                ],
                'contact' => [
                    'phone' => $settings->phone,
                    'email' => $settings->email,
                    'location' => $settings->location,
                ],
                'social_media' => [
                    'facebook' => $settings->facebook_url,
                    'linkedin' => $settings->linkedin_url,
                    'instagram' => $settings->instagram_url,
                ],
                'about' => $settings->about_school,
            ];

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération du contenu de la page d\'accueil');
        }
    }
}
