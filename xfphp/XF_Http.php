<?php
class XF_Http
{
	private static function buildData($data)
	{
        $encodData = "";
        foreach ($data as $k => $v)
		{
            $encodData .= ($encodData ? "&" : "");
            $encodData .= rawurlencode($k) . "=" . rawurlencode($v);
        }

		return $encodData;
	}

	public static function curl($url, $data, $type = 'GET')
	{
        $ci = curl_init(); 

        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ci, CURLOPT_TIMEOUT, 5);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_HEADER, FALSE);

		$encodData = '';
		if(!empty($data)) { $encodData = self::buildData($data); }

		if($method === 'GET')
		{
			$url = strstr($url, '?') ? '&'.$encodeData : '?'.$encodeData;
		}
        elseif($method === 'POST')
		{
            curl_setopt($ci, CURLOPT_POST, TRUE);
            if(!empty($encodData))
			{
				curl_setopt($ci, CURLOPT_POSTFIELDS, $encodData);
            }
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        $response = curl_exec($ci); 
        curl_close ($ci);

        return $response;
	}

	public static function sock($url, $data, $type = 'GET')
	{
        $url = parse_url($url);
        if(!$url) { return "couldn't parse url"; }
        if(!isset($url['port']))  { $url['port'] = ""; }
        if(!isset($url['query'])) { $url['query'] = ""; }

		$encodData = '';
		if(!empty($data)) { $encodData = self::buildData($data); }

        // Open socket on host
        $fp = @fsockopen($url['host'], $url['port'] ? $url['port'] : 80);
        if(!$fp) { return "failed to open socket to {$url['host']}"; }

        // Send HTTP 1.0 POST request to host
        fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], $url['query'] ? "?" : "", $url['query']));
        fputs($fp, "Host: {$url['host']}\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
        fputs($fp, "Content-length: " . strlen($encoded) . "\n");
        fputs($fp, "Connection: close\n\n");
        fputs($fp, "$encoded\n");

        // Read the first line of data, only accept if 200 OK is sent
        $line = fgets($fp, 1024);
        if(!preg_match('#^HTTP/1\\.. 200#', $line)) { return; }

        // Put everything, except the headers to $results 
        $response = "";
		$inheader = TRUE;
        while(!feof($fp))
		{
            $line = fgets($fp, 1024);
            if ($inheader && ($line == "\n" || $line == "\r\n"))
			{
                $inheader = FALSE;
            }
            elseif(!$inheader)
			{
                $response .= $line;
            }
        }
        fclose($fp);
        // Return with data received
        return $response;
	}
}
