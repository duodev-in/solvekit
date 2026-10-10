<x-tool-page-layout
    title="Grams to Ounces Converter - SolveKit"
    description="Professional grams to ounces converter for metric to imperial weight conversions. Convert grams (g) to ounces (oz) with precision for cooking and measurements."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Grams to Ounces</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700" id="inputLabel">
                                                                                    Enter Weight in Grams
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter weight (e.g., 100)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">g</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500" id="conversionHint">1 ounce = 28.3495 grams</p>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="g-to-oz" class="text-rose-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Grams → Ounces</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="oz-to-g" class="text-rose-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Ounces → Grams</span>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Ounce Type Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Ounce Type
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="ounceType" value="weight" class="text-rose-600 focus:ring-slate-200" checked>
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Weight Ounce</span>
                                                                                            <div class="text-[11px] text-slate-500">Dry ingredients</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-rose-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="ounceType" value="fluid" class="text-rose-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Fluid Ounce</span>
                                                                                            <div class="text-[11px] text-slate-500">Liquids (water)</div>
                                                                                        </div>
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
                                        <!-- Results Display -->
                                                                        <div class="mt-8 space-y-4">
                                                                            <h3 class="text-lg font-semibold text-slate-900 text-center mb-4">Converted Values</h3>

                                                                            <!-- Primary Result -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <div class="flex items-center justify-between">
                                                                                    <div>
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Weight in Ounces</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Imperial weight measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">oz</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Pounds</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="poundsOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kilograms</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="kgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Milligrams</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mgOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Weight Presets -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-slate-700">
                                                            Quick Weight Presets
                                                        </label>
                                                        <div class="grid grid-cols-4 gap-2">
                                                            <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-slate-700 hover:text-rose-700 rounded-lg transition-colors" data-value="28.35" data-direction="g-to-oz">1 oz</button>
                                                            <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-slate-700 hover:text-rose-700 rounded-lg transition-colors" data-value="100" data-direction="g-to-oz">100g</button>
                                                            <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-slate-700 hover:text-rose-700 rounded-lg transition-colors" data-value="454" data-direction="g-to-oz">1 lb</button>
                                                            <button type="button" class="weight-preset px-3 py-2 text-sm bg-gray-100 hover:bg-rose-100 text-slate-700 hover:text-rose-700 rounded-lg transition-colors" data-value="1000" data-direction="g-to-oz">1 kg</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Weight Conversion Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 oz = 28.3495 g</div>
                                                        <div>• 1 lb = 453.592 g</div>
                                                        <div>• 1 kg = 35.274 oz</div>
                                                        <div>• 1 fl oz (water) = 29.5735 g</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Grams to Ounces Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Weight vs Fluid Ounces</h4>
                                    <p>Weight ounces (oz) measure mass and are used for dry ingredients. Fluid ounces (fl oz) measure volume for liquids. They are different units despite the similar name.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Cooking Applications</h4>
                                    <p>Essential for recipe conversions between metric and imperial systems, portion control, and international cooking where ingredient measurements may be given in different units.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Cooking Tip:</strong> When converting recipes, always check whether the original uses weight or volume measurements for best accuracy!
                                </p>
                            </div>
                        </div>

                        <!-- Common Weight Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Weight Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Coin (Quarter)</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="5.67">5.67 g</div>
                                    <div class="text-[11px] text-slate-500">~0.2 oz</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Letter</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="4.5">4.5 g</div>
                                    <div class="text-[11px] text-slate-500">~0.16 oz</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Sugar Packet</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="4">4 g</div>
                                    <div class="text-[11px] text-slate-500">~0.14 oz</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Smartphone</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-weight="150">150 g</div>
                                    <div class="text-[11px] text-slate-500">~5.29 oz</div>
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
                        const ounceTypeRadios = document.getElementsByName('ounceType');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const poundsOutput = document.getElementById('poundsOutput');
                        const kgOutput = document.getElementById('kgOutput');
                        const mgOutput = document.getElementById('mgOutput');

                        // Conversion constants
                        const GRAM_TO_OZ = 0.035274;
                        const GRAM_TO_FLUID_OZ = 0.033814; // For water at room temperature

                        function formatNumber(num) {
                            if (num >= 1000000) {
                                return Number(num.toPrecision(5)).toExponential();
                            } else if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 4 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 6 });
                            }
                        }

                        function getConversionRate() {
                            const ounceType = document.querySelector('input[name="ounceType"]:checked').value;
                            return ounceType === 'weight' ? GRAM_TO_OZ : GRAM_TO_FLUID_OZ;
                        }

                        function convert() {
                            const value = parseFloat(inputValue.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const conversionRate = getConversionRate();

                            if (!isNaN(value) && value >= 0) {
                                let grams, ounces;

                                if (direction === 'g-to-oz') {
                                    grams = value;
                                    ounces = value * conversionRate;
                                    const ounceType = document.querySelector('input[name="ounceType"]:checked').value;
                                    const ounceUnit = ounceType === 'weight' ? 'oz' : 'fl oz';
                                    
                                    resultTitle.textContent = `Weight in ${ounceType === 'weight' ? 'Ounces' : 'Fluid Ounces'}`;
                                    resultDescription.textContent = `${ounceType === 'weight' ? 'Imperial weight' : 'Volume'} measurement`;
                                    output.textContent = formatNumber(ounces);
                                    unitDisplay.textContent = ounceUnit;
                                } else {
                                    ounces = value;
                                    grams = value / conversionRate;
                                    resultTitle.textContent = 'Weight in Grams';
                                    resultDescription.textContent = 'Metric weight measurement';
                                    output.textContent = formatNumber(grams);
                                    unitDisplay.textContent = 'g';
                                }

                                // Additional conversions (always based on grams)
                                const pounds = grams * 0.00220462;
                                const kg = grams / 1000;
                                const mg = grams * 1000;

                                poundsOutput.textContent = formatNumber(pounds) + ' lb';
                                kgOutput.textContent = formatNumber(kg) + ' kg';
                                mgOutput.textContent = formatNumber(mg) + ' mg';
                            } else {
                                output.textContent = "--";
                                poundsOutput.textContent = "--";
                                kgOutput.textContent = "--";
                                mgOutput.textContent = "--";
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const ounceType = document.querySelector('input[name="ounceType"]:checked').value;

                            if (direction === 'g-to-oz') {
                                inputLabel.textContent = 'Enter Weight in Grams';
                                inputValue.placeholder = 'Enter weight (e.g., 100)';
                                inputUnit.textContent = 'g';
                                
                                if (ounceType === 'weight') {
                                    conversionHint.textContent = '1 ounce = 28.3495 grams';
                                } else {
                                    conversionHint.textContent = '1 fl oz (water) = 29.5735 grams';
                                }
                            } else {
                                const ounceTypeText = ounceType === 'weight' ? 'Ounces' : 'Fluid Ounces';
                                const unitText = ounceType === 'weight' ? 'oz' : 'fl oz';
                                
                                inputLabel.textContent = `Enter Weight in ${ounceTypeText}`;
                                inputValue.placeholder = `Enter ${ounceTypeText.toLowerCase()} (e.g., 3.5)`;
                                inputUnit.textContent = unitText;
                                
                                if (ounceType === 'weight') {
                                    conversionHint.textContent = '1 ounce = 28.3495 grams';
                                } else {
                                    conversionHint.textContent = '1 fl oz (water) = 29.5735 grams';
                                }
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

                        ounceTypeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
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
                                weightPresets.forEach(btn => btn.classList.remove('bg-rose-100', 'text-rose-700'));
                                weightPresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-rose-100', 'text-rose-700');
                            });
                        });

                        // Add clickable functionality to example weights
                        const exampleWeights = document.querySelectorAll('[data-weight]');
                        exampleWeights.forEach(element => {
                            element.addEventListener('click', function() {
                                const weightValue = this.getAttribute('data-weight');
                                
                                // Set to g-to-oz mode
                                document.querySelector('input[value="g-to-oz"]').checked = true;
                                document.querySelector('input[value="weight"]').checked = true;
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
                                const newDirection = currentDirection === 'g-to-oz' ? 'oz-to-g' : 'g-to-oz';
                                document.querySelector(`input[value="${newDirection}"]`).checked = true;
                                updateLabels();
                                convert();
                            } else if (e.ctrlKey && e.key === 't') {
                                e.preventDefault();
                                // Toggle ounce type
                                const currentType = document.querySelector('input[name="ounceType"]:checked').value;
                                const newType = currentType === 'weight' ? 'fluid' : 'weight';
                                document.querySelector(`input[value="${newType}"]`).checked = true;
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
