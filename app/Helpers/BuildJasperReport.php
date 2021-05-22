<?php

namespace App\Helpers;

use PHPJasper\PHPJasper;

class BuildJasperReport
{
    
    /**
     * @var string
     */
    protected $pathInput;

    /**
     * @var string
     */
    protected $pathOutput;

    /**
     * @var string
     */
    protected $tenancy;

    public function __construct() {

        $this->tenancy = session()->get('tenant', 'public');
        $this->pathInput = public_path() . '/reports/';
        $this->pathOutput = public_path() . '/reports/gerados/';
        

    }
/**
     * Reporna um array com os parametros de conexão
     * @return Array
     */
    public function getDatabaseConfig()
        {
            return [ 
                'driver'   =>'postgres',
                'host'     => env('DB_HOST'),
                'port'     => env('DB_PORT'),
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'database' => env('DB_DATABASE'),
                //'jdbc_dir' => base_path() . env('JDBC_DIR', '/vendor/lavela/phpjasper/src/JasperStarter/jdbc'),
            ];
        }

    public function gera(bool $customReport , string $reportName, string $format, array $params=[] ){

        $output = $this->pathOutput . time() . '_' . $reportName;
        $input = $customReport ? $this->pathInput . $this->tenancy . '/' . $reportName . '.jrxml' : $this->pathInput . $reportName . '.jrxml';
        
        $report = new PHPJasper;
        
        $rel_params = ['schema' => $this->tenancy.'.'];
        $rel_params = $params ? array_merge($rel_params,$params) : $rel_params;
        
        $report->process(
            $input,
            $output,
            ['format' => [$format],
            'locale' => 'pt',
            'params' => $rel_params,
            'db_connection' => $this->getDatabaseConfig()]
        )->execute();

        $file = $output . '.' . $format;
        
        $path = $file;
        
        if (!file_exists($file)) {
            abort(404);
        }

        $file = file_get_contents($file);
        //dd($file);
        unlink($path);

        // retornamos o conteudo para o navegador que íra abrir o PDF
        //return $file;
        return response($file, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . time() . '_' . $reportName . '"');

    }  
    
}
