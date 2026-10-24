<x-calc.page
    title="Guitar String Tension Calculator - SolveKit"
    description="Free guitar string tension calculator: tension of any string for a scale length and tuning (D’Addario unit weights)."
    lede="Find string tension."
    about="Tension rises with the square of the pitch and the scale length, and with the string’s weight."
    :calc="['engine' => 'tc-music', 'tool' => 'string_tension', 'fields' => ['scale', 'string', 'uw', 'note', 'a4'], 'unitFields' => ['scale' => collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi'])->all()], 'data' => ['units' => collect(config('units'))->only(['length'])->all(), 'technology' => collect(config('technology_data'))->only(['strings'])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the tension of a .046 nickel string at E2 on 25.5″?', 'answer' => '17.47 lb.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="scale" label="Scale length" value="25.5" placeholder="Scale length">
            <label for="calc-scale-unit" class="sr-only">Scale length unit</label>
            <select id="calc-scale-unit" name="scale-unit" class="h-full border-0 border-l border-slate-200 bg-slate-50 px-2 text-sm font-medium text-slate-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500/40">
                @foreach(collect(config('units.length'))->only(['m', 'km', 'cm', 'mm', 'um', 'nm', 'mi', 'yd', 'ft', 'in', 'nmi']) as $key => $unit)
                    <option value="{{ $key }}" @selected($key === 'in')>{{ $unit['symbol'] }}</option>
                @endforeach
            </select>
        </x-calc.field>
        <x-calc.select name="string" label="String" :options="['pl0095' => 'Plain steel .0095', 'pl010' => 'Plain steel .010', 'pl0105' => 'Plain steel .0105', 'pl0115' => 'Plain steel .0115', 'pl013' => 'Plain steel .013', 'pl0135' => 'Plain steel .0135', 'pl015' => 'Plain steel .015', 'pl017' => 'Plain steel .017', 'pl019' => 'Plain steel .019', 'pl020' => 'Plain steel .020', 'nw018' => 'Nickel wound .018', 'nw026' => 'Nickel wound .026', 'nw028' => 'Nickel wound .028', 'nw032' => 'Nickel wound .032', 'nw036' => 'Nickel wound .036', 'nw038' => 'Nickel wound .038', 'nw042' => 'Nickel wound .042', 'nw046' => 'Nickel wound .046', 'nw048' => 'Nickel wound .048', 'nw052' => 'Nickel wound .052', 'nw054' => 'Nickel wound .054', 'pb022' => 'Phosphor bronze .022', 'pb025' => 'Phosphor bronze .025', 'pb026' => 'Phosphor bronze .026', 'pb032' => 'Phosphor bronze .032', 'pb035' => 'Phosphor bronze .035', 'pb036' => 'Phosphor bronze .036', 'pb042' => 'Phosphor bronze .042', 'pb045' => 'Phosphor bronze .045', 'pb047' => 'Phosphor bronze .047', 'pb049' => 'Phosphor bronze .049', 'pb053' => 'Phosphor bronze .053', 'pb056' => 'Phosphor bronze .056', 'pb064' => 'Phosphor bronze .064', 'bw025' => '80/20 bronze .025', 'bw026' => '80/20 bronze .026', 'bw032' => '80/20 bronze .032', 'bw036' => '80/20 bronze .036', 'bw042' => '80/20 bronze .042', 'bw045' => '80/20 bronze .045', 'bw047' => '80/20 bronze .047', 'bw053' => '80/20 bronze .053', 'bw056' => '80/20 bronze .056', 'custom' => 'Other (enter the value)']" selected="nw046" />
        <div data-show-when="string:custom">
            <x-calc.field name="uw" label="Unit weight (lb/in, for Other)" value="0.00038216" min="0" step="any" />
        </div>
        <x-calc.field name="note" label="Tuned to (note and octave)" value="E2" type="text" inputmode="text" />
        <x-calc.field name="a4" label="A4 tuning (Hz)" value="440" min="1" step="any" />
    </div>

    <x-calc.result label="Tension" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['scale' => 25.5, 'scale-unit' => 'in', 'string' => 'nw046', 'uw' => 0.00038216, 'note' => 'E2', 'a4' => 440],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'newtons' => ['label' => 'In newtons'],
            'kg' => ['label' => 'In kilograms-force'],
            'freq' => ['label' => 'Frequency'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
        <x-calc.grid heading="Standard 10–46 set (EXL110) at this scale length" name="set" :scroll="true" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
