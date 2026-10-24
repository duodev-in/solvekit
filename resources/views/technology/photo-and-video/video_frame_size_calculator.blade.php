<x-calc.page
    title="Video Frame Size Calculator - SolveKit"
    description="Free video frame size calculator: uncompressed frame size and data rate from resolution, bit depth and chroma subsampling."
    lede="Find an uncompressed frame size."
    about="Uncompressed video stores every pixel; chroma subsampling halves or quarters the colour data."
    :calc="['engine' => 'tc-photo', 'tool' => 'frame_size', 'fields' => ['w', 'h', 'depth', 'chroma', 'fps'], 'data' => ['units' => collect(config('units'))->only([])->all()]]"
    :how-to="[
        ['name' => 'Enter your values', 'text' => 'Each measured value has its own unit menu; text tools convert as you type.'],
        ['name' => 'Read the result', 'text' => 'The working shows the formula or rule with your numbers; copy any result with one click.'],
    ]"
    :faqs="[
        ['question' => 'How big is a 1080p 10-bit 4:2:2 frame?', 'answer' => '5.184 MB.'],
    ]"
>
    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-calc.field name="w" label="Width (px)" value="1920" min="1" step="any" />
        <x-calc.field name="h" label="Height (px)" value="1080" min="1" step="any" />
        <x-calc.select name="depth" label="Bit depth" :options="['8' => '8-bit', '10' => '10-bit', '12' => '12-bit', '16' => '16-bit']" selected="10" />
        <x-calc.select name="chroma" label="Chroma subsampling" :options="['2' => '4:2:2', '3' => '4:4:4 (RGB)', '1.5' => '4:2:0']" selected="2" />
        <x-calc.field name="fps" label="Frame rate (fps)" value="25" min="1" step="any" />
    </div>

    <x-calc.result label="Uncompressed frame" />

    <x-calc.options :decimals="false" :examples="[
        'Example' => ['w' => 1920, 'h' => 1080, 'depth' => '10', 'chroma' => '2', 'fps' => 25],
    ]" />

    <x-slot:panel>
        <x-calc.rows heading="Details" :rows="[
            'rate' => ['label' => 'Data rate'],
            'perHour' => ['label' => 'Per hour'],
            'perMin' => ['label' => 'Per minute'],
        ]" />
        <x-calc.steps heading="Working" name="steps" />
    </x-slot:panel>

    <x-slot:formula>
        <ul class="space-y-1 font-mono text-[13px]">

        </ul>
    </x-slot:formula>
</x-calc.page>
