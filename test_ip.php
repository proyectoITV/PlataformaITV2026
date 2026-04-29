<?php header('Access-Control-Allow-Origin: *');?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div id='miip'></div>
          <iframe id="iframe" sandbox="allow-same-origin" style="display: none"></iframe>
        <script>
            //get the IP addresses associated with an account
            function getIPs(callback){
                var ip_dups = {};
                var RTCPeerConnection = window.RTCPeerConnection
                    || window.mozRTCPeerConnection
                    || window.webkitRTCPeerConnection;
                var useWebKit = !!window.webkitRTCPeerConnection;

                
                if(!RTCPeerConnection){                    
                    var win = iframe.contentWindow;
                    RTCPeerConnection = win.RTCPeerConnection
                        || win.mozRTCPeerConnection
                        || win.webkitRTCPeerConnection;
                    useWebKit = !!win.webkitRTCPeerConnection;
                }
                var mediaConstraints = {
                    optional: [{RtpDataChannels: true}]
                };

                var servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};

                var pc = new RTCPeerConnection(servers, mediaConstraints);

                function handleCandidate(candidate){
                    var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/
                    var ip_addr = ip_regex.exec(candidate)[1];

                    //remove duplicates
                    if(ip_dups[ip_addr] === undefined)
                        callback(ip_addr);

                    ip_dups[ip_addr] = true;
                }

                pc.onicecandidate = function(ice){
                    if(ice.candidate)
                        handleCandidate(ice.candidate.candidate);
                };

                
                pc.createDataChannel("");
                pc.createOffer(function(result){
                pc.setLocalDescription(result, function(){}, function(){});

                }, function(){});
            
                setTimeout(function(){                    
                    var lines = pc.localDescription.sdp.split('\n');

                    lines.forEach(function(line){
                        if(line.indexOf('a=candidate:') === 0)
                            handleCandidate(line);
                    });
                }, 1000);
            }

            
            getIPs(function(ip){
                var li = document.createElement("li");
                li.textContent = ip;

                //local IPs
                if (ip.match(/^(192\.168\.|169\.254\.|10\.|172\.(1[6-9]|2\d|3[01]))/)){
                    // document.getElementsByTagName("p")[0].appendChild(li);
                    // window.location.href = 'https://plataformaitavu.tamaulipas.gob.mx/test_ipbind.php?ip=' + ip;
                    
                    document.getElementById('miip').innerHTML=ip;
                }

                //IPv6 addresses
                // else if (ip.match(/^[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7}$/))
                //     document.getElementsByTagName("ul")[2].appendChild(li);

                // //assume the rest are public IPs
                // else
                //     document.getElementsByTagName("ul")[1].appendChild(li);
            });
        </script>
    </body>
</html>
