<x-calc.page
    title="Frequency of Light Calculator - SolveKit"
    description="Free frequency of light calculator: f = c/λ with photon energy and spectral region."
    lede="Solve f = c ÷ λ."
    about="Light’s frequency is the speed of light divided by its wavelength. Green light at 550 nm vibrates 545 trillion times a second."
    :calc="['engine' => 'ph-quantum', 'tool' => 'light_frequency', 'fields' => ['solve', 'f', 'lambda', 'out_f', 'out_lambda'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'f', 'force', 'frequency_hz', 'length', 'mass', 'speed'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is the frequency of 550 nm light?', 'answer' => '545.077 THz.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['f' => 'Frequency', 'lambda' => 'Wavelength (vacuum)']" selected="f" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:lambda" hidden>
            <x-calc.field name="f" label="Frequency" value="545.077" min="0" placeholder="Frequency">
                <label for="calc-f-unit" class="sr-only">Frequency unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'thz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f">
            <x-calc.field name="lambda" label="Wavelength (vacuum)" value="550" placeholder="Wavelength (vacuum)">
                <label for="calc-lambda-unit" class="sr-only">Wavelength (vacuum) unit</label>
                <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f">
            <x-calc.select name="out_f" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="thz" />
        </div>
        <div data-show-when="solve:lambda" hidden>
            <x-calc.select name="out_lambda" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
        </div>
    </div>

    <x-calc.result label="Frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'f', 'f' => 545.077, 'f-unit' => 'thz', 'out_f' => 'thz', 'lambda' => 550, 'lambda-unit' => 'nm', 'out_lambda' => 'nm'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'E' => ['label' => 'Photon energy'],
            'band' => ['label' => 'Region of the spectrum'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f = c ÷ λ</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
