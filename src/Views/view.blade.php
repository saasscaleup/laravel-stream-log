@if(config('lsl.enabled') && config('app.env')!=='production'))

    
      <!--  EventSource pollyfill  -->
      <script src="https://cdn.jsdelivr.net/npm/event-source-polyfill@1.0.31/src/eventsource.min.js"></script>

    @if(config('lsl.js_notification_library') == 'noty')

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>
        <script>

            if (window.EventSource !== undefined) {

                var noty_type_arr   = ['alert', 'success', 'error', 'warning', 'info'];
                var es              = new EventSource("{{route('lsl-stream-log')}}");
                
                es.addEventListener("stream", function (e) {

                    var data            = JSON.parse(e.data);
                    var js_timeout      = {{config('lsl.js_timeout') ? config('lsl.js_timeout'): 'false' }};
                    var js_console_log  = {{config('lsl.js_console_log_enabled') ? config('lsl.js_console_log_enabled'): 'false' }};
                    
                    if (data.message) {
                        new Noty({
                            text:'<small> ['+data.time+'] '+data.type + '</small><br>' + data.message,
                            type: noty_type_arr.includes(data.type) ? data.type : 'info',
                            theme: "metroui", // relax, mint, metroui 
                            closeWith: ['click','button'],
                            layout: "{{config('lsl.js_position')}}",
                            timeout: js_timeout
                        }).show();

                        if (js_console_log===true || js_console_log===1){
                            console.log(data);
                        }
                    }
                }, false);

                es.addEventListener("error", event => {
                    if (event.readyState == EventSource.CLOSED) {
                        console.log("lsl Connection Closed.");
                    }
                }, false);

            } else {
                alert("lsl is not supported in this browser!");
            }
        </script>


    @elseif(config('lsl.js_notification_library') == 'izitoast')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>


        <script>
        if (window.EventSource !== undefined) {

            var es                  = new EventSource("{{route('lsl-stream-log')}}");
            var izitoast_type_arr   = ['success', 'error', 'warning', 'info'];

            es.addEventListener("stream", function (e) {

                var data            = JSON.parse(e.data);
                var js_timeout      = {{config('lsl.js_timeout') ? config('lsl.js_timeout'): 'false' }};
                var js_console_log  = {{config('lsl.js_console_log_enabled') ? config('lsl.js_console_log_enabled'): 'false' }};

                if (data.message) {
                    izitoast_type = izitoast_type_arr.includes(data.type) ? data.type : 'info'

                    iziToast[izitoast_type]({
                        title: '<small>[' + data.time + ']</small>',
                        message:  data.message,
                        position: "{{config('lsl.js_position')}}",
                        timeout: js_timeout,
                        //maxWidth: 300,
                    });

                    if (js_console_log===true || js_console_log===1){
                        console.log(data);
                    }
                }

            }, false);

            es.addEventListener("error", event => {
                if (event.readyState == EventSource.CLOSED) {
                    console.log("lsl Connection Closed.");
                }
            }, false);

        } else {
            alert("lsl is not supported in this browser!");
        }
        </script>
    @endif
@endif
