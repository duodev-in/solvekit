<x-calc.page
    title="Diametral Pitch Calculator - SolveKit"
    description="Free diametral pitch calculator: teeth per inch of pitch diameter, with module and circular pitch."
    lede="Solve P = N ÷ D."
    about="Diametral pitch is the number of teeth per inch of pitch diameter. Metric gears use the module, m = 25.4/P mm."
    :calc="['engine' => 'ph-mach', 'tool' => 'diametral_pitch', 'fields' => ['solve', 'P', 'N', 'Dp', 'out_Dp'], 'unitFields' => ['Dp' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['P', 'energy', 'force', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the pitch of a 30-tooth gear of 3 in pitch diameter?', 'answer' => '10.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['P' => 'Diametral pitch (teeth per inch)', 'N' => 'Number of teeth', 'Dp' => 'Pitch diameter']" selected="P" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:N,Dp" hidden>
            <x-calc.field name="P" label="Diametral pitch (teeth per inch)" value="10" step="any" />
        </div>
        <div data-show-when="solve:P,Dp">
            <x-calc.field name="N" label="Number of teeth" value="30" step="any" />
        </div>
        <div data-show-when="solve:P,N">
            <x-calc.field name="Dp" label="Pitch diameter" value="3" placeholder="Pitch diameter">
                <label for="calc-Dp-unit" class="sr-only">Pitch diameter unit</label>
                <select id="calc-Dp-unit" name="Dp-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Dp" hidden>
            <x-calc.select name="out_Dp" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="in" />
        </div>
    </div>

    <x-calc.result label="Diametral pitch (teeth per inch)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'P', 'P' => 10, 'N' => 30, 'Dp' => 3, 'Dp-unit' => 'in', 'out_Dp' => 'in'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'module' => ['label' => 'Metric module'],
            'cp' => ['label' => 'Circular pitch'],
            'od' => ['label' => 'Outside diameter (D + 2/P)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>P = N ÷ D</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
