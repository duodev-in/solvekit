<x-calc.page
    title="Dice Roller Calculator - SolveKit"
    description="Free dice roller: roll d4, d6, d8, d10, d12, d20, d100 or custom dice with modifiers and keep-highest rules (DnD)."
    lede="Roll dice."
    about="Write dice in standard notation (2d6, 1d20+5, 4d6kh3) and roll them with fair cryptographic randomness. Change any value to roll again. Also known as 10 Sided Dice Roller Calculator, 2 Dice Roller Calculator, 4-Sided Dice Roller Calculator, 6 Sided Dice Roller Calculator, Custom Dice Roller Calculator, D100 Dice Roller Calculator, D20 Dice Roller Calculator, DnD Dice Roller Calculator and Random Dice Roller."
    :calc="['engine' => 'st-prob', 'tool' => 'dice_roller', 'fields' => ['dice'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'Can I roll for Dungeons & Dragons stats?', 'answer' => 'Yes: 4d6kh3 rolls four dice and keeps the highest three.'],
    ]"
>
    <x-calc.field name="dice" label="Dice (e.g. 2d6, 1d20+5, 4d6kh3, d%)" value="2d6" type="text" inputmode="text" />

    <x-calc.result label="Total" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['dice' => '2d6'],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rolls' => ['label' => 'Each die'],
            'range' => ['label' => 'Possible range'],
            'average' => ['label' => 'Average total'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
