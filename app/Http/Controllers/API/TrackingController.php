<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function track(Request $request)
    {
        // Retrieve tracking data from the request
        $ip = "";

            try{
                $ip =    $_SERVER['REMOTE_ADDR'];
            }catch(\Exception $exception ){

            }
        $trackingData = $request->all();
        foreach ($trackingData["Tracktions"] as $track){

            $tracking = new Tracking();
            if(isset( $track["a"])){
                $tracking->age = $track["a"];
            }
            if (isset($track["g"])) {
                $tracking->gender = $track["g"];
            }
            if (isset($track["gp"])) {
                $tracking->genderProbability = $track["gp"];
            }
            if (isset($track["an"])) {
                $tracking->angry = $track["an"];
            }
            if (isset($track["d"])) {
                $tracking->disgusted = $track["d"];
            }
            if (isset($track["f"])) {
                $tracking->fearful = $track["f"];
            }
            if (isset($track["h"])) {
                $tracking->happy = $track["h"];
            }
            if (isset($track["n"])) {
                $tracking->neutral = $track["n"];
            }
            if (isset($track["s"])) {
                $tracking->sad = $track["s"];
            }
            if (isset($track["su"])) {
                $tracking->surprised = $track["su"];
            }
            if (isset($track["st"])) {
                $tracking->state = $track["st"];
            }
            if (isset($track["ct"])) {
                $tracking->currentTime = $track["ct"];
            }
            $tracking->ip =$ip;
            $tracking->save();
        }


        // Perform necessary tracking logic
        // ...

        // Return a response
        return response()->json([
            'message' => 'Tracking data received successfully.',
            'data' => $trackingData,
        ]);
    }
    public function checkVideo(Request $request){
        $requestData = $request->all();
        $videoID = $requestData["videoID"];
        $curl = curl_init();
        $url = 'https://i.ytimg.com/vi/'.$videoID.'/hqdefault.jpg';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $httpcode["statusCode"] = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        return response()->json([
            'message' => 'Tracking data received successfully.',
            'data' => $httpcode,
        ]);
    }
}
