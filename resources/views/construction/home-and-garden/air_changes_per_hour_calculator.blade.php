<x-calc.page
    title="Air Changes per Hour Calculator - SolveKit"
    description="Free air changes per hour calculator: ACH from airflow and room volume, or the CFM needed for a target ACH."
    lede="Work out air changes per hour, or the airflow for a target."
    about="ACH = CFM × 60 ÷ room volume (ft³). The reverse gives the CFM needed for a target number of air changes."
    :calc="['engine' => 'con-hvac', 'tool' => 'ach', 'fields' => ['mode', 'floor', 'ceiling', 'cfm', 'target'], 'unitFields' => ['floor' => collect(config('units.area'))->only(['ft2', 'yd2', 'm2', 'acre', 'ha'])->all(), 'ceiling' => collect(config('units.length'))->only(['ft', 'in', 'yd', 'm', 'cm', 'mm'])->all()]]"
    :how-to="[
        ['name' => 'Enter the room size', 'text' => 'Floor area and ceiling height.'],
        ['name' => 'Enter the airflow or a target', 'text' => 'CFM, or the ACH you want.'],
    ]"
    :faqs="[
        ['question' => 'What is a good ACH for a room?', 'answer' => 'It depends on use; ASHRAE 62.2 sets whole-house ventilation in CFM, and workshops or labs often target 6–12 ACH.'],
        ['question' => 'How do I convert ACH to CFM?', 'answer' => 'CFM = ACH × volume ÷ 60.'],
        ['question' => 'What is ACH50?', 'answer' => 'Air changes per hour at 50 Pa in a blower-door test, a measure of airtightness.'],
    ]"
>
    <x-calc.segmented name="mode" legend="Work out" :options="['ach' => 'ACH from CFM', 'cfm' => 'CFM for a target ACH']" selected="ach" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="floor" label="Floor area" value="200" min="0" placeholder="Floor area">
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
    </div>

    <div data-show-when="mode:ach">
        <x-calc.field name="cfm" label="Airflow" value="160" min="0" suffix="CFM" />
    </div>

    <div data-show-when="mode:cfm" hidden>
        <x-calc.field name="target" label="Target ACH" value="6" min="0" step="0.5" />
    </div>

    <x-calc.result label="Air changes per hour" />

    <x-calc.options :examples="[
        '200 ft² room, 160 CFM' => ['mode' => 'ach', 'floor' => 200, 'floor-unit' => 'ft2', 'ceiling' => 8, 'ceiling-unit' => 'ft', 'cfm' => 160],
        'Workshop, 8 ACH' => ['mode' => 'cfm', 'floor' => 600, 'floor-unit' => 'ft2', 'ceiling' => 10, 'ceiling-unit' => 'ft', 'target' => 8],
        'Metric room' => ['mode' => 'cfm', 'floor' => 20, 'floor-unit' => 'm2', 'ceiling' => 2.5, 'ceiling-unit' => 'm', 'target' => 4],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'm3h' => ['label' => 'Cubic meters per hour'],
            'ls' => ['label' => 'Liters per second'],
            'volume' => ['label' => 'Room volume'],
            'minutes' => ['label' => 'Air change time'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>ACH = CFM × 60 ÷ V</li>
            <li>CFM = ACH × V ÷ 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
