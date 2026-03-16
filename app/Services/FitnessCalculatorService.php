<?php

namespace App\Services;

use Carbon\Carbon;

class FitnessCalculatorService
{
    public function calculateAcsmRiskClass($age, $gender, $answers)
    {
        $riskFactors = 0;
        $hasChronicDisease = false;

        if ($answers['has_cardiovascular_disease'] ?? false) $hasChronicDisease = true;
        if ($answers['has_metabolic_disease'] ?? false) $hasChronicDisease = true;
        if ($answers['has_renal_disease'] ?? false) $hasChronicDisease = true;
        if ($answers['has_respiratory_disease'] ?? false) $hasChronicDisease = true;

        if ($hasChronicDisease) {
            return ['class' => 'B', 'intensity_min' => 0, 'intensity_max' => 39];
        }

        if ($answers['is_smoker'] ?? false) $riskFactors++;
        if ($answers['is_sedentary'] ?? false) $riskFactors++;
        if ($answers['family_history'] ?? false) $riskFactors++;
        if ($answers['obesity'] ?? false) $riskFactors++;
        if ($answers['hypertension'] ?? false) $riskFactors++;
        if ($answers['dyslipidemia'] ?? false) $riskFactors++;
        if ($answers['prediabetes'] ?? false) $riskFactors++;

        if ($answers['high_hdl'] ?? false) $riskFactors--;

        $isOld = ($gender === 'male' && $age >= 45) || ($gender === 'female' && $age >= 55);

        if (!$isOld && $riskFactors <= 1) {
            return ['class' => 'A1', 'intensity_min' => 60, 'intensity_max' => 80];
        }

        if ($isOld && $riskFactors == 0) {
            return ['class' => 'A2', 'intensity_min' => 60, 'intensity_max' => 80];
        }

        if ($riskFactors >= 2 ||
            ($answers['hypertension'] ?? false) ||
            ($answers['dyslipidemia'] ?? false) ||
            ($answers['obesity'] ?? false) ||
            ($answers['prediabetes'] ?? false)) {
            return ['class' => 'A3', 'intensity_min' => 40, 'intensity_max' => 60];
        }

        return ['class' => 'A1', 'intensity_min' => 60, 'intensity_max' => 80];
    }

    public function calculateVo2Max($testType, $data, $member)
    {
        $age = $member->age;
        $gender = $member->gender === 'male' ? 1 : 0;
        $weight = $data['weight'];
        $time = $data['time'] ?? 0;
        $hr = $data['heart_rate'] ?? 0;

        $vo2max = 0;

        switch ($testType) {
            case 'rockport_walk':
                $vo2max = 132.853 - (0.0769 * ($weight * 2.20462)) - (0.3877 * $age) + (6.315 * $gender) - (3.2649 * $time) - (0.1565 * $hr);
                break;

            case 'one_mile_run':
                $vo2max = 108.844 - (0.1636 * $weight) - (1.438 * $time) - (0.1928 * $hr);
                break;

            case 'cooper':
                $distance = $data['distance'];
                $vo2max = ($distance - 504.9) / 44.73;
                break;

            case 'watt_bike':
                $watts = $data['watts'];
                $vo2max = (10.8 * $watts / $weight) + 7;
                break;
        }

        return round($vo2max, 2);
    }

    public function calculateNorm($testName, $value, $age, $gender)
    {
        // Buraya yüzlerce if/else veya veritabanından norm tablosu sorgusu gelecek.
        // Örnek:
        if ($testName === 'push_up') {
            if ($value > 30) return 'Mükemmel';
            if ($value > 20) return 'İyi';
            return 'Geliştirilmeli';
        }

        return 'Standart';
    }
}
