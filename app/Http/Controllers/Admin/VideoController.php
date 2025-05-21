<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Models\Series;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    private function convertDuration($isoDuration)
    {
        preg_match('/PT(?:(\d+)H)?(?:(\d+)M)?(?:(\d+)S)?/', $isoDuration, $matches);

        $hours = isset($matches[1]) ? (int) $matches[1] : 0;
        $minutes = isset($matches[2]) ? (int) $matches[2] : 0;
        $seconds = isset($matches[3]) ? (int) $matches[3] : 0;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

    public function create($slug)
    {
        // get series by slug
        $series = Series::where('slug', $slug)->first();

        // return view with series
        return view('admin.video.create', compact('series'));
    }

    public function store(Request $request, $slug)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        if (!$apiKey) {
            Log::error('YouTube API Key is missing.');
            return response()->json(['error' => 'YouTube API Key not found'], 500);
        }

        $url = "https://www.googleapis.com/youtube/v3/videos?id={$request->video_code}&part=contentDetails&key={$apiKey}";
        $response = Http::get($url);
        $data = $response->json();

        // Ambil durasi dari response JSON
        $isoDuration = $data['items'][0]['contentDetails']['duration'];

        // Konversi ke format HH:MM:SS
        $formattedDuration = $this->convertDuration($isoDuration);

        // get series by slug
        $series = Series::where('slug', $slug)->first();

        // create new video by series
        $series->videos()->create([
            'name' => $request->name,
            'video_code' => $request->video_code,
            'episode' => $request->episode,
            'duration' => $formattedDuration,
            'intro' => $request->intro ? 1 : 0
        ]);

        // return redirect with toastr
        return redirect(route('admin.series.show', $series->slug))->with('toast_success', 'Video created successfully ');
    }

    public function edit($slug, $video_code)
    {
        // get series by slug
        $series = Series::where('slug', $slug)->first();

        // get video by video_code
        $video = Video::where('video_code', $video_code)->first();

        // return view with series and video
        return view('admin.video.edit', compact('series', 'video'));
    }

    public function update(Request $request, $slug, $video_code)
    {
        $apiKey = env('YOUTUBE_API_KEY');
        if (!$apiKey) {
            Log::error('YouTube API Key is missing.');
            return response()->json(['error' => 'YouTube API Key not found'], 500);
        }

        $url = "https://www.googleapis.com/youtube/v3/videos?id={$request->video_code}&part=contentDetails&key={$apiKey}";
        $response = Http::get($url);
        $data = $response->json();

        // Ambil durasi dari response JSON
        $isoDuration = $data['items'][0]['contentDetails']['duration'];

        // Konversi ke format HH:MM:SS
        $formattedDuration = $this->convertDuration($isoDuration);
        // get series by slug
        $series = Series::where('slug', $slug)->first();

        // get video by video_code
        $video = Video::where('video_code', $video_code)->first();

        $video->update([
            'name' => $request->name,
            'video_code' => $request->video_code,
            'episode' => $request->episode,
            'duration' => $formattedDuration,
            'intro' => $request->intro ? 1 : 0
        ]);

        // return view with series and video
        return redirect(route('admin.series.show', $series->slug))->with('toast_success', 'Video updated successfully ');
    }

    public function destroy(video $video)
    {
        $msg = "video";
        if(str_contains($video->video_code, 'documents') && Storage::exists($video->video_code)){
            Storage::delete($video->video_code);
            $msg = "document";
        }
        // delete video by id
        $video->delete();

        // redirect back with toastr
        return back()->with('toast_success', $msg .' deleted successfully');
    }
}
