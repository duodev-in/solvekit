<x-calc.page
    title="Power Factor Calculator - SolveKit"
    description="Free power factor calculator: PF from real and apparent power, kW and kVAR, or phase angle, with correction. Includes practice questions."
    lede="Find the power factor."
    about="Power factor is real power over apparent power, cos φ. Low power factor means more current for the same useful work; capacitors correct it."
    :calc="['engine' => 'ph-em', 'tool' => 'power_factor', 'fields' => ['mode', 'mode', 'P', 'S', 'Q', 'phi', 'question', 'answer'], 'unitFields' => ['phi' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()], 'practice' => 'powerFactor']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is PF for 8 kW and 10 kVA?', 'answer' => '0.8.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered power factor problems with answer checking and the working. This replaces the old power factor quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="mode" label="I know" :options="['PS' => 'Real and apparent power', 'PQ' => 'Real and reactive power', 'angle' => 'Phase angle']" selected="PS" />
            <div data-show-when="mode:PS,PQ">
                <x-calc.field name="P" label="Real power (kW)" value="8" min="0" step="any" />
            </div>
            <div data-show-when="mode:PS">
                <x-calc.field name="S" label="Apparent power (kVA)" value="10" min="0" step="any" />
            </div>
            <div data-show-when="mode:PQ">
                <x-calc.field name="Q" label="Reactive power (kVAR)" value="6" step="any" />
            </div>
            <div data-show-when="mode:angle">
                <x-calc.field name="phi" label="Phase angle" value="36.87" placeholder="Phase angle">
                    <label for="calc-phi-unit" class="sr-only">Phase angle unit</label>
                    <select id="calc-phi-unit" name="phi-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Power factor" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'PS', 'P' => 8, 'S' => 10, 'Q' => 6, 'phi' => 36.87, 'phi-unit' => 'deg'],
        'Practice' => ['mode' => 'practice', 'P' => 8, 'S' => 10, 'Q' => 6, 'phi' => 36.87, 'phi-unit' => 'deg', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'angle' => ['label' => 'Phase angle'],
                'Q' => ['label' => 'Reactive power per kW'],
                'kvar' => ['label' => 'Capacitor kVAR to reach PF 0.95 (per kW)'],
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

        </ul>
    </x-slot:formula>
</x-calc.page>
