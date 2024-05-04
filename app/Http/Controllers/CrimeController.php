<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Crime;
use App\Notifications\NewCrimeData;
use Illuminate\Support\Facades\Notification;

use App\Models\User;



class CrimeController extends Controller
{
    
    public function addCrime(Request $request)
{
    $request->validate([
        'longitude' => 'required',
        'time' => 'required|date_format:H:i',
    ]);

    // Create and save the crime
    $crime = new Crime;
    $crime->user_id = $request->user_id;
    $crime->type = $request->type;
    $crime->location = $request->location;
    $crime->longitude = $request->longitude;
    $crime->latitude = $request->latitude;
    $crime->source = $request->source;
    $crime->time = $request->time;
    $crime->date = $request->date;
    $crime->save();

    // Send the notification to the specific user
    $user = \App\Models\User::find($request->user_id);


    if ($user) {
        Notification::send($user, new NewCrimeData());
    }

    return redirect('/view')->with('message', 'Crime added Successfully');
}
    public function insertcrime()
    {
        return view('insert');
    } 
    public function showCrimeMapSearch()
    {
        return view('search');
    }

    public function getCrimesByLocation(Request $request)
    {
        $location = $request->input('location');

        $crimes = Crime::where('location', 'like', '%' . $location . '%')->get();

        return $crimes;
    }
    public function ViewCrimeData(){
        $crimeData = Crime::all();
        return view('view', ['crimeData' => $crimeData]);
    }

    public function editCrime($crimeId)
    {
        $crime = Crime::find($crimeId);
        return view('edit', ['crime' => $crime]);
    }

    public function updateCrime(Request $request, $crimeId)
    {
        // Validation logic similar to addCrime method

        $crime = Crime::find($crimeId);

        if (!$crime) {
            return back()->with('error', 'Crime not found');
        }

        // Update crime data
        $crime->type = $request->type;
        $crime->location = $request->location;
        $crime->source = $request->source;
        $crime->time = $request->time;
        $crime->date = $request->date;
        // Update other fields as needed

        $crime->save();

        return redirect('view')->with('updatemessage', 'Crime updated successfully');
    }

    public function deleteCrime($crimeId)
        {
            $crime = Crime::find($crimeId);

            if (!$crime) {
                return back()->with('error', 'Crime not found');
            }

            $crime->delete();
            return redirect('view')->with('deletemessage', 'Crime deleted successfully');
        }





    // Geocoding API to fetch latitude and longitude based on the location data you have stored

//     public function getGeocodedData()
// {
//     $crimes = Crime::all();

//     foreach ($crimes as $crime) {
//         // Make a request to Google Maps Geocoding API
//         $client = new Client();
//         $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
//             'query' => [
//                 'address' => $crime->location,
//                 'key' => 'AIzaSyCTXnohcGL0e0EIUr2v4jpEOOoDMKewEaM',
//             ],
//         ]);

//         $data = json_decode($response->getBody(), true);

//         // Extract latitude and longitude from the API response
//         $lat = $data['results'][0]['geometry']['location']['lat'];
//         $lng = $data['results'][0]['geometry']['location']['lng'];

//         // Update your Crime model with lat and lng values
//         $crime->update([
//             'lat' => $lat,
//             'lng' => $lng,
//         ]);
//     }

//     return response()->json(['message' => 'Geocoding completed successfully']);
// }



    //  Get Crime Data Function 
    // public function getCrimes(Request $request)
    // {
    //     $query = Crime::query();

    //     // Add logic to filter based on search parameters
    //     if ($request->has('location')) {
    //         $query->where('location', 'LIKE', '%' . $request->input('location') . '%');
    //     }

    //     // Add more filters based on your needs (type, time, date, etc.)

    //     $crimes = $query->get();

    //     return response()->json($crimes);
    // }
        //************ */ Get getCrimesByLocation FUNCTION**************************
  

}
