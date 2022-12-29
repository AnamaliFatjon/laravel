<?php

namespace App\Http\Controllers;

use App\Models\Visure;
use Illuminate\Http\Request;
use App\Http\Resources\VisureResource;
use App\Models\Form;
use DB;

class VisureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // INDEX FUNCTION TO LIST ALL VISURE
    public function index()
    {
     

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://test.visengine2.altravia.com/visure",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer 63906d538f727020506665aa"
        ],
        ]);

        $visure = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $visure = json_decode($visure);
        }
    
        return view('pages.visure',compact('visure'));
    }

    // FUNCTION TO RETRIEVE A SINGLE VISURE FROM DB
    public function visura(Request $request,$hash)
    {
     

        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => "https://test.visengine2.altravia.com/visure/$hash",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer 63906d538f727020506665aa"
        ],
        ]);

        $visura = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
            $visura = json_decode($visura);
        }
        
        $nr_fornitori = count($visura->data->fornitori);    
        return view('pages.visura',compact('visura','nr_fornitori'));
    }
    
    public function richiesta()
    {
        return view('pages.request');
    }
    
    // CREATING A 'RICHIESTA' TO PURCHASE A SINGLE VISURE
    public function sendrequest()
    {
        
    $cf = $_POST['cf'];
    $cc = $_POST['cc'];
    $contact = $_POST['contact'];
    
    $arrPostData = array(
        'hash_visura'  => '155e32c7eafa9bf45fd65f8647a9a623',
        
        'json_visura'=> array(
        '$0'  => $cf,
        '$1'  => $cc,
        '$2'  => $contact )
        );
    
    $postData = json_encode($arrPostData);
    
    $curl = curl_init();

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://test.visengine2.altravia.com/richiesta",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_HTTPHEADER => [
    "Authorization: Bearer 6397462e0b3f7e70594a96a9",
    "content-type: application/json"
    ],
    ]);

   
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
     $response=json_decode($response);
    }
   
    if($response->success)
    {
        if($response->message == 'Test Request, deleting') 
        {
            $data=array(
        'prezzo'=>$response->data->prezzo_visura,
        'success'=>$response->success,
        'message'=>$response->message,
        'error'=>$response->error
            ); 
        }
        else 
        {
          $data=array(
        'id_order'=>$response->data->_id,
        'state'=>$response->data->state,
        'hash'=>$response->data->hash_visura,
        'prezzo'=>$response->data->prezzo_visura,
        'stato_richiesta'=>$response->data->stato_richiesta,
        'timestamp_creation'=>$response->data->timestamp_creation,
        'timestamp_last_update'=>$response->data->timestamp_last_update,
        'owner'=>$response->data->owner,
        'success'=>$response->success,
        'message'=>$response->message,
        'error'=>$response->error
            );  
        }
    
    
    }
    else
    {
       $data=array(
        'trace'=>$response->trace,
        'success'=>$response->success,
        'message'=>$response->message,
        'error'=>$response->error
            ); 
    }
    
      $richiesta =   DB::table('richieste')->insertGetId($data);
    
        return redirect("requestdetails/$richiesta");
    }
    
    public function requestdetails(Request $request,$id)
    {
     
        $richiesta = DB::table('richieste')->where('id', $id)->first();
    
        return view('pages.requestdetails',compact('richiesta'));
    }
    
}
