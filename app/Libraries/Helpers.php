<?php 
namespace App\Libraries;

use Carbon\Carbon;

class Helpers 
{
    public static function upload_file($file, $folder='default'){
		$result    = '';
		$file_name = '';

    	if($file){
			$file_name = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();
			$date      = date('H:i:s');
	    	$result = $file->storeAs('public/'.$folder, md5($file_name . $date).'.'.$extension);
    	}

    	$data = [
			'url'       => str_replace('public/', '', $result),
			'file_name' => $file_name
    	];

    	return $data; 
    }

    public static function download_file(){
    	return \Storage::download('file/default/96886efd3254cab3bd0c12285819c764.jpeg');
    }

    public static function formatDateToMysql($date)
    {
    	return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public static function trelloLog($msg)
    {
        $msg = date('Y-m-d H:i:s') . ' ' . $msg;
        
        $fp = fopen(storage_path('logs/trello.log'), 'a');
        fwrite($fp, $msg);
        fwrite($fp, "\n\n");
        fclose($fp);
    }

    public static function convertfilesize($induction = null)
    {
        $size = ini_get('upload_max_filesize');

        switch(substr($size, -1))
        {
            case 'G': $return = (int)rtrim($size,substr($size, -1)).'000000000';
            break;
            case 'M': $return = (int)rtrim($size,substr($size, -1)).'000000';
            break;
            default : $return = (int)$size;
            break;
        }

        return $return;
    }
}
