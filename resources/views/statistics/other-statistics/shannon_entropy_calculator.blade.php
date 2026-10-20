<x-calc.page
    title="Shannon Entropy Calculator - SolveKit"
    description="Free Shannon entropy calculator: information entropy in bits, nats or hartleys from probabilities, counts or text."
    lede="Find Shannon entropy."
    about="Shannon entropy measures the average information or uncertainty per symbol."
    :calc="['engine' => 'st-inf', 'tool' => 'shannon', 'fields' => ['mode', 'probs', 'counts', 'text', 'base'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the entropy of ½, ¼, ⅛, ⅛?', 'answer' => '1.75 bits.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.select name="mode" label="From" :options="['probs' => 'Probabilities', 'counts' => 'Counts', 'text' => 'A text (character frequencies)']" selected="probs" />
        <div data-show-when="mode:probs">
            <x-calc.textarea name="probs" label="Probabilities (adding up to 1)" value="0.5, 0.25, 0.125, 0.125" rows="3" />
        </div>
        <div data-show-when="mode:counts">
            <x-calc.textarea name="counts" label="Counts" value="40, 30, 20, 10" rows="3" />
        </div>
        <div data-show-when="mode:text">
            <x-calc.textarea name="text" label="Text" value="hello world" rows="3" />
        </div>
        <x-calc.select name="base" label="Units" :options="['2' => 'bits (log₂)', '10' => 'hartleys (log₁₀)', '2.718281828459045' => 'nats (ln)']" selected="2" />
    </div>

    <x-calc.result label="Shannon entropy" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'probs', 'probs' => '0.5, 0.25, 0.125, 0.125', 'counts' => '40, 30, 20, 10', 'text' => 'hello world', 'base' => '2'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'max' => ['label' => 'Maximum possible (all equal)'],
            'efficiency' => ['label' => 'Efficiency H ÷ Hmax'],
            'symbols' => ['label' => 'Symbols'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
