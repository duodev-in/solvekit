<x-calc.page
    title="Net Force Calculator - SolveKit"
    description="Free net force calculator: add any number of forces with directions to get the net force, its direction and the acceleration. Includes practice questions."
    lede="Add forces as vectors."
    about="The net force is the vector sum of all forces. Resolve each force into x and y components, add them and recombine. If the net force is zero the object keeps its velocity."
    :calc="['engine' => 'ph-mech', 'tool' => 'net_force', 'fields' => ['mode', 'forces', 'm', 'out', 'question', 'answer'], 'unitFields' => ['m' => collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us'])->all()], 'data' => ['units' => collect(config('units'))->only(['acceleration', 'energy', 'force', 'length', 'mass', 'speed'])->all()], 'practice' => 'netForce']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What is the net force of 50 N at 0°, 30 N at 90° and 20 N at 210°?', 'answer' => '38.3138 N.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions; each question number gives a different net-force problem, checks your answer and shows the working. This replaces the old net force quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.textarea name="forces" label="Forces: magnitude in newtons, direction in degrees (one per line)" value="50, 0
30, 90
20, 210" rows="3" />
            <x-calc.field name="m" label="Mass (optional, for acceleration)" value="10" min="0" placeholder="Mass (optional, for acceleration)">
                <label for="calc-m-unit" class="sr-only">Mass (optional, for acceleration) unit</label>
                <select id="calc-m-unit" name="m-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.mass'))->only(['kg', 'g', 'mg', 't', 'lb', 'oz', 'gr', 'ton_us']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'kg')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.select name="out" label="Show the result in" :options="['n' => 'N', 'kn' => 'kN', 'millinewton' => 'mN', 'meganewton' => 'MN', 'lbf' => 'lbf', 'kgf' => 'kgf', 'dyn' => 'dyn', 'kip' => 'kip']" selected="n" />
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Net force" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'out' => 'n', 'forces' => '50, 0
30, 90
20, 210', 'm' => 10, 'm-unit' => 'kg'],
        'Practice' => ['out' => 'n', 'forces' => '50, 0
30, 90
20, 210', 'm' => 10, 'm-unit' => 'kg', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Force diagram" name="vectors" />
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'dir' => ['label' => 'Direction'],
                'comps' => ['label' => 'Components (x, y)'],
                'a' => ['label' => 'Acceleration'],
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
