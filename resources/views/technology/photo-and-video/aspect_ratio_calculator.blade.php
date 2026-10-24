<x-calc.page
    title="Aspect Ratio Calculator - SolveKit"
    description="Free aspect ratio calculator: simplify width × height to a ratio and resize while keeping it, with CSS."
    lede="Find an aspect ratio."
    about="The aspect ratio is the shape of an image or screen: width compared with height. Also known as 16:10 Aspect Ratio Calculator, 16:9 Aspect Ratio Calculator, 4:3 Aspect Ratio Calculator, CSS Aspect Ratio Calculator, Pixel Aspect Ratio Calculator, Portrait Aspect Ratio Calculator and Screen Ratio Calculator."
    :calc="['engine' => 'tc-photo', 'tool' => 'aspect', 'fields' => ['w', 'h', 'newW'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'What is the ratio of 1920 × 1080?', 'answer' => '16:9.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Width" value="1920" min="0" step="any" />
        <x-calc.field name="h" label="Height" value="1080" min="0" step="any" />
        <x-calc.field name="newW" label="New width (optional)" value="1280" min="0" step="any" />
    </div>

    <x-calc.result label="Aspect ratio" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 1920, 'h' => 1080, 'newW' => 1280],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'decimal' => ['label' => 'As a decimal'],
            'newH' => ['label' => 'Height for the new width'],
            'css' => ['label' => 'CSS'],
            'name' => ['label' => 'Common name'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
