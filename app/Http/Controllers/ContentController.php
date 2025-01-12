<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\News;
use App\Models\Professor;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    /**
     * Display a listing of news items.
     *
     * @return \Illuminate\Http\Response
     */
    public function getNews()
    {
        $news = News::all();
        return $news->map(function ($news) {
            return [
                'id' => $news->id,
                'title' => $news->title,
                'content' => $news->content,
                'cover_image' => $news->cover_image,
            ];
        });
    }

    /**
     * Display a listing of clubs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClubs()
    {
        $clubs = Club::all();
        return $clubs;
        return $clubs->map(function ($club) {
            return [
                'id' => $club->id,
                'name' => $club->name,
                'description' => $club->description,
                'logo' => $club->logo,
                'website_url' => $club->website_url,
                'social_media_links' => $club->social_media_links,
            ];
        });
    }

    /**
     * Display a listing of sponsors.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSponsors()
    {
        $sponsors = Sponsor::all();
        return $sponsors->map(function ($sponsor) {
            return [
                'id' => $sponsor->id,
                'name' => $sponsor->name,
                'url' => $sponsor->url,
                'logo' => $sponsor->logo, // Use the accessor to get the logo URL
            ];
        });
    }

    /**
     * Display a listing of professors.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfessors()
    {
        $professors = Professor::all();
        return $professors->map(function ($professor) {
            return [
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
        });
    }
}
