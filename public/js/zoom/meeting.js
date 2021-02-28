window.addEventListener('DOMContentLoaded', function (event) {
    console.log('DOM fully loaded and parsed');
    websdkready();
});

function websdkready() {
    var testTool = window.testTool;
    if (testTool.isMobileDevice()) {
        vConsole = new VConsole();
    }
    console.log("checkSystemRequirements");
    console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

    // it's option if you want to change the WebSDK dependency link resources. setZoomJSLib must be run at first
    // if (!china) ZoomMtg.setZoomJSLib('https://source.zoom.us/1.9.0/lib', '/av'); // CDN version default
    // else ZoomMtg.setZoomJSLib('https://jssdk.zoomus.cn/1.9.0/lib', '/av'); // china cdn option
    // ZoomMtg.setZoomJSLib('http://localhost:9999/node_modules/@zoomus/websdk/dist/lib', '/av'); // Local version default, Angular Project change to use cdn version
    ZoomMtg.preLoadWasm(); // pre download wasm file to save time.

    var API_KEY = "MKk8XSAJQwyLf8DJTG2McA";

    /**
     * NEVER PUT YOUR ACTUAL API SECRET IN CLIENT SIDE CODE, THIS IS JUST FOR QUICK PROTOTYPING
     * The below generateSignature should be done server side as not to expose your api secret in public
     * You can find an eaxmple in here: https://marketplace.zoom.us/docs/sdk/native-sdks/web/essential/signature
     */
    var API_SECRET = "QeaQeAaZuWBoVfmy5GFtIUOTQWHQvplJcRJ8";

    // some help code, remember mn, pwd, lang to cookie, and autofill.
    document.getElementById("display_name").value =
        "CDN" +
        ZoomMtg.getJSSDKVersion()[0] +
        testTool.detectOS() +
        "#" +
        testTool.getBrowserInfo();
    document.getElementById("meeting_number").value = testTool.getCookie(
        "meeting_number"
    );
    document.getElementById("meeting_pwd").value = testTool.getCookie(
        "meeting_pwd"
    );
    if (testTool.getCookie("meeting_lang"))
        document.getElementById("meeting_lang").value = testTool.getCookie(
            "meeting_lang"
        );

    document
        .getElementById("meeting_lang")
        .addEventListener("change", function (e) {
            testTool.setCookie(
                "meeting_lang",
                document.getElementById("meeting_lang").value
            );
            testTool.setCookie(
                "_zm_lang",
                document.getElementById("meeting_lang").value
            );
        });
    // copy zoom invite link to mn, autofill mn and pwd.
    document
        .getElementById("meeting_number")
        .addEventListener("input", function (e) {
            var tmpMn = e.target.value.replace(/([^0-9])+/i, "");
            if (tmpMn.match(/([0-9]{9,11})/)) {
                tmpMn = tmpMn.match(/([0-9]{9,11})/)[1];
            }
            var tmpPwd = e.target.value.match(/pwd=([\d,\w]+)/);
            if (tmpPwd) {
                document.getElementById("meeting_pwd").value = tmpPwd[1];
                testTool.setCookie("meeting_pwd", tmpPwd[1]);
            }
            document.getElementById("meeting_number").value = tmpMn;
            testTool.setCookie(
                "meeting_number",
                document.getElementById("meeting_number").value
            );
        });

    document.getElementById("clear_all").addEventListener("click", function (e) {
        testTool.deleteAllCookies();
        document.getElementById("display_name").value = "";
        document.getElementById("meeting_number").value = "";
        document.getElementById("meeting_pwd").value = "";
        document.getElementById("meeting_lang").value = "en-US";
        document.getElementById("meeting_role").value = 0;
        window.location.href = "/meeting";
    });

    // click join meeting button
    document
        .getElementById("join_meeting")
        .addEventListener("click", function (e) {
            e.preventDefault();
            var meetingConfig = testTool.getMeetingConfig();
            if (!meetingConfig.mn || !meetingConfig.name) {
                alert("Meeting number or username is empty");
                return false;
            }

            testTool.setCookie("meeting_number", meetingConfig.mn);
            testTool.setCookie("meeting_pwd", meetingConfig.pwd);

            var signature = ZoomMtg.generateSignature({
                meetingNumber: meetingConfig.mn,
                apiKey: API_KEY,
                apiSecret: API_SECRET,
                role: meetingConfig.role,
                success: function (res) {
                    console.log(res.result);
                    meetingConfig.signature = res.result;
                    meetingConfig.apiKey = API_KEY;
                    // var joinUrl = "/meeting/join?" + testTool.serialize(meetingConfig);
                    meetingSdk(meetingConfig);
                    console.log(joinUrl);
                    // window.open(joinUrl, "_blank");
                },
            });
        });

    function copyToClipboard(elementId) {
        var aux = document.createElement("input");
        aux.setAttribute("value", document.getElementById(elementId).getAttribute('link'));
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);
    }

    // click copy join link button
    window.copyJoinLink = function (element) {
        var meetingConfig = testTool.getMeetingConfig();
        if (!meetingConfig.mn || !meetingConfig.name) {
            alert("Meeting number or username is empty");
            return false;
        }
        var signature = ZoomMtg.generateSignature({
            meetingNumber: meetingConfig.mn,
            apiKey: API_KEY,
            apiSecret: API_SECRET,
            role: meetingConfig.role,
            success: function (res) {
                console.log(res.result);
                meetingConfig.signature = res.result;
                meetingConfig.apiKey = API_KEY;
                var joinUrl =
                    testTool.getCurrentDomain() +
                    "/meeting/join" +
                    testTool.serialize(meetingConfig);
                document.getElementById('copy_link_value').setAttribute('link', joinUrl);
                copyToClipboard('copy_link_value');

            },
        });
    };

    function meetingSdk(tmpArgs) {
        // var testTool = window.testTool;
        // get meeting args from url
        // var tmpArgs = testTool.parseQuery();
        var meetingConfig = {
            apiKey: tmpArgs.apiKey,
            meetingNumber: tmpArgs.mn,
            userName: (function () {
                if (tmpArgs.name) {
                    try {
                        return testTool.b64DecodeUnicode(tmpArgs.name);
                    } catch (e) {
                        return tmpArgs.name;
                    }
                }
                return (
                    "CDN#" +
                    tmpArgs.version +
                    "#" +
                    testTool.detectOS() +
                    "#" +
                    testTool.getBrowserInfo()
                );
            })(),
            passWord: tmpArgs.pwd,
            leaveUrl: "zoom/list",
            role: parseInt(tmpArgs.role, 10),
            userEmail: (function () {
                try {
                    return testTool.b64DecodeUnicode(tmpArgs.email);
                } catch (e) {
                    return tmpArgs.email;
                }
            })(),
            lang: tmpArgs.lang,
            signature: tmpArgs.signature || "",
            china: tmpArgs.china === "1",
        };

        // a tool use debug mobile device
        if (testTool.isMobileDevice()) {
            vConsole = new VConsole();
        }
        console.log(JSON.stringify(ZoomMtg.checkSystemRequirements()));

        // it's option if you want to change the WebSDK dependency link resources. setZoomJSLib must be run at first
        // ZoomMtg.setZoomJSLib("https://source.zoom.us/1.9.0/lib", "/av"); // CDN version default
        if (meetingConfig.china)
            // For CDN version default
            ZoomMtg.setZoomJSLib("https://jssdk.zoomus.cn/1.9.0/lib", "/av"); // china cdn option
        ZoomMtg.preLoadWasm();
        ZoomMtg.prepareJssdk();

        function beginJoin(signature) {
            document.getElementById('nav-tool').style.display = 'none';
            document.getElementById('show-test-tool-btn').textContent = 'Show';
            ZoomMtg.init({
                leaveUrl: meetingConfig.leaveUrl,
                webEndpoint: meetingConfig.webEndpoint,
                success: function () {
                    console.log(meetingConfig);
                    console.log("signature", signature);
                    ZoomMtg.i18n.load(meetingConfig.lang);
                    ZoomMtg.i18n.reload(meetingConfig.lang);
                    ZoomMtg.join({
                        meetingNumber: meetingConfig.meetingNumber,
                        userName: meetingConfig.userName,
                        signature: signature,
                        apiKey: meetingConfig.apiKey,
                        userEmail: meetingConfig.userEmail,
                        passWord: meetingConfig.passWord,
                        success: function (res) {
                            console.log("join meeting success");
                            console.log("get attendeelist");
                            ZoomMtg.getAttendeeslist({});
                            ZoomMtg.getCurrentUser({
                                success: function (res) {
                                    console.log("success getCurrentUser", res.result.currentUser);
                                },
                            });
                        },
                        error: function (res) {
                            console.log(res);
                        },
                    });
                },
                error: function (res) {
                    console.log(res);
                },
            });

            ZoomMtg.inMeetingServiceListener('onUserJoin', function (data) {
                console.log('inMeetingServiceListener onUserJoin', data);
            });

            ZoomMtg.inMeetingServiceListener('onUserLeave', function (data) {
                console.log('inMeetingServiceListener onUserLeave', data);
            });

            ZoomMtg.inMeetingServiceListener('onUserIsInWaitingRoom', function (data) {
                console.log('inMeetingServiceListener onUserIsInWaitingRoom', data);
            });

            ZoomMtg.inMeetingServiceListener('onMeetingStatus', function (data) {
                console.log('inMeetingServiceListener onMeetingStatus', data);
            });
        }


        beginJoin(meetingConfig.signature);
    }

}
