<x-calc.page
    title="Natural Frequency Calculator - SolveKit"
    description="Free natural frequency calculator: f = (1/2π)√(k/m) for a mass on a spring, solved for any value."
    lede="Solve f = √(k/m) ÷ 2π."
    about="A mass on a spring vibrates at its natural frequency. Stiffer springs and lighter masses vibrate faster. Keeping forcing frequencies away from it avoids resonance."
    :calc="['engine' => 'ph-mat', 'tool' => 'natural_frequency', 'fields' => ['solve', 'f', 'k', 'm', 'out_f', 'out_k', 'out_m'], 'unitFields' => ['f' => collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm'])->all(), 'k' => collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['energy', 'f', 'force', 'frequency_hz', 'length', 'mass', 'short_time', 'speed', 'stiffness'])->all()]]"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What is f for 1 kg on 1,000 N/m?', 'answer' => '5.03292 Hz.'],
    ]"
>
    <x-calc.select name="solve" label="Solve for" :options="['f' => 'Natural frequency', 'k' => 'Stiffness', 'm' => 'Mass']" selected="f" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="solve:k,m" hidden>
            <x-calc.field name="f" label="Natural frequency" value="5.03292" min="0" placeholder="Natural frequency">
                <label for="calc-f-unit" class="sr-only">Natural frequency unit</label>
                <select id="calc-f-unit" name="f-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.frequency_hz'))->only(['hz', 'khz', 'mhz', 'ghz', 'thz', 'mhz_milli', 'rpm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'hz')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f,m">
            <x-calc.field name="k" label="Stiffness" value="1000" min="0" placeholder="Stiffness">
                <label for="calc-k-unit" class="sr-only">Stiffness unit</label>
                <select id="calc-k-unit" name="k-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.stiffness'))->only(['npm', 'npmm', 'knpm', 'npcm', 'lbfpin', 'lbfpft', 'kgfpmm']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'npm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f,k">
            <x-calc.field name="m" label="Mass" value="1" min="0" placeholder="Mass">
                <label for="calc-m-unit" class="sr-only">Mass unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
        </div>
        <div data-show-when="solve:f">
            <x-calc.select name="out_f" label="Show the result in" :options="['hz' => 'Hz', 'khz' => 'kHz', 'mhz' => 'MHz', 'ghz' => 'GHz', 'thz' => 'THz', 'mhz_milli' => 'mHz', 'rpm' => 'rpm']" selected="hz" />
        </div>
        <div data-show-when="solve:k" hidden>
            <x-calc.select name="out_k" label="Show the result in" :options="['npm' => 'N/m', 'npmm' => 'N/mm', 'knpm' => 'kN/m', 'npcm' => 'N/cm', 'lbfpin' => 'lbf/in', 'lbfpft' => 'lbf/ft', 'kgfpmm' => 'kgf/mm']" selected="npm" />
        </div>
        <div data-show-when="solve:m" hidden>
            <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
        </div>
    </div>

    <x-calc.result label="Natural frequency" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['solve' => 'f', 'f' => 5.03292, 'f-unit' => 'hz', 'out_f' => 'hz', 'k' => 1000, 'k-unit' => 'npm', 'out_k' => 'npm', 'm' => 1, 'm-unit' => 'kg', 'out_m' => 'kg'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'formula' => ['label' => 'Rearranged formula'],
            'si' => ['label' => 'Result in common units'],
            'T' => ['label' => 'Period'],
            'defl' => ['label' => 'Static deflection under gravity'],
            'w' => ['label' => 'Angular frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>f = (1 ÷ 2π) √(k ÷ m)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
