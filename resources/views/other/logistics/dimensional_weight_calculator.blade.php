<x-calc.page
    title="Dimensional Weight Calculator - SolveKit"
    description="Free dimensional weight calculator: volumetric and billable weight for FedEx, UPS, USPS and DHL."
    lede="Find the billable weight."
    about="Carriers charge for the larger of actual weight and dimensional weight (volume ÷ a divisor)."
    :calc="['engine' => 'ot-misc', 'tool' => 'dim_weight', 'fields' => ['carrier', 'divisor', 'l', 'w', 'h', 'actual'], 'unitFields' => ['l' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'w' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'actual' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass'])->all(), 'other' => collect(config('other_data'))->only(['dim_divisors'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is billed for a 50 × 40 × 30 cm, 8 kg box (FedEx/UPS)?', 'answer' => '12.701 kg.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="carrier" label="Carrier rule" :options="['fedex_ups' => 'FedEx / UPS daily rates (139 in³/lb)', 'ups_retail' => 'UPS retail rates (166 in³/lb)', 'usps' => 'USPS (139 in³/lb, parcels over 1 ft³)', 'dhl' => 'DHL Express (5,000 cm³/kg)', 'air_6000' => 'Air freight / some couriers (6,000 cm³/kg)', 'custom' => 'Other (enter the value)']" selected="fedex_ups" />
        <div data-show-when="carrier:custom">
            <x-calc.field name="divisor" label="Divisor (custom, cm³/kg)" value="5000" min="1" step="any" />
        </div>
        <x-calc.field name="l" label="Length" value="50" placeholder="Length">
            <label for="calc-l-unit" class="sr-only">Length unit</label>
            <select id="calc-l-unit" name="l-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="w" label="Width" value="40" placeholder="Width">
            <label for="calc-w-unit" class="sr-only">Width unit</label>
            <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="h" label="Height" value="30" placeholder="Height">
            <label for="calc-h-unit" class="sr-only">Height unit</label>
            <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.field name="actual" label="Actual weight" value="8" min="0" placeholder="Actual weight">
            <label for="calc-actual-unit" class="sr-only">Actual weight unit</label>
            <select id="calc-actual-unit" name="actual-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
    </div>

    <x-calc.result label="Billable weight" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['carrier' => 'fedex_ups', 'divisor' => 5000, 'l' => 50, 'l-unit' => 'cm', 'w' => 40, 'w-unit' => 'cm', 'h' => 30, 'h-unit' => 'cm', 'actual' => 8, 'actual-unit' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'dim' => ['label' => 'Dimensional weight'],
            'actualRow' => ['label' => 'Actual weight'],
            'applies' => ['label' => 'Rule'],
            'imperial' => ['label' => 'In pounds'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
