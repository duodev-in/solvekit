<x-calc.page
    title="Smog Calculator - SolveKit"
    description="Free smog calculator: US EPA Air Quality Index (AQI) from PM2.5, PM10, ozone, carbon monoxide, sulfur dioxide and nitrogen dioxide concentrations, with health advice."
    lede="Work out the Air Quality Index from pollutant concentrations."
    about="Each pollutant's concentration is truncated and placed in the US EPA breakpoint table (updated in 2024 for PM2.5); the AQI is interpolated within its band. The overall AQI is the highest of the pollutants, and its band gives the category and health message. Enter averages over the stated periods (24-hour for particles, 8-hour for ozone and CO, 1-hour for SO₂ and NO₂)."
    :calc="['engine' => 'eco-science', 'tool' => 'smog', 'fields' => ['pm25', 'pm10', 'o3_8h', 'o3_1h', 'co', 'no2', 'so2', 'so2_24h'], 'data' => ['aqi' => config('ecology_data.aqi')]]"
    :how-to="[
        ['name' => 'Enter the concentrations you have', 'text' => 'One or more pollutants.'],
        ['name' => 'Read the AQI', 'text' => 'The highest pollutant sets it.'],
    ]"
    :faqs="[
        ['question' => 'What PM2.5 is unhealthy?', 'answer' => 'Above 55.4 µg/m³ (24-hour) is Unhealthy on the 2024 EPA scale; 35.5–55.4 is Unhealthy for Sensitive Groups.'],
        ['question' => 'What is a good AQI?', 'answer' => '0–50.'],
        ['question' => 'Is this the same in every country?', 'answer' => 'No, India, China and the EU use different scales; this is the US EPA AQI.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="pm25" label="PM2.5, 24-hour" value="30" min="0" step="0.1" suffix="µg/m³" />
        <x-calc.field name="pm10" label="PM10, 24-hour" value="" min="0" suffix="µg/m³" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="o3_8h" label="Ozone, 8-hour" value="" min="0" step="0.001" suffix="ppm" placeholder="Optional" />
        <x-calc.field name="o3_1h" label="Ozone, 1-hour" value="" min="0" step="0.001" suffix="ppm" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="co" label="Carbon monoxide, 8-hour" value="" min="0" step="0.1" suffix="ppm" placeholder="Optional" />
        <x-calc.field name="no2" label="Nitrogen dioxide, 1-hour" value="" min="0" suffix="ppb" placeholder="Optional" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="so2" label="Sulfur dioxide, 1-hour" value="" min="0" suffix="ppb" placeholder="Optional" />
        <x-calc.field name="so2_24h" label="Sulfur dioxide, 24-hour (305 ppb and up)" value="" min="0" suffix="ppb" placeholder="Optional" />
    </div>

    <x-calc.result label="Air Quality Index" />

    <x-calc.options :examples="[
        'Smoggy day, PM2.5 30' => ['pm25' => 30, 'pm10' => '', 'o3_8h' => '', 'o3_1h' => '', 'co' => '', 'no2' => '', 'so2' => '', 'so2_24h' => ''],
        'Ozone 0.078 ppm' => ['pm25' => '', 'pm10' => '', 'o3_8h' => 0.078, 'o3_1h' => '', 'co' => '', 'no2' => '', 'so2' => '', 'so2_24h' => ''],
        'Wildfire smoke' => ['pm25' => 180, 'pm10' => 220, 'o3_8h' => 0.06, 'o3_1h' => '', 'co' => 3, 'no2' => 40, 'so2' => '', 'so2_24h' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'category' => ['label' => 'Category'],
            'pollutant' => ['label' => 'Set by'],
            'advice' => ['label' => 'Health advice'],
        ]" />
        <x-calc.quick-ref heading="Each pollutant" name="pollutants" :generated="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>AQI = (I_hi − I_lo) ÷ (C_hi − C_lo) × (C − C_lo) + I_lo</li>
            <li>overall AQI = highest pollutant</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
