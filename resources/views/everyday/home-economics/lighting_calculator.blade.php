<x-calc.page
    title="Lighting Calculator - SolveKit"
    description="Free lighting calculator: lumens needed to light a room to a target lux level, and the number of fixtures."
    lede="Work out how much light a room needs."
    about="Lumens = target illuminance (lux) × floor area (m²) ÷ utilization, where utilization (about 0.6–0.8) allows for light lost to walls and fittings. Typical targets: about 100–200 lux for living rooms and bedrooms, 300–500 for kitchens and bathrooms, and 500 for office desks (EN 12464-1). 1 footcandle = 10.76 lux."
    :calc="['engine' => 'ev-home', 'tool' => 'lighting', 'fields' => ['area', 'lux', 'utilization', 'fixture'], 'unitFields' => ['area' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all()]]"
    :how-to="[
        ['name' => 'Enter the room area', 'text' => 'And its use.'],
        ['name' => 'Enter fixture lumens', 'text' => 'From the bulb box.'],
    ]"
    :faqs="[
        ['question' => 'How many lumens for a 200 ft² living room?', 'answer' => 'About 4,000 lumens at 150 lux.'],
        ['question' => 'How many lumens for a kitchen?', 'answer' => 'About 6,400 lumens for a 12 × 10 ft kitchen at 400 lux.'],
        ['question' => 'What is the difference between lux and lumens?', 'answer' => 'Lumens is light from a source; lux is light falling on each square meter.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="area" label="Room area" value="200" min="0" placeholder="Room area">
            <label for="calc-area-unit" class="sr-only">Room area unit</label>
            <select id="calc-area-unit" name="area-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="lux" label="Room type" :options="['150' => 'Living room or bedroom (150 lux)', '300' => 'Bathroom or dining (300 lux)', '400' => 'Kitchen (400 lux)', '500' => 'Office or study (500 lux)', '750' => 'Workshop or detailed tasks (750 lux)']" selected="150" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="utilization" label="Utilization" value="70" min="30" max="100" step="5" suffix="%" />
        <x-calc.field name="fixture" label="Lumens per fixture (optional)" value="800" min="0" />
    </div>

    <x-calc.result label="Light output needed" />

    <x-calc.options :examples="[
        'Living room 200 ft²' => ['area' => 200, 'area-unit' => 'ft2', 'lux' => '150', 'utilization' => 70, 'fixture' => 800],
        'Kitchen 12 × 10 ft' => ['area' => 120, 'area-unit' => 'ft2', 'lux' => '400', 'utilization' => 70, 'fixture' => 1100],
        'Office 20 m²' => ['area' => 20, 'area-unit' => 'm2', 'lux' => '500', 'utilization' => 70, 'fixture' => 3000],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'fixtures' => ['label' => 'Fixtures'],
            'watts' => ['label' => 'LED watts'],
            'footcandles' => ['label' => 'In footcandles'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>lumens = lux × m² ÷ utilization</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
