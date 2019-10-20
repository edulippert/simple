<?php
declare(strict_types=1);
namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class File extends Model
{
    protected $fillable = ['file','name','type','subtype'];

    protected $table = 'files';

    const BASE_PATH = 'app/public';

    public static function createFiles($files):Collection{
        try {
            
            self::uploadFiles($files);
            DB::beginTransaction();
            $files = self::createFileModels($files);
            DB::commit();
            return new Collection($files);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    public static function uploadFiles($files){
        $dir = 'attendance';
        dd($files); 
        $files->store($dir,['disk'=>'public']);
        //}
    }

    private static function createFileModels($files):array{
        
        //foreach ($files as $file){
            $files =self::create([
                'file' => 'attendance',
                'name' => $files->hashName(),
                'type' => 'pdf',
                'subtypo' => 'pdf'
            ]); 
        //}
        return $files;
    }
}
