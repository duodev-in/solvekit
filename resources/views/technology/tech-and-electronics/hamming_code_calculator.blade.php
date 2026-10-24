<x-calc.page
    title="Hamming Code Calculator - SolveKit"
    description="Free Hamming code calculator: encode data bits, or find and correct a single-bit error in a received code word."
    lede="Encode and check Hamming codes."
    about="A Hamming code adds parity bits at positions 1, 2, 4, 8 … so that any single flipped bit can be found and corrected."
    :calc="['engine' => 'tc-text', 'tool' => 'hamming_code', 'fields' => ['mode', 'data', 'word', 'parity', 'secded'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the Hamming (7,4) code for 1011?', 'answer' => '0110011.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="Mode" :options="['encode' => 'Encode data bits', 'decode' => 'Check a received code word']" selected="encode" />
        <x-calc.field name="data" label="Data bits" value="1011" type="text" inputmode="text" />
        <x-calc.field name="word" label="Received code word" value="0110111" type="text" inputmode="text" />
        <x-calc.select name="parity" label="Parity" :options="['even' => 'Even', 'odd' => 'Odd']" selected="even" />
        <x-calc.select name="secded" label="Extra overall parity bit (SECDED)" :options="['no' => 'No', 'yes' => 'Yes']" selected="no" />
    </div>

    <x-calc.result label="Result" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'encode', 'data' => '1011', 'word' => '0110111', 'parity' => 'even', 'secded' => 'no'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'info' => ['label' => 'Detail'],
            'parityBits' => ['label' => 'Parity bits'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
