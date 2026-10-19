<x-calc.page
    title="Productivity Calculator - SolveKit"
    description="Free Productivity Calculator: productivity = output ÷ input. Labor productivity is output per hour worked; multifactor uses several inputs."
    lede="Work out the productivity from output (units or value) and input (hours or cost)."
    about="Labor productivity is output per hour worked; multifactor uses several inputs. Estimates for planning, not financial, tax or legal advice."
    :calc="['engine' => 'fin-simple', 'tool' => 'productivity', 'fields' => ['output', 'input']]"
    :how-to="[
        ['name' => 'Enter your figures', 'text' => 'Output (units or value), Input (hours or cost).'],
        ['name' => 'Read the result', 'text' => 'The productivity appears as you type.'],
    ]"
    :faqs="[
        ['question' => 'How do you calculate the productivity?', 'answer' => 'Productivity = output ÷ input.'],
        ['question' => 'What is the productivity for output 1,200, input 300?', 'answer' => '4.'],
        ['question' => 'And for output 950, input 160?', 'answer' => '5.938.'],
        ['question' => 'What does the result tell me?', 'answer' => 'Track it over time with the same units.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="output" label="Output (units or value)" value="1200" step="any" />
        <x-calc.field name="input" label="Input (hours or cost)" value="300" step="any" />
    </div>

    <x-calc.result label="Productivity" />

    <x-calc.options :decimals="false" :examples="[
        'Example A' => ['output' => 1200, 'input' => 300],
        'Example B' => ['output' => 950, 'input' => 160],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :grow="true" :rows="[
            'calc' => ['label' => 'With your numbers'],
        ]" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">
            <li>productivity = output ÷ input</li>
        </ul>
    </x-slot:formula>
</x-calc.page>
