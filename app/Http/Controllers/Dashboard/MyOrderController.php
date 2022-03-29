<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

use App\Http\Requests\Dashboard\MyOrder\UpdateMyOrderRequest;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Alert;

use App\Models\User;
use App\Models\OrderStatus;
use App\Models\Order;
use App\Models\Service;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use App\Models\Tagline;


class MyOrderController extends Controller
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
    //return data
    $orders = Order::where('frelancer_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();


    return view('pages.dashboard.order.index', [
      'orders' => $orders
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return abort(404);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    return abort(404);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {

    $service = Service::where('id', $order['service_id'])->first();
    $thumbnail = ThumbnailService::where('service_id', $order['service_id'])->get();
    $advantage_service = AdvantageService::where('service_id', $order['service_id'])->get();
    $advantage_user = AdvantageUser::where('servie_id', $order['service_id'])->get();
    $tagline = Tagline::where('service_id', $order['service_id'])->get();

    // Return to show pages
    return view('pages.dashboard.order.detail', [
      'order' => $order,
      'service' => $service,
      'thumbnail' => $thumbnail,
      'advantage_service' => $advantage_service,
      'advantage_user' => $advantage_user,
      'tagline' => $tagline
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Order $order)
  {
    //Untuk button submit in order table page
    return view('pages.dashboard.order.edit', [
      'order' => $order
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateMyOrderRequest $request, Order $order)
  {
    //mengambil data semua request
    $data = $request->all();

    // if untuk mengecek pada variabel data apakah field file benar" ada isinya
    if (isset($data['file'])) {
      // uplod file berupa zip
      $data['file'] = $request->file('file')->store(
        // Lokasi path untuk menyimpan file zip
        'assets/order/attachment',
        'public'
      );
    }

    $order = Order::find($order->id);
    $order->file = $data['file'];
    $order->note = $data['note'];
    $order->save();

    toast()->success('Submit order has been success ');
    return redirect()->route('member.order.index');
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

  // Custom function

  public function accepted($id)
  {
    $order = Order::find($id);
    $order->order_status_id = 2;
    $order->save();

    toast()->success('Accept has been success');
    return back();
  }

  public function rejected($id)
  {
    $order = Order::find($id);
    $order->order_status_id = 3;
    $order->save();

    toast()->success('Reject has been success');
    return back();
  }
}
