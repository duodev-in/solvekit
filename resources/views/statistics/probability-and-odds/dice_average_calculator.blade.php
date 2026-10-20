<x-calc.page
    title="Dice Average Calculator - SolveKit"
    description="Free dice average calculator: the expected roll of any dice notation such as 3d6+2 or 4d6 keep highest 3, with the full distribution. Includes practice questions."
    lede="Find the average dice roll."
    about="One fair die with s sides averages (s + 1) ÷ 2, and averages add. Keep-highest rules are worked out exactly over every possible roll."
    :calc="['engine' => 'st-prob', 'tool' => 'dice_average', 'fields' => ['mode', 'dice', 'question', 'answer'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'practice' => 'diceAverage']"
    :how-to="[
        ['name' => 'Enter your numbers or data', 'text' => 'Type values or paste data separated by commas, spaces or new lines; use the menus to choose the method or test.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula with your numbers, and the charts and tables update as you type.'],
    ]"
    :faqs="[
        ['question' => 'What is the average of 3d6?', 'answer' => '10.5.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered dice-average problems with the working. This replaces the old dice average quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <x-calc.field name="dice" label="Dice (e.g. 3d6+2, 4d6kh3, 2d20kl1)" value="3d6" type="text" inputmode="text" />
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Average roll" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'dice' => '3d6'],
        'Practice' => ['dice' => '3d6', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <x-calc.plot heading="Distribution of the total" name="dist" />
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'range' => ['label' => 'Lowest and highest'],
                'sd' => ['label' => 'Standard deviation'],
                'common' => ['label' => 'Most likely total'],
            ]" />
        </div>
        <div data-show-when="mode:practice" hidden>
            <x-calc.rows heading="Details" :rows="[
                'question' => ['label' => 'Question'],
                'yours' => ['label' => 'Your answer'],
                'check' => ['label' => 'Check'],
                'answer' => ['label' => 'Answer'],
            ]" />
        </div>
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
