<x-calc.page
    title="Dunk Calculator - SolveKit"
    description="Free dunk calculator: can you dunk? Your reach above the rim, the jump you need and your hang time. Includes practice questions."
    lede="Check whether you can dunk."
    about="To dunk you need your hand clearly above the rim, about 15–25 cm depending on your hands. Your standing reach plus your vertical jump has to get there."
    :calc="['engine' => 'sp-ball', 'tool' => 'dunk', 'fields' => ['mode', 'reach', 'jump', 'rim', 'hand', 'out', 'question', 'answer'], 'unitFields' => ['reach' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'jump' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all(), 'rim' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length', 'mass', 'speed', 'time'])->all()], 'practice' => 'dunk']"
    :how-to="[
        ['name' => 'Enter the values', 'text' => 'Each value has its own unit menu; mix units freely.'],
        ['name' => 'Read the result', 'text' => 'Pick the unit for the result; the working shows the formula with your numbers.'],
    ]"
    :faqs="[
        ['question' => 'Can someone with a 230 cm reach and a 70 cm jump dunk?', 'answer' => 'Not yet: they reach −4.8 cm above the rim.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered reach-and-jump problems with the working. This replaces the old dunk quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="reach" label="Standing reach" value="230" placeholder="Standing reach">
                <label for="calc-reach-unit" class="sr-only">Standing reach unit</label>
                <select id="calc-reach-unit" name="reach-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="jump" label="Vertical jump" value="70" placeholder="Vertical jump">
                <label for="calc-jump-unit" class="sr-only">Vertical jump unit</label>
                <select id="calc-jump-unit" name="jump-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.field name="rim" label="Rim height" value="304.8" placeholder="Rim height">
                <label for="calc-rim-unit" class="sr-only">Rim height unit</label>
                <select id="calc-rim-unit" name="rim-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                    @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                        <option value="{{ $key }}" @selected($key === 'cm')>{{ $unit['symbol'] }}</option>
                    @endforeach
                </select>
            </x-calc.field>
            <x-calc.select name="hand" label="Reach needed above the rim" :options="['15' => 'About 15 cm (large hands, palming the ball)', '25' => 'About 25 cm (two hands or small hands)']" selected="15" />
            <x-calc.select name="out" label="Show the result in" :options="['m' => 'm', 'km' => 'km', 'cm' => 'cm', 'mm' => 'mm', 'um' => 'µm', 'nm' => 'nm', 'mi' => 'mi', 'yd' => 'yd', 'ft' => 'ft', 'in' => 'in', 'nmi' => 'nmi']" selected="cm" />
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Your reach above the rim" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'out' => 'cm', 'reach' => 230, 'reach-unit' => 'cm', 'jump' => 70, 'jump-unit' => 'cm', 'rim' => 304.8, 'rim-unit' => 'cm', 'hand' => '15'],
        'Practice' => ['out' => 'cm', 'reach' => 230, 'reach-unit' => 'cm', 'jump' => 70, 'jump-unit' => 'cm', 'rim' => 304.8, 'rim-unit' => 'cm', 'hand' => '15', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'can' => ['label' => 'Can you dunk?'],
                'need' => ['label' => 'Vertical jump needed'],
                'hang' => ['label' => 'Hang time at that jump'],
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
