<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Alert;

use App\Models\Service;
use App\Models\AdvantageService;
use App\Models\Tagline;
use App\Models\AdvantageUser;
use App\Models\Order;
use App\Models\ThumbnailService;
use App\Models\User;

class ServiceController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $services = Service::where('users_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

    //return view
    return view('pages.dashboard.service.index', [
      'services' => $services
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // retrun view to create page
    return view('pages.dashboard.service.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StoreServiceRequest $request)
  {
    // Memanggil field yang sudah divalidasi pada file StoreServiceRequest
    $data = $request->all();
    // dd($data);
    // menambahakan array users_id pada variabel $data yang diambil menggunakan id saat user sedang login
    $data['users_id'] = Auth::user()->id;


    // add to service
    $service = Service::create($data);

    // add to advantage service 
    foreach ($data['advantage-service'] as $key => $value) {
      $advantage_service = new AdvantageService;
      $advantage_service->service_id = $service->id;
      $advantage_service->advantage = $value;
      $advantage_service->save();
    }

    // add to advantage user
    foreach ($data['advantage-user'] as $key => $value) {
      $advantage_user = new AdvantageUser;
      $advantage_user->service_id = $service->id;
      $advantage_user->advantage = $value;
      $advantage_user->save();
    }

    // add to thumbnail service
    //  untuk cek apakah field thumbnail ini adalah file atau bukan, 
    if ($request->hasFile('thumbnail')) {
      foreach ($request->file('thumbnail') as $file) {
        $path = $file->store('assets/service/thumbnail', 'public');

        $thumbnail_service = new ThumbnailService;
        $thumbnail_service->service_id = $service['id'];
        $thumbnail_service->thumbnail = $path;
        $thumbnail_service->save();
      }
    }

    // add to tagline
    if (count($data['tagline'])) {
      foreach ($data['tagline'] as $key => $value) {
        $tagline = new Tagline;
        $tagline->service_id = $service->id;
        $tagline->tagline = $value;
        $tagline->save();
      }
    }

    toast()->success('Save has been success');
    return redirect()->route('member.service.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //tidak digunakan, jika ada yang mengakses route ini akan diarahkan ke error 404
    return abort(404);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Service $service)
  {
    $advantage_service = AdvantageService::where('service_id', $service->id)->get();
    $advantage_user = AdvantageUser::where('service_id', $service->id)->get();
    $thumbnail_service = ThumbnailService::where('service_id', $service->id)->get();
    $tagline = Tagline::where('service_id', $service->id)->get();

    //return view to edit page
    return view('pages.dashboard.service.edit', [
      'service' => $service,
      'advantage_service' => $advantage_service,
      'advantage_user' => $advantage_user,
      'thumbnail_service' => $thumbnail_service,
      'tagline' => $tagline
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateServiceRequest $request, Service $service)
  {
    // Memanggil file request yang sudah dibuat pada file UpdateServiceRequest
    $data = $request->all();

    // update to service
    $service->update($data);

    // update to advantage service
    foreach ($data['advantage-services'] as $key => $value) {
      $advantage_service = AdvantageService::find($key);
      $advantage_service->advantage = $value;
      $advantage_service->save();
    }

    // add new advantage service
    if (isset($data['advantage-service'])) {
      foreach ($data['advantage-service'] as $key => $value) {
        $advantage_service = new AdvantageService;
        $advantage_service->service_id = $service->id;
        $advantage_service->advantage = $value;
        $advantage_service->save();
      }
    }

    // update to advantage user
    foreach ($data['advantage-users'] as $key => $value) {
      $advantage_user = AdvantageUser::find($key);
      $advantage_user->advantage = $value;
      $advantage_user->save();
    }

    // add new advantage user
    if (isset($data['advantage-user'])) {
      foreach ($data['advantage-user'] as $key => $value) {
        $advantage_user = new AdvantageUser;
        $advantage_user->service_id = $service->id;
        $advantage_user->advantage = $value;
        $advantage_user->save();
      }
    }

    // update to tagline
    foreach ($data['taglines'] as $key => $value) {
      $tagline = Tagline::find($key);
      $tagline->tagline = $value;
      $tagline->save();
    }

    //add new tagline
    if (isset($data['tagline'])) {
      foreach ($data['tagline'] as $key => $value) {
        $tagline = new Tagline;
        $tagline->service_id = $service['id'];
        $tagline->tagline = $value;
        $tagline->save();
      }
    }

    // update to thumbnail service
    if ($request->hasFile('thumbnails')) {
      foreach ($request->file('thumbnails') as $key => $file) {

        // get old photo thumbnail
        $get_photo = ThumbnailService::where('id', $key)->first();

        // store photo
        $path = $file->store(
          'assets/service/thumbnail',
          'public'
        );

        // update thumbnail
        $thumbnail_service = ThumbnailService::find($key);
        $thumbnail_service->thumbnail = $path;
        $thumbnail_service->save();

        // delete old photo thumbnail
        $data = 'storage/' . $get_photo['photo'];
        if (File::exists($data)) {
          File::delete($data);
        } else {
          File::delete('storage/app/public' . $get_photo['photo']);
        }
      }
    }

    // add to thumbnail service
    if ($request->hasFile('thumbnail')) {
      foreach ($request->file('thumbnail') as $key => $file) {
        $path = $file->store(
          'assets/service/thumbnail',
          'public'
        );

        $thumbnail_service = new ThumbnailService;
        $thumbnail_service->service_id = $service['id'];
        $thumbnail_service->thumbnail = $path;
        $thumbnail_service->save();
      }
    }

    toast()->success('Update has ben success');
    return redirect()->route('member.service.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    return abort(404);
  }
}
