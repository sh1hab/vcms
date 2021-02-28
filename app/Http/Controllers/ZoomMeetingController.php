<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Shihab\Zoom\Api as ZoomApi;
use App\Models\Zoom;
use GuzzleHttp\Client;
use DateTime;

class ZoomMeetingController
{
    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;

    protected $zoomApi;

    public function __construct()
    {
        $this->zoomApi = new ZoomApi();
    }

    public function list(Request $request)
    {
        $client  = new Client();

        $response = $this->zoomApi->get();

        $data = json_decode($response->body(), true);
        $data['meetings'] = array_map(function (&$m) {
//            $m['start_at'] = $this->toUnixTimeStamp($m['start_time'], $m['timezone']);
            $m['start_at'] = Carbon::createFromTimestamp($m['start_time'])->toDateTimeString();
//            $m['start_at'] = $m['start_time'];
            $m['url'] = parse_url($m['join_url'],PHP_URL_QUERY);
             parse_str( $m['url'], $m['items'] );
             $m['items']['id'] = explode('/',$m['join_url']);
            $m['items']['id'] = explode('?',$m['items']['id'][4])[0];
            return $m;
        }, $data['meetings']);
        return view('meeting.list')->with('meetings',$data['meetings']);

    }

    public function create(Request $request){
        return view('meeting.create');
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|string',
            'agenda' => 'required|string',
            'start_time' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->with($validator->errors()->all());
//            return $this->respondNotValidated($validator->errors()->first(), $validator->errors()->all());
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
                'host_video' => false,
                'participant_video' => false,
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

//        return response()->json([
//            'success' => $response->status() === 201,
//            'data' => $data,
//            'zoom_id' => $zoom->id
//        ], 201);

        return redirect()->route('');
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
}
