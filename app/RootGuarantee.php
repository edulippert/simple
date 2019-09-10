<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RootGuarantee extends Model
{
    protected $fillable = [ 'guarantee_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'amount',
                            'period',
                            'is_active',
                            'reference'
                        ];
    
    protected $table = 'root_guarantees';

    public function root_maintenaces(){
        return $this->hasMany(RootMaintenance::class);
    }

    public function guarantees(){
        return $this->belongsTo(Guarantee::class);
    }
}
