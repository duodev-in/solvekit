<x-tool-page-layout
    title="Liters to Centiliters Converter - SolveKit"
    description="Professional liters to centiliters converter for metric volume conversions. Convert liters (L) to centiliters (cL) with precision for laboratory and culinary use."
>
    <x-slot name="toolUi">
        <!-- Calculator Card -->
                        <div class="space-y-2">
                            
                            <!-- Calculator Header -->
                            <div class="rounded-md bg-white p-2.5 shadow-sm">
                                <h1 class="text-sm font-semibold text-slate-900">Liters to Centiliters</h1>
                            </div>

                            <!-- Calculator Body -->
                            <div class="rounded-md bg-white p-3 shadow-sm">
                                
                                <div class="grid gap-3 lg:grid-cols-9">
                                    <div class="lg:col-span-5">
                                        <form class="space-y-3" id="calculatorForm">

                                                                            <!-- Input Value -->
                                                                            <div class="space-y-2">
                                                                                <label for="inputValue" class="block text-sm font-semibold text-slate-700" id="inputLabel">
                                                                                    Enter Volume in Liters
                                                                                </label>
                                                                                <div class="relative">
                                                                                    <input 
                                                                                        type="number" 
                                                                                        id="inputValue" 
                                                                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-slate-400 focus:ring-2 focus:ring-slate-200 transition-all duration-200 text-lg font-medium" 
                                                                                        placeholder="Enter volume (e.g., 2.5)"
                                                                                        step="any"
                                                                                        min="0"
                                                                                    >
                                                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                                                                        <span class="text-gray-500 text-sm font-medium" id="inputUnit">L</span>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="text-[11px] text-slate-500" id="conversionHint">1 liter = 100 centiliters</p>
                                                                            </div>

                                                                            <!-- Conversion Direction -->
                                                                            <div class="space-y-2">
                                                                                <label class="block text-sm font-semibold text-slate-700">
                                                                                    Conversion Direction
                                                                                </label>
                                                                                <div class="grid grid-cols-2 gap-3">
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="l-to-cl" class="text-indigo-600 focus:ring-slate-200" checked>
                                                                                        <span class="text-sm font-medium">Liters → Centiliters</span>
                                                                                    </label>
                                                                                    <label class="flex items-center space-x-2 p-3 border-2 border-gray-200 rounded-lg hover:border-indigo-300 transition-colors cursor-pointer">
                                                                                        <input type="radio" name="direction" value="cl-to-l" class="text-indigo-600 focus:ring-slate-200">
                                                                                        <span class="text-sm font-medium">Centiliters → Liters</span>
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
                                                                                        <h4 class="text-xs font-semibold text-slate-900" id="result-title">Volume in Centiliters</h4>
                                                                                        <p class="text-[11px] text-slate-500" id="result-description">Metric volume measurement</p>
                                                                                    </div>
                                                                                    <div class="text-right">
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="output">--</div>
                                                                                        <div class="text-xs text-slate-500 font-medium" id="unit-display">cL</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Complete Metric Volume Conversions -->
                                                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Milliliters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="mlOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Deciliters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="dlOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                    <div class="text-center">
                                                                                        <h4 class="text-xs font-semibold text-slate-900">Kiloliters</h4>
                                                                                        <div class="font-serif text-3xl font-bold leading-none text-indigo-700" id="klOutput">--</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Step-by-Step Conversion -->
                                                                            <div class="rounded-md border border-slate-200 bg-slate-50 p-2.5">
                                                                                <h4 class="text-sm font-semibold text-slate-700 mb-2 text-center">Step-by-Step Conversion</h4>
                                                                                <div class="text-center text-[11px] text-slate-500" id="stepByStep">
                                                                                    Enter a value to see the conversion steps
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    

        <div class="mt-6 space-y-4">
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="p-4 bg-indigo-50 rounded-lg border border-indigo-200">
                        <h4 class="text-sm font-semibold text-indigo-800 mb-2">Metric Volume Hierarchy</h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs text-indigo-700">
                            <div class="text-center p-2 bg-white rounded">
                                <div class="font-semibold">kL</div>
                                <div>Kiloliter</div>
                                <div class="text-indigo-600">1000 L</div>
                            </div>
                            <div class="text-center p-2 bg-white rounded border-2 border-indigo-300">
                                <div class="font-semibold">L</div>
                                <div>Liter</div>
                                <div class="text-indigo-600">Base unit</div>
                            </div>
                            <div class="text-center p-2 bg-white rounded border-2 border-indigo-300">
                                <div class="font-semibold">cL</div>
                                <div>Centiliter</div>
                                <div class="text-indigo-600">0.01 L</div>
                            </div>
                            <div class="text-center p-2 bg-white rounded">
                                <div class="font-semibold">mL</div>
                                <div>Milliliter</div>
                                <div class="text-indigo-600">0.001 L</div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Volume Presets -->
                                                    <div class="space-y-2">
                                                        <label class="block text-sm font-semibold text-slate-700">
                                                            Quick Volume Presets
                                                        </label>
                                                        <div class="grid grid-cols-4 gap-2">
                                                            <button type="button" class="volume-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="0.1" data-direction="l-to-cl">0.1 L</button>
                                                            <button type="button" class="volume-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="0.5" data-direction="l-to-cl">0.5 L</button>
                                                            <button type="button" class="volume-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="1" data-direction="l-to-cl">1 L</button>
                                                            <button type="button" class="volume-preset px-3 py-2 text-sm bg-gray-100 hover:bg-indigo-100 text-slate-700 hover:text-indigo-700 rounded-lg transition-colors" data-value="2" data-direction="l-to-cl">2 L</button>
                                                        </div>
                                                    </div>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <!-- Quick Reference -->
                                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                                    <h4 class="text-sm font-semibold text-slate-700 mb-2">Metric Volume Reference</h4>
                                                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">
                                                        <div>• 1 L = 100 cL</div>
                                                        <div>• 1 L = 1000 mL</div>
                                                        <div>• 1 cL = 10 mL</div>
                                                        <div>• 1 kL = 1000 L</div>
                                                    </div>
                                                </div>
            </div>
        </div>
