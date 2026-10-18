<x-calc.page
    title="Idling Fuel Consumption Calculator - SolveKit"
    description="Free idling fuel consumption calculator: fuel, money and CO₂ wasted idling a car each year, from engine size and minutes a day."
    lede="See how much fuel and money idling wastes."
    about="Natural Resources Canada estimates an idling engine burns about 0.6 L of fuel an hour for each liter of engine size: a 3-liter engine uses about 300 mL every 10 minutes. Air conditioning and other loads raise it. NRCan suggests turning the engine off if you will be stopped for more than 60 seconds, except in traffic."
    :calc="['engine' => 'ev-transport', 'tool' => 'idling', 'fields' => ['rate_mode', 'engine', 'rate', 'minutes', 'days', 'price', 'price_unit', 'fuel'], 'data' => ['fuels' => config('ecology_data.fuels'), 'idle' => config('everyday_data.idle')]]"
    :how-to="[
        ['name' => 'Enter the engine size', 'text' => 'Or your own idle fuel rate.'],
        ['name' => 'Enter minutes a day', 'text' => 'Warm-ups, drive-throughs, waiting.'],
    ]"
    :faqs="[
        ['question' => 'How much gas does idling use?', 'answer' => 'About 0.6 L an hour per liter of engine: 1.8 L (0.48 gal) an hour for a 3-liter engine.'],
        ['question' => 'Is restarting worse than idling?', 'answer' => 'NRCan says restarting uses less fuel than idling for more than 10 seconds.'],
        ['question' => 'Should I idle to warm up?', 'answer' => 'No, driving gently warms a modern engine faster.'],
    ]"
>
    <x-calc.segmented name="rate_mode" legend="Idle fuel rate" :options="['engine' => 'From engine size', 'own' => 'My own rate']" selected="engine" />

    <div data-show-when="rate_mode:engine">
        <x-calc.field name="engine" label="Engine size" value="3" min="0.5" max="15" step="0.1" suffix="L" />
    </div>

    <div data-show-when="rate_mode:own" hidden>
        <x-calc.field name="rate" label="Idle fuel use" value="1.8" min="0" step="0.1" suffix="L/h" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="minutes" label="Idling a day" value="10" min="0" step="1" suffix="min" />
        <x-calc.field name="days" label="Days a year" value="300" min="1" max="366" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <x-calc.field name="price" label="Fuel price" value="3.5" min="0" step="0.01" suffix="$" />
        <x-calc.select name="price_unit" label="Price" :options="['gal' => 'per US gallon', 'l' => 'per liter', 'gal_uk' => 'per UK gallon']" selected="gal" />
        <x-calc.select name="fuel" label="Fuel" :options="['us_gasoline' => 'Gasoline (EPA)', 'us_diesel' => 'Diesel (EPA)', 'uk_petrol' => 'Petrol, UK blend (DESNZ)', 'uk_diesel' => 'Diesel, UK blend (DESNZ)']" selected="us_gasoline" />
    </div>

    <x-calc.result label="Fuel burned idling a year" />

    <x-calc.options :examples="[
        '3 L engine, 10 min a day' => ['rate_mode' => 'engine', 'engine' => 3, 'rate' => '', 'minutes' => 10, 'days' => 300, 'price' => 3.5, 'price_unit' => 'gal', 'fuel' => 'us_gasoline'],
        'Diesel pickup, 30 min' => ['rate_mode' => 'engine', 'engine' => 6.7, 'rate' => '', 'minutes' => 30, 'days' => 250, 'price' => 3.9, 'price_unit' => 'gal', 'fuel' => 'us_diesel'],
        'Own rate, metric' => ['rate_mode' => 'own', 'engine' => '', 'rate' => 1.2, 'minutes' => 15, 'days' => 220, 'price' => 1.6, 'price_unit' => 'l', 'fuel' => 'uk_petrol'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'cost' => ['label' => 'Cost'],
            'co2' => ['label' => 'CO₂'],
            'ten' => ['label' => 'Every 10 minutes'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>L/h ≈ 0.6 × engine liters (NRCan)</li>
            <li>fuel = L/h × hours</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
