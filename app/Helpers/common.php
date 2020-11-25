<?php

if (! function_exists('httpCurl')) {
    /**
     * curl request
     *
     * @param  array   $opt
     * @return mixed
     */
    function httpCurl($opt)
    {
        $ch = curl_init($opt['url']);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //返回获取的输出文本流
        if (isset($opt['postData'])) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $opt['postData']);
        }
        if (isset($opt['headerInfo']) && is_array($opt['headerInfo'])) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $opt['headerInfo']);
        }

        if (isset($opt['proxy']) && is_array($opt['proxy'])) {

            curl_setopt($ch, CURLOPT_PROXY, $opt['proxy'][0]);
            curl_setopt($ch, CURLOPT_PROXYPORT, $opt['proxy'][1]);

        }
        
        if (isset($opt['timeout'])) {
            curl_setopt($ch, CURLOPT_TIMEOUT, (int)$opt['timeout']);
        } else {
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        }

        $content = curl_exec($ch);

        curl_close($ch);

        return $content;
    }
}