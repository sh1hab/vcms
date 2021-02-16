<head>
    <!-- import #zmmtg-root css -->
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/react-select.css"/>
    <head>

<body>
<!-- added on import -->
<div id="zmmtg-root"></div>
<div id="aria-notify-area"></div>

<!-- added on meeting init -->
<div class="ReactModalPortal"></div>
<div class="ReactModalPortal"></div>
<div class="ReactModalPortal"></div>
<div class="ReactModalPortal"></div>
<div class="global-pop-up-box"></div>
<div class="sharer-controlbar-container sharer-controlbar-container--hidden"></div>

<!-- import ZoomMtg dependencies -->
<script src="https://source.zoom.us/1.9.0/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/lodash.min.js"></script>

<!-- import ZoomMtg -->
<script src="https://source.zoom.us/zoom-meeting-1.9.0.min.js"></script>

<!-- import local .js file -->
{{--<script src="js/index.js"></script>--}}
<script type="application/javascript">
    import { ZoomMtg } from '@zoomus/websdk';

    ZoomMtg.setZoomJSLib('https://dmogdx0jrul3u.cloudfront.net/1.9.0/lib', '/av');
    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareJssdk
    const zoomMeeting = document.getElementById("zmmtg-root")

    const meetConfig = {
        apiKey: '3239845720934223459',
        meetingNumber: '123456789',
        leaveUrl: 'https://yoursite.com/meetingEnd',
        userName: 'Firstname Lastname',
        userEmail: 'shihab9921@gmail.com',
        passWord: 'password', // if required
        role: 1 // 1 for host; 0 for attendee
    };

    function getSignature(meetConfig) {
        // getSignature(meetConfig) {
        fetch(`${YOUR_SIGNATURE_ENDPOINT}`, {
            method: 'POST',
            body: JSON.stringify({meetingData: meetConfig})
        }).then(result => result.text())
            .then(response => {
                ZoomMtg.init({
                    leaveUrl: meetConfig.leaveUrl,
                    isSupportAV: true,
                    success: function () {
                        ZoomMtg.join({
                            signature: response,
                            apiKey: meetConfig.apiKey,
                            meetingNumber: meetConfig.meetingNumber,
                            userName: meetConfig.userName,
                            // password optional; set by Host
                            passWord: meetConfig.passWord
                            error(res) {
                                console.log(res)
                            }
                        })
                    }
                })
            }
        // }

    }


</script>
</body>
