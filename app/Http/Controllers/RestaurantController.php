<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use App\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use App\Notifications\RestaurantCredentials;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;


class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = Restaurant::orderBy('id', 'desc')->paginate(5);
        return response()->json($restaurants);
    }

    public function getAll()
    {
        $all_restaurants = Restaurant::all();
        return response()->json($all_restaurants);
    }

    public function search(Request $request)
    {
        $search_query = $request->search_query;
        $data = Restaurant::where('name','LIKE',"%$search_query%")
        ->take(5)
        ->get();
        return response()->json($data);
    }

    public function blocked()
    {
        $restaurants = Restaurant::where('status', 0)
        ->paginate(5);
        return response()->json($restaurants);
    }


    public function activeRestaurants()
    {
        $active_restaurants = Restaurant::where('status', 1)
        ->paginate(5);
        return response()->json($active_restaurants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'restaurant_name' => 'required',
            'phone' => ['required', 'unique:restaurants'],
            'address' => 'required',
            'license_number' => 'required',
            'email' => ['email:rfc,dns', 'unique:restaurants'],
            'restaurant_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $notify_info = $request->all();
        unset($notify_info['file']);
        $notify_info = (object) $notify_info;


        try {
            Notification::route('nexmo', $request->phone )
            ->notify(new RestaurantCredentials($notify_info));
        } catch (\Exception $e) {
            Log::error(' Nexmo API developer are to be blame.');
        }

        try {
        Notification::route('mail',$request->email)
        ->notify(new RestaurantCredentials( $notify_info));        
        } catch (\Exception $e) {
           // Log::error(' Your network connection is to be blame.');
        }


        // New driver object
        $restaurant = new Restaurant;

        // Image set up for restaurant
        if ( $request->hasFile('restaurant_file') ) {
            $path = Storage::disk('public')->putFile('restaurant',$request->file('restaurant_file'));
            $restaurant->image = $path;
        }

        // Save to database
        $restaurant->name = $request->restaurant_name;
        $restaurant->phone = $request->phone;
        $restaurant->address = $request->address;
        $restaurant->email = $request->email;
        $restaurant->discount = $request->discount;
        $restaurant->license_number = $request->license_number;
        $restaurant->commmission = $request->commmision;
        $restaurant->save();

        return 'Suceess';


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $restaurant = Restaurant::find($id);
        return response()->json($restaurant);
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

        $restaurant = Restaurant::find($id);

        $validator = Validator::make($request->all(), [
            'restaurant_name' => 'required',
            'phone' => ['required'],
            'address' => 'required',
            'license_number' => 'required',
            'email' => ['email:rfc,dns'],
            'restaurant_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Image set up
       // $restaurant->image = 'default_image.svg';
        if ( $request->hasFile('restaurant_file') ) {
            Storage::disk('public')->delete($restaurant->image);
            $path = Storage::disk('public')->putFile('restaurant',$request->file('restaurant_file'));
            $restaurant->image = $path;
        }

        // Save to database
        $restaurant->name = $request->restaurant_name;
        $restaurant->phone = $request->phone;
        $restaurant->address = $request->address;
        $restaurant->email = $request->email;
        $restaurant->discount = $request->discount;
        $restaurant->license_number = $request->license_number;
        $restaurant->commmission = $request->commmision;
        $restaurant->save();

        return 'Suceess';

    }

    public function statusUpdate(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);
        $restaurant->status = $request->status;
        $restaurant->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        Storage::disk('public')->delete($restaurant->image);
        $restaurant->menus()->delete();
        $restaurant->config()->delete();
        $restaurant->delete();
    }
}
