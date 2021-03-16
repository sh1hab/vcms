<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTimeZone;
use Firebase\JWT\JWT;
use GuzzleHttp\ClientInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Shihab\Zoom\Api as ZoomApi;
use App\Models\Zoom;
use DateTime;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class ZoomMeetingController
{
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    protected $zoomApi;

    public $jwt;
    public $headers;

    public function __construct()
    {
        $this->client = Client::class;
        $this->zoomApi = new ZoomApi();
        $this->jwt = $this->generateToken();
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->jwt,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function list(Request $request)
    {
        try {
            $all_meetings = Zoom::orderBy('start_time', 'DESC')->get();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        $response = $this->zoomApi->get();

        $data = json_decode($response->body(), true);
        $data['meetings'] = array_map(function (&$m) {
//            $m['start_at'] = $this->toUnixTimeStamp($m['start_time'], $m['timezone']);
            $m['start_at'] = Carbon::parse($m['start_time'])->format('Y-m-d H:i:s');
//            $m['start_at'] = Carbon::createFromTimestamp($m['start_time']);
            $m['url'] = parse_url($m['join_url'], PHP_URL_QUERY);
            parse_str($m['url'], $m['items']);
            $m['items']['id'] = explode('/', $m['join_url']);
            $m['items']['id'] = explode('?', $m['items']['id'][4])[0];
//            if(Date('Y-m-d\TH:i:s') > $m['start_time']){
//                $m['status'] = 'completed';
//            }else
            $m['status'] = 'not completed';
            return $m;
        }, $data['meetings']);

        sort($data['meetings']);

//        dd($data['meetings']);

        return view('meeting.list')->with('meetings', $data['meetings']);

    }

    public function create(Request $request)
    {
        return view('meeting.create');
    }

    public function save(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string',
            'agenda' => 'required|string',
            'start_time' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->with($validator->errors()->all());
        }

        $data = $validator->validated();

        $response = $this->zoomApi->post([
            'topic' => $data['topic'],
            'type' => self::MEETING_TYPE_SCHEDULE,
            'start_time' => $this->toZoomTimeFormat($data['start_time']),
            'duration' => 40,
            'timezone' => 'Asia/Dhaka',
            'agenda' => $data['agenda'],
            'settings' => [
                'join_before_host' => true,
                'host_video' => true,
                'participant_video' => true,
                'waiting_room' => false,
            ]
        ]);
        $data = json_decode($response->body(), true);

        $zoom = new Zoom();
        $zoom->meeting_uuid = $data['uuid'];
        $zoom->meeting_id = $data['id'];
        $zoom->host_id = $data['host_id'];
        $zoom->join_url = $data['join_url'];
        $zoom->duration = $data['duration'];
        $zoom->timezone = $data['timezone'];
        $zoom->start_time = $data['start_time'];
        $zoom->save();

        return redirect()->route('zoom.list');
    }

    public function pastMeetingDetails($meetingID): JsonResponse
    {
        $path = 'past_meetings/' . $meetingID;
        $response = $this->zoomApi->get();

        $data = json_decode($response->body(), true);
        return response()->json([
            'success' => $response->status() === 201,
            'data' => $data
        ], 200);
    }

    private function toUnixTimeStamp(string $dateTime, string $timezone)
    {
        try {
            $date = new DateTime($dateTime, new DateTimeZone($timezone));
            return $date->getTimestamp();
//            return $date->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toUnixTimeStamp : ' . $e->getMessage());
            return '';
        }
    }

    /**
     * @param string $dateTime
     * @return string
     */
    private function toZoomTimeFormat(string $dateTime): string
    {
        try {
            $date = new DateTime($dateTime);
            return $date->format('Y-m-d\TH:i:s');
        } catch (\Exception $e) {
            Log::error('ZoomJWT->toZoomTimeFormat : ' . $e->getMessage());
            return '';
        }
    }


    public function generateToken(): string
    {
        $key = getenv('ZOOM_API_KEY');
        $secret = getenv('ZOOM_API_SECRET');
        $payload = [
            'iss' => $key,
            'exp' => strtotime('+1 minute'),
        ];

        return JWT::encode($payload, $secret, 'HS256');
    }

    public function delete($meeting_id = null)
    {
        $all_meetings = Zoom::orderBy('start_time', 'DESC')->get();

        $request = Http::withHeaders([
            'authorization' => 'Bearer ' . $this->jwt,
            'content-type' => 'application/json',
        ]);

        foreach ($all_meetings as $meeting) {
            $response = $request->delete('https://api.zoom.us/v2/meetings/' . $meeting->meeting_id);
            $response = json_decode($response, true);
            if (isset($response['code']) && $response['code'] == '3001') {
                Zoom::find($meeting->id)->delete();
            }
        }

        return view('meeting.list')->with('meetings', $all_meetings);
    }
}
