<x-calc.page
    title="Potential Energy Calculator - SolveKit"
    description="Free potential energy calculator: gravitational PE = mgh for energy, mass, height or gravity. Includes practice questions."
    lede="Solve PE = mgh."
    about="Lifting a mass through height h stores mgh of gravitational potential energy, which turns back into kinetic energy when it falls."
    :calc="['engine' => 'ph-mech', 'tool' => 'potential_energy', 'fields' => ['mode', 'solve', 'E', 'm', 'h', 'g', 'out_E', 'out_m', 'out_h', 'out_g', 'question', 'answer'], 'unitFields' => ['E' => collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev'])->all(), 'm' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all(), 'h' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'g' => collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0'])->all()], 'data' => ['units' => collect(config('units'))->only(['E', 'acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all()], 'practice' => 'potentialEnergy']"
    :how-to="[
        ['name' => 'Choose what to solve for', 'text' => 'The other quantities stay as inputs, each with its own unit.'],
        ['name' => 'Enter the values', 'text' => 'The result is shown in the unit you pick, with the rearranged formula and your numbers in the working.'],
    ]"
    :faqs="[
        ['question' => 'What PE does 10 kg gain lifted 10 m?', 'answer' => '980.665 J.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered mgh problems with answer checking and the working. This replaces the old potential energy quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <x-calc.select name="solve" label="Solve for" :options="['E' => 'Potential energy', 'm' => 'Mass', 'h' => 'Height', 'g' => 'Gravity']" selected="E" />
    </div>

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <div data-show-when="solve:m,h,g" hidden>
                <x-calc.field name="E" label="Potential energy" value="981" placeholder="Potential energy">
                    <label for="calc-E-unit" class="sr-only">Potential energy unit</label>
                    <select id="calc-E-unit" name="E-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.energy'))->only(['j', 'kj', 'mj', 'gj', 'wh', 'kwh', 'cal', 'kcal', 'btu', 'ftlbf', 'ev']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'j')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="solve:E,h,g">
                <x-calc.field name="m" label="Mass" value="10" min="0" placeholder="Mass">
                    <label for="calc-m-unit" class="sr-only">Mass unit</label>
                    <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="solve:E,m,g">
                <x-calc.field name="h" label="Height" value="10" placeholder="Height">
                    <label for="calc-h-unit" class="sr-only">Height unit</label>
                    <select id="calc-h-unit" name="h-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'm')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="solve:E,m,h">
                <x-calc.field name="g" label="Gravity" value="9.80665" placeholder="Gravity">
                    <label for="calc-g-unit" class="sr-only">Gravity unit</label>
                    <select id="calc-g-unit" name="g-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.acceleration'))->only(['ms2', 'cms2', 'fts2', 'ins2', 'kmhs', 'mphs', 'g0']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ms2')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="solve:E">
                <x-calc.select name="out_E" label="Show the result in" :options="['j' => 'J', 'kj' => 'kJ', 'mj' => 'MJ', 'gj' => 'GJ', 'wh' => 'Wh', 'kwh' => 'kWh', 'cal' => 'cal', 'kcal' => 'kcal', 'btu' => 'BTU', 'ftlbf' => 'ft·lbf', 'ev' => 'eV']" selected="j" />
            </div>
            <div data-show-when="solve:m" hidden>
                <x-calc.select name="out_m" label="Show the result in" :options="['kg' => 'kg', 'g' => 'g', 'mg' => 'mg', 't' => 't', 'lb' => 'lb', 'oz' => 'oz', 'gr' => 'gr', 'ton_us' => 'US ton']" selected="kg" />
            </div>
            <div data-show-when="solve:h" hidden>
                <x-calc.select name="out_h" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="m" />
            </div>
            <div data-show-when="solve:g" hidden>
                <x-calc.select name="out_g" label="Show the result in" :options="['ms2' => 'm/s²', 'cms2' => 'cm/s²', 'fts2' => 'ft/s²', 'ins2' => 'in/s²', 'kmhs' => 'km/h/s', 'mphs' => 'mph/s', 'g0' => 'g']" selected="ms2" />
            </div>
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Potential energy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'solve' => 'E', 'E' => 981, 'E-unit' => 'j', 'out_E' => 'j', 'm' => 10, 'm-unit' => 'kg', 'out_m' => 'kg', 'h' => 10, 'h-unit' => 'm', 'out_h' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2', 'out_g' => 'ms2'],
        'Practice' => ['solve' => 'E', 'E' => 981, 'E-unit' => 'j', 'out_E' => 'j', 'm' => 10, 'm-unit' => 'kg', 'out_m' => 'kg', 'h' => 10, 'h-unit' => 'm', 'out_h' => 'm', 'g' => 9.80665, 'g-unit' => 'ms2', 'out_g' => 'ms2', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'formula' => ['label' => 'Rearranged formula'],
                'si' => ['label' => 'Result in common units'],
                'v' => ['label' => 'Speed if dropped from that height'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
        </div>
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>E = m g h</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
