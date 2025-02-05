<?php

namespace App\Http\Controllers;

use App\Models\EventAnnouncement;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class EventAnnouncementController
{
    use ApiResponse;

    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 10);
            $eventsPaginated = EventAnnouncement::paginate($perPage);
            $mapped = $eventsPaginated->getCollection()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title,
                    'description' => $item->description,
                    'location' => $item->location,
                    'date' => $item->date,
                    'image' => $item->image,
                ];
            });
            $eventsPaginated->setCollection($mapped);
            return $this->successResponse($eventsPaginated->toArray());
        } catch (\Exception $e) {
            return $this->errorResponse('Erreur lors de la récupération des événements');
        }
    }

    public function show($id)
    {
        try {
            $event = EventAnnouncement::findOrFail($id);
            return $this->successResponse([
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'location' => $event->location,
                'date' => $event->date,
                'content' => $event->content,
                'image' => $event->image,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse('Événement non trouvé');
        }
    }
}
