<?php

namespace Saasscaleup\LSL\Http\Controllers;

use DateTime;
use Illuminate\Routing\Controller as BaseController;
use Saasscaleup\LSL\Models\StreamLog;
use Symfony\Component\HttpFoundation\StreamedResponse;
// use Illuminate\Http\Request;

class LSLController extends BaseController
{
    /**
     * Notifies LSL events.
     *
     * @param StreamLog $StreamLog
     * @return StreamedResponse
     * @throws \Exception
     */
    public function stream(StreamLog $StreamLog): StreamedResponse
    {

        $response = new StreamedResponse(function() use ($StreamLog){

            // if the connection has been closed by the client we better exit the loop
            if (connection_aborted()) {
                return;
            }

            $server_eventr_etry = config('lsl.server_eventr_etry');

            echo ':' . str_repeat(' ', 2048) . "\n"; // 2 kB padding for IE
            echo "retry: {$server_eventr_etry}\n";
            $client = getVisitorId();

            while($model = $StreamLog->where('client',$client)->where('delivered', false)->oldest()->first()) {

                // if the connection has been closed by the client we better exit the loop
                if (connection_aborted()) {
                    return;
                }

                $data = json_encode([
                    'message' => $model->message,
                    'type' => strtolower($model->type),
                    'time' => date('H:i:s', strtotime($model->created_at)),
                ]);

                echo 'id: ' . $model->id . "\n";
                echo 'event: ' . $model->event . "\n";
                echo 'data: ' . $data . "\n\n";

                ob_flush();
                flush();
               // sleep(config('lsl.interval'));
                sleep(1);
                $model->delivered = '1';
                $model->save();
            }

            echo ": heartbeat\n\n";

        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        return $response;

    }

}
