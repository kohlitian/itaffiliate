<html>
	<head>
	  <title>Bootstrap Example</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	</head>
    <body>
        <style>
        @media screen and (max-width: 480px)
        {
            .main {
                 height: 100px;
             }
        }
        </style>
        <?php
        $DBLink = mysqli_connect("192.168.148.25", "vvc_bridge", "dE5HWx6YDDFMy62t", "vvc_dev");
        mysqli_set_charset($DBLink,'utf8');
        $SQL = "select id, url, title from ecom_affiliate where status='A' AND FIND_IN_SET(224,country_id) order by id desc limit 0,50";
        $rs = mysqli_query($DBLink, $SQL);

        set_time_limit(1800);

        function limit_text($text, $limit) {
          if (str_word_count($text, 0) > $limit) {
              $words = str_word_count($text, 2);
              $pos = array_keys($words);
              $text = substr($text, 0, $pos[$limit]) . '...';
          }
          return $text;
        }

        function get_data($url) {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }

        function testSite($url){
            if(!empty($url)){
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                $respinse = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if($httpCode == 404){
                    return "<h4>".$httpCode."</h4><br>This request resource could not be found.";
                } elseif ($httpCode == 400) {
                    return "<h4>".$httpCode."</h4><br>Request cannot fulfilled due to bad syntax.";
                } elseif($httpCode == 401){
                    return "<h4>".$httpCode."</h4><br>Request require user authentication. Unauthorized Access";
                } elseif($httpCode == 403){
                    return "<h4>".$httpCode."</h4><br>Server refuse to respond to the request.";
                } elseif($httpCode == 405){
                    return "<h4>".$httpCode."</h4><br>Request method is not supported by the resource";
                } elseif($httpCode == 407){
                    return "<h4>".$httpCode."</h4><br>User are required to use proxy.";
                } elseif($httpCode == 408){
                    return "<h4>".$httpCode."</h4><br>Server time out.";
                } elseif($httpCode == 409){
                    return "<h4>".$httpCode."</h4><br>Confilct happened in request.";
                } elseif($httpCode == 410){
                    return "<h4>".$httpCode."</h4><br>Requested resource are gone. No forwarding address is known.";
                } elseif($httpCode == 411){
                    return "<h4>".$httpCode."</h4><br>Requested resource require length of content.";
                } elseif($httpCode == 412){
                    return "<h4>".$httpCode."</h4><br>Server does not meet precondition of request.";
                } elseif($httpCode == 413){
                    return "<h4>".$httpCode."</h4><br>Server refuse to process oversize request entity.";
                } elseif($httpCode == 414){
                    return "<h4>".$httpCode."</h4><br>Requested URL are too long, server refuse to service.";
                } elseif($httpCode == 415){
                    return "<h4>".$httpCode."</h4><br>Server does not support requested media type.";
                } elseif($httpCode == 416){
                    return "<h4>".$httpCode."</h4><br>Requested Range Not satisfiable.";
                } elseif($httpCode == 417){
                    return "<h4>".$httpCode."</h4><br>The server cannot meet the requirements of the Expect request-header field.";
                } elseif($httpCode == 420 || $httpCode == 429){
                    return "<h4>".$httpCode."</h4><br>User sent too many request in given amount of time.";
                } elseif($httpCode == 422){
                    return "<h4>".$httpCode."</h4><br>The request was well-formed but was unable to be followed due to semantic errors.";
                } elseif($httpCode == 426){
                    return "<h4>".$httpCode."</h4><br>The client should switch to a different protocol.";
                } elseif($httpCode == 428){
                    return "<h4>".$httpCode."</h4><br>Origin server require specific condition request to continue.";
                } elseif($httpCode == 431){
                    return "<h4>".$httpCode."</h4><br>Header fields are too large.";
                } elseif($httpCode == 444){
                    return "<h4>".$httpCode."</h4><br>Return no information to client and close connection.";
                } elseif($httpCode == 449){
                    return "<h4>".$httpCode."</h4><br>Retry after appropriate action.";
                } elseif($httpCode == 450){
                    return "<h4>".$httpCode."</h4><br>Windows Parental Controls are turned on and are blocking access to the given webpage.";
                } elseif($httpCode == 450){
                    return "<h4>".$httpCode."</h4><br>Resource access is denied for legal reason.";
                } elseif($httpCode == 499){
                    return "<h4>".$httpCode."</h4><br>Server unable to send HTTP header back because connection closed by client";
                } elseif($httpCode == 500){
                    return "<h4>".$httpCode."</h4><br>Server encountered unexpected condition.";
                } elseif($httpCode == 501){
                    return "<h4>".$httpCode."Server lack of ability to fulfill the requrement or it does not recognize the method.";
                } elseif($httpCode == 502){
                    return "<h4>".$httpCode."</h4><br>Server act as gateway and recieved invalid response from upstream server.";
                } elseif($httpCode == 503){
                    return "<h4>".$httpCode."</h4><br>Server is currently unable due to temporary overloading or maintainance.";
                } elseif($httpCode == 504){
                    return "<h4>".$httpCode."</h4><br>Server act as gateway, did not receive timely response";
                } elseif($httpCode == 505){
                    return "<h4>".$httpCode."</h4><br>Server does not support the HTTP protocol.";
                } elseif($httpCode == 506){
                    return "<h4>".$httpCode."</h4><br>Server has an internal configuration error.";
                } elseif($httpCode == 507){
                    return "<h4>".$httpCode."</h4><br>Insufficient storage cause method could not be performed on resource.";
                } elseif($httpCode == 508){
                    return "<h4>".$httpCode."</h4><br>Server terminated an operation because it caused infinity loop.";
                } elseif($httpCode == 509){
                    return "<h4>".$httpCode."</h4><br>Bandwidth Limit Exceeded";
                } elseif($httpCode == 510){
                    return "<h4>".$httpCode."</h4><br>Further extensions to the request are required for the server to fulfill it.";
                } elseif($httpCode == 511){
                    return "<h4>".$httpCode."</h4><br>Client need to authenticate to gain network access.";
                } elseif($httpCode == 598){
                    return "<h4>".$httpCode."</h4><br>Network read timeout.";
                } elseif($httpCode == 599){
                    return "<h4>".$httpCode."</h4><br>Network connect timeout.";
                } elseif($httpCode == 300){
                    return "<h4>".$httpCode."</h4><br>";
                } elseif($httpCode == 301){
                    return "<h4>".$httpCode."</h4><br>Requested resource has assigned a new permanent URL.";
                } elseif($httpCode == 302){
                    return "<h4>".$httpCode."</h4><br>Resource temporary resign on different URL.";
                } elseif($httpCode == 303){
                    return "<h4>".$httpCode."</h4><br>response to the request found on different URL, use GET method to reach the resource.";
                } elseif($httpCode == 304){
                    return "<h4>".$httpCode."</h4><br>Resource has not been modify since last requested.";
                } elseif($httpCode == 305){
                    return "<h4>".$httpCode."</h4><br>Requested resource must access through the proxy";
                } elseif($httpCode == 307){
                    return "<h4>".$httpCode."</h4><br>The requested resource temporary resides on different URL.";
                } elseif($httpCode == 308){
                    return "<h4>".$httpCode."</h4><br>The requested resource permanently resides on different URL.";
                } else {
                    return "<h4>".$httpCode."</h4><br>Website is working correctly";
                }
            }
        }
        $html = "<div class='container-fluid'>";
        $html .= "<table border=1 width='100%' class='table table-striped table-hover'>";
        $html .= "<tr>";
        $html .= "</tr>";
        $html .= "<td width='10%'><h5>Title</h5></td>";
        $html .= "<td width='10%'><h5>Action</h5></td>";
        $html .= "<td width='10%'><h5>URL</h5></td>";
        $html .= "<td width='40%'><h5>Content</h5></td>";
        $html .= "<td width='30%'><h5>HTTP Code</h5></td>";
        $html .= "</tr>";
        while ($r = mysqli_fetch_object($rs)) {
            $html .= "<tr>";
            $html .= "<td width='10%'>".$r->title."</td>";
            $html .= "<td width='10%'><button class='btn btn-info btn-md'><small>Set To Inactive</small></button></td>";
            $html .= "<td width='10%'><a href='".$r->url."' target='_blank'>".limit_text($r->url,10)."...</a></td>";
            
            //$html .= '<td width="60%">'.get_data($r->url).'</td>';
            $html .= '<td width="40%"><iframe class="main" src="'.$r->url.'" allowfullscreen="" sandbox="allow-forms allow-scripts" width="500" height="100"></iframe></td>';
            $html .= "<td width='30%'>".
//            testSite($r->url);
            "</td>";
            $html .= "</tr>";
        }
        $html .= "</table>";
        $html .= "</div>";

        echo $html;

        exit;
        ?>
        <script type="text/javascript">
           if(top.location != window.location) {
             window.location = top.location;
           }
        </script>
	        <form method="post" action="#">
	            <table>
	                <tr>
	                    <td><button type="submit" name='generate' value="generate"> Generate</button></td>
	                    <td><button type="submit" name='export' value="export"> Export</button></td>
	                </tr>
	            </table>
	            <?php
	            if(!empty($html)){
	                $layout = '<div class="container" id="tableWrapper">';
	                $layout .= '<div>'.$html.'</div>';
	                $layout .= '</div>';
	                echo $layout;
	            }
	            ?>
	        </form>
    </body>
</html>