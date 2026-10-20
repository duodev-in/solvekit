<x-calc.page
    title="Pythagorean Triples Calculator - SolveKit"
    description="Free Pythagorean triples calculator: list all triples up to a limit, generate one from Euclid's formula, or check three numbers."
    lede="Find Pythagorean triples."
    about="A Pythagorean triple is three whole numbers with a² + b² = c², such as (3, 4, 5) and (5, 12, 13). Euclid's formula a = m² − n², b = 2mn, c = m² + n² gives every primitive triple when m > n are coprime and of opposite parity; multiples give the rest."
    :calc="['engine' => 'mt-tri', 'tool' => 'pyth_triples', 'fields' => ['mode', 'limit', 'm', 'n', 'a', 'b', 'c']]"
    :how-to="[
        ['name' => 'Choose what you know', 'text' => 'Pick the combination of values you have, then the unit.'],
        ['name' => 'Enter the values', 'text' => 'Every other measure is solved and drawn to scale.'],
    ]"
    :faqs="[
        ['question' => 'How many Pythagorean triples have hypotenuse at most 50?', 'answer' => '20 triples, of which 7 are primitive.'],
        ['question' => 'Which triple do m = 5 and n = 2 give?', 'answer' => '(21, 20, 29).'],
    ]"
>
    <x-calc.select name="mode" label="I want to" :options="['list' => 'List all triples up to a hypotenuse', 'euclid' => 'Generate from m and n', 'check' => 'Check three numbers']" selected="list" />

    <div data-show-when="mode:list" hidden>
        <x-calc.field name="limit" label="Largest hypotenuse" value="50" min="5" max="2000" step="1" />
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="mode:euclid" hidden>
            <x-calc.field name="m" label="m" value="5" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="mode:euclid" hidden>
            <x-calc.field name="n" label="n" value="2" type="text" inputmode="decimal" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
        <div data-show-when="mode:check" hidden>
            <x-calc.field name="a" label="a" value="20" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="mode:check" hidden>
            <x-calc.field name="b" label="b" value="21" type="text" inputmode="decimal" />
        </div>
        <div data-show-when="mode:check" hidden>
            <x-calc.field name="c" label="c" value="29" type="text" inputmode="decimal" />
        </div>
    </div>

    <x-calc.result label="Pythagorean triples" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'list', 'limit' => 50, 'm' => '5', 'n' => '2', 'a' => '20', 'b' => '21', 'c' => '29'],
        'Euclid' => ['mode' => 'euclid', 'limit' => 50, 'm' => '5', 'n' => '2', 'a' => '20', 'b' => '21', 'c' => '29'],
        'Check' => ['mode' => 'check', 'limit' => 50, 'm' => '5', 'n' => '2', 'a' => '20', 'b' => '21', 'c' => '29'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'first' => ['label' => 'Triples'],
            'primitive' => ['label' => 'Primitive'],
            'check' => ['label' => 'Check'],
            'perimeter' => ['label' => 'Perimeter'],
            'area' => ['label' => 'Area'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>a = m² − n², b = 2mn, c = m² + n²</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
