<?php

namespace Saasscaleup\LSL;

use Saasscaleup\LSL\Models\StreamLog;

/**
 * LSL
 */
class LSL
{
    /**
     * @var StreamLog
     */
    protected $StreamLog;
    
    /**
     * __construct
     *
     * @param  StreamLog $StreamLog
     * @return void
     */
    public function __construct(StreamLog $StreamLog)
    {
        $this->StreamLog = $StreamLog;
    }

    /**
     * Notify LSL event.
     *
     * @param string $message : notification message
     * @param string $type : alert, success, error, warning, info, debug, critical, etc...
     * @param string $event : Type of event such as "EmailSent", "UserLoggedIn", etc
     * @return bool
     */
    public function notify(string $message, string $type = 'info', string $event = 'stream'): bool
    {
        return $this->StreamLog->saveEvent($message, $type, $event);
    }

}