</x-slot>

    <x-slot name="aboutContent">
        <!-- Additional Information -->
                        <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">About Liters to Centiliters Conversion</h3>
                            <div class="grid md:grid-cols-2 gap-6 text-[11px] text-slate-500">
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Metric System Advantages</h4>
                                    <p>The metric system uses base-10 conversions, making calculations simple and intuitive. Converting between liters and centiliters is straightforward: multiply by 100 to go from L to cL, divide by 100 to go from cL to L.</p>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-slate-700 mb-2">Practical Applications</h4>
                                    <p>Centiliters are commonly used in cooking (especially in European recipes), beverage labeling, laboratory measurements, and pharmaceutical dosing where precision is important.</p>
                                </div>
                            </div>
                            <div class="mt-4 rounded-md bg-indigo-50 p-3 text-xs text-indigo-800">
                                <p class="text-sm text-indigo-800">
                                    <strong>Metric Tip:</strong> The metric system's decimal nature makes mental conversions easy - just move the decimal point!
                                </p>
                            </div>
                        </div>

                        <!-- Common Volume Examples -->
                        <div class="rounded-xl border border-slate-200 bg-white p-3">
                            <h3 class="text-lg font-semibold text-slate-900 mb-4">Common Volume Examples</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Small Bottle</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="0.33">0.33 L</div>
                                    <div class="text-[11px] text-slate-500">33 cL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Wine Bottle</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="0.75">0.75 L</div>
                                    <div class="text-[11px] text-slate-500">75 cL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Water Bottle</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="1.5">1.5 L</div>
                                    <div class="text-[11px] text-slate-500">150 cL</div>
                                </div>
                                <div class="text-center p-3 bg-slate-50 rounded-md">
                                    <div class="font-semibold text-slate-700">Large Bottle</div>
                                    <div class="text-indigo-700 cursor-pointer hover:text-indigo-800 transition-colors" data-volume="2">2 L</div>
                                    <div class="text-[11px] text-slate-500">200 cL</div>
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
                        const clearButton = document.getElementById('clearButton');
                        const output = document.getElementById('output');
                        const unitDisplay = document.getElementById('unit-display');
                        const resultTitle = document.getElementById('result-title');
                        const resultDescription = document.getElementById('result-description');
                        const mlOutput = document.getElementById('mlOutput');
                        const dlOutput = document.getElementById('dlOutput');
                        const klOutput = document.getElementById('klOutput');
                        const stepByStep = document.getElementById('stepByStep');

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

                        function convert() {
                            const value = parseFloat(inputValue.value);
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (!isNaN(value) && value >= 0) {
                                let liters, centiliters;

                                if (direction === 'l-to-cl') {
                                    liters = value;
                                    centiliters = value * 100;
                                    
                                    resultTitle.textContent = 'Volume in Centiliters';
                                    resultDescription.textContent = 'Metric volume measurement';
                                    output.textContent = formatNumber(centiliters);
                                    unitDisplay.textContent = 'cL';
                                    
                                    stepByStep.innerHTML = `
                                        <div class="font-mono text-indigo-700">
                                            ${formatNumber(liters)} L × 100 = ${formatNumber(centiliters)} cL
                                        </div>
                                        <div class="text-xs mt-1">
                                            To convert liters to centiliters, multiply by 100
                                        </div>
                                    `;
                                } else {
                                    centiliters = value;
                                    liters = value / 100;
                                    
                                    resultTitle.textContent = 'Volume in Liters';
                                    resultDescription.textContent = 'Metric volume measurement';
                                    output.textContent = formatNumber(liters);
                                    unitDisplay.textContent = 'L';
                                    
                                    stepByStep.innerHTML = `
                                        <div class="font-mono text-indigo-700">
                                            ${formatNumber(centiliters)} cL ÷ 100 = ${formatNumber(liters)} L
                                        </div>
                                        <div class="text-xs mt-1">
                                            To convert centiliters to liters, divide by 100
                                        </div>
                                    `;
                                }

                                // Calculate all metric conversions based on liters
                                const milliliters = liters * 1000;
                                const deciliters = liters * 10;
                                const kiloliters = liters / 1000;

                                mlOutput.textContent = formatNumber(milliliters) + ' mL';
                                dlOutput.textContent = formatNumber(deciliters) + ' dL';
                                klOutput.textContent = formatNumber(kiloliters) + ' kL';
                            } else {
                                output.textContent = "--";
                                mlOutput.textContent = "--";
                                dlOutput.textContent = "--";
                                klOutput.textContent = "--";
                                stepByStep.textContent = "Enter a value to see the conversion steps";
                            }
                        }

                        function updateLabels() {
                            const direction = document.querySelector('input[name="direction"]:checked').value;

                            if (direction === 'l-to-cl') {
                                inputLabel.textContent = 'Enter Volume in Liters';
                                inputValue.placeholder = 'Enter volume (e.g., 2.5)';
                                inputUnit.textContent = 'L';
                                conversionHint.textContent = '1 liter = 100 centiliters';
                            } else {
                                inputLabel.textContent = 'Enter Volume in Centiliters';
                                inputValue.placeholder = 'Enter volume (e.g., 250)';
                                inputUnit.textContent = 'cL';
                                conversionHint.textContent = '100 centiliters = 1 liter';
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

                        clearButton.addEventListener('click', clearInput);

                        // Volume preset buttons
                        const volumePresets = document.querySelectorAll('.volume-preset');
                        volumePresets.forEach(button => {
                            button.addEventListener('click', function() {
                                const value = this.getAttribute('data-value');
                                const direction = this.getAttribute('data-direction');
                                
                                // Set direction
                                document.querySelector(`input[value="${direction}"]`).checked = true;
                                updateLabels();
                                
                                inputValue.value = value;
                                convert();
                                
                                // Update button styles
                                volumePresets.forEach(btn => btn.classList.remove('bg-indigo-100', 'text-indigo-700'));
                                volumePresets.forEach(btn => btn.classList.add('bg-gray-100', 'text-slate-700'));
                                this.classList.remove('bg-gray-100', 'text-slate-700');
                                this.classList.add('bg-indigo-100', 'text-indigo-700');
                            });
                        });

                        // Add clickable functionality to example volumes
                        const exampleVolumes = document.querySelectorAll('[data-volume]');
                        exampleVolumes.forEach(element => {
                            element.addEventListener('click', function() {
                                const volumeValue = this.getAttribute('data-volume');
                                
                                // Set to l-to-cl mode
                                document.querySelector('input[value="l-to-cl"]').checked = true;
                                updateLabels();
                                
                                inputValue.value = volumeValue;
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
                                const newDirection = currentDirection === 'l-to-cl' ? 'cl-to-l' : 'l-to-cl';
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
