<x-calc.page
    title="Mayan Numerals Converter - SolveKit"
    description="Free Mayan numerals converter: numbers in the Maya base-20 system of dots, bars and shells, with the calendar long count."
    lede="Convert to Mayan numerals."
    about="Maya numerals are base 20, written top to bottom: a dot is 1, a bar is 5 and a shell is 0. 2,024 = 5 × 400 + 1 × 20 + 4. The calendar long count used 18 × 20 = 360 in the third place instead of 400. Also known as Maya numbers converter."
    :calc="['engine' => 'mt-other', 'tool' => 'mayan', 'fields' => ['dir', 'n', 'digits']]"
    :how-to="[
        ['name' => 'Enter the values', 'text' => ''],
        ['name' => 'Read the result', 'text' => 'The working explains each step.'],
    ]"
    :faqs="[
        ['question' => 'How is 2,024 written in Maya numerals?', 'answer' => 'Digits 5, 1, 4: ▬ | • | ••••.'],
    ]"
>
    <x-calc.select name="dir" label="Convert" :options="['to' => 'Decimal → Mayan', 'from' => 'Mayan digits → decimal']" selected="to" />

    <div data-show-when="dir:to" hidden>
        <x-calc.field name="n" label="Whole number" value="2024" type="text" inputmode="numeric" />
    </div>

    <div data-show-when="dir:from" hidden>
        <x-calc.field name="digits" label="Digits from the top (0 to 19)" value="5, 1, 4" type="text" inputmode="text" />
    </div>

    <x-calc.result label="Mayan numerals" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dir' => 'to', 'n' => '2024', 'digits' => '5, 1, 4'],
        'Back' => ['dir' => 'from', 'n' => '2024', 'digits' => '1, 0, 0'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'digits' => ['label' => 'Base-20 digits'],
            'glyphs' => ['label' => 'Glyphs'],
            'bars' => ['label' => 'Bars and dots'],
            'longcount' => ['label' => 'Long count'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>base 20</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
