<x-calc.page
    title="Oligo Resuspension Calculator - SolveKit"
    description="Free oligo resuspension calculator: volume of water or TE to dissolve a primer to a target concentration."
    lede="Work out how much buffer dissolves an oligo to a target concentration."
    about="The tube label gives the yield in nmol. Dissolving n nmol in V µL gives n ÷ V × 1000 µM, so 100 µM needs 10 µL per nmol. Spin the tube before opening and use TE or nuclease-free water."
    :calc="['engine' => 'lab', 'tool' => 'resuspension', 'fields' => ['nmol', 'target']]"
    :how-to="[
        ['name' => 'Read the label', 'text' => 'The yield in nmol on the tube or spec sheet.'],
        ['name' => 'Choose a stock concentration', 'text' => '100 µM is common for primers.'],
    ]"
    :faqs="[
        ['question' => 'How much water for 100 µM?', 'answer' => '10 µL per nmol, e.g. 250 µL for 25 nmol.'],
        ['question' => 'Water or TE?', 'answer' => 'TE (pH 8) keeps oligos stable for longer; use water if EDTA would interfere.'],
        ['question' => 'How do I make 10 µM working stock?', 'answer' => 'Mix 1 part 100 µM stock with 9 parts buffer.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="nmol" label="Oligo amount" value="25" min="0" suffix="nmol" />
        <x-calc.field name="target" label="Target concentration" value="100" min="0" suffix="µM" />
    </div>

    <x-calc.result label="Buffer to add" />

    <x-calc.options :examples="[
        '25 nmol to 100 µM' => ['nmol' => 25, 'target' => 100],
        '41.3 nmol to 100 µM' => ['nmol' => 41.3, 'target' => 100],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'working' => ['label' => 'Working stock'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>V (µL) = nmol ÷ µM × 1000</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
