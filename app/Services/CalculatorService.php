<?php

namespace App\Services;

use App\Models\Calculator;
use App\Models\CalculatorRequest;
use Illuminate\Support\Facades\Auth;

class CalculatorService
{
    public function execute(Calculator $calculator, array $input)
    {
        // Create request record
        $request = CalculatorRequest::create([
            'calculator_id' => $calculator->id,
            'user_id' => Auth::id(),
            'input_data' => $input,
            'status' => 'processing'
        ]);

        try {
            // Validate input against parameters
            $this->validateInput($calculator->parameters, $input);

            // Execute calculator code
            $result = $this->executeCalculatorCode($calculator->code, $input);

            // Update request status
            $request->update([
                'status' => 'completed',
                'result' => $result
            ]);

            // Increment usage stats
            $calculator->incrementUsage();

            return $result;
        } catch (\Exception $e) {
            $request->update([
                'status' => 'failed',
                'error' => $e->getMessage()
            ]);

            throw $e;
        }
    }

    protected function validateInput(array $parameters, array $input)
    {
        foreach ($parameters as $param) {
            if (!isset($input[$param['name']])) {
                throw new \InvalidArgumentException("Missing required parameter: {$param['name']}");
            }

            // Add more validation based on parameter type
            switch ($param['type']) {
                case 'number':
                    if (!is_numeric($input[$param['name']])) {
                        throw new \InvalidArgumentException("Parameter {$param['name']} must be a number");
                    }
                    break;
                case 'boolean':
                    if (!is_bool($input[$param['name']])) {
                        throw new \InvalidArgumentException("Parameter {$param['name']} must be a boolean");
                    }
                    break;
                // Add more types as needed
            }
        }
    }

    protected function executeCalculatorCode(string $code, array $input)
    {
        // Create a safe execution environment
        $sandbox = new \stdClass();
        $sandbox->input = $input;
        $sandbox->result = null;

        // Execute the code in a sandbox
        $execution = function() use ($code, $sandbox) {
            eval($code);
            return $sandbox->result;
        };

        return $execution();
    }
} 