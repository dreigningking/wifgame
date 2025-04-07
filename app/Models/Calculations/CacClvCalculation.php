<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class CacClvCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'marketing_spend',
        'sales_spend',
        'new_customers',
        'result_cac',
        'average_purchase_value',
        'purchase_frequency',
        'customer_lifespan',
        'result_clv',
        'result_clv_cac_ratio',
        'segmentation_data',
        'historical_trends',
        'notes'
    ];

    protected $casts = [
        'segmentation_data' => 'array',
        'historical_trends' => 'array',
        'marketing_spend' => 'decimal:2',
        'sales_spend' => 'decimal:2',
        'result_cac' => 'decimal:2',
        'average_purchase_value' => 'decimal:2',
        'purchase_frequency' => 'decimal:2',
        'customer_lifespan' => 'decimal:2',
        'result_clv' => 'decimal:2',
        'result_clv_cac_ratio' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // CAC/CLV calculation logic will be implemented here
        return [
            'cac' => 0,
            'clv' => 0,
            'clv_cac_ratio' => 0
        ];
    }
} 