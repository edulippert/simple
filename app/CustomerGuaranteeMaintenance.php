<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerGuaranteeMaintenance extends Model
{
    protected $fillable = ['customer_guarantee_id',
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

    protected $table = 'customer_guarantee_maintenances';
}
