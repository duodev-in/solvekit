<x-calc.page
    title="Electrical Power Calculator - SolveKit"
    description="Free electrical power calculator: power, voltage, current and resistance from any two values. Includes practice questions."
    lede="Find electrical power from any two values."
    about="Ohm’s law V = IR and P = VI tie voltage, current, resistance and power together. Know any two and the rest follow."
    :calc="['engine' => 'ph-em', 'tool' => 'electrical_power', 'fields' => ['mode', 'pair', 'V', 'I', 'R', 'P', 'out', 'question', 'answer'], 'unitFields' => ['V' => collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav'])->all(), 'I' => collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka'])->all(), 'R' => collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm'])->all(), 'P' => collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs'])->all()], 'data' => ['units' => collect(config('units'))->only(['current', 'energy', 'force', 'length', 'mass', 'power', 'resistance', 'speed', 'voltage'])->all()], 'practice' => 'electricalPower']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'What power does 12 V at 2 A deliver?', 'answer' => '24 W.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered power problems with answer checking and the working. This replaces the old electrical power quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.select name="pair" label="I know" :options="['VI' => 'Voltage and current', 'VR' => 'Voltage and resistance', 'IR' => 'Current and resistance', 'PV' => 'Power and voltage', 'PI' => 'Power and current', 'PR' => 'Power and resistance']" selected="VI" />
            <div data-show-when="pair:VI,VR,PV">
                <x-calc.field name="V" label="Voltage" value="12" placeholder="Voltage">
                    <label for="calc-V-unit" class="sr-only">Voltage unit</label>
                    <select id="calc-V-unit" name="V-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.voltage'))->only(['v', 'mv', 'uv', 'kv', 'megav']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'v')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="pair:VI,IR,PI">
                <x-calc.field name="I" label="Current" value="2" placeholder="Current">
                    <label for="calc-I-unit" class="sr-only">Current unit</label>
                    <select id="calc-I-unit" name="I-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.current'))->only(['a', 'ma', 'ua', 'na', 'ka']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'a')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="pair:VR,IR,PR">
                <x-calc.field name="R" label="Resistance" value="6" min="0" placeholder="Resistance">
                    <label for="calc-R-unit" class="sr-only">Resistance unit</label>
                    <select id="calc-R-unit" name="R-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.resistance'))->only(['ohm', 'mohm', 'kohm', 'megohm', 'gohm']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'ohm')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <div data-show-when="pair:PV,PI,PR">
                <x-calc.field name="P" label="Power" value="24" min="0" placeholder="Power">
                    <label for="calc-P-unit" class="sr-only">Power unit</label>
                    <select id="calc-P-unit" name="P-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                        @foreach(collect(config('units.power'))->only(['w', 'kw', 'mw', 'gw', 'milliwatt', 'hp', 'ps', 'btuh', 'tr', 'ftlbfs']) as $key => $unit)
                            <option value="{{ $key }}" @selected($key === 'w')>{{ $unit['symbol'] }}</option>
                        @endforeach
                    </select>
                </x-calc.field>
            </div>
            <x-calc.select name="out" label="Show the result in" :options="['w' => 'W', 'kw' => 'kW', 'mw' => 'MW', 'gw' => 'GW', 'milliwatt' => 'mW', 'hp' => 'hp', 'ps' => 'PS', 'btuh' => 'BTU/h', 'tr' => 'TR', 'ftlbfs' => 'ft·lbf/s']" selected="w" />
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Power" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'out' => 'w', 'pair' => 'VI', 'V' => 12, 'V-unit' => 'v', 'I' => 2, 'I-unit' => 'a', 'R' => 6, 'R-unit' => 'ohm', 'P' => 24, 'P-unit' => 'w'],
        'Practice' => ['out' => 'w', 'pair' => 'VI', 'V' => 12, 'V-unit' => 'v', 'I' => 2, 'I-unit' => 'a', 'R' => 6, 'R-unit' => 'ohm', 'P' => 24, 'P-unit' => 'w', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'V' => ['label' => 'Voltage V'],
                'I' => ['label' => 'Current I'],
                'R' => ['label' => 'Resistance R'],
                'P' => ['label' => 'Power P'],
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
