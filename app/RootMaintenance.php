<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RootMaintenance extends Model
{
    protected $fillable = [ 'maintenance_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'activity',
                            'description',
                            'amount',
                            'period',
                            'responsable',
                            'font'
                        ];

    protected $table = 'root_maintenances';

}
