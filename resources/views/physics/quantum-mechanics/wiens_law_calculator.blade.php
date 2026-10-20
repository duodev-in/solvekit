<x-calc.page
    title="Wien's Law Calculator - SolveKit"
    description="Free Wien's displacement law calculator: peak wavelength from temperature, or temperature from colour."
    lede="Solve λ_max = b ÷ T."
    about="Hotter bodies glow at shorter wavelengths: λ_max = 2.898 mm·K ÷ T. The Sun peaks in green-blue; people peak at about 9 µm in the infrared."
    :calc="['engine' => 'ph-quantum', 'tool' => 'wien', 'fields' => ['solve', 'lambda', 'T', 'out_lambda', 'out_T'], 'unitFields' => ['lambda' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'T' => collect(config('units.temperature'))->only(['c', 'f', 'k', 'r'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'lambda', 'length', 'mass', 'speed', 'temperature'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'Where does the Sun’s spectrum peak?', 'answer' => '502.039 nm.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['lambda' => 'Peak wavelength', 'T' => 'Temperature']" selected="lambda" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:T" hidden>
            <x-calc.field name="lambda" label="Peak wavelength" value="502.04" placeholder="Peak wavelength">
                <label for="calc-lambda-unit" class="sr-only">Peak wavelength unit</label>
                <select id="calc-lambda-unit" name="lambda-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'nm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:lambda">
            <x-calc.field name="T" label="Temperature" value="5772" placeholder="Temperature">
                <label for="calc-T-unit" class="sr-only">Temperature unit</label>
                <select id="calc-T-unit" name="T-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.temperature'))->only(['c', 'f', 'k', 'r']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'k')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:lambda">
            <x-calc.select name="out_lambda" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="nm" />
        </div>
        <div data-show-when="solve:T" hidden>
            <x-calc.select name="out_T" label="Show the result in" :options="['c' => '°C', 'f' => '°F', 'k' => 'K', 'r' => '°R']" selected="k" />
        </div>
    </div>

    <x-calc.result label="Peak wavelength" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'lambda', 'lambda' => 502.04, 'lambda-unit' => 'nm', 'out_lambda' => 'nm', 'T' => 5772, 'T-unit' => 'k', 'out_T' => 'k'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'band' => ['label' => 'Region'],
            'b' => ['label' => 'Wien constant'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>λ_max = b ÷ T</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
