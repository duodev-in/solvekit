<x-calc.page
    title="Nusselt Number Calculator - SolveKit"
    description="Free Nusselt number calculator: Nu = hL/k, solved for any value."
    lede="Solve Nu = hL ÷ k."
    about="The Nusselt number compares convection with conduction across a fluid layer."
    :calc="['engine' => 'ph-thermo', 'tool' => 'nusselt', 'fields' => ['solve', 'Nu', 'h', 'L', 'k', 'out_h', 'out_L', 'out_k'], 'unitFields' => ['h' => collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f'])->all(), 'L' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'k' => collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk'])->all()], 'data' => ['units' => collect(config('units'))->only(['Nu', 'energy', 'force', 'heat_transfer_coefficient', 'length', 'mass', 'speed', 'thermal_conductivity'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is Nu for the example?', 'answer' => '50.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['Nu' => 'Nusselt number', 'h' => 'Heat transfer coefficient', 'L' => 'Characteristic length', 'k' => 'Fluid conductivity']" selected="Nu" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:h,L,k" hidden>
            <x-calc.field name="Nu" label="Nusselt number" value="50" step="any" />
        </div>
        <div data-show-when="solve:Nu,L,k">
            <x-calc.field name="h" label="Heat transfer coefficient" value="1000" min="0" placeholder="Heat transfer coefficient">
                <label for="calc-h-unit" class="sr-only">Heat transfer coefficient unit</label>
                <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.heat_transfer_coefficient'))->only(['wm2k', 'kwm2k', 'btuhft2f']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wm2k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Nu,h,k">
            <x-calc.field name="L" label="Characteristic length" value="30" placeholder="Characteristic length">
                <label for="calc-L-unit" class="sr-only">Characteristic length unit</label>
                <select id="calc-L-unit" name="L-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:Nu,h,L">
            <x-calc.field name="k" label="Fluid conductivity" value="0.6" min="0" placeholder="Fluid conductivity">
                <label for="calc-k-unit" class="sr-only">Fluid conductivity unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.thermal_conductivity'))->only(['wmk', 'btuhftf', 'calscmc', 'mwmk']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'wmk')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:h" hidden>
            <x-calc.select name="out_h" label="Show the result in" :options="['wm2k' => 'W/(m²·K)', 'kwm2k' => 'kW/(m²·K)', 'btuhft2f' => 'BTU/(h·ft²·°F)']" selected="wm2k" />
        </div>
        <div data-show-when="solve:L" hidden>
            <x-calc.select name="out_L" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
        <div data-show-when="solve:k" hidden>
            <x-calc.select name="out_k" label="Show the result in" :options="['wmk' => 'W/(m·K)', 'btuhftf' => 'BTU/(h·ft·°F)', 'calscmc' => 'cal/(s·cm·°C)', 'mwmk' => 'mW/(m·K)']" selected="wmk" />
        </div>
    </div>

    <x-calc.result label="Nusselt number" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'Nu', 'Nu' => 50, 'h' => 1000, 'h-unit' => 'wm2k', 'out_h' => 'wm2k', 'L' => 30, 'L-unit' => 'mm', 'out_L' => 'mm', 'k' => 0.6, 'k-unit' => 'wmk', 'out_k' => 'wmk'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'meaning' => ['label' => 'Meaning'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>Nu = h L ÷ k</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
