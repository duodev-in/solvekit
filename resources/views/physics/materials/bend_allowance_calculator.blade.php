<x-calc.page
    title="Bend Allowance Calculator - SolveKit"
    description="Free bend allowance calculator: sheet metal bend allowance, outside setback and bend deduction from angle, radius, thickness and K-factor. Includes practice questions."
    lede="Find the bend allowance for sheet metal."
    about="When sheet metal bends, the inside compresses and the outside stretches; a neutral line at K × thickness from the inside keeps its length. The bend allowance is the arc length of that line, θ(R + Kt); the bend deduction converts flange lengths to the flat blank."
    :calc="['engine' => 'ph-mat', 'tool' => 'bend_allowance', 'fields' => ['mode', 'angle', 'R', 't', 'k', 'out', 'question', 'answer'], 'unitFields' => ['angle' => collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn'])->all(), 'R' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 't' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['angle', 'energy', 'force', 'length', 'mass', 'speed'])->all()], 'practice' => 'bendAllowance']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the bend allowance for a 90° bend, R = 3 mm, t = 2 mm, K = 0.33?', 'answer' => '5.74911 mm.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered bend allowance problems, with answer checking and the working. This replaces the old bend allowance quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="angle" label="Bend angle" value="90" placeholder="Bend angle">
                <label for="calc-angle-unit" class="sr-only">Bend angle unit</label>
                <select id="calc-angle-unit" name="angle-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.angle'))->only(['deg', 'rad', 'arcmin', 'arcsec', 'mrad', 'turn']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'deg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="R" label="Inside bend radius" value="3" placeholder="Inside bend radius">
                <label for="calc-R-unit" class="sr-only">Inside bend radius unit</label>
                <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="t" label="Material thickness" value="2" placeholder="Material thickness">
                <label for="calc-t-unit" class="sr-only">Material thickness unit</label>
                <select id="calc-t-unit" name="t-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'mm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="k" label="K-factor" value="0.33" min="0" step="any" />
            <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="mm" />
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Bend allowance" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'out' => 'mm', 'angle' => 90, 'angle-unit' => 'deg', 'R' => 3, 'R-unit' => 'mm', 't' => 2, 't-unit' => 'mm', 'k' => 0.33],
        'Practice' => ['out' => 'mm', 'angle' => 90, 'angle-unit' => 'deg', 'R' => 3, 'R-unit' => 'mm', 't' => 2, 't-unit' => 'mm', 'k' => 0.33, 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'ossb' => ['label' => 'Outside setback'],
                'bd' => ['label' => 'Bend deduction'],
                'neutral' => ['label' => 'Neutral axis radius'],
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
