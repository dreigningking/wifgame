<?php

namespace App\Models\Calculations;

use App\Models\BaseCalculation;

class AbTestCalculation extends BaseCalculation
{
    protected $fillable = [
        'user_id',
        'calculator_id',
        'test_name',
        'control_visitors',
        'control_conversions',
        'variant_visitors',
        'variant_conversions',
        'minimum_detectable_effect',
        'confidence_level',
        'control_conversion_rate',
        'variant_conversion_rate',
        'absolute_difference',
        'relative_difference',
        'statistical_significance',
        'is_significant',
        'result_confidence_interval',
        'test_details',
        'segment_analysis',
        'notes'
    ];

    protected $casts = [
        'test_details' => 'array',
        'segment_analysis' => 'array',
        'minimum_detectable_effect' => 'decimal:2',
        'confidence_level' => 'decimal:2',
        'control_conversion_rate' => 'decimal:2',
        'variant_conversion_rate' => 'decimal:2',
        'absolute_difference' => 'decimal:2',
        'relative_difference' => 'decimal:2',
        'statistical_significance' => 'decimal:2',
        'is_significant' => 'boolean',
        'result_confidence_interval' => 'decimal:2'
    ];

    public function calculate(): array
    {
        // A/B Test calculation logic will be implemented here
        return [
            'control_conversion_rate' => 0,
            'variant_conversion_rate' => 0,
            'absolute_difference' => 0,
            'relative_difference' => 0,
            'statistical_significance' => 0,
            'is_significant' => false,
            'confidence_interval' => 0
        ];
    }
} 