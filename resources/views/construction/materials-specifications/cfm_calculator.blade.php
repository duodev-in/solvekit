<x-calc.page
    title="CFM Calculator - SolveKit"
    description="Free CFM calculator: airflow in cubic feet per minute from room volume and air changes, duct size and velocity, or heating output and temperature rise."
    lede="Work out airflow in CFM."
    about="Three ways: room volume × ACH ÷ 60; duct area × air velocity (ft/min); or, for a furnace or coil, Btu/h ÷ (1.08 × temperature change in °F), where 1.08 = 0.075 lb/ft³ × 0.24 Btu/(lb·°F) × 60 min/h for standard air."
    :calc="['engine' => 'con-hvac', 'tool' => 'cfm', 'fields' => ['mode', 'floor', 'ceiling', 'ach', 'duct', 'velocity', 'diameter', 'duct_width', 'duct_height', 'btu', 'rise'], 'unitFields' => ['floor' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'ceiling' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all(), 'diameter' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'duct_width' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all(), 'duct_height' => collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm'])->all()]]"
    :how-to="[
        ['name' => 'Choose the method', 'text' => 'Room, duct or heat.'],
        ['name' => 'Enter the values', 'text' => 'In any units.'],
    ]"
    :faqs="[
        ['question' => 'What CFM does an 8 in duct carry?', 'answer' => 'About 244 CFM at 700 ft/min.'],
        ['question' => 'What is 1.08 in the CFM formula?', 'answer' => 'The heat carried by 1 CFM of standard air per °F per hour.'],
        ['question' => 'How many CFM per ton of cooling?', 'answer' => 'Typically about 350–400 CFM per ton.'],
    ]"
>
    <x-calc.segmented name="mode" legend="From" :options="['room' => 'Room and ACH', 'duct' => 'Duct and velocity', 'heat' => 'Heat and ΔT']" selected="room" />

    <div data-show-when="mode:room">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-calc.field name="floor" label="Floor area" value="300" min="0" placeholder="Floor area">
                <label for="calc-floor-unit" class="sr-only">Floor area unit</label>
                <select id="calc-floor-unit" name="floor-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft2')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="ceiling" label="Ceiling height" value="8" min="0" placeholder="Ceiling height">
                <label for="calc-ceiling-unit" class="sr-only">Ceiling height unit</label>
                <select id="calc-ceiling-unit" name="ceiling-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'ft')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="ach" label="Air changes per hour" value="6" min="0" step="0.5" />
        </div>
    </div>

    <div data-show-when="mode:duct" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="duct" label="Duct" :options="['round' => 'Round', 'rect' => 'Rectangular']" selected="round" />
            <x-calc.field name="velocity" label="Air velocity" value="700" min="0" suffix="ft/min" />
        </div>
    </div>

    <div data-show-when="mode:duct" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <div data-show-when="duct:round">
                <x-calc.field name="diameter" label="Diameter" value="8" min="0" placeholder="Diameter">
                    <label for="calc-diameter-unit" class="sr-only">Diameter unit</label>
                    <select id="calc-diameter-unit" name="diameter-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="duct:rect" hidden>
                <x-calc.field name="duct_width" label="Width" value="12" min="0" placeholder="Width">
                    <label for="calc-duct_width-unit" class="sr-only">Width unit</label>
                    <select id="calc-duct_width-unit" name="duct_width-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="duct:rect" hidden>
                <x-calc.field name="duct_height" label="Height" value="8" min="0" placeholder="Height">
                    <label for="calc-duct_height-unit" class="sr-only">Height unit</label>
                    <select id="calc-duct_height-unit" name="duct_height-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['in', 'cm', 'mm', 'ft', 'm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
        </div>
    </div>

    <div data-show-when="mode:heat" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="btu" label="Output" value="60000" min="0" suffix="Btu/h" />
            <x-calc.field name="rise" label="Air temperature change" value="50" min="0" suffix="°F" />
        </div>
    </div>

    <x-calc.result label="Airflow" />

    <x-calc.options :examples="[
        '300 ft² at 6 ACH' => ['mode' => 'room', 'floor' => 300, 'floor-unit' => 'ft2', 'ceiling' => 8, 'ceiling-unit' => 'ft', 'ach' => 6],
        '8 in duct at 700 ft/min' => ['mode' => 'duct', 'duct' => 'round', 'diameter' => 8, 'diameter-unit' => 'in', 'velocity' => 700],
        'Furnace 60,000 Btu/h, 50 °F rise' => ['mode' => 'heat', 'btu' => 60000, 'rise' => 50],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm3h' => ['label' => 'Cubic meters per hour'],
            'ls' => ['label' => 'Liters per second'],
            'm3s' => ['label' => 'Cubic meters per second'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>CFM = V × ACH ÷ 60</li>
            <li>CFM = A × velocity</li>
            <li>CFM = Btu/h ÷ (1.08 × ΔT)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
