<?php

namespace App\Http\Controllers\Callbacks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    protected $key, $host;

    public function __construct()
    {
        $this->key = '2c406a399cmsha3229a3f4c13742p15b3bdjsn0fd5558875dc';
        $this->host = 'domainr.p.rapidapi.com';
    }

    public function index(Request $request)
    {
        $data = [];
        // dump($this->key);
        // dump($this->host);
        // dd($request);
        if($request->has('query') && null !== $request->input('query')){
            $query = $request->input('query');
            // dump($this->isDomain($query));
            if($this->isDomain($query)){
                $response = $this->exec('status', $query);
                // dd($response->collect());
                $data = $response->collect()['status'];
            }else{
                $domains = $this->exec('search', $query);
                // dd($domains->collect()['results']);
                foreach($domains->collect()['results'] as $domain){
                    // dump($domain);
                    $status = $this->exec('status', $domain['domain']);
                    // dump($status->collect()['status']);
                    $data[] = $status->collect()['status'][0];
                }
            }
        }

        return view('results.domains', compact('data'));
    }

    public function suggest(Request $request)
    {
        // dump($this->key);
        // dump($this->host);
        if($request->has('query')){
            $query = $request->input('query');
        }else{
            return response()->json([
                'fail' => true,
                'message' => 'No query is provided!'
            ]);
        }
        // dump($query); 
        $response = $this->exec('search', $query);

        // return $response->json();
        $return = [];
        // dump($response->collect());
        if(count($response->collect()['results']) > 0){
            foreach ($response->collect()['results'] as $dom) {
                // dump($dom);
                $return[] = $dom['domain'];
            }
        }
        
        return response()->json($return);
    }

    private function exec($command, $query)
    {
        if($command === 'search'){
            $params = [
                'mashape-key' => $this->key,
                'query' => $query
            ];
        }
        if ($command === 'status') {
            $params = [
                'mashape-key' => $this->key,
                'domain' => $query
            ];
        }
        $response = Http::withHeaders(
            [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ]
        )->get('https://domainr.p.rapidapi.com/v2/'.$command, $params);

        $response->throw();

        return $response;
    }

    private function isDomain($string)
    {
        $pattern = '/^(http[s]?\:\/\/)?(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/';
        return preg_match($pattern, $string);
    }
}
