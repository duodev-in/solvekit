<x-calc.page
    title="Catenary Curve Calculator - SolveKit"
    description="Free catenary calculator: the sag, cable length and shape y = a cosh(x/a) of a hanging chain or cable between two supports at the same height."
    lede="Model a hanging cable."
    about="A uniform chain hanging under its own weight forms a catenary, y = a cosh(x/a), not a parabola. From the span and the sag (or the cable length) the parameter a is found numerically; a equals the horizontal tension divided by the weight per unit length. Also known as hanging cable calculator."
    :calc="['engine' => 'mt-coord', 'tool' => 'catenary', 'fields' => ['given', 'span', 'sag', 'length', 'a']]"
    :how-to="[
        ['name' => 'Enter the coordinates', 'text' => 'Fractions such as 3/4 stay exact; decimals work too.'],
        ['name' => 'Read the result', 'text' => 'The working is shown step by step, with a graph where it helps.'],
    ]"
    :faqs="[
        ['question' => 'A cable spans 100 m and sags 10 m. How long is it?', 'answer' => '102.618686813.'],
    ]"
>
    <x-calc.select name="given" label="I know" :options="['sag' => 'The span and the sag', 'length' => 'The span and the cable length', 'a' => 'The span and the parameter a']" selected="sag" />

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="span" label="Span between supports" value="100" min="0" step="any" />
        <div data-show-when="given:sag" hidden>
            <x-calc.field name="sag" label="Sag" value="10" min="0" step="any" />
        </div>
    </div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div data-show-when="given:length" hidden>
            <x-calc.field name="length" label="Cable length" value="103" min="0" step="any" />
        </div>
        <div data-show-when="given:a" hidden>
            <x-calc.field name="a" label="Parameter a" value="120" min="0" step="any" />
        </div>
    </div>

    <x-calc.result label="Sag" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['given' => 'sag', 'span' => 100, 'sag' => 10, 'length' => 103, 'a' => 120],
        'Length' => ['given' => 'length', 'span' => 100, 'sag' => 10, 'length' => 103, 'a' => 120],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Shape" name="graph" />
        <x-calc.rows heading="Details" :rows="[
            'a' => ['label' => 'Parameter a'],
            'length' => ['label' => 'Cable length'],
            'sag' => ['label' => 'Sag'],
            'angle' => ['label' => 'Angle at the supports'],
            'tension' => ['label' => 'Tension'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>y = a cosh(x/a)</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
