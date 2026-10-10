<x-tool-page-layout
    title="Drops to mL Converter - ConvertPro"
    description="Professional drops to milliliters converter for medical dosages and small volume measurements. Convert drops to mL with precision."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Drops to mL</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="drops" class="block text-sm font-semibold text-slate-700">
                                                                                    Enter Number of Drops
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="drops" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter drops (e.g., 20)"
                                                                                        step="1"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">drops</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500">Standard: 1 drop ≈ 0.05 mL</p>
                                                                            </div>

                                                                            <!-- Drop Size Selection -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Drop Size Standard
                                                                                </label>
                                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="dropSize" value="0.05" class="text-teal-600 focus:ring-slate-200" checked>
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Standard Medical</span>
                                                                                            <div class="text-[11px] text-slate-500">0.05 mL per drop</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="dropSize" value="0.067" class="text-teal-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Imperial Standard</span>
                                                                                            <div class="text-[11px] text-slate-500">0.067 mL per drop</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="dropSize" value="0.1" class="text-teal-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Large Drop</span>
                                                                                            <div class="text-[11px] text-slate-500">0.1 mL per drop</div>
                                                                                        </div>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-3 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="dropSize" value="custom" class="text-teal-600 focus:ring-slate-200">
                                                                                        <div>
                                                                                            <span class="text-sm font-medium">Custom Size</span>
                                                                                            <div class="text-[11px] text-slate-500">Enter custom value</div>
                                                                                        </div>
                                                                                    </label>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Custom Drop Size -->
                                                                            <div class="space-y-2" id="customDropSizeField" style="display: none;">
                                                                                <label for="customDropSize" class="block text-sm font-semibold text-slate-700">
                                                                                    Custom Drop Size
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="customDropSize" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter drop size"
                                                                                        step="0.001"
                                                                                        min="0.001"
                                                                                        max="1"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium">mL/drop</span>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="drops-to-ml" class="text-teal-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Drops → mL</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-teal-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="ml-to-drops" class="text-teal-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">mL → Drops</span>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Volume in Milliliters</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Precise volume measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">mL</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Additional Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Liters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="litersOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Fluid Ounces</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="flOzOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Teaspoons</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="tspOutput">--</div>
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
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Drop Size Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• Medical standard: 0.05 mL</div>
                                                        <div>• Imperial standard: 0.067 mL</div>
                                                        <div>• 20 drops ≈ 1 mL (medical)</div>
                                                        <div>• 15 drops ≈ 1 mL (imperial)</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Drops to mL Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Medical Applications</h4>
                                    <p>Essential for precise medication dosing, eye drops, ear drops, and other medical treatments where small, accurate volumes are critical for patient safety and treatment effectiveness.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Variable Drop Sizes</h4>
                                    <p>Drop size varies based on liquid properties (viscosity, surface tension), dropper design, and dispensing technique. Always verify with specific medical instructions.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Medical Warning:</strong> Always follow your healthcare provider's specific instructions for medication dosing. This calculator is for reference only!
                                </p>
                            </div>
                        </div>

                        <!-- Common Drop Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Drop Measurements</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Eye Drops</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-drops="1">1-2 drops</div>
                                    <div class="text-[11px] text-slate-500">~0.05-0.1 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Dose</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-drops="5">5 drops</div>
                                    <div class="text-[11px] text-slate-500">~0.25 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Medium Dose</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-drops="20">20 drops</div>
                                    <div class="text-[11px] text-slate-500">~1 mL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Larger Dose</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-drops="40">40 drops</div>
                                    <div class="text-[11px] text-slate-500">~2 mL</div>
                                </div>
                            </div>
                        </div>
    </x-slot>

    <x-slot name="scripts">
        <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dropsInput = document.getElementById('drops');
                        const dropSizeRadios = document.getElementsByName('dropSize');
                        const customDropSizeField = document.getElementById('customDropSizeField');
                        const customDropSize = document.getElementById('customDropSize');
                        const directionRadios = document.getElementsByName('direction');
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const litersOutput = document.getElementById('litersOutput');
                        const flOzOutput = document.getElementById('flOzOutput');
                        const tspOutput = document.getElementById('tspOutput');

                        function formatNumber(num) {
                            if (num >= 1000) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 2 });
                            } else if (num >= 1) {
                                return num.toLocaleString(undefined, { maximumFractionDigits: 3 });
                            } else if (num !== 0 && Math.abs(num) < 0.000001) {
                                return Number(num.toPrecision(4)).toExponential();
                            } else {
                                return num.toLocaleString(undefined, { maximumSignificantDigits: 4 });
                            }
                        }

                        function getDropSize() {
                            const selectedSize = document.querySelector('input[name="dropSize"]:checked').value;
                            if (selectedSize === 'custom') {
                                return parseFloat(customDropSize.value) || 0.05;
                            }
                            return parseFloat(selectedSize);
                        }

                        function convert() {
                            const value = parseFloat(dropsInput.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const dropSizeValue = getDropSize();

                            if (!isNaN(value) && value >= 0) {
                                let ml, drops;

                                if (direction === 'drops-to-ml') {
                                    drops = value;
                                    ml = value * dropSizeValue;
                                    resultTitle.textContent = 'Volume in Milliliters';
                                    resultDescription.textContent = 'Drops to milliliters conversion';
                                    output.textContent = formatNumber(ml);
                                    unitDisplay.textContent = 'mL';
                                } else {
                                    ml = value;
                                    drops = value / dropSizeValue;
                                    resultTitle.textContent = 'Number of Drops';
                                    resultDescription.textContent = 'Milliliters to drops conversion';
                                    output.textContent = formatNumber(drops);
                                    unitDisplay.textContent = 'drops';
                                }

                                // Additional conversions (always from ml)
                                const liters = ml / 1000;
                                const flOz = ml * 0.033814;
                                const tsp = ml * 0.202884;

                                litersOutput.textContent = formatNumber(liters) + ' L';
                                flOzOutput.textContent = formatNumber(flOz) + ' fl oz';
                                tspOutput.textContent = formatNumber(tsp) + ' tsp';
                            } else {
                                output.textContent = "--";
                                litersOutput.textContent = "--";
                                flOzOutput.textContent = "--";
                                tspOutput.textContent = "--";
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;
                            const inputLabel = document.querySelector('label[for="drops"]');

                            if (direction === 'drops-to-ml') {
                                inputLabel.textContent = 'Enter Number of Drops';
                                dropsInput.placeholder = 'Enter drops (e.g., 20)';
                                document.querySelector('.absolute span').textContent = 'drops';
                            } else {
                                inputLabel.textContent = 'Enter Volume in mL';
                                dropsInput.placeholder = 'Enter mL (e.g., 1.0)';
                                document.querySelector('.absolute span').textContent = 'mL';
                            }
                        }

                        function toggleCustomField() {
                            const selectedSize = document.querySelector('input[name="dropSize"]:checked').value;
                            if (selectedSize === 'custom') {
                                customDropSizeField.style.display = 'block';
                            } else {
                                customDropSizeField.style.display = 'none';
                            }
                        }

                        function clearInput() {
                            dropsInput.value = '';
                            customDropSize.value = '';
                            convert();
                            dropsInput.focus();
                        }

                        // Event listeners
                        dropsInput.addEventListener('input', convert);
                        
                        dropSizeRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                toggleCustomField();
                                convert();
                            });
                        });

                        customDropSize.addEventListener('input', convert);

                        directionRadios.forEach(radio => {
                            radio.addEventListener('change', () => {
                                updateLabels();
                                convert();
                            });
                        });

                        clearButton.addEventListener('click', clearInput);

                        // Add clickable functionality to example drops
                        const exampleDrops = document.querySelectorAll('[data-drops]');
                        exampleDrops.forEach(element => {
                            element.addEventListener('click', function() {
                                const dropsValue = this.getAttribute('data-drops');
                                
                                // Set to drops-to-ml mode
                                document.querySelector('input[value="drops-to-ml"]').checked = true;
                                updateLabels();
                                
                                dropsInput.value = dropsValue;
                                convert();
                                dropsInput.focus();
                            });
                        });

                        // Initialize
                        dropsInput.focus();
                        updateLabels();
                        toggleCustomField();

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
                                const newDirection = currentDirection === 'drops-to-ml' ? 'ml-to-drops' : 'drops-to-ml';
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
