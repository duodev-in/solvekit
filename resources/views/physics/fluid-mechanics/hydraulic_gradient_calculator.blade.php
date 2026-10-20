<x-calc.page
    title="Hydraulic Gradient Calculator - SolveKit"
    description="Free hydraulic gradient calculator: i = Δh/L, solved for any value."
    lede="Solve i = Δh ÷ L."
    about="The hydraulic gradient is the drop in head per unit distance along the flow."
    :calc="['engine' => 'ph-fluid', 'tool' => 'hydraulic_gradient', 'fields' => ['solve', 'i', 'dh', 'L', 'out_dh', 'out_L'], 'unitFields' => ['dh' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'i', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is i for 2 m over 200 m?', 'answer' => '0.01.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['i' => 'Hydraulic gradient', 'dh' => 'Head difference', 'L' => 'Distance']" selected="i" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:dh,L" hidden>
            <x-calc.field name="i" label="Hydraulic gradient" value="0.01" step="any" />
        </div>
        <div data-show-when="solve:i,L">
            <x-calc.field name="dh" label="Head difference" value="2" placeholder="Head difference">
                <label for="calc-dh-unit" class="sr-only">Head difference unit</label>
                <select id="calc-dh-unit" name="dh-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:i,dh">
            <x-calc.field name="L" label="Distance" value="200" placeholder="Distance">
                <label for="calc-L-unit" class="sr-only">Distance unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:dh" hidden>
            <x-calc.select name="out_dh" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
        </div>
    </div>

    <x-calc.result label="Hydraulic gradient" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'i', 'i' => 0.01, 'dh' => 2, 'dh-unit' => 'm', 'out_dh' => 'm', 'L' => 200, 'L-unit' => 'm', 'out_L' => 'm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'pct' => ['label' => 'As a percentage'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>i = Δh ÷ L</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
