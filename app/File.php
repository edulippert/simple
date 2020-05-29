<?php
declare(strict_types=1);
namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class File extends Model
{
    protected $fillable = ['file','name','type','subtype'];

    protected $table = 'files';

    const BASE_PATH = 'app/public';
    const DIR_ATTACHMENTS = 'attachments';

    const ATTACHMENTS_PATH = self::BASE_PATH . '/' . self::DIR_ATTACHMENTS;

    public static function createFile($request, $subtype,$id_sender=1){
        
        
        
        $file = self::create([
            'file' => $request->file('file')->getClientOriginalName(),
            'name' => $request->file('file')->hashName(),
            'type' => $request->file('file')->getClientOriginalExtension(),
            'subtype' => $subtype
        ]);

        $file->refresh();

        $file_path = (self::DIR_ATTACHMENTS.'/'.$subtype.'/'.$file->id);

        $fileName = $file->name;   
        
        //$dir = self::attachmentsPath($file_path);

        $path = Storage::disk('s3')->put($file_path, $request->file);

        //$path = $request->file('file')->store('teste', 's3');
        
        //$path = $request->file('file')->move($dir,$fileName);
        
        $file_url = $file_path.'/'.$file->name;    

        return $response = [
            'file_url' =>  $file_url,
            'file_id' => $file->id
        ];
    }

    public static function downloadFile($file_id)
    {

        $file = File::find($file_id);

        if ($file) {
      
            $completePath = '/'.$file->subtype.'/'.$file->id.'/'.$file->name;

            //$completePath = $file->file_path.'/'.$file->hash_name;
            
            $dir = self::attachmentsPath($completePath);

            return response()->download($dir,$file->file);
            
        }else{
            $file_error = ['file_id' => ['Arquivo nao localizado no banco. ID = '.$file_id]];
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $file_error],422);
        }    
    }

    public static function deleteFile($file){
        
        
        $file_path = '/'.$file->subtype.'/'.$file->id;

        $dir = self::attachmentsPath($file_path);
        
        $file->delete();

        \File::deleteDirectory($dir);

        return response()->json([],204);
        
    }

    public static function attachmentsPath($attachPath)
    {
        $path = self::ATTACHMENTS_PATH;
        return storage_path("{$path}{$attachPath}");
    }

}