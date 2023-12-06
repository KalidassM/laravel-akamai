<?php

namespace App\Http\Controllers;


use App\Models\Whitelist;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Akamai\Open\EdgeGrid\Client;
use GuzzleHttp\Exception\RequestException;
use App\Models\User;


class WhitelistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:whitelist-list|whitelist-create|whitelist-edit|whitelist-delete', ['only' => ['index','show']]);
         $this->middleware('permission:whitelist-create', ['only' => ['create','store']]);
         $this->middleware('permission:whitelist-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:whitelist-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $whitelists = Whitelist::latest('id')->get();

        $active_pending_list = Whitelist::where("status", 2)->get('id')->toArray();
        
        if(count($active_pending_list) > 0) {
            
            $client_token = "akab-wdlkcvj3eulviynk-z3flq2xzjm6sqcoo";
            $client_secret = "vnnU580yBbiHzRGzqdtgCEFzHRkcs7ju6kqFLBBMxl0=";
            $access_token = "akab-hhtxmckgal4fit4b-xhpdetgvbbex6qef";

            $auth = array(
                [
                    'client_token' => 'akab-wdlkcvj3eulviynk-z3flq2xzjm6sqcoo',
                    'client_secret' => 'vnnU580yBbiHzRGzqdtgCEFzHRkcs7ju6kqFLBBMxl0=',
                    'access_token' => 'akab-hhtxmckgal4fit4b-xhpdetgvbbex6qef'
                ]
            );

            $client = new Client();
            $client->setAuth($client_token, $client_secret, $access_token);
            
            $response_staging = $client->request('GET', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/environments/STAGING/status', [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false
            ]);

            $status_code_stagging = $response_staging->getStatusCode();
            $get_response_stagging = json_decode($response_staging->getBody()->getContents(),true);

            if($status_code_stagging == '200') {
                $response_production = $client->request('GET', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/environments/STAGING/status', [
                    'headers' => [
                        'accept' => 'application/json'
                    ],
                    'http_errors' => false
                ]);

                $status_code_production = $response_production->getStatusCode();
                if($status_code_production == '200') {
                    $get_response_production = json_decode($response_production->getBody()->getContents(),true);
                    $arrList = [];
                    foreach($active_pending_list as $key => $pl) {
                        $arrList[$key] = $pl['id'];
                    }
                    $updateProduct = Whitelist::whereIn('id',$arrList)->update(['status' => '3']);
                }
            }
        }

        return view('whitelist.index',compact('whitelists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('whitelist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ipv4' => 'required|unique:whitelists',
            'ipv6' => 'unique:whitelists',
            'user_id' => 'required',
        ], [
            'ipv4.required'    => 'IPV4 is required',
            'ipv4.unique'    => 'IPV4 is already in Whitelist',
            'ipv6.unique'    => 'IPV6 is already in Whitelist',
        ]);

        $client_token = "akab-wdlkcvj3eulviynk-z3flq2xzjm6sqcoo";
        $client_secret = "vnnU580yBbiHzRGzqdtgCEFzHRkcs7ju6kqFLBBMxl0=";
        $access_token = "akab-hhtxmckgal4fit4b-xhpdetgvbbex6qef";

        $auth = array(
            [
                'client_token' => 'akab-wdlkcvj3eulviynk-z3flq2xzjm6sqcoo',
                'client_secret' => 'vnnU580yBbiHzRGzqdtgCEFzHRkcs7ju6kqFLBBMxl0=',
                'access_token' => 'akab-hhtxmckgal4fit4b-xhpdetgvbbex6qef'
            ]
        );

        $client = new Client();
        $client->setAuth($client_token, $client_secret, $access_token);

        if($request['ipv4'] && $request['ipv6']) {

            $response_ipv4 = $client->request('PUT', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/elements?element='.$request['ipv4'], [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false
            ]);

            $response_ipv6 = $client->request('PUT', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/elements?element='.$request['ipv6'], [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false
            ]);
            
            $status_code_ipv4 = $response_ipv4->getStatusCode();
            $status_code_ipv6 = $response_ipv6->getStatusCode();

            // $status_code_ipv4 = 400;
            // $status_code_ipv6 = 400;

            if($status_code_ipv4 != '200') {
                $get_response_ipv4 = json_decode($response_ipv4->getBody()->getContents(),true);
            }
            if($status_code_ipv6 != '200') {
                $get_response_ipv6 = json_decode($response_ipv6->getBody()->getContents(),true);
            }

            if($status_code_ipv4 == '200' && $status_code_ipv6 == '200') {
                $result =  redirect()->route('whitelist.index')->with('success','IP Added Successfully. Please Activate on Staging then Production');
            } 
            elseif($status_code_ipv4 == '200' && $status_code_ipv6 != '200') {

                $both_messages_ipv4_200_ipv6_not200 = [
                    "both_message" => [
                        [
                            "key" => "ipv4",
                            "status" => "success",
                            "message" => "IPV4 Added Successfully. Please Activate on Staging then Production",
                        ],
                        [
                            "key" => "ipv6",
                            "status" => "error",
                            "message" => $get_response_ipv6['detail'],
                            //"message" => "IPV6 error",
                        ],
                    ],
                ];

                $result =  redirect()->route('whitelist.index')
                                ->with('bothmessage', $both_messages_ipv4_200_ipv6_not200);
            } 
            elseif($status_code_ipv4 != '200' && $status_code_ipv6 == '200') {

                $both_messages_ipv4_not200_ipv6_200 = [
                    "both_message" => [
                        [
                            "key" => "ipv4",
                            "status" => "error",
                            "message" => $get_response_ipv4['detail'],
                        ],
                        [
                            "key" => "ipv6",
                            "status" => "success",
                            "message" => "IPV6 Added Successfully. Please Activate on Staging then Production",
                        ],
                    ],
                ];
                $result =  redirect()->route('whitelist.index')
                                ->with('bothmessage', $both_messages_ipv4_not200_ipv6_200);
            } 
            else {

                $both_messages_ipv4_not200_ipv6_not200 = [
                    "both_message" => [
                        [
                            "key" => "ipv4",
                            "status" => "error",
                            "message" => $get_response_ipv4['detail'],
                        ],
                        [
                            "key" => "ipv6",
                            "status" => "error",
                            "message" => $get_response_ipv6['detail'],
                        ],
                    ],
                ];

                $result =  redirect()->route('whitelist.index')
                                ->with('bothmessage', $both_messages_ipv4_not200_ipv6_not200);
            }

        }
        elseif($request['ipv4']) {
            $response = $client->request('PUT', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/elements?element='.$request['ipv4'], [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false
            ]);
            $status_code = $response->getStatusCode();
            if($status_code == '200') {
                $result =  redirect()->route('whitelist.index')->with('success','IPV4 Added Successfully. Please Activate on Staging then Production');
            } else {
                $get_response = json_decode($response->getBody()->getContents(),true);
                $result = redirect()->route('whitelist.index')->with('error',$get_response['detail']);
            }
        } 
        elseif($request['ipv6']) {
            $response = $client->request('PUT', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/elements?element='.$request['ipv6'], [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false
            ]);
            $status_code = $response->getStatusCode();
            if($status_code == '200') {
                $result =  redirect()->route('whitelist.index')->with('success','IPV6 Added Successfully. Please Activate on Staging then Production');
            } else {
                $get_response = json_decode($response->getBody()->getContents(),true);
                $result = redirect()->route('whitelist.index')->with('error',$get_response['detail']);
            }
        }
        Whitelist::create($request->all());
        return $result;
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Whitelist $whitelist): View
    {
        return view('whitelist.show',compact('whitelist'));
    }


    public function activate(Request $request, $key): RedirectResponse
    {
        
        $client_token = "akab-wdlkcvj3eulviynk-z3flq2xzjm6sqcoo";
        $client_secret = "vnnU580yBbiHzRGzqdtgCEFzHRkcs7ju6kqFLBBMxl0=";
        $access_token = "akab-hhtxmckgal4fit4b-xhpdetgvbbex6qef";

        $auth = array(
            [
                'client_token' => 'akab-wdlkcvj3eulviynk-z3flq2xzjm6sqcoo',
                'client_secret' => 'vnnU580yBbiHzRGzqdtgCEFzHRkcs7ju6kqFLBBMxl0=',
                'access_token' => 'akab-hhtxmckgal4fit4b-xhpdetgvbbex6qef'
            ]
        );

        $client = new Client();
        $client->setAuth($client_token, $client_secret, $access_token);

        $whitelist = Whitelist::find($key); 

        if($whitelist) {
            $user_id = $whitelist->user_id;
            $ipv4 = $whitelist->ipv4;
            $ipv6 = $whitelist->ipv6;
            $status = $whitelist->status;

            $user = \App\Models\User::find($user_id); 

            $name = $user->name;
            $email = $user->email;
            
            $response_staging = $client->request('POST', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/environments/STAGING/activate', [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    "comments" => $name. " is activating the STAGING", 
                    "notificationRecipients" => [
                        $email 
                    ] 
                ]
            ]);

            $status_code_stagging = $response_staging->getStatusCode();

            $get_response_stagging = json_decode($response_staging->getBody()->getContents(),true);

            $response_production = $client->request('POST', 'https://akab-3rlgc6eglgti2e7p-6msb4g7yosccggxi.luna.akamaiapis.net/network-list/v2/network-lists/84153_SECURITYBYPASSLIST/environments/PRODUCTION/activate', [
                'headers' => [
                    'accept' => 'application/json'
                ],
                'http_errors' => false,
                'json' => [
                    "comments" => $name. " is activating the PRODUCTION", 
                    "notificationRecipients" => [
                        $email 
                    ] 
                ]
            ]);

            $status_code_production = $response_production->getStatusCode();

            $get_response_production = json_decode($response_production->getBody()->getContents(),true);

            if($status_code_production == '200') {
                $result =  redirect()->route('whitelist.index')->with('success','Activation is completed successfully, Please wait 15 to 20 mins for IP Whitelist, Once process are completed, You will receive the activation success mail from Akamai !!!');
            } else {
                $result = redirect()->route('whitelist.index')->with('error',$get_response_production['detail']);
            }
            //$whitelist->update($request->all());
            $whitelist->where('id', $key)
                ->update([
                    'status' => 2
                ]);
            return $result;
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Whitelist $whitelist): View
    {
        return view('whitelist.edit',compact('whitelist'));
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Whitelist $whitelist): RedirectResponse
    {
        request()->validate([
            'ipv4' => 'required',
            'user_id' => 'required',
        ]);
    
        $whitelist->update($request->all());
    
        return redirect()->route('whitelist.index')
                        ->with('success','IP Address updated successfully');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Whitelist $whitelist): RedirectResponse
    {
        $whitelist->delete();
    
        return redirect()->route('whitelist.index')
                        ->with('success','IP Address deleted successfully');
    }
}
