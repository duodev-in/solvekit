<x-tool-page-layout
    title="Mesh to Micron Converter - ConvertPro"
    description="Professional mesh to micron converter for particle size analysis. Convert US standard mesh sizes to microns for industrial screening and filtration applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Mesh to Micron</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="mesh" class="block text-xs font-semibold text-slate-700">
                                                                                    Enter US Standard Mesh Size
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="mesh" 
                                                                                        class="w-full rounded-md border border-slate-300 bg-white" 
                                                                                        placeholder="Enter mesh size (e.g., 20)"
                                                                                        step="1"
                                                                                        min="1"
                                                                                        max="500"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-slate-500 text-sm font-medium">mesh</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Common range: 3 to 400 mesh</p>
                                                                            </div>

                                                                            <div class="space-y-1">
                                                                                <span class="block text-xs font-semibold text-slate-700">Conversion Mode</span>
                                                                                <div class="grid grid-cols-1 gap-2 sm:grid-cols-3">
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="mode" value="standard" class="text-indigo-600" checked>
                                                                                        <span class="text-xs font-medium">Standard</span>
                                                                                    </label>
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="mode" value="formula" class="text-indigo-600">
                                                                                        <span class="text-xs font-medium">Formula</span>
                                                                                    </label>
                                                                                    <label class="flex items-center gap-2 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                        <input type="radio" name="mode" value="both" class="text-indigo-600">
                                                                                        <span class="text-xs font-medium">Both</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <div class="flex items-center justify-between gap-3 rounded-md border border-slate-200 bg-slate-50 px-2 py-1.5">
                                                                                <p class="text-[11px] text-slate-500">Shortcut: Ctrl + M to switch mode</p>
                                                                                <button
                                                                                    type="button"
                                                                                    id="clearButton"
                                                                                    class="rounded-md bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-700"
                                                                                >
                                                                                    Clear
                                                                                </button>
                                                                            </div>

                                                                        </form>
                                    </div>
                                    <div class="space-y-4 lg:col-span-4">
                                        <!-- Result Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                            <div class="flex items-center justify-between">
                                                                                <div>
                                                                                    <h3 class="text-xs font-semibold text-slate-900">Micron Size</h3>
                                                                                    <p class="text-[11px] text-slate-500" id="result-description">Particle size conversion</p>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                    <div class="text-xs text-slate-500 font-medium">μm</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Secondary Result (when showing both) -->
                                                                        <div class="mt-4 rounded-md border border-slate-200 bg-slate-50 p-2.5" id="secondaryResult" style="display: none;">
                                                                            <div class="flex items-center justify-between">
                                                                                <div>
                                                                                    <h3 class="text-xs font-semibold text-slate-900">Formula Result</h3>
                                                                                    <p class="text-[11px] text-slate-500">Approximate calculation</p>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="formulaOutput">--</div>
                                                                                    <div class="text-xs text-slate-500 font-medium">μm</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Mesh to Micron Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">What is Mesh Size?</h4>
                                    <p>Mesh size refers to the number of openings per linear inch in a sieve or screen. Higher mesh numbers indicate smaller openings and finer particle sizes. It's widely used in industrial applications for particle classification.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Industrial Applications</h4>
                                    <p>Essential for powder processing, pharmaceutical manufacturing, mining operations, food processing, paint production, and quality control in industries requiring precise particle size specifications.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Technical Note:</strong> US Standard mesh sizes follow ASTM E11 specifications for accurate particle size determination!
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl border border-slate-200 bg-white p-3 shadow-sm">
                            <h3 class="text-base font-semibold text-slate-900 mb-3">Common Mesh Sizes</h3>
                            <div class="grid grid-cols-1 gap-2 text-xs text-slate-600 sm:grid-cols-2">
                                <div>• 20 mesh = 841 μm</div>
                                <div>• 50 mesh = 297 μm</div>
                                <div>• 100 mesh = 149 μm</div>
                                <div>• 200 mesh = 74 μm</div>
                            </div>
                        </div>

                        <!-- Standard Mesh Table -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Standard US Mesh Sizes</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Coarse</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-mesh="20">20 mesh</div>
                                    <div class="text-[11px] text-slate-500">841 μm</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Medium</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-mesh="50">50 mesh</div>
                                    <div class="text-[11px] text-slate-500">297 μm</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Fine</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-mesh="100">100 mesh</div>
                                    <div class="text-[11px] text-slate-500">149 μm</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Very Fine</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-mesh="325">325 mesh</div>
                                    <div class="text-[11px] text-slate-500">44 μm</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const meshInput = document.getElementById('mesh');
                        const modeRadios = document.getElementsByName('mode');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const formulaOutput = document.getElementById('formulaOutput');
                        const secondaryResult = document.getElementById('secondaryResult');
                        const resultDescription = document.getElementById('result-description');

                        // Standard mesh-to-micron lookup table (ASTM E11)
                        const meshToMicronTable = {
                            3: 6730, 4: 4760, 5: 4000, 6: 3360, 7: 2830, 8: 2380,
                            10: 2000, 12: 1680, 14: 1410, 16: 1190, 18: 1000, 20: 841,
                            25: 707, 30: 595, 35: 500, 40: 425, 45: 354, 50: 297,
                            60: 250, 70: 210, 80: 177, 100: 149, 120: 125, 140: 105,
                            170: 88, 200: 74, 230: 63, 270: 53, 325: 44, 400: 37
                        };

                        function getMode() {
                            return document.querySelector('input[name="mode"]:checked')?.value || 'standard';
                        }

                        function setMode(mode) {
                            modeRadios.forEach((radio) => {
                                radio.checked = radio.value === mode;
                            });
                        }

                        function cycleMode() {
                            const order = ['standard', 'formula', 'both'];
                            const currentIndex = order.indexOf(getMode());
                            const nextMode = order[(currentIndex + 1) % order.length];
                            setMode(nextMode);
                            convert();
                        }

                        function convert() {
                            const mesh = parseInt(meshInput.value);
                            const mode = getMode();
                            
                            if (!isNaN(mesh) && mesh > 0) {
                                const standardValue = meshToMicronTable[mesh];
                                const formulaValue = (14900 / mesh).toFixed(1);
                                
                                if (mode === 'standard') {
                                    if (standardValue) {
                                        output.textContent = standardValue.toLocaleString();
                                        resultDescription.textContent = 'ASTM E11 standard value';
                                    } else {
                                        output.textContent = parseFloat(formulaValue).toLocaleString(undefined, { maximumFractionDigits: 1 });
                                        resultDescription.textContent = 'Not in standard table, formula approximation';
                                    }
                                    secondaryResult.style.display = 'none';
                                } else if (mode === 'formula') {
                                    output.textContent = parseFloat(formulaValue).toLocaleString(undefined, { maximumFractionDigits: 1 });
                                    resultDescription.textContent = 'Formula-based approximation';
                                    secondaryResult.style.display = 'none';
                                } else { // both
                                    if (standardValue) {
                                        output.textContent = standardValue.toLocaleString();
                                        resultDescription.textContent = 'ASTM E11 standard value';
                                    } else {
                                        output.textContent = 'N/A';
                                        resultDescription.textContent = 'Not in standard table';
                                    }
                                    formulaOutput.textContent = parseFloat(formulaValue).toLocaleString(undefined, { maximumFractionDigits: 1 });
                                    secondaryResult.style.display = 'block';
                                }
                            } else {
                                output.textContent = "--";
                                formulaOutput.textContent = "--";
                                resultDescription.textContent = 'Particle size conversion';
                                secondaryResult.style.display = 'none';
                            }
                        }

                        function clearInput() {
                            meshInput.value = '';
                            convert();
                            meshInput.focus();
                        }

                        // Event listeners
                        meshInput.addEventListener('input', convert);
                        modeRadios.forEach((radio) => {
                            radio.addEventListener('change', convert);
                        });
                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example mesh sizes
                        const exampleMeshes = document.querySelectorAll('[data-mesh]');
                        exampleMeshes.forEach(element => {
                            element.addEventListener('click', function() {
                                const meshValue = this.getAttribute('data-mesh');
                                meshInput.value = meshValue;
                                convert();
                                meshInput.focus();
                            });
                        });

                        // Initialize
                        meshInput.focus();

                        // Add keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            } else if (e.ctrlKey && (e.key === 'm' || e.key === 'M')) {
                                e.preventDefault();
                                cycleMode();
                            }
                        });

                        // Input validation
                        meshInput.addEventListener('input', function() {
                            const value = parseInt(this.value);
                            if (value > 500) {
                                this.value = 500;
                            } else if (value < 0) {
                                this.value = '';
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
