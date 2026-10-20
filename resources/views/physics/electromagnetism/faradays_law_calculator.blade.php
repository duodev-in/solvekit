<x-calc.page
    title="Faraday's Law Calculator - SolveKit"
    description="Free Faraday's law calculator: induced EMF from turns, flux change and time, solved for any value."
    lede="Solve ε = NΔΦ ÷ Δt."
    about="A changing magnetic flux through a coil induces an EMF proportional to the number of turns and the rate of change. Lenz’s law gives its direction."
    :calc="['engine' => 'ph-em', 'tool' => 'faraday', 'fields' => ['solve', 'emf', 'N', 'dphi', 't', 'out_emf', 'out_t'], 'unitFields' => ['emf' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 't' => collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'force', 'length', 'mass', 'speed', 'time', 'voltage'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What EMF does 100 turns with ΔΦ = 0.01 Wb in 0.2 s give?', 'answer' => '5 V.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['emf' => 'Induced EMF (magnitude)', 'N' => 'Turns', 'dphi' => 'Change in flux per turn (Wb)', 't' => 'Time']" selected="emf" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:N,dphi,t" hidden>
            <x-calc.field name="emf" label="Induced EMF (magnitude)" value="5" placeholder="Induced EMF (magnitude)">
                <label for="calc-emf-unit" class="sr-only">Induced EMF (magnitude) unit</label>
                <select id="calc-emf-unit" name="emf-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:emf,dphi,t">
            <x-calc.field name="N" label="Turns" value="100" step="any" />
        </div>
        <div data-show-when="solve:emf,N,t">
            <x-calc.field name="dphi" label="Change in flux per turn (Wb)" value="0.01" step="any" />
        </div>
        <div data-show-when="solve:emf,N,dphi">
            <x-calc.field name="t" label="Time" value="0.2" placeholder="Time">
                <label for="calc-t-unit" class="sr-only">Time unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.time'))->only(['s', 'ms', 'us', 'min', 'h', 'day', 'year']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 's')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:emf">
            <x-calc.select name="out_emf" label="Show the result in" :options="['v' => 'V', 'mv' => 'mV', 'uv' => 'µV', 'kv' => 'kV', 'megav' => 'MV']" selected="v" />
        </div>
        <div data-show-when="solve:t" hidden>
            <x-calc.select name="out_t" label="Show the result in" :options="['s' => 's', 'ms' => 'ms', 'us' => 'µs', 'min' => 'min', 'h' => 'h', 'day' => 'd', 'year' => 'yr']" selected="s" />
        </div>
    </div>

    <x-calc.result label="Induced EMF (magnitude)" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'emf', 'emf' => 5, 'emf-unit' => 'v', 'out_emf' => 'v', 'N' => 100, 'dphi' => 0.01, 't' => 0.2, 't-unit' => 's', 'out_t' => 's'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'lenz' => ['label' => 'Direction (Lenz’s law)'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>|ε| = N ΔΦ ÷ Δt</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
