<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RootMaintenance extends Model
{
    protected $fillable = [ 'root_guarantee_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'activity',
                            'description',
                            'amount',
                            'periodo',
                            'responsable',
                            'font'
                        ];

    protected $table = 'root_maintenances';

    public function root_guarantees()
    {
        return $this->belongsTo(RootGuarantee::class);
    }
}
