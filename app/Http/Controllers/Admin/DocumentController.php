<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Series;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        // get series by slug
        $series = Series::where('slug', $slug)->first();
        return view('admin.document.create' , compact('series'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
        $request->validate([
            'document' => 'required',
        ]);
    
        // Cari series berdasarkan slug
        $series = Series::where('slug', $slug)->firstOrFail();
    
        // Simpan file ke storage
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/documents', $filename);
    
            // Simpan ke database
            Video::create([
                'series_id' => $series->id,
                'name' => $request->input('name'),
                'episode' => $request->input('number'),
                'intro' => $request->intro ? 1 : 0,
                'duration' => 0,            
                'slug' => Str::slug($request->input('name')),
                'video_code' => $path,
            ]);
    
            return redirect(route('admin.series.show', $series->slug))->with('toast_success', 'Document created successfully ');
        }
    
        return redirect(route('admin.series.show', $series->slug))->with('toast_error', 'Document failed to upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get series by slug
        $series = Video::where('id', $id)->first();
        return view('admin.document.edit' , compact('series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    
        // Cari data lama
        $data = Video::findOrFail($id);
    
        // Jika ada file baru diunggah
        if ($request->hasFile('document')) {
            // Hapus file lama jika ada
            if ($data->video_code && Storage::exists($data->video_code)) {
                Storage::delete($data->video_code);
            }
    
            // Simpan file baru di public/document
            $file = $request->file('document');
            $filename = time() . '_' . $file->getClientOriginalName();
            $newPath = $file->storeAs('public/documents', $filename);
    
            // Update path dengan file baru
            $data->video_code = $newPath;
        }
    
        // Update data lainnya
        $data->name = $request->name;
        $data->episode = $request->number;
        $data->intro = $request->intro ? 1 : 0;
        $data->save();
    
        return redirect(route('admin.series.show', $data->series->slug))->with('toast_success', 'Document successfully updated');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
