<x-calc.page
    title="Babylonian Numbers Converter - SolveKit"
    description="Free Babylonian numbers converter: write numbers in base 60 with cuneiform wedges, and read sexagesimal values such as 1;24,51,10."
    lede="Convert to Babylonian numerals."
    about="The Babylonians counted in base 60 with two wedge signs: 𒁹 for one and 𒌋 for ten. 4,000 = 1 × 3,600 + 6 × 60 + 40, written 1,6,40. The tablet YBC 7289 gives √2 as 1;24,51,10 = 1.41421296, correct to six digits. We still use base 60 for minutes and degrees. Also known as sexagesimal converter."
    :calc="['engine' => 'mt-other', 'tool' => 'babylonian', 'fields' => ['dir', 'n', 'sexa']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'How is 4,000 written in Babylonian numerals?', 'answer' => '1,6,40 in base 60.'],
        ['question' => 'What is 1;24,51,10?', 'answer' => '1.41421296296296.'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Decimal → Babylonian', 'from' => 'Sexagesimal → decimal']" selected="to" />

    <div data-show-when="dir:to" hidden>
        <x-calc.field name="n" label="Whole number" value="4000" type="text" inputmode="numeric" />
    </div>

    <div data-show-when="dir:from" hidden>
        <x-calc.field name="sexa" label="Base-60 digits (; before the fraction)" value="1;24,51,10" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Babylonian numerals" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'n' => '4000', 'sexa' => '1;24,51,10'],
        'Root2' => ['dir' => 'from', 'n' => '4000', 'sexa' => '1;24,51,10'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'sexagesimal' => ['label' => 'Base 60'],
            'glyphs' => ['label' => 'Cuneiform'],
            'decimal' => ['label' => 'Decimal'],
            'places' => ['label' => 'Place values'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>base 60</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
