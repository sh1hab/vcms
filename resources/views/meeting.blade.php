<html>

<head>
    <title>Online Class Room</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.0/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

<body>
<style>
    .sdk-select {
        height: 34px;
        border-radius: 4px;
    }

    .websdktest button {
        float: right;
        margin-left: 5px;
    }

    #nav-tool {
        margin-bottom: 0;
    }

    #show-test-tool {
        position: absolute;
        top: 100px;
        left: 0;
        display: block;
        z-index: 99999;
    }

    #display_name {
        width: 250px;
    }


    #websdk-iframe {
        width: 700px;
        height: 500px;
        border: 1px dashed red;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        left: 50%;
        margin: 0;
    }
</style>

<nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Online Class room</a>
        </div>

        <div id="navbar" class="websdktest">
            <form class="navbar-form navbar-right" id="meeting_form">
                <div class="form-group">
                    <label for="display_name"></label><input type="text" name="display_name" id="display_name" value="1.9.0#CDN" maxLength="100"
                                                             placeholder="Name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="meeting_number"></label><input type="text" name="meeting_number" id="meeting_number" value="" maxLength="200"
                                                               style="width:150px" placeholder="Meeting Number" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="meeting_pwd"></label><input type="text" name="meeting_pwd" id="meeting_pwd" value="" style="width:150px"
                                                            maxLength="32" placeholder="Meeting Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="meeting_email"></label><input type="text" name="meeting_email" id="meeting_email" value="" style="width:150px"
                                                              maxLength="32" placeholder="Email option" class="form-control">
                </div>

                <div class="form-group">
                    <label for="meeting_role"></label>
                    <input id="meeting_role" type="hidden" value="0" >
                </div>

                <div class="form-group">
                    <label for="meeting_china"></label>
                    <input id="meeting_china" type="hidden" value="0" >
                </div>

                <div class="form-group">
                    <input id="meeting_lang" type="hidden" value="en-US" >
                </div>

                <input type="hidden" value="" id="copy_link_value" />
                <button type="submit" class="btn btn-primary" id="join_meeting">Join</button>
                <button type="submit" class="btn btn-primary" id="clear_all">Clear</button>
                <button type="button" onclick="window.copyJoinLink('#copy_join_link')"
                        class="btn btn-primary" id="copy_join_link">Copy Direct join link</button>

            </form>
        </div>
        <!--/.navbar-collapse -->
    </div>
</nav>

<div id="show-test-tool">
    <button type="submit" class="btn btn-primary" id="show-test-tool-btn"
            title="show or hide top test tool">Hide</button>
</div>

<script>
    document.getElementById('show-test-tool-btn').addEventListener("click", function (e) {
        var textContent = e.target.textContent;
        if (textContent === 'Show') {
            document.getElementById('nav-tool').style.display = 'block';
            document.getElementById('show-test-tool-btn').textContent = 'Hide';
        } else {
            document.getElementById('nav-tool').style.display = 'none';
            document.getElementById('show-test-tool-btn').textContent = 'Show';
        }
    })
</script>

<!-- import ZoomMtg dependencies -->
<script src="https://source.zoom.us/1.9.0/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/1.9.0/lib/vendor/lodash.min.js"></script>
<!-- import ZoomMtg -->
<script src="https://source.zoom.us/zoom-meeting-1.9.0.min.js"></script>
<script src="{!! asset('js/zoom/tool.js') !!}"></script>
<script src="{!! asset('js/zoom/vconsole.min.js') !!}"></script>
<!-- import local .js file -->
{{--<script src="{!! asset('js/zoom/index.js') !!}"></script>--}}
{{--<script src="{!! asset('js/zoom/meeting.js') !!}"></script>--}}
<script src="{!! asset('js/zoom/meeting.js') !!}"></script>

<script>
    const simd = async () => WebAssembly.validate(new Uint8Array([0, 97, 115, 109, 1, 0, 0, 0, 1, 4, 1, 96, 0, 0, 3, 2, 1, 0, 10, 9, 1, 7, 0, 65, 0, 253, 15, 26, 11]))
    simd().then((res) => {
        console.log("simd check", res);
    });
</script>

</body>

</html>
