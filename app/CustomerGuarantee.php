<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGuarantee extends Model
{
    protected $fillable = [ 'condominium_id',
                            'guarantee_id',
                            'group_id',
                            'item_id',
                            'subitem_id',
                            'start_date',
                            'amount',
                            'periodo',
                            'due_date',
                            'is_active',
                            'is_expired',
                            'reference'
                        ];
                        
    protected $table = 'customer_guarantees';
         
}
