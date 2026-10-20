<x-calc.page
    title="Centrifuge Calculator - SolveKit"
    description="Free centrifuge calculator: RCF (× g) from rpm and rotor radius, or rpm for a target RCF."
    lede="Convert rpm to RCF (× g)."
    about="Lab protocols give relative centrifugal force, RCF = 1.118 × 10⁻⁵ × r(cm) × rpm². Different rotors need different rpm for the same RCF."
    :calc="['engine' => 'ph-mech', 'tool' => 'centrifuge', 'fields' => ['solve', 'rcf', 'w', 'r', 'out_w', 'out_r'], 'unitFields' => ['w' => collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin'])->all(), 'r' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angular_speed', 'energy', 'force', 'length', 'mass', 'rcf', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What RCF does 10,000 rpm at 10 cm give?', 'answer' => '11,182.4 × g.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['rcf' => 'Relative centrifugal force (× g)', 'w' => 'Rotor speed', 'r' => 'Rotor radius']" selected="rcf" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:w,r" hidden>
            <x-calc.field name="rcf" label="Relative centrifugal force (× g)" value="11180" step="any" />
        </div>
        <div data-show-when="solve:rcf,r">
            <x-calc.field name="w" label="Rotor speed" value="10000" placeholder="Rotor speed">
                <label for="calc-w-unit" class="sr-only">Rotor speed unit</label>
                <select id="calc-w-unit" name="w-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angular_speed'))->only(['rads', 'rpm', 'rps', 'degs', 'radmin']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'rpm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:rcf,w">
            <x-calc.field name="r" label="Rotor radius" value="10" placeholder="Rotor radius">
                <label for="calc-r-unit" class="sr-only">Rotor radius unit</label>
                <select id="calc-r-unit" name="r-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:w" hidden>
            <x-calc.select name="out_w" label="Show the result in" :options="['rads' => 'rad/s', 'rpm' => 'rpm', 'rps' => 'rev/s', 'degs' => '°/s', 'radmin' => 'rad/min']" selected="rpm" />
        </div>
        <div data-show-when="solve:r" hidden>
            <x-calc.select name="out_r" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <x-calc.result label="Relative centrifugal force (× g)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'rcf', 'rcf' => 11180, 'w' => 10000, 'w-unit' => 'rpm', 'out_w' => 'rpm', 'r' => 10, 'r-unit' => 'cm', 'out_r' => 'cm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>RCF = ω² r ÷ g</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
