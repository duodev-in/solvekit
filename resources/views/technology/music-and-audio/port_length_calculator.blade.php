<x-calc.page
    title="Port Length Calculator - SolveKit"
    description="Free port length calculator: loudspeaker port length for a box volume and tuning frequency, round or slot ports. Includes practice questions."
    lede="Find a speaker port length."
    about="A bass-reflex port and the air in the box form a Helmholtz resonator tuned to a set frequency."
    :calc="['engine' => 'tc-music', 'tool' => 'port_length', 'fields' => ['mode', 'vb', 'fb', 'shape', 'd', 'sw', 'sh', 'np', 'k', 'question', 'answer'], 'data' => ['units' => collect(config('units'))->only([])->all()], 'practice' => 'portLength']"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How long a 7.5 cm port tunes a 50 L box to 35 Hz?', 'answer' => '16.15 cm.'],
        ['question' => 'Can I practise with this calculator?', 'answer' => 'Yes. Switch the mode to practice questions for numbered port-length problems with the working. This replaces the old port length quiz.'],
    ]"
>
    <x-calc.select name="mode" label="Mode" :options="['calculate' => 'Calculate', 'practice' => 'Practice questions']" selected="calculate" />

    <div data-show-when="mode:calculate">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="vb" label="Box volume (litres, net)" value="50" min="0" step="any" />
            <x-calc.field name="fb" label="Tuning frequency Fb (Hz)" value="35" min="0" step="any" />
            <x-calc.select name="shape" label="Port" :options="['round' => 'Round', 'slot' => 'Slot (rectangular)']" selected="round" />
            <div data-show-when="shape:round">
                <x-calc.field name="d" label="Port inner diameter (cm)" value="7.5" min="0" step="any" />
            </div>
            <div data-show-when="shape:slot">
                <x-calc.field name="sw" label="Slot width (cm)" value="15" min="0" step="any" />
            </div>
            <div data-show-when="shape:slot">
                <x-calc.field name="sh" label="Slot height (cm)" value="4" min="0" step="any" />
            </div>
            <x-calc.field name="np" label="Number of ports" value="1" min="1" step="any" />
            <x-calc.select name="k" label="Port ends" :options="['0.732' => 'One end flanged (on the baffle)', '0.85' => 'Both ends flanged', '0.614' => 'Both ends free']" selected="0.732" />
        </div>
    </div>

    <div data-show-when="mode:practice" hidden>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            <x-calc.field name="question" label="Question number (change it for a new question)" value="1" min="1" step="1" />
            <x-calc.field name="answer" label="Your answer" value="" type="text" inputmode="text" />
        </div>
    </div>

    <x-calc.result label="Port length" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['mode' => 'calculate', 'vb' => 50, 'fb' => 35, 'shape' => 'round', 'd' => 7.5, 'sw' => 15, 'sh' => 4, 'np' => 1, 'k' => '0.732'],
        'Practice' => ['vb' => 50, 'fb' => 35, 'shape' => 'round', 'd' => 7.5, 'sw' => 15, 'sh' => 4, 'np' => 1, 'k' => '0.732', 'mode' => 'practice', 'question' => 1, 'answer' => ''],
    ]" />

    <x-slot:panel>
        <div data-show-when="mode:calculate">
            <x-calc.rows heading="Details" :rows="[
                'area' => ['label' => 'Port area (total)'],
                'volume' => ['label' => 'Volume taken by the port(s)'],
                'equiv' => ['label' => 'Equivalent round diameter'],
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
