<x-tool-page-layout
    title="Micrograms to Milligrams Converter - SolveKit"
    description="Professional micrograms to milligrams converter for precise weight conversions. Convert mcg to mg with high precision for various applications."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">mcg to mg</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700" id="inputLabel">
                                                                                    Enter Weight in Micrograms
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter weight (e.g., 5000)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">mcg</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500" id="conversionHint">1 milligram = 1000 micrograms</p>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="mcg-to-mg" class="text-pink-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">mcg → mg</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="mg-to-mcg" class="text-pink-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">mg → mcg</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Precision Level -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Precision Level
                                                                                </label>
                                                                                <div class="grid grid-cols-3 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="3" class="text-pink-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-xs font-medium">3 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="6" class="text-pink-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">6 decimals</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-2 border border-gray-200 rounded-lg hover:border-pink-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="precision" value="9" class="text-pink-600 focus:ring-slate-200">
                                                                                        <span class="text-xs font-medium">9 decimals</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Common Weight Presets -->
                                                                            

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
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Weight in Milligrams</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Metric weight measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">mg</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Weight Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Grams</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="gramsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Nanograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="nanogramsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kilograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="kilogramsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Step-by-Step Calculation -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-2 text-center">Step-by-Step Calculation</h4>
                                                                                <div class="text-center text-[11px] text-slate-500 font-mono" id="stepByStep">
                                                                                    Enter a value to see the calculation steps
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <div class="space-y-2">
                                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                                    Common Weight Values
                                                                                                </label>
                                                                                                <div class="grid grid-cols-4 gap-2">
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-slate-700 hover:text-pink-700 rounded-lg transition-colors" data-value="100" data-direction="mcg-to-mg">100 mcg</button>
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-slate-700 hover:text-pink-700 rounded-lg transition-colors" data-value="500" data-direction="mcg-to-mg">500 mcg</button>
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-slate-700 hover:text-pink-700 rounded-lg transition-colors" data-value="1000" data-direction="mcg-to-mg">1000 mcg</button>
                                                                                                    <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-pink-100 text-slate-700 hover:text-pink-700 rounded-lg transition-colors" data-value="5000" data-direction="mcg-to-mg">5000 mcg</button>
                                                                                                </div>
                                                                                            </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Weight Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 mg = 1000 mcg</div>
                                                        <div>• 1 g = 1,000,000 mcg</div>
                                                        <div>• 1 mcg = 1000 ng</div>
                                                        <div>• 1 kg = 1,000,000,000 mcg</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Micrograms to Milligrams Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Precision Matters</h4>
                                    <p>Converting between micrograms and milligrams requires precision as these are very small units. This converter offers multiple decimal precision levels to meet various accuracy requirements.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Common Applications</h4>
                                    <p>Used in laboratories, manufacturing, quality control, research, and any application requiring precise measurement of very small quantities where accuracy is essential.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Precision Note:</strong> Choose the appropriate decimal precision based on your accuracy requirements!
                                </p>
                            </div>
                        </div>

                        <!-- Common Weight Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Small Weight Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Dust Particle</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="50">50 mcg</div>
                                    <div class="text-[11px] text-slate-500">0.05 mg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Seed</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="200">200 mcg</div>
                                    <div class="text-[11px] text-slate-500">0.2 mg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Tiny Crystal</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="750">750 mcg</div>
                                    <div class="text-[11px] text-slate-500">0.75 mg</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Fine Powder</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="2000">2000 mcg</div>
                                    <div class="text-[11px] text-slate-500">2 mg</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const inputValue = document.getElementById('inputValue');
                        const inputLabel = document.getElementById('inputLabel');
                        const inputUnit = document.getElementById('inputUnit');
                        const conversionHint = document.getElementById('conversionHint');
                        const directionRadios = document.getElementsByName('direction');
                        const precisionRadios = document.getElementsByName('precision');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const gramsOutput = document.getElementById('gramsOutput');
                        const nanogramsOutput = document.getElementById('nanogramsOutput');
                        const kilogramsOutput = document.getElementById('kilogramsOutput');
                        const stepByStep = document.getElementById('stepByStep');

                        function getPrecision() {
                            return parseInt(document.querySelector('input[name="precision"]:checked').value);
                        }

                        function formatNumber(num, precision = null) {
                            const decimals = precision || getPrecision();
                            if (num >= 1000000) {
                                return Number(num.toPrecision(decimals + 1)).toExponential();
                            }

                            const rounded = parseFloat(num.toFixed(decimals));

                            if (num !== 0 && rounded === 0) {
                                return Math.abs(num) < 0.000001
                                    ? Number(num.toPrecision(4)).toExponential()
                                    : num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }

                            return rounded.toLocaleString(undefined, { maximumFractionDigits: decimals });
                        }

                        function convert() {
                            const value = parseFloat(inputValue.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (!isNaN(value) && value >= 0) {
                                let mcg, mg;

                                if (direction === 'mcg-to-mg') {
                                    mcg = value;
                                    mg = value / 1000;
                                    
                                    resultTitle.textContent = 'Weight in Milligrams';
                                    resultDescription.textContent = 'Metric weight measurement';
                                    output.textContent = formatNumber(mg);
                                    unitDisplay.textContent = 'mg';
                                    
                                    stepByStep.textContent = `${formatNumber(mcg)} mcg ÷ 1000 = ${formatNumber(mg)} mg`;
                                } else {
                                    mg = value;
                                    mcg = value * 1000;
                                    
                                    resultTitle.textContent = 'Weight in Micrograms';
                                    resultDescription.textContent = 'Metric weight measurement';
                                    output.textContent = formatNumber(mcg);
                                    unitDisplay.textContent = 'mcg';
                                    
                                    stepByStep.textContent = `${formatNumber(mg)} mg × 1000 = ${formatNumber(mcg)} mcg`;
                                }

                                // Additional conversions (always based on mcg)
                                const grams = mcg / 1000000;
                                const nanograms = mcg * 1000;
                                const kilograms = mcg / 1000000000;

                                gramsOutput.textContent = formatNumber(grams) + ' g';
                                nanogramsOutput.textContent = formatNumber(nanograms) + ' ng';
                                kilogramsOutput.textContent = formatNumber(kilograms, 9) + ' kg';
                            } else {
                                output.textContent = "--";
                                gramsOutput.textContent = "--";
                                nanogramsOutput.textContent = "--";
                                kilogramsOutput.textContent = "--";
                                stepByStep.textContent = "Enter a value to see the calculation steps";
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (direction === 'mcg-to-mg') {
                                inputLabel.textContent = 'Enter Weight in Micrograms';
                                inputValue.placeholder = 'Enter weight (e.g., 5000)';
                                inputUnit.textContent = 'mcg';
                                conversionHint.textContent = '1 milligram = 1000 micrograms';
                            } else {
                                inputLabel.textContent = 'Enter Weight in Milligrams';
                                inputValue.placeholder = 'Enter weight (e.g., 5)';
                                inputUnit.textContent = 'mg';
                                conversionHint.textContent = '1 milligram = 1000 micrograms';
                            }
                        }

                        function clearInput() {
                            inputValue.value = '';
                            convert();
                            inputValue.focus();
                        }

                        // Event listeners
                        inputValue.addEventListener('input', convert);
                        
                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });

                        precisionRadios.forEach(radio => {
                            radio.addEventListener('change', convert);
                        });

                        clearButton.addEventListener('click', clearInput);

                        // Weight preset buttons
                        const weightPresets = document.querySelectorAll('.weight-preset');
                        weightPresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const direction = this.getAttribute('data-direction');
                                
                                // Set direction
                                document.querySelector(`input[value="${direction}"]`).checked = true;
                                updateLabels();
                                
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                weightPresets.forEach(btn => btn.classList.remove('bg-pink-100', 'text-pink-700'));
                                weightPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-pink-100', 'text-pink-700');
                            });
                        });

                        // Add clickable functionality to example weights
                        const exampleWeights = document.querySelectorAll('[data-weight]');
                        exampleWeights.forEach(element => {
                            element.addEventListener('click', function() {
                                const weightValue = this.getAttribute('data-weight');
                                
                                // Set to mcg-to-mg mode
                                document.querySelector('input[value="mcg-to-mg"]').checked = true;
                                updateLabels();
                                
                                inputValue.value = weightValue;
                                convert();
                                inputValue.focus();
                            });
                        });

                        // Initialize
                        inputValue.focus();
                        updateLabels();

                        // Keyboard shortcuts
                        document.addEventListener('keydown', function(e) {
                            if (e.key === 'Escape' || (e.ctrlKey && e.shiftKey && (e.key === 'C' || e.key === 'c'))) {
                                if (e.ctrlKey && e.shiftKey) {
                                    e.preventDefault();
                                }
                                clearInput();
                            } else if (e.ctrlKey && (e.key || '').toLowerCase() === 'm') {
                                e.preventDefault();
                                // Toggle direction
                                const currentDirection = document.querySelector('input[name="direction"]:checked').value;
                                const newDirection = currentDirection === 'mcg-to-mg' ? 'mg-to-mcg' : 'mcg-to-mg';
                                document.querySelector(`input[value="${newDirection}"]`).checked = true;
                                updateLabels();
                                convert();
                            }
                        });

                        // Initialize conversion
                        convert();
                    });
                </script>
    </x-slot>
</x-tool-page-layout>
